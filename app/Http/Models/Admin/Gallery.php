<?php 
namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model {

    protected $table = 'gallery';
    protected $fillable = ['name','category_id','sm_image','lg_image'];
}
