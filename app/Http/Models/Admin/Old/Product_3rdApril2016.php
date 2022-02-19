<?php
namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
class Product extends Model{


	function updateAllProductsStatus($status){
		DB::table('products')->update(['status' => $status]);
	}

	function importBulkProducts($data){
		foreach($data as $product){

			if($product['product_brand']){
				$brand_id = DB::table('brands')->where('title', $product['product_brand'])->first();

				// check brand
				if($brand_id){
					$brand_id = $brand_id->id;
				} else{
					$brand_id = DB::table('brands')->insertGetId(['title'  => $product['product_brand'], 'image'  => '', 'status' => 1]);
				}
			} else{
				$brand_id = false;
			}

			if($product['category']){
				$category_id = DB::table('categories')->where('title', $product['category'])->first();
				// check category
				if($category_id){
					$category_id = $category_id->id;
				} else{
					$category_id = DB::table('categories')
						->insertGetId([
							'title'  => $product['category'],
							'iconKeyword'  => '',
							'image'  => '',
							'alt_text'  => '',
							'image2'  => '',
							'alt_text2'  => '',
							'short_description'  => '',
							'order_no'  => '0',
							'parent_id'  => '0',
							'status' => 1
						]);
				}
			} else{
				$category_id = false;
			}


			if($product['sub_category']){
				$sub_category_id = DB::table('categories')->where('title', $product['sub_category'])->first();
				// check sub_category
				if($sub_category_id){
					$sub_category_id = $sub_category_id->id;
				} else{
					$sub_category_id = DB::table('categories')
						->insertGetId([
							'title'  => $product['sub_category'],
							'iconKeyword'  => '',
							'image'  => '',
							'alt_text'  => '',
							'image2'  => '',
							'alt_text2'  => '',
							'short_description'  => '',
							'order_no'  => '0',
							'parent_id'  => $category_id,
							'status' => 1
						]);
				}
			} else{
				$sub_category_id = false;
			}

			if($product['sub_sub_category']){
				$sub_sub_category_id = DB::table('categories')->where('title', $product['sub_sub_category'])->first();
				// check sub_sub_category
				if($sub_sub_category_id){
					$sub_sub_category_id = $sub_sub_category_id->id;
				} else{
					$sub_sub_category_id = DB::table('categories')
						->insertGetId([
							'title'  => $product['sub_sub_category'],
							'iconKeyword'  => '',
							'image'  => '',
							'alt_text'  => '',
							'image2'  => '',
							'alt_text2'  => '',
							'short_description'  => '',
							'order_no'  => '0',
							'parent_id'  => $sub_category_id,
							'status' => 1
						]);
				}
			} else{
				$sub_sub_category_id = false;
			}


			if($product['sub_sub_sub_category']){
				$sub_sub_sub_category_id = DB::table('categories')->where('title', $product['sub_sub_sub_category'])->first();
				// check sub_sub_sub_category
				if($sub_sub_sub_category_id){
					$sub_sub_sub_category_id = $sub_sub_sub_category_id->id;
				} else{
					$sub_sub_sub_category_id = DB::table('categories')
						->insertGetId([
							'title'  => $product['sub_sub_sub_category'],
							'iconKeyword'  => '',
							'image'  => '',
							'alt_text'  => '',
							'image2'  => '',
							'alt_text2'  => '',
							'short_description'  => '',
							'order_no'  => '0',
							'parent_id'  => $sub_sub_category_id,
							'status' => 1
						]);
				}
			} else{
				$sub_sub_sub_category_id = false;
			}


			if($product['sub_sub_sub_sub_category']){
				$sub_sub_sub_sub_category_id = DB::table('categories')->where('title', $product['sub_sub_sub_sub_category'])->first();
				// check sub_sub_category
				if($sub_sub_sub_sub_category_id){
					$sub_sub_sub_sub_category_id = $sub_sub_sub_sub_category_id->id;
				} else{
					$sub_sub_sub_sub_category_id = DB::table('categories')
						->insertGetId([
							'title'  => $product['sub_sub_sub_sub_category'],
							'iconKeyword'  => '',
							'image'  => '',
							'alt_text'  => '',
							'image2'  => '',
							'alt_text2'  => '',
							'short_description'  => '',
							'order_no'  => '0',
							'parent_id'  => $sub_sub_sub_category_id,
							'status' => 1
						]);
				}
			} else{
				$sub_sub_sub_sub_category_id = false;
			}

			$cat_id = false;
			if($sub_sub_sub_sub_category_id){
				$cat_id = $sub_sub_sub_sub_category_id;
			} elseif($sub_sub_sub_category_id){
				$cat_id = $sub_sub_sub_category_id;
			} elseif($sub_sub_category_id){
				$cat_id = $sub_sub_category_id;
			} elseif($sub_category_id){
				$cat_id = $sub_category_id;
			} else if ($category_id){
				$cat_id = $category_id;
			}

			$product_exists = DB::table('products')->where('product_code', $product['product_code'])->first();
			if($product_exists){
				// update
				DB::table('products')->where('product_code', $product['product_code'])->update([
					'product_name'  => $product['product_name'],
					'brand_id'  => $brand_id,
					'sale_price'  => $product['sale_price'],
					'list_price'  => $product['list_price'],
					'quantity_in_stock'  => $product['quantity_in_stock'],
					'low_level_in_stock'  => $product['low_level_in_stock'],
					'manufacturer_part_number'  => $product['manufacturer_part_number'],
					'is_tax'  => ($product['tax'])? 1: 0,
					'weight'  => $product['weight'],
					'status'  => $product['status'],
				]);

				DB::table('product_to_category')->where('product_id', $product_exists->id)->delete();

				DB::table('product_to_category')
					->insertGetId([
						'category_id'  => $cat_id,
						'product_id'  => $product_exists->id,
						'display_order'  => '0'
					]);

			} else{


				// insert to product
				$product_id = DB::table('products')
					->insertGetId([
						'product_name'  => $product['product_name'],
						'product_code'  => $product['product_code'],
						'brand_id'  => $brand_id,
						'sale_price'  => $product['sale_price'],
						'list_price'  => $product['list_price'],
						'quantity_in_stock'  => $product['quantity_in_stock'],
						'low_level_in_stock'  => $product['low_level_in_stock'],
						'manufacturer_part_number'  => $product['manufacturer_part_number'],
						'is_tax'  => ($product['tax'])? 1: 0,
						'weight'  => $product['weight'],
						'status'  => $product['status'],
					]);


				// insert to product_to_category
				DB::table('product_to_category')
					->insertGetId([
						'category_id'  => $cat_id,
						'product_id'  => $product_id,
						'display_order'  => '0'
					]);

			}
		}


	}

