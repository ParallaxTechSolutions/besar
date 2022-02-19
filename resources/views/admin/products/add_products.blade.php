@extends('adminLayout')

@section('content')
@push('styles')
<link type="text/css" rel="stylesheet" href="{{ asset('/public/admin/css/price-calendar.css') }}">
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
  .radio-inline + .radio-inline, .checkbox-inline + .checkbox-inline{
    margin-left: 0px;
  }
</style>
@endpush
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">

  <!--BEGIN PAGE HEADER & BREADCRUMB-->
  <div class="page-header-breadcrumb">
    <div class="page-heading hidden-xs">
      <h1 class="page-title">Services</h1>
    </div>

    <ol class="breadcrumb page-breadcrumb">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/web88cms/dashboard/') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
      <li>Services &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
      <li><a href="{{ url('/web88cms/products/list') }}">Services Listing</a> &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
      <li class="active">Service - Add New</li>
    </ol>
  </div>
  <!--END PAGE HEADER & BREADCRUMB-->

  <!--BEGIN CONTENT-->
  <div class="page-content">
    <div class="row">
      <div class="col-lg-12">
        <h2>Service <i class="fa fa-angle-right"></i> Add New</h2>
        <div class="clearfix"></div>

        @if(session()->has('data'))
        <div class="alert alert-success alert-dismissable">
          <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
          <i class="fa fa-check-circle"></i> <strong>Success!</strong>
          <p>{{  session('data.success') }}</p>
        </div>
        @endif

        <!-- validation errors -->
			 	@if($errors->has())
        <div class="alert alert-danger alert-dismissable">
            <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
            <i class="fa fa-times-circle"></i> <strong>Error!</strong>
            @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
        </div>
				@endif

        <div class="clearfix"></div>
        <p></p>
        <ul id="myTab" class="nav nav-tabs">
          <li class="active"><a href="#general" data-toggle="tab">General</a></li>
          <li><a href="#images" data-toggle="tab">Images</a></li>
          <li><a href="#description-feature" data-toggle="tab">Description &amp; Features</a></li>
          <li><a href="#room-amenities" data-toggle="tab">Room Amenities</a></li>
          <li><a href="#quantity-discount" data-toggle="tab">Packages</a></li>
          <li><a href="#pwp" data-toggle="tab">PWP Setup</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
          <div id="general" class="tab-pane fade in active">
            <form class="form-horizontal" method="post" action="{{ url('web88cms/products/addProduct') }}" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}" />
              <div class="portlet">
                <div class="portlet-header">
                  <div class="caption">General</div>
                  <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                </div>

                <?php
                $input = Request::old();
                //if($input) dd($input);
                ?>
                <div class="portlet-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-3 control-label">Status <span class="text-red">*</span></label>
                        <div class="col-md-6">
                          <div data-on="success" data-off="primary" class="make-switch" style="height:32px;">
                            <input type="checkbox" name="status" <?php if(isset($input['status']) && $input['status']!='0'){ echo 'checked="checked"'; } ?>/>
                          </div>
 <br>
                              <span><b>Note:</b> 'Active' = to show room in frontend</span><br>
                              <span>'InActive' = to hide room in frontend</span>
                        </div>
                      </div>

                       <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Property <span class="text-red">*</span></label>
                        <div class="col-md-6">
                          <select name="property_id" id="property_id" class="form-control">
                              <option>Please Select Property</option>
                              @if(count($property) > 0)
                                @foreach($property as $p)
                                    <option value="{{$p->property_id}}">{{$p->name}}</option>
                                @endforeach
                              @endif
                          </select>
                        </div>
                      </div>

                      <!-- <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Service Name <span class="text-red">*</span></label>
                        <div class="col-md-6">
                          <input type="text" name="product_name" class="form-control" placeholder="Service Name" value="{{ old('product_name') }}">
                        </div>
                      </div> -->
                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Type <span class="text-red">*</span></label>
                        <div class="col-md-6">
                          <input type="text" name="type" class="form-control" placeholder="eg. Premier Room" value="{{ old('type') }}">
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <!-- <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Service Code <span class="text-red">*</span></label>
                        <div class="col-md-6">
                          <input type="text" name="product_code" class="form-control" placeholder=Service Code" value="{{ old('product_code') }}">
                        </div>
                      </div> -->
                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Room Code <span class="text-red">*</span></label>
                        <div class="col-md-6">
                          <input type="text" name="room_code" class="form-control" placeholder="eg. PR-XXXXX01" value="{{ old('room_code') }}">
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Bed </label>
                        <div class="col-md-6">
                          <input type="text" name="bed" class="form-control" placeholder="eg. 1 King or 2 Singles" value="{{ old('bed') }}">
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Guest </label>
                        <div class="col-md-6">
                          <input type="text" name="guest" class="form-control" placeholder="eg. Max. 2 guests" value="{{ old('guest') }}">
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Meal </label>
                        <div class="col-md-6">
                          <input type="text" name="meal" class="form-control" placeholder="eg. 2 breakfasts" value="{{ old('meal') }}">
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Promo Behaviour</label>
                        <div class="col-md-6">
                          <div class="xss-margin"></div>
                          <div class="checkbox-list">
                            <label><input id="inlineCheckbox1" name="promo_behaviour[]" type="radio" value="none" <?php if(isset($input['promo_behaviour']) && in_array('none',$input['promo_behaviour'])){ echo 'checked="checked"'; } ?>/>&nbsp; None</label>
                            <label><input id="inlineCheckbox1" name="promo_behaviour[]" type="radio" value="hot" <?php if(isset($input['promo_behaviour']) && in_array('hot',$input['promo_behaviour'])){ echo 'checked="checked"'; } ?>/>&nbsp; Hot</label>
                            <label><input id="inlineCheckbox2" name="promo_behaviour[]" type="radio" value="new" <?php if(isset($input['promo_behaviour']) && in_array('new',$input['promo_behaviour'])){ echo 'checked="checked"'; } ?>/>&nbsp; New</label>
                            <label><input id="inlineCheckbox3" name="promo_behaviour[]" type="radio" value="sale" <?php if(isset($input['promo_behaviour']) && in_array('sale',$input['promo_behaviour'])){ echo 'checked="checked"'; } ?>/>&nbsp; Sale</label>
                            <label><input id="inlineCheckbox4" name="promo_behaviour[]" type="radio" value="pwp" <?php if(isset($input['promo_behaviour']) && in_array('pwp',$input['promo_behaviour'])){ echo 'checked="checked"'; } ?>/>&nbsp; PWP</label>
                            <label><input id="inlineCheckbox5" name="promo_behaviour[]" type="radio" value="last_minute" <?php if(isset($input['promo_behaviour']) && in_array('last_minute',$input['promo_behaviour'])){ echo 'checked="checked"'; } ?>/>&nbsp; Last Minute</label>
                            <label><input id="inlineCheckbox6" name="promo_behaviour[]" type="radio" value="24hoursale" <?php if(isset($input['promo_behaviour']) && in_array('24hoursale',$input['promo_behaviour'])){ echo 'checked="checked"'; } ?>/>&nbsp; 24 Hour Sale</label>
                            <label><input id="inlineCheckbox7" name="promo_behaviour[]" type="radio" value="popular" <?php if(isset($input['promo_behaviour']) && in_array('popular',$input['promo_behaviour'])){ echo 'checked="checked"'; } ?>/>&nbsp; Popular</label>
                            <label><input id="inlineCheckbox7" name="promo_behaviour[]" type="radio" value="early_bird" <?php if(isset($input['promo_behaviour']) && in_array('early_bird',$input['promo_behaviour'])){ echo 'checked="checked"'; } ?>/>&nbsp; Early Bird</label>

                            <label><input id="inlineCheckbox10" name="promo_behaviour[]" type="radio" value="black_friday" <?php if(isset($input['promo_behaviour']) && in_array('black_friday',$input['promo_behaviour'])){ echo 'checked="checked"'; } ?> />&nbsp; Black Friday</label>
                              <label><input id="inlineCheckbox11" name="promo_behaviour[]" type="radio" value="singles_day" <?php if(isset($input['promo_behaviour']) && in_array('singles_day',$input['promo_behaviour'])){ echo 'checked="checked"'; } ?> />&nbsp; Singles day</label>
                              <label><input id="inlineCheckbox12" name="promo_behaviour[]" type="radio" value="merdeka" <?php if(isset($input['promo_behaviour']) && in_array('merdeka',$input['promo_behaviour'])){ echo 'checked="checked"'; } ?> />&nbsp; Merdeka</label>
                              <label><input id="inlineCheckbox13" name="promo_behaviour[]" type="radio" value="valentines" <?php if(isset($input['promo_behaviour']) && in_array('valentines',$input['promo_behaviour'])){ echo 'checked="checked"'; } ?> />&nbsp; Valentine's</label>

                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Category <span class="text-red">*</span></label>
                        <div class="col-md-6">
                          <select multiple="multiple" name="categories[]" class="form-control" style="height: 350px;">
                            <?php echo $categories; ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Room Price / Qty <span class="text-red">*</span></label>
                        <div class="col-md-6">
                          <div class="xss-margin"></div>
                          <a href="#" data-target="#modal-add-new" data-toggle="modal" class="btn btn-success">Add New Room Price / Qty &nbsp;<i class="fa fa-plus"></i></a>
                          <div class="xss-margin"></div>
                        </div>
                        <input type="hidden" name="roomPrices" id="roomPrices" />
                      </div>

                      <div class="form-group">
                        <label class="col-md-3 control-label">Upload Thumbnail Image</label>
                        <div class="col-md-9">
                          <div class="text-15px margin-top-10px">
                            <div class="text-blue text-12px">Thumbnails displayed on "Rooms Listing" page.</div>
                          <div class="xss-margin"></div>
                            <input id="exampleInputFile1" type="file" name="thumbnail_image_1"/>
                            <span class="help-block">(Image dimension: 360 x 314 pixels, JPEG/GIF/PNG only, Max. 2MB) </span>
                          </div>
                        </div>
                      </div>

                      <div class="form-group" style="display:none">
                        <label for="inputFirstName" class="col-md-3 control-label">Quantity in Stock (rooms)</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" name="quantity_in_stock" placeholder="" value="<?php echo (isset($input['quantity_in_stock'])) ? $input['quantity_in_stock'] : ''; ?>">
                          <div class="xss-margin"></div>
                          <div class="text-blue text-12px">Rooms remaining in the hotel.</div>
                        </div>
                      </div>
                      <div class="form-group" style="display:none">
                        <label for="inputFirstName" class="col-md-3 control-label">Low Level in Stock (rooms)</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" name="low_level_in_stock" placeholder="" value="<?php echo (isset($input['low_level_in_stock'])) ? $input['low_level_in_stock'] : ''; ?>">
                          <div class="xss-margin"></div>
                          <div class="text-blue text-12px">Shows the minimum level of a service in the warehouse, at which the stock is considered to be low.</div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Display Order</label>
                        <div class="col-md-3">
                          <input type="text" class="form-control" name="display_order" placeholder="" value="<?php echo (isset($input['display_order'])) ? $input['display_order'] : ''; ?>">
                          <div class="xss-margin"></div>
                          <div class="text-blue text-12px">The display order of the service.</div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Tax</label>
                        <div class="col-md-6">
                          <div class="xss-margin"></div>
                          <input type="checkbox" name="is_tax" id="is_tax" <?php if(isset($input['is_tax'])){ echo 'checked="checked"'; } ?>> Tax Rates
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Tag</label>
                        <div class="col-md-5">
                          <input type="text" name="tags" class="form-control" placeholder="eg. Premier Room" value="<?php echo (isset($input['tags'])) ? $input['tags'] : ''; ?>"/><span class="input-group-btn"><!--<button type="button" class="btn btn-primary">Add</button>--></span>
                          <div class="xss-margin"></div>
                          <div class="text-blue text-12px">eg. Hotel Rooms, Premier Room, 50% Room Sales.</div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="starting_from" class="col-md-3 control-label">Price Indicate As:</label>
                        <div class="col-md-6">
                          <div class="xss-margin"></div>
                          <input type="checkbox" name="starting_from" <?php if(isset($input['starting_from'])){ echo 'checked="checked"'; } ?>> <span style="coolor:#000">Starting From </span><i>(Optional)</i>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-mdcol-md-9 col-md-offset-3">
                          <div class="row" style="margin-left: 0px;margin-top: -15px;">
                              <div class="col-md-4">
                                  <div class="xss-margin"></div>
                                  <input type="checkbox" name="gross_price_per_night" <?php if(isset($input['gross_price_per_night'])){ echo 'checked="checked"'; } ?>>  <span style="color:#f00"> Gross Price Per Night</span>

                              </div>
                              <div class="col-md-4" style="margin-left: -65px;">
                                  <div class="xss-margin"></div>
                                  <input type="checkbox" id="net_price_per_night" name="net_price_per_night" <?php if(isset($input['net_price_per_night'])){ echo 'checked="checked"'; } ?>>  <span style="color:#f00">Nett Price Per Night</span>
                                  <div class="xss-margin"></div>
                                  <input type="checkbox" id="reverse_tax_calculation" name="reverse_tax_calculation" <?php if(isset($input['reverse_tax_calculation'])){ echo 'checked="checked"'; } ?> <?php if(isset($input['net_price_per_night'])){ echo 'checked="checked"'; }else{ echo 'disabled';} ?>>  <span style="color:#f00">Reverse Tax Calculation</span>
                              </div>
                              <div class="col-md-4">
                                  <label class="ontrol-label" style="position: absolute;left: -82px;top: 7px;"><i>(Choose One)</i></label>
                              </div>
                          </div>
                        </div>

                      </div>




                    </div>
                    <!-- end col-md-12 -->
                  </div>
                  <!-- end row -->

                  <div class="clearfix"></div>
                  <!--Modal Add New Banner start-->
                  <div id="modal-add-new" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                    <div class="modal-dialog modal-wide-width">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                          <h4 id="modal-login-label2" class="modal-title">Add New Price</h4>
                        </div>

                        <div class="modal-body">
                          <div id="calendar"></div>
                          <div class="clearfix"></div>
                          <i class="fa fa-square alert-success"></i> <span class="text-success">Availability</span>
                          <i class="fa fa-square alert-error"></i> <span class="text-danger">No Availability</span>
                          <div class="form-actions">
                            <div class="col-md-offset-5 col-md-8">
                              <a href="#" class="btn btn-red" onclick="savePrices(); event.preventDefault();">Save &nbsp;<i class="fa fa-floppy-o"></i></a>&nbsp;
                              <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--END MODAL Add New -->
                  <style type="text/css">
                    .status-button .btn{
                      opacity: 0.4
                    }
                    .status-button .btn.active{
                      opacity: 1
                    }
                  </style>
                  <!--Modal add schedule start-->
                  <div id="modal-add-schedule" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                    <div class="modal-dialog modal-wide-width">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                          <h4 id="modal-login-label3" class="modal-title">Add Price / Qty / Restriction</h4>
                        </div>

                        <div class="modal-body">
                          <div class="form-group">
                            <label class="col-md-3 control-label">Status </label>
                            <div class="col-md-9">
                              <div class="btn-group status-button" data-toggle="buttons">
                                <label class="btn btn-success active">
                                  <input id="roomStatusAvailable" type="radio" value='1' checked> Availability
                                </label>
                                <label class="btn btn-danger">
                                  <input id="roomStatusUnavailable" type="radio" value='0'> No Availability
                                </label>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="salePrice" class="col-md-3 control-label">Sale Price (Per Night/nett) <span class="text-red">*</span></label>
                            <div class="col-md-6">
                              <input id="salePrice" type="text" class="form-control" placeholder="0.00" value="0.00">
                              <div class="xss-margin"></div>
                              <div class="text-blue text-12px">The product sale price. The product is sold to customers at this price.</div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="listPrice" class="col-md-3 control-label">List Price (Per Night/nett)</label>
                            <div class="col-md-6">
                              <input id="listPrice" type="text" class="form-control" placeholder="0.00" value="0.00">
                              <div class="xss-margin"></div>
                              <div class="text-blue text-12px">Original room tariff rates.</div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="inputFirstName" class="col-md-3 control-label">Quantity in Stock (rooms)</label>
                            <div class="col-md-6">
                              <input type="text" class="form-control" id="quantity_in_stock" placeholder="0.00" value="0.00">
                              <div class="xss-margin"></div>
                              <div class="text-blue text-12px">Rooms remaining in the hotel.</div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputFirstName" class="col-md-3 control-label">Low Level in Stock (rooms)</label>
                            <div class="col-md-6">
                              <input type="text" class="form-control" id="low_level_in_stock" placeholder="0.00" value="0.00">
                              <div class="xss-margin"></div>
                              <div class="text-blue text-12px">Shows the minimum level of a service in the warehouse, at which the stock is considered to be low.</div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-3 control-label">Bulk Options </label>
                            <div class="col-md-9">
                              <div class="xss-margin"></div>
                              <div class="col-md-9">
                              <label><input id="radioBulkDateRange" type="radio" name="radioBulkOptions" value="1" />&nbsp; By Date Range</label>
                              <div class="margin-top-10px text-blue border-bottom">You may set up a single day or a range of dates for the status "No Availability" or promotional price for festive period.</div>

                              <div class="xss-margin"></div>
                              <div class="input-group input-daterange">
                                <input id="start" type="text" class="form-control" placeholder="eg. 01 March, 2017"/>
                                <span class="input-group-addon">to</span>
                                <input id="end" type="text" class="form-control" placeholder="eg. 01 April, 2017"/>
                              </div>
                              <!-- end input daterange -->

                              <div class="xss-margin"></div>
                                <div class="input-group input-daterange">
                                <input id="start" type="text" class="form-control" placeholder="eg. 01 March, 2017"/>
                                <span class="input-group-addon">to</span>
                                <input id="end" type="text" class="form-control" placeholder="eg. 01 April, 2017"/>
                              </div>
                              <!-- end input daterange -->

                              <div class="xss-margin"></div>
                              <div class="input-group input-daterange">
                                <input id="start" type="text" class="form-control" placeholder="eg. 01 March, 2017"/>
                                <span class="input-group-addon">to</span>
                                <input id="end" type="text" class="form-control" placeholder="eg. 01 April, 2017"/>
                              </div>
                              <!-- end input daterange -->

                              <div class="xss-margin"></div>
                              <a href="#" id="btnAddMoreDate" onclick="addMoreDate(); event.preventDefault();" class="btn btn-dark">Add More Date &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                            </div>
                            <!-- end col-md-9 -->

                            <div class="clearfix xs-margin"></div>
                            <div class="col-md-4">
                              <label><input id="radioByDayOfMonth" name="radioBulkOptions" type="radio" value="1" />&nbsp; By Day / Month</label>
                              <div class="clearfix"></div>
                              <span class="inline">Every
                                <select id="day" multiple="multiple" style="height: 180px" class="form-control">
                                  <option>- Select -</option>
                                  <option value="MON">Monday</option>
                                  <option value="TUE">Tuesday</option>
                                  <option value="WED">Wednesday</option>
                                  <option value="THU">Thursday</option>
                                  <option value="FRI">Friday</option>
                                  <option value="SAT">Saturday</option>
                                  <option value="SUN">Sunday</option>
                                </select>
                                of
                                <select id="month" multiple="multiple" style="height: 200px;" class="form-control">
                                  <option>- Select Month -</option>
                                  <option value="ALL">Every Month</option>
                                  <option value="1">January</option>
                                  <option value="2">February</option>
                                  <option value="3">March</option>
                                  <option value="4">April</option>
                                  <option value="5">May</option>
                                  <option value="6">June</option>
                                  <option value="7">July</option>
                                  <option value="8">August</option>
                                  <option value="9">September</option>
                                  <option value="10">October</option>
                                  <option value="11">November</option>
                                  <option value="12">December</option>
                                </select>
                              </span>
                            </div>
                            <!-- end col-md-4 -->

                            <div class="col-md-4">
                              <label><input id="radioByDaysOfYear" type="radio" name="radioBulkOptions" value="1"/>&nbsp; By Days / Year</label>
                              <div class="clearfix"></div>
                              <span class="inline">All
                                <select id="days" multiple="multiple" style="height: 180px;" class="form-control">
                                  <option>- Select -</option>
                                  <option value="MON">Mondays</option>
                                  <option value="TUE">Tuesdays</option>
                                  <option value="WED">Wednesdays</option>
                                  <option value="THU">Thursdays</option>
                                  <option value="FRI">Fridays</option>
                                  <option value="SAT">Saturdays</option>
                                  <option value="SUN">Sundays</option>
                                </select>
                                of
                                <select id="year" multiple="multiple" style="height: 200px;" class="form-control">
                                  <option>- Select Year -</option>
                                  @for($i = 0; $i < 10; $i++)
                                  <option value="{{ date('Y') + $i }}">{{ date('Y') + $i }}</option>
                                  @endfor
                                </select>
                              </span>
                              <div class="margin-top-10px"></div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-3 control-label">Room Restriction Text</label>
                            <div class="col-md-9">
                              <textarea id="roomRestrictionText" class="form-control" placeholder="eg. This special rate is for online booking only."></textarea>
                            </div>
                          </div>
                          <hr>

                          <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                              <a href="#" class="btn btn-dark" onclick="addMorePrices(); event.preventDefault();">
                                Add More Price &nbsp;
                                <i class="fa fa-plus"></i>
                              </a>&nbsp;
                            </div>
                          </div>
                          <hr>

                          <div class="form-actions">
                            <div class="col-md-offset-5 col-md-8">
                              <a href="#" class="btn btn-red" onclick="renderPricesToCalendar(); event.preventDefault();">Save &nbsp;
                                <i class="fa fa-floppy-o"></i>
                              </a>&nbsp;
                              <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--END MODAL add schedule-->
                </div>
                <!-- end portlet body -->
              </div>
              <div class="portlet">
                <div class="portlet-header">
                  <div class="caption">Purchase Availability</div>
                  <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                </div>
                <div class="portlet-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Creation Date</label>
                        <div class="col-md-4">
                          <div class="input-group">
                            <input type="text" name="created" class="datepicker-default form-control" data-date-format="dd/mm/yyyy" placeholder="17 Apr, 2015" value="<?php echo (isset($input['created'])) ? date('d M, Y',strtotime($input['created'])) : date('d M, Y'); ?>"/>
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Out of Stock Actions</label>
                        <div class="col-md-4">
                          <select class="form-control" name="out_of_stock_action">
                            <option value="none" <?php if(isset($input['out_of_stock_action']) && $input['out_of_stock_action'] == 'none'){ echo 'selected="selected"'; }; ?>>None</option>
                            <option value="signup"  <?php if(isset($input['out_of_stock_action']) && $input['out_of_stock_action'] == 'signup'){ echo 'selected="selected"'; }; ?>>Sign up for notification</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <!-- end col-md-12 -->
                  </div>
                  <!-- end row -->
                  <div class="clearfix"></div>
                </div>
                <!-- end portlet body -->
              </div>
              <!-- end purchase availability -->

              <div class="form-actions">
                <div class="col-md-offset-5 col-md-7">
                  <button type="submit" class="btn btn-red" />Add Service &nbsp;<i class="fa fa-floppy-o"></i></button>
                  <!-- <a onclick="$('#addColorForm').submit()" class="btn btn-red" href="#">Save &nbsp;<i class="fa fa-floppy-o"></i></a>-->&nbsp;
                  <a class="btn btn-green" data-dismiss="modal" href="{{ url('/web88cms/products/list') }}">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a>
                </div>
              </div>
            </form>
          </div>
          </div>
          <!-- end tab general -->

          <div id="images" class="tab-pane fade">
            <div class="portlet">
              <div class="portlet-header">
                <div class="caption">Additional Service Images</div>
                <div class="clearfix"></div>
                <span class="text-blue text-15px">Additional product images will be displayed in "Product Details" page. Thumbnails will be generated from detailed images automatically. Thumbnails will be resized to 128 x 128 pixels.</span>
                <div class="xs-margin"></div>
                <div class="clearfix"></div>
                <a href="#" class="btn btn-success">Add More Image &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
              </div>

              <div class="portlet-body">
                <div class="row">
                  <div class="col-md-12">
                    <form class="form-horizontal">
                      <div class="form-group border-bottom">
                        <label class="col-md-3 control-label">Upload Popup Larger Image of Additional Thumbnail</label>
                        <div class="col-md-9">
                          <div class="text-15px margin-top-10px">
                            <input id="exampleInputFile1" type="file"/>
                            <span class="help-block">(Image dimension: 800 x 800 pixels, JPEG/GIF/PNG only, Max. 2MB) </span>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                    </form>
                  </div>
                  <!-- end col-md-12 -->
                </div>
                <!-- end row -->
                <div class="clearfix"></div>
              </div>
              <!-- end portlet body -->
            </div>
            <!-- end portlet -->
            <!-- end images -->
          </div>
          <!-- end tab images -->

          <div id="description-feature" class="tab-pane fade">
            <div class="portlet">
              <div class="portlet-header">
                <div class="caption">Description</div>
                <div class="clearfix"></div>
                <span class="text-blue text-15px">You can edit the text by clicking the content below. </span>
                <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
              </div>

              <div class="portlet-body">
                <div class="row">
                  <div class="col-md-12">
                    <div id="description" contenteditable="true" onclick="$('#description').attr('contenteditable', true)">
                      <p><strong>Start edit the content by clicking the text.</strong></p>
                      <p>Start edit the content by clicking the text.</p>
                    </div>
                  </div>
                  <!-- end col-md-12 -->
                </div>
                <!-- end row -->
                <div class="clearfix"></div>
              </div>
              <!-- end portlet body -->
            </div>
            <!-- end portlet -->
            <!-- end description -->

            <div class="portlet">
              <div class="portlet-header">
                <div class="caption">Terms and Conditions</div>
                <div class="clearfix"></div>
                <span class="text-blue text-15px">You can edit the text by clicking the content below.</span>
                <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
              </div>

              <div class="portlet-body">
                <div class="row">
                  <div class="col-md-12">
                    <div id="terms_and_conditions" contenteditable="true" onclick="$('#terms_and_conditions').attr('contenteditable', true)">
                      <p><strong>Start edit the content by clicking the text.</strong></p>
                      <p>Start edit the content by clicking the text.</p>
                    </div>
                  </div>
                  <!-- end col-md-12 -->
                </div>
                <!-- end row -->
                <div class="clearfix"></div>
              </div>
              <!-- end portlet body -->
            </div>
            <!-- end portlet -->
            <!-- end features & video -->

            <div class="portlet">
              <div class="portlet-header">
                <div class="caption">Cancellation Policy</div>
                <div class="clearfix"></div>
                <span class="text-blue text-15px">You can edit the text by clicking the content below.</span>
                <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
              </div>

              <div class="portlet-body">
                <div class="row">
                  <div class="col-md-12">
                    <div id="cancellation_policy" contenteditable="true" onclick="$('#cancellation_policy').attr('contenteditable', true)">
                      <p><strong>Start edit the content by clicking the text.</strong></p>
                      <p>Start edit the content by clicking the text.</p>
                    </div>
                  </div>
                  <!-- end col-md-12 -->
                </div>
                <!-- end row -->
                <div class="clearfix"></div>
              </div>
              <!-- end portlet body -->
            </div>
            <!-- end portlet -->
            <!-- end warranty & support -->
          </div>
          <!-- end tab description & features -->

          <div id="shipping-info" class="tab-pane fade" style="display: none;">
            <div class="portlet">
              <div class="portlet-header">
                <div class="caption">Shipping Information</div>
                <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
              </div>

              <div class="portlet-body">
                <div class="row">
                  <div class="col-md-12">
                    <form class="form-horizontal" method="post" action="{{ url('/web88cms/products/updateShippingInformation') }}">
                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Weight (kg)</label>
                        <div class="col-md-3">
                          <input type="text" class="form-control" placeholder="0.00" value="0.00">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Free Shipping</label>
                        <div class="col-md-2">
                          <select class="form-control">
                              <option value="" selected="selected">No</option>
                              <option>Yes</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputFirstName" class="col-md-3 control-label">Shipping Cost (RM)</label>
                        <div class="col-md-3">
                          <input type="text" class="form-control" placeholder="0.00" value="0.00">
                        </div>
                      </div>
                      <div class="clearfix"></div>

                      <div class="form-actions">
                        <div class="col-md-offset-5 col-md-7">
                          <button type="submit" class="btn btn-red" />Save &nbsp;<i class="fa fa-floppy-o"></i></button>
                          <a class="btn btn-green" data-dismiss="modal" href="{{ url('/web88cms/products/list') }}">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- end col-md-12 -->
                </div>
                <!-- end row -->
                <div class="clearfix"></div>
              </div>
              <!-- end portlet body -->
            </div>
            <!-- end portlet -->
          </div>
          <!-- end tab shipping information -->

          <div id="quantity-discount" class="tab-pane fade">
            <div class="portlet">
              <div class="portlet-header">
                <div class="caption">Packages</div>
                <div class="clearfix"></div>
                <p class="margin-top-10px"></p>
                <a href="#" class="btn btn-success" data-hover="tooltip" data-placement="top" data-target="#modal-add-discount" data-toggle="modal">Add New Package &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                <div class="btn-group">
                  <button type="button" class="btn btn-primary">Delete</button>
                  <button type="button" data-toggle="dropdown" class="btn btn-red dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="#" data-target="#modal-delete-selected" data-toggle="modal">Delete selected item(s)</a></li>
                    <li class="divider"></li>
                    <li><a href="#" data-target="#modal-delete-all" data-toggle="modal">Delete all</a></li>
                  </ul>
                </div>
                <div class="tools"> <i class="fa fa-chevron-up"></i> </div>

                <!--Modal add discount start-->
                <div id="modal-add-discount" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                  <div class="modal-dialog modal-wide-width">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                        <h4 id="modal-login-label3" class="modal-title">Add Package</h4>
                      </div>
                      <div class="modal-body">
                        <div class="form">
                          <form class="form-horizontal" method="post" action="{{ url('/web88cms/products/addQuantityDiscount') }}">
                            <div class="form-group">
                              <label class="col-md-3 control-label">Status <span class="text-red">*</span></label>
                              <div class="col-md-6">
                                <div data-on="success" data-off="primary" class="make-switch">
                                  <input type="checkbox" name="status" checked="checked"/>
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="inputFirstName" class="col-md-3 control-label">Package Name</label>
                              <div class="col-md-6">
                                <input type="text" class="form-control" name="package_name" placeholder="Package Name">
                              </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                              <label for="inputFirstName" class="col-md-3 control-label">Package Code</label>
                              <div class="col-md-6">
                                <input type="text" class="form-control" name="package_code" placeholder="Package Code">
                              </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                              <label for="inputFirstName" class="col-md-3 control-label">StartDate To EndDate </label>
                              <div class="col-md-3" style="margin-right:-15px;">
                                <input type="date" class="form-control" name="start_date" placeholder="Start Date">
                              </div>
                              <div class="col-md-3 input-group">
                                <span class="input-group-addon" id="basic-addon1">To</span>
                                <input type="date" class="form-control" name="end_date" placeholder="End Date">
                              </div>
                            </div>
                            <div class="clearfix"></div>

                            <!-- <div class="form-group">
                              <label for="inputFirstName" class="col-md-3 control-label">From Quantity</label>
                              <div class="col-md-6">
                                <input type="text" class="form-control" name="from_quantity" placeholder="Qty">
                              </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                              <label for="inputFirstName" class="col-md-3 control-label">To Quantity</label>
                              <div class="col-md-6">
                                <input type="text" class="form-control" name="to_quantity" placeholder="Qty">
                              </div>
                            </div>
                            <div class="clearfix"></div> -->

                            <div class="form-group">
                              <label for="inputFirstName" class="col-md-3 control-label"><input type="radio" id="Discount" name="package_discount" value="discount"> Discount </label>
                              <div class="col-md-6">
                                <input type="text" class="form-control"  name="discount" placeholder="Amount">
                                <div class="xs-margin"></div>
                                <select name="discount_by" class="form-control">
                                  <option value="percentage" >%</option>
                                  <option value="amount">RM</option>
                                </select>
                              </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                              <label for="inputFirstName" class="col-md-3 control-label"><input type="radio" id="Price" name="package_discount" value="price"> Price</label>
                              <div class="col-md-6">
                                <input type="text" class="form-control" name="price" placeholder="Price">
                              </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                              <label for="inputFirstName" class="col-md-3 control-label">Check-In </label>
                              <div class="col-md-6">
                                <span class="checkbox-inline" style="margin-right: -17px;">
                                  Days
                                </span>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkin_mo" value=""> Mo
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkin_tu" value=""> Tu
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkin_we" value=""> We
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkin_th" value=""> Th
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkin_fr" value=""> Fr
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkin_sa" value=""> Sa
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkin_su" value=""> Su
                                </label>
                              </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                              <label for="inputFirstName" class="col-md-3 control-label">Check-Out </label>
                              <div class="col-md-6">
                                <span class="checkbox-inline" style="margin-right: -17px;">
                                  Days
                                </span>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkout_mo" value=""> Mo
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkout_tu" value=""> Tu
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkout_we" value=""> We
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkout_th" value=""> Th
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkout_fr" value=""> Fr
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkout_sa" value=""> Sa
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="checkout_su" value=""> Su
                                </label>
                              </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                              <label for="inputFirstName" class="col-md-3 control-label">Minimum Stay</label>
                              <div class="col-md-6">
                                <input type="text" class="form-control" name="minimum_stay" placeholder="Minimum Stay">
                              </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                              <label for="inputFirstName" class="col-md-3 control-label">Value Added Service</label>
                              <div class="col-md-6">
                                <input type="text" class="form-control" name="value_added_service" placeholder="eg.2 nights with breakfast">
                              </div>
                            </div>

                            <div class="form-actions">
                              <div class="col-md-offset-5 col-md-8">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                {{-- <input type="hidden" name="product_id" value="{{ $productDetails->id }}" /> --}}
                                <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button>&nbsp;
                                <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--END MODAL add new discount -->

                <!--Modal delete selected items start-->
                <div id="modal-delete-selected" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                        <h4 id="modal-login-label3" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                      </div>
                      <div class="modal-body">
                        <p><strong>#1:</strong> Price per item - RM 650.00 (Discount - RM 20.00)</p>
                        <div class="form-actions">
                          <div class="col-md-offset-4 col-md-8"> <a href="#" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- modal delete selected items end -->

                <!--Modal delete all items start-->
                <div id="modal-delete-all" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                        <h4 id="modal-login-label3" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete all items? </h4>
                      </div>
                      <div class="modal-body">
                        <div class="form-actions">
                          <div class="col-md-offset-4 col-md-8"> <a href="#" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- modal delete all items end -->
              </div>
              <div id="modal-delete-2" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                      <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete this item? </h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-actions">
                        <div class="col-md-offset-4 col-md-8"> <a href="javascript:void(0)" class="btn btn-red" onclick="continue_delete_process_packages()">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="javascript:void(0)" data-dismiss="modal" class="btn btn-green" onclick="cancel_delete()">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php if(count($quantity_discounts) > 0) {
                $arr_get = Input::get();
                unset($arr_get['page']);
                $query_string = http_build_query($arr_get);

                $per_page = (Session::has('quantity_discount.per_page')) ? Session::get('quantity_discount.per_page') : 30;
              ?>
              <div class="portlet-body">
                <div class="form-inline pull-left">
                  <div class="form-group">
                    <select name="select" class="form-control" onchange="set_per_page(this.value,'quantity_discount','{{ Request::path() }}','{{ ($query_string)?$query_string:'activetab=quantity-discount' }}')">
                      <option <?php if($per_page == 10){ echo 'selected="selected"'; } ?>>10</option>
                      <option <?php if($per_page == 20){ echo 'selected="selected"'; } ?>>20</option>
                      <option <?php if($per_page == 30){ echo 'selected="selected"'; } ?>>30</option>
                      <option <?php if($per_page == 50){ echo 'selected="selected"'; } ?>>50</option>
                      <option <?php if($per_page == 100){ echo 'selected="selected"'; } ?>>100</option>
                    </select>
                    &nbsp;
                    <label class="control-label">Records per page</label>
                  </div>
                </div>
                <div class="clearfix"></div>
                <br/>
                <div class="table-responsive mtl">
                  {{-- <span class="text-red"><b>Sale Price: RM 0.00</b></span> --}}
                  <table id="example1" class="table table-hover table-striped">
                    <thead>
                      <tr>
                        <th width="1%"><input type="checkbox" id="select_items"/></th>
                        <th>#</th>
                        <th>Package Name</th>
                        <th>Package Code</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $i = 1;
                      foreach($quantity_discounts as $details) {
                        $status_class = ($details->status == '0') ? 'label-red' : 'label-success';
                        $status = ($details->status == '0') ? 'In-active' : 'Active';
                    ?>
                      <tr>
                        <td><input type="checkbox" data-id="<?php echo $details->id; ?>" class="select_items"/></td>
                        <td>{{ $i }}</td>
                        <td>{{ $details->package_name }}</td>
                        <td>{{ $details->package_code }}<br/></td>
                        <td><span class="label label-sm <?php echo $status_class; ?>"><?php echo $status; ?></span></td>
                        <td>
                          <a href="#" data-hover="tooltip" data-placement="top" title="Edit" data-target="#modal-edit-discount-<?php echo $details->id; ?>" data-toggle="modal">
                            <span class="label label-sm label-success"><i class="fa fa-pencil"></i></span>
                          </a>
                          <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-2" data-toggle="modal" onclick="delete_item(<?php echo $details->id; ?>)"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>
                          <!--Modal edit discount start-->
                          <div id="modal-edit-discount-<?php echo $details->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                            <div class="modal-dialog modal-wide-width">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                  <h4 id="modal-login-label3" class="modal-title">Edit Package</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="form">
                                    <form class="form-horizontal" method="post" action="{{ url('/web88cms/products/updateQuantityDiscount/') }}">
                                      <div class="form-group">
                                        <label class="col-md-3 control-label">Status <span class="text-red">*</span></label>
                                        <div class="col-md-6">
                                          <div data-on="success" data-off="primary" class="make-switch">
                                            <input type="checkbox" name="status" <?php if($details->status == '1'){ echo 'checked="checked"'; } ?>/>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="inputFirstName" class="col-md-3 control-label">Package Name</label>
                                        <div class="col-md-6">
                                          <input type="text" class="form-control" name="package_name" placeholder="Package Name" value="{{ $details->package_name }}">
                                        </div>
                                      </div>
                                      <div class="clearfix"></div>

                                      <div class="form-group">
                                        <label for="inputFirstName" class="col-md-3 control-label">Package Code</label>
                                        <div class="col-md-6">
                                          <input type="text" class="form-control" name="package_code" placeholder="Package Code" value="{{ $details->package_code }}">
                                        </div>
                                      </div>
                                      <div class="clearfix"></div>

                                      <div class="form-group">
                                        <label for="inputFirstName" class="col-md-3 control-label">StartDate To EndDate </label>
                                        <div class="col-md-3" style="margin-right:-15px;">
                                          <input type="date" class="form-control" name="start_date" placeholder="Start Date" value="{{ $details->start_date }}">
                                        </div>
                                        <div class="col-md-3 input-group">
                                          <span class="input-group-addon" id="basic-addon1">To</span>
                                          <input type="date" class="form-control" name="end_date" placeholder="End Date" value="{{ $details->end_date }}">
                                        </div>
                                      </div>
                                      <div class="clearfix"></div>

                                      <div class="form-group">
                                        <label for="inputFirstName" class="col-md-3 control-label"><input type="radio" id="Discount" name="package_discount" value="discount" @if($details->package_discount == 'discount') checked @endif> Discount </label>
                                        <div class="col-md-6">
                                          <input type="text" class="form-control" placeholder="Amount" name="discount" value="{{ number_format($details->discount,2) }}">
                                          <div class="xs-margin"></div>
                                          <select name="discount_by" class="form-control">
                                            <option value="percentage" <?php if($details->discount_by == 'percentage'){ echo 'selected="selected"'; } ?> >%</option>
                                            <option value="amount" <?php if($details->discount_by == 'amount'){ echo 'selected="selected"'; } ?>>RM</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="clearfix"></div>

                                      <div class="form-group">
                                        <label for="inputFirstName" class="col-md-3 control-label"><input type="radio" id="Price" name="package_discount" value="price" @if($details->package_discount == 'price') checked @endif> Price</label>
                                        <div class="col-md-6">
                                          <input type="text" class="form-control" name="price" placeholder="Price" value="{{ $details->price }}">
                                        </div>
                                      </div>
                                      <div class="clearfix"></div>

                                      <div class="form-group">
                                        <label for="inputFirstName" class="col-md-3 control-label">Check-In </label>
                                        <div class="col-md-6">
                                          <span class="checkbox-inline" style="margin-right: -17px;">
                                            Days
                                          </span>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkin_mo" <?php if($details->checkin_mo == '1'){ echo 'checked="checked"'; }?>> Mo
                                          </label>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkin_tu" <?php if($details->checkin_tu == '1'){ echo 'checked="checked"'; }?>> Tu
                                          </label>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkin_we" <?php if($details->checkin_we == '1'){ echo 'checked="checked"'; }?>> We
                                          </label>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkin_th" <?php if($details->checkin_th == '1'){ echo 'checked="checked"'; }?>> Th
                                          </label>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkin_fr" <?php if($details->checkin_fr == '1'){ echo 'checked="checked"'; }?>> Fr
                                          </label>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkin_sa" <?php if($details->checkin_sa == '1'){ echo 'checked="checked"'; }?>> Sa
                                          </label>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkin_su" <?php if($details->checkin_su == '1'){ echo 'checked="checked"'; }?>> Su
                                          </label>
                                        </div>
                                      </div>
                                      <div class="clearfix"></div>

                                      <div class="form-group">
                                        <label for="inputFirstName" class="col-md-3 control-label">Check-Out </label>
                                        <div class="col-md-6">
                                          <span class="checkbox-inline" style="margin-right: -17px;">
                                            Days
                                          </span>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkout_mo" <?php if($details->checkout_mo == '1'){ echo 'checked="checked"'; }?>> Mo
                                          </label>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkout_tu" <?php if($details->checkout_tu == '1'){ echo 'checked="checked"'; }?>> Tu
                                          </label>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkout_we" <?php if($details->checkout_we == '1'){ echo 'checked="checked"'; }?>> We
                                          </label>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkout_th" <?php if($details->checkout_th == '1'){ echo 'checked="checked"'; }?>> Th
                                          </label>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkout_fr" <?php if($details->checkout_fr == '1'){ echo 'checked="checked"'; }?>> Fr
                                          </label>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkout_sa" <?php if($details->checkout_sa == '1'){ echo 'checked="checked"'; }?>> Sa
                                          </label>
                                          <label class="checkbox-inline">
                                            <input type="checkbox" name="checkout_su" <?php if($details->checkout_su == '1'){ echo 'checked="checked"'; }?>> Su
                                          </label>
                                        </div>
                                      </div>
                                      <div class="clearfix"></div>

                                      <div class="form-group">
                                        <label for="inputFirstName" class="col-md-3 control-label">Minimum Stay</label>
                                        <div class="col-md-6">
                                          <input type="text" class="form-control" name="minimum_stay" placeholder="Minimum Stay" value="{{ $details->minimum_stay }}">
                                        </div>
                                      </div>
                                      <div class="clearfix"></div>

                                      <div class="form-group">
                                        <label for="inputFirstName" class="col-md-3 control-label">Value Added Service</label>
                                        <div class="col-md-6">
                                          <input type="text" class="form-control" name="value_added_service" placeholder="eg.2 nights with breakfast" value="{{ $details->value_added_service }}">
                                        </div>
                                      </div>

                                      <div class="form-actions">
                                        <div class="col-md-offset-5 col-md-8">
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                          <input type="hidden" id="discount_id" name="discount_id" value="{{ $details->id }}" />
                                          <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button>&nbsp;
                                          <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!--END MODAL edit discount -->
                        </td>
                      </tr>
                    <?php
                        $i++;
                      } // end foreach
                    ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="6"></td>
                      </tr>
                    </tfoot>
                  </table>
                  <div class="tool-footer text-right">
                    <p class="pull-left"><?php echo $pagination_report; ?></p>
                    <?php echo $quantity_discounts->setPath(Request::url())->appends(['activetab' => 'quantity-discount'])->render(); ?>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
              <input type="hidden" id="delete_item_ids" value="{{ $details->id }}" />
              {{-- <input type="hidden" id="product_id" value="{{ $productDetails->id }}" /> --}}
              <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}" />
              <input type="hidden" id="query_string" value="{{ $query_string }}" />
              <script>
                // select all checkboxes
                $(document).ready(function() {
                  $('#select_items').click(function() {
                    //alert('asd');
                    //if($('.select_items').length() > 0)
                    if($('#select_items').is(':checked')) {
                      $('.select_items').prop('checked',true);
                    } else {
                      $('.select_items').prop('checked',false);
                    }
                  });
                });
              </script>
            <?php
              }
            ?>
            <!-- end portlet body -->
            </div>
              <!-- end portlet body -->
            </div>
            <!-- end portlet -->
          </div>
          <!-- end tab quantity discounts -->
        </div>
        <!-- end tab content -->
        <div class="clearfix"></div>
      </div>
      <!-- end col-lg-12 -->
    </div>
    <!-- end row -->
  </div>
  <!--END CONTENT-->

  <!--BEGIN FOOTER-->
  <div class="page-footer">
    <div class="copyright">
      <span class="text-15px">2015 &copy; <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
      <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies Sdn Bhd"></div>
    </div>
  </div>
  <!--END FOOTER--></div>
