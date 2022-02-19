@extends('adminLayout')
@section('title', 'Calendar View')
@section('css')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('/public/admin/vendors/fullcalendar/fullcalendar.print.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('/public/front/css/plugins.css') }}">
    <style>
        body {
            overflow-x: hidden;
        }

    </style>
@endsection
@section('content')
    <div id="page-wrapper">
        <!--BEGIN PAGE HEADER & BREADCRUMB-->

        <div class="page-header-breadcrumb">
            <div class="page-heading hidden-xs">
                <h1 class="page-title">Bookings</h1>
            </div>
            <ol class="breadcrumb page-breadcrumb">
                <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard">Dashboard</a>&nbsp; <i
                        class="fa fa-angle-right"></i>&nbsp;</li>
                <li>Bookings &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
                <li class="active">Calendar View</li>
            </ol>
        </div>
        <!--END PAGE HEADER & BREADCRUMB-->
        <!--BEGIN CONTENT-->

        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Calendar View</h2>
                    <div class="clearfix"></div>
                    @if ($success)
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" data-dismiss="alert" aria-hidden="true"
                                class="close">&times;</button>
                            <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                            <p>{{ $success }}</p>
                        </div>
                    @endif
                    @if ($warning)
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" data-dismiss="alert" aria-hidden="true"
                                class="close">&times;</button>
                            <i class="fa fa-times-circle"></i> <strong>Error!</strong>
                            <p>{{ $warning }}</p>
                        </div>
                    @endif
                    @if ($last_updated)
                        <div class="pull-left"> Last updated: <span class="text-blue">{{ $last_updated }}</span>
                        </div>
                        <div class="clearfix"></div>
                        <p></p>
                    @endif
                    <div class="clearfix"></div>
                </div>
                <!-- end col-lg-12 -->


                <div class="col-lg-12">

                    <div class="portlet">
                        <div class="portlet-body">

                            <div class="row">

                                <div class="col-md-12">
                                    <div id="external-events">

                                        {{-- <h4>Draggable Events</h4>
                                    <input id="event-name" type="text" value="" placeholder="Event name..." class="form-control"/><br/>
                                    <a id="event-add" href="javascript:;" class="btn btn-primary btn-sm">Add Event</a> --}}
                                        {{-- <hr/> --}}
                                        {{-- <span id="external-events-client"> --}}
                                        @foreach ($clients as $client)
                                            <div data-product_id="{{ $client['product_id'] }}"
                                                data-id="{{ $client['id'] }}" data-color=""
                                                data-email="{{ $client['email'] }}"
                                                data-telephone="{{ $client['telephone'] }}"
                                                class="external-event label label-success display-none">
                                                {{ $client['name'] }}</div>
                                        @endforeach
                                        {{-- <div class="external-event label label-danger">Booking Name (1)</div> --}}
                                        {{-- <div class="external-event label label-warning">Booking Name (1)</div> --}}
                                        {{-- <div class="external-event label label-info">Booking Name (1)</div> --}}
                                        {{-- </span> --}}
                                        <div id="event-block"></div>
                                        <div class="clearfix md-margin"></div>
                                    </div>

                                    <div class="col-md-12">
                                        <div id="calendar"></div>

                                        <div class="clearfix md-margin"></div>

                                    </div>
                                    <div class="clearfix md-margin"></div>

                                </div><!-- end row -->

                            </div>
                        </div><!-- end portlet -->
                        <div class="clearfix"></div>
                    </div>
                    <!-- end col-lg-12 -->
                </div>
                <!-- end row -->
            </div>
        </div>
        <!--END CONTENT-->

        <!--BEGIN FOOTER-->
        <div class="page-footer">
            <div class="copyright"><span class="text-15px">2015 © <a href="http://www.webqom.com"
                        target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a
                        href="mailto:support@webqom.com">Webqom Support</a>.</span>
                <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}"
                        alt="Webqom Technologies"></div>
            </div>
        </div>
        <!--END FOOTER-->
    </div>

    <div id="open-booking-modal" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true"
        class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
                    <h4 id="modal-login-label2" class="modal-title">Booking</h4>
                </div>
                <div class="modal-body">
                    <div class="form">
                        <form class="form-horizontal" id="room-booking">
                            <div class="_input-daterange">
                                <div class="form-group">
                                    <label for="inputFirstName" class="col-md-4 control-label">Check-in Date </label>
                                    <div class="col-md-6">
                                        <div class="input box-radius"><i class="fa fa-calendar fa-calendar-icon"></i>
                                            <input type="text" id="Ldate-arrival"
                                                class="form-control checkin_date date-range" name="checkin_date" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputFirstName" class="col-md-4 control-label">Check-out Date </label>
                                    <div class="col-md-6">
                                        <div class="input box-radius"><i class="fa fa-calendar fa-calendar-icon"></i>
                                            <input type="text" id="Ldate-departure"
                                                class="form-control checkout_date date-range" name="checkout_date" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label for="inputFirstName" class="col-md-4 control-label">Rooms</label>
                                <div class="col-md-6">
                                    <select name="avail_rooms" style="padding-top: 4px" class="form-control avail_rooms">
                                        <option value="">Getting available rooms...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label for="inputFirstName" class="col-md-4 control-label">Name </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="shipping_name" value="">
                                </div>
                            </div>
                            <div class="clearfix"></div>



                            {{-- <div class="form-group">
                            <label for="inputFirstName" class="col-md-4 control-label">Ship To Last Name </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="shipping_last_name" value="Mei">
                            </div>
                        </div>
                        <div class="clearfix"></div> --}}

                            <div class="form-group">
                                <label for="inputFirstName" class="col-md-4 control-label">Email </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="shipping_email" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputFirstName" class="col-md-4 control-label">Telephone </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="shipping_telephone" value="">
                                </div>
                            </div>
                            {{-- <div class="form-group">
                            <label for="inputFirstName" class="col-md-4 control-label">Address </label>
                            <div class="col-md-6">
                                <textarea name="shipping_address" class="form-control">B-8-5, Kiaramas Ayuria, Jalan Kiara 7, Mont'  Kiara,</textarea>
                            </div>
                        </div> --}}
                            <div class="form-actions">
                                <div class="col-md-offset-5 col-md-8">
                                    <a href="javascript:void(0)" id="save-room-booking" class="btn btn-red">
                                        Save &nbsp;<i class="fa fa-floppy-o"></i>
                                    </a>&nbsp;
                                    <a href="javascript:void(0)" data-dismiss="modal" class="btn btn-green">
                                        Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i>
                                    </a>
                                </div>
                            </div>
                            <input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="booking-notification" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true"
        class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
                    <h4 id="modal-login-label4" class="modal-title">Please fill all the field and try again. </h4>
                </div>
                <div class="modal-body">
                    <div class="form-actions">
                        <div class="col-md-offset-4 col-md-8">
                            <a href="javascript:void(0)" data-dismiss="modal" class="btn btn-green">Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ URL::asset('public/admin/vendors/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ URL::asset('public/admin/js/page-fullcalendar.js') }}"></script>
    <script src="{{ URL::asset('public/front/js/plugins.js') }}"></script>

    <script>
        $(function() {
            setTimeout(function() {
                $('#page-wrapper').css('height', '100%')
            }, 500);

        })
        $(document).ready(function() {
            jQuery('#Ldate-arrival').pignoseCalendar({
                buttons: true,
                minDate: moment($(".checkin_date").val()).format("YYYY-MM-DD"),
                select: function(date, context) {},
                apply: function(date, context) {
                    console.log(date);
                    var ddt = moment(date);
                    ddt.set('date', ddt.get('date') + 1);
                    console.log("date ==", ddt.format('YYYY-MM-DD'));
                    if (jQuery('#Ldate-departure').val() != '' && new Date(jQuery('#Ldate-arrival')
                        .val()) >= new Date(jQuery('#Ldate-departure').val())) {
                        jQuery('#Ldate-departure').val(ddt.format('YYYY-MM-DD'));
                    }
                    jQuery('#Ldate-departure').pignoseCalendar('set', ddt.format('YYYY-MM-DD'));
                    jQuery('#Ldate-departure').trigger("click");
                }
            });
            jQuery('#Ldate-departure').pignoseCalendar({
                buttons: true,
                minDate: new Date(),
                select: function(dates, context) {},
                apply: function(date, context) {
                    if (new Date(jQuery('#Ldate-arrival').val()) >= new Date(date)) {
                        jQuery('#Ldate-departure').val('');
                        jQuery('.modal-text').text(
                            'Please select departure date bigger than arrival date.');
                        jQuery('#modal-validation').modal('show')
                    }
                }
            });
        });
    </script>
@endsection
