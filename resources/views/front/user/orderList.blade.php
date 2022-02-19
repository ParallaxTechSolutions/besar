
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="{{asset('public/src/dist/css/timepicker.min.css')}}">
<script src="{{asset('public/src/dist/js/timepicker.min.js')}}"></script>


<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <a href="javascript:window.print()" class="btn btn-default">PRINT THIS PAGE &nbsp;<i class="fa fa-print"></i></a> &nbsp;
            <button data-toggle="modal" data-target="#email-modal" class="btn btn-default">EMAIL &nbsp;<i class="fa fa-envelope"></i></button>
        </div>
        <div class="clearfix"></div>
        <div class="alert alert-success alert-dismissable margin-top" id="email-success" style="display:none;">
            <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
            <i class="fa fa-check-circle"></i> <strong>Success!</strong>
            <p></p>
        </div>

        <div class="table-responsive margin-top">
            <?php
            $gst = 0;
            foreach($orderProducts as $orderProduct) {
                $gst += $orderProduct->gst;
            }
            ?>
            <table class="table cart-table" style="margin-bottom: 20px !important;">
                <thead>
                <tr>
                    <th class="table-title">Booking ID</th>
                    <th class="table-title">Payment Reference No.</th>
                    <th class="table-title">Date</th>
                    <th class="table-title">Order Total</th>
                    <th class="table-title">Payment Method</th>
                    <th class="table-title">Booking Status</th>
                    <th class="table-title">Payment Status</th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td>#{{$userOrderDetails[0]->id}}</td>
                    <td><?php echo $userOrderDetails[0]->order_id;?></td>
                    <td><?php echo date('dS M, Y', strtotime($userOrderDetails[0]->modifydate));?></td>
                    <td>RM  {{ number_format($orderTax->totalPrice, 2) }}</td>
                    <td><?php echo $userOrderDetails[0]->payment_method;?></td>
                    <td class="text-uppercase">
                        @if($userOrderDetails[0]->status == 'Processing')
                            <span class="highlight fourth-color text-12px">Processing</span>
                        @elseif($userOrderDetails[0]->status == 'New Order')
                            <span class="highlight orange-color text-12px">New Order</span>
                        @elseif($userOrderDetails[0]->status == 'Ready To Ship')
                            <span class="highlight fourth-color text-12px">Ready To Ship</span>
                        @elseif($userOrderDetails[0]->status == 'Shipped')
                            <span class="highlight blue-color text-12px">Shipped</span>
                        @elseif($userOrderDetails[0]->status == 'Completed')
                            <span class="highlight first-color text-12px">Completed</span>
                        @elseif($userOrderDetails[0]->status == 'Declined')
                            <span class="highlight third-color text-12px">Declined</span>
                        @elseif($userOrderDetails[0]->status == 'Cancelled')
                            <span class="highlight black-color text-12px">Cancelled</span>
                        @else
                            <span class="highlight black-color text-12px">New Order</span>
                        @endif
                    </td>
                    <td class="text-uppercase">
                        @if($userOrderDetails[0]->payment_status == 'Paid')
                            <span class="highlight first-color text-12px text-uppercase">Fulfilled</span>
                        @elseif($userOrderDetails[0]->payment_status == 'Processing')
                            <span class="highlight fourth-color text-12px text-uppercase">Processing</span>
                        @elseif($userOrderDetails[0]->payment_status == 'Payment Error')
                            <span class="highlight third-color text-12px">Payment Error</span>
                        @elseif($userOrderDetails[0]->payment_status == 'Cancelled')
                            <span class="highlight black-color text-12px text-uppercase">Cancelled</span>
                        @endif
                        @if($userOrderDetails[0]->payment_status == 'Paid')
                            <a  data-target="#modal-feedback-edit" data-toggle="modal" style="float: right; padding-top: 30%" class="statusChanged"><i class="fa fa-edit"></i></a>
                        @endif
                        {{--take feedback Status--}}
                        <div class="modal fade" id="modal-feedback-edit" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 id="modal-login-label2" class="modal-title">Feedback</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form">
                                            <form class="form-horizontal" id="submitUSerFeedback">
                                                <div class="form-group">
                                                    <label class="col-md-12 control-label">Customer Name</label>
                                                    <div class="col-md-12">
                                                        <input type="text" id="customer_name" placeholder="customer_name" name="customer_name" value="{{ Session::get('userFirstName') }} {{ Session::get('userLastName')}}" readonly class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-12 control-label">Booking Id </label>
                                                    <div class="col-md-12">
                                                        <div class="input box-radius"><i class="fa fa-calendar"></i>
                                                            <input type="text" id="booking_id" name="booking_id" placeholder="booking Id"class="form-control" readonly value="{{@($userOrderDetails[0]->id)}}">
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12 control-label">Feedback</label>
                                                    <div class="col-md-12">
                                                        <textarea type='text' name="feedback_text" style="width:100%" rows="15"  id="feedbacktext"   class="form-control"></textarea>
                                                    </div>
                                                </div>

                                                <div style="float: right" class="form-actions form-group">
                                                    <button type="submit" id="save-fulfilled-status" class="btn btn-default">Save &nbsp;<i class="fa fa-floppy-o"></i></button>&nbsp;
                                                </div>
                                                <div class="clearfix"></div>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            </form>
                                        </div>
                                    </div>

                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div>

                    </td>

                </tr>
                </tbody>
            </table>
        </div>

        <div class="clearfix margin-top"></div>
    </div>
