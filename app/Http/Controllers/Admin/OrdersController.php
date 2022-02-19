<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Models\Admin\Orders;
use App\Http\Models\Countries;


use App\Models\Partners;
use Session;
use Input;
use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Response;
use Mail;
use App\Http\Models\Front\CheckAvail;
use App\Http\Models\ShippingMethod;
use Illuminate\Http\Request;


class OrdersController extends Controller {
    private $data = array();
    private $OrdersModel = null;
    private $ShippingModel = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->OrdersModel = new Orders();
        $this->ShippingModel = new ShippingMethod();
    }

    public function index(Request $request, $limit = 10)
    {
        $page = 0;

        if(Input::get('page')){
            $page = Input::get('page');
        }
        if(Input::get('sort')){
            $sort = Input::get('sort');
        }
        else{
            $sort = 'DESC';
        }
        if(Input::get('sort_by')){
            $sort_by = Input::get('sort_by');
        }
        else{
            $sort_by = 'createdate';
        }

        $this->data['success'] = Session::get('order.success');
        Session::forget('order.success');
        $this->data['warning'] = Session::get('order.warning');
        Session::forget('order.warning');

        $this->data['orders'] = $this->OrdersModel->getOrders($limit, $page, Input::get());
        $this->data['paginate_msg'] = $this->OrdersModel->get_paginate_msg($limit, $page, Input::get());
        $this->data['last_updated'] = $this->OrdersModel->getLastUpdated();
        $this->data['curr_url'] = $request->getRequestUri() . '?' . $_SERVER['QUERY_STRING'];

        //Sorting URL Start
        $sortingUrl = url('web88cms/orders/' . $limit) . '?';
        if(Input::get('order_from')){
            $sortingUrl .= '&order_from=' . Input::get('order_from');
        }

        if(Input::get('order_to')){
            $sortingUrl .= '&order_to=' . Input::get('order_to');
        }

        if(Input::get('customer_name')){
            $sortingUrl .= '&customer_name=' . Input::get('customer_name');
        }

        if(Input::get('status')){
            $sortingUrl .= '&status=' . Input::get('status');
        }

        if(Input::get('payment_status')){
            $sortingUrl .= '&payment_status=' . Input::get('payment_status');
        }
        //Sorting URL End

        $this->data['limit'] = $limit;
        $this->data['page'] = $page;
        $this->data['sorting_url'] = $sortingUrl;
        $this->data['sort'] = $sort;
        $this->data['sort_by'] = $sort_by;

        $this->data['page_title'] = 'Orders:: Listing';

        return view('admin.order.index', $this->data);
    }

    public function deleteOrder($order_id){
        $this->OrdersModel->deleteOrder($order_id);
        Session::put('order.success', 'Order deleted successfully.');

        if(Input::get('redirect')){
            return redirect(Input::get('redirect'));
        }
        else{
            return redirect(Input::get('web88cms/orders'));
        }
    }

    public function deleteAllOrder(){
        $orders = Input::get('order_id');

        if($orders && is_array($orders)){
            foreach($orders as $order_id){
                $this->OrdersModel->deleteOrder($order_id);
            }
        }

        Session::put('order.success', 'Orders deleted successfully.');
        $json['success'] = 'TRUE';
        return Response::json($json);
    }

    public function detail($order_id){
        $bookind=$order_id;
        $this->data['success'] = Session::get('order.success');
        Session::forget('order.success');
        $this->data['warning'] = Session::get('order.warning');
        Session::forget('order.warning');

        $CountriesModel = new Countries();
        $order = $this->OrdersModel->getOrder($order_id);
//        dd($order);

        $this->data['billing_states'] = array();
        $this->data['shipping_states'] = array();

        if($order->billing_country){
            $this->data['billing_states'] = $CountriesModel->getStatesByCountry($order->billing_country);
        }
        if($order->shipping_country){
            $this->data['shipping_states'] = $CountriesModel->getStatesByCountry($order->shipping_country);
        }

        $this->data['bookid'] =$bookind;
        $this->data['countries'] = $CountriesModel->getCountries();
        $this->data['order'] = $order;
        $this->data['order_to_products'] = $this->OrdersModel->getOrderToProduct($order_id);
        $this->data['booking_date'] = DB::table('room_booked_date')->where('order_id', $order_id)->first();
        $this->data['customer'] = $this->OrdersModel->getCustomer($order->customer_id);
        $this->data['customerTotalOrders'] = $this->OrdersModel->getCustomerTotalOrders($order->customer_id);
        $this->data['totalOrderItems'] = $this->OrdersModel->getTotalOrderItems($order->id);
        $this->data['getPartners'] = $this->OrdersModel->getPartner();

        $this->data['orderStatus'] = array('New Order', 'Declined', 'Cancelled', 'Shipped', 'Ready To Ship', 'Completed', 'Processing');
        $this->data['paymentStatus'] = array('Processing', 'Paid', 'Payment Error', 'Cancelled');
        $this->data['partners'] = Partners::where('status',1)->get();

        $this->data['page_title'] = 'View Orders:: Details';
        //Get Available Csv shipping method
        $this->data['shipping_options'] = $this->ShippingModel->getAvailableCsvShipping($order->total_weight, $order->shipping_state);
        $this->data['rate'] = DB::table('gst_rates')->select('rate')->get();
        $this->data['packages'] = [];
        if(isset($this->data['order_to_products'][0]->product_id)) {
            $this->data['packages'] = DB::table('product_to_quantity_discount')->where('product_id',$this->data['order_to_products'][0]->product_id)->get();
        }
        // return response()->json($this->data);
        return view('admin.order.detail', $this->data);
    }

    public function invoice($id){

        $order = $this->OrdersModel->getOrder($id);
        $orderToProduct = $this->OrdersModel->getOrderToProduct($id);
        $product = new \App\Http\Models\Front\Product();

        $order_id=$id;
        $this->data['bookid'] =$order_id;
        $total = 0;
        $discount = 0;
        //dd($orderToProduct);
        $arrivalDate=DB::table('room_booked_date')->select('date_checkin')->where('order_id','=',$id)->first();
        $arrivalDate=$arrivalDate->date_checkin;
        $deliveryDate=DB::table('room_booked_date')->select('date_checkout')->where('order_id','=',$id)->first();
        $deliveryDate=$deliveryDate->date_checkout;
        for($i = 0; $i < count($orderToProduct); $i++){
            $orderToProduct[$i]->bed = $product->getProduct($orderToProduct[$i]->product_id,$arrivalDate,$deliveryDate)->bed;
            $orderToProduct[$i]->guest = $product->getProduct($orderToProduct[$i]->product_id,$arrivalDate,$deliveryDate)->guest;
            $orderToProduct[$i]->meal = $product->getProduct($orderToProduct[$i]->product_id,$arrivalDate,$deliveryDate)->meal;
            $orderToProduct[$i]->pwp_price = $product->getProduct($orderToProduct[$i]->product_id,$arrivalDate,$deliveryDate)->sale_price;
            $orderToProduct[$i]->sale_price = $product->getProduct($orderToProduct[$i]->product_id,$arrivalDate,$deliveryDate)->sale_price;
            $total += $orderToProduct[$i]->sale_price*$orderToProduct[$i]->quantity;

            $off = DB::table('order_to_product')->where('product_id', $orderToProduct[$i]->product_id)->where('order_id', $orderToProduct[$i]->order_id)->get()[0];

            $discount += $off->quantity_discount*$orderToProduct[$i]->quantity;
        }


        //$orderToProduct[0]->bed = $product->getProduct(1303,'2018-02-28')->bed;

        $invoice = array(
            'order' 			=> $order,
            'order_to_products'	=> $orderToProduct,
            'total'	=> $total,
            'discount'	=> $discount
        );

        $this->data['success'] = Session::get('order.success');
        Session::forget('order.success');
        $this->data['warning'] = Session::get('order.warning');
        Session::forget('order.warning');

        $CountriesModel = new Countries();
        $order = $this->OrdersModel->getOrder($order_id);

        $this->data['billing_states'] = array();
        $this->data['shipping_states'] = array();

        if($order->billing_country){
            $this->data['billing_states'] = $CountriesModel->getStatesByCountry($order->billing_country);
        }
        if($order->shipping_country){
            $this->data['shipping_states'] = $CountriesModel->getStatesByCountry($order->shipping_country);
        }

        $this->data['countries'] = $CountriesModel->getCountries();
        $this->data['order'] = $order;
        $this->data['order_to_products'] = $this->OrdersModel->getOrderToProduct($order_id);
        $this->data['booking_date'] = DB::table('room_booked_date')->where('order_id', $order_id)->first();
        $this->data['customer'] = $this->OrdersModel->getCustomer($order->customer_id);
        $this->data['customerTotalOrders'] = $this->OrdersModel->getCustomerTotalOrders($order->customer_id);
        $this->data['totalOrderItems'] = $this->OrdersModel->getTotalOrderItems($order->id);

        $this->data['orderStatus'] = array('New Order', 'Declined', 'Cancelled', 'Shipped', 'Ready To Ship', 'Completed', 'Processing');
        $this->data['paymentStatus'] = array('Processing', 'Paid', 'Payment Error', 'Cancelled');
        //echo '<pre>';print_r($this->data['orders']);exit;

        $this->data['page_title'] = 'View Orders:: Details';

        //Get Available Csv shipping method
        $this->data['shipping_options'] = $this->ShippingModel->getAvailableCsvShipping($order->total_weight, $order->shipping_state);
        $this->data['packages'] = DB::table('product_to_quantity_discount')->where('product_id',$this->data['order_to_products'][0]->product_id)->get();
        //dd($orderToProduct);
        //////////////////////////////
        //////////////////////////////
        // $order = $this->OrdersModel->getOrder($id);
        //
        // $this->data['order'] = $order;
        // $this->data['order_to_products'] = $this->OrdersModel->getOrderToProduct($id);
        // $this->data['customer'] = $this->OrdersModel->getCustomer($order->customer_id);
        // $this->data['customerTotalOrders'] = $this->OrdersModel->getCustomerTotalOrders($order->customer_id);
        // $this->data['totalOrderItems'] = $this->OrdersModel->getTotalOrderItems($order->id);
        //
        // $this->data['page_title'] = 'Invoice';
        //dd($invoice);
        //// return view('admin.order.invoice', $this->data);
        //var_dump($invoice);
        //return view('invoice.admin-invoice-print-html','order' =>$invoice);
        return view('invoice.admin-invoice-print-html',$invoice,$this->data);
        //	//return view('invoice/invoice-html', $this->data);
    }

    public function saveShippingAddress($id){
        $json = array();

        $validation['shipping_first_name'] = 'required';
        $validation['shipping_last_name'] = 'required';
        $validation['shipping_email'] = 'required|email';
        $validation['shipping_telephone'] = 'required';
        $validation['shipping_address'] = 'required';

        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            $json['error'] = $validator->errors()->all();
        }
        else
        {
            $this->OrdersModel->saveShippingAddress($id, $request->all());
            Session::put('order.success', 'Shipping address updated successfuly.');
            $json['success'] = 'TRUE';
        }

        return Response::json($json);
    }

    public function saveBillingAddress(Request $request,$id){
        $json = array();

        $validation['billing_first_name'] = 'required';
        $validation['billing_last_name'] = 'required';
        $validation['billing_email'] = 'required|email';
        $validation['billing_telephone'] = 'required';
        $validation['billing_address'] = 'required';

        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            $json['error'] = $validator->errors()->all();
        }
        else
        {
            $this->OrdersModel->saveBillingAddress($id, $request->all());
            Session::put('order.success', 'Billing address updated successfuly.');
            $json['success'] = 'TRUE';
        }

        return Response::json($json);
    }

    public function updateOrderStatus($id){
        $json = array();
        $this->OrdersModel->updateOrderStatus($id, Input::get('status'));
        $arrivalDate=DB::table('room_booked_date')->select('date_checkin')->where('order_id','=',$id)->first();
        $arrivalDate=$arrivalDate->date_checkin;
        $deliveryDate=DB::table('room_booked_date')->select('date_checkout')->where('order_id','=',$id)->first();
        $deliveryDate=$deliveryDate->date_checkout;
        //Send invoice
        if(Input::get('notify')){

            $order = $this->OrdersModel->getOrder($id);
            $checkDate = DB::table('room_booked_date')->where('order_id',$id)->first();
            $order->check_date=$checkDate;

            $orderToProduct = $this->OrdersModel->getOrderToProduct($id);
            $product = new \App\Http\Models\Front\Product();

            $total = 0;
            $discount = 0;
            //dd($orderToProduct);
            for($i = 0; $i < count($orderToProduct); $i++){
                $orderToProduct[$i]->bed = $product->getProduct($orderToProduct[$i]->product_id, $arrivalDate,$deliveryDate)->bed;
                $orderToProduct[$i]->guest = $product->getProduct($orderToProduct[$i]->product_id, $arrivalDate,$deliveryDate)->guest;
                $orderToProduct[$i]->meal = $product->getProduct($orderToProduct[$i]->product_id, $arrivalDate,$deliveryDate)->meal;
                $orderToProduct[$i]->pwp_price = $product->getProduct($orderToProduct[$i]->product_id, $arrivalDate,$deliveryDate)->sale_price;
                $orderToProduct[$i]->sale_price = $product->getProduct($orderToProduct[$i]->product_id, $arrivalDate,$deliveryDate)->sale_price;
                $total += $orderToProduct[$i]->sale_price*$orderToProduct[$i]->quantity;

                $off = DB::table('order_to_product')->where('product_id', $orderToProduct[$i]->product_id)->where('order_id', $orderToProduct[$i]->order_id)->get()[0];

                $discount += $off->quantity_discount*$orderToProduct[$i]->quantity;
            }
            $invoice = array(
                'order' 			=> $order,
                'order_to_products'	=> $orderToProduct,
                'total'	=> $total,
                'discount'	=> $discount
            );

            $messageData = [
                'fromEmail' => 'registration@towerregency.com.my',
                'fromName' => 'Tower Regency Hotels & Apartments Online Booking',
                'toEmail' 				=> $order->billing_email,
                'toName' 				=> $order->billing_first_name . ' ' . $order->billing_last_name,
                'subject'				=> 'Tower Regency Hotel & Apartments::Order #' . $order->order_id
            ];
            //dd($invoice);
            Mail::send('invoice.admin-invoice-html', $invoice, function ($message) use ($messageData) {
                $message->from($messageData['fromEmail'], $messageData['fromName']);
                $message->to($messageData['toEmail'], $messageData['toName']);
                $message->subject($messageData['subject']);
            });
        }
        //End
//dd($messageData);
        Session::put('order.success', 'Order status updated successfuly.');
        $json['success'] = 'TRUE';

        return Response::json($json);
    }

    public function updatePaymentStatus($id){
        $json = array();

        $this->OrdersModel->updatePaymentStatus($id, Input::get('status'));
        $arrivalDate=DB::table('room_booked_date')->select('date_checkin')->where('order_id','=',$id)->first();
        $arrivalDate=$arrivalDate->date_checkin;
        $deliveryDate=DB::table('room_booked_date')->select('date_checkout')->where('order_id','=',$id)->first();
        $deliveryDate=$deliveryDate->date_checkout;
        //Send invoice
        if(Input::get('notify')){
            $order = $this->OrdersModel->getOrder($id);
            $orderToProduct = $this->OrdersModel->getOrderToProduct($id);
            $product = new \App\Http\Models\Front\Product();

            $checkDate = DB::table('room_booked_date')->where('order_id',$id)->first();
            $order->check_date=$checkDate;

            $total = 0;
            $discount = 0;
            //dd($orderToProduct);
            //RJ START
            $checkAvailModel = new CheckAvail();
            //RJ END
            for($i = 0; $i < count($orderToProduct); $i++){
                $orderToProduct[$i]->bed = $product->getProduct($orderToProduct[$i]->product_id, $arrivalDate, $deliveryDate)->bed;
                $orderToProduct[$i]->guest = $product->getProduct($orderToProduct[$i]->product_id, $arrivalDate, $deliveryDate)->guest;
                $orderToProduct[$i]->meal = $product->getProduct($orderToProduct[$i]->product_id, $arrivalDate, $deliveryDate)->meal;
                $orderToProduct[$i]->pwp_price = $product->getProduct($orderToProduct[$i]->product_id, $arrivalDate, $deliveryDate)->sale_price;
                $orderToProduct[$i]->sale_price = $product->getProduct($orderToProduct[$i]->product_id, $arrivalDate, $deliveryDate)->sale_price;
                $total += $orderToProduct[$i]->sale_price*$orderToProduct[$i]->quantity;

                $off = DB::table('order_to_product')->where('product_id', $orderToProduct[$i]->product_id)->where('order_id', $orderToProduct[$i]->order_id)->get()[0];

                $discount += $off->quantity_discount*$orderToProduct[$i]->quantity;

                //New Code (RJ) Start
                $priceByDates = $checkAvailModel->getPriceByDates($orderToProduct[$i]->product_id, $arrivalDate, $deliveryDate);
                DB::table('room_booked_date')->where('order_id','=',$id)
                    ->where('product_id', $orderToProduct[$i]->product_id)
                    ->update(['price_details' => json_encode($priceByDates)]);
                //New Code (RJ) END
            }
            $invoice = array(
                'order' 			=> $order,
                'order_to_products'	=> $orderToProduct,
                'total'	=> $total,
                'discount'	=> $discount
            );

            $messageData = [
                'fromEmail' => 'registration@towerregency.com.my',
                'fromName' => 'Tower Regency Hotels & Apartments Online Booking',
                'toEmail' 				=> $order->billing_email,
                'toName' 				=> $order->billing_first_name . ' ' . $order->billing_last_name,
                'subject'				=> 'Tower Regency Hotel & Apartments::Order #' . $order->order_id
            ];
            //dd($invoice);
            Mail::send('invoice.admin-invoice-html', $invoice, function ($message) use ($messageData) {
                $message->from($messageData['fromEmail'], $messageData['fromName']);
                $message->to($messageData['toEmail'], $messageData['toName']);
                $message->subject($messageData['subject']);
            });
        }
        //End

        Session::put('order.success', 'Payment status updated successfuly.');
        $json['success'] = 'TRUE';

        return Response::json($json);
    }

    public function updateAssignmentStatus(Request $request, $id){
        $json = array();
//         dd($request->all());
        $this->OrdersModel->updatePartnerStatus($id,$request->order_id);
        if(Input::get('notify')){
            $order = $this->OrdersModel->getOrder($request->order_id);
            $orderToProduct = $this->OrdersModel->getOrderToProduct($order->id);
            $partner=Partners::where('id',$id)->first();
            $invoice = array(
                'order' 			=> $order,
                'partner' 			=> $partner,
                'order_to_products'	=> $orderToProduct
            );

            $messageData = [
                'fromEmail' 			=> 'shop@tbm.com.my',
                'fromName' 				=> 'Assignment Status',
                'toEmail' 				=> $partner->email,
                'toName' 				=> $partner->first_name . ' ' . $partner->last_name,
                'subject'				=> 'Order Assign To partner #' . $partner->first_name .' '. $partner->last_name,
            ];

            Mail::send('invoice.partner-assignment', $invoice, function ($message) use ($messageData) {
                $message->from($messageData['fromEmail'], $messageData['fromName']);
                $message->to($messageData['toEmail'], $messageData['toName']);
                $message->subject($messageData['subject']);
            });
        }
        //End

        Session::put('order.success', 'Assignment status updated successfully.');
        $json['success'] = 'TRUE';

        return Response::json($json);
    }

    public function shipmentsList($limit = 10)
    {
        $page = 0;

        if(Input::get('page')){
            $page = Input::get('page');
        }
        if(Input::get('sort')){
            $sort = Input::get('sort');
        }
        else{
            $sort = 'DESC';
        }
        if(Input::get('sort_by')){
            $sort_by = Input::get('sort_by');
        }
        else{
            $sort_by = 'createdate';
        }

        $this->data['success'] = Session::get('order.success');
        Session::forget('order.success');
        $this->data['warning'] = Session::get('order.warning');
        Session::forget('order.warning');

        $data = Input::get();
        $data['isShipment'] = true;

        $this->data['orders'] = $this->OrdersModel->getOrders($limit, $page, $data);
        $this->data['paginate_msg'] = $this->OrdersModel->get_paginate_msg($limit, $page, $data);
        $this->data['last_updated'] = $this->OrdersModel->getLastUpdated();
        $this->data['curr_url'] = Request::url(). '?' . $_SERVER['QUERY_STRING'];

        //Sorting URL Start
        $sortingUrl = url('web88cms/orders/shipmentsList/' . $limit) . '?';
        if(Input::get('order_from')){
            $sortingUrl .= '&order_from=' . Input::get('order_from');
        }

        if(Input::get('order_to')){
            $sortingUrl .= '&order_to=' . Input::get('order_to');
        }

        if(Input::get('customer_name')){
            $sortingUrl .= '&customer_name=' . Input::get('customer_name');
        }

        if(Input::get('status')){
            $sortingUrl .= '&status=' . Input::get('status');
        }

        if(Input::get('payment_status')){
            $sortingUrl .= '&payment_status=' . Input::get('payment_status');
        }
        //Sorting URL End

        $this->data['limit'] = $limit;
        $this->data['page'] = $page;
        $this->data['sorting_url'] = $sortingUrl;
        $this->data['sort'] = $sort;
        $this->data['sort_by'] = $sort_by;

        $this->data['page_title'] = 'Orders:: Listing';

        return view('admin.order.shipmentsList', $this->data);
    }

    public function shipmentDetail($id){
        $order = $this->OrdersModel->getOrder($id);

        $this->data['order'] = $order;
        $this->data['order_to_products'] = $this->OrdersModel->getOrderToProduct($id);
        $this->data['customer'] = $this->OrdersModel->getCustomer($order->customer_id);
        $this->data['totalOrderItems'] = $this->OrdersModel->getTotalOrderItems($order->id);

        $this->data['page_title'] = 'View Shipment:: Details';

        return view('admin.order.shipmentDetail', $this->data);
    }

    public function addNewShipment($id){
        $json = array();

        $validation['shipping_method'] = 'required';
        $validation['tracking_number'] = 'required';
        $validation['comments'] = 'required';

        $validator = Validator::make(Request::all(), $validation);

        if ($validator->fails()) {
            $json['error'] = $validator->errors()->all();
        }
        else
        {
            $this->OrdersModel->addNewShipment($id, Request::all());

            //Send invoice
            if(Input::get('send_shipment_notification') == 'on'){
                $order = $this->OrdersModel->getOrder($id);
                $orderToProduct = $this->OrdersModel->getOrderToProduct($id);

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

                Mail::send('invoice.admin-invoice-shipment', $invoice, function ($message) use ($messageData) {
                    $message->from($messageData['fromEmail'], $messageData['fromName']);
                    $message->to($messageData['toEmail'], $messageData['toName']);
                    $message->subject($messageData['subject']);
                });
            }
            //End

            Session::put('order.success', 'New shipment added successfuly.');
            $json['success'] = 'TRUE';
        }

        return Response::json($json);
    }

    public function editNote($id){
        $json = array();

        $data['customer_notes'] = Input::get('customer_notes');
        $data['staff_notes'] = Input::get('staff_notes');

        $this->OrdersModel->updateNotes($id, $data);
        $json['success'] = 'Notes updated successfuly.';

        return Response::json($json);
    }

    function csv(){
        $table = DB::table('orders')->select('id', 'order_id', 'createdate', 'billing_email', 'billing_first_name', 'billing_last_name', 'totalPrice', 'status', 'payment_status')->get();

        $filename = "orders.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('id', 'order_id', 'createdate', 'email', 'first_name', 'last_name', 'totalPrice', 'status', 'payment_status'));

        foreach($table as $row) {
            fputcsv($handle, array($row->id, $row->order_id, $row->createdate, $row->billing_email, $row->billing_first_name, $row->billing_last_name, $row->totalPrice, $row->status, $row->payment_status));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        );

        return Response::download($filename, $filename, $headers);
    }

    public function viewPurchasedService(Request $request){
        $inputs = Input::all();

        //$this->OrdersModel->getOrderToProduct($order_id);
        foreach ($inputs['order_id'] as $id) {
            if(isset($this->OrdersModel->getOrderToProduct($id)[0])){
                $order = $this->OrdersModel->getOrderToProduct($id)[0];
                $order->tax = $this->OrdersModel->getOrderTax($id);
                $this->data['orders'][] = $order;
            }
        }

        $this->data['page_title'] = 'view purchased service';

        return view('admin.order.view_purchased_services', $this->data);
    }

    public function calendarView(){
        $this->data['success'] = Session::get('order.success');
        Session::forget('order.success');
        $this->data['warning'] = Session::get('order.warning');
        Session::forget('order.warning');
        $this->data['last_updated'] = $this->OrdersModel->getLastUpdated();


        $data = $this->OrdersModel->getOrderData();
        $clients = collect($data)->groupBy('customer_id')->map(function($value, $key) {
            $data['id'] = $key;
            $data['name'] = $value[0]->billing_first_name ." ".$value[0]->billing_last_name;
            $data['email'] = $value[0]->billing_email;
            $data['telephone'] = $value[0]->billing_telephone;
            $data['product_id'] = $value[0]->product_id;
            // dd($value);
            return $data;
        })->values();

        $this->data['clients'] = $clients;
        // dd($this->data);
        return view('admin.calendar_view', $this->data);
    }

    public function getAvailableRooms() {
        $data = Request::all();
        $checkAvailModel = new CheckAvail();
        $rooms = $checkAvailModel->getRoom($data['start_date'], $data['end_date'], []);

        return response()->json($rooms);
    }

    public function placeOrder()
    {
        $data = Request::all();

        return response()->json($this->addOrderBank($data));
        # code...
    }

    public function addOrderBank($request){

        $this->data['errors'] = false;
        // check if customer exist
        $customer_details = DB::table("customers")->where("email", $request['shipping_email'])->first();

        $data['customer_id'] = !is_null($customer_details)? $customer_details->id: 0;
        $data['billing_first_name'] = !is_null($customer_details) ? $customer_details->billing_first_name : $request['shipping_name'];
        $data['billing_last_name'] = !is_null($customer_details) ? $customer_details->billing_last_name : '';
        $data['billing_email'] = !is_null($customer_details) ? $customer_details->billing_email: $request['shipping_email'];
        $data['billing_telephone'] = !is_null($customer_details) ? $customer_details->billing_telephone: $request['shipping_telephone'];
        $data['billing_country'] = !is_null($customer_details) ? $customer_details->billing_country : '';
        $data['billing_state'] = !is_null($customer_details) ? $customer_details->billing_state: '';
        $data['billing_address'] = !is_null($customer_details) ? $customer_details->billing_address: '';
        $data['billing_city'] = !is_null($customer_details) ? $customer_details->billing_city: '';
        $data['billing_post_code'] = !is_null($customer_details) ? $customer_details->billing_post_code: '';

        $data['shipping_first_name'] = !is_null($customer_details) ? $customer_details->shipping_first_name: $request['shipping_name'];
        $data['shipping_last_name'] = !is_null($customer_details) ? $customer_details->shipping_last_name: '';
        $data['shipping_email'] = !is_null($customer_details) ? $customer_details->shipping_email: $request['shipping_email'];
        $data['shipping_telephone'] = !is_null($customer_details) ? $customer_details->shipping_telephone: $request['shipping_telephone'];
        $data['shipping_country'] = !is_null($customer_details) ? $customer_details->shipping_country: '';
        $data['shipping_state'] = !is_null($customer_details) ? $customer_details->shipping_state: '';
        $data['shipping_address'] = !is_null($customer_details) ? $customer_details->shipping_address: '';
        $data['shipping_city'] = !is_null($customer_details) ? $customer_details->shipping_city: '';
        $data['shipping_post_code'] = !is_null($customer_details) ? $customer_details->shipping_post_code: '';
        $data['payment_method'] = "Created by Admin";
        $data['ota_checklist_id'] = 0;

        $data['shipping_method'] = 'Citylink';
        $data['shipping_charge'] = 0;

        $data['shipping_estimate_country'] = 0;
        $data['shipping_estimate_state'] = 0;


        $discount = 0;
        $key = 0;
        $checkAvailModel = new CheckAvail();
        $products = $checkAvailModel->getRoom($request['checkin_date'], $request['checkout_date'], ['product_id' => $request['avail_rooms']]);

        $product  = null;
        foreach($products as $key => $cartProduct){
            $product = $cartProduct;
            $data['products'][$key]['product_id'] = $cartProduct->id; //$cartProduct->cart['product_id'];
            $data['products'][$key]['quantity'] = 1;
            $data['products'][$key]['color_id'] = !empty($cartProduct->colors) ? $cartProduct->colors : '';
            $data['products'][$key]['special_event_id'] = '0';
            $data['products'][$key]['amount'] = $cartProduct->sale_price;
            $data['products'][$key]['shipping_amount'] = $cartProduct->shipping_cost;;

            //pwp price
            if (isset($cartProduct->pwp_price)) {
                $data['products'][$key]['pwp_price'] = $cartProduct->pwp_price;
            }
            $data['products'][$key]['date_checkin'] = $request['checkin_date'];
            $data['products'][$key]['date_checkout'] = $request['checkout_date'];
            //Discount
            $data['products'][$key]['quantity_discount'] = 0;
            $data['products'][$key]['global_discount'] = 0;
            $data['products'][$key]['promo_code_discount'] = 0;

            $discount += 0;

            // add later data.
            $data['products'][$key]["product_type"]  = $cartProduct->type;
            $data['products'][$key]["product_code"] = $cartProduct->room_code;
            $data['products'][$key]["bed"] = $cartProduct->bed;
            $data['products'][$key]["guest"] = $cartProduct->guest;
            $data['products'][$key]["meal"] = $cartProduct->meal;
            $data['products'][$key]["promo_behaviour"] = $cartProduct->promo_behaviour;
            $data['products'][$key]["product_thumb"] = $cartProduct->thumbnail_image_1;
        }


        $data['promocode_id'] = 0;


        $total_amount = 0;

        $total_amount += $product->sale_price * 1;

        $total_amount *= 1;

        // $finalAmount = number_format((float)(($total_amount - $cart['discount_amount']) + $cart['tax_amount']), 2, '.', '');
        // calculate tax
        $tax_amount = 0;
        if($product->is_tax) {
            $tax_amount += ($product->sale_price * (int)$product->gst_rate * 1 / 100);
        }
        $finalAmount = ($total_amount - 0) + $tax_amount;
        $data['totalPrice'] = $finalAmount;
        $data['discount'] = 0;
        $data['room'] = 1;
        $data['adults'] = 1;
        $data['children'] = 0;
        $data["total_weight"] = '';
        $data["tax_rate"] = $product->gst_rate;
        $data["special_requests"] = '';
        $data["tax_name"] = $product->gst_name;

        $checkOutModel = new \App\Http\Models\Front\Checkout();

        $orderId = $checkOutModel->addOrder($data);



        $data = [
            'description'           => 'Transaction is processing',
            'status'                => 'New Order',
            'payment_status'        => 'Processing',
            'transaction_id'        => 'processing',
            'payment_method'        => "Created by Admin (".Auth::user()->email.")"
        ];

        $checkOutModel->updateOrderByRefNoCC($orderId, $data);

        //Send invoice
        $order = $checkOutModel->getOrderByRefNoCC($orderId);
        $orderToProduct = $checkOutModel->getOrderToProduct($order->id);

        Session::put('order.success', 'Your order has been successfully saved.');


        return $order;

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
    }

    public function getOrder()
    {
        $data = $this->OrdersModel->getOrderData();
        $clients = collect($data)->groupBy('customer_id')->map(function($key, $val) {
            return $val;
        });
        $colors = [];
        foreach ($clients as $key => $client) {
            $colors[$client] = $this->getColor($key + rand(1,100));
        }

        foreach($data as $val){
            list($r, $g, $b) = $colors[$val->customer_id];
            $order[] = array(
                'customer_id'=> $val->customer_id,
                'title'=>$val->billing_first_name.' '.$val->billing_last_name.', '.$val->billing_email.', '.$val->billing_telephone,
                'start' => $val->date_checkin,
                'end' => $val->date_checkout,
                'full_name' => $val->billing_first_name.' '.$val->billing_last_name,
                'backgroundColor' => "rgb($r, $g, $b)",
                'product_id' => $val->product_id
            );
        }

        return json_encode($order);
    }

    public function getColor($num) {
        $hash = md5('color' . $num);
        return array(mt_rand( 0, 127 ), mt_rand( 0, 127 ), mt_rand( 0, 127 ));
        // return array(hexdec(substr($hash, 0, 2)), hexdec(substr($hash, 2, 2)), hexdec(substr($hash, 4, 2)));
    }
}
