<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\notification;
use Illuminate\Support\Facades\URL;
use DB;
use Response;

use App\Http\Models\Admin\Product;
use App\Http\Models\Admin\RoomPrice;

class NotificationController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
		
        $limit = $request->has('limit') ? $request->limit : 10;
        $sort_by = $request->has('sort_by') ? $request->sort_by : 'id';
        $sort = $request->has('sort') ? strtolower($request->sort) : 'desc';
        $page = $request->has('page') ? $request->page : 1;
        $url = URL::current();
        $sorting_url = "$url";

        $notifications = new notification;

		$display_count = $page*$limit;
        if($display_count>$notifications->count()){
            $display_count = $notifications->count();
        } 
		
		$paginate_msg = "Showing ".((($page-1)*$limit)+1)." to ".(int) $display_count." of ".$notifications->count();
		
        $last_updated = $notifications->latest("updated_at")->first();
        if($last_updated){
            $last_updated = $last_updated->updated_at->format('d F, Y @ H:i A');
        }else{
            $last_updated = '';
        }
		
        $notifications = $notifications->getNotifications($limit, $page, $request->all()); //orderBy($sort_by, $sort)->paginate($limit);
		//dd('hcgvcgvhcgvh');
        return view('admin.notifications.index')->with(compact('notifications', 'last_updated', 'limit', 'sort', 'sort_by', 'sorting_url', 'paginate_msg', 'page' ));
    }


    public function getActivityLogsList(Request $request)
    {
        $limit = $request->has('limit') ? $request->limit : 10;
        $sort_by = $request->has('sort_by') ? $request->sort_by : 'id';
        $sort = $request->has('sort') ? strtolower($request->sort) : 'desc';
        $page = $request->has('page') ? $request->page : 1;
        $url = URL::current();
        $sorting_url = "$url?page=$page&sort_by=$sort_by&sort=$sort&limit=$limit";

        $activities = new ActivityLogs;

        $paginate_msg = "Showing ".(int) ceil($activities->count()/$limit)." to $page of ".$activities->count();

        $last_updated = $activities->latest("updated_at")->first();
        if($last_updated){
            $last_updated = $last_updated->updated_at->format('d F, Y @ H:i A');
        }else{
            $last_updated = '';
        }
        
        $activities = $activities->with(['user' => function($q){
            $q->with('role');
        }])->orderBy($sort_by, $sort)->paginate($limit);
        return view('admin.activity_logs.index')->with(compact('activities', 'last_updated', 'limit', 'sort', 'sort_by', 'sorting_url', 'paginate_msg'));

    }

    public function removeRow(Request $request, $type)
    {
        if($type == 'selected'){
            if(!$request->has('notification_settings') || !$request->notification_settings){
                return redirect()->back()->with('warning', 'Please select at least one notification settings before delete.');
            }

            $notification_settings = json_decode($request->notification_settings, true);

            if(notification::whereIn('id', $notification_settings)->delete()){
                return redirect()->back()->with('success', 'Selected items deleted successfully!');
            }
        }

        if($type == 'simple'){
            if(!$request->has('simple') || !$request->simple){
                return redirect()->back()->with('warning', 'Please select at least one product before delete.');
            }

            $notification = notification::find($request->simple);

            if($notification->delete()){
                return redirect()->back()->with('success', 'Selected items deleted successfully!');
            }
        }

        if($type == 'all'){
            notification::truncate();
            return redirect()->back()->with('success', 'All items deleted successfully!');
        }



        return redirect()->back()->with('warning', 'Something is wrong!');

    }

    public function getDetails($id)
    {
        $notifications = notification::find($id);
        return view('admin.notifications.modal_content.details')->with(compact('notifications'));
    }

    function csv(){

        $table = notification::get();

        $filename = "notifications.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('name','actions', 'emails', 'status'));

        foreach($table as $row) {
			
			if(!empty($row->status)){
				$status = 'Active';
			}else{
				$status = 'Inactive';
			}
            fputcsv($handle, array($row->name, $row->actions, $row->emails, $status));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        );

        return Response::download($filename, $filename, $headers);
    }
	
	function notification_settings_new(){
		return view('admin.notifications.notification_settings_new');
	}
	
	function notificationSettingsNewPost(Request $request){
		$requestArr = $request->all();
		$notificationObj = new notification;
		$result = $notificationObj->saveNotification($requestArr);
		if($result){
			return redirect('web88cms/notifications')->with('success', 'Notification setting saved successfully.');
		}
	}
	
	public function edit($notification_id){
		$notification = new notification;
		$notificationData = $notification->find($notification_id);
		return view('admin.notifications.edit')->with(compact('notificationData'));
	}

    function csv2($year, $month, $room_type){
        
        $defaultTab = 'rooms_suits';
        if(!empty($room_type)){
            $defaultTab = $room_type;
        }
        
        $currentYear = date('Y');
        $currentMonth = date('m');
        if(!empty($month)){
            $currentMonth = ($month);
        }
        if(!empty($year)){
            $currentYear = ($year);
        }
        
        $projectObj = new Product;
        if($defaultTab== 'rooms_suits'){
            $categoryList = $projectObj->getSubCategories(array(8));
            array_push($categoryList,8);
        }else{
            $categoryList = $projectObj->getSubCategories(array(9));
            array_push($categoryList,9);
        }
        
        $products = DB::table('products')->join('product_to_category as c','products.id','=','c.product_id')->whereIN('c.category_id',$categoryList)->select('products.*')->get();
        
        $product_count = DB::table('products')->join('product_to_category as c','products.id','=','c.product_id')->whereIN('c.category_id',$categoryList)->count(); 
        
        foreach($products as $product){
            $product_id = $product->id;
            $roomBookedDateOrderIdsArr = DB::table('room_booked_date')->where('product_id',$product_id)->whereRaw('(MONTH(date_checkin) = '.$currentMonth.' AND YEAR(date_checkin) = '.$currentYear.') OR (MONTH(date_checkout) = '.$currentMonth.' AND YEAR(date_checkout) = '.$currentYear.')')->get();
            $tempOrderToProductArr = array();
            foreach($roomBookedDateOrderIdsArr as $roomBookedDateOrderIdArr){
                $orderToProductArr = DB::table('order_to_product')->where('product_id',$roomBookedDateOrderIdArr->product_id)->where('order_id',$roomBookedDateOrderIdArr->order_id)->groupBy('product_id')->get();
                $date_checkin = $roomBookedDateOrderIdArr->date_checkin;
                $date_checkout = $roomBookedDateOrderIdArr->date_checkout;
                while (strtotime($date_checkin) <= strtotime($date_checkout)) {
                    if(!empty($tempOrderToProductArr[$date_checkin])){
                        $tempOrderToProductArr[$date_checkin] += !empty($orderToProductArr->quantity)?$orderToProductArr->quantity:0;
                    }else{
                        $tempOrderToProductArr[$date_checkin] = !empty($orderToProductArr->quantity)?$orderToProductArr->quantity:0;
                    }
                    $date_checkin = date ("Y-m-d", strtotime("+1 days", strtotime($date_checkin)));
                }
            }
            
            $productRoomPricesArr = DB::table('product_room_prices')->where('product_id', $product->id)->whereRaw('MONTH(date) = '.$currentMonth.' AND YEAR(date) = '.$currentYear)->orderBy('date', 'ASC')->get();
            $tempRoomPricesArr = array();
            foreach($productRoomPricesArr as $productRoomPrice){
                $tempRoomPricesArr[$productRoomPrice->date] = $productRoomPrice;
            }
            $data['products'][$product_id]['roomPricesArr'] = $tempRoomPricesArr;
            $data['products'][$product_id]['productDetails'] = $product;
            $data['products'][$product_id]['orderToProductArr'] = $tempOrderToProductArr;
        }
        $data['currentMonth'] = $currentMonth;
        $data['currentYear'] = $currentYear;
        $data['product_count'] = $product_count;
        $data['defaultTab'] = $defaultTab;

        //$dateObj   = DateTime::createFromFormat('!m', $currentMonth);
        $monthName = date("F", mktime(0, 0, 0, $currentMonth, 10));

        $filename = "rooms_sale_report.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array(' ', $monthName));

        $number = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        $columnsArr = array('Room Type');
        $datesArr = array();
        for($i=1; $i<=$number; $i++){
            $datesArr[] = $i."\n".date('D', strtotime($currentYear.'-'.$currentMonth.'-'.$i));
        }

        $datesMergeArr = array_merge($columnsArr, $datesArr);
        fputcsv($handle, $datesMergeArr);

        foreach($data['products'] as $product){ 
            $productSalesArr = array($product['productDetails']->type);

            for($i=1; $i<=$number; $i++){
                if(empty($product['roomPricesArr'])){
                    $productSalesArr[] = 'N/A';
                } else {
                    $currentMonth = str_pad($currentMonth, 2, "0", STR_PAD_LEFT);
                    $i = str_pad($i, 2, "0", STR_PAD_LEFT);
                    if(!empty($product['orderToProductArr'][$currentYear.'-'.$currentMonth.'-'.$i])){
                        $productSalesArr[] = 'N/A';
                    }else{
                        if(!empty($product['orderToProductArr'][$currentYear.'-'.$currentMonth.'-'.$i])){
                            if(($product['orderToProductArr'][$currentYear.'-'.$currentMonth.'-'.$i])>=($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->qty_stock)){
                                $productSalesArr[] = 'SOLD OUT';
                            } else {
                                $orderToProductArr = $product['orderToProductArr'][$currentYear.'-'.$currentMonth.'-'.$i];
                                $roomPricesDividedByTwo = ceil($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->qty_stock/2);
                                if($orderToProductArr >= $roomPricesDividedByTwo){
                                    $productSalesArr[] = "50% SOLD"."\n".number_format($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->sale_price,2);
                                }
                            }
                        } else {
                            $productSalesArr[] = number_format($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->sale_price,2);
                        }
                    }
                }
            }

            fputcsv($handle, $productSalesArr);
        }
        

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        );
        
        return Response::download($filename, $filename, $headers);

    }
}