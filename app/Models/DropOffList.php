<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropOffList extends Model {

    protected $table = 'drop_off_list';

    protected $fillable = ['drop_list_id', 'name', 'type', 'address', 'city', 'postal_code', 'state', 'country', 'website_url', 'telephone', 'fax', 'administrative_email', 'reservation_email', 'status'];

    /**
     *@Description : enabled timestamps created_at and updated_at
     */
    public $timestamps = true;

    function deletedropofflist($item_id){
        \DB::table('drop_off_list')->whereIn('drop_list_id',explode(',',$item_id))->delete();
    }

}
