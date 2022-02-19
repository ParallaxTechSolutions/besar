<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Hash;

class CreditManagement extends Model{

    protected $table = 'credit_management';

    protected $fillable = ['id', 'partner_id', 'add_credit', 'old_credit', 'total_credit', 'debit'];

}