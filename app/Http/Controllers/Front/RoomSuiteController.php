<?php namespace App\Http\Controllers\Front;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\DropOffList;
use App\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Front\Product as ProductModel;
use App\Http\Models\Admin\Property;
use Illuminate\Http\Request;
use Response;

class RoomSuiteController extends Controller {
	private $ProductModel = null;

	public function __construct()
	{
		$this->ProductModel = new ProductModel();
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id = '')
	{

		$product = array();
		if(!empty($id)){
			$product = $this->ProductModel->getProductsByCategory($id, 'order');
			$banners = \App\Models\BannerLeft::getBannerImages($id);
		}

		// dd($product);
		return view('front/rooms_suites/rooms_suites', compact("product", "banners"));
	}

	public function getList(Request $r)
	{
		$product = $this->ProductModel->getProductsByCategory($r->id,$r->type);
		return $product;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id,$package= null)
	{
	   	$product = DB::table('products')
			->leftJoin(DB::raw('(SELECT * FROM `product_room_prices`) prp'), function($join) {
				$join->on('products.id', '=', 'prp.product_id')
					->where('prp.status', '=', '1')
					->where('prp.date', '=', date('Y-m-d'));
			})
			->where('products.id', $id)
			->select(
				'products.*',
				DB::raw('COALESCE(prp.sale_price, 0) as sale_price'),
				DB::raw('COALESCE(prp.list_price, 0) as list_price'),
				'prp.date as date'
			)->first();
		$properties = Property::where('status',1)->select('property_id','name')->get();
		$dropOffList = DropOffList::where('status',1)->get();
	   $images = Product::findOrFail($id)->images;
	   $packages = DB::table('product_to_quantity_discount')->where('product_id',$id)->get();
	   // $images = $this->ProductModel->getProductImages($id);
         //$this->ProductModel->updateViewProduct($product->id);
         /* echo '<pre>';
         print_r($product);
         exit; */

		return view('front/rooms_suites/show')->with('product',$product)
											  ->with('images',$images)
											  ->with('packages', $packages)
		                                      ->with('properties',$properties)
		                                      ->with('dropOffList',$dropOffList)
		                                      ->with('attached_package_id',$package);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
