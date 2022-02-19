<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Models\CreditManagement;
use App\Http\Models\Front\Users;
use App\Http\Models\Countries;
use App\Http\Controllers\Customers;
use App\Http\Models\Front\Categories;
use App\Http\Models\Front\Product;
use App\Models\Order;
use App\Models\Partners;
use App\Http\Models\Admin\Orders;
use App\Http\Models\Front\CheckAvail;
use Session;
use Input;
use URL;
use Illuminate\Http\RedirectResponse;
//use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Illuminate\Http\Request;

use Response;
use Illuminate\Support\Facades\Mail;

class partnerLoginController extends Controller {
    private $data = array();

    /**
     * Create a user controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //// make object for Users class to use user model
        $this->UsersModel = new Users();
        $this->CategoriesModel = new Categories();
        $this->OrdersModel	= new  Orders();
        $this->checkAvailModel = new CheckAvail();
    }

    /**
     * Index page
     *
     * @return Response
     */

    private function get_ip() {

        if ( function_exists( 'apache_request_headers' ) ) {
            $headers = apache_request_headers();
        } else {
            $headers = $_SERVER;
        }
        //Get the forwarded IP if it exists.
        if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
            $the_ip = $headers['X-Forwarded-For'];
        } elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
            $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
        } else {
            $the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
        }
        return $the_ip;
    }


    // create an account after post and insert value in DB table
    public function create_account_register()
    {
        $post=$_POST;
        $file= $_FILES;

        //dd(Request::input());
        if(Request::isMethod('post'))
        {
            $messages = [
                'password_format' => 'Password length should be between 8-12 characters with combination of numeric',
                'billing_email' => 'Plesae enter valid email address'
            ];

            $validator = Validator::make(Request::all(),[
                'billing_first_name' => 'required',
                'billing_last_name' => 'required',
                'billing_telephone' => 'required',
                'birth_date' => 'required',
                'billing_email' => 'required|email',
                'password' =>'required|min:8|max:12|',
                'passconf' => 'required',
                'newsletter_subscription' => 'required',
                'agree' => 'required',
                'billing_address' => array('required','regex:/(^([a-zA-Z0-9 ,\.]+)$)/u'),
                'billing_city' => 'required',
                'billing_post_code' => 'required',
                'billing_country' => 'required',
            ],$messages);

            $billing_first_name=$_REQUEST['billing_first_name'];
            $billing_last_name=$_REQUEST['billing_last_name'];
            if ($validator->fails()) {
                $errors = $validator->errors()->all() ;
                return Redirect::to('create_account')->withInput()->with('error', 'Oops! Your account hasn\'t been created yet. Please check and correct the errors below.')->with('errors', $errors);
            }else{
                if($billing_first_name!=$billing_last_name){
                    $results = DB::table('customers')->where('email',$post['billing_email'])->get();
                    if( count($results) > 0 ) {
                        return Redirect::to('create_account')->withInput()->with('error','This email  is address already registered .');
                    }else {
                        $this->UsersModel->insertregistereddata(Request::input());
                        return Redirect::to('create_account')->withInput()->with('success','Account  has been created successfully..');
                    }
                }else{
                    return Redirect::to('create_account')->withInput()->with('error','First Name And Last Name Must Be Different');
                }

            }
        }

        return view('front.user.create_account');
    }


    ///// Login page form
    public function login()
    {
        Session::forget('success');
        $this->data['page_title'] = 'Login';
        $this->data['customCategories'] = $this->CategoriesModel->getCategories(0);
        return view('front.partnerLogin.login', $this->data);
    }

    ////// login logic after post value from login page
    public function partnerLogin() {
        Session::forget('success');
        $post = $_POST;
        $password = Hash::make($post['password']);
        $a = Hash::check($post['password'], $password);
        // print_r($post);
        $results = DB::table('partners')->where('email', $post['email'])->where('status', 1)->get();
        // print_r($results);die;
        if (count($results) > 0) {
            foreach ($results as $res) {
                $pw = $res->password;
                $b = Hash::check($post['password'], $pw); // true
            }
            if ($a == $b) {
                Session::put('userId', $res->id);
                Session::put('userEmail', $res->email);
                Session::put('userFirstName', $res->first_name);
                Session::put('userLastName', $res->last_name);

                if ($post['redirect'] == 'checkout') {
                    //return Redirect::intended('dashboard');
                    return redirect('/partnercheckout');
                } else {
                    $ip = $this->get_ip();
                    $activity = new \App\Http\Models\Admin\ActivityLogs();

                    $activity->user_id = $res->id;
                    $activity->ip = $ip;
                    $activity->action = 'Logged In';
                    $activity->activity = '-';
                    $activity->details = '-';
                    $activity->save();
                    return Redirect::to('partnerDashboard')->withInput();
                }
            }
            else {
                if ($post['redirect'] == 'checkout') {
                    return Redirect::to('/partnercheckout')->withInput()->with([
                        'error' => 'Oops! You have entered wrong User ID or Password. Please try again.',
                        'errorType' => 'password'
                    ]);
                } else {
                    return Redirect::to('partnerlogin')->withInput()->with('error', 'Oops! You have entered wrong User ID or Password. Please try again.');
                }
            }
        }
        else {

            if ($post['redirect'] == 'checkout') {
                return Redirect::to('/partnercheckout')->withInput()->with([
                    'error' => 'We are sorry! Your account does not exist. If you don\'t have an account with us, please proceed to registration page.',
                    'errorType'=>'account'
                ] );
            }
            else {
                return Redirect::to('partnerlogin')->withInput()->with('error', 'We are sorry! Your account does not exist. If you don\'t have an account with us, please proceed to registration page.');
            }
        }
    }
    ///// logout form account
    public function logout()
    {	Session::forget('userId');
        Session::forget('userEmail');
        Session::forget('userFirstName');
        Session::forget('userLastName');
        Session::forget('cart');
        //return Redirect::to('login')->withInput()->with('success','Logged Out.');
        return redirect(\URL::previous())->withInput()->with('success','Logged Out.');
    }

    ////// dashboard after login
    public function dashboard()
    {
//        dd(Session::get('userId'));
        $this->data['page_title'] = 'Account Dashboard';
        if(Session::get('userId')!='' and Session::get('userEmail')!=''){
            //Load left
            $this->data['user_left'] = view('front.user.userLeft');

            ///Get user detail
            $this->data['userDetail'] = $this->UsersModel->getPartnerUserById(Session::get('userId'));
            $this->data['partnerCredit']=CreditManagement::where('partner_id',Session::get('userId'))->first();
            ///Get order of user
            $this->data['userOrders'] = $this->UsersModel->getPartnerUserOrder(Session::get('userId'));

            ////Get newsletter subscribation status
            $this->data['newsletterStatus'] = $this->UsersModel->getNewsletterStatus(Session::get('userEmail'));
            $this->data['customCategories'] = $this->CategoriesModel->getCategories(0);

            return view('front.partnerLogin.dashboard', $this->data);
        }else{
            return Redirect::intended('partnerlogin')->withInput()->with('error','Oops! You have to need login to access for this section.');
        }
    }

    /////// view account information and edit
    public function accountEdit()
    {
//        dd("sdfa");
        if(app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName() != "partner-account-edit")
        {
            Session::forget('success');
        }
        if(Session::get('userId')!='' and Session::get('userEmail')!=''){
            $this->data['page_title'] = 'Account Edit';

            $post=$_POST;
            $file= $_FILES;
            if(Request::isMethod('post'))
            {
                //create password format validation rule
                Validator::extend('passwordFormat', function($field,$value,$parameters){
                    if(preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[*@$!+%~]).{8,12}$/', $value)==true){
                        return true;
                    }else{
                        return false;
                    }
                });

                $messages = [
                    'password_format' => 'Password length should be between 8-12 characters with combination of alphabet letters, digits & special characters (eg. *@$!+%~).',
                ];

                $validator = Validator::make(Request::all(),[
                    'billing_first_name' => 'required',
                    'billing_last_name'  => 'required',
                    'billing_telephone'  => 'required',
                    'billing_email'      => 'required|email',
                    'current_password'   =>'required',
                    'password'           =>'passwordFormat',
                    'billing_address'    => 'required',
                    'billing_city'       => 'required',
                    'billing_post_code'  => 'required',
                    'billing_country'    => 'required',
                ],
                    $messages);

                if ($validator->fails()) {
                    $errors = $validator->errors()->all() ;
                    return Redirect::to('partner-account-edit')->withInput()->with('error', 'Oops! Your account information hasn\'t been updated yet. Please check and correct the errors below.')->with('errors', $errors);
                }else{
                    ///// check password and confirm password are match or not
                    if($post['password']!=$post['passconf']){
                        return Redirect::to('partner-account-edit')->withInput()->with('error','Password and Confirm Password are not match!');
                    }

                    ///// check password is correct?
                    $password =  Hash::make($post['current_password']);
                    $a= Hash::check($post['current_password'], $password);

                    $results = DB::table('partners')->where('id','=', $post['userId'])->get();

                    if( count($results) > 0 ) {

                        foreach($results as $res){
                            $pw= $res->password;
                            $b =Hash::check($post['current_password'], $pw); // true
                        }

                        if($a==$b){
                            $results = DB::table('partners')->where('email',$post['billing_email'])->where('id','!=', $post['userId'])->get();
                            if( count($results) > 0 ) {
                                return Redirect::to('partner-account-edit')->withInput()->with('error','This email address is already in use.');
                            }else {
                                $this->UsersModel->updateAccount(Request::input());
                                return Redirect::to('partner-account-edit')->withInput()->with('success','Account information has been updated successfully..');
                            }
                        }else{
                            return Redirect::to('partner-account-edit')->withInput()->with('error','Current password is not matched.Please check');
                        }
                    }
                }
            }


            //Load left
            $this->data['user_left'] = view('front.partnerLogin.userLeft');

            ///Get user detail
            $this->data['userDetail'] = $this->UsersModel->getPartnerUserById(Session::get('userId'));

            //Country
            $CountriesModel = new Countries();
            $this->data['countries'] = DB::table('countries')->orderBy('name', 'ASC')->get();

            //States of current country
            $CountriesModel = new Countries();
            $this->data['states'] = $CountriesModel->getStatesByCountry($this->data['userDetail'][0]->billing_country);

            $this->data['customCategories'] = $this->CategoriesModel->getCategories(0);

            return view('front.partnerLogin.accountEdit', $this->data);
        }else{
            return Redirect::intended('login')->withInput()->with('error','Oops! You have to need login to access for this section.');
        }
    }

    //// Get and update billing info
    public function billingaddress(){
        if(Session::get('userId')!='' and Session::get('userEmail')!=''){
            $this->data['page_title'] = 'Billing Address';

            ////// After POST data
            $post=$_POST;
            $file= $_FILES;
            if(Request::isMethod('post'))
            {
                $validator = Validator::make(Request::all(),[
                    'billing_first_name' => 'required',
                    'billing_last_name' => 'required',
                    'billing_telephone' => 'required',
                    'billing_email' => 'required|email',
                    'billing_address' => 'required',
                    'billing_city' => 'required',
                    'billing_post_code' => 'required',
                    'billing_country' => 'required',
                ]);

                if ($validator->fails()) {
                    $errors = $validator->errors()->all() ;
                    return Redirect::to('billingaddress')->withInput()->with('error', 'Oops! Your billing information hasn\'t been updated yet. Please check and correct the errors below.')->with('errors', $errors);
                }else{
                    $this->UsersModel->updateBillingInfo(Request::input());
                    return Redirect::to('billingaddress')->withInput()->with('success','Billing information has been updated successfully..');
                }
            }


            //Load left
            $this->data['user_left'] = view('front.partnerLogin.userLeft');

            ///Get user detail
            $this->data['userDetail'] = $this->UsersModel->getUserById(Session::get('userId'));

            //Country
            $CountriesModel = new Countries();
            $this->data['countries'] = DB::table('countries')->orderBy('name', 'ASC')->get();

            //States of current country
            $CountriesModel = new Countries();
            $this->data['states'] = $CountriesModel->getStatesByCountry($this->data['userDetail'][0]->billing_country);

            return view('front.partnerLogin.billingaddress', $this->data);
        }else{
            return Redirect::intended('login')->withInput()->with('error','Oops! You have to need login to access for this section.');
        }
    }

    //// Get and update shipping info
    public function shippingaddress(){
        if(Session::get('userId')!='' and Session::get('userEmail')!=''){
            $this->data['page_title'] = 'Shipping Address';

            ////// After POST data
            $post=$_POST;
            $file= $_FILES;
            if(Request::isMethod('post'))
            {
                $validator = Validator::make(Request::all(),[
                    'shipping_first_name' => 'required',
                    'shipping_last_name' => 'required',
                    'shipping_telephone' => 'required',
                    'shipping_email' => 'required|email',
                    'shipping_address' => 'required',
                    'shipping_city' => 'required',
                    'shipping_post_code' => 'required',
                    'shipping_country' => 'required',
                ]);

                if ($validator->fails()) {
                    $errors = $validator->errors()->all() ;
                    return Redirect::to('shippingaddress')->withInput()->with('error', 'Oops! Your shipping information hasn\'t been updated yet. Please check and correct the errors below.')->with('errors', $errors);
                }else{
                    $this->UsersModel->updateShippingInfo(Request::input());
                    return Redirect::to('shippingaddress')->withInput()->with('success','Shipping information has been updated successfully..');
                }
            }


            //Load left
            $this->data['user_left'] = view('front.user.userLeft');

            ///Get user detail
            $this->data['userDetail'] = $this->UsersModel->getUserById(Session::get('userId'));

            //Country
            $CountriesModel = new Countries();
            $this->data['countries'] = DB::table('countries')->orderBy('name', 'ASC')->get();

            //States of current country
            $CountriesModel = new Countries();
            $this->data['states'] = $CountriesModel->getStatesByCountry($this->data['userDetail'][0]->shipping_country);

            return view('front.partnerLogin.shippingaddress', $this->data);
        }else{
            return Redirect::intended('login')->withInput()->with('error','Oops! You have to need login to access for this section.');
        }
    }

    ////user subscribe or unsubscribe
    public function newsletter(){
        if(Session::get('userId')!='' and Session::get('userEmail')!=''){
            ////// After POST data
            $post=$_POST;
            if(Request::isMethod('post'))
            {
                if(isset($post['nwslttr']) and $post['nwslttr']!='' and $post['nwslttr']=='subscribe'){
                    $this->UsersModel->newsletter(Request::input());
                    return Redirect::to('dashboard')->withInput()->with('success','Subscribed successfully..');
                }else{
                    $this->UsersModel->newsletter(Request::input());
                    return Redirect::to('dashboard')->withInput()->with('success','Unsubscribed successfully..');
                }
            }
        }else{
            return Redirect::intended('login')->withInput()->with('error','Oops! You have to need login to access for this section.');
        }
    }

    ////// My Order History
    public function orderhistory($sort='all', $page='1')
    {
        $this->data['sort'] = $sort;
        $this->data['page'] = $page;
        $this->data['item'] = 10;

        if(Session::get('userId')!='' and Session::get('userEmail')!=''){
            $this->data['page_title'] = 'Order History';
            //Load left
            $this->data['user_left'] = view('front.partnerLogin.userLeft');

            ///Get all order of user
            $this->data['userOrders'] = $this->UsersModel->getUserPartnerAllOrder(Session::get('userId'), $sort, $page, $this->data['item']);
            //get total order by sort
            $totalOrders =  $this->UsersModel->getUserPartnerAllSortOrder(Session::get('userId'), $sort);
            $this->data['countOrders'] = count($totalOrders);

            $this->data['customCategories'] = $this->CategoriesModel->getCategories(0);
//            dd($this->data);

            return view('front.partnerLogin.orderhistory', $this->data);
        }else{
            return Redirect::intended('login')->withInput()->with('error','Oops! You have to need login to access for this section.');
        }
    }

    ////Get order detail
    public function orderdetails($id){
        if(Session::get('userId')!='' and Session::get('userEmail')!=''){
            $this->data['page_title'] = 'Order Detail';

            //Load left
            $this->data['user_left'] = view('front.user.userLeft');
            ///Get all order of user
            $this->data['userOrderDetails'] = $this->UsersModel->getOrderDetail($id);
            Session::set('userOrderdId',$this->data['userOrderDetails'][0]->id);
            $this->data['orderTax'] = $this->OrdersModel->getOrderTax($this->data['userOrderDetails'][0]->id);
            $this->data['orderProducts'] = $this->UsersModel->getOrderToProduct($id);
            $roomDates = array();
            $order_details=Order::where('id',$id)->first();
            $this->data['driver_details']=DB::table('driver_details')->where('order_id',$order_details->order_id)->first();
            if($this->data['orderTax']->products){
                foreach($this->data['orderTax']->products as $orderProduct){

                    //$checkAvailModel = new App\Http\Models\Front\CheckAvail();
                    if(isset($this->data['userOrderDetails'][0]->check_date) && !empty($this->data['userOrderDetails'][0]->check_date)){
                        $productId = $orderProduct->id;
                        $checkIn = $this->data['userOrderDetails'][0]->check_date->date_checkin;
                        $checkOut = $this->data['userOrderDetails'][0]->check_date->date_checkout;
                        $priceByDate = $this->getPriceByDate($productId,$checkIn,$checkOut);
                        $roomDates[$orderProduct->id] = $this->checkAvailModel->getPriceByDates($orderProduct->id, $this->data['userOrderDetails'][0]->check_date->date_checkin, $this->data['userOrderDetails'][0]->check_date->date_checkout);
                    }

                }
            }
            $priceByDates = '';
            foreach ($priceByDate as $pd) {
                $priceByDates .= "<span>" . date('l', strtotime($pd->date)) . ", " . date('d/M/Y', strtotime($pd->date)) . " MYR " . number_format($pd->sale_price, 2) . "</span><br/>";
            }
            $this->data['priceByDates'] = $priceByDates;
            $this->data['roomDates'] = $roomDates;
            $this->data['packages'] = DB::table('product_to_quantity_discount')->where('product_id',$this->data['orderTax']->products[0]->product_id)->get();
            $this->data['propertyName']=DB::table('property')->where('property_id',$this->data['orderTax']->products[0]->property_id)->pluck('name');
            $this->data['pick_up_list']=DB::table('property')->get();
            $this->data['drop_off_list']=DB::table('drop_off_list')->get();
//            dd($this->data);
            return view('front.partnerLogin.orderdetails', $this->data);
        }else{
            return Redirect::intended('login')->withInput()->with('error','Oops! You have to need login to access for this section.');
        }
    }

    public function getPriceByDate($productId,$checkIn,$checkOut){
        return  DB::table('product_room_prices')
            ->where('date', '>=', $checkIn)
            ->where('date', '<', $checkOut)
            ->where('product_id', $productId)
            ->where('qty_stock','>=','0')
            ->orderBy('date')
            ->get();
    }


    //get states for a country
    public function getStates(){
        $CountriesModel = new Countries();
        $json['states'] = $CountriesModel->getStatesByCountry(Input::get('country_id'));
        return Response::json($json);
    }

    //reset password
    public function resetmail(Request $request)
    {
        $post=$_POST;
        $email= $post['email'];
        //echo $email;
        $recordSet = DB::table('partners')->where('email',$email)->get();

        $total=count($recordSet);
        if($total == 0)
        {
            $response = 'Email does not exist.';
        }
        else
        {
            // Get user details
            $userData = $recordSet;
            $formData = $userData[0];
            $code=  rand(0,99999);
            $data['code'] = $code;
            DB::table('partners')->where('email', $email)->update($data);

            // send mail
            $to = $email;
            $to_name = $formData->first_name;
            $subject = "Password Recovery";
            $to = $formData->email;
            $to_name = $formData->first_name;
            $from = 'Reset Password in Tower Regency Hotel & Apartments <passwordreset@towerregency.com.my>';
            $from_name = 'Password Reset';
            $subject = "Reset Password in Tower Regency Hotel & Apartments";

            $data = [
                'to' => $to,
                'to_name' => $to_name,
                'reset_link' => "http://" . Request::getHttpHost() . "/passwordreset?email=" . $to . "&code=" . $code,
                'logo_link' => 'http://'.Request::getHttpHost().'/public/front/images/index/logo.png'
            ];

            $message = view('emails.password', $data)->render();

            $headers = "From:".$from . "\r\n" ;
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            mail($to,$subject,$message,$headers);
            $response = 'Password has been sent to '.$email.' Kindly  check your email ';

        }
        //return $response;
        return Redirect::to('login')->withInput()->with('success',$response);

    }
    /************************************************/
    function passwordreset()
    {
        $this->data['page_title'] = 'Reset Password';
        return view('front.partnerLogin.passwordreset', $this->data);
    }

    /************************************************/
    function passwordresetpost()
    {
        $post= $_POST;
        $email= $post['email'];
        $code= $post['code'];
        $password= $post['password'];

        if(Request::isMethod('post'))
        {
            //create password format validation rule
            Validator::extend('passwordFormat', function($field,$value,$parameters){
                if(preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[*@$!+%~]).{8,12}$/', $value)==true){
                    return true;
                }else{
                    return false;
                }
            });
            $messages = [
                'password_format' => 'Password length should be between 8-12 characters with combination of alphabet letters, digits & special characters (eg. *@$!+%~).',
            ];
            $a = Request::all();
            $validator = Validator::make(Request::all(),[

                'password' =>'required|passwordFormat',
            ],$messages);

            if ($validator->fails()) {
                $errors = $validator->errors()->all() ;
                return Redirect::to(Request::url()."?email=".$email."&code=".$code."" )->withInput()->with('error', 'Password length should be between 8-12 characters with combination of alphabet letters, digits & special characters (eg. *@$!+%~).')->with('errors', $errors);
            }else{
                $recordSet =DB::table('partners')->where('email',$email)->where('code',$code)->get();

                $total=count($recordSet);
                if($total == 0)
                {
                    $response = 'Retry to reset your password.';
                }
                else
                {
                    $data['password'] = Hash::make($password);
                    $data['code'] = '';
                    DB::table('partners')->where('email', $email)->update($data);

                    //  return Redirect::to('login')->withInput()->with('success','Welcome back Dear "'.$email.'" ');
                    return Redirect::to(Request::url()."?email=".$email."&code=".$code."" )->with('success','You have successfully reset your password. Now you can use your new password to log in.');

                }
            }
        }
    }

    function sendemail(){
        // return(Request::all());

        $data = Request::get('invoice');
        $email = Request::get('email');

        $customerArr = Partners::where('id',$data['orderDetail'][0]['customer_id'])->first();
        $id = $data['orderDetail'][0]['id'];

        $order = $this->UsersModel->getOrderDetail($id);
        $orderTax = $this->OrdersModel->getOrderTax((int) $order[0]->id );
        $order_to_products =  $this->UsersModel->getOrderToProduct($id);
        $countryModel = new Countries();
        $billingInfo = ([ 'country' => $countryModel->getCountry($customerArr['billing_country']), 'state' => DB::table('states')->where('zone_id', '=', $customerArr['billing_state'])->get()[0] ]);
        $property_name = '';
        foreach ($orderTax->products as $product) {
            $property = DB::table('property')->where('property_id','=',$product->property_id)->first();
            $property_name = $property->name;
        }
        $invoice = array(
            'order' => $order[0],
            'orderTax' => $orderTax,
            'order_to_products' => $order_to_products,
            'property_name' => $property_name
        );

        $total = 0;
        $discount = 0;

        $ProductsModel = new Product();

        foreach ($invoice['order_to_products'] as $key => $value) {
            $total += $value->sale_price*$value->quantity;
            $discount += $value->quantity_discount;
        }

        $invoice['promo'] = $ProductsModel->getDiscount(Session::get('_token'), $invoice['order_to_products'][0]->product_id);
        $invoice['discount'] = $discount;
        $invoice['billing_info'] = $billingInfo;
        $invoice['packages'] = DB::table('product_to_quantity_discount')->where('product_id',$invoice['order_to_products'][0]->product_id)->get();
        // $invoice['shipping_info'] = $shippingInfo;
        $Dates = $this->checkAvailModel->getPriceByDates($invoice['order_to_products'][0]->product_id, $invoice['order']->check_date->date_checkin, $invoice['order']->check_date->date_checkout);
        $priceByDates = "";
        foreach ($Dates as $pd) {
            if($invoice['order']->ota_checklist_id) {
                $pd->sale_price  = $invoice['order_to_products'][0]->amount_sold_at;
            }
            $priceByDates .= "<span>". date('l', strtotime($pd->date)) .", ". date('d/M/Y', strtotime($pd->date)) ." MYR " .number_format($pd->sale_price, 2)." </span><br/>";
        }
        $invoice['priceByDates'] = $priceByDates;
        $messageData = [
            'fromEmail' => 'registration@towerregency.com.my',
            'fromName' => 'Tower Regency Hotel & Apartments Online Booking',
            'toEmail' => $email,
            'toName' => $invoice['order']->billing_first_name . ' ' . $invoice['order']->billing_last_name,
            'subject' => 'Tower Regency Hotel & Apartments::Order #' . $invoice['order']->order_id];

        Mail::send('invoice.admin-invoice-html', $invoice, function ($message) use ($messageData) {
            $message->from($messageData['fromEmail'], $messageData['fromName']);
            $message->to($messageData['toEmail'], '');
            $message->subject($messageData['subject']);
        });

        return json_encode(['success' => 'Email sent successfully']);

    }


//    OrderStatusUpdate

    public function partnerClientStatus(Request $request)
    {
        $statusUpdate=$this->OrdersModel->updateOrderPaymentStatus($request->order_id,$request->payment_status);
//        dd($statusUpdate);
        return Response::json(['success'=>true]);

    }
//    OrderPaymentStatusUpdate

    public function partnerClientPaymentStatus(Request $request)
    {
        $statusUpdate=$this->OrdersModel->updatePartnerOrderStatus($request->all());
//        dd($statusUpdate);
        return Response::json(['success'=>true]);

    }
}