	function addProduct($formData)
	{
		/*if($imageName)
			$data['image'] = $imageName;
		
		$status = (isset($formData['status']) && $formData['status'] == 'on') ? '1' : '0';
		
		$data['title'] = $formData['title'];
		$data['status'] = $status;	*/
		
		unset($formData['_token']);
		
		$display_order = $formData['display_order'];
		unset($formData['display_order']);
		
		$categories = array();
		$colors = array();
		
		$categories = $formData['categories'];
		unset($formData['categories']);
		
		if(isset($formData['colors']))
		{
			$colors = $formData['colors'];
			unset($formData['colors']);			
		}
		
		$formData['available_since'] = date('Y-m-d',strtotime($formData['available_since']));
		$formData['created'] = date('Y-m-d',strtotime($formData['created']));
		$formData['createdate'] = date('Y-m-d H:i:s');
		$formData['last_modified'] = date('Y-m-d H:i:s');
		//print_r($categories);
		//print_r($colors);
		//dd($formData);
		
		DB::table('products')->insert($formData);
		
		$inserted_id = DB::getPdo()->lastInsertId();
		//echo $inserted_id; exit;
		// insert into product to categories
		if(sizeof($categories) > 0)
		{
			foreach($categories as $category_id)
			{
				DB::table('product_to_category')->insert(array('category_id' => $category_id, 'product_id' => $inserted_id, 'display_order' => $display_order));	
			}	
		}
		
		// insert into product to colors
		if(sizeof($colors) > 0)
		{
			foreach($colors as $colors_id)
			{
				DB::table('product_to_color')->insert(array('color_id' => $colors_id, 'product_id' => $inserted_id));	
			}	
		}
		
		return $inserted_id;
	}
	
