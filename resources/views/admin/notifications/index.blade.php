@extends('adminLayout')
@section('title', 'Notifications - Listing')
@section('content')
<div id="page-wrapper">
    <div class="page-header-breadcrumb">
        <div class="page-heading hidden-xs">
        	<h1 class="page-title">Global Settings</h1>
        </div>
        
	    <ol class="breadcrumb page-breadcrumb">
    		<li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
		    <li>Global Settings &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
		    <li class="active">Notifications Settings - Listing</li>
	    </ol>
    </div>
        
    <div class="page-content">
        <div class="row">
            <div class="col-lg-12">
            	<h2>Notification Settings <i class="fa fa-angle-right"></i> Listing</h2>
	            <div class="clearfix"></div>
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissable">
	                    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
    	                <i class="fa fa-check-circle"></i> <strong>Success!</strong>
        	            <p>{{ session()->get('success') }}</p>
                    </div>  	
                @endif
                
                @if (session()->has('warning'))
                    <div class="alert alert-danger alert-dismissable">
	                    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
    	                <i class="fa fa-times-circle"></i> <strong>Error!</strong>
        	            <p>{{ session()->get('warning') }}</p>
                    </div>
                @endif
                @if ($last_updated)
                    <div class="pull-left"> Last updated: <span class="text-blue">{{ $last_updated }}</span> </div>
    	            <div class="clearfix"></div>
        	        <p></p>
                @endif
                <div class="clearfix"></div>
            </div>
        
			<div class="col-md-6">
                <div class="portlet portlet-blue">
                    <div class="portlet-header">
                        <div class="caption text-white">Search Notifications</div>                        
                    </div>
                    <div class="portlet-body">
                        <form class="form-horizontal" method="get">
                            <div class="form-group">
                            	<label class="col-md-4 control-label">Name </label>
	                            <div class="col-md-8">
    		                        <input type="text" class="form-control" name="name" value="{{ Input::get('name') }}">
            	                </div>
                            </div>
                            <div class="form-group">
                	            <label class="col-md-4 control-label">Sent to Email </label>
                    	        <div class="col-md-8">
                        		    <input type="text" class="form-control" name="email" value="{{ Input::get('email') }}">
	                            </div>
                            </div>
                            <div class="form-actions text-center"> 
    	                        <button type="submit" class="btn btn-red">Search &nbsp;<i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		
            <div class="col-lg-12">
                <div class="portlet">
                    <div class="portlet-header">
                    	<div class="caption">Notification Settings Listing</div><br/>
	                    <p class="margin-top-10px"></p>
                        <a href="{{ url('web88cms/notification_settings_new') }}" class="btn btn-success">Add New Notificaion Setting &nbsp;<i class="fa fa-plus"></i></a>
                        <div class="btn-group">
	                        <button type="button" class="btn btn-primary">Delete</button>
    	                    <button type="button" data-toggle="dropdown" class="btn btn-red dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
        	                <ul role="menu" class="dropdown-menu">
            		            <li><a href="#" onclick="deleteSelected()">Delete selected item(s)</a></li>
                		        <li class="divider"></li>
                    		    <li><a href="#" data-target="#modal-delete-all" data-toggle="modal">Delete all</a></li>
                        	</ul>
                        </div>&nbsp;
	                    
                        <a href="{{ url('/web88cms/notification_settings_new/csv') }}" class="btn btn-blue">Export to CSV &nbsp;<i class="fa fa-share"></i></a>
                        <div class="tools"> <i class="fa fa-chevron-up"></i> </div>


                        <!--Modal delete selected items start-->
                        <div id="modal-delete-selected" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                   		<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	                                    <h4 id="modal-login-label3" class="modal-title"><a href="javascript:void(0)"><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                                    </div>
                                    <div class="modal-body error">
                                        <div class="alert alert-danger" role="alert">
                                            Please select at least one product before delete.
                                        </div>
                                        <div class="form-actions">
                                            <div class="col-md-offset-4 col-md-8">
                                                <a href="javascript:void(0)" data-dismiss="modal" class="btn btn-green">OK &nbsp;<i class="fa fa-times-circle"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
	                                <div class="modal-body success">
    		                            <div class="form-actions">
                                            <form class="selected-items" method="post" action="{{ url('/web88cms/notification_settings_new/delete/selected') }}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="notification_settings">
                                            </form>
                    			            <div class="col-md-offset-4 col-md-8">
                                                <a href="javascript:void(0)" onclick="deleterows('selected')" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp;
                                                <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a>
                                            </div>
		                                </div>
         	                       </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal delete selected items end -->

                        <!-- Delete simple item start -->
                        <div id="modal-delete-simple-item" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                        <h4 id="modal-login-label3" class="modal-title"><a href="javascript:void(0)"><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="simple-delete-content"></div>
                                        <div class="form-actions">
                                            <form class="simple-items" method="post" action="{{ url('/web88cms/notification_settings_new/delete/simple') }}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="simple">
                                            </form>
                                            <div class="col-md-offset-4 col-md-8">
                                                <a href="javascript:void(0)" onclick="deleterows('simple')" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp;
                                                <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Delete simple item end -->

                        <!--Modal delete all items start-->
                        <div id="modal-delete-all" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	                                    <h4 id="modal-login-label3" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete all items? </h4>
                                    </div>
                                    <div class="modal-body">
                                        <form class="all-items" method="post"  action="{{url('/web88cms/notification_settings_new/delete/all')}}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </form>
                                    	<div class="form-actions">
		                                    <div class="col-md-offset-4 col-md-8">
                                                <a href="javascript:void(0)" onclick="deleterows('all')" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp;
                                                <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a>
                                            </div>
	                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal delete all items end -->
                </div>
                        
                        <div class="portlet-body">
                            <div class="form-inline pull-left">
                                <div class="form-group">
                                    <select name="select_per_page" class="form-control">
                                        <option <?= ($limit == 10 ? 'selected="selected"' : ''); ?> value="10">10</option>
                                        <option <?= ($limit == 20 ? 'selected="selected"' : ''); ?> value="20">20</option>
                                        <option <?= ($limit == 30 ? 'selected="selected"' : ''); ?> value="30">30</option>
                                        <option <?= ($limit == 50 ? 'selected="selected"' : ''); ?> value="50">50</option>
                                        <option <?= ($limit == 100 ? 'selected="selected"' : ''); ?> value="100">100</option>
                                    </select>
                                    &nbsp;
                                    <label class="control-label">Records per page</label>
                                </div>
                            </div>
                        	<div class="clearfix"></div>
                        <br/>
                        <br/>
                        <div class="table-responsive mtl">
                            <table id="administrators" class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" onclick="$('input[type=checkbox]').prop('checked', $(this).is(':checked'))">
                                        </th>
                                        <th>#</th>
										<th>Status</th>
                                        <th><a href="javascript:void(0)">Name</a></th>
                                        <th><a href="javascript:void(0)">Sent to Email</a></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
										$count = (($page-1)*$limit)+1;
									?>
                                    @foreach ($notifications as $notification)
                                        <tr>
                                            <td>
                                                <input class="chk-notification" name="notification[]" value="{{ $notification->id }}" type="checkbox">
                                            </td>
                                            <td>{{ $count }}</td>
                                            <td>
												<?php
													if(!empty($notification->status))
														echo '<span class="label label-sm label-success">Active</span>';
													else
														echo '<span class="label label-sm label-danger">Inactive</span>';
												?>
											</td>
											<td>{{ $notification->name }}</td>
                                            <td>{{ str_replace(',', ', ', $notification->emails) }}</td>
                                            <td>
                                                <a href="#" data-hover="tooltip" data-placement="top" data-item="{{ $notification->id }}" title="View Log Details" data-target="#modal-view-details-new-user" data-toggle="modal"><span class="label label-sm label-yellow"><i class="fa fa-search"></i></span></a>
												<a href="{{ url('web88cms/notifications/'.$notification->id.'/edit') }}" data-hover="tooltip" data-placement="top" data-item="{{ $notification->id }}" title="Edit Details" ><span class="label label-sm label-green"><i class="fa fa-edit"></i></span></a>
                                                <a href="#"
                                                   data-hover="tooltip"
                                                   data-placement="top"
                                                   title="Delete"
                                                   data-target="#modal-delete-simple-item"
                                                   data-toggle="modal"
                                                   data-item="{{ $notification->id }}"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>
                                            </td>
                                        </tr>
                                        <?php $count++; ?>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="9"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        <div class="tool-footer text-right">
                            <p class="pull-left"><?= $paginate_msg; ?></p>
                            {!! $notifications->render() !!}
                        </div>
                        <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <!-- end row -->
    </div>



    <div id="modal-view-details-new-user" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
        <div class="modal-dialog modal-wide-width">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
                    <h4 id="modal-login-label3" class="modal-title">View Log Details</h4>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
            
    <div class="page-footer">
        <div class="copyright"><span class="text-15px">2015 © <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
        <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies Sdn Bhd"></div>
        </div>
    </div>

	<input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">
