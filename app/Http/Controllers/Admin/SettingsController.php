<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use DB;
use Response;


class SettingsController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $idsArr = array(3,4);
        $settings = DB::table('global_setting')->whereIn('id', $idsArr)->lists('value','key');
      //  dd($settings);
        return view('admin.settings.index')->with(compact('settings'));
    }

    public function saveSettings(Request $request){
        $requestArr = $request->all();
        foreach ($requestArr as $key => $value) {
            if($key!='_token'){
                DB::table('global_setting')->where('id', $key)->update(['value' => $value]);
            }
        }

        return redirect('web88cms/settings')->with('success', 'Settings saved successfully.');
    }

    public function soldRoomsPerAvailable(Request $request){
        $idsArr = array(5);
        $settings = DB::table('global_setting')->whereIn('id', $idsArr)->lists('value','key');
       // dd($settings);
        return view('admin.settings.soldRoomsPerAvailable')->with(compact('settings'));
    }

    public function saveSoldRoomsPerAvailable(Request $request){
        $requestArr = $request->all();
        //dd($requestArr);
        foreach ($requestArr as $key => $value) {
            if($key!='_token'){
                DB::table('global_setting')->where('id', $key)->update(['value' => $value]);
            }
        }

        return redirect('web88cms/sold_rooms_per_available')->with('success', 'Settings saved successfully.');
    }

}