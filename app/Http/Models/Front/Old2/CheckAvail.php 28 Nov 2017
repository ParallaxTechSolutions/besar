<?php
namespace App\Http\Models\Front; // where this file exists

use Illuminate\Database\Eloquent\Model;
use DB;

class CheckAvail extends Model{

	function getRoom($check_in ,$check_out ,$data){
		$result =  DB::table('products');
        $result->select('products.*',DB::raw("count(product_id) as count"))
                  ->leftJoin('room_booked_date','room_booked_date.product_id','=','products.id')
                  ->where('quantity_in_stock', '>', 'count');

                if(!empty($data['product_id'])){
                  $result->where('products.id', '=', $data['product_id']);
                }

									$result->where(function ($query) use ($check_in ,$check_out) {
                								$query->where(function ($query) use ($check_in ,$check_out){
                										$query->whereDate('date_checkin', '>', $check_in)
                      								  		  ->whereDate('date_checkin', '>', $check_out);
            						 					})
                      								  ->orWhere(function ($query) use ($check_in ,$check_out){
                										$query->whereDate('date_checkout', '<', $check_in)
                      								  		  ->whereDate('date_checkout', '<', $check_out);
            						 					})
                      								  ->orWhere(function ($query) {
                										$query->where('date_checkin', '=', NULL)
                      								  		  ->where('date_checkout', '=', NULL);
            						 					});
            						 })
									->where(['status' => 1])
									->groupBy('product_id');

                  $result = $result->get();
                  return $result;
	}
}

?>