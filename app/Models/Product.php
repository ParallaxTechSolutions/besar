<?php namespace App\Models;

use App\Http\Models\Admin\Property;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    /**
     * Generated
     */

    protected $table = 'products';
    protected $fillable = ['id', 'type', 'room_code', 'bed', 'guest', 'meal', 'promo_behaviour', 'categories', 'brand_id', 'sale_price', 'list_price', 'large_image', 'thumbnail_image_1', 'thumbnail_image_2', 'colors', 'quantity_in_stock', 'low_level_in_stock', 'manufacturer_part_number', 'ships_in', 'is_tax', 'tags', 'is_available', 'available_since', 'in_physical_store_only', 'created', 'out_of_stock_action', 'description', 'features_and_video', 'warranty_and_support', 'return_policy', 'weight', 'free_shipping', 'shipping_cost', 'status', 'last_modified', 'createdate'];


    public $timestamps = false;

    /**
     * @return relation with pick up location
     */
    public function pickUp()
    {
        return $this->belongsTo(Property::class, 'property_id','property_id');
    }
    /**
     * @return realtion with drop off location
     */
    public function dropOff()
    {
        return $this->belongsTo(DropOffList::class, 'drop_list_id','drop_list_id');
    }

}
