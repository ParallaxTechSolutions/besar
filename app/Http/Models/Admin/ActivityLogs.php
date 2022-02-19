<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ActivityLogs extends Model{
    protected $table = 'activity_logs';

    public function user()
    {
        switch ($this->user_type){
            case 'admin':
                return $this->belongsTo('App\User');
                break;
            case 'customer':
                return $this->belongsTo('App\Models\Customer', 'user_id');
                break;
            case 'client':
                return $this->belongsTo('App\Models\Customer', 'user_id');
                break;
            default:
                return $this->belongsTo('App\User');
        }
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Customer', 'user_id');
    }
}