<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class notification extends Model  {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';
	
	protected $guarded = [];

	public function saveNotification($requestArr){
		$activity = array_keys($requestArr['activity']);
		$saveArr['name'] = $requestArr['name'];
		$saveArr['actions'] = implode(',', $activity);
		$saveArr['emails'] = $requestArr['emails'];
		$saveArr['status'] = !empty($requestArr['status'])?$requestArr['status']:0;
		if(!empty($requestArr['id'])){
			return $this->where('id', $requestArr['id'])->update($saveArr);
		}else{
			return $this->create($saveArr);
		}
	}
	
	public function getNotifications($limit, $page, $data)
	{
		$notifications = DB::table('notifications');
		
		if(isset($data['email']) && trim($data['email']) != ''){
			$notifications->where('emails', 'LIKE', '%' . $data['email'] . '%');
		}
		if(isset($data['name']) && trim($data['name']) != ''){
			$notifications->where(DB::raw('name'), 'LIKE', '%' . $data['name'] . '%');
		}
		
		//Sorting Start
		$sort = 'DESC';
		$sort_by = 'id';
		
		if(isset($data['sort'])){
			$sort = $data['sort'];
		}
		
		if(isset($data['sort_by']) && in_array($data['sort_by'], array('id', 'name', 'email', 'status'))){
			$sort_by = $data['sort_by'];
		}
		
		if($sort_by == 'name'){
			$notifications->orderBy('name', $sort);
		}
		else{
			$notifications->orderBy($sort_by, $sort);
		}
		//Sorting End
		
		return $notifications->paginate($limit);
	}
	
}
