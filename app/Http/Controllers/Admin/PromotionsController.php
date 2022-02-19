<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Promotion;
use App\Http\Models\Admin\Category;
use Session;
use Input;
use Illuminate\Http\RedirectResponse;
use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Request;


class PromotionsController extends Controller {
	private $data = array();
	private $PromotionModel = null;
	private $CategoryModel = null;

	public function __construct()
	{
		$this->middleware('auth');
		$this->PromotionModel = new Promotion();
		$this->CategoryModel = new Category();

	}

	// *******************************************Promotions************************************************
	public function promotions_list(){
		$promotion=new Promotion;
		if (Request::isMethod('post')) {

			$file = Input::file('file_name');

			if (isset($file) && !empty($file)) {

				$info = getimagesize($file);
				$name = Input::file('file_name')->getClientOriginalName();
				$size = Input::file('file_name')->getSize();

				if ($size > 1049576 || !preg_match('/.jpg|.jpeg|.gif|.png$/', $name) || intval($info[0]) > 3450 || intval($info[1]) > 1950) {

					Session::put('fail', '1');
					return Redirect::back();
				}


				$ret = Input::file('file_name')->move(base_path() . '/public/front/images/promotions', $name);
				$promotion->image= $name;
			}

			$files = Input::file('large_file');

			if (isset($files) && !empty($files)) {

				$infos = getimagesize($files);
				$names = Input::file('large_file')->getClientOriginalName();
				$sizes = Input::file('large_file')->getSize();

				if ($sizes > 1049576 || !preg_match('/.jpg|.jpeg|.gif|.png$/', $names) || intval($info[0]) > 3450 || intval($infos[1]) > 1950) {

					Session::put('fail', '1');
					return Redirect::back();
				}

				$ret = Input::file('large_file')->move(base_path() . '/public/front/images/promotions', $names);
				$promotion->enlarge_image = $names;
			}


			if (Input::get('status_chk')) {
				$promotion->status  ='Active';
			} else {
				$promotion->status ='Deactive';
			}
			$promotion->title=Input::get('title');
			$promotion->short_description=Input::get('sh_des');
			// $promotion->date=Input::get('date_t');
			$promotion->date= date('Y-m-d', strtotime(Input::get('date_t')));

			$promotion->save();
			Session::put('success', '1');
			return Redirect::back();

		}

	}

	public function promotions_list_all_del(){
		try {

			DB::table('promotions')->delete();
			Session::put('success', '1');
			return Redirect::to('/web88cms/promotions_list');
		}

		catch (Exception $e) {
			Session::put('fail', '1');
			return Redirect::to('/web88cms/promotions_list');
		}

	}


	public function editpromotions_list(){
		try {
			// dd(Request::all());
			if (Request::isMethod('post')) {
				$p_key=Input::get('key');
				$promotion=Promotion::find($p_key);

				$file = Input::file('file_name');

				if (isset($file) && !empty($file)) {

					$info = getimagesize($file);
					$name = Input::file('file_name')->getClientOriginalName();
					$size = Input::file('file_name')->getSize();

					if ($size > 1049576 || !preg_match('/.jpg|.jpeg|.gif|.png$/', $name) || intval($info[0]) > 3450 || intval($info[1]) > 1950) {

						Session::put('fail', '1');
						return Redirect::back();
					}


					$ret = Input::file('file_name')->move(base_path() . '/public/front/images/promotions', $name);
					$promotion->image= $name;
				}


				$files = Input::file('large_file');

				if (isset($files) && !empty($files)) {

					$infos = getimagesize($files);
					$names = Input::file('large_file')->getClientOriginalName();
					$sizes = Input::file('large_file')->getSize();

					if ($sizes > 1049576 || !preg_match('/.jpg|.jpeg|.gif|.png$/', $names) || intval($infos[0]) > 3450 || intval($infos[1]) > 1950) {

						Session::put('fail', '1');
						return Redirect::back();
					}

					$ret = Input::file('large_file')->move(base_path() . '/public/front/images/promotions', $names);
					$promotion->enlarge_image = $names;
				}



				if (Input::get('status_chk')) {
					$promotion->status  ='Active';
				} else {
					$promotion->status ='Deactive';
				}
				$promotion->title=Input::get('title');
				$promotion->short_description=Input::get('sh_des');
				$promotion->date= date('Y-m-d', strtotime(Input::get('date_t')));
				$promotion->save();
				Session::put('success', '1');
				return Redirect::back();

			}

		}

		catch (Exception $e) {
			Session::put('fail', '1');
			return Redirect::to('/web88cms/promotions_list');
		}

	}