	function updateProduct($formData,$product_id)
	{		
		unset($formData['_token']);
		
		$display_order = $formData['display_order'];
		unset($formData['display_order']);
		
		$categories = array();
		$colors = array();
		
		$categories = $formData['categories'];
		unset($formData['categories']);
		
		if(isset($formData['colors']))
		{
			$colors = $formData['colors'];
			unset($formData['colors']);			
		}
		
		$formData['sale_price'] = str_replace(',','',$formData['sale_price']);
		$formData['list_price'] = str_replace(',','',$formData['list_price']);
		$formData['available_since'] = date('Y-m-d',strtotime($formData['available_since']));
		$formData['created'] = date('Y-m-d',strtotime($formData['created']));
		$formData['last_modified'] = date('Y-m-d H:i:s');
		
		//print_r($categories);
		//print_r($colors);
		//dd($formData);
		DB::table('products')->where('id',$product_id)->update($formData);
		
		$inserted_id = $product_id;
		//echo $inserted_id; exit;
		
		// delete existing categories
		DB::table('product_to_category')->where('product_id',$product_id)->delete();
		
		// insert into product to categories
		if(sizeof($categories) > 0)
		{
			foreach($categories as $category_id)
			{
				DB::table('product_to_category')->insert(array('category_id' => $category_id, 'product_id' => $product_id, 'display_order' => $display_order));	
			}	
		}
		
		
		// delete existing colors
		DB::table('product_to_color')->where('product_id',$product_id)->delete();		
		
		// insert into product to colors
		if(sizeof($colors) > 0)
		{
			foreach($colors as $colors_id)
			{
				DB::table('product_to_color')->insert(array('color_id' => $colors_id, 'product_id' => $product_id));	
			}	
		}
	}
	
	
	// get product details
	function getProductDetails($product_id)
	{
		// get details
		$data['productDetails'] = DB::table('products')->where('id',$product_id)->first();
		
		// get product categories
		$data['productCategories'] = $this->getProductCategories($product_id);
		
		// get product colors
		$data['productColors'] = $this->getProductColors($product_id);
		
		// get product images
		//$data['productImages'] = $this->getProductImages($product_id);
		
		return $data;
		
	}
	
	function getProductCategories($product_id)
	{
		return DB::table('product_to_category')->where('product_id',$product_id)->get();
	}
	
	function getProductColors($product_id)
	{
		return DB::table('product_to_color')->where('product_id',$product_id)->lists('color_id');
	}
	
	function getProductImages($product_id)
	{
		return DB::table('product_to_images')->where('product_id',$product_id)->get();
	}
	
	// get all products
	function getProducts()
	{
		$per_page = (Session::has('product.per_page')) ? Session::get('product.per_page') : 30;
		return DB::table('products')->paginate($per_page);	
	}
	
