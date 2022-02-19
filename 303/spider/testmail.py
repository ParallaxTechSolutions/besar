from scrapy.http import Request
from scrapy.selector import Selector
from scrapy.linkextractors import LinkExtractor
from scrapy.spiders import CrawlSpider, Rule
from hotel_bookingdetails.items import HotelBookingdetailsItem
from scrapy.http.cookies import CookieJar
from urlparse import urljoin
from urlparse import urlparse, parse_qs
import urllib
from scrapy import signals
from pydispatch import dispatcher
from scrapy.mail import MailSender
import time
import os
import psutil
import subprocess
import re

class HotelBookingsSpider(CrawlSpider):
	name = 'testmail'
	base_url = 'https://www.google.com'
	allowed_domains = ['www.google.com']
	mailer = MailSender(smtphost='mail.webqom.com', mailfrom='support@webqom.com', smtpuser='support@webqom.com', smtppass='1218PlUWdXA%%B.8', smtpport=587)
	start_urls = []
	

	def __init__(self):
		dispatcher.connect(self.spider_closed, signals.spider_closed)


	def spider_closed(self, spider):
		return self.mailer.send(to=["jon.tham@webqom.com"], subject="Crawl Testing", body="Crawl Testing")
			