	public function promotions_list_del(){
		try {

			$p_key=Input::get('keys');
			Promotion::destroy($p_key);
			Session::put('success', '1');
			return Redirect::to('/web88cms/promotions_list');
		}

		catch (Exception $e) {
			Session::put('fail', '1');
			return Redirect::to('/web88cms/promotions_list');
		}


	}
	public function promotion_selected_all_del(){
		if (Request::isMethod('post')) {

			$ids = Request::input('index');
			DB::table("promotions")->whereIn('id',explode(",",$ids))->delete();
			Session::put('success', '1');
			return Redirect::to('/web88cms/promotions_list');
		}

	}

	public function promotion_del_img(){

		if (Request::isMethod('post')) {

			$del_path=Request::input('img_path');
			$fas=Promotion::where('image','=',$del_path)->first();
			$fas->image=null;
			$fas->save();

			Session::put('success', '1');
			return Redirect::to('/web88cms/promotions_list');
		}
	}

	public function promotion_large_img(){
		if (Request::isMethod('post')) {

			$del_path=Request::input('large_path');
			$fas=Promotion::where('enlarge_image','=',$del_path)->first();
			$fas->enlarge_image=null;
			$fas->save();

			Session::put('success', '1');
			return Redirect::to('/web88cms/promotions_list');
		}
	}

	function listGlobalDiscounts()
	{
		$this->data['success'] = Session::get('response');
		Session::forget('response');



		// get global discounts
		$this->data['global_discounts'] = $this->PromotionModel->getGlobalDiscounts();


		// get pagination record status
		$this->data['pagination_report'] = $this->PromotionModel->getTotalProducts(Input::get('page'));

		// get category list
		$this->data['categories'] = $this->CategoryModel->getCategoriesTree();
		// get last updated
		$this->data['last_modified'] = DB::table('global_discounts')->orderBy('last_modified','desc')->pluck('last_modified');

		$this->data['page_title'] = 'Global Discounts:: Listing';

		return view('admin.promotions.global_discounts_list',$this->data);

	}

	function addGlobalDiscount()
	{
		if(Request::isMethod('post'))
		{
			$validator = Validator::make(	Request::all(),[
												'from_amount' => 'required',
												'to_amount' => 'required',
												'discount'	=> 'required'
											]
										);

		  if ($validator->fails()) {
				$json['error'] = $validator->errors()->all();
				echo json_encode($json);
				exit;

			}
			else
			{
				$this->PromotionModel->addGlobalDiscount(Request::input());

				Session::put('response', 'Global discount added successfully.');

				echo json_encode(array('success' => 'success'));
			}
		}
	}

	function deleteGlobalDiscounts()
	{
		$brands = $this->PromotionModel->deleteGlobalDiscounts($_POST['item_id']);
		Session::put('response', 'Item(s) deleted successfully.');
	}


	function updateGlobalDiscount()
	{
		if(Request::isMethod('post'))
		{
			$validator = Validator::make(	Request::all(),[
												'from_amount' => 'required',
												'to_amount' => 'required',
												'discount'	=> 'required'
											]
										);

		  if ($validator->fails()) {
				$json['error'] = $validator->errors()->all();
				echo json_encode($json);
				exit;

			}
			else
			{
				$this->PromotionModel->updateGlobalDiscount(Request::input());

				Session::put('response', 'Global discount updated successfully.');

				echo json_encode(array('success' => 'success'));
			}
		}
	}
}
