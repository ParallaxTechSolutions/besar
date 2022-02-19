import sys, traceback
from scrapy.http import Request
from scrapy.selector import Selector
from scrapy.linkextractors import LinkExtractor
from scrapy.spiders import CrawlSpider, Rule
from hotel_bookingdetails.items import HotelBookingdetailsItem
from scrapy.http.cookies import CookieJar
from bs4 import BeautifulSoup
from selenium import webdriver
from urlparse import urljoin
from urlparse import urlparse, parse_qs
import urllib
import datetime
import MySQLdb
import MySQLdb.cursors
import time
import json
import random
import subprocess
import re

geckodriver = '..\..\..\..\geckodriver'
options = webdriver.FirefoxOptions()
options.add_argument('-headless')

SQL_DB = ""
SQL_HOST = 'localhost'
SQL_USER = ""
SQL_PASSWD = ""

proc = subprocess.Popen("php /resultjson.php", shell=True, stdout=subprocess.PIPE)
jsonS = proc.stdout.read().splitlines()
for index,val in enumerate(jsonS):
	if "database" in val:
		 SQL_DB = re.search('"(.*)"', jsonS[index+1]).group(1)
		 print SQL_DB
	if "username" in val:
		 SQL_USER = re.search('"(.*)"', jsonS[index+1]).group(1)
		 print SQL_USER
	if "password" in val:
		 SQL_PASSWD = re.search('"(.*)"', jsonS[index+1]).group(1)
		 print SQL_PASSWD


class HotelBookingsSpider(CrawlSpider):
	name = 'hotelbookinglists'
	base_url = 'https://www.google.com'
	allowed_domains = ['www.google.com']
	start_urls = []
	CONN = MySQLdb.connect(host=SQL_HOST, user=SQL_USER, passwd=SQL_PASSWD, db=SQL_DB, charset='utf8')
	CURSOR = CONN.cursor()
	CURSOR.execute("""SELECT name FROM hotelname""")
	if CURSOR.rowcount > 0:
		result = CURSOR.fetchall()
		hoteldata = [row[0] for row in result]
		for lists in hoteldata:
			print lists
			start_urls.append('https://www.google.com/search?q='+str(lists))

	rules = (
		Rule(LinkExtractor(allow=(), deny=()), callback='parse_start_url', follow=True),
	)
	
	def start_requests(self):
		try:
			for url in self.start_urls:
				count = 0
				parsed = urlparse(url)
				hotelname = parse_qs(parsed.query)['q'][0]
				yield Request(url=url,callback=self.parse_start_url,meta={'hotelname':hotelname, 'count':count})
		except Exception as e:
			f = open(HotelBookingsSpider.name+'-log.txt', 'a')
			traceback.print_exc(file=f)
			f.close()

	def parse_start_url(self, response):
		try:
			sel = Selector(response)
			hotelname = response.meta['hotelname']
			count = response.meta['count']
			booklink = sel.xpath('//div[@class="vRH59e gws-local-hotels__hab"]').xpath('//a[@class="vJdf1c"]/@href').extract_first() if len(sel.xpath('//div[@class="vRH59e gws-local-hotels__hab"]')) > 0 else ""
			print "URL: ", booklink
			if booklink != "":
				actual_crawl_url = self.base_url+booklink
				yield Request(url=actual_crawl_url,cookies=self.get_cookies(actual_crawl_url),callback=self.getBookingDetails,meta={'hotelname':hotelname})
			elif count < 3:
				print "Retrying ", response.url
				count = count + 1
				yield Request(url=response.url,callback=self.parse_start_url,meta={'hotelname':hotelname, 'count':count},dont_filter = True)
		except Exception as e:
			f = open(HotelBookingsSpider.name+'-log.txt', 'a')
			f.write('\n\n%s' %(response.url))
			traceback.print_exc(file=f)
			f.close()


	def get_cookies(self,url):
		driver = webdriver.Firefox(executable_path=geckodriver, firefox_options=options)
		driver.get(url)
		rand_time = random.randint(5, 10)
		time.sleep(rand_time)
		cookies = driver.get_cookies()
		driver.close()
		driver.quit()
		return cookies


	def getBookingDetails(self, response):
		try:
			sel = Selector(response)
			hotelname = response.meta['hotelname']
			soup = BeautifulSoup(response.text, 'html.parser')
			check_in = soup.find_all(class_="p0RA ogfYpf Py5Hke")[0].text.encode('ascii', 'ignore').decode('ascii')
			check_out = soup.find_all(class_="p0RA ogfYpf Py5Hke")[1].text.encode('ascii', 'ignore').decode('ascii')
			bookingData = soup.find(class_="KoLVjf bM3xBe").find_all(class_="KQO6ob")
			print hotelname
			for index,record in enumerate(bookingData):
				sitename = record.find(class_="mK0tQb").text.encode('ascii', 'ignore').decode('ascii')
				rate =  record.find(class_="wqcQP").find(class_="MW1oTb").text.encode('ascii', 'ignore').decode('ascii') if len(record.find_all(class_="wqcQP")) > 0 else ""
				print "Sitename: ", sitename
				print "Rate: ", rate
				print "Checkin: ", check_in
				print "Checkout:", check_out
				updated_date_time = time.strftime('%Y-%m-%d %H:%M:%S') 
				CONN = MySQLdb.connect(host=SQL_HOST, user=SQL_USER, passwd=SQL_PASSWD, db=SQL_DB, charset='utf8')
				CURSOR = CONN.cursor()
				CURSOR.execute("""INSERT into OTA_checklist (hotelname,sitename,rate,checkin,checkout,created_at) values (%s,%s,%s,%s,%s,%s)""", (hotelname,sitename,rate,check_in,check_out,updated_date_time))
				CONN.commit()
		except Exception as e:
			f = open(HotelBookingsSpider.name+'-log.txt', 'a')
			f.write('\n\n%s' %(response.url))
			traceback.print_exc(file=f)
			f.close()


			
