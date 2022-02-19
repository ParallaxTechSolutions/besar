<?php namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Models\Front\Product;
use App\Http\Models\Front\CheckAvail;

use Helper;
use Session;
use Input;
use Illuminate\Http\RedirectResponse;
use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use View;

use Request;
use Response;
use Cookie;

class CheckAvailController extends Controller {
	private $data = array();

	public function __construct()
	{
		$this->CheckAvailModel = new CheckAvail();
		$this->ProductModel = new Product();
	}

	function index(){
		$data = Input::all();
		return View::make('front.check_avail.check_avail',$data);
	}

	function check_avail(){
		$data = Input::all();
		$rules = [
            'checkin_date' => 'required',
            'checkout_date' => 'required'
        ];
        $val = Validator::make($data, $rules);

        if ($val->fails()) {
        	echo json_encode(['status' => false]);
        	return;
        }

        // Get available rooms
        $avail = $this->CheckAvailModel->getRoom($data['checkin_date'] , $data['checkout_date'], $data);
        foreach ($avail as $key => &$value) {
                $discount = $this->ProductModel->getGlobalDiscount($value->id, $value->sale_price);
                if(!empty($discount)){
                	$off = 0;
                	if($discount->discount_by == 'percentage'){
                		$off = ($value->sale_price*$discount->discount)/100;
                	}else{
                		$off = $discount->discount;
                	}

                	$value->discount = $off;
                }else{
                	$value->discount = $off;
                }
            }
		echo json_encode(['status' => true, 'avail' => $avail]);
	}

	function saveCart(){
		$cart = [];
		$data = Input::all();
		$cart['product'] = array();
		$cart['arrival'] = $data['arrival'];
		$cart['departure'] = $data['departure'];
		foreach ($data['order'] as $key => $value) {
			$product = $this->ProductModel->getProduct($value['product_id']);
			if(empty($product)) continue;
                $discount = $this->ProductModel->getGlobalDiscount($product->id, $product->sale_price);
                if(!empty($discount)){
                	$off = 0;
                	if($discount->discount_by == 'percentage'){
                		$off = ($product->sale_price*$discount->discount)/100;
                	}else{
                		$off = $discount->discount;
                	}

                }else{
                	$off = 0;
                }
			$cartProduct = array(
				'product_id' => $product->id,
				'off' => $off,
				'type' => $product->type,
				'qty' => $value['qty'],
				'thumbnail_image_1' => $product->thumbnail_image_1,
				'room_code' => $product->room_code,
				'bed' => $product->bed,
				'guest' => $product->guest,
				'meal' => $product->meal,
				'sale_price' => $product->sale_price,
				'quantity_in_stock' => $product->quantity_in_stock
				);
			$cart['product'][] = $cartProduct;
		}
		Session::put('cart', $cart);
		echo json_encode(array('status' => 1));
	}
}