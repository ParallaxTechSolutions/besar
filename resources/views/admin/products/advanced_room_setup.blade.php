<?php
/* ini_set('post_max_size','8M');
ini_set('suhosin.post.max_vars','5000');
ini_set('suhosin.request.max_vars','5000');
phpinfo();
exit; */
?>
@extends('adminLayout')
@section('title', 'Advanced Room Setup')
@section('css')

@endsection
@section('content')
<style>
.table-scroll {
  position:relative;
  margin:auto;
  overflow:hidden;
  /*border:1px solid #000;*/
}

.DTFC_LeftBodyLiner{
    /* overflow-y:hidden !important;*/
    height: 515px !important;
    direction: rtl !important;
    overflow-x: hidden !important;
    width: auto !important;
}
.DTFC_Cloned{
    direction: ltr;
    background: white;
}
.DTFC_LeftBodyWrapper{
    height: 500px !important;
    margin-top: 20px !important;
}
.dataTables_scrollBody{
    overflow-y: scroll !important;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none;  /* Internet Explorer 10+ */
}
.dataTables_scrollBody::-webkit-scrollbar { /* WebKit */
    width: 0;
    height: 0;
}
.table-scroll table {
  width:100%;
  margin:auto;
  border-collapse:separate;
  border-spacing:0;
}
.table-scroll th, .table-scroll td {
  padding: 3px 3px 10px 3px;
  /*padding:5px 10px;
  border:1px solid #000;
  background:#fff;*/
  white-space:nowrap;
  vertical-align:top;
}
.table-scroll thead, .table-scroll tfoot {
  background:#f9f9f9;
}
.clone {
  position:absolute;
  top:0;
  left:0;
  pointer-events:none;
}
.clone th, .clone td {
  visibility:hidden
}
.clone td, .clone th {
  border-color:transparent
}
.clone tbody th {
  visibility:visible;
  color:red;
}
.clone .fixed-side {
  border:1px solid #333;
  background:#eee;
  visibility:visible;
}
.clone thead, .clone tfoot{background:transparent;}
.each_product_roomprice_box input.form-control{
  padding: 0px;
  text-align: center;
  /* margin: auto; */
}
.doubleScroll-scroll-wrapper{
  visibility: hidden;
}
.DTFC_LeftBodyLiner{
  visibility: hidden;
}
</style>
<?php
$filter_start_date = (isset($_GET['start_date']) ? $_GET['start_date'] : date('d/m/Y'));
$filter_days = (isset($_GET['filter_days']) ? $_GET['filter_days'] : 14);
$filter_room_type = (isset($_GET['filter_room_type']) ? $_GET['filter_room_type'] : 0);