	// get record for pagination report
	function getTotalProducts($current_page)
	{
		$current_page = ($current_page) ? $current_page : 1;
		$per_page = (Session::has('product.per_page')) ? Session::get('product.per_page') : 30;
		$total_records = DB::table('products')->count();
		
		$page_to = (($current_page * $per_page) > $total_records) ? $total_records : ($current_page * $per_page);
		
		$msg = 'Showing '. ((($current_page-1) * $per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		
		//return array('total_records' => $total_records, 'current_page' => $current_page, 'per_page' => $per_page, 'message' => $msg);
		return $msg;
	}
	
	function deleteProducts($item_id)
	{
		// delete products
		DB::table('products')->whereIn('id',explode(',',$item_id))->delete();
		
		// delete images
		DB::table('product_to_images')->whereIn('product_id',explode(',',$item_id))->delete();
		
		DB::table('product_to_category')->whereIn('product_id',explode(',',$item_id))->delete();
		DB::table('product_to_color')->whereIn('product_id',explode(',',$item_id))->delete();
		DB::table('product_to_quantity_discount')->whereIn('product_id',explode(',',$item_id))->delete();
		
			
	}
	
	/**
	 * get all active sub category childs by category id
	*/
	function getSubCategories($category_id = array(),$arr_categories = array())
	{
		$results = DB::table('categories')->where('status','1')->whereIN('parent_id', $category_id)->lists('id');	
		
		if(sizeof($results) > 0)
		{		
			array_push($arr_categories,$results);			
			
			return $this->getSubCategories($results,$arr_categories);
		}
		
		$subCategories = array();
		foreach($arr_categories as $resultSet)
		{
			foreach($resultSet as $item)
			{
				array_push($subCategories,$item);
			}
		}
		return $subCategories;
	}
	
	function searchProducts($search_for)
	{
		//dd($search_for);
		$per_page = (Session::has('product.per_page')) ? Session::get('product.per_page') : 100;
	
		$query = DB::table('products');
		
		if($search_for['product_name'] != '')
			$query = $query->where('product_name','like','%'.$search_for['product_name'].'%');
		
		if($search_for['product_code'] != '')
			$query = $query->where('product_code','like','%'.$search_for['product_code'].'%');
		
		if($search_for['price_from'] != '' && $search_for['price_to'] != '')
			$query = $query->whereBetween('sale_price',array($search_for['price_from'],$search_for['price_to']));
		else if($search_for['price_from'] != '' && ($search_for['price_to'] == '' || $search_for['price_to'] == 0))
			$query = $query->where('sale_price','>=',$search_for['price_from']);
		else if($search_for['price_to'] != '' && ($search_for['price_from'] == '' || $search_for['price_from'] == 0))
			$query = $query->where('sale_price','<=',$search_for['price_to']);
		
		if($search_for['brand_id'] != 'all')
			$query = $query->where('brand_id',$search_for['brand_id']);
		
		if($search_for['category_id'] != 'all')
		{
			$category_id = $search_for['category_id'];
			
			$categoryList = $this->getSubCategories(array($category_id));
		
			array_push($categoryList,(int)$category_id);
			
			//$product_ids = DB::table('product_to_category')->where('category_id',$search_for['category_id'])->lists('product_id');
			$product_ids = DB::table('product_to_category')->whereIN('category_id',$categoryList)->lists('product_id');
			
			$query = $query->whereIn('id',$product_ids);
		}
		
		return $query->paginate($per_page);
	}
	
	// get record for pagination report
	function getTotalSearchResults($search_for)
	{
		$current_page = (isset($search_for['page'])) ? $search_for['page'] : 1;
		$per_page = (Session::has('product.per_page')) ? Session::get('product.per_page') : 100;
		
		$query = DB::table('products');
		
		if($search_for['product_name'] != '')
			$query = $query->where('product_name','like','%'.$search_for['product_name'].'%');
		
		if($search_for['product_code'] != '')
			$query = $query->where('product_code','like','%'.$search_for['product_code'].'%');
		
		if($search_for['price_from'] != '' && $search_for['price_to'] != '')
			$query = $query->whereBetween('sale_price',array($search_for['price_from'],$search_for['price_to']));
		else if($search_for['price_from'] != '' && ($search_for['price_to'] == '' || $search_for['price_to'] == 0))
			$query = $query->where('sale_price','>=',$search_for['price_from']);
		else if($search_for['price_to'] != '' && ($search_for['price_from'] == '' || $search_for['price_from'] == 0))
			$query = $query->where('sale_price','<=',$search_for['price_to']);
		
		if($search_for['brand_id'] != 'all')
			$query = $query->where('brand_id',$search_for['brand_id']);
		
		if($search_for['category_id'] != 'all')
		{
			//$product_ids = DB::table('product_to_category')->where('category_id',$search_for['category_id'])->lists('product_id');
			$category_id = $search_for['category_id'];
			
			$categoryList = $this->getSubCategories(array($category_id));
		
			array_push($categoryList,(int)$category_id);
			
			//$product_ids = DB::table('product_to_category')->where('category_id',$search_for['category_id'])->lists('product_id');
			$product_ids = DB::table('product_to_category')->whereIN('category_id',$categoryList)->lists('product_id');
			$query = $query->whereIn('id',$product_ids);
		}
		$total_records = $query->count();
		
		$page_to = (($current_page * $per_page) > $total_records) ? $total_records : ($current_page * $per_page);
		
		$msg = 'Showing '. ((($current_page-1) * $per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		
		//return array('total_records' => $total_records, 'current_page' => $current_page, 'per_page' => $per_page, 'message' => $msg);
		return $msg;
	}
	
	function categoryProducts($category_id)
	{
		$result = DB::table('products as p')->select('p.*','c.display_order')->leftJoin('product_to_category as c','p.id','=','c.product_id')->where('p.status','1')->where('c.category_id',$category_id)->groupBY('p.id')->get();
		
		return $result;				
	}
	
	function getQuantityDiscounts($product_id)
	{
		//return DB::table('product_to_quantity_discount')->where('product_id',$product_id)->get();
		
		$per_page = (Session::has('quantity_discount.per_page')) ? Session::get('quantity_discount.per_page') : 30;
		return DB::table('product_to_quantity_discount')->where('product_id',$product_id)->paginate($per_page);
	}
	
	// get record for pagination report
	function getTotalQuantityDiscounts($current_page,$product_id)
	{
		$current_page = ($current_page) ? $current_page : 1;
		$per_page = (Session::has('quantity_discount.per_page')) ? Session::get('quantity_discount.per_page') : 30;
		$total_records = DB::table('product_to_quantity_discount')->where('product_id',$product_id)->count();
		
		$page_to = (($current_page * $per_page) > $total_records) ? $total_records : ($current_page * $per_page);
		
		$msg = 'Showing '. ((($current_page-1) * $per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		
		//return array('total_records' => $total_records, 'current_page' => $current_page, 'per_page' => $per_page, 'message' => $msg);
		return $msg;
	}
	
	function deleteQuantityDiscount($item_id)
	{
		DB::table('product_to_quantity_discount')->whereIn('id',explode(',',$item_id))->delete();
	}
	
	public function getNotifyUsers($product_id){
		return DB::table('notify_me')->where('product_id', '=', $product_id)->where('mail_send', '=', '0')->get();
	}
	
	public function updateNotifyUsers($ids){
		DB::table('notify_me')->whereIn('id',$ids)->update(['mail_send' => '1']);
	}
}