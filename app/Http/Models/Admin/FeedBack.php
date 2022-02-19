<?php
namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Hash;
use App\Http\Models\Admin\ActivityLogs;
use Auth;

class FeedBack extends Model{

    protected $table = 'feedbacks';


    protected $fillable = ['name','company_name','company_address','city','state','post_code','country','email','contact_number','subject','questions_comments'];



}
