<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Loader extends Model  {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'loader';
   protected $fillable = ['name','status'];

}
