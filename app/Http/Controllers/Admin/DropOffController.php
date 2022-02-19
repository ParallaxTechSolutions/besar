<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Property;
use App\Models\DropOffList;
use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Request;
use Response;
use Session;

class DropOffController extends Controller {

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
    public function indexDropOff(Request $request){
        $property = DropOffList::paginate(15);
        return view('admin.dropOff.index',['property' => $property]);
    }

    public function storeDropOff(Request $request){

        $messages = [
            'name.required' => 'Drop Of Name is required',
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

            if(Request::input('drop_list_id') != null){
                //update Drop off
                DropOffList::where('drop_list_id',Request::input('drop_list_id'))
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

                Session::put('response', 'Drop Off updated successfully.');

            }else{
                //add Drop List
                DropOffList::create([
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

                Session::put('response', 'Drop Off added successfully.');
            }


        }
    }


    function deleteDropOff()
    {
        $PropertyModel = new DropOffList();
        $PropertyModel->deletedropofflist($_POST['item_id']);
        Session::put('response', 'Item(s) deleted successfully.');
    }


}