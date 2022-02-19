<?php 
namespace App\Http\Controllers\Front;
use App\Http\Models\Front\Banners;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\Categories;
use App\Http\Models\Front\Brands;
use App\Http\Models\Front\Product;
use App\Http\Models\Front\Newsletter;
use App\Http\Models\Admin\Property;
use App\Models\DropOffList;
use App\Models\Page; //later added
use View;
use Session;
use Input;
use Illuminate\Http\RedirectResponse;
use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Request;

class HomeController extends Controller {
	private $data = array();
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		/*FOR DEBUG, PLEASE DON'T REMOVE THEESE LINES*/
		// $this->time = 0;
		// $this->queries = 0;
		// \DB::listen(function($sql, $bindings, $time)
		// {
		// 	$this->queries++;
		// 	$this->time+=$time;
		//     file_put_contents('php://stdout', "time:\t{$this->time} milliseconds\n-------------{$this->queries}----------------\n\n\n");
		// });
		$this->CategoriesModel = new Categories();
		$this->BrandsModel = new Brands();
		$this->BannersModel = new Banners(); 
		$this->ProductModel = new Product();
		$this->NewsletterModel = new Newsletter();
		$this->pageItem = new Page();

	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{	
		//Load module
		$shopCategories = $this->CategoriesModel->getAll();
		$this->data['categories'] = $shopCategories;
		
		
		$brands = $this->BrandsModel->getAllBrands();
		$this->data['brands'] = $brands;
		
		
		// get brands with most products listed
		$this->data['topSellingBrands'] = $this->BrandsModel->getAllTopSellingBrands();
		
		$latest_arrivals = $this->CategoriesModel->getcategory_home_list_enabletab();
		$this->data['latest_arrivals'] = $latest_arrivals;
		
		$homeCategoryWithoutTab = $this->CategoriesModel->getcategory_home_list_disabletab();
		$this->data['homeCategoryWithoutTab'] = $homeCategoryWithoutTab;
		
		
		$banner4 = $this->BannersModel->getLatestPromoLeftBanner();
		$this->data['bannerslatestpromo'] = $banner4;
		
		$banner5 = $this->BannersModel->getMidlleBottomBanner();
		$this->data['bannersbottom'] = $banner5;
		
		
		$banner1 = $this->BannersModel->getLeftBanner();
		$this->data['bannersleft'] = $banner1;
		
		$banner2 = $this->BannersModel->getMiddleTopBanner(); 
		$this->data['bannerslmiddletop'] = $banner2;
		
		$banner3 = $this->BannersModel->getTopBanner();
		$this->data['banners'] = $banner3;
		
		//New Arrivals & Bestsellers
		$this->data['newArrivals'] = $this->ProductModel->getNewArrivals(16);
		$this->data['bestsellers'] = $this->ProductModel->getBestsellers(16);

		// for getting the room suites.
		$this->data['rooms'] = $this->ProductModel->getProductsByCategory(8);
		$this->data['aparts'] = $this->ProductModel->getProductsByCategory(9);

		// for index page dynmiac      
		// 1.) index_first
		$pages = $this->pageItem->where('page','=','index')->first();
		$this->data['index_first'] = unserialize($pages->new_content);
		// 2.) index_second
		$pages = $this->pageItem->where('page','=','index_second')->first();
		$this->data['index_second'] = unserialize($pages->new_content);
		// 3.) index_third
		$pages = $this->pageItem->where('page','=','index_third')->first();
		$this->data['index_third'] = unserialize($pages->new_content);
		// 4.) index_fourth
		$pages = $this->pageItem->where('page','=','index_fourth')->first();
		$this->data['index_fourth'] = unserialize($pages->new_content);
		// 5.) facilites
		$pages = $this->pageItem->where('page','=','facilities')->first();
		$this->data['facility'] = unserialize($pages->new_content);
		$this->data['background'] = $pages;
		$this->data['facilities'] = DB::select("SELECT * FROM facilities WHERE status = 1");
		// 6.) video title
		$pages = $this->pageItem->where('page','=','video')->first();
		$this->data['video_title'] = unserialize($pages->new_content);
		// 7.) for dyanmic video 		
		$this->data['videos'] = DB::select("SELECT * FROM videos WHERE status = 1");
		$this->data['properties'] = Property::where('status',1)->select('property_id','name')->get();
		$this->data['drop_off_list'] = DropOffList::where('status',1)->select('drop_list_id','name')->get();

		return view('front.home.home', $this->data);
	}
	
	public function search_result()
	{
		//echo "sxcdsadcascas";
		return view('front.home.search_result');
	}
	
	public function searchdata()
	{
		/*echo "<pre>";
		print_r($_POST);*/
		$post=$_POST;
		if(isset($post['searchbox'])&& ($post['searchbox']!=''))
		{
			
			$data['keyword'] = $post['searchbox'];
			
			$data['searchdata'] =DB::select("SELECT * FROM products WHERE product_name='".$post['searchbox']."'"); 
		}
		return view('front.home.search_result', $data);
		
	}

	public function searchlowestrate($checkin,$checkout)
	{




		if(isset($checkin) && isset($checkout))
		{	
			$data =DB::select('SELECT *, REPLACE( rate, "RM", "" ) AS new_rate FROM OTA_checklist
			WHERE STR_TO_DATE( checkin, "%a, " "%b " "%e" ) >= STR_TO_DATE( DATE_FORMAT( "'.$checkin.'", "%a, " "%b " "%e" ) , "%a, " "%b " "%e" )
			AND STR_TO_DATE( checkout, "%a, " "%b " "%e" ) <= STR_TO_DATE( DATE_FORMAT( "'.$checkout.'", "%a, " "%b " "%e" ) , "%a, " "%b " "%e" ) ORDER BY CAST( new_rate AS SIGNED ) ASC');
			return json_encode($data);
		}
		
	}
	
	public function getRoomsFromLowestRate() 
	{
		$data = Input::all();
		$checkin = $data['arrival'];
		$checkout = $data['departure'];

		$product = DB::table('products as p')
			->select(
				'p.*','b.title as brand_name',
				'p.type as sitename',
				'prp.sale_price as new_rate',
				// DB::raw('ROUND(SUM(COALESCE(prp.sale_price, 0)), 2) as new_rate'),
				// DB::raw('ROUND(SUM(COALESCE(prp.list_price, 0)), 2) as list_price'),
				'prp.date as date',
				'prp.id as room_id'

			)->join(DB::raw('(SELECT * FROM `product_room_prices`) prp'), function($join) use($checkin, $checkout) {
				$join->on('p.id', '=', 'prp.product_id')
					->where('prp.status', '=', '1')
					;
					// ->where('prp.date', '<', $checkout);
			});
		$product->whereBetween('prp.date', [$checkin, $checkout]);
		$product->leftJoin('brands as b', 'p.brand_id', '=', 'b.id');
		// $product->where('p.id', $product_id);
		$product->orderBy("prp.sale_price", "ASC");
		$product->groupBy("p.id");
		$product->where('p.status', '1');

		return $product->get();

	}
	/**
	 * Add Subscriber
	 */
	function addSubscriber()
	{
		if(Request::isMethod('post'))
		{
			$validator = Validator::make(Request::all(),[
				'email' => 'required|email'
			]);
			
			if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				echo json_encode($json);
				exit;
			}else{
			    
				$this->NewsletterModel->addSubscriber(Request::all());
                return json_encode(['success' => 'Newsletter is subscribed!']);
//				echo json_encode(array('success' => 'success'));
				//exit;
			}
		}
	}

}
