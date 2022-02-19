<?php 

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Property extends Model {

    protected $table = 'property';

    protected $fillable = ['property_id', 'name', 'type', 'address', 'city', 'postal_code', 'state', 'country', 'website_url', 'telephone', 'fax', 'administrative_email', 'reservation_email', 'status'];

    /**
    *@Description : enabled timestamps created_at and updated_at
    */
    public $timestamps = true;

    function deleteproperties($item_id){
    	\DB::table('property')->whereIn('property_id',explode(',',$item_id))->delete();
    }

}