</div>
@if(count($packages) > 0)
    <div class="table-responsive margin-top package">
        <table class="table">
            <tr>
                <td style="width:50%">
                    <ul style="text-align: left;">
                        <li>Pick Up:<span class="text-black info-property"><b>{{$propertyName}}</b></span></li>
                        <li>Drop Off: <span class="text-black"><b>{{ @($userOrderDetails[0]->check_date->date_checkin) }} </b></span></li>
                        <li>Date:  <span class="text-black"><b>{{ date('dS M, Y', strtotime($userOrderDetails[0]->check_date->date_checkout)) }} </b></span></li>
                        <li>Time: <span class="text-black"><b>{{ $userOrderDetails[0]->rooms }}</b></span></li>
                        <li>Adults: <span class="text-black"><b>{{ $userOrderDetails[0]->adults }}</b></span></li>
                        <li>Children: <span class="text-black"><b>{{ $userOrderDetails[0]->children }}</b></span>
                            <a style="float:right; " data-target="#modal-edit" data-toggle="modal"><i class="fa fa-edit"></i></a>
                        </li>
                    </ul>
                </td>
                <td style="width:50%">
                    <ul style="text-align: left;">
                        <li>Package Name: <span class="text-black"><b>{{$packages[0]->package_name}}</b></span></li>
                        <li>Package Code: <span class="text-black"><b>{{$packages[0]->package_code}}</b></span></li>
                        <li>Value Added Services:
                            @foreach(explode(",",$packages[0]->value_added_service) as $service)
                                <br>
                                <span class="text-black"><b>&gt;&gt; {{ $service }}</b></span>
                            @endforeach
                        </li>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
@else
    <div class="row">
        <div class="col-md-12">
            Pick Up: <span class="text-black info-property"><b>{{$propertyName}}</b></span>
        </div>
        @if( ! empty($userOrderDetails[0]->check_date))
            <div class="col-md-12">
                Drop Off: <span class="text-black"><b>{{($userOrderDetails[0]->check_date->date_checkin) }}</b></span>
            </div>
        @endif
        @if( ! empty($userOrderDetails[0]->check_date))
            <div class="col-md-12">
                Date: <span class="text-black"><b>{{ date('dS M, Y', strtotime($userOrderDetails[0]->check_date->date_checkout)) }}</b></span>
            </div>
        @endif
        @if( ! empty($userOrderDetails[0]->rooms))
            <div class="col-md-12">
                Time: <span class="text-black"><b>{{ $userOrderDetails[0]->rooms }}</b></span>
            </div>
        @endif
        @if( ! empty($userOrderDetails[0]->adults))
            <div class="col-md-12">
                Adults: <span class="text-black"><b>{{ $userOrderDetails[0]->adults }}</b></span>
            </div>
        @endif
        <div class="col-md-11">
            Children: <span class="text-black"><b>{{ $userOrderDetails[0]->children }}</b></span>
        </div>
        <div class="col-md-1">
            <a style="float:right; " data-target="#modal-edit" data-toggle="modal"><i class="fa fa-edit"></i></a>
        </div>
    </div>