</div>
<!--END PAGE WRAPPER-->

@push('scripts')
<!--LOADING SCRIPTS FOR PAGE-->

<script src="{{ asset('/public/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/moment/moment.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-clockface/js/clockface.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/jquery-maskedinput/jquery-maskedinput.js') }}"></script>
<script src="{{ asset('/public/admin/js/form-components.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('/public/admin/js/price-calendar.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/public/admin/js/ui-tabs-accordions-navs.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

    /* if tax rate checked then reserve tax collection will be disbaled */
    $('#is_tax').click(function () {
        console.log("$(this).is(':checked')");
        console.log($(this).is(':checked'));
        if($(this).is(':checked')) {
            $("#reverse_tax_calculation").prop('disabled', true);
        } else {
            $("#reverse_tax_calculation").prop('disabled', false);
        }
    });

    $("#reverse_tax_calculation").click(function () {
        console.log("$(this).is(':checked')");
        console.log($(this).is(':checked'));
        if($(this).is(':checked')) {
            $('#is_tax').prop('disabled', true);
            $("#net_price_per_night").prop('disabled', true);
            $("#net_price_per_night").prop('checked', false);
        } else {
            $('#is_tax').prop('disabled', false);
        }
    });

    $("#net_price_per_night").click(function () {
        console.log("$(this).is(':checked')");
        console.log($(this).is(':checked'));
        if($(this).is(':checked')) {
            $("#reverse_tax_calculation").prop('disabled', true);
            $("#reverse_tax_calculation").prop('checked', false);
        } else {
            $("#reverse_tax_calculation").prop('disabled', false);
            $("#reverse_tax_calculation").prop('checked', true);
        }
    });


    $(document).ready(function(){
        var checkbox=$('#net_price_per_night')
        // checkbox.on('click',checkStatus);

function checkStatus() {

  // if at least one checkbox in selected checkboxes is checked then
  // disable target checkboxes
  if($(checkbox).is(':checked'))
  {
      $("#reverse_tax_calculation").prop('disabled', false);

  }
  else{
      $("#reverse_tax_calculation").prop('disabled', true);
      $("#reverse_tax_calculation").prop('checked', false);
  }
}
    })

  function continue_delete_process_packages()
  {
    var item_id = $('#discount_id').val();
    // ajax call to delete messages
    $.ajax({
        type : 'POST',
        url : '{{url("web88cms/products/deleteQuantityDiscount")}}',
        data : 'item_id='+item_id+'&_token='+$('#csrf_token').val(),
        success : function(response){
          window.location.href = '{{url("web88cms/products/addProduct")}}';
        }
    });	// end ajax
  }
</script>
@endpush

@endsection