?>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper"><!--BEGIN PAGE HEADER & BREADCRUMB-->

  <div class="page-header-breadcrumb">
    <div class="page-heading hidden-xs">
      <h1 class="page-title">Advanced Room Setup</h1>
    </div>


    <ol class="breadcrumb page-breadcrumb">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
      <li>Services &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
      <li class="active">Advanced Room Setup</li>
    </ol>
  </div>
  <!--END PAGE HEADER & BREADCRUMB--><!--BEGIN CONTENT-->
  <div class="page-content">
    <div class="row">
      <div class="col-lg-12">
        <h2>Advanced Room <i class="fa fa-angle-right"></i> Setup</h2>
        <div class="clearfix"></div>

        <div class="pull-left"> Last updated: <span class="text-blue"><?php echo date('d M, Y @ g:i A',strtotime($last_modified)); ?></span> </div>
        <div class="clearfix"></div>
        @if ($success)
        <div class="alert alert-success alert-dismissable">
         <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
         <i class="fa fa-check-circle"></i> <strong>Success!</strong>
         <p>{{ $success }}</p>
       </div>
       @endif


       <div class="clearfix"></div>
     </div>
     <!-- end col-lg-12 -->
     <div class="col-md-6">
      <div class="portlet portlet-blue">
          <div class="portlet-header">
            <div class="caption text-white">Quick Filter by Room &amp; Date</div>
          </div>
          <div class="portlet-body">
            <form method="get" class="form-horizontal" _lpchecked="1">
              <div class="form-group">
                <label class="col-md-4 control-label">Room Type </label>
                <div class="col-md-8">
                  <select name="filter_room_type" class="form-control">
                    <!-- <option>-Please select a room type-</option> -->
                    <option value="all" {{$filter_room_type == 0 ? 'selected' : ''}}>List all rooms here</option>
                    @foreach($room_types as $k => $v)
                      <option {{$filter_room_type == $v->id ? 'selected' : ''}} value="{{$v->id}}">{{$v->type_name}}</option>
                    @endforeach

                  </select>
                </div>
              </div>

              <div class="form-group">

                      <label for="inputFirstName" class="col-md-4 control-label">Start Date</label>

                    <div class="col-md-8">
                          <div class="input-group">
                            <input name="filter_start_date" type="text" class="datepicker-default form-control" data-date-format="dd/mm/yyyy" placeholder="25 Sept, 2019" value="{{$filter_start_date}}">
                              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>

                          </div>
                      </div>

              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Days </label>
                <div class="col-md-8">
                  <select class="form-control" name="filter_days">
                    <option {{ $filter_days == 3 ? 'selected="selected"' : '' }} value="3">3</option>
                    <option {{ $filter_days == 5 ? 'selected="selected"' : '' }} value="5">5</option>
                    <option {{ $filter_days == 7 ? 'selected="selected"' : '' }} value="7">7</option>
                    <option {{ $filter_days == 14 ? 'selected="selected"' : '' }} value="14">14</option>
                    <option {{ $filter_days == 21 ? 'selected="selected"' : '' }} value="21">21</option>
                    <option {{ $filter_days == 28 ? 'selected="selected"' : '' }} value="28">28</option>
                    <option {{ $filter_days == 35 ? 'selected="selected"' : '' }} value="35">35</option>
                    <option {{ $filter_days == 42 ? 'selected="selected"' : '' }} value="42">42</option>
                    <option {{ $filter_days == 49 ? 'selected="selected"' : '' }} value="49">49</option>
                  </select>
                </div>
              </div>

              <!-- save button start -->
              <div class="form-actions text-center"> <button type="submit" class="btn btn-red">Load</button> </div>
              <!-- save button end -->
            </form>
          </div>
          <!-- end portlet-body -->
        </div>
      <!-- end portlet -->
    </div>
    <!-- end col-md-6 -->
    <div class="col-lg-12">

                <p>@if (Session::has('flash_message'))
        <div class="alert alert-success alert-dismissable">
          <button type="button" data-dismiss="alert" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
          <i class="fa fa-check-circle"></i> <strong>Success!</strong> {{ Session::get('flash_message') }}</div>
          @endif
        </p>
        <!-- {{ $error = Session::get('error') }}
            {{ Session::get('error') }}-->
            @if($error)
            <div class="alert alert-danger alert-dismissable">
                <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                <i class="fa fa-times-circle"></i> <strong>Error!</strong>
                <p>{{ $error }}</p>
                </div>
          @endif



      <ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#brand-image" data-toggle="tab">Rooms & Suites</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
        <div id="brand-image" class="tab-pane fade in active">
          <div class="portlet">
                <div class="portlet-header">

                  <p class="clearfix margin-top-10px"></p>
                  <div class="text-center">
                    <!-- <a href="#" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp; Prev</a>
                    <a href="#" class="btn btn-default">Next &nbsp;<i class="fa fa-arrow-right"></i></a> -->
                    <button class="btn btn-red tableSaveBtn">Save &nbsp;<i class="fa fa-save"></i></button>
                  </div>


                  <div class="tools"> <i class="fa fa-chevron-up"></i> </div>



                </div>
                <div class="portlet-body">

                  <div class="table-responsive mtl">


                    <?php
                    if(sizeof($table_data[key($table_data)]) > 0)
                    {
                         // echo http_build_query(Input::get());

                     $arr_get = Input::get();
                     unset($arr_get['page']);
                     $query_string = http_build_query($arr_get);

                     $per_page_records = (Session::has('product.per_page')) ? Session::get('product.per_page') : 100;

                     ?>

                    <div class="clearfix"></div>
                  <br/>
                  <br/>
                    <input type="hidden" id="delete_item_ids" value="0" />
                    <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" id="query_string" value="{{ $query_string }}" />
                    <form id="update_adv_room_data" method="post" enctype="multipart/form-data">
                      <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}" />
                      <div id="table-scroll" class="table-scroll">
                              <div class="table-wrap" >
                                 <table id="fixTable" class="table table-bordered">
                                      <thead>
                                        <tr>
                                          <th style="border-right:none !important" class="x"></th>
                                          <th style="border-left:none !important" class="y"></th>
                                          <th></th>
                                          <!-- <th class="text-center"><a href="javascript:void(0)" onclick="previousMonth()"><i class="fa fa-chevron-left"></i></a></th> -->
                                          <?php
                                              $last_month = '';
                                              $colspan = 1;
                                              $month_html = '';
                                              $month_html_array = [];
                                           ?>
                                          @foreach($dates_array as $key => $val)
                                          <?php
                                          //echo '<th>'.($key+1).' == ' .count($table_data[key($table_data)]). '</th>';
                                          if($val->month_name != $last_month){
                                            if($last_month != '')array_push($month_html_array, $month_html);
                                            $last_month = $val->month_name;
                                            $colspan = 1;
                                            $month_html = '<th class="text-center month_colspan_fix" colspan="'.$colspan.'">'.$val->month_name.'</th>';
                                          }else if($val->month_name == $last_month || ($key+1) == count($dates_array) ){
                                            $colspan++;
                                            $month_html = '<th class="text-center month_colspan_fix" colspan="'.$colspan.'">'.$val->month_name.'</th>';
                                            if(($key+1) == count($dates_array)){
                                              array_push($month_html_array, $month_html);
                                            }
                                          }
                                          ?>
                                          @endforeach
                                          <!-- <th colspan="13" class="text-center">September</th> -->
                                          @foreach($month_html_array as $key => $val)
                                            {!!$val!!}
                                          @endforeach
                                          <!-- <th class="text-center"><a href="javascript:void(0)" onclick="nextMonth()"><i class="fa fa-chevron-right"></i></a></th> -->
                                       </tr>
                                        <tr>
                                          <th style="border-right:none !important"></th>
                                          <th style="border-left:none !important"></th>
                                          <th class="fix-col-2"><a href="#sort by booking id">Room Type</a></th>
                                          @foreach($dates_array as $key => $val)
                                              <th {!!(in_array($val->date_day_name,['Sat', 'Sun']) ? 'class="text-center text-white" bgcolor="#b8312f"' : 'class="text-center"')!!}>{{$val->date_day}}<br>{{$val->date_day_name}}</th>
                                          @endforeach
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($table_data as $key2 => $val2)
                                            <?php
                                            $is_empty = (isset($val2[0]->is_empty) && $val2[0]->is_empty == 1? true : false);
                                            $first_status = (isset($val2[0]->status) ? $val2[0]->status : 0);
                                            $product_id = $key2;
                                            ?>
                                            <tr class="room_type_row" product_id="{{$product_id}}">
                                                <td></td>
                                              <td class="head-col">

                                                <a style="display: {{($first_status != 1 ? 'none' : '')}}" class="btn-xs btn-success plm changeStatusAll" data-hover="tooltip" data-placement="bottom" title="" data-original-title="Open"></a>

                                                <a style="display: {{($first_status == 1 ? 'none' : '')}}" class="btn-xs btn-dark plm changeStatusAll" data-hover="tooltip" data-placement="bottom" title="" data-original-title="Closed"></a>
                                              </td>
                                              <td class="head-col"><span class="text-12px">{{$val2[0]->type}}</span> </td>
                                            @foreach($dates_array as $key3 => $val3)
                                            <?php
                                            /* echo '<pre>';
                                              print_r($val3);
                                              exit; */
                                              $is_new_record = false;
                                              if( !$is_empty && isset($val2[$key3]) && isset($val2[$key3]->date) && $val2[$key3]->date == $val3->date ){
                                                $val3 = $val2[$key3];
                                              }else{
                                                $is_new_record = true;
                                                $val3 = (object)[
                                                                  'id' => 0,
                                                                  'sale_price' => 0,
                                                                  'qty_stock' => 0,
                                                                  'total_orders' => 0,
                                                                  'status' => 0,
                                                                  'date' => $val3->date,
                                                                ];
                                              }
                                              if($is_empty || $is_new_record){
                                                $val3->id = uniqid();//abs( crc32( uniqid() ) );
                                                $val3->sale_price = 0;
                                                $val3->qty_stock = 0;
                                                $val3->total_orders = 0;
                                                $val3->status = 0;
                                              }
                                            ?>
                                               <td>
                                                  @if($is_empty || $is_new_record)
                                                  <input type="hidden" value="1" name="update[{{$val3->id}}][is_new_entry]">
                                                  <input type="hidden" value="{{$val3->date}}" name="update[{{$val3->id}}][date]">
                                                  <input type="hidden" value="{{$product_id}}" name="update[{{$val3->id}}][product_id]">


                                                  @endif
                                                  <table class="each_product_roomprice_box" row_prp_id="{{$val3->id}}" width="100%" border="0" cellpadding="0" cellspacing="0">
                                                      <tbody>
                                                        <tr>
                                                          <td>
                                                            <input class="is_updated_entry" type="hidden" value="0" name="update[{{$val3->id}}][is_updated_entry]">
                                                            <input name="update[{{$val3->id}}][sale_price]" type="text" class="form-control text-12px price_box" placeholder="Room Price" value="{{$val3->sale_price}}" data-hover="tooltip" data-placement="bottom" title="" style="width: 45px" data-original-title="Room Price">
                                                          </td>
                                                          <td>
                                                            <input name="update[{{$val3->id}}][qty_stock]" type="text" class="form-control text-12px qty_box" placeholder="Available Unit" value="{{$val3->qty_stock}}" data-hover="tooltip" data-placement="left" title="" style="width: 40px;" data-original-title="Available Unit">
                                                          </td>
                                                        </tr>

                                                      <tr>
                                                        <td><span class="badge badge-blue xss-margin" data-hover="tooltip" data-placement="top" title="" data-original-title="Booking Received">{{$val3->total_orders}}</span></td>
                                                        <td>
                                                          <input name="update[{{$val3->id}}][status]" type="hidden" class="update_status status_box" value="{{$val3->status}}" >
                                                          <a style="display: {{($val3->status != 1 ? 'none' : '')}}" class="btn-xs btn-success plm changeStatus" data-hover="tooltip" data-placement="top" title="" data-original-title="Open"></a>
                                                          <a style="display: {{($val3->status == 1 ? 'none' : '')}}" class="btn-xs btn-dark plm changeStatus" data-hover="tooltip" data-placement="top" title="" data-original-title="Closed"></a>

                                                        </td>
                                                      </tr>
                                                    </tbody>

                                                  </table>
                                              </td>
                                            @endforeach
                                            </tr>
                                          @endforeach

                                    </tbody>

                                 </table>

                              </div><!-- end table wrap -->
                            </div>
                            <!-- end table scroll-->
                          </form><!-- end form-->


                      <script type="text/javascript">
                      function uniquefun(val, sn)
                      {
                        // alert('hello');
                        var inputs = $(".alldisplayord");

                        for(var i = 0; i <= inputs.length; i++){
                          if($(inputs[i]).val()==val && i!=sn-1){
                            alert("Order '"+val+"' is already in use. Please try another!");
                            return false;
                          }
                        }
                      }
                      </script>





                      {{-- <div class="tool-footer text-right">
                      </div> --}}
                      <div class="clearfix"></div>
                      <div class="form-actions text-center md-margin"> <button class="btn btn-red tableSaveBtn">Save &nbsp;<i class="fa fa-save"></i></button> </div>
                      <?php
                    }
                    else
                    {
                      echo 'No service found.';
                    }
                    ?>
                    <div class="clearfix"></div>
                  </div>
                  <!-- end table responsive -->
                </div>
              </div>
            </div>
            <!-- end background image -->
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
      <div class="copyright"><span class="text-15px">2015 &copy; <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
       <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies Sdn Bhd"></div>
     </div>
   </div>
   <!--END FOOTER--></div>
   <!--END PAGE WRAPPER-->


   <!--LOADING SCRIPTS FOR PAGE-->
   <script src="{{ asset('/public/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
   <script src="{{ asset('/public/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
   <script src="{{ asset('/public/admin/vendors/moment/moment.js') }}"></script>
   <script src="{{ asset('/public/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
   <script src="{{ asset('/public/admin/vendors/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
   <script src="{{ asset('/public/admin/vendors/bootstrap-clockface/js/clockface.js') }}"></script>
   <script src="{{ asset('/public/admin/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
   <script src="{{ asset('/public/admin/vendors/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
   <script src="{{ asset('/public/admin/vendors/jquery-maskedinput/jquery-maskedinput.js') }}"></script>
   <script src="{{ asset('/public/admin/js/form-components.js') }}"></script>
   <!--LOADING SCRIPTS FOR PAGE-->

   <script src="{{ asset('/public/admin/vendors/tinymce/js/tinymce/tinymce.min.js') }}"></script>
   <script src="{{ asset('/public/admin/vendors/ckeditor/ckeditor.js') }}"></script>
   <script src="{{ asset('/public/admin/js/ui-tabs-accordions-navs.js') }}"></script>
   <script src="{{ asset('/public/admin/js/jquery.jsscroll.min.js') }}"></script>
   {{-- <script src="https://cdn.jsdelivr.net/npm/tableheadfixer@1.0.2/jquery.tableheadfixer.min.js"></script> --}}
   {{-- #The script version or source(cdn or local) may vary, just pay attention for jquery.dataTables.min.js and dataTables.fixedColumns.min.js  --}}

<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.3.1/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="{{asset('public/admin/js/jquery.doubleScroll.js')}}"></script>

   <script type="text/javascript">

    // select all checkboxes
$(document).ready(function(){
   $(document).on('change, input', 'input.status_box, input.qty_box, input.price_box',function(){
      if( $(this).hasClass('price_box') || $(this).hasClass('qty_box') ){
        $(this).attr('value',$(this).val());
      }
      $(this).parents('.each_product_roomprice_box:first').find('.is_updated_entry:first').val(1);
      //$(this).closest('.is_updated_entry').val(1);
      console.log($(this).parents('.each_product_roomprice_box:first').find('.is_updated_entry:first').val());
      console.log('done');
   });
   $(document).on('click', '.tableSaveBtn',function(e){
      e.preventDefault();
      $('#update_adv_room_data').submit();
   });
   $(document).on('click', '.changeStatus, .changeStatusAll',function(){
    if($(this).hasClass('changeStatusAll')){
        var product_id = $(this).parents('.room_type_row:first').attr('product_id');
        if($(this).hasClass('btn-dark'))
        {
          $('tr[product_id="'+product_id+'"] .each_product_roomprice_box .update_status').val(1);
          $('tr[product_id="'+product_id+'"] .each_product_roomprice_box .changeStatus').hide();
          $('tr[product_id="'+product_id+'"] .each_product_roomprice_box .changeStatus.btn-success').show();
          $(this).parent().find('.changeStatusAll').hide();
          $(this).parent().find('.changeStatusAll.btn-success').show();

        }
        else if($(this).hasClass('btn-success')){
          $('tr[product_id="'+product_id+'"] .each_product_roomprice_box .update_status').val(0);
          $('tr[product_id="'+product_id+'"] .each_product_roomprice_box .changeStatus').hide();
          $('tr[product_id="'+product_id+'"] .each_product_roomprice_box .changeStatus.btn-dark').show();
          $(this).parent().find('.changeStatusAll').hide();
          $(this).parent().find('.changeStatusAll.btn-dark').show();
        }
        $('tr[product_id="'+product_id+'"] .each_product_roomprice_box .is_updated_entry').val(1);

    }else{

        if($(this).hasClass('btn-success'))
        {
          console.log(0);
          $(this).hide();
          $(this).parent().find('.btn-dark').show();
          $(this).parent().find('.update_status').val(0);

        }
        else if($(this).hasClass('btn-dark')){
          console.log(1);
          $(this).hide();
          $(this).parent().find('.btn-success').show();
          $(this).parent().find('.update_status').val(1);
        }
        $(this).parents('.each_product_roomprice_box:first').find('.is_updated_entry:first').val(1);

    }


   });
});

</script>
<script>
  $(document).ready(function(){
       var tab=$('#fixTable').DataTable({
            paging: false,
            fixedColumns: {
        leftColumns: 3
        },
            scrollY: 500,
            scrollX: 200,
            "searching": false,
            "bFilter": false,
            "bInfo": false,
            "ordering": false
        });
        tab.columns.adjust().draw();
      $('.dataTables_scrollBody').doubleScroll({
          scrollCss: {
      'overflow-x': 'scroll',
      'overflow-y': 'scroll'
    },
      });

    $("#fixTable_wrapper").mouseover(function(){
      $(".doubleScroll-scroll-wrapper").css("visibility", "visible");
      $(".DTFC_LeftBodyLiner").css({"visibility": "visible", 'max-height': '500px'});
    });
    $("#fixTable_wrapper").mouseout(function(){
      $(".doubleScroll-scroll-wrapper").css("visibility", "hidden");
      $(".DTFC_LeftBodyLiner").css("visibility", "hidden");
    });
  });
</script>

@endsection