@endif

{{--changes PickUp & Drop Off--}}
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="modal-login-label2" class="modal-title">Update Order</h4>
            </div>
            <div class="modal-body">
                <div class="form">
                    <form class="form-horizontal" id="edit-update-order">

                        <div class="form-group">
                            <label class="col-md-12 control-label">Select Pick Up Location</label>
                            <div class="col-md-12">
                                <select name="pick_up" id="pick_up" class="form-control">
                                    @foreach($pick_up_list as $key => $val)
                                        <option value="{{$val->property_id}}"
                                                {{($val->property_id ? 'selected' : '')}}>{{$val->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Select Drop off Location</label>
                            <div class="col-md-12">
                                <select name="drop_off" id="drop_off" class="form-control">
                                    @foreach($drop_off_list as $val)
                                        <option value="{{$val->drop_list_id}}"
                                                {{($val->drop_list_id)}}>{{$val->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Enter New Date </label>
                            <div class="col-md-12">
                                <div class="input box-radius"><i class="fa fa-calendar"></i>
                                    <input type="text" id="date" name="date" placeholder="Enter New Date"
                                           class="form-control"
                                           value="<?php echo empty($departure) ? '' : $departure ?>">
                                </div>

                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-12 control-label">Enter New Time
                            </label>
                            <div class="col-md-12">
                                <input type='text' name="time" style="width:100%" placeholder="Time" id="time"   class="form-control bs-timepicker">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Adult </label>
                            <div class="col-md-12">
                                <select name="adult" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Children </label>
                            <div class="col-md-12">
                                <select name="childrens" class="form-control">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-actions form-group">
                            <button type="submit" id="save-new-address" class="btn btn-default">Save &nbsp;<i class="fa fa-floppy-o"></i></button>&nbsp;
                        </div>
                        <div class="clearfix"></div>
                        <input type="hidden" name="_token"
                               value="{{ csrf_token() }}">
                    </form>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<script type="text/javascript">
    $(function () {
        $('.bs-timepicker').timepicker();
    });

    $(document).on('submit', '#edit-update-order', function(e){
        e.preventDefault();
        var data = {
            pick_up: jQuery("#pick_up").val(),
            drop_off: jQuery("#drop_off").val(),
            date: jQuery("#date").val(),
            time: jQuery('#time').val(),
            customer_id: <?php echo Auth::user()->id; ?> ,
            order_id: <?php echo $userOrderDetails[0]->order_id; ?> ,
        };

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: "POST",
            url: "/user/update-new-address",
            data: data,
            dataType: 'JSON',
            success: function(response){
                if(response.success){
                    jQuery('#email-success').css('display', 'block');
                    jQuery('#email-success p').html(response.success + " order has been changed ");
                }
                console.log(response);
            },

            complete:function(){
                jQuery('#email-modal').modal('toggle');
                btn.removeAttr('disabled');
            }
        });
    });

    $(document).on('submit', '#submitUSerFeedback', function(e){
        e.preventDefault();
        var data = {
            booking_id: jQuery("#booking_id").val(),
            customer_name: jQuery("#customer_name").val(),
            feedbacktext: jQuery("#feedbacktext").val(),
        };
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: "POST",
            url: "/user/submit-feedback",
            data: data,
            dataType: 'JSON',
            success: function(response){
                if(response.success){
                    jQuery('#email-success').css('display', 'block');
                    jQuery('#email-success p').html(response.success + " Feedback has been submitted ");
                    window.location.reload();
                }
            },

            complete:function(){
                btn.removeAttr('disabled');
            }
        });
    });

    $('#datePick').pignoseCalendar({
        buttons: true,
        minDate: new Date(),
        select: function (dates, context) {
        },
        apply: function (date, context) {
            if (new Date(jQuery('#date-arrival').val()) >= new Date(date)) {
                jQuery('#modal-validation').modal('show');
                jQuery('#modal-check-ota').hide()
            }
        }
    });

</script>
