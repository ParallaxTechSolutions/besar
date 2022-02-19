@extends('front/templateFront')

@section('content')

    <div class="room-single-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-full-width">
                    <div class="section-title-area text-center">
                        <h2 class="section-title">Dashboard</h2>
                        <p class="section-title-dec">View &amp; edit your account information and track of your past bookings.</p>
                    </div><!--/.section-title-area-->
                </div><!--/.col-md-8-->
            </div><!--/.row-->



            <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12">

                    <div class="room-comments-area">
                        <div id="respond" class="comment-respond box-radius">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="comment-reply-title">My Account</h4><!--/.comment-reply-title-->
                                </div><!--/.col-md-12-->
                            </div><!--/.row-->

                            <div class="row">
                                <div class="col-md-12">

                                    <ul class="margin-top">
                                        <li><i class="fa fa-check-circle"></i> <a href="{{url('partnerDashboard')}}">Account Dashboard</a></li>
                                        <li><i class="fa fa-check-circle"></i> <a href="{{url('partner-account-edit')}}">Account Information</a></li>
                                        <li><i class="fa fa-check-circle"></i> <a href="{{url('partner/order-history')}}">My Orders</a></li>
                                    </ul>

                                </div><!--/.col-md-12-->
                            </div><!--/.row-->
                        </div><!--/.comment-respond-->
                    </div>

                </div><!--/.col-md-6-->

                <div class="room-single-content col-md-9 col-sm-12 col-xs-12">

                    <div class="single-room list mobile-extend">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success">
                                    <strong>Hello
                                        {{ Session::get('userFirstName') }} {{ Session::get('userLastName') }}! </strong>
                                    <p>From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. You can view your booking history or edit your information.</p>


                                    @if(Session::has('success'))
                                        <div class="alert-box success">
                                            <p>{{ Session::get('success') }}</p>
                                        </div>
                                    @endif

                                </div>


                                <div class="col-md-6 col-sm-6">
                                    <p><div class="alert alert-warning"><i class="fa fa-star"></i> &nbsp;<strong>Partner:</strong> Code {{$partnerCredit->id}}</div></p>
                                </div><!--/.col-md-6-->
                                <div class="col-md-6 col-sm-6">
                                    <p><div class="alert alert-warning"><i class="fa fa-user-o"></i> &nbsp;<strong>Credits</strong> Available RM {{$partnerCredit->total_credit}}</div></p>
                                </div><!--/.col-md-6-->






                                <div class="room-description clearfix">
                                    <h4 class="pull-left">Recent Orders</h4>

                                    <a href="{{ url('partner/order-history') }}" class="pull-right"><button type="button" class="btn btn-default btn-xs">VIEW ALL <i class="fa fa-list"></i></button></a>
                                </div>


                                <div class="clearfix"></div>
                                <div class="table">



                                    @if(count($userOrders)>0)
                                        <table class="table cart-table">
                                            <thead>
                                            <tr>
                                                <th class="table-title">Order ID</th>
                                                <th class="table-title">Order Number</th>
                                                <th class="table-title">Order Date</th>
                                                <th class="table-title">Pick Up Point</th>
                                                <th class="table-title">Drop Off Point</th>
                                                <th class="table-title">Fulfilment Status</th>
                                                <th class="table-title">Order Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($userOrders as $order){?>
                                            
                                           
                                            <?php }?>
                                            @foreach($userOrders as $order)
                                                <?php
                                                $ordersModel = new App\Http\Models\Admin\Orders();
                                                $orderTax = $ordersModel->getOrderTax($order->id);
                                                ?>


                                                <tr>
                                                    <td><a href="partner-order-details/{{$order->id}}">#{{$order->id}}</a></td>
                                                    <td><a href="partner-order-details/{{ $order->id}}">{{ $order->id}}</a></td>
                                                    <td>{{ date('dS M, Y', strtotime($order->modifydate))}}</td>
                                                    <td> {{ $order->billing_address }}</td>
                                                    <td>{{ $order->shipping_address}}</td>
                                                    <td>
                                                        @if($order->payment_status == 'Paid')
                                                            <span class="highlight first-color text-12px">Paid</span>
                                                        @elseif($order->payment_status == 'Processing')
                                                            <span class="highlight fourth-color text-12px">Processing</span>
                                                        @elseif($order->payment_status == 'Payment Error')
                                                            <span class="highlight third-color text-12px">Payment Error</span>
                                                        @elseif($order->payment_status == 'Cancelled')
                                                            <span class="highlight black-color text-12px">Cancelled</span>
                                                        @endif
{{--                                                        <div style="float: right; padding-top: 30%" class="statusChanged"><i class="fa fa-edit"></i></div>--}}
                                                    </td>
                                                    <td><a href="partner-order-details/{{ $order->id}}"><button type="button" class="btn btn-danger btn-xs">DETAILS <i class="fa fa-search"></i></button>
                                                        </a>
{{--                                                        <div style="float: right" class="statusChanged"><i class="fa fa-edit"></i></div>--}}
                                                    </td>
                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p align="center"><strong> No Order Found.</strong></p>
                                    @endif
                                </div><!--/.table responsive-->
                                <!-- end recent orders -->

                                <div class="clearfix margin-top"></div>

                                <!-- account info start -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="room-description clearfix">
                                            <h4 class="pull-left">Account Information</h4>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="room-description clearfix">
                                                    <h4 class="pull-left">My Personal Information</h4>
                                                </div>
                                                <p>{{ Session::get('userFirstName') }} {{ Session::get('userLastName') }} <br/>
                                                    {{ Session::get('userEmail') }}</p>
                                                <a href="{{ url('partner-account-edit') }}"><button type="button" class="btn btn-danger btn-xs">EDIT &nbsp;<i class="fa fa-pencil"></i></button></a>
                                                <a href="{{ url('partner-account-edit') }}"><button type="button" class="btn btn-info btn-xs">CHANGE PASSWORD &nbsp;<i class="fa fa-lock"></i></button></a>


                                            </div>
                                            <!-- end col-md-6 -->

                                            <div class="col-md-6">
                                                <div class="room-description clearfix">
                                                    <h4 class="pull-left">Newsletter Subscription</h4>
                                                </div>
                                                @if($newsletterStatus==1)
                                                    <p>You are currently subscribed to J-Horizons Travel newsletter.</p>
                                                @else
                                                    <p>You are not subscribed to J-Horizons Travel newsletter.</p>
                                                @endif
                                                <a href="#" data-toggle="modal" data-target="#modal-newsletter-subscription"><button type="button" class="btn btn-danger btn-xs">EDIT &nbsp;<i class="fa fa-pencil"></i></button></a>


                                            </div>
                                            <!-- end col-md-6 -->


                                            <!-- Modal newsletter subscription start -->
                                            <div class="modal fade" id="modal-newsletter-subscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
                                                <form id="login-form-2" name="newsletter" method="post" action="newsletter">
                                                    <input type="hidden" name="userEmail" value="{{ $userDetail[0]->email}}" />
                                                    <input type="hidden" name="userName" value="{{ $userDetail[0]->first_name}} {{ $userDetail[0]->last_name}}" />
                                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <h4 class="modal-title" id="myModalLabel2">Newsletter Subscription</h4>
                                                            </div><!-- End .modal-header -->
                                                            <div class="modal-body clearfix">
                                                                <div class="input-group custom-checkbox">
                                                                    <input type="radio" name="nwslttr" value="subscribe" @if($newsletterStatus==0) 'checked="checked"' @endif> <span class="radio-container"><i class="fa fa-radio"></i></span>Yes, I would like to subscribe to J-Horizons Travel newsletter.</div>
                                                                <div class="input-group custom-checkbox">
                                                                    <input type="radio" name="nwslttr" value="unsubscribe" @if($newsletterStatus==1) checked="checked" @endif> <span class="radio-container"><i class="fa fa-radio"></i></span>Please unsubscribe me.</div>


                                                            </div><!-- End .modal-body -->
                                                            <div class="modal-footer">
                                                                <button class="btn btn-danger btn-sm" onclick="newsletter.submit();">SAVE</button>
                                                                <button type="button" class="btn btn-info btn-sm" data-dismiss="modal">CLOSE</button>
                                                            </div><!-- End .modal-footer -->
                                                        </div><!-- End .modal-content -->
                                                    </div><!-- End .modal-dialog -->
                                                </form>
                                            </div><!-- End .modal newsletter subscription -->
                                        </div>
                                        <!-- end row -->


                                    </div>
                                    <!-- end col-md-12 -->
                                </div>
                                <!-- end row -->
                                <div class="clearfix margin-top"></div>


                                <!--billing account info start -->
                            {{-- div class="row">
                            	<div class="col-md-12">
                                   <div class="room-description clearfix">
                                       <h4 class="pull-left">Billing &amp; Shipping Address</h4>
                                   </div>

                                    <div class="row">
                                    	<div class="col-md-6">
                                        	<div class="room-description clearfix">
                                            	<h4 class="pull-left">Default Billing Address</h4>
                                            </div>
                                           <p><strong>{{$userDetail[0]->billing_first_name}} {{ $userDetail[0]->billing_last_name}}</strong></p>
                                            <p>{{ $userDetail[0]->billing_address}} <br/>{{ $userDetail[0]->billing_post_code}} {{ $userDetail[0]->billing_city}}, {{ $userDetail[0]->billing_state_name}}, <br/>{{ $userDetail[0]->billing_country_name}}.</p>
                                            <p><strong>Email:</strong> {{ $userDetail[0]->billing_email}}</p>
                                            <p><strong>Telephone:</strong> {{ $userDetail[0]->billing_telephone}}</p>
                                            <a href="{{ url('billingaddress') }}"><button type="button" class="btn btn-danger btn-xs">EDIT &nbsp;<i class="fa fa-pencil"></i></button></a>
                                        </div>

                                        <!-- end col-md-6 -->

                                        <div class="col-md-6">
                                            <div class="room-description clearfix">
                                               <h4 class="pull-left">Default Shipping Address</h4>
                                            </div>
                                             <p><strong>{{ $userDetail[0]->shipping_first_name}} {{ $userDetail[0]->shipping_last_name}}</strong></p>
                                            <p>{{ $userDetail[0]->shipping_address}} <br/>{{ $userDetail[0]->shipping_post_code}} {{ $userDetail[0]->shipping_city}}, {{ $userDetail[0]->shipping_state_name}}, <br/>{{ $userDetail[0]->shipping_country_name}}.</p>
                                            <p><strong>Email:</strong> {{ $userDetail[0]->shipping_email}}</p>
                                            <p><strong>Telephone:</strong> {{ $userDetail[0]->shipping_telephone}}</p>
                                            <a href="{{ url('shippingaddress') }}"><button type="button" class="btn btn-danger btn-xs">EDIT &nbsp;<i class="fa fa-pencil"></i></button></a>
                                        </div>
                                        <!-- end col-md-6 -->
                                    </div>
                                    <!-- end row -->

                                </div>
                                    <!-- end col-md-12 -->
                             </div> --}}
                            <!-- end row -->


                                <!-- end account info -->


                            </div><!--/.col-md-12-->
                        </div><!--/.row-->

                    </div>

                </div><!--/.col-md-6-->

            </div><!--/.row-->

            <br/>

        </div><!--/.container-->
    </div>


    <?php
    // Brands & Services are done in the templateFront.blade.php
    if(isset($brands_scroller)) unset($brands_scroller);
    ?>

@endsection
