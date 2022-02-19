<?php namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Http\Models\Front\Product;
use App\Http\Models\Admin\Promotion;
use App\Http\Models\Countries;
use App\Http\Models\Front\Checkout;
use App\Http\Models\Front\Brands;

use Session;
use Input;
use Illuminate\Http\RedirectResponse;
use Auth;

use Redirect;

use Request;
use Response;
use DB;
use Validator;
use View;
use Mail;
use Helper;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderToProduct;
use App\Models\RoomBookedDate;
use App\Models\Product as myProduct;


class CheckoutController extends Controller {
	private $data = array();
	private $ProductModel = null;
	private $CheckoutModel = null;

	public function __construct()
	{
		$this->ProductsModel = new Product();
		$this->CheckoutModel = new Checkout();
		$this->BrandsModel = new Brands();
		$this->PromotionModel = new Promotion();
	}

	function index(){
		$cart = Session::get('cart');
		$this->data['cart'] = $cart == null?array():$cart;
		$total = 0;
		$discount = 0;
		foreach ($cart['product'] as $key => $value) {
			$total += $value['sale_price']*$value['qty'];
			$discount += floor($value['off'])*$value['qty'];
		}
		$this->data['discount'] = $discount;
		$this->data['warning'] = Session::get('checkout.warning');
		$this->data['isUserLogin'] = Session::has('userId');
		$this->data['page_title'] = 'Checkout';
		return view('front.checkout.index',$this->data);
	}
	function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
    public function orderPlacement($payment, $payment_id) {
        $user_id = Session::get('userId');
        $customerArr = Customer::where('id',$user_id)->first();
        $cart = Session::get('cart');
        $orderObj = new Order();
        $orderObj->order_id = $payment_id.str_random(6);
        $orderObj->customer_id = $user_id;
        $orderObj->billing_first_name = $customerArr['billing_first_name'];
        $orderObj->billing_last_name = $customerArr['billing_last_name'];
        $orderObj->billing_email = $customerArr['billing_email'];
        $orderObj->billing_telephone = $customerArr['billing_telephone'];
        $orderObj->billing_address = $customerArr['billing_address'];
        $orderObj->billing_city = $customerArr['billing_city'];
        $orderObj->billing_post_code = $customerArr['billing_post_code'];
        $orderObj->billing_state = $customerArr['billing_state'];
        $orderObj->billing_country = $customerArr['billing_country'];
        $orderObj->shipping_first_name = $customerArr['shipping_first_name'];
        $orderObj->shipping_last_name = $customerArr['shipping_last_name'];
        $orderObj->shipping_email = $customerArr['shipping_email'];
        $orderObj->shipping_telephone = $customerArr['shipping_telephone'];
        $orderObj->shipping_address = $customerArr['shipping_address'];
        $orderObj->shipping_city = $customerArr['shipping_city'];
        $orderObj->shipping_post_code = $customerArr['shipping_post_code'];
        $orderObj->shipping_state = $customerArr['shipping_state'];
        $orderObj->shipping_country = $customerArr['shipping_country'];
        $orderObj->totalPrice = $payment->transactions[0]->amount->total;
        $orderObj->transaction_id = $payment_id;
        $orderObj->payment_method = 'PayPal';
        $orderObj->payment_status = 'Paid';
        $orderObj->status = 'Paid';
        $orderObj->ip_address = $this->getRealIpAddr();
        $orderObj->modifydate = date('Y-m-d H:i:s');
        $orderObj->createdate = date('Y-m-d H:i:s');
        $orderObj->save();
        

        
        $OrderToProductArr = [];
        foreach($cart['product'] as $room) {
            $OrderToProduct = new OrderToProduct();
            $RoomBookedDate = new RoomBookedDate();
            $OrderToProduct->order_id = $orderObj->id;
            $OrderToProduct->product_id = $room['product_id'];
            $OrderToProduct->quantity = $room['qty'];
            $OrderToProduct->amount = $room['sale_price'];
            $OrderToProduct->quantity_discount =$room['off'];            
            $OrderToProduct->save();
            array_push($OrderToProductArr,$OrderToProduct);
            $RoomBookedDate->date_checkin = $cart['arrival'];
            $RoomBookedDate->date_checkout = $cart['departure'];
            $RoomBookedDate->order_id = $orderObj->id;
            $RoomBookedDate->product_id = $room['product_id'];
            $RoomBookedDate->save();
            
            myProduct::where('id',$room['product_id'])->decrement('quantity_in_stock',$room['qty']);
        }
         $invoice = array(
                'order' => $orderObj,
                'order_to_products' => $OrderToProductArr
            );
        
        $messageData = [
                'fromEmail' => 'registration@ritzgardenhotel.com',
                'fromName' => 'RitzGarden',
                'toEmail' => $orderObj->billing_email,
                 'toName' => $orderObj->billing_first_name . ' ' . $orderObj->billing_last_name,
                'subject' => 'TBM::Order #' . $orderObj->order_id
            ];
            Mail::send('invoice.invoice-html', $invoice, function ($message) use ($messageData) {
                $message->from($messageData['fromEmail'], $messageData['fromName']);
                $message->to($messageData['toEmail'], $messageData['toName']);
                $message->subject($messageData['subject']);
            });
         $invoice2 = array(
                'orderInfo' => $orderObj,
                'orderProducts' => $OrderToProduct
            );
        Session::forget('cart');
        return view('front.checkout.order-confirmation')->with($invoice2);

    }
// 	function index()
// 	{
// 		$cart = Session::get('cart');
// 		$estimateShipping = Session::get('estimateShipping');
// 		$promocode = Session::get('promocode');
// 		$cart_info = Helper::getCartInfo();

// 		if (!$cart){
// 			return redirect('/');
// 		}

// 		$this->data['errors'] = false;

// 		if (Request::isMethod('post'))
// 		{
// 			$validation['billing_first_name'] = 'required';
// 			$validation['billing_last_name'] = 'required';
// 			$validation['billing_email'] = 'required|email';
// 			$validation['billing_telephone'] = 'required';
// 			$validation['billing_country'] = 'required';
// 			//$validation['billing_state'] = 'required';
// 			$validation['billing_address'] = 'required';
// 			$validation['billing_city'] = 'required';
// 			$validation['billing_post_code'] = 'required';

// 			$validation['shipping_first_name'] = 'required';
// 			$validation['shipping_last_name'] = 'required';
// 			$validation['shipping_email'] = 'required|email';
// 			$validation['shipping_telephone'] = 'required';
// 			$validation['shipping_country'] = 'required';
// 			//$validation['shipping_state'] = 'required';
// 			$validation['shipping_address'] = 'required';
// 			$validation['shipping_city'] = 'required';
// 			$validation['shipping_post_code'] = 'required';
// 			$validation['payment_method'] = 'required';

// 			$validator = Validator::make(Request::all(), $validation);

// 			if ($validator->fails()) {
// 				$this->data['errors'] = $validator->errors('<p>:message</p>')->all();
// 			}
// 			else
// 			{
// 				$data['customer_id'] = Session::get('userId');

// 				$data['billing_first_name'] = Input::get('billing_first_name');
// 				$data['billing_last_name'] = Input::get('billing_last_name');
// 				$data['billing_email'] = Input::get('billing_email');
// 				$data['billing_telephone'] = Input::get('billing_telephone');
// 				$data['billing_country'] = Input::get('billing_country');
// 				$data['billing_state'] = Input::get('billing_state');
// 				$data['billing_address'] = Input::get('billing_address');
// 				$data['billing_city'] = Input::get('billing_city');
// 				$data['billing_post_code'] = Input::get('billing_post_code');

// 				$data['shipping_first_name'] = Input::get('shipping_first_name');
// 				$data['shipping_last_name'] = Input::get('shipping_last_name');
// 				$data['shipping_email'] = Input::get('shipping_email');
// 				$data['shipping_telephone'] = Input::get('shipping_telephone');
// 				$data['shipping_country'] = Input::get('shipping_country');
// 				$data['shipping_state'] = Input::get('shipping_state');
// 				$data['shipping_address'] = Input::get('shipping_address');
// 				$data['shipping_city'] = Input::get('shipping_city');
// 				$data['shipping_post_code'] = Input::get('shipping_post_code');
// 				$data['payment_method'] = Input::get('payment_method');

// 				//Add Estimate Shipping
// 				if (isset($estimateShipping['shipping_method']) && $estimateShipping['shipping_method'] != '') {
// 					$data['shipping_method'] = $estimateShipping['shipping_method'];
// 				} elseif (Session::has('default_ship')) {
// 					$data['shipping_method'] = Session::get('default_ship');
// 				}

// 				//save shipping charge
// 				if (Session::has('shipping_charge')) {
// 					$data['shipping_charge'] = Session::get('shipping_charge');
// 				} else {
// 					$data['shipping_charge'] = 0;
// 				}

// 				//save order total weight
// 				if ($cart_info !== false) {
// 					$data['total_weight'] = $cart_info['total_weight'];
// 				}
// 				$data['shipping_estimate_country'] = (isset($estimateShipping['country']) ? $estimateShipping['country'] : '');
// 				$data['shipping_estimate_state'] = (isset($estimateShipping['state']) ? $estimateShipping['state'] : '');

// 				//Update customer
// 				//$this->CheckoutModel->updateCustomer(Session::get('userId'), $data);
// 				//end

// 				$cartProducts = $this->ProductsModel->getCartProducts($cart, $promocode);
// 				$discount = 0;

// 				foreach($cartProducts['products'] as $key => $cartProduct){
// 					$data['products'][$key]['product_id'] = $cartProduct->id; //$cartProduct->cart['product_id'];
// 					$data['products'][$key]['quantity'] = $cartProduct->cart['quantity'];
// 					$data['products'][$key]['color_id'] = $cartProduct->cart['color_id'];
// 					$data['products'][$key]['special_event_id'] = (isset($cartProduct->cart['special_event_id']) ? $cartProduct->cart['special_event_id'] : '0');
// 					$data['products'][$key]['amount'] = $cartProduct->sale_price;

// 					if(!$cartProduct->free_shipping && $cartProduct->shipping_cost){
// 						$data['products'][$key]['shipping_amount'] = $cartProduct->shipping_cost;;
// 					}
// 					else{
// 						$data['products'][$key]['shipping_amount'] = 0;
// 					}

// 					//pwp price
// 					if (isset($cartProduct->pwp_price)) {
// 						$data['products'][$key]['pwp_price'] = $cartProduct->pwp_price;
// 					}

// 					//Discount
// 					$data['products'][$key]['quantity_discount'] = $cartProduct->cart['quantityDiscount'];
// 					$data['products'][$key]['global_discount'] = $cartProduct->cart['globalDiscount'];
// 					$data['products'][$key]['promo_code_discount'] = $cartProduct->cart['promocodeDiscount'];

// 					$discount += ($cartProduct->cart['quantityDiscount'] * $cartProduct->cart['quantity']) + $cartProduct->cart['globalDiscount'] + $cartProduct->cart['promocodeDiscount'];
// 				}

// 				if($promocode){
// 					$data['promocode_id'] = $promocode['promocode']->id;
// 				}
// 				else{
// 					$data['promocode_id'] = 0;
// 				}

// 				$data['totalPrice'] = ($cartProducts['totalPrice'] + $cartProducts['shippingTotal'] - $discount);
// 				$data['discount'] = $discount;

// 				$orderId = $this->CheckoutModel->addOrder($data);
// 				Session::put('orderId', $orderId);

// /*
// 	//Send invoice
// //	$order = $this->CheckoutModel->getOrderByRefNo($refno);
// 	$order = $this->CheckoutModel->getOrder($orderId);
// 	$orderToProduct = $this->CheckoutModel->getOrderToProduct($order->id);

// 	$invoice = array(
// 		'order' 			=> $order,
// 		'order_to_products'	=> $orderToProduct
// 	);

// 	$messageData = [
// 		'fromEmail' 			=> 'shop@tbm.com.my',
// 		'fromName' 				=> 'TBMonline',
// 		'toEmail' 				=> $order->billing_email,
// 		'toName' 				=> $order->billing_first_name . ' ' . $order->billing_last_name,
// 		'subject'				=> 'TBM::Order #' . $order->order_id
// 	];

// $view = view('invoice.invoice-html', $invoice);
// //dd($_SERVER);
// echo $view;
// exit;
// 	Mail::send('invoice.invoice-html', $invoice, function ($message) use ($messageData) {
// 		$message->from($messageData['fromEmail'], $messageData['fromName']);
// 		$message->to($messageData['toEmail'], $messageData['toName']);
// 		$message->subject($messageData['subject']);
// 	});
// 	//End
// */

// 				return redirect('/checkout/payment');
// 			}
// 		}

// 		$this->data['success'] = Session::get('checkout.success');
// 		Session::forget('checkout.success');

// 		$this->data['warning'] = Session::get('checkout.warning');
// 		Session::forget('checkout.warning');
// 		//Session::put('userId', 1);
// 		if(Session::get('userId')){
// 			//Put user
// 			$customer = DB::table('customers')->where('id', Session::get('userId'))->first();
// 			$this->data['customer'] = $customer;
// 			//End

// 			$CountriesModel = new Countries();
// 			$this->data['countries'] = $CountriesModel->getCountries();

// 			$this->data['billing_states'] = array();
// 			$this->data['shipping_states'] = array();

// 			if($customer->billing_country){
// 				$this->data['billing_states'] = $CountriesModel->getStatesByCountry($customer->billing_country);
// 			}
// 			if($customer->shipping_country){
// 				$this->data['shipping_states'] = $CountriesModel->getStatesByCountry($customer->shipping_country);
// 			}
// 		}

// 		$this->data['isUserLogin'] = Session::has('userId');
// 		$cartProducts = $this->ProductsModel->getCartProducts($cart, $promocode);

// 		if(!$cartProducts){
// 			return redirect('/');
// 		}

// 		$this->data['cartProducts'] = $cartProducts;

// 		$brands = $this->BrandsModel->getBrands();
// 		$this->data['brands'] = $brands;
// 		$this->data['brands_scroller'] = View::make('front.module.brands', $this->data);

// 		$this->data['page_title'] = 'Checkout';
// 		return view('front.checkout.index',$this->data);
// 	}