</div>

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
<!--LOADING SCRIPTS FOR PAGE-->


<script>
/*$(document).ready(function () {
    $('select[name=select_per_page]').change(function () {
        var limit = $(this).val();
        var url = "{{$sorting_url}}";
        url = url + '&limit='+limit
        location.href = url;
    })
}) */

$(document).ready(function () {
    $('select[name=select_per_page]').change(function () {
        var limit = $(this).val();
        var url = "{{$sorting_url}}";
		var sort_by = "{{$sort_by}}";
		var sort = "{{$sort}}";
		var page = "{{$page}}";
		var notification_count = {{$notifications->total()}};
		if(page>(notification_count/limit)){
			page = 1;
		}
        url = url +'?page='+page+'&limit='+limit+'&sort='+sort+'&sort_by='+sort_by;
        location.href = url;
    })
})



function deleteSelected() {
    var count = $('.chk-notification:checked').length;
    if(!count){
        $('#modal-delete-selected').find('.modal-body.error').show()
        $('#modal-delete-selected').find('.modal-body.success').hide()
    }else{
        $('#modal-delete-selected').find('.modal-body.error').hide()
        $('#modal-delete-selected').find('.modal-body.success').show()
    }

    $('#modal-delete-selected').modal('show')
}

function deleterows(type)
{
    console.log(1);
    switch (type) {
        case 'selected':
            var data = $(".chk-notification:checked").map(function(){
                return $(this).val();
            }).get();

            $('input[name=notification_settings]').val(JSON.stringify(data));
            $('.selected-items').submit();
            break;
        case 'all':
            $('.all-items').submit();
            break;
        case 'simple':
            $('.simple-items').submit();
            break;
        default:
            $('.modal').modal('hide')
            break;
    }
}


$(document).on('show.bs.modal', '#modal-view-details-new-user', function (e) {
    var target = $(e.relatedTarget);
    var item = target.attr('data-item')
    $(this).find('.modal-body').load('/web88cms/notification_settings_new/details/'+item)
})

$(document).on('show.bs.modal', '#modal-delete-simple-item', function (e) {
    var target = $(e.relatedTarget);
    $(this).find('input[name=simple]').val(target.attr('data-item'));
    $(this).find('.simple-delete-content').html(target.attr('data-delete-modal-content'))
})


</script>
@endsection
