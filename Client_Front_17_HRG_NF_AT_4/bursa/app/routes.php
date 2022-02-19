<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/* Route::get('/', function()
{
  return View::make('hello');
});
Route::get('grievancereportslisting',function(){
echo "hello world";
});
*/

Route::get('delete_multiple','HomeController@delete_multiple');
Route::get('testing_pdf','HomeController@testing_pdf');
Route::get('destory_session','HomeController@destory_session');
Route::get('admin/grienvance_procedure_delete/{id}','HomeController@del');

Route::get('admin/grienvance_procedure','HomeController@grienvance_procedure');
Route::get('grievancereportslisting','HomeController@grivance');
Route::get('grievanceform','HomeController@grivanceForm');

Route::post('save_gravience','HomeController@save_gravience');

// for dynamic banner
View::composer(array('layouts.front', 'layouts.front_without_banner','layouts.front1','layouts.front2','layouts.front3'), function($view)
{
  if( Request::segment(3)=='general')
  {
    $id= 20;
  }else if(Request::segment(3)=='directorprofile')
  {
    $id =21;
  }
  else if(Request::segment(3)=='keymanagemnet')
  {
    $id =22;
  }
  else if(Request::segment(3)=='oursubsidiaries')
  {
    $id =24;
  }
  else if(Request::segment(2)=='corporategovernance')
  {
    $id =26;
  }
  else if(Request::segment(3)=='ipostatistics')
  {
    $id =27;
  }
  else if(Request::segment(3)=='competitiveadvantages')
  {
    $id =28;
  }
  else if(Request::segment(3)=='riskfactors')
  {
    $id =29;
  }
  else if(Request::segment(3)=='utilizationproceeds')
  {
    $id =30;
  }
  else if(Request::segment(3)=='industryoverview')
  {
    $id =31;
  }

//share information
  else if(Request::segment(3)=='priceticker')
  {
    $id =32;
  }else if(Request::segment(3)=='pricevolume')
  {
    $id =34;
  }
  else if(Request::segment(3)=='shareholdingsanalysis')
  {
    $id =35;
  }

  else if(Request::segment(3)=='topshareholders')
  {
    $id =36;
  }
//end of share information
  else if(Request::segment(2)=='frontentitlement')
  {
    $id =37;
  }
  else if(Request::segment(3)=='financialhighlights')
  {
    $id =38;
  }
  else if(Request::segment(3)=='comprehensiveincome')
  {
    $id =39;
  }else if(Request::segment(3)=='financialposition')
  {
    $id =40;
  }
  else if(Request::segment(3)=='cashflowstatement')
  {
    $id =160;
  }
  else if(Request::segment(3)=='risk_management_committee')
  {
    $id =161;
  }
  else if(Requ