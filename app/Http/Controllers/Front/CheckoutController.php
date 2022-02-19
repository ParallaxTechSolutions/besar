<?php namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Http\Models\Front\Product;
use App\Http\Models\Admin\Promotion;
use App\Http\Models\Countries;
use App\Http\Models\Front\Checkout;
use App\Http\Models\Front\Brands;
use App\notification;
use Session;
use Input;
use Illuminate\Http\RedirectResponse;
use Auth;
use Log;
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

    public function __construct(\Illuminate\Routing\Route $route)
    {
        $this->ProductsModel = new Product();
        $this->CheckoutModel = new Checkout();
        $this->BrandsModel = new Brands();
        $this->PromotionModel = new Promotion();

        Log::debug($route->getActionName());
    }

    function index(){
        //

        $gst = DB::table('gst_rates')->first();
        Session::put('gst',$gst);
        Session::forget('already');
        Session::forget('payment');
        Session::forget('payment_id');
        //

        //echo "<pre>"; print_r(Session::all()); die;

        $cart = Session::get('cart');
        // echo '<pre>';print_r($cart);echo '</pre>';
        Session::put('new_cart', $cart);
        $this->data['cart'] = $cart == null?array():$cart;
        
        $total = 0;
        $discount = 0;
        if(!isset($cart['product'])){
             return redirect('/'); 
        }

        $tax = 0;
        foreach ($cart['product'] as $key => $value) {
            $total += $value['sale_price']*$value['qty'];
            $discount += $value['off']*$value['qty'];
            if($value['is_tax'] == 1){
                $tax += ($total*$cart['tax_rate']/100);
            }
        }

        $product_details = null;
        $packages = [];

        if(isset($cart['product'][0]['product_id'])){
            $product_details = DB::table('products')->where('id',$cart['product'][0]['product_id'])->first();
            $propertyName=DB::table('property')->where('property_id',$cart['product'][0]['product_id'])->pluck('name');
            $packages = DB::table('product_to_quantity_discount')->where('product_id',$cart['product'][0]['product_id'])->get();
            Session::put('propertyName',$propertyName);
        }

        $this->data['promo'] =($cart['promocode_id']) ? $this->ProductsModel->getDiscount(Session::get('_token'), $cart['product'][0]['product_id']):'';

        $this->data['discount'] = $discount;
        $this->data['warning'] = Session::get('checkout.warning');
        $this->data['isUserLogin'] = Session::has('userId');
        $this->data['tax'] = $tax;
        $this->data['page_title'] = 'Checkout';
        $this->data['orderInfo'] = DB::table("customers")->where("id",Session::get('userId'))->first();
        $this->data['orderId'] =  rand(1,100);
        $this->data['product_details'] =  $product_details;
        $this->data['packages'] =  $packages;

        $total_amount = 0;

        foreach ($cart['product'] as $key => $value) {
            $total_amount += $value['sale_price'] * 1;
        }
        
        $total_amount *= $cart['rooms'];

        $finalAmount = number_format((float)(($total_amount - $cart['discount_amount']) + $cart['tax_amount']), 2, '.', '');

        //  $this->data['sign'] = $this->iPay88_signature('IDqHDFhHiQ'.'M07198'. $this->data['orderId'] . str_replace(array('.', ','),'', number_format($cart['final_amount'], 2)). 'MYR');
        $this->data['sign'] = $this->iPay88_signature('IDqHDFhHiQ'.'M07198'. $this->data['orderId'] . str_replace(array('.', ','),'', number_format($finalAmount, 2)). 'MYR');

        //  $this->data['sign'] = $this->iPay88_signature('QQXMtHhkyL'.'M14638'. $this->data['orderId'] . str_replace(array('.', ','),'', number_format($finalAmount, 2)). 'MYR');
        $this->data['cart']['tax_name'] = $gst->name;

        //nol
        // dd($this->data);exit();

        return view('front.checkout.index',$this->data);
    }

    public function addOrderIpay88(){
        $cart = Session::get('cart');
        $estimateShipping = Session::get('estimateShipping');
        $promocode = Session::get('promocode');
        $cart_info =  Session::get('cart');
        if (!$cart){
            return redirect('/');
        }
        if(Session::has('creditCard')){
            Session::put('creditCard','-1');
        }

        $this->data['errors'] = false;
        $data['customer_id'] = Session::get('userId');
                $customer_details = DB::table("customers")->where("id",Session::get('userId'))->first();

                $data['billing_first_name'] = $customer_details->billing_first_name;
                $data['billing_last_name'] = $customer_details->billing_last_name;
                $data['billing_email'] = $customer_details->billing_email;
                $data['billing_telephone'] = $customer_details->billing_telephone;
                $data['billing_country'] = $customer_details->billing_country;
                $data['billing_state'] = $customer_details->billing_state;
                $data['billing_address'] = $customer_details->billing_address;
                $data['billing_city'] = $customer_details->billing_city;
                $data['billing_post_code'] = $customer_details->billing_post_code;

                $data['shipping_first_name'] = $customer_details->shipping_first_name;
                $data['shipping_last_name'] = $customer_details->shipping_last_name;
                $data['shipping_email'] = $customer_details->shipping_email;
                $data['shipping_telephone'] = $customer_details->shipping_telephone;
                $data['shipping_country'] = $customer_details->shipping_country;
                $data['shipping_state'] = $customer_details->shipping_state;
                $data['shipping_address'] = $customer_details->shipping_address;
                $data['shipping_city'] = $customer_details->shipping_city;
                $data['shipping_post_code'] = $customer_details->shipping_post_code;
                $data['payment_method'] = "IPAY88";

                $data['ota_checklist_id'] = isset($cart['ota_checklist_id']) ? $cart['ota_checklist_id'] : 0;

                //Add Estimate Shipping
                if (isset($estimateShipping['shipping_method']) && $estimateShipping['shipping_method'] != '') {
                    $data['shipping_method'] = $estimateShipping['shipping_method'];
                } elseif (Session::has('default_ship')) {
                    $data['shipping_method'] = Session::get('default_ship');
                }

                //save shipping charge
                if (Session::has('shipping_charge')) {
                    $data['shipping_charge'] = Session::get('shipping_charge');
                } else {
                    $data['shipping_charge'] = 0;
                }

                //save order total weight
                if ($cart_info !== false) {
                    //$data['total_weight'] = $cart_info['total_weight'];
                }
                $data['shipping_estimate_country'] = (isset($estimateShipping['country']) ? $estimateShipping['country'] : '');
                $data['shipping_estimate_state'] = (isset($estimateShipping['state']) ? $estimateShipping['state'] : '');
                // dd($cart);
                //Update customer
                //$this->CheckoutModel->updateCustomer(Session::get('userId'), $data);
                //end

                $cartProducts = $this->ProductsModel->getCartProducts($cart, $promocode);

                 // echo "<pre>";
                // print_r($cartProducts);
                // echo "Hello";exit;

                $discount = 0;
                foreach($cartProducts['products'] as $key => $cartProduct){
                    $data['products'][$key]['product_id'] = $cartProduct->id; //$cartProduct->cart['product_id'];
                    $data['products'][$key]['quantity'] = $cartProduct->cart['qty'];
                    $data['products'][$key]['color_id'] = isset($cartProduct->cart['color_id']) ? $cartProduct->cart['color_id'] : '';
                    $data['products'][$key]['special_event_id'] = (isset($cartProduct->cart['special_event_id']) ? $cartProduct->cart['special_event_id'] : '0');
                    
                    if($data['ota_checklist_id']) {
                        $data['products'][$key]['amount'] = $cartProduct->cart['sale_price'];
                    } else {
                        $data['products'][$key]['amount'] = $cartProduct->sale_price;
                    }

                    if(!$cartProduct->free_shipping && $cartProduct->shipping_cost){
                        $data['products'][$key]['shipping_amount'] = $cartProduct->shipping_cost;;
                    }
                    else{
                        $data['products'][$key]['shipping_amount'] = 0;
                    }

                    //pwp price
                    if (isset($cartProduct->pwp_price)) {
                        $data['products'][$key]['pwp_price'] = $cartProduct->pwp_price;
                    }
                    $data['products'][$key]['date_checkin'] = $cartProduct->cart['date_checkin'];
                    $data['products'][$key]['date_checkout'] = $cartProduct->cart['date_checkout'];
                    //Discount
                    $data['products'][$key]['quantity_discount'] = $cartProduct->cart['quantityDiscount'];
                    $data['products'][$key]['global_discount'] = $cartProduct->cart['globalDiscount'];
                    $data['products'][$key]['promo_code_discount'] = $cartProduct->cart['promocodeDiscount'];

                    $discount += ($cartProduct->cart['quantityDiscount'] * $cartProduct->cart['qty']) + $cartProduct->cart['globalDiscount'] + $cartProduct->cart['promocodeDiscount'];

                    // add later data.
                    $data['products'][$key]["product_type"]  = $cartProduct->cart['type'];
                    $data['products'][$key]["product_code"] = $cartProduct->cart['room_code'];
                    $data['products'][$key]["bed"] = $cartProduct->cart['bed'];
                    $data['products'][$key]["guest"] = $cartProduct->cart['guest'];
                    $data['products'][$key]["meal"] = $cartProduct->cart['meal'];
                    $data['products'][$key]["promo_behaviour"] = $cartProduct->cart['promo_behaviour'];
                    $data['products'][$key]["product_thumb"] = $cartProduct->cart['thumbnail_image_1'];


                }

                if($promocode){
                    $data['promocode_id'] = $promocode['promocode']->id;
                }
                else{
                    $data['promocode_id'] = 0;
                }


               $total_amount = 0;

               foreach ($cart['product'] as $key => $value) {
                  $total_amount += $value['sale_price'] * 1;
               }

               $total_amount *= $cart['rooms'];

               // $finalAmount = number_format((float)(($total_amount - $cart['discount_amount']) + $cart['tax_amount']), 2, '.', '');

                $finalAmount = ($total_amount - $cart['discount_amount']) + $cart['tax_amount'];
                // dump($cart);
                // dump($cartProducts);
                // dd($cartProducts['products'][0]->id);

            //  $data['totalPrice'] = ($cart_info['final_amount']);
                // $data['totalPrice'] = (number_format($finalAmount, 2));
                $data['totalPrice'] = $finalAmount; //(number_format($finalAmount, 2));
                $data['discount'] = $cart['discount_amount'];
                $data['room'] = $cartProducts['rooms'];
                $data['adults'] = $cartProducts['adults'];
                $data['children'] = $cartProducts['children'];
                $data["total_weight"] = '';
                $data["tax_rate"] = Session::get('tax_rate')? Session::get('tax_rate'): $cart['tax_rate'];
                $data["special_requests"] = $cart['special_requests'];
                
                // add later data.
                // $data["product_type"]  = $cartProducts['products'][0]->type;
                // $data["product_code"] = $cartProducts['products'][0]->room_code;
                // $data["bed"] = $cartProducts['products'][0]->bed;
                // $data["guest"] = $cartProducts['products'][0]->guest;
                // $data["meal"] = $cartProducts['products'][0]->meal;
                // $data["promo_behaviour"] = $cartProducts['products'][0]->promo_behaviour;
                // $data["product_thumb"] = $cartProducts['products'][0]->thumbnail_image_1;

                //return dd($cart);
                // dd($data);
                $data["tax_name"] = Session::get('tax_name');
                // $data["tax_rate"] = !is_null(Session::get('tax_rate')) && Session::get('tax_rate') ? Session::get('tax_rate'): 0;
                $orderId = $this->CheckoutModel->addOrder($data);
                Session::put('orderId', $orderId);

               $propId=DB::table('products')->where('id',$data['products'][0]['product_id'])->pluck('property_id');
               $prpertyName=DB::table('property')->where('property_id',$propId)->pluck('name');
               /* echo '<pre>';
                print_r($prpertyName);
                exit; */
                Session::put('propertyName',$prpertyName);
                //Send invoice
                //  $order = $this->CheckoutModel->getOrderByRefNo($refno);
                // $order = $this->CheckoutModel->getOrder($orderId);
                // $orderToProduct = $this->CheckoutModel->getOrderToProduct($order->id);

                // $invoice = array(
                //  'order'             => $order,
                //  'order_to_products' => $orderToProduct
                // );

                // $messageData = [
                //  'fromEmail'             => 'registration@ritzgardenhotel.com',
                //  'fromName'              => 'Ritz Garden Hotel Online Booking',
                //  'toEmail'               => $order->billing_email,
                //  'toName'                => $order->billing_first_name . ' ' . $order->billing_last_name,
                //  'subject'               => 'RITZ GARDEN HOTEL::Order #' . $order->order_id
                // ];

                //$view = view('invoice.invoice-html', $invoice);
                //dd($_SERVER);
                // echo $view;
                // exit;
                // Mail::send('invoice.invoice-html', $invoice, function ($message) use ($messageData) {
                    // $message->from($messageData['fromEmail'], $messageData['fromName']);
                    // $message->to($messageData['toEmail'], $messageData['toName']);
                    // $message->subject($messageData['subject']);
                // });
                //End

                 return redirect('/checkout/payment');

    }
    public function addOrderCC(){
        $cart = Session::get('cart');
        $estimateShipping = Session::get('estimateShipping');
        $promocode = Session::get('promocode');
        $cart_info =  Session::get('cart');

        if (!$cart){
            return redirect('/');
        }
        $this->data['errors'] = false;
        $data['customer_id'] = Session::get('userId');
                $customer_details = DB::table("customers")->where("id",Session::get('userId'))->first();

                $data['billing_first_name'] = $customer_details->billing_first_name;
                $data['billing_last_name'] = $customer_details->billing_last_name;
                $data['billing_email'] = $customer_details->billing_email;
                $data['billing_telephone'] = $customer_details->billing_telephone;
                $data['billing_country'] = $customer_details->billing_country;
                $data['billing_state'] = $customer_details->billing_state;
                $data['billing_address'] = $customer_details->billing_address;
                $data['billing_city'] = $customer_details->billing_city;
                $data['billing_post_code'] = $customer_details->billing_post_code;

                $data['shipping_first_name'] = $customer_details->shipping_first_name;
                $data['shipping_last_name'] = $customer_details->shipping_last_name;
                $data['shipping_email'] = $customer_details->shipping_email;
                $data['shipping_telephone'] = $customer_details->shipping_telephone;
                $data['shipping_country'] = $customer_details->shipping_country;
                $data['shipping_state'] = $customer_details->shipping_state;
                $data['shipping_address'] = $customer_details->shipping_address;
                $data['shipping_city'] = $customer_details->shipping_city;
                $data['shipping_post_code'] = $customer_details->shipping_post_code;
                $data['payment_method'] = "Credit Card";
                
                $data['ota_checklist_id'] = isset($cart['ota_checklist_id']) ? $cart['ota_checklist_id'] : 0;

                //Add Estimate Shipping
                if (isset($estimateShipping['shipping_method']) && $estimateShipping['shipping_method'] != '') {
                    $data['shipping_method'] = $estimateShipping['shipping_method'];
                } elseif (Session::has('default_ship')) {
                    $data['shipping_method'] = Session::get('default_ship');
                }

                //save shipping charge
                if (Session::has('shipping_charge')) {
                    $data['shipping_charge'] = Session::get('shipping_charge');
                } else {
                    $data['shipping_charge'] = 0;
                }

                //save order total weight
                if ($cart_info !== false) {
                    //$data['total_weight'] = $cart_info['total_weight'];
                }
                $data['shipping_estimate_country'] = (isset($estimateShipping['country']) ? $estimateShipping['country'] : '');
                $data['shipping_estimate_state'] = (isset($estimateShipping['state']) ? $estimateShipping['state'] : '');
                // dd($cart);
                //Update customer
                //$this->CheckoutModel->updateCustomer(Session::get('userId'), $data);
                //end

                $cartProducts = $this->ProductsModel->getCartProducts($cart, $promocode);

                 // echo "<pre>";
                // print_r($cartProducts);
                // echo "Hello";exit;

                $discount = 0;

                foreach($cartProducts['products'] as $key => $cartProduct){
                    $data['products'][$key]['product_id'] = $cartProduct->id; //$cartProduct->cart['product_id'];
                    $data['products'][$key]['quantity'] = $cartProduct->cart['qty'];
                    $data['products'][$key]['color_id'] = isset($cartProduct->cart['color_id']) ? $cartProduct->cart['color_id'] : '';
                    $data['products'][$key]['special_event_id'] = (isset($cartProduct->cart['special_event_id']) ? $cartProduct->cart['special_event_id'] : '0');
                    
                    if($data['ota_checklist_id']) {
                        $data['products'][$key]['amount'] = $cartProduct->cart['sale_price'];
                    } else {
                        $data['products'][$key]['amount'] = $cartProduct->sale_price;
                    }

                    if(!$cartProduct->free_shipping && $cartProduct->shipping_cost){
                        $data['products'][$key]['shipping_amount'] = $cartProduct->shipping_cost;;
                    }
                    else{
                        $data['products'][$key]['shipping_amount'] = 0;
                    }

                    //pwp price
                    if (isset($cartProduct->pwp_price)) {
                        $data['products'][$key]['pwp_price'] = $cartProduct->pwp_price;
                    }
                    $data['products'][$key]['date_checkin'] = $cartProduct->cart['date_checkin'];
                    $data['products'][$key]['date_checkout'] = $cartProduct->cart['date_checkout'];
                    //Discount
                    $data['products'][$key]['quantity_discount'] = $cartProduct->cart['quantityDiscount'];
                    $data['products'][$key]['global_discount'] = $cartProduct->cart['globalDiscount'];
                    $data['products'][$key]['promo_code_discount'] = $cartProduct->cart['promocodeDiscount'];

                    $discount += ($cartProduct->cart['quantityDiscount'] * $cartProduct->cart['qty']) + $cartProduct->cart['globalDiscount'] + $cartProduct->cart['promocodeDiscount'];

                    // add later data.
                    $data['products'][$key]["product_type"]  = $cartProduct->cart['type'];
                    $data['products'][$key]["product_code"] = $cartProduct->cart['room_code'];
                    $data['products'][$key]["bed"] = $cartProduct->cart['bed'];
                    $data['products'][$key]["guest"] = $cartProduct->cart['guest'];
                    $data['products'][$key]["meal"] = $cartProduct->cart['meal'];
                    $data['products'][$key]["promo_behaviour"] = $cartProduct->cart['promo_behaviour'];
                    $data['products'][$key]["product_thumb"] = $cartProduct->cart['thumbnail_image_1'];


                }

                if($promocode){
                    $data['promocode_id'] = $promocode['promocode']->id;
                }
                else{
                    $data['promocode_id'] = 0;
                }


               $total_amount = 0;

               foreach ($cart['product'] as $key => $value) {
                  $total_amount += $value['sale_price'] * 1;
               }

               $total_amount *= $cart['rooms'];

               // $finalAmount = number_format((float)(($total_amount - $cart['discount_amount']) + $cart['tax_amount']), 2, '.', '');

                $finalAmount = ($total_amount - $cart['discount_amount']) + $cart['tax_amount'];
                $data['totalPrice'] = $finalAmount;
                $data['discount'] = $cart['discount_amount'];
                $data['room'] = $cartProducts['rooms'];
                $data['adults'] = $cartProducts['adults'];
                $data['children'] = $cartProducts['children'];
                $data["total_weight"] = '';
                $data["tax_rate"] = $cart['tax_rate'];
                $data["special_requests"] = $cart['special_requests'];
                /* echo '<pre>';
                print_r($data);
                exit; */
                $data["tax_name"] = Session::get('tax_name');
                // $data["tax_rate"] = Session::get('tax_rate');
                $orderId = $this->CheckoutModel->addOrder($data);
                $usrId=['cus_id'=>Session::get('userId'),'order_id'=>$orderId];

                $ar=array_merge($usrId,$_POST);

                //print_r($ar);
                $x=DB::table('customerBilling')->insert($ar);
                Session::put('orderId', $orderId);
                $cart = Session::get('cart');
                Session::forget('cart');

            $data = [
                'description'           => 'Transaction is processing',
                'status'                => 'New Order',
                'payment_status'        => 'Processing',
                'transaction_id'        => 'Processing',
                'payment_method'        => 'Credit Card'
            ];

            $this->CheckoutModel->updateOrderByRefNoCC($orderId, $data);

            //Send invoice
            $order = $this->CheckoutModel->getOrderByRefNoCC($orderId);
            $orderToProduct = $this->CheckoutModel->getOrderToProduct($order->id);
            /*
            $invoice = array(
                'order'             => $order,
                'order_to_products' => $orderToProduct,
                'billing_info' => array(
                    'bookid'           => $order->id,
            'state' => $state,
            'country' => $country
            ),
            'cart' => $cart
            );*/

                $invoice = array(
                'bookid'=>$order->id,
                'order_to_products' => $orderToProduct
            );
             
            $invoice['cart'] = $cart == null?array():$cart;
            $total = 0;
            $discount = 0;
            // return($invoice);
            foreach ($cart['product'] as $key => $value) {
                $total += $value['sale_price']*$value['qty'];
                $discount += $value['off']*$value['qty'];
            }
            $ProductsModel = new Product();
            $invoice['promo'] = isset($invoice['cart']['product']) && isset($invoice['cart']['product'][0])  && isset($invoice['cart']['product'][0]['product_id']) ? $ProductsModel->getDiscount(Session::get('_token'), $invoice['cart']['product'][0]['product_id']) : (object) array();

           // $invoice['product_details'] = $ProductsModel->find($invoice['cart']['product'][0]['product_id']);
            $product_details = $ProductsModel->find($invoice['cart']['product'][0]['product_id']);

            $invoice['discount'] = $discount;
            $country = (object) array();
            $country->name =  $order->shipping_country_name;
            $state = (object) array();
            $state->name = $order->shipping_state_name;
            $invoice['billing_info'] = array(
                'state' => $state,
                'country' => $country
            );
            $order->check_date = $this->CheckoutModel->getOrderBookingDateByOrderId($order->id);
            if (!is_object($order->check_date)) {
                $order->check_date = (object) array();
            }
            if (!property_exists($order->check_date, 'date_checkout')) {
                $order->check_date->date_checkout = date("YYYY-MM-DD");
                $order->check_date->date_checkin = date("YYYY-MM-DD");
            }
            $invoice['tax_name'] = Session::get('tax_name');
            $invoice['tax_rate'] = $cart['tax_rate']; //Session::get('tax_rate');
            $invoice['order'] = $order;
            $messageData = [
                'fromEmail'             => 'registration@towerregency.com.my',
                'fromName'              => 'Tower Regency Hotel & Apartments Online Booking',
                'toEmail'               => $order->billing_email,
                'toName'                => $order->billing_first_name.' '.$order->billing_last_name,
                'subject'               => 'TOWER REGENCY HOTEL & APARTMENTS::Order #' . $order->id
            ];
            $invoice['propertyName']=DB::table('property')->where('property_id',$product_details['property_id'])->pluck('name');
            $invoice['packages'] = DB::table('product_to_quantity_discount')->where('product_id',$invoice['cart']['product'][0]['product_id'])->get();
            /* echo '<pre>';
            print_r($name);
            exit; */
            $invoice["tax_name"] = Session::get('tax_name');
            $invoice["tax_rate"] = $cart['tax_rate']; //Session::get('tax_rate');
            Mail::send('invoice.invoice-html', $invoice, function ($message) use ($messageData) {
                $message->from($messageData['fromEmail'], $messageData['fromName']);
                $message->to($messageData['toEmail'], $messageData['toName']);
                $message->subject($messageData['subject']);
            });


            $notification = new notification;
            $notificationsArr = $notification->where('actions', 'like', '%new_order_received%')->where('status',1)->get();
            foreach($notificationsArr as $notifications){
                $sentEmailArr = array();
                $emailsArr = explode(',',$notifications->emails);
                foreach($emailsArr as $email){
                    if(!in_array($email, $sentEmailArr)){
                        Mail::send('invoice.admin-invoice-html', $invoice, function ($message) use ($messageData, $email) {
                            $message->from($messageData['fromEmail'], $messageData['fromName']);
                            $message->to($email, 'Admin');
                            $message->subject($messageData['subject']);
                        });
                    }
                }
            }
             $orderInfo = $this->CheckoutModel->getOrderByRefNoCC($orderId);

             $invoice['orderInfo'] = (array)$orderInfo;
             /* print_r($orderInfo);
             exit; */
            //End
            Session::put('creditCard',"Your order status is 'Processing'");
            // Session::put("invoice", $invoice);
            Session::put('checkout.refno', $order->id);
            Session::put('checkout.success', '<strong>Thank you!</strong> Your order has been received. We are now processing your order.');
            Session::put("new_cart", $cart);
            Session::put('propertyName',$invoice['propertyName']);
            Session::put('invoice', $invoice);
            
            return redirect('/checkout/orderConfirmation');
            // return Redirect::route('orderConfirmation3');

                // return redirect('/checkout/payment');

    }
    public function addOrderBank(Request $req){


        $cart = Session::get('cart');
        $estimateShipping = Session::get('estimateShipping');
        $promocode = Session::get('promocode');
        $cart_info =  Session::get('cart');

        if (!$cart){
            return redirect('/');
        }
        $this->data['errors'] = false;
        $data['customer_id'] = Session::get('userId');
                $customer_details = DB::table("customers")->where("id",Session::get('userId'))->first();

                $data['billing_first_name'] = $customer_details->billing_first_name;
                $data['billing_last_name'] = $customer_details->billing_last_name;
                $data['billing_email'] = $customer_details->billing_email;
                $data['billing_telephone'] = $customer_details->billing_telephone;
                $data['billing_country'] = $customer_details->billing_country;
                $data['billing_state'] = $customer_details->billing_state;
                $data['billing_address'] = $customer_details->billing_address;
                $data['billing_city'] = $customer_details->billing_city;
                $data['billing_post_code'] = $customer_details->billing_post_code;

                $data['shipping_first_name'] = $customer_details->shipping_first_name;
                $data['shipping_last_name'] = $customer_details->shipping_last_name;
                $data['shipping_email'] = $customer_details->shipping_email;
                $data['shipping_telephone'] = $customer_details->shipping_telephone;
                $data['shipping_country'] = $customer_details->shipping_country;
                $data['shipping_state'] = $customer_details->shipping_state;
                $data['shipping_address'] = $customer_details->shipping_address;
                $data['shipping_city'] = $customer_details->shipping_city;
                $data['shipping_post_code'] = $customer_details->shipping_post_code;
                $data['payment_method'] = "Credit Card";
                $data['ota_checklist_id'] = isset($cart['ota_checklist_id']) ? $cart['ota_checklist_id'] : 0;

                //Add Estimate Shipping
                if (isset($estimateShipping['shipping_method']) && $estimateShipping['shipping_method'] != '') {
                    $data['shipping_method'] = $estimateShipping['shipping_method'];
                } elseif (Session::has('default_ship')) {
                    $data['shipping_method'] = Session::get('default_ship');
                }

                //save shipping charge
                if (Session::has('shipping_charge')) {
                    $data['shipping_charge'] = Session::get('shipping_charge');
                } else {
                    $data['shipping_charge'] = 0;
                }

                //save order total weight
                if ($cart_info !== false) {
                    //$data['total_weight'] = $cart_info['total_weight'];
                }
                $data['shipping_estimate_country'] = (isset($estimateShipping['country']) ? $estimateShipping['country'] : '');
                $data['shipping_estimate_state'] = (isset($estimateShipping['state']) ? $estimateShipping['state'] : '');
                // dd($cart);
                //Update customer
                //$this->CheckoutModel->updateCustomer(Session::get('userId'), $data);
                //end

                $cartProducts = $this->ProductsModel->getCartProducts($cart, $promocode);

                 // echo "<pre>";
                // print_r($cartProducts);
                // echo "Hello";exit;

                $discount = 0;

                foreach($cartProducts['products'] as $key => $cartProduct){
                    $data['products'][$key]['product_id'] = $cartProduct->id; //$cartProduct->cart['product_id'];
                    $data['products'][$key]['quantity'] = $cartProduct->cart['qty'];
                    $data['products'][$key]['color_id'] = isset($cartProduct->cart['color_id']) ? $cartProduct->cart['color_id'] : '';
                    $data['products'][$key]['special_event_id'] = (isset($cartProduct->cart['special_event_id']) ? $cartProduct->cart['special_event_id'] : '0');
                    
                    if($data['ota_checklist_id']) {
                        $data['products'][$key]['amount'] = $cartProduct->cart['sale_price'];
                    } else {
                        $data['products'][$key]['amount'] = $cartProduct->sale_price;
                    }

                    if(!$cartProduct->free_shipping && $cartProduct->shipping_cost){
                        $data['products'][$key]['shipping_amount'] = $cartProduct->shipping_cost;;
                    }
                    else{
                        $data['products'][$key]['shipping_amount'] = 0;
                    }

                    //pwp price
                    if (isset($cartProduct->pwp_price)) {
                        $data['products'][$key]['pwp_price'] = $cartProduct->pwp_price;
                    }
                    $data['products'][$key]['date_checkin'] = $cartProduct->cart['date_checkin'];
                    $data['products'][$key]['date_checkout'] = $cartProduct->cart['date_checkout'];
                    //Discount
                    $data['products'][$key]['quantity_discount'] = $cartProduct->cart['quantityDiscount'];
                    $data['products'][$key]['global_discount'] = $cartProduct->cart['globalDiscount'];
                    $data['products'][$key]['promo_code_discount'] = $cartProduct->cart['promocodeDiscount'];

                    $discount += ($cartProduct->cart['quantityDiscount'] * $cartProduct->cart['qty']) + $cartProduct->cart['globalDiscount'] + $cartProduct->cart['promocodeDiscount'];

                    // add later data.
                    $data['products'][$key]["product_type"]  = $cartProduct->cart['type'];
                    $data['products'][$key]["product_code"] = $cartProduct->cart['room_code'];
                    $data['products'][$key]["bed"] = $cartProduct->cart['bed'];
                    $data['products'][$key]["guest"] = $cartProduct->cart['guest'];
                    $data['products'][$key]["meal"] = $cartProduct->cart['meal'];
                    $data['products'][$key]["promo_behaviour"] = $cartProduct->cart['promo_behaviour'];
                    $data['products'][$key]["product_thumb"] = $cartProduct->cart['thumbnail_image_1'];


                }

                if($promocode){
                    $data['promocode_id'] = $promocode['promocode']->id;
                }
                else{
                    $data['promocode_id'] = 0;
                }


               $total_amount = 0;

               foreach ($cart['product'] as $key => $value) {
                  $total_amount += $value['sale_price'] * 1;
               }

               $total_amount *= $cart['rooms'];

               // $finalAmount = number_format((float)(($total_amount - $cart['discount_amount']) + $cart['tax_amount']), 2, '.', '');

                $finalAmount = ($total_amount - $cart['discount_amount']) + $cart['tax_amount'];
                $data['totalPrice'] = $finalAmount;
                $data['discount'] = $cart['discount_amount'];
                $data['room'] = $cartProducts['rooms'];
                $data['adults'] = $cartProducts['adults'];
                $data['children'] = $cartProducts['children'];
                $data["total_weight"] = '';
                $data["tax_rate"] = $cart['tax_rate'];
                $data["special_requests"] = $cart['special_requests'];
                $data["tax_name"] = Session::get('tax_name');
                // $data["tax_rate"] = Session::get('tax_rate');
                
                $orderId = $this->CheckoutModel->addOrder($data);
                Session::put('orderId', $orderId);
                $cart = Session::get('cart');
            Session::forget('cart');

            $data = [
                'description'           => 'Transaction is processing',
                'status'                => 'New Order',
                'payment_status'        => 'Processing',
                'transaction_id'        => 'processing',
                'payment_method'        => 'Bank Transfer'
            ];

            $this->CheckoutModel->updateOrderByRefNoCC($orderId, $data);

            //Send invoice
            $order = $this->CheckoutModel->getOrderByRefNoCC($orderId);
            $orderToProduct = $this->CheckoutModel->getOrderToProduct($order->id);
            /*
            $invoice = array(
                'order'             => $order,
                'order_to_products' => $orderToProduct,
                'billing_info' => array(
                    'bookid'           => $order->id,
            'state' => $state,
            'country' => $country
            ),
            'cart' => $cart
            );*/

                $invoice = array(
                'bookid'=>$order->id,
                'order_to_products' => $orderToProduct
            );

            $invoice['cart'] = $cart == null?array():$cart;
            $total = 0;
            $discount = 0;
            // return($invoice);
            foreach ($cart['product'] as $key => $value) {
                $total += $value['sale_price']*$value['qty'];
                $discount += $value['off']*$value['qty'];
            }
            $ProductsModel = new Product();
            $invoice['promo'] = isset($invoice['cart']['product']) && isset($invoice['cart']['product'][0])  && isset($invoice['cart']['product'][0]['product_id']) ? $ProductsModel->getDiscount(Session::get('_token'), $invoice['cart']['product'][0]['product_id']) : (object) array();

            $product_details = $ProductsModel->find($invoice['cart']['product'][0]['product_id']);

            $invoice['discount'] = $discount;
            $country = (object) array();
            $country->name =  $order->shipping_country_name;
            $state = (object) array();
            $state->name = $order->shipping_state_name;
            $invoice['billing_info'] = array(
                'state' => $state,
                'country' => $country
            );
            $order->check_date = $this->CheckoutModel->getOrderBookingDateByOrderId($order->id);
            if (!is_object($order->check_date)) {
                $order->check_date = (object) array();
            }
            if (!property_exists($order->check_date, 'date_checkout')) {
                $order->check_date->date_checkout = date("YYYY-MM-DD");
                $order->check_date->date_checkin = date("YYYY-MM-DD");
            }

            $invoice['order'] = $order;
            $cart['tax_name'] = Session::get('tax_name');
            $messageData = [
                'fromEmail'             => 'registration@towerregency.com.my',
                'fromName'              => 'Tower Regency Hotel & Apartments Online Booking',
                'toEmail'               => $order->billing_email,
                'toName'                => $order->billing_first_name.' '.$order->billing_last_name,
                'subject'               => 'TOWER REGENCY HOTEL & APARTMENTS::Order #' . $order->id
            ];
            $invoice['propertyName']=DB::table('property')->where('property_id',$product_details['property_id'])->pluck('name');
            $invoice['packages'] = DB::table('product_to_quantity_discount')->where('product_id',$invoice['cart']['product'][0]['product_id'])->get();
            /* echo '<pre>';
            print_r($name);
            exit; */
            $invoice["tax_name"] = Session::get('tax_name');
            $invoice["tax_rate"] = Session::get('tax_rate');
            Mail::send('invoice.invoice-html', $invoice, function ($message) use ($messageData) {
                $message->from($messageData['fromEmail'], $messageData['fromName']);
                $message->to($messageData['toEmail'], $messageData['toName']);
                $message->subject($messageData['subject']);
            });

            
            $notification = new notification;
            $notificationsArr = $notification->where('actions', 'like', '%new_order_received%')->where('status',1)->get();
            foreach($notificationsArr as $notifications){
                $sentEmailArr = array();
                $emailsArr = explode(',',$notifications->emails);
                foreach($emailsArr as $email){
                    if(!in_array($email, $sentEmailArr)){
                        Mail::send('invoice.admin-invoice-html', $invoice, function ($message) use ($messageData, $email) {
                            $message->from($messageData['fromEmail'], $messageData['fromName']);
                            $message->to($email, 'Admin');
                            $message->subject($messageData['subject']);
                        });
                    }
                }
            }
             $orderInfo = $this->CheckoutModel->getOrderByRefNoCC($orderId);

             $invoice['orderInfo'] = (array)$orderInfo;
             /* print_r($orderInfo);
             exit; */
            //End
            Session::put('creditCard',"Your order status is 'Processing'");
            Session::put("invoice", $invoice);
            Session::put('checkout.refno', $order->id);
            Session::put('checkout.success', '<strong>Thank you!</strong> Your order has been received. We are now processing your order.');
            Session::put("new_cart", $cart);
            Session::put('propertyName',$invoice['propertyName']);
            Session::put('invoice', $invoice);



            return redirect('/checkout/orderConfirmation');
            // return Redirect::route('orderConfirmation3');

                // return redirect('/checkout/payment');

    }
    public function addOrdereGHL(){
        $cart = Session::get('cart');
        $estimateShipping = Session::get('estimateShipping');
        $promocode = Session::get('promocode');
        $cart_info =  Session::get('cart');

        if (!$cart){
            return redirect('/');
        }
        if(Session::has('creditCard')){
            Session::put('creditCard','-1');
        }
        $this->data['errors'] = false;
        $data['customer_id'] = Session::get('userId');
                $customer_details = DB::table("customers")->where("id",Session::get('userId'))->first();

                $data['billing_first_name'] = $customer_details->billing_first_name;
                $data['billing_last_name'] = $customer_details->billing_last_name;
                $data['billing_email'] = $customer_details->billing_email;
                $data['billing_telephone'] = $customer_details->billing_telephone;
                $data['billing_country'] = $customer_details->billing_country;
                $data['billing_state'] = $customer_details->billing_state;
                $data['billing_address'] = $customer_details->billing_address;
                $data['billing_city'] = $customer_details->billing_city;
                $data['billing_post_code'] = $customer_details->billing_post_code;

                $data['shipping_first_name'] = $customer_details->shipping_first_name;
                $data['shipping_last_name'] = $customer_details->shipping_last_name;
                $data['shipping_email'] = $customer_details->shipping_email;
                $data['shipping_telephone'] = $customer_details->shipping_telephone;
                $data['shipping_country'] = $customer_details->shipping_country;
                $data['shipping_state'] = $customer_details->shipping_state;
                $data['shipping_address'] = $customer_details->shipping_address;
                $data['shipping_city'] = $customer_details->shipping_city;
                $data['shipping_post_code'] = $customer_details->shipping_post_code;
                $data['payment_method'] = "eGHL";

                $data['ota_checklist_id'] = isset($cart['ota_checklist_id']) ? $cart['ota_checklist_id'] : 0;

                //Add Estimate Shipping
                if (isset($estimateShipping['shipping_method']) && $estimateShipping['shipping_method'] != '') {
                    $data['shipping_method'] = $estimateShipping['shipping_method'];
                } elseif (Session::has('default_ship')) {
                    $data['shipping_method'] = Session::get('default_ship');
                }

                //save shipping charge
                if (Session::has('shipping_charge')) {
                    $data['shipping_charge'] = Session::get('shipping_charge');
                } else {
                    $data['shipping_charge'] = 0;
                }

                //save order total weight
                if ($cart_info !== false) {
                    //$data['total_weight'] = $cart_info['total_weight'];
                }
                $data['shipping_estimate_country'] = (isset($estimateShipping['country']) ? $estimateShipping['country'] : '');
                $data['shipping_estimate_state'] = (isset($estimateShipping['state']) ? $estimateShipping['state'] : '');
                // dd($cart);
                //Update customer
                //$this->CheckoutModel->updateCustomer(Session::get('userId'), $data);
                //end

                $cartProducts = $this->ProductsModel->getCartProducts($cart, $promocode);

                 // echo "<pre>";
                // print_r($cartProducts);
                // echo "Hello";exit;

                $discount = 0;

                foreach($cartProducts['products'] as $key => $cartProduct){
                    $data['products'][$key]['product_id'] = $cartProduct->id; //$cartProduct->cart['product_id'];
                    $data['products'][$key]['quantity'] = $cartProduct->cart['qty'];
                    $data['products'][$key]['color_id'] = isset($cartProduct->cart['color_id']) ? $cartProduct->cart['color_id'] : '';
                    $data['products'][$key]['special_event_id'] = (isset($cartProduct->cart['special_event_id']) ? $cartProduct->cart['special_event_id'] : '0');
                    
                    if($data['ota_checklist_id']) {
                        $data['products'][$key]['amount'] = $cartProduct->cart['sale_price'];
                    } else {
                        $data['products'][$key]['amount'] = $cartProduct->sale_price;
                    }

                    if(!$cartProduct->free_shipping && $cartProduct->shipping_cost){
                        $data['products'][$key]['shipping_amount'] = $cartProduct->shipping_cost;;
                    }
                    else{
                        $data['products'][$key]['shipping_amount'] = 0;
                    }

                    //pwp price
                    if (isset($cartProduct->pwp_price)) {
                        $data['products'][$key]['pwp_price'] = $cartProduct->pwp_price;
                    }
                    $data['products'][$key]['date_checkin'] = $cartProduct->cart['date_checkin'];
                    $data['products'][$key]['date_checkout'] = $cartProduct->cart['date_checkout'];
                    //Discount
                    $data['products'][$key]['quantity_discount'] = $cartProduct->cart['quantityDiscount'];
                    $data['products'][$key]['global_discount'] = $cartProduct->cart['globalDiscount'];
                    $data['products'][$key]['promo_code_discount'] = $cartProduct->cart['promocodeDiscount'];

                    $discount += ($cartProduct->cart['quantityDiscount'] * $cartProduct->cart['qty']) + $cartProduct->cart['globalDiscount'] + $cartProduct->cart['promocodeDiscount'];

                    // add later data.
                    $data['products'][$key]["product_type"]  = $cartProduct->cart['type'];
                    $data['products'][$key]["product_code"] = $cartProduct->cart['room_code'];
                    $data['products'][$key]["bed"] = $cartProduct->cart['bed'];
                    $data['products'][$key]["guest"] = $cartProduct->cart['guest'];
                    $data['products'][$key]["meal"] = $cartProduct->cart['meal'];
                    $data['products'][$key]["promo_behaviour"] = $cartProduct->cart['promo_behaviour'];
                    $data['products'][$key]["product_thumb"] = $cartProduct->cart['thumbnail_image_1'];


                }

                if($promocode){
                    $data['promocode_id'] = $promocode['promocode']->id;
                }
                else{
                    $data['promocode_id'] = 0;
                }


               $total_amount = 0;

               foreach ($cart['product'] as $key => $value) {
                  $total_amount += $value['sale_price'] * 1;
               }

               $total_amount *= $cart['rooms'];

               // $finalAmount = number_format((float)(($total_amount - $cart['discount_amount']) + $cart['tax_amount']), 2, '.', '');

                $finalAmount = ($total_amount - $cart['discount_amount']) + $cart['tax_amount'];
                // dump($cart);
                // dump($cartProducts);
                // dd($cartProducts['products'][0]->id);

            //  $data['totalPrice'] = ($cart_info['final_amount']);
                // $data['totalPrice'] = (number_format($finalAmount, 2));
                $data['totalPrice'] = $finalAmount; //(number_format($finalAmount, 2));
                $data['discount'] = $cart['discount_amount'];
                $data['room'] = $cartProducts['rooms'];
                $data['adults'] = $cartProducts['adults'];
                $data['children'] = $cartProducts['children'];
                $data["total_weight"] = '';
                $data["tax_rate"] = $cart['tax_rate'];
                $data["special_requests"] = $cart['special_requests'];

                // add later data.
                // $data["product_type"]  = $cartProducts['products'][0]->type;
                // $data["product_code"] = $cartProducts['products'][0]->room_code;
                // $data["bed"] = $cartProducts['products'][0]->bed;
                // $data["guest"] = $cartProducts['products'][0]->guest;
                // $data["meal"] = $cartProducts['products'][0]->meal;
                // $data["promo_behaviour"] = $cartProducts['products'][0]->promo_behaviour;
                // $data["product_thumb"] = $cartProducts['products'][0]->thumbnail_image_1;

                //return dd($cart);
                // dd($data);
                $data["tax_name"] = Session::get('tax_name');
                // $data["tax_rate"] = Session::get('tax_rate');
                $orderId = $this->CheckoutModel->addOrder($data);
                Session::put('orderId', $orderId);


                //Send invoice
                //  $order = $this->CheckoutModel->getOrderByRefNo($refno);
                // $order = $this->CheckoutModel->getOrder($orderId);
                // $orderToProduct = $this->CheckoutModel->getOrderToProduct($order->id);

                // $invoice = array(
                //  'order'             => $order,
                //  'order_to_products' => $orderToProduct
                // );

                // $messageData = [
                //  'fromEmail'             => 'registration@ritzgardenhotel.com',
                //  'fromName'              => 'Ritz Garden Hotel Online Booking',
                //  'toEmail'               => $order->billing_email,
                //  'toName'                => $order->billing_first_name . ' ' . $order->billing_last_name,
                //  'subject'               => 'RITZ GARDEN HOTEL::Order #' . $order->order_id
                // ];

                //$view = view('invoice.invoice-html', $invoice);
                //dd($_SERVER);
                // echo $view;
                // exit;
                // Mail::send('invoice.invoice-html', $invoice, function ($message) use ($messageData) {
                    // $message->from($messageData['fromEmail'], $messageData['fromName']);
                    // $message->to($messageData['toEmail'], $messageData['toName']);
                    // $message->subject($messageData['subject']);
                // });
                //End

                 return redirect('/checkout/paymenteGHL');

    }
    /* public function creditCard(){
        $usrId=['cus_id'=>Session::get('userId')];
        $ar=array_merge($usrId,$_GET);

        //print_r($ar);
       $x=DB::table('customerBilling')->insert($ar);
       if($x){
           echo 'Success';
       }
       else{
           echo 'not Success';
       }

    } */
    /*function index()
    {
        $cart = Session::get('cart');
        $estimateShipping = Session::get('estimateShipping');
        $promocode = Session::get('promocode');
        $cart_info = Helper::getCartInfo();

        if (!$cart){
            return redirect('/');
        }

        $this->data['errors'] = false;

        if (Request::isMethod('post'))
        {
            $validation['billing_first_name'] = 'required';
            $validation['billing_last_name'] = 'required';
            $validation['billing_email'] = 'required|email';
            $validation['billing_telephone'] = 'required';
            $validation['billing_country'] = 'required';
            //$validation['billing_state'] = 'required';
            $validation['billing_address'] = 'required';
            $validation['billing_city'] = 'required';
            $validation['billing_post_code'] = 'required';

            $validation['shipping_first_name'] = 'required';
            $validation['shipping_last_name'] = 'required';
            $validation['shipping_email'] = 'required|email';
            $validation['shipping_telephone'] = 'required';
            $validation['shipping_country'] = 'required';
            //$validation['shipping_state'] = 'required';
            $validation['shipping_address'] = 'required';
            $validation['shipping_city'] = 'required';
            $validation['shipping_post_code'] = 'required';
            $validation['payment_method'] = 'required';

            $validator = Validator::make(Request::all(), $validation);

            if ($validator->fails()) {
                $this->data['errors'] = $validator->errors('<p>:message</p>')->all();
            }
            else
            {
                $data['customer_id'] = Session::get('userId');

                $data['billing_first_name'] = Input::get('billing_first_name');
                $data['billing_last_name'] = Input::get('billing_last_name');
                $data['billing_email'] = Input::get('billing_email');
                $data['billing_telephone'] = Input::get('billing_telephone');
                $data['billing_country'] = Input::get('billing_country');
                $data['billing_state'] = Input::get('billing_state');
                $data['billing_address'] = Input::get('billing_address');
                $data['billing_city'] = Input::get('billing_city');
                $data['billing_post_code'] = Input::get('billing_post_code');

                $data['shipping_first_name'] = Input::get('shipping_first_name');
                $data['shipping_last_name'] = Input::get('shipping_last_name');
                $data['shipping_email'] = Input::get('shipping_email');
                $data['shipping_telephone'] = Input::get('shipping_telephone');
                $data['shipping_country'] = Input::get('shipping_country');
                $data['shipping_state'] = Input::get('shipping_state');
                $data['shipping_address'] = Input::get('shipping_address');
                $data['shipping_city'] = Input::get('shipping_city');
                $data['shipping_post_code'] = Input::get('shipping_post_code');
                $data['payment_method'] = Input::get('payment_method');

                //Add Estimate Shipping
                if (isset($estimateShipping['shipping_method']) && $estimateShipping['shipping_method'] != '') {
                    $data['shipping_method'] = $estimateShipping['shipping_method'];
                } elseif (Session::has('default_ship')) {
                    $data['shipping_method'] = Session::get('default_ship');
                }

                //save shipping charge
                if (Session::has('shipping_charge')) {
                    $data['shipping_charge'] = Session::get('shipping_charge');
                } else {
                    $data['shipping_charge'] = 0;
                }

                //save order total weight
                if ($cart_info !== false) {
                    $data['total_weight'] = $cart_info['total_weight'];
                }
                $data['shipping_estimate_country'] = (isset($estimateShipping['country']) ? $estimateShipping['country'] : '');
                $data['shipping_estimate_state'] = (isset($estimateShipping['state']) ? $estimateShipping['state'] : '');

                //Update customer
                //$this->CheckoutModel->updateCustomer(Session::get('userId'), $data);
                //end
                echo "Hello";exit;
                $cartProducts = $this->ProductsModel->getCartProducts($cart, $promocode);
                $discount = 0;

                foreach($cartProducts['products'] as $key => $cartProduct){
                    $data['products'][$key]['product_id'] = $cartProduct->id; //$cartProduct->cart['product_id'];
                    $data['products'][$key]['quantity'] = $cartProduct->cart['quantity'];
                    $data['products'][$key]['color_id'] = $cartProduct->cart['color_id'];
                    $data['products'][$key]['special_event_id'] = (isset($cartProduct->cart['special_event_id']) ? $cartProduct->cart['special_event_id'] : '0');
                    $data['products'][$key]['amount'] = $cartProduct->sale_price;

                    if(!$cartProduct->free_shipping && $cartProduct->shipping_cost){
                        $data['products'][$key]['shipping_amount'] = $cartProduct->shipping_cost;;
                    }
                    else{
                        $data['products'][$key]['shipping_amount'] = 0;
                    }

                    //pwp price
                    if (isset($cartProduct->pwp_price)) {
                        $data['products'][$key]['pwp_price'] = $cartProduct->pwp_price;
                    }

                    //Discount
                    $data['products'][$key]['quantity_discount'] = $cartProduct->cart['quantityDiscount'];
                    $data['products'][$key]['global_discount'] = $cartProduct->cart['globalDiscount'];
                    $data['products'][$key]['promo_code_discount'] = $cartProduct->cart['promocodeDiscount'];

                    $discount += ($cartProduct->cart['quantityDiscount'] * $cartProduct->cart['quantity']) + $cartProduct->cart['globalDiscount'] + $cartProduct->cart['promocodeDiscount'];
                }

                if($promocode){
                    $data['promocode_id'] = $promocode['promocode']->id;
                }
                else{
                    $data['promocode_id'] = 0;
                }

                $data['totalPrice'] = ($cartProducts['totalPrice'] + $cartProducts['shippingTotal'] - $discount);
                $data['discount'] = $discount;

                $orderId = $this->CheckoutModel->addOrder($data);
                Session::put('orderId', $orderId);


                //Send invoice
                //  $order = $this->CheckoutModel->getOrderByRefNo($refno);
                $order = $this->CheckoutModel->getOrder($orderId);
                $orderToProduct = $this->CheckoutModel->getOrderToProduct($order->id);

                $invoice = array(
                    'order'             => $order,
                    'order_to_products' => $orderToProduct
                );

                $messageData = [
                    'fromEmail'             => 'registration@towerregency.com.my',
                    'fromName'              => 'Tower Regency Hotel & Apartments Online Booking',
                    'toEmail'               => $order->billing_email,
                    'toName'                => $order->billing_first_name . ' ' . $order->billing_last_name,
                    'subject'               => 'TOWER REGENCY HOTEL & APARTMENTS::Order #' . $order->order_id
                ];

                $view = view('invoice.invoice-html', $invoice);
                //dd($_SERVER);
                // echo $view;
                // exit;
                // Mail::send('invoice.invoice-html', $invoice, function ($message) use ($messageData) {
                    // $message->from($messageData['fromEmail'], $messageData['fromName']);
                    // $message->to($messageData['toEmail'], $messageData['toName']);
                    // $message->subject($messageData['subject']);
                // });
                //End


                // return redirect('/checkout/payment');
            }
        }

        $this->data['success'] = Session::get('checkout.success');
        Session::forget('checkout.success');

        $this->data['warning'] = Session::get('checkout.warning');
        Session::forget('checkout.warning');
        //Session::put('userId', 1);
        if(Session::get('userId')){
            //Put user
            $customer = DB::table('customers')->where('id', Session::get('userId'))->first();
            $this->data['customer'] = $customer;
            //End

            $CountriesModel = new Countries();
            $this->data['countries'] = $CountriesModel->getCountries();

            $this->data['billing_states'] = array();
            $this->data['shipping_states'] = array();

            if($customer->billing_country){
                $this->data['billing_states'] = $CountriesModel->getStatesByCountry($customer->billing_country);
            }
            if($customer->shipping_country){
                $this->data['shipping_states'] = $CountriesModel->getStatesByCountry($customer->shipping_country);
            }
        }

        $this->data['isUserLogin'] = Session::has('userId');
        $cartProducts = $this->ProductsModel->getCartProducts($cart, $promocode);

        if(!$cartProducts){
            return redirect('/');
        }

        $this->data['cartProducts'] = $cartProducts;

        $brands = $this->BrandsModel->getBrands();
        $this->data['brands'] = $brands;
        $this->data['brands_scroller'] = View::make('front.module.brands', $this->data);

        $this->data['page_title'] = 'Checkout';
        return view('front.checkout.index',$this->data);
    }*/

    public function payment(){
        $orderId = Session::get('orderId');
        $ipay88=DB::table('paymentMethods')->where('id','2')->first();
        $ipay88=json_decode($ipay88->content);
        Session::forget('orderId');

        if(!$orderId){
            return redirect('/checkout');
        }

        $orderInfo = $this->CheckoutModel->getOrder($orderId);

        if(!$orderInfo){
            return redirect('/checkout');
        }


        $cart = Session::get('cart');
        $total_amount = 0;

        foreach ($cart['product'] as $key => $value) {
            $total_amount += $value['sale_price'] * 1;
        }

        $total_amount *= $cart['rooms'];

        $finalAmount = ($total_amount - $cart['discount_amount']) + $cart['tax_amount'];

       //$this->data['sign'] = $this->iPay88_signature('IDqHDFhHiQ'.'M07198'. $orderInfo->order_id . str_replace(array('.', ','),'', number_format($orderInfo->totalPrice, 2)). 'MYR');
         $this->data['sign'] = $this->iPay88_signature("$ipay88->merchantKey"."$ipay88->merchantCode". $orderInfo->order_id . str_replace(array('.', ','),'', number_format($finalAmount, 2)). 'MYR');

       //$this->data['sign'] = $this->iPay88_signature('QQXMtHhkyL'.'M14638'. $orderInfo->order_id . str_replace(array('.', ','),'', number_format($finalAmount, 2)). 'MYR');

        $this->data['orderInfo'] = $orderInfo;
        $this->data['total_amount'] = $finalAmount;

        return view('front.checkout.payment',$this->data);
    }
    public function paymenteGHL(){
        $eGHL=DB::table('paymentMethods')->where('id','3')->first();
        $eGHL=json_decode($eGHL->content);
        $orderId = Session::get('orderId');
        Session::forget('orderId');

        if(!$orderId){
            return redirect('/checkout');
        }

        $orderInfo = $this->CheckoutModel->getOrder($orderId);

        if(!$orderInfo){
            return redirect('/checkout');
        }


        $cart = Session::get('cart');

        $total_amount = 0;

        foreach ($cart['product'] as $key => $value) {
            $total_amount += $value['sale_price'] * 1;
        }

        $total_amount *= $cart['rooms'];

        $finalAmount = ($total_amount - $cart['discount_amount']) + $cart['tax_amount'];
        $hashkey=$eGHL->merchantPassword.$eGHL->merchantId.$orderInfo->order_id.url('/checkout/successPaymenteGHL').url('checkout/merchantCallbackURLeGHL').str_replace(',','',number_format($finalAmount, 2)).'MYR'.$orderInfo->ip_address.'600';
        $this->data['merchantPassword']=$eGHL->merchantPassword;
        $this->data['merchantId']=$eGHL->merchantId;
       $this->data['hashValue'] = $this->eGHL_siganture($hashkey);
        $this->data['orderInfo'] = $orderInfo;
        $this->data['total_amount'] = $finalAmount;
        /* echo '<pre>';
        print_r($hashkey);
        exit; */

        return view('front.checkout.paymenteGHL',$this->data);
    }

    public function getStates(){
        $CountriesModel = new Countries();
        $json['states'] = $CountriesModel->getStatesByCountry(Input::get('country_id'));
        return Response::json($json);
    }
    private function eGHL_siganture($value){
        return hash('sha256',$value);
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

    public function succeddPayment2(){
        exit;
    }
    public function successPayment(){

        \Log::info(Input::all());

        if (!Request::isMethod('post')){
            return redirect('/');
        }
        // dd(Request::all());
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
            $cart = Session::get('cart');
            Session::forget('cart');

            $data = [
                'description'           => $remark,
                'status'                => 'New Order',
                'payment_status'        => 'Paid',
                'transaction_id'        => $transid,
                'payment_method'        => 'IPAY88'
            ];

            $this->CheckoutModel->updateOrderByRefNo($refno, $data);

            //Send invoice
            $order = $this->CheckoutModel->getOrderByRefNo($refno);
            $orderToProduct = $this->CheckoutModel->getOrderToProduct($order->id);
            /*
            $invoice = array(
                'order'             => $order,
                'order_to_products' => $orderToProduct,
        'bookid'           => $order->id,
        'billing_info' => array(
            'state' => $state,
            'country' => $country
        ),
        'cart' => $cart
            );*/

      $invoice = array(
                'bookid'=>$order->id,
                'order_to_products' => $orderToProduct
            );

            $invoice['cart'] = $cart == null?array():$cart;
            $total = 0;
            $discount = 0;
            // return($invoice);
            foreach ($cart['product'] as $key => $value) {
                $total += $value['sale_price']*$value['qty'];
                $discount += $value['off']*$value['qty'];
            }
            $ProductsModel = new Product();
            $invoice['promo'] = isset($invoice['cart']['product']) && isset($invoice['cart']['product'][0])  && isset($invoice['cart']['product'][0]['product_id']) ? $ProductsModel->getDiscount(Session::get('_token'), $invoice['cart']['product'][0]['product_id']) : (object) array();

            $invoice['product_details'] = $ProductsModel->find($invoice['cart']['product'][0]['product_id']);

            $invoice['discount'] = $discount;
            $country = (object) array();
            $country->name =  $order->shipping_country_name;
            $state = (object) array();
            $state->name = $order->shipping_state_name;
            $invoice['billing_info'] = array(
                'state' => $state,
                'country' => $country
            );
            $order->check_date = $this->CheckoutModel->getOrderBookingDateByOrderId($order->id);
            if (!is_object($order->check_date)) {
                $order->check_date = (object) array();
            }
            if (!property_exists($order->check_date, 'date_checkout')) {
                $order->check_date->date_checkout = date("YYYY-MM-DD");
                $order->check_date->date_checkin = date("YYYY-MM-DD");
            }

            $invoice['order'] = $order;
            $messageData = [
                'fromEmail'             => 'registration@towerregency.com.my',
                'fromName'              => 'Tower Regency Hotel & Apartments Online Booking',
                'toEmail'               => $order->billing_email,
                'toName'                => $order->billing_first_name.' '.$order->billing_last_name,
                'subject'               => 'TOWER REGENCY HOTEL & APARTMENTS::Order #' . $order->id
            ];
            $invoice["tax_name"] = Session::get('tax_name');
            $invoice["tax_rate"] = Session::get('tax_rate');
            $invoice['propertyName']=DB::table('property')->where('property_id',$invoice['product_details']['property_id'])->pluck('name');
            $invoice['packages'] = DB::table('product_to_quantity_discount')->where('product_id',$invoice['cart']['product'][0]['product_id'])->get();
            Mail::send('invoice.invoice-html', $invoice, function ($message) use ($messageData) {
                $message->from($messageData['fromEmail'], $messageData['fromName']);
                $message->to($messageData['toEmail'], $messageData['toName']);
                $message->subject($messageData['subject']);
            });

            
            $notification = new notification;
            $notificationsArr = $notification->where('actions', 'like', '%new_order_received%')->where('status',1)->get();
            foreach($notificationsArr as $notifications){
                $sentEmailArr = array();
                $emailsArr = explode(',',$notifications->emails);
                foreach($emailsArr as $email){
                    if(!in_array($email, $sentEmailArr)){
                        Mail::send('invoice.admin-invoice-html', $invoice, function ($message) use ($messageData, $email) {
                            $message->from($messageData['fromEmail'], $messageData['fromName']);
                            $message->to($email, 'Admin');
                            $message->subject($messageData['subject']);
                        });
                    }
                }
            }
             $orderInfo = $this->CheckoutModel->getOrderByRefNo($refno);
             $invoice['orderInfo'] = (array)$orderInfo;
            //End
            Session::put("invoice", $invoice);
            Session::put('checkout.refno', $order->id);
            Session::put('checkout.success', '<strong>Thank you!</strong> Your order has been received. We are now processing your order.');
            Session::put("new_cart", $cart);
            Session::put('propertyName',$invoice['propertyName']);
            Session::put('invoice', $invoice);

            return redirect('/checkout/orderConfirmation');
            // return Redirect::route('orderConfirmation3');
        }
        else{
            $data = [
                'description'           => $errdesc,
                'status'                => 'Declined',
                'payment_status'        => 'Payment Error',
            ];
            $this->CheckoutModel->updateOrderByRefNo($refno, $data);

            Session::put('checkout.warning', '<strong>Sorry!</strong> Your order was declined because IPAY88 ' . $errdesc . '.');
            return redirect('/checkout');
        }
    }
    public function merchantCallbackURLeGHL() {
        Log::debug("merchantCallbackURLeGHL".json_encode(Request::all()));

        if(isset($_REQUEST['urlType']) && ($_REQUEST['urlType'] == "return")) {
            return url('/checkout/successPaymenteGHL');
        }
        echo "ok";
    }
    public function successPaymenteGHL(){

        \Log::info(Input::all());

        if (!Request::isMethod('post')){
            return redirect('/');
        }
        // dd(Request::all());
        //// Response
        $merchantcode = Input::get('ServiceID');
        $paymentid = Input::get('PaymentID');
        $amount = Input::get('Amount');
        $ecurrency = Input::get('CurrencyCode');
        $remark = Input::get('TxnMessage');
        $transid = Input::get('TxnID');
        $authcode = Input::get('AuthCode');
        $estatus = Input::get('Status');
        $errdesc = Input::get('TxnMessage');

        $this->data['success'] = '';
        $this->data['warning'] = '';
        $name='';

        if(Input::get('TxnStatus')=='0'){
            $cart = Session::get('cart');
            Session::forget('cart');

            $data = [
                'description'           => $remark,
                'status'                => 'New Order',
                'payment_status'        => 'Paid',
                'transaction_id'        => $transid,
                'payment_method'        => 'eGHL'
            ];

            $this->CheckoutModel->updateOrderByRefNo($paymentid, $data);

            //Send invoice
            $order = $this->CheckoutModel->getOrderByRefNo($paymentid);
            $orderToProduct = $this->CheckoutModel->getOrderToProduct($order->id);
            /*
            $invoice = array(
                'order'             => $order,
                'order_to_products' => $orderToProduct,
                'billing_info' => array(
                    'bookid'           => $order->id,
            'state' => $state,
            'country' => $country
            ),
            'cart' => $cart
            );*/

                $invoice = array(
                'bookid'=>$order->id,
                'order_to_products' => $orderToProduct
            );

            $invoice['cart'] = $cart == null?array():$cart;
            $total = 0;
            $discount = 0;
            // return($invoice);
            foreach ($cart['product'] as $key => $value) {
                $total += $value['sale_price']*$value['qty'];
                $discount += $value['off']*$value['qty'];
            }
            $ProductsModel = new Product();
            $invoice['promo'] = isset($invoice['cart']['product']) && isset($invoice['cart']['product'][0])  && isset($invoice['cart']['product'][0]['product_id']) ? $ProductsModel->getDiscount(Session::get('_token'), $invoice['cart']['product'][0]['product_id']) : (object) array();

            //$invoice['product_details'] = $ProductsModel->find($invoice['cart']['product'][0]['product_id']);
            $product_details = $ProductsModel->find($invoice['cart']['product'][0]['product_id']);
            $property_id = !empty($product_details['property_id']) ? $product_details['property_id']: ''; 
            $invoice['discount'] = $discount;
            $country = (object) array();
            $country->name =  $order->shipping_country_name;
            $state = (object) array();
            $state->name = $order->shipping_state_name;
            $invoice['billing_info'] = array(
                'state' => $state,
                'country' => $country
            );
            $order->check_date = $this->CheckoutModel->getOrderBookingDateByOrderId($order->id);
            if (!is_object($order->check_date)) {
                $order->check_date = (object) array();
            }
            if (!property_exists($order->check_date, 'date_checkout')) {
                $order->check_date->date_checkout = date("YYYY-MM-DD");
                $order->check_date->date_checkin = date("YYYY-MM-DD");
            }

            $invoice['order'] = $order;
            $messageData = [
                'fromEmail'             => 'registration@towerregency.com.my',
                'fromName'              => 'Tower Regency Hotel & Apartments Online Booking',
                'toEmail'               => $order->billing_email,
                'toName'                => $order->billing_first_name.' '.$order->billing_last_name,
                'subject'               => 'TOWER REGENCY HOTEL & APARTMENTS::Order #' . $order->id
            ];
            $invoice['propertyName']=DB::table('property')->where('property_id',$property_id)->pluck('name');
            $invoice['packages'] = DB::table('product_to_quantity_discount')->where('product_id',$invoice['cart']['product'][0]['product_id'])->get();
            /* echo '<pre>';
            print_r($name);
            exit; */
            $invoice["tax_name"] = Session::get('tax_name');
            $invoice["tax_rate"] = Session::get('tax_rate');
            Mail::send('invoice.invoice-html', $invoice, function ($message) use ($messageData) {
                $message->from($messageData['fromEmail'], $messageData['fromName']);
                $message->to($messageData['toEmail'], $messageData['toName']);
                $message->subject($messageData['subject']);
            });


            $notification = new notification;
            $notificationsArr = $notification->where('actions', 'like', '%new_order_received%')->where('status',1)->get();
            foreach($notificationsArr as $notifications){
                $sentEmailArr = array();
                $emailsArr = explode(',',$notifications->emails);
                foreach($emailsArr as $email){
                    if(!in_array($email, $sentEmailArr)){
                        Mail::send('invoice.admin-invoice-html', $invoice, function ($message) use ($messageData, $email) {
                            $message->from($messageData['fromEmail'], $messageData['fromName']);
                            $message->to($email, 'Admin');
                            $message->subject($messageData['subject']);
                        });
                    }
                }
            }
             $orderInfo = $this->CheckoutModel->getOrderByRefNo($paymentid);
             $invoice['orderInfo'] = (array)$orderInfo;
            //End
            Session::put("invoice", $invoice);
            Session::put('checkout.refno', $order->id);
            Session::put('checkout.success', '<strong>Thank you!</strong> Your order has been received. We are now processing your order.');
            Session::put("new_cart", $cart);
            Session::put('propertyName',$invoice['propertyName']);
            Session::put('invoice', $invoice);

            return redirect('/checkout/orderConfirmation');
            // return Redirect::route('orderConfirmation3');
        }
        else{
            $data = [
                'description'           => $errdesc,
                'status'                => 'Declined',
                'payment_status'        => 'Payment Error',
                'payment_method'        => 'eGHL'
            ];
            $this->CheckoutModel->updateOrderByRefNo($paymentid, $data);

            Session::put('checkout.warning', '<strong>Sorry!</strong> Your order was declined because eGHL ' . $errdesc . '.');
            /* Session::put('propertyName',$invoice['propertyName']); */
            return redirect('/checkout');
        }
    }

    public function failPayment(){

    }

    public function orderConfirmation_back(){
        if (!Session::has('checkout.refno')){
            return redirect('/');
        }

        $refno = Session::get('checkout.refno');

/*      $this->data['success'] = Session::get('checkout.success');
        Session::forget('checkout.success');

        $orderInfo = $this->CheckoutModel->getOrderByRefNo($refno);

        $this->data['orderInfo'] = $orderInfo;
        $this->data['orderProducts'] = $this->CheckoutModel->getOrderToProduct($orderInfo->id);

        $brands = $this->BrandsModel->getBrands();
        $this->data['brands'] = $brands;
        $this->data['brands_scroller'] = View::make('front.module.brands', $this->data);*/
        $invoice = Session::get('invoice');

        $this->data['invoice'] = $invoice;
        $this->data['page_title'] = 'Order Confirmation';
        $this->data['cart'] = Session::get("cart");

        Session::forget("cart");

        return view('front.checkout.order-confirmation', $this->data);
    }

    public function orderConfirmation(){
        $cart = Session::get('new_cart');
        
        $invoice = Session::get('invoice');
        $gst = Session::get('gst');
        if(empty($invoice)){
            return redirect()->back();
        }
        $invoice['orderInfo']['country'] = \App\Http\Models\Countries::where('country_id',$invoice['orderInfo']['billing_country'])->get();

        $billing_state='';
        if (isset($invoice['orderInfo']['billing_state'])) {
            $billing_state=$invoice['orderInfo']['billing_state'];
        }
        //$invoice['orderInfo']['state'] = \App\Models\State::where('zone_id',$invoice['orderInfo']['billing_state'])->get();
        $invoice['orderInfo']['state'] = \App\Models\State::where('zone_id',$billing_state)->get();
        $invoice['booking_reference_id'] = Session::get('checkout.refno');
        $orderId = $invoice['orderInfo']['id'];

        //nol new tax
        //$this->data['checkout_tax_name'] = Session::get('tax_name');
        //$this->data['checkout_tax_rate'] = Session::get('tax_rate');
        //$name = $gst->name;
        $update = [
            'tax_name' => Session::get('tax_name').','.Session::get('tax_rate'),
            'ota_checklist_id' => isset($cart['ota_checklist_id']) && $cart['ota_checklist_id'] ? $cart['ota_checklist_id'] : '0'
        ];
        ////

        DB::table('orders')->where('id',$orderId)->update($update);
        $this->data['cart'] = $cart == null?array():$cart;
        $paid_order = DB::table('orders')->where('id',$orderId)->first();
        $this->data['tax_name'] = $paid_order->tax_name;
        $total = 0;
        $discount = 0;
        //delete ////////////
        // $cart['arrival'] = "18th Jul, 2017";
        // $cart['departure'] = "19th Jul, 2017";
        // $cart['product'][0]['product_id'] = 2;
        // $cart['product'][0]['bed'] = 2;
        // $cart['product'][0]['guest'] = 3;
        // $cart['product'][0]['meal'] = 10;
        // $cart['product'][0]['sale_price'] = 500;
        // $cart['product'][0]['qty'] = 500;
        // $cart['product'][0]['thumbnail_image_1'] = null;
        // $cart['product'][0]['type'] = "Deluxe Room";
        // $cart['product'][0]['room_code'] = "DR-XXXXX01";
        // $cart['product'][0]['off'] =  0.3;
        //
        // $this->data['cart'] = $cart == null?array():$cart;
        //delete ////////////////////

        $tax = 0;
         foreach ($cart['product'] as $key => $value) {
            $total += $value['sale_price']*$value['qty'];
            $discount += $value['off']*$value['qty'];
            if($value['is_tax'] == 1){
                $tax += ($total*6/100);
            }
         }
        $this->data['promo'] = ($cart['promocode_id'])?$this->ProductsModel->getDiscount(Session::get('_token'), $cart['product'][0]['product_id']):'';
        $this->data['discount'] = $discount;
        $this->data['warning'] = Session::get('checkout.warning');
        $this->data['isUserLogin'] = Session::has('userId');
        $this->data['page_title'] = 'Reservation Successful';
        $this->data['invoice'] = $invoice;
        $this->data['tax'] = $tax;
        $this->data['packages'] = DB::table('product_to_quantity_discount')->where('product_id',$invoice['cart']['product'][0]['product_id'])->get();

        $product_details = DB::table('products')->where('id',$cart['product'][0]['product_id'])->first();
        $this->data['product_details'] = $product_details;

        //nol
        $this->data['checkout_tax_name'] = Session::get('tax_name');
        $this->data['checkout_tax_rate'] = Session::get('tax_rate');
        //dd($this->data);
         //Session::forget('invoice');
        ////
        return view('front.checkout.order-confirmation',$this->data);
    }

    public function sendEmail(Request $request){
        $data = (Session::get('invoice'));
        $email = Request::get('email');
        $orderProducts = '';
        if(!isset($data['order_to_products'])) {
            $orderProducts = $data['orderProducts'];
        } else {
            $orderProducts = $data['order_to_products'];
        }
        $invoice = array(
                        'bookid'=>$data['orderInfo']['id'],
            'order' => ($data['orderInfo']),
            'order_to_products' => ($orderProducts)
        );

        $invoice['cart'] = $data['cart'] == null?array():$data['cart'];
        $invoice['tax_name'] = Session::get('tax_name');
        $invoice['tax_rate'] = Session::get('tax_rate');
        $total = 0;
        $discount = 0;
        // return($invoice);
        foreach ($data['cart']['product'] as $key => $value) {
         $total += $value['sale_price']*$value['qty'];
         $discount += $value['off']*$value['qty'];
        }
        $ProductsModel = new Product();
        $invoice['promo'] = $ProductsModel->getDiscount(Session::get('_token'), $data['cart']['product'][0]['product_id']);
        $invoice['product_details'] = $ProductsModel->find($data['cart']['product'][0]['product_id']);
        $invoice['discount'] = $discount;
        $billingInfo = '';
        if(!isset($data['billing_info'])) {
            $billingInfo = $data['billingInfo'];
        } else {
            $billingInfo = $data['billing_info'];
        }
        $invoice['billing_info'] = $billingInfo;
        $invoice["tax_name"] = Session::get('tax_name');
        $invoice["tax_rate"] = Session::get('tax_rate');
        // $invoice['shipping_info'] = $data['shippingInfo'];
        $order = $this->CheckoutModel->getOrderByRefNoCC($invoice['order']['id']);
        $invoice['order'] = $order;
        $messageData = [
            'fromEmail' => 'registration@towerregency.com.my',
            'fromName' => 'Tower Regency Hotel & Apartments Online Booking',
            'toEmail' => $email,
            'toName' => $invoice['order']->billing_first_name . ' ' . $invoice['order']->billing_last_name,
            'subject' => 'Tower Regency Hotel & Apartments::Order #' . $invoice['order']->order_id];
        $invoice['packages'] = DB::table('product_to_quantity_discount')->where('product_id',$invoice['cart']['product'][0]['product_id'])->get();    
        Mail::send('invoice.invoice-html', $invoice, function ($message) use ($messageData) {
            $message->from($messageData['fromEmail'], $messageData['fromName']);
            $message->to($messageData['toEmail'], '');
            $message->subject($messageData['subject']);
        });

        return json_encode(['success' => 'Email sent successfully']);
    }



}
