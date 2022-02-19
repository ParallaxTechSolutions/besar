<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\FeedBack;
use App\Http\Models\Admin\Partners;
use App\Http\Models\Front\Users;
use App\Http\Models\Countries;
use App\Http\Controllers\Customers;
use App\Http\Models\Front\Categories;
use App\Http\Models\Front\Product;
use App\Models\Customer;
use App\Http\Models\Admin\Orders;
use App\Http\Models\Front\CheckAvail;
use Session;
use Input;
use URL;
use Illuminate\Http\RedirectResponse;
//use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller {



    public function contactsubmit()
    {
        $name = Input::get('name');
        $email = Input::get('email');
        $contact_number = Input::get('contact_number');
        $company_name = Input::get('company_name');
        $company_address = Input::get('company_address');
        $city = Input::get('city');
        $state = Input::get('state');
        $post_code = Input::get('post_code');
        $country = Input::get('country');
        $cat_id = Input::get('cat_id');
        $subcat_id = Input::get('subcat_id');
        $subject = Input::get('subject');
        $questions_comments = Input::get('questions_comments');


        $category = Enquirycategory::where('id', '=', $cat_id)->first();
        $category_name = $category->title;
        $subcategory_name = '';
        if (!empty($subcat_id)) {
            $subcategory = Enquirycategory::where('id', '=', $subcat_id)->first();
            $subcategory_name = $subcategory->title;
        } else {
            $subcat_id = 0;
        }
        $matchThese = ['cat_id' => $cat_id, 'subcat_id' => $subcat_id];
        $enquiry_email = Enquiryemail::where($matchThese)->get();
        $email_arr = array();
        foreach($enquiry_email as $em)
        {
            array_push($email_arr,$em->email);
        }

        if (!empty($enquiry_email) && count($enquiry_email)>0){
            $email_sent_arr = $email_arr;
        }else{
            $email_arr = array('support@webqom.com');
            $email_sent_arr = $email_arr;
        }
        if (!empty($enquiry_email) || empty($enquiry_email)) {
            $emailcontent = array(
                'name' => $name,
                'email' => $email,
                'contact_number' => $contact_number,
                'company_name' => $company_name,
                'company_address' => $company_address,
                'city' => $city,
                'state' => $state,
                'post_code' => $post_code,
                'country' => $country,
                'category_name' => $category_name,
                'subcategory_name' => $subcategory_name,
                'subject' => $subject,
                'questions_comments' => $questions_comments
            );
            //fareast@fareh.po.my
            Mail::send('email', $emailcontent, function($message) use ($email_sent_arr) {
                $message->to($email_sent_arr, 'Special Enquiry')
                    ->subject($_ENV['MAIL_SUBJECT']);
                $message->from($_ENV['MAIL_FROM_ADDRESS_BURSA'],$_ENV['MAIL_FROM_NAME_BURSA']);
            });
        }
        $feedbacks = Feedback::create(Input::all());
        if ($feedbacks) {
            return Redirect::back()->with('message', '<br><br><br><div class="alert alert-success nomargin"><i class="icon-flag"></i>Success! Thank you for submitting the feedback.</div>');
        } else {
            return Redirect::back()->with('message', '<div class="alert alert-error">
								<i class="icon-warning-sign"></i>
								Error! Please correct the errors in the form below.
							</div>
                            ');
        }
    }
    public function addToFeedbackList(){
        $rules = array(
            'g-recaptcha-response' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);




        // process the login
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }
        $input = Input::all();
        $feedback = Feedback::create($input);

        if ($feedback) {
            return Redirect::back()->with('message', '<div class="alert alert-success alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                <p>The submission is successful. Thank you!.</p>
              </div><script>$(document).ready(function(){ $("html,body").animate({ scrollTop: 600 }, "slow");});</script>');
        } else {
            return Redirect::back()->with('message', '<div class="alert alert-error alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <i class="fa fa-check-circle"></i> <strong>Fail!</strong>
                <p>Something happened try again.</p>
              </div><script>$(document).ready(function(){ $("html,body").animate({ scrollTop:  500 }, "slow");});</script>');
        }

    }
        public function adminFeedback(Request $request,$limit = 10)
        {
            $page = 0;

            if(Input::get('page')){
                $page = Input::get('page');
            }
            if(Input::get('sort')){
                $sort = Input::get('sort');
            }
            else{
                $sort = 'ASC';
            }
            if(Input::get('sort_by')){
                $sort_by = Input::get('sort_by');
            }
            else{
                $sort_by = 'createdate';
            }

            $this->data['success'] = Session::get('customer.success');
            Session::forget('customer.success');
            $this->data['warning'] = Session::get('customer.warning');
            Session::forget('customer.warning');

            $this->data['feedbacks'] = Feedback::orderBy('id', 'DESC')->paginate(10);
            $this->data['paginate_msg'] = $this->get_paginate_msg($limit, $page, Input::get());
            $this->data['last_updated'] = $this->getLastUpdated();
            $this->data['curr_url'] = $request->url(). '?' . $_SERVER['QUERY_STRING'];

//            dd($this->data);
            //Sorting URL Start
            $sortingUrl = url('web88cms/contacts/feedbacks/' . $limit) . '?';
            if(Input::get('name')){
                $sortingUrl .= '&name=' . Input::get('name');
            }
            if(Input::get('email')){
                $sortingUrl .= '&email=' . Input::get('email');
            }
            //Sorting URL End

            $this->data['limit'] = $limit;
            $this->data['page'] = $page;
            $this->data['sorting_url'] = $sortingUrl;
            $this->data['sort'] = $sort;
            $this->data['sort_by'] = $sort_by;

            $this->data['page_title'] = 'Customers:: Listing';

        return View('admin.FeedBack.feedback', $this->data);
    }
    public function getLastUpdated(){
        $modifydate = FeedBack::select('created_at')->orderBy('created_at', 'DESC')->take(1)->first();
        if($modifydate){
            return date('d M, Y @ h:i A', strtotime($modifydate->created_at));
        }
        else{
            return false;
        }
    }
    public function get_paginate_msg($limit, $page, $data){
        $page = ($page ? ($page-1) * $limit : 0);

        //First query
        $feedback = FeedBack::select('id');
        if(isset($data['email']) && trim($data['email']) != ''){
            $feedback->where('email', 'LIKE', '%' . $data['email'] . '%');
        }
        if(isset($data['name']) && trim($data['name']) != ''){
            $feedback->where('name', 'LIKE', '%' . $data['name'] . '%');
        }
        $results = $feedback->skip($page)->take($limit)->get();

        //Second query
        $feedback = new FeedBack();
        if(isset($data['email']) && trim($data['email']) != ''){
            $feedback->where('email', 'LIKE', '%' . $data['email'] . '%');
        }
        if(isset($data['name']) && trim($data['name']) != ''){
            $feedback->where('name', 'LIKE', '%' . $data['name'] . '%');
        }

        $count = $feedback->count();

        if($results){
            $message = 'Showing ' . ($page + 1) . ' to ' . ($page + count($results)) . ' of ' . $count . ' entries';
        }
        else{
            $message = 'Showing 0 to 0 of ' . $count . ' entries';
        }

        return $message;
    }

    public function adminDeleteFeedback() {
        $id = Input::get('feedbackid');
        $pressrelease = Feedback::findOrFail($id);
        $pressrelease->delete();
        if ($pressrelease) {
            return Redirect::back()->with('message', '<div class="alert alert-success alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                <p>Deleted Successfully.</p>
              </div>');
        } else {
            return Redirect::back()->with('message', '<div class="alert alert-error alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <i class="fa fa-check-circle"></i> <strong>failed!</strong>
                <p>Something happened try again.</p>
              </div>');
        }
        // $banners = Banner::paginate(2);
        // $corebusinesses = Corebusiness::paginate(2);
        // return View::make('adminindex', array ( 'banners' => $banners, 'corebusinesses' => $corebusinesses ));
    }
    public function adminSingleDeleteFeedback($feedbackId){
        DB::table('feedbacks')->where('id',$feedbackId)->delete();
        Session::put('feedback.success', 'FeedBack deleted successfully.');

        if(Input::get('redirect')){
            return redirect(Input::get('redirect'));
        }
        else{
            return redirect(Input::get('web88cms/contacts/feedbacks'));
        }
    }

    public function adminDeleteAllFeedback() {
        $pressrelease = Feedback::truncate();
        if ($pressrelease) {
            return Redirect::back()->with('message', '<div class="alert alert-success alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                <p>All Records Deleted Successfully.</p>
              </div>');
        } else {
            return Redirect::back()->with('message', '<div class="alert alert-error alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <i class="fa fa-check-circle"></i> <strong>failed!</strong>
                <p>Something happened try again.</p>
              </div>');
        }
    }
    public function getSubcategory($id) {
        $sub_categories = Enquirycategory::where('parent_id', $id)->lists('title', 'id');
        ?>
        <option value=''>--Please Select--</option>
        <?php
        foreach ($sub_categories as $key => $val) {
            ?>
            <option value='<?php echo $key; ?>'><?php echo $val ?></option>
            <?php
        }
    }
    public function regionaloffices() {

        $pageTitle = "Regional Offices";
        $masthead = url().'/images/banner_subpage/banner13.jpg';
        $breadcrumbs = array(
            0 => array
            (
                "title" => "Home",
                "url" => ""
            ),
            1 => array
            (
                "title" => "Contact Us",
                "url" => "http://bursa.fareastholdingsbhd.com/contactus"
            ),
            2 => array
            (
                "title" => "Regional Offices",
                "url" => ""
            )

        );
        $tagLine = "Oil Palm Plantation Investment Holdings";
        $mainMenuTitle = $pageTitle;
        $metaTitle = $mainMenuTitle;

        return View::make('frontregionaloffices',array(
                'pageTitle' => $pageTitle,
                'masthead' => $masthead,
                'breadcrumbs' => $breadcrumbs,
                'tagLine' => $tagLine,
                'metaTitle' => $metaTitle,



            )
        );

    }
}

