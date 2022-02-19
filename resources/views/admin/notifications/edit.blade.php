@extends('adminLayout')
@section('title', 'Notifications - Listing')
@section('content')
<div id="page-wrapper">
    <div class="page-header-breadcrumb">
        <div class="page-heading hidden-xs">
        	<h1 class="page-title">Customers</h1>
        </div>
        
	    <ol class="breadcrumb page-breadcrumb">
    		<li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
			<li>Global Settings &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
		    <li>Notification Settings &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
		    <li class="active">Notification Settings - Add New</li>
	    </ol>
    </div>
        
    <div class="page-content">
        <div class="row">
            <div class="col-lg-12">
            	<h2>Notification Settings <i class="fa fa-angle-right"></i> Add New</h2>
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
                
                <div class="clearfix"></div>
            </div>
        
            <div class="col-lg-12">
                <div class="portlet">
                    <div class="portlet-header">
					<b>Notification Settings - Add New</b>
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
                                            <form class="selected-items" method="post" action="{{ url('/web88cms/activiy_logs_list/delete/selected') }}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="activities">
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
                                            <form class="simple-items" method="post" action="{{ url('/web88cms/activiy_logs_list/delete/simple') }}">
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
                                        <form class="all-items" method="post"  action="{{url('/web88cms/activiy_logs_list/delete/all')}}">
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
                    <form id="save_notification_setting" method="POST" action="{{ url('web88cms/notification_settings_new') }}" >
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    					<div class="portlet-body">
                            <div class="alert alert-danger hide" id="errors"></div>
                            <div class="form-group">
                                <label class="col-md-4 control-label text-right">Status <span class="text-red">*</span></label>
                                <div class="col-md-6">
                                  <div data-on="success" data-off="primary" class="make-switch">
									<?php
									$status_checked = '';
									if(!empty($notificationData->status)){
										$status_checked = 'checked="checked"';
									}
									?>
                                    <input type="checkbox" name="status" id="status" value="1" {{$status_checked}} />
                                  </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label for="inputFirstName" class="col-md-4 control-label  text-right">Name <span class="text-red">*</span></label>
                                <div class="col-md-6">
                                  <input type="text" name="name" id="name" class="form-control" placeholder="" value="{{ $notificationData->name }}">
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label for="inputFirstName" class="col-md-4 control-label  text-right">Activities </label>
                                <div class="col-md-6">
									<?php
										$client_registered_checked = $new_order_received_checked = $room_running_low_checked = $feedback_received_checked = $job_posting_expired_checked = $job_posting_will_expire_checked = $resume_submitted_checked = $room_active_for_booking_checked = '';
										$actions = $notificationData->actions;
										$actionsArr = explode(',', $actions);
										if(in_array("client_registered", $actionsArr)){
											$client_registered_checked = 'checked="checked"';
										}
										if(in_array("new_order_received", $actionsArr)){
											$new_order_received_checked = 'checked="checked"';
										}
										if(in_array("room_running_low", $actionsArr)){
											$room_running_low_checked = 'checked="checked"';
										}
										if(in_array("feedback_received", $actionsArr)){
											$feedback_received_checked = 'checked="checked"';
										}
										if(in_array("job_posting_expired", $actionsArr)){
											$job_posting_expired_checked = 'checked="checked"';
										}
										if(in_array("job_posting_will_expire", $actionsArr)){
											$job_posting_will_expire_checked = 'checked="checked"';
										}
										if(in_array("resume_submitted", $actionsArr)){
											$resume_submitted_checked = 'checked="checked"';
										}
										if(in_array("room_active_for_booking", $actionsArr)){
											$room_active_for_booking_checked = 'checked="checked"';
										}
									?>
                                  <input type="checkbox" {{$client_registered_checked}} name="activity[client_registered]" id="activity_client_registered" class="activity_checkbox" placeholder="" value=1 /> A new client has registered <br>
                                  <input type="checkbox" {{$new_order_received_checked}} name="activity[new_order_received]" id="activity_new_order_received" class="activity_checkbox" placeholder="" value=1 /> A new order is received<br>
                                  <input type="checkbox" {{$room_running_low_checked}} name="activity[room_running_low]" id="activity_room_running_low"  class="activity_checkbox" placeholder="" value=1 /> Room is running low<br>
                                  <input type="checkbox" {{$feedback_received_checked}} name="activity[feedback_received]" id="activity_feedback_received"  class="activity_checkbox" placeholder="" value=1 /> A feedback is received<br>
                                  <input type="checkbox" {{$job_posting_expired_checked}} name="activity[job_posting_expired]" id="activity_job_posting_expired"  class="activity_checkbox" placeholder="" value=1 /> A job posting expired<br>
                                  <input type="checkbox" {{$job_posting_will_expire_checked}} name="activity[job_posting_will_expire]"  class="activity_checkbox" id="activity_job_posting_will_expire" placeholder="" value=1 /> A job posting will expire soon<br>
                                  <input type="checkbox" {{$resume_submitted_checked}}  class="activity_checkbox" name="activity[resume_submitted]" id="activity_resume_submitted" placeholder="" value=1 /> A resume is submitted<br>
                                  <input type="checkbox" {{$room_active_for_booking_checked}}  class="activity_checkbox" name="activity[room_active_for_booking]" id="activity_room_active_for_booking" placeholder="" value=1 /> No rooms have been active for booking<br>
                                </div>
                            </div>
                            <br><br><br><br><br><br><br><br>
                            <div class="form-group">
                                <label for="inputFirstName" class="col-md-4 control-label  text-right">Send to email <span class="text-red">*</span></label>
                                <div class="col-md-6">
                                    Send email notification to:
                                    <div id="emails_div">
										<ol style="list-style-type:decimal">
											<?php
											$emailsArr = explode(',', $notificationData->emails);
											$i = 0;
											foreach($emailsArr as $email){
											?>
											<li id='<?php echo $i; ?>'> <?php echo $email; ?> &nbsp;<a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="removeEmail(<?php echo $i; ?>)" ><i class="fa fa-trash"></i></a></li>
											<?php $i++; } ?>
										</ol>
									</div>
                                    <input type="hidden" name="emails" id="emails" value="{{$notificationData->emails}}" />
                                </div>
                            </div> 
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label for="inputFirstName" class="col-md-4 control-label  text-right">&nbsp;</label>
                                <div class="col-md-4">
                                    <input type="text" name="email" id="email" class="form-control" placeholder="eq. enquiry@hotel.com" aria-label="eq. enquiry@hotel.com" aria-describedby="basic-addon2" />
									<span id="email_error" class="text-danger hide">Please enter email</span>
                                </div>
								<div class="col-md-1">
									<a class="btn btn-danger" href="javascript:void(0)" onclick="return addEmailAddress();">
                                        <i class="fa fa-plus"></i>&nbsp;Add
                                    </a>
								</div>
                            </div>
                            <br><br>
                            <div class="text-center">
                                <a class="btn btn-danger" href="javascript:void(0)" onclick="saveNotificationSetting()" >Save</a>
                            </div>
							<input type="hidden" name="id" id="id" value="{{$notificationData->id}}" />
                        </div>
                    </form>
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


