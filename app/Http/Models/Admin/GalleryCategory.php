<?php 
namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model {

    protected $table = 'gallery_category';
    protected $fillable = ['name'];
}
