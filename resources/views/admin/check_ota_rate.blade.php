@extends('adminLayout')
@section('title', 'Check OTA Rate')
@section('content')
<style>
.table-scroll {
  position:relative;

  margin:auto;
  overflow:hidden;
  /*border:1px solid #000;*/
}
.table-wrap {
  width:100%;
  overflow:auto;
}
.table-scroll table {
  width:100%;
  margin:auto;
  border-collapse:separate;
  border-spacing:0;
}
.table-scroll th, .table-scroll td {
  padding: 2px;
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
      <h1 class="page-title">Bookings</h1>
    </div>


    <ol class="breadcrumb page-breadcrumb">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
      <li>Bookings &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
      <li class="active">Check OTA Rate</li>
    </ol>
  </div>
  <!--END PAGE HEADER & BREADCRUMB--><!--BEGIN CONTENT-->
  <div class="page-content">
    <div class="row">
      <div class="col-lg-12">
        <h2>Check OTA Rate</h2>
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
     <!-- end col-lg-12 -->
    <div class="col-md-6">
      <div class="portlet portlet-blue">
        <div class="portlet-header">
          <div class="caption text-white">Search</div>
        </div>
        <div class="portlet-body">
          <form class="form-horizontal" action="/web88cms/check_ota_rate" method="get">
            <div class="form-group">
              <label class="col-md-4 control-label">Date</label>
              <div class="col-md-8">
                <div class="input-group input-daterange">
                  <input type="text" name="start_date" required value="{{($start_date != '' ? date('d-m-Y',strtotime($start_date)) : '')}}" class="form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" autocomplete="off"/>
                  <span class="input-group-addon">to</span>
                  <input type="text" name="end_date" value="{{($end_date != '' ? date('d-m-Y',strtotime($end_date)) : '')}}" class="form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" autocomplete="off"/>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label">OTA </label>
              <div class="col-md-8">
                <input type="text" class="form-control" name="ota_search" value="{{$ota_search}}">
              </div>
            </div>

            <!-- save button start -->
            <div class="form-actions text-center"> <button type="submit" class="btn btn-red">Search &nbsp;<i class="fa fa-search"></i></button> </div>
            <!-- save button end -->
          </form>
        </div>
        <!-- end portlet-body -->
      </div>
      <!-- end portlet -->
    </div>
    <!-- end col-md-6 -->


        <!-- end col-lg-12 -->

        <div class="col-lg-12">
              <ul id="myTab" class="nav nav-tabs">
                <li class="active"><a href="#brand-image" data-toggle="tab">Check OTA Rate</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div id="brand-image" class="tab-pane fade in active">
                  <div class="portlet">
                    <div class="portlet-header">
                      <div class="caption">Check OTA Rate</div>
                      <p class="clearfix"></p>

                      <form action="/web88cms/check_ota_rate" method="post">
                        <div class="form-group">
                          <label class="col-md-2 control-label margin-top-10px">Hotel Name <span class='require'>*</span></label>
                          <div class="col-md-6 margin-top-5px">
                              <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}" />
                             <input type="text" name="hotel_name" class="form-control" placeholder="eg. Tower Regency Hotel & Resorts" required>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button>
                      </form>
                      <div class="tools"> <i class="fa fa-chevron-up"></i> </div>

                      <!--Modal delete selected items start-->
                      <div id="modal-delete-selected" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                              <h4 id="modal-login-label4" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                            </div>
                            <div class="modal-body">
                              <p><strong>#1:</strong> Tower Regency Hotel &amp; Apartments - Ipoh, Perak</p>
                              <div class="form-actions">
                                <div class="col-md-offset-4 col-md-8"> <a href="#" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- modal delete selected items end -->
                    <br>

                    </div>
                    <div class="portlet-body">
                      <div class="form-inline pull-left">
                        <div class="form-group">
                          <form action="/web88cms/check_ota_rate" method="get">
                            <select name="per_page" class="form-control">
                              <option {{$per_page == 10 ? 'selected' : ''}}>10</option>
                              <option {{$per_page == 20 ? 'selected' : ''}}>20</option>
                              <option {{$per_page == 30 ? 'selected' : ''}}>30</option>
                              <option {{$per_page == 50 ? 'selected' : ''}}>50</option>
                              <option {{$per_page == 100 ? 'selected' : ''}}>100</option>
                            </select>
                          </form>
                          &nbsp;
                          <label class="control-label">Records per page</label>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <br/>
                      <br/>
                      <div class="table-responsive mtl">
                        <table class="table table-hover table-striped">
                          <thead>
                            <tr>
                              <th width="1%"><input type="checkbox"/></th>
                              <th>#</th>
                              <th><a herf="sort by date">Date</a></th>
                              <th><a herf="sort by ota">OTA</a></th>
                              <th><a herf="sort by price">Price</a></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($ota_check_list as $key => $val)
                              <tr>
                                <td><input type="checkbox"/></td>
                                <td>{{$val->id}}</td>
                                <td>{{date('d F Y',strtotime($val->checkin))}}</td>
                                <td>{{$val->sitename}}</td>
                                <td>{{$val->rate}}</td>
                              </tr>
                            @endforeach
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="9"></td>
                            </tr>
                          </tfoot>
                        </table>
                        <div class="tool-footer text-right">

                          <p class="pull-left">Showing <?php if($ota_check_list->total()==0){echo '0';}else{ echo $ota_check_list->firstItem();} ?> {{-- {!!$ota_check_list->firstItem()!!} --}} to {!!$ota_check_list->lastItem()!!} of {!!$ota_check_list->total()!!} entries</p>
                          <!-- <ul class="pagination pagination mtm mbm">
                            <li class="disabled"><a href="#">&laquo;</a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">&raquo;</a></li>
                          </ul> -->
                          {!! $ota_check_list->render() !!}
                        </div>
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

   <script type="text/javascript">

    // select all checkboxes
$(document).ready(function(){
   $(document).on('change', 'select[name="per_page"]',function(){
        $(this).parents('form:first').submit();
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

@endsection