function addEmailAddress(){
	var re = /^(([^<>()[]\.,;:s@"]+(.[^<>()[]\.,;:s@"]+)*)|(".+"))@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}])|(([a-zA-Z-0-9]+.)+[a-zA-Z]{2,}))$/igm;
    var email = $('#email').val();
    var emails = $('#emails').val();
    if((email!='')) {
        if(emails!==''){
            var emails_result = emails.split(",");
        }else{
            var emails_result = [];
        }
        var a = emails_result.indexOf(email);

        if(a==-1){
            emails_result.push(email);
            emails_result_str = '';
            if(emails_result.length!=0){
                emails_result_str = '<ol style="list-style-type:decimal">';
                $.each( emails_result, function( i, l ){
                  emails_result_str += '<li id='+i+'>' + l + '&nbsp;<a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="removeEmail('+i+')" ><i class="fa fa-trash"></i></a></li>';
                });
                emails_result_str += '</ol>';
            }

            $('#emails').val(emails_result.join());
            $('#emails_div').html(emails_result_str);
            $('#email').val('');
        }
        $('#email_error').addClass('hide');
    }else{
		
		if((email=='')) {
			$('#email_error').html('Please enter email');
		}	
		
        $('#email_error').removeClass('hide');
    }
}

function removeEmail(index){
    $('#'+index).remove();
    var emails_text = $('#emails').val();
    var emails_result = emails_text.split(",");
    emails_result.splice(index, 1);
    $('#emails').val(emails_result.join());
}

function deleteSelected() {
    var count = $('.chk-activities:checked').length;
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
            var data = $(".chk-activities:checked").map(function(){
                return $(this).val();
            }).get();

            $('input[name=activities]').val(JSON.stringify(data));
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
    $(this).find('.modal-body').load('/web88cms/activiy_logs_list/details/'+item)
});

$(document).on('show.bs.modal', '#modal-delete-simple-item', function (e) {
    var target = $(e.relatedTarget);
    $(this).find('input[name=simple]').val(target.attr('data-item'));
    $(this).find('.simple-delete-content').html(target.attr('data-delete-modal-content'))
});

function saveNotificationSetting(){
    errors = [];
    var name = $('#name').val();
    if(name == ''){
        errors.push('Please enter name');
    }


    var emails = $('#emails').val();
    if(emails == ''){
        errors.push('Please enter email');
    }
    

    var checkboxValues = $('.activity_checkbox:checked').map(function() {
        return $(this).val();
    }).get();

    if(checkboxValues.length == 0){
        errors.push('Please select at least one activity.');
    }

    if(errors.length!=0){
        $('#errors').html(errors.join('<br>'));
        $('#errors').removeClass('hide');
    }else{
        $('#save_notification_setting').submit();
        $('#errors').addClass('hide');
    }

    

}

</script>
@endsection
