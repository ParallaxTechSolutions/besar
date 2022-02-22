`<?php
$p=DB::table('paymentMethods')->get();
$TaxRate='';
$isReverseCalculated=false;
foreach($orderTax->products as $orderProduct){
    $roomCode=($orderProduct->product_code)?$orderProduct->product_code:$orderProduct->room_code;
    $BRoom=DB::table('products')->where('room_code',$roomCode)->first();
//    if($BRoom->reverse_tax_calculation=='1'){
//        $isReverseCalculated=true;
//    }
}
if($isReverseCalculated){
    $TaxRate=DB::table('gst_rates')->get();
    /* print_r($TaxRate);
    exit; */
}
function reverseCalculation($totalBill,$TaxRate){
    return $totalBill/(1+intval($TaxRate[0]->rate)/100);
}


//dd($order, $orderTax);
?>
@extends('front/templateFront')

@section('content')
    <style>
        .custom-strong{
            font-weight: 600;
            font-size: 20px;
        }
        .control-label
        {
            text-align: left !important;
        }
    </style>
    <?php
    //$ordersModel = new App\Http\Models\Admin\Orders();
    //$orderTax = $ordersModel->getOrderTax($userOrderDetails[0]->id);

    ?>
    <div class="room-single-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-full-width">
                    <div class="section-title-area text-center">
                        <h2 class="section-title">Booking Details</h2>
                        <p class="section-title-dec">View your booking details and track your booking.</p>
                    </div><!--/.section-title-area-->
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 room-single-content">
                    <div class="single-room list mobile-extend">
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

                                @include('front/partnerLogin/subOrderDetails')

                                <hr>

                                <div class="room-info">
                                    <div class="room-description clearfix">
                                        <h4> Guest Details </h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><b>Guest Name:</b> <?php echo $userOrderDetails[0]->billing_first_name;?> <?php echo $userOrderDetails[0]->billing_last_name;?> </li>
                                                <li><b>Telephone:</b> <?php echo $userOrderDetails[0]->billing_telephone;?></li>
                                                <li><b>Address: </b><?php echo $userOrderDetails[0]->billing_address;?>, <?php echo $userOrderDetails[0]->billing_post_code;?> <?php echo $userOrderDetails[0]->billing_city;?>, <?php echo $userOrderDetails[0]->billing_state_name;?>, <?php echo $userOrderDetails[0]->billing_country_name;?>.</li>
                                                <li><b>Email:</b> <?php echo $userOrderDetails[0]->billing_email; ?></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><b>Passport/NRIC:</b> </li>
                                            <!-- <li><b>Ship to:</b> <?php echo $userOrderDetails[0]->shipping_first_name;?> <?php echo $userOrderDetails[0]->shipping_last_name;?> </li> -->
                                                <li><b>Email:</b> <?php echo $userOrderDetails[0]->shipping_email;?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="room-info">
                                    <div class="room-description clearfix">
                                        <h4>Your Reservation Details </h4>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table checkout-table table-responsive">
                                        <thead>
                                        <tr>
                                            <!-- <th class="table-title">Product Id</th> -->
                                            <th class="table-title">Types</th>
                                            <th class="table-title">Vehicle Code</th>
                                            <th class="table-title">Unit Price / Night (Nett)</th>
                                            <!-- <th class="table-title">Quantity</th> -->
                                            {{-- <th class="table-title" style="text-align: right;">SST (RM)</th> --}}
                                            <th class="table-title">Subtotal</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $gst = 0;
                                        $gst_rate = 6;
                                        if(isset($orderTax->products)){

                                        ?>

                                        @foreach($orderTax->products as $orderProduct)
                                            <?php
                                            //                                    $checkAvailModel = new App\Http\Models\Front\CheckAvail();
                                            //                                    $roomDates = $checkAvailModel->getPriceByDates($orderProduct->id, $userOrderDetails[0]->check_date->date_checkin, $userOrderDetails[0]->check_date->date_checkout);

                                            $priceByDates = "";
                                            if(!empty($roomDates[$orderProduct->id])){
                                                foreach ($roomDates[$orderProduct->id] as $pd) {
                                                    if($orderTax->ota_checklist_id && isset($orderProducts[0]->amount_sold_at) && !empty($orderProducts[0]->amount_sold_at)){
                                                        $pd->sale_price = $orderProducts[0]->amount_sold_at;
                                                    }
                                                    $priceByDates .= "<span>". date('l', strtotime($pd->date)) .", ". date('d/M/Y', strtotime($pd->date)) ." MYR " .number_format($pd->sale_price, 2)." </span><br/>";
                                                }
                                            }
                                            if($priceByDates == "") {
                                                $result = DB::table('product_room_prices')
                                                    ->where('date', '>=', $userOrderDetails[0]->check_date->date_checkin)
                                                    ->where('date', '<', $userOrderDetails[0]->check_date->date_checkout)
                                                    ->where('product_id', $orderProduct->id)
                                                    ->orderBy('date')
                                                    ->get();
                                                foreach ($result as $pd) {
                                                    if($orderTax->ota_checklist_id && isset($orderProducts[0]->amount_sold_at) && !empty($orderProducts[0]->amount_sold_at)){
                                                        $pd->sale_price = $orderProducts[0]->amount_sold_at;
                                                    }
                                                    $priceByDates .= "<span>". date('l', strtotime($pd->date)) .", ". date('d/M/Y', strtotime($pd->date)) ." MYR " .number_format($pd->sale_price, 2)." </span><br/>";
                                                }
                                            }
                                            ?>
                                            <tr>
                                            <!-- <td class="item-code">{{ $orderProduct->id }}</td> -->
                                                <td class="item-name-col">
                                                    <figure><a href="{{ url('web88cms/products/editProduct/' . $orderProduct->product_id) }}">

                                                            {{--   <img src="{{ asset('/public/admin/products/medium/' . $orderProduct->thumbnail_image_1) }}" alt="{{ $orderProduct->type }}" class="img-responsive"> --}}

                                                            @if($orderProduct->product_thumb != null)
                                                                <img src="{{ asset('/public/admin/products/medium/' . $orderProduct->product_thumb) }}" alt="{{ $orderProduct->product_type }}" class="img-responsive">
                                                            @else
                                                                <img src="{{ asset('/public/admin/products/medium/' . $orderProduct->thumbnail_image_1) }}" alt="{{ $orderProduct->type }}" class="img-responsive">
                                                            @endif
                                                        </a>
                                                        @if($orderProduct->product_promo_behaviour != null)
                                                            @if($orderProduct->product_promo_behaviour === 'sale')
                                                                <img class="promo" src="{{ asset('public/promo/sale_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->product_promo_behaviour === 'hot')
                                                                <img class="promo" src="{{ asset('public/promo/hot_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->product_promo_behaviour === 'new')
                                                                <img class="promo" src="{{ asset('public/promo/new_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->product_promo_behaviour === 'pwp')
                                                                <img class="promo" src="{{ asset('public/promo/pwp_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->product_promo_behaviour === 'last_minute')
                                                                <img class="promo" src="{{ asset('public/promo/last_minute.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->product_promo_behaviour === '24hoursale')
                                                                <img class="promo" src="{{ asset('public/promo/24hour_sale.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->product_promo_behaviour === 'popular')
                                                                <img class="promo" src="{{ asset('public/promo/popular.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->product_promo_behaviour === 'early_bird')
                                                                <img class="promo" src="{{ asset('public/promo/early_bird.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">

                                                            @elseif($orderProduct->product_promo_behaviour === 'black_friday')
                                                                <img class="promo" src="{{ asset('public/promo/black_friday.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->product_promo_behaviour === 'singles_day')
                                                                <img class="promo" src="{{ asset('public/promo/singles_day.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->product_promo_behaviour === 'merdeka')
                                                                <img class="promo" src="{{ asset('public/promo/merdeka.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->product_promo_behaviour === 'valentines')
                                                                <img class="promo" src="{{ asset('public/promo/valentine.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">


                                                            @endif
                                                        @else
                                                            @if($orderProduct->promo_behaviour === 'sale')
                                                                <img class="promo" src="{{ asset('public/promo/sale_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->promo_behaviour === 'hot')
                                                                <img class="promo" src="{{ asset('public/promo/hot_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->promo_behaviour === 'new')
                                                                <img class="promo" src="{{ asset('public/promo/new_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->promo_behaviour === 'pwp')
                                                                <img class="promo" src="{{ asset('public/promo/pwp_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->promo_behaviour === 'last_minute')
                                                                <img class="promo" src="{{ asset('public/promo/last_minute.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->promo_behaviour === '24hoursale')
                                                                <img class="promo" src="{{ asset('public/promo/24hour_sale.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->promo_behaviour === 'popular')
                                                                <img class="promo" src="{{ asset('public/promo/popular.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->promo_behaviour === 'early_bird')
                                                                <img class="promo" src="{{ asset('public/promo/early_bird.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">


                                                            @elseif($orderProduct->promo_behaviour === 'black_friday')
                                                                <img class="promo" src="{{ asset('public/promo/black_friday.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->promo_behaviour === 'singles_day')
                                                                <img class="promo" src="{{ asset('public/promo/singles_day.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->promo_behaviour === 'merdeka')
                                                                <img class="promo" src="{{ asset('public/promo/merdeka.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">
                                                            @elseif($orderProduct->promo_behaviour === 'valentines')
                                                                <img class="promo" src="{{ asset('public/promo/valentine.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">



                                                            @endif
                                                        @endif



                                                    </figure>


                                                    <header class="item-name">
                                                        {{-- <a href="{{ url('web88cms/products/editProduct/' . $orderProduct->product_id) }}">{{ $orderProduct->type }}</a> --}}
                                                        @if($orderProduct->product_type != null)
                                                            <a href="{{ url('web88cms/products/editProduct/' . $orderProduct->product_id) }}">{{ $orderProduct->product_type }}</a>
                                                        @else
                                                            <a href="{{ url('web88cms/products/editProduct/' . $orderProduct->product_id) }}">{{ $orderProduct->type }}</a>
                                                        @endif

                                                    </header>
                                                    <ul class="product--type">
                                                        <li><i class="fa fa-bed"></i> <b>BED:</b> {{ ($orderProduct->product_bed)?$orderProduct->product_bed:$orderProduct->bed }} </li>
                                                        <li><i class="fa fa-user"></i> <b>GUEST:</b> {{ ($orderProduct->product_guest)?$orderProduct->product_guest:$orderProduct->guest }}</li>
                                                        <li><i class="fa fa-cutlery"></i> <b>MEAL: {{ ($orderProduct->product_meal)?$orderProduct->product_meal:$orderProduct->meal }}</b> </li>
                                                        @if($orderTax->ota_checklist_id)
                                                            <li class="lowest-price"><i class="fa  fa-dot-circle-o"></i> <b>Lowest price available</b> </li>
                                                        @endif

                                                    </ul>
                                                    <ul>
                                                        @if($orderProduct->color_name)
                                                            <li>Color: {{ $orderProduct->color_name }}</li>
                                                        @endif

                                                        @if($orderProduct->event_type)
                                                            <li><i class="fa fa-gift text-red"></i> <span class="text-red"><b>For: {{ $orderProduct->event_type }}</b></span></li>
                                                        @endif
                                                    </ul>

                                                    @if (!is_null($orderProduct->pwp_price))
                                                        <span class="pwp-item">PWP ITEM</span>
                                                    @endif
                                                </td>
                                                <td class="item-price-col text-center">{{ ($orderProduct->product_code)?$orderProduct->product_code:$orderProduct->room_code }}</td>
                                                <td class="item-price-col">
                                                {!! $priceByDates !!}
                                                <!-- @if (is_null($orderProduct->pwp_price))
                                                    {{ number_format($orderProduct->amount, 2) }}
                                                @else
                                                    {{ number_format($orderProduct->pwp_price, 2) }}
                                                @endif -->
                                                </td>
                                            <!-- <td class="item-price-col text-center">{{ $orderProduct->quantity }}</td> -->
                                                {{--   <td class="item-price-col" style="text-align:right;padding-right:10px">{{ number_format($orderProduct->tax, 2) }}</td> --}}
                                                <?php $sbttl = $orderTax->subtotal * $orderTax->rooms; ?>

                                                <td class="item-price-col"><!--{{ number_format($orderTax->totalPrice, 2) }}-->{{ ($isReverseCalculated)?number_format(reverseCalculation($sbttl,$TaxRate), 2):number_format((float)$sbttl, 2, '.', '') }}{{-- {!! number_format($sbttl, 2) !!} --}}</td>
                                                <?php
                                                $gst_rate = $orderProduct->gst_rate;
                                                $gst += (( $sbttl * $gst_rate)/100);
                                                ?>
                                            </tr>
                                        @endforeach
                                        <?php } ?>

                                        <tr>
                                            <td class="checkout-table-title text-right" colspan="2"></td>
                                            <td colspan="1" class="checkout-table-title text-black">
                                                <span class="alignleft">SUBTOTAL:</span>
                                            </td>
                                            <td style="text-align:right; padding-right: 10px" class="checkout-table-price text-black">RM {{ ($isReverseCalculated)?number_format(reverseCalculation($sbttl,$TaxRate), 2):number_format((float)$sbttl, 2, '.', '') }}{{-- {!! number_format($sbttl, 2) !!} --}}</td>
                                        </tr>
                                        @if($isReverseCalculated)
                                            <tr>
                                                <td class="checkout-table-title text-right" colspan="2"></td>
                                                <td class="checkout-table-title text-black"><span class="alignleft">{{$TaxRate[0]->name}} ({{ $TaxRate[0]->rate }}%)</span></td>
                                                <td class="checkout-table-price text-black"> <span
                                                            class="item-price-special alignright">RM {{ ($isReverseCalculated)?number_format($sbttl-reverseCalculation($sbttl,$TaxRate), 2):'0.00' }}</span></td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td class="checkout-table-title text-right" colspan="2"></td>
                                            <td class="text-danger checkout-table-title" colspan="1">
                                                <span class="alignleft">DISCOUNT:</span>
                                            </td>
                                            <td style="text-align:right; padding-right: 10px;" class="text-danger checkout-table-title">RM {{ number_format($orderTax->discount, 2) }}</td>
                                        </tr>
                                        @if($gst > 0)
                                            <tr>
                                                <td class="checkout-table-title text-right" colspan="2"></td>
                                                <td class="checkout-table-title text-black" colspan="1">
                                                    <?php
                                                    $tax_details = @explode(',',$orderTax->tax_name);
                                                    ?>
                                                    <span class="alignleft">{{@$tax_details[0]}} ({{ @$tax_details[1] }}%):</span>
                                                </td>
                                                <!-- <td style="border: none;"></td> -->
                                                <td style="text-align:right; padding-right: 10px" class="checkout-table-title text-black">RM {{ number_format($gst, 2) }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td class="checkout-table-title text-right" colspan="2"></td>
                                            <td  colspan="1" class="checkout-table-title">
                        <span class="alignleft">
                            <b>TOTAL:</b>
                        </span>
                                            </td>
                                        <?php $totalAmount = (($sbttl + $gst) - $orderTax->discount ); ?>
                                        <!-- <td style="text-align:right;padding-right:10px"><b>{{ number_format($orderTax->tax + $orderTax->shipping_charge * 0.06, 2) }}</b></td> -->
                                            <td  style="text-align:right; padding-right: 10px" class="checkout-total-price cart-total"><b>RM {{ number_format($totalAmount,2) }}</b></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="hidden-md hidden-lg text-center extend-btn"><span class="extend-icon"><i class="fa fa-angle-down"></i></span></div>
                        </div>
                    </div>

                    <div class="row result-container">
                        <div class="col-md-12 review-comment-form box-radius" style="padding:15px;">
                            <h4>Special Requests</h4>
                            <p>Please write requests in English or the property's language</p>
                            <textarea class="form-control" name="special_requests" id="special_requests" rows="5" readonly><?php echo $userOrderDetails[0]->special_requests; ?></textarea>
                            <div class="clearfix"></div><br/>
                            <div class="alert alert-warning" role="alert">
                                <strong>Note:</strong> Don't disclose any additional personal or payment information in your request.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="single-room list mobile-extend">
                                <div class="room-info">
                                    <div class="room-description clearfix">

                                        @if(isset($orderProduct->terms_and_conditions))
                                            <h4 class="text-uppercase">Terms and Conditions</h4>
                                            <?php echo $orderProduct->terms_and_conditions; ?>
                                        @endif

                                        @if(isset($orderProduct->cancellation_policy))
                                            <h4 class="margin-top">Cancellation Policy</h4>
                                            <?php echo $orderProduct->cancellation_policy; ?>
                                        @endif

                                        <div class="clearfix"></div>

                                        <hr>

                                        <div class="text-center">
                                            <a href="/dashboard" class="btn btn-default btn-sm">Back</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="email-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" style="clear:none">Enter Email Address</h4>
                        </div>
                        <div class="modal-body">
                            Enter an email address you want to email the invoice to.
                            <input type="email" placeholder="Email Address" class="form-control" id="email-address">
                            <p class="text-danger" id="email-error" style="display: none; margin-bottom: 10px;"></p>
                        </div>

                        <div class="modal-footer" style="text-align: right;">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 12px; padding: 10px">Close</button>
                            <button type="button" class="btn btn-default" style="font-size: 12px; padding: 10px;" id="btn-send-email">Send</button>
                        </div>


                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

            @endsection



            @section('scripts')

                <script type="text/javascript">
                    $(function () {
                        $('.bs-timepicker').timepicker();
                    });
                    $(function () {
                        $('#timePick').timepicker();
                    });

                    jQuery(document).on('click', '#email-modal #btn-send-email', function(){
                        btn = jQuery(this);
                        orderDetails = ({!! json_encode($userOrderDetails) !!});
                        orderProducts = {!! json_encode($orderProducts) !!};
                        if(jQuery("#email-modal #email-address").val() == ""){
                            jQuery("#email-modal #email-error").css('display', 'block');
                            jQuery("#email-modal #email-error").html("Please enter an email address.");
                        }else{
                            jQuery("#email-modal #email-error").css('display', 'none');
                            jQuery(this).attr('disabled', true);

                            jQuery.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            jQuery.ajax({
                                type: "POST",
                                url: "/user/sendOrderEmail",
                                data: {invoice: {orderDetail: orderDetails, orderProducts: orderProducts}, email: jQuery("#email-modal #email-address").val()},
                                dataType: 'JSON',


                                success: function(response){
                                    if(response.success){
                                        jQuery('#email-success').css('display', 'block');
                                        jQuery('#email-success p').html(response.success + " to " + jQuery('#email-modal #email-address').val());
                                    }
                                    console.log(response);
                                },

                                complete:function(){
                                    jQuery('#email-modal').modal('toggle');
                                    // jQuery("#email-modal #email-address").val("");
                                    btn.removeAttr('disabled');

                                }
                            });


                        }
                    });

                    jQuery(document).on('submit', '#edit-update-order', function(){
                        var btn = jQuery(this);
                        var data = {
                            pick_up: jQuery("#pick_up").val(),
                            drop_off: jQuery("#drop_off").val(),
                            date: jQuery("#date").val(),
                            time: jQuery('#time').val(),
                            partner_id: <?php echo Auth::user()->id; ?> ,
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


                    jQuery('#datePick').pignoseCalendar({
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
            @endsection
