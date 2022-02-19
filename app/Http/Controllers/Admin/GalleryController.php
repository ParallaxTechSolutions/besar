<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Gallery;
use App\Http\Models\Admin\GalleryCategory;
use Session;
use Input;
use Illuminate\Http\RedirectResponse;
use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Request;

class GalleryController extends Controller {


    public function category()
    {
        if (Request::isMethod('post')) {
            if(!empty(Input::get('key'))){
                $c_key = Input::get('key');
                $category = GalleryCategory::find($c_key);
            }else{
                $category = new GalleryCategory();        
            }
            if (Input::get('status')) {
				$category->status  ='Active';
			} else {
				$category->status ='Deactive';
			}
			$category->name=Input::get('name');
			$category->save();
			$this->updateAdminLastActivity('gallery');
			Session::put('success', '1');
			return Redirect::back();
        }
    }

    public function delCategory()
    {
        if (Request::isMethod('post')) {
			$del=Request::input('keys');
			$fas= GalleryCategory::where('id','=',$del)->delete();
			Session::put('success', '1');
			$this->updateAdminLastActivity('gallery');
			return Redirect::to('/web88cms/gallery_list');
		}
    }

    public function category_all_del()
    {
        try {
			GalleryCategory::truncate();
			Session::put('success', '1');
			$this->updateAdminLastActivity('gallery');
			return Redirect::to('/web88cms/gallery_list');
		}

		catch (Exception $e) {
			Session::put('fail', '1');
			return Redirect::to('/web88cms/gallery_list');
		}
    }

    public function category_selected_del()
    {
        if (Request::isMethod('post')) {
			$ids = Request::input('index');
			$fas= GalleryCategory::whereIn('id',explode(",",$ids))->delete();
			Session::put('success', '1');
			$this->updateAdminLastActivity('gallery');
			return Redirect::to('/web88cms/gallery_list');
		}
    }

    public function gallery()
    {
        if (Request::isMethod('post')) {
            if(!empty(Input::get('key'))){
                $g_key = Input::get('key');
                $gallery = Gallery::find($g_key);
            }else{
                $gallery = new Gallery();        
            }

            $files = Input::file('sm_file');

			if (isset($files) && !empty($files)) {

				$infos = getimagesize($files);
				$names = Input::file('sm_file')->getClientOriginalName();
				$sizes = Input::file('sm_file')->getSize();

				if ($sizes > 1049576 || !preg_match('/.jpg|.jpeg|.gif|.png$/', $names) || intval($infos[0]) > 3450 || intval($infos[1]) > 1950) {

					Session::put('fail', '1');
					return Redirect::back();
				}

				$ret = Input::file('sm_file')->move(base_path() . '/public/front/images/gallery', $names);
				$gallery->sm_image = $names;
			}

            $files = Input::file('lg_file');

			if (isset($files) && !empty($files)) {

				$infos = getimagesize($files);
				$names = Input::file('lg_file')->getClientOriginalName();
				$sizes = Input::file('lg_file')->getSize();

				if ($sizes > 1049576 || !preg_match('/.jpg|.jpeg|.gif|.png$/', $names) || intval($infos[0]) > 3450 || intval($infos[1]) > 1950) {

					Session::put('fail', '1');
					return Redirect::back();
				}

				$ret = Input::file('lg_file')->move(base_path() . '/public/front/images/gallery', $names);
				$gallery->lg_image = $names;
			}

			if (Input::get('status')) {
				$gallery->status  ='Active';
			} else {
				$gallery->status ='Deactive';
			}
			$gallery->name=Input::get('name');
			$gallery->category_id=Input::get('category_id');
			$this->updateAdminLastActivity('gallery');
			$gallery->save();
			Session::put('success', '1');
			return Redirect::back();
        }
    }


    public function delGallery()
    {
        if (Request::isMethod('post')) {

			$del=Request::input('keys');
			$fas= Gallery::where('id','=',$del)->delete();
			Session::put('success', '1');
			$this->updateAdminLastActivity('gallery');
			return Redirect::to('/web88cms/gallery_list');
		}
    }

    public function gallery_all_del()
    {
        try {
			Gallery::truncate();
			Session::put('success', '1');
			$this->updateAdminLastActivity('gallery');
			return Redirect::to('/web88cms/gallery_list');
		} catch (Exception $e) {
			Session::put('fail', '1');
			return Redirect::to('/web88cms/gallery_list');
		}
    }

    public function gallery_selected_del()
    {
        if (Request::isMethod('post')) {
			$ids = Request::input('index');
			$fas= Gallery::whereIn('id',explode(",",$ids))->delete();
			Session::put('success', '1');
			$this->updateAdminLastActivity('gallery');
			return Redirect::to('/web88cms/gallery_list');
		}
    }
    public function updateAdminLastActivity($section='')
    {
    	if(Auth::check() && $section != ''){
    		$admin_id = Auth::user()->id;
    	}else{
    		return 0;
    	}
    	$last = DB::table('admin_last_activity')->where('section',$section)->orderBy('updated_at','desc')->first();
    	$update = ['admin_id' => $admin_id, 'section' => $section, 'updated_at' => date("Y-m-d H:i:s")];
    	if($last){
    		DB::table('admin_last_activity')->where('id', $last->id)->update($update);
    	}else{
    		$update['created_at'] = date("Y-m-d H:i:s");
    		DB::table('admin_last_activity')->insert($update);
    	}
    }
}