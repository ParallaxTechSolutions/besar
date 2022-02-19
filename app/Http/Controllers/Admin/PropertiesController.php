<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Property;

use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Request;
use Response;
use Session;

class PropertiesController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	list all property
	**/
	public function index(Request $request){
		$property = Property::paginate(15);
		return view('admin.property.index',['property' => $property]);
	}

	public function manageproperty(Request $request){
			
			$messages = [
				'name.required' => 'Property name is required',
			];

			$validator = Validator::make(Request::all(),[
				'name' => 'required',
			], $messages);

		  	if ($validator->fails()) {
				return Response::json(array(
                    'code'      =>  401,
                    'message'   =>  $validator->errors()->all()
                ), 404);  
			}else{

				if(Request::input('property_id') != null){
					//add property
					Property::where('property_id',Request::input('property_id'))
						->update([
						'status' => Request::input('status') != null ? Request::input('status') : 0, 
						'name' => Request::input('name'),
						'type' => Request::input('type'),
						'address' => Request::input('address'),
						'city' => Request::input('city'),
						'postal_code' => Request::input('postal_code'),
						'state' => Request::input('state'),
						'country' => Request::input('country'),
						'website_url' => Request::input('website_url'),
						'telephone' => Request::input('telephone'),
						'fax' => Request::input('fax'),
						'administrative_email' => Request::input('administrative_email'),
						'reservation_email' => Request::input('reservation_email')
					]);

					Session::put('response', 'Pick Up updated successfully.');
					
				}else{
					//add property
					Property::create([
						'status' => Request::input('status') != null ? Request::input('status') : 0, 
						'name' => Request::input('name'),
						'type' => Request::input('type'),
						'address' => Request::input('address'),
						'city' => Request::input('city'),
						'postal_code' => Request::input('postal_code'),
						'state' => Request::input('state'),
						'country' => Request::input('country'),
						'website_url' => Request::input('website_url'),
						'telephone' => Request::input('telephone'),
						'fax' => Request::input('fax'),
						'administrative_email' => Request::input('administrative_email'),
						'reservation_email' => Request::input('reservation_email')
					]);

					Session::put('response', 'Pick Up added successfully.');
				}

				
			}
	}


	function deleteproperties()
	{
		$PropertyModel = new Property();
		$PropertyModel->deleteproperties($_POST['item_id']);
		Session::put('response', 'Item(s) deleted successfully.');
	}
	

}