	public function payment(){
		$orderId = Session::get('orderId');
		Session::forget('orderId');

		if(!$orderId){
			return redirect('/checkout');
		}

		$orderInfo = $this->CheckoutModel->getOrder($orderId);

		if(!$orderInfo){
			return redirect('/checkout');
		}

		$this->data['sign'] = $this->iPay88_signature('cRFkKfG6nNM07662' . $orderInfo->order_id . str_replace('.','', number_format($orderInfo->totalPrice, 2)). 'MYR');
		$this->data['orderInfo'] = $orderInfo;

		return view('front.checkout.payment',$this->data);
	}

	public function getStates(){
		$CountriesModel = new Countries();
		$json['states'] = $CountriesModel->getStatesByCountry(Input::get('country_id'));
		return Response::json($json);
	}

	private function iPay88_signature($source) {
	  return base64_encode(hex2bin(sha1($source)));
	}

	private function hex2bin($hexSource)
	{
		for ($i=0;$i<strlen($hexSource);$i=$i+2)
		{
		  $bin .= chr(hexdec(substr($hexSource,$i,2)));
		}
	  return $bin;
	}

	public function successPayment(){
		if (!Request::isMethod('post')){
			return redirect('/');
		}

		//// Response
		$merchantcode = Input::get('MerchantCode');
		$paymentid = Input::get('PaymentId');
		$refno = Input::get('RefNo');
		$amount = Input::get('Amount');
		$ecurrency = Input::get('Currency');
		$remark = Input::get('Remark');
		$transid = Input::get('TransId');
		$authcode = Input::get('AuthCode');
		$estatus = Input::get('Status');
		$errdesc = Input::get('ErrDesc');
		$signature = Input::get('Signature');


		$this->data['success'] = '';
		$this->data['warning'] = '';

		if(Input::get('Status')){
			Session::forget('cart');

			$data = [
				'description'			=> $remark,
				'status'				=> 'New Order',
				'payment_status'		=> 'Paid',
				'transaction_id'		=> $transid,
				'payment_method'		=> ''
			];

			$this->CheckoutModel->updateOrderByRefNo($refno, $data);

			//Send invoice
			$order = $this->CheckoutModel->getOrderByRefNo($refno);
			$orderToProduct = $this->CheckoutModel->getOrderToProduct($order->id);

			$invoice = array(
				'order' 			=> $order,
				'order_to_products'	=> $orderToProduct
			);

			$messageData = [
				'fromEmail' 			=> 'shop@tbm.com.my',
				'fromName' 				=> 'TBMonline',
				'toEmail' 				=> $order->billing_email,
				'toName' 				=> $order->billing_first_name . ' ' . $order->billing_last_name,
				'subject'				=> 'TBM::Order #' . $order->order_id
			];

			Mail::send('invoice.invoice-html', $invoice, function ($message) use ($messageData) {
				$message->from($messageData['fromEmail'], $messageData['fromName']);
				$message->to($messageData['toEmail'], $messageData['toName']);
				$message->subject($messageData['subject']);
			});
			//End

			Session::put('checkout.refno', $refno);
			Session::put('checkout.success', '<strong>Thank you!</strong> Your order has been received. We are now processing your order and you will receive the goods in 3-5 business working days.');
			return redirect('/checkout/orderConfirmation');
		}
		else{
			$data = [
				'description'			=> $errdesc,
				'status'				=> 'Declined',
				'payment_status'		=> 'Payment Error',
			];
			$this->CheckoutModel->updateOrderByRefNo($refno, $data);

			Session::put('checkout.warning', '<strong>Sorry!</strong> Your order was declined because ' . $errdesc . '.');
			return redirect('/checkout');
		}
	}

	public function failPayment(){

	}

	public function orderConfirmation(){
		if (!Session::has('checkout.refno')){
			return redirect('/');
		}

		$refno = Session::get('checkout.refno');

		$this->data['success'] = Session::get('checkout.success');
		Session::forget('checkout.success');

		$orderInfo = $this->CheckoutModel->getOrderByRefNo($refno);

		$this->data['orderInfo'] = $orderInfo;
		$this->data['orderProducts'] = $this->CheckoutModel->getOrderToProduct($orderInfo->id);

		$brands = $this->BrandsModel->getBrands();
		$this->data['brands'] = $brands;
		$this->data['brands_scroller'] = View::make('front.module.brands', $this->data);

		$this->data['page_title'] = 'Order Confirmation';

		return view('front.checkout.order-confirmation', $this->data);
	}
}
