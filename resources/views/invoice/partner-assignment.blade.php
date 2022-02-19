{{-- {{ dd('here') }} --}}
<?php
$TaxRate='';
$partner = '';
$isReverseCalculated=false;
foreach($order_to_products as $key => $value){
    $roomCode=($value->product_code)?$value->product_code:$value->room_code;
    $BRoom=DB::table('products')->where('room_code',$roomCode)->first();
//    $property_id = $BRoom->property_id;
//    if($BRoom->reverse_tax_calculation=='1'){
//        $isReverseCalculated=true;
//    }
}

?>
<div style="padding:0px; margin:0px;">
    <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" style="padding:10px; background:#fff;">
        <tr>
            <td width="550" align="left" valign="top" style="border-bottom:1px solid #ccc;"><img src="{{ asset('/public/front/images/index/logo.png') }}" /></td>
            <td width="450" align="right" valign="top" style="border-bottom:1px solid #ccc; padding:10px 0 20px; text-align:right;">
                <strong>TOWER REGENCY HOTEL & APARTMENTS</strong><br />
                No.6, Jalan Dato Seri Ahmad Said, 30450 Ipoh, Perak, Malaysia.<br />
                Tel: (605) 208 6888<br />
                Fax: (605) 255 8399<br />
                inquiry@towerregency.com.my<br />
            </td>
        </tr>
        <tr>
            <td width="550" align="left" valign="top" style="border-bottom:1px solid #ccc; padding:10px 0 20px;"><h2 style="padding:0px; margin:0px; color:#444645; font-size:32px;">Order Confirmation</h2></td>
            <td width="450" align="right" valign="top" style="border-bottom:1px solid #ccc; padding:10px 0 20px;"><h2 style="padding:0px; margin:0px; color:#444645; font-size:32px;">Order #{{ $order->order_id }}</h2></td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
            <td align="left" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Billed To:</strong></td>
            <!-- <td align="right" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Shipped To:</strong></td> -->
            <td align="right" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><h4 class="block-heading pull-right"><B style"color:#2EFE2E;"><font color="green">Booking ID:</font></B> <span class="text-red">{{$order->id}}</span></h4></td>
        </tr>
        <tr>
            <td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->billing_first_name . ' ' . $order->billing_last_name }}</td>
            <!-- <td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">$order->shipping_first_name . ' ' . $order->shipping_last_name</td> -->
        </tr>
        <tr>
            <td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->billing_address }},<br/> {{ $order->billing_post_code }} {{ $order->billing_city }}, <br/>{{ $order->billing_state_name }}, {{ $order->billing_country_name }}.</td>
            <!-- <td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;"> $order->shipping_address ,<br/>  $order->shipping_post_code   $order->shipping_city , <br/> $order->shipping_state_name ,  $order->shipping_country_name .</td> -->
        </tr>
        <tr>
            <td align="left" valign="top">&nbsp;</td>
            <td align="right" valign="top">&nbsp;</td>
        </tr>
        <tr>
            <td align="left" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Order Status:</strong></td>
            <td align="right" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Payment Status:</strong></td>
        </tr>
        <tr>
            <td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->status }}</td>
            <td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->payment_status }}</td>
        </tr>

        <tr>
            <td align="left" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Payment Method:</strong></td>
            <td align="right" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Order Date:</strong></td>
        </tr>
        <tr>
            <td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->payment_method }}</td>
            <td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ date('dS M, Y', strtotime($order->createdate)) }}</td>
        </tr>
        <tr>
            <td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->billing_email }}</td>
            <td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">&nbsp;</td>
        </tr>

        @if(!empty($packages))
            <tr>
                <td align="left" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Package Name:</strong></td>
                <td align="right" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Package Code:</strong></td>
            </tr>
            <tr>
                <td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $packages[0]->package_name }}</td>
                <td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $packages[0]->package_code }}</td>
            </tr>
            <tr>
                <td align="left" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Value Added Services:</strong></td>
                <td align="right" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;">&nbsp;</td>
            </tr>
            @foreach(explode(",",$packages[0]->value_added_service) as $service)
                <tr>
                    {{-- <span class="text-black"><b>&gt;&gt; {{ $service }}</b></span> --}}
                    <td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">&bull; {{ $service }}</td>
                    {{-- <br> --}}
                    <td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">&nbsp;</td>
                </tr>
            @endforeach
        @endif
        <tr>
            <td colspan="2" align="left" valign="top" style=" padding:0px 0 0; margin:0 0 0px;"><h2 style="padding:10px 0; margin:0px; color:#444645; font-size:22px;">Order summary</h2></td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top">Pickup : @{{$property_name}}</td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top">Drop Off : @{{($order->check_date->date_checkin)}}</td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top">Date : @{{date('dS F, Y', strtotime($order->check_date->date_checkout))}}</td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top">Rooms : @{{$order->rooms}}</td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top">Audlts : @{{$order->adults}}</td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top">Children : {{$order->children}}</td>
        </tr>
    </table>
</div>
<div style="padding:0px; margin:0px;">
    <table class="table checkout-table"  width="1000" border="0" align="center" cellpadding="0" cellspacing="0" style='border: 1px solid #e0e0e0;margin-bottom: 0;background-color: transparent;border-spacing: 0;border-collapse: collapse;display: table;background-color: white; font-family: "Poppins", sans-serif;font-size: 15px;font-weight: 400;line-height: 1.45em;color: #787878;-webkit-font-smoothing: antialiased;'>
        <thead>
        <tr>
            <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;width:40%'>Types</th>
            <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;width:20%'>Room Code</th>
            <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;width:20%'>Unit Price / night (nett)</th>
            <!--               <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>Quantity</th> -->
            <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;width:20%'>SubTotal</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // cart info
        $total_amount = 0;
        //echo '<pre>';
        //print_r($order);
        //print_r($orderTax);
        //print_r($order_to_products);
        //echo '</pre>';exit;
        $tax = 0;
        $gst_rate = 0;
        foreach ($order_to_products as $key => $value) {
        $gst_rate = $value->gst_rate;
        // $total_amount += $value->sale_price * $value->quantity;
        $total_amount += $value->amount;
        //  $tax += $value->gst;
        $tax = $tax + ($value->amount * $value->gst_rate / 100);
        if($value->product_thumb != null):
            $img = asset('/public/admin/products/medium/'.$value->product_thumb);
        else:
            $img = asset('/public/admin/products/medium/'.$value->thumbnail_image_1);
        endif;
        ?>
        <tr>
            <td class="item-name-col" style='text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;width: 40%;'>
                <div style="float:left">
                    <figure>
                        <a href="#room-details"><img src="{{ $img }}" alt="Deluxe Room" class="img-responsive" style="display: inline-block; max-width: 100%; height: auto; width: 100px;height:87px; margin: auto; vertical-align: middle; border: 0;"></a>
                        @if($value->product_promo_behaviour != null)
                            @if($value->product_promo_behaviour === 'sale')
                                <img class="promo" src="{{ asset('public/promo/sale_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->product_promo_behaviour === 'hot')
                                <img class="promo" src="{{ asset('public/promo/hot_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->product_promo_behaviour === 'new')
                                <img class="promo" src="{{ asset('public/promo/new_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->product_promo_behaviour === 'pwp')
                                <img class="promo" src="{{ asset('public/promo/pwp_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->product_promo_behaviour === 'last_minute')
                                <img class="promo" src="{{ asset('public/promo/last_minute.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->product_promo_behaviour === '24hoursale')
                                <img class="promo" src="{{ asset('public/promo/24hour_sale.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->product_promo_behaviour === 'popular')
                                <img class="promo" src="{{ asset('public/promo/popular.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->product_promo_behaviour === 'early_bird')
                                <img src="{{ asset('public/promo/early_bird.png') }}"  style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">


                            @elseif($value->product_promo_behaviour === 'black_friday')
                                <img class="promo" src="{{ asset('public/promo/black_friday.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->product_promo_behaviour === 'singles_day')
                                <img class="promo" src="{{ asset('public/promo/singles_day.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->product_promo_behaviour === 'merdeka')
                                <img class="promo" src="{{ asset('public/promo/merdeka.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->product_promo_behaviour === 'valentines')
                                <img class="promo" src="{{ asset('public/promo/valentine.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">

                            @endif
                        @else
                            @if($value->promo_behaviour === 'sale')
                                <img class="promo" src="{{ asset('public/promo/sale_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->promo_behaviour === 'hot')
                                <img class="promo" src="{{ asset('public/promo/hot_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->promo_behaviour === 'new')
                                <img class="promo" src="{{ asset('public/promo/new_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->promo_behaviour === 'pwp')
                                <img class="promo" src="{{ asset('public/promo/pwp_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->promo_behaviour === 'last_minute')
                                <img class="promo" src="{{ asset('public/promo/last_minute.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->promo_behaviour === '24hoursale')
                                <img class="promo" src="{{ asset('public/promo/24hour_sale.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->promo_behaviour === 'popular')
                                <img class="promo" src="{{ asset('public/promo/popular.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->promo_behaviour === 'early_bird')
                                <img src="{{ asset('public/promo/early_bird.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">

                            @elseif($value->promo_behaviour === 'black_friday')
                                <img class="promo" src="{{ asset('public/promo/black_friday.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->promo_behaviour === 'singles_day')
                                <img class="promo" src="{{ asset('public/promo/singles_day.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->promo_behaviour === 'merdeka')
                                <img class="promo" src="{{ asset('public/promo/merdeka.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">
                            @elseif($value->promo_behaviour === 'valentines')
                                <img class="promo" src="{{ asset('public/promo/valentine.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -8px !important;left: -43px !important;">


                            @endif
                        @endif
                    </figure>
                </div>
                <div style="/*float:left;*/ margin-left: 10px; margin-top: -5px;">
                    <header style='font-size: 18px;color: #333;line-height: 18px;font-weight: 600;margin-bottom: 15px;text-align: left;'>
                        @if($value->product_type != null)
                            <a href="{{url('rooms-suites/show')}}/<?= $value->product_id ?>" target="_blank" style="color: #78A994;"><?php $value->product_type ?></a>
                        @else
                            <a href="{{url('rooms-suites/show')}}/<?= $value->product_id ?>" target="_blank" style="color: #78A994;"><?php $value->type ?></a>
                        @endif
                    </header>
                    <ul style="font-size:15px; margin-top:0px;  margin-left:-20px;">
                        <li><b>BED:</b> <span style="text-transform: lowercase;"><?= ($value->product_bed)?$value->product_bed:$value->bed ?> </span></li>
                        <li><b>GUEST:</b> <span style="text-transform: lowercase;"><?= ($value->product_guest)?$value->product_guest:$value->guest ?></span></li>
                        <li><b>MEAL:</b> <span style="text-transform: lowercase;"><?= ($value->product_meal)?$value->product_meal:$value->meal ?></span></li>
                        <?php $ota = isset($cart[0]['ota_checklist_id']) && $cart[0]['ota_checklist_id'] ? $cart[0]['ota_checklist_id'] : 0 ?>
                        @if($order->ota_checklist_id || $ota)
                            <li class="lowest-price"><i class="fa  fa-dot-circle-o"></i> <b>Lowest price available</b> </li>
                        @endif
                    </ul>
                </div>
            </td>

            <td class="item-price-col" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;width:20%'><?= ($value->product_code)?$value->product_code:$value->room_code ?></td>
            <td class="item-price-col" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;width:20%'>
            <?php
//            $checkAvailModel = new App\Http\Models\Front\CheckAvail();
//            $roomDates = $checkAvailModel->getPriceByDates($value->product_id, $order->check_date->date_checkin, $order->check_date->date_checkout);
//            $priceByDates = "";
//            $ota = isset($cart[0]['ota_checklist_id']) && $cart[0]['ota_checklist_id'] ? $cart[0]['ota_checklist_id'] : 0;
//
//            if(!empty($roomDates)){
//                foreach ($roomDates as $pd) {
//                    if(($order->ota_checklist_id || $ota) && $value->amount_sold_at) {
//                        $pd->sale_price = $value->amount_sold_at;
//                    }
//                    $priceByDates .= "<span>". date('l', strtotime($pd->date)) .", ". date('d/M/Y', strtotime($pd->date)) ." MYR " .number_format($pd->sale_price, 2)." </span><br/>";
//                }
//            }
//            if($priceByDates == '') {
//                $priceByDate = DB::table('product_room_prices')
//                    ->where('date', '>=', $order->check_date->date_checkin)
//                    ->where('date', '<', $order->check_date->date_checkout)
//                    ->where('product_id', $value->product_id)
//                    ->orderBy('date')
//                    ->get();
//                foreach ($priceByDate as $pd) {
//                    if(($order->ota_checklist_id || $ota) && $value->amount_sold_at) {
//                        $pd->sale_price = $value->amount_sold_at;
//                    }
//                    $priceByDates .= "<span>". date('l', strtotime($pd->date)) .", ". date('d/M/Y', strtotime($pd->date)) ." MYR " .number_format($pd->sale_price, 2)." </span><br/>";
//                }
//            }
//            echo $priceByDates;
            ?>
{{--            <!-- <span class="item-price-special">RM <?= /*$value->sale_price*/ number_format((float)$value->amount, 2, '.', '') ?><span class="sub-price"></span></span> -->--}}
            </td>
        <!--                  <td style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;'><?= $value->quantity ?></td> -->
{{--            <td class="item-total-col" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;width:20%'><span class="item-price-special">RM {{ ($isReverseCalculated)?number_format($order->totalPrice/(1+intval($TaxRate[0]->rate)/100), 2):number_format((float)$total_amount, 2, '.', '') }}<span class="sub-price"></span></span>--}}
{{--            </td>--}}
{{--        </tr>--}}
        <?php } ?>
        <tr>


            <td class="checkout-table-title text-right" colspan="2" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'></td>
            <td class="checkout-table-title text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;width:20%'><span class="alignleft">Subtotal</span></td>
            <td class="checkout-table-price text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important;border-bottom: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;border-bottom: 1px solid #e0e0e0!important;vertical-align: top;width:20%'>RM {{ ($isReverseCalculated)?number_format($order->totalPrice/(1+intval($TaxRate[0]->rate)/100), 2):number_format((float)$total_amount, 2, '.', '') }}<span class="sub-price"></span></span></td>

        </tr>
        @if($isReverseCalculated)
            <tr>
                <td class="checkout-table-title text-right" colspan="2" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'></td>
                <td class="checkout-table-title text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'><span class="alignleft">{{$TaxRate[0]->name}} ({{$TaxRate[0]->rate}} %)</span></td>
                <td class="checkout-table-price text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'>RM {{ ($isReverseCalculated)?number_format($order->totalPrice-$order->totalPrice/(1+intval($TaxRate[0]->rate)/100), 2):'0.00' }}<span class="sub-price"></span></span></td>
            </tr>
        @endif
        <tr>
            <td class="checkout-table-title text-right" colspan="2" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'></td>
            <td class="checkout-table-title text-danger" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;width:20%'><span class="alignleft" style="color:#a94442;">Discount @if(isset($promo->promo_code)) ({{$promo->promo_code}}) @endif<span class="text-12px" style="color:#a94442;"></span></span></span> </td>
            <?php
//            $discount_price = $discount;
//            $promo_d = isset($promo->discount) ? ($total_amount - $discount_price - (($total_amount - $discount_price) / 100 * $promo->discount)) : $total_amount - $discount_price;
//            $p_disc = isset($promo->discount) ? $promo->discount : 0;
            ?>
            <td class="checkout-table-price text-danger" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding-left:5px;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; color:#a94442;"'>RM <?= number_format($order->discount, 2) ?><span class="sub-price" style="color:#a94442;"></span></td>
        </tr>
        </tr>
        @if($tax > 0)
            <tr>
                <td class="checkout-table-title text-right" colspan="2" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'></td>
                <td class="checkout-table-title text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;width:20%'><span class="alignleft">{{isset($tax_name) ? $tax_name : 'Tax Rates'}} ({{ isset($tax_rate) ? $tax_rate : '' }}%)<!--Tax Rates ({{$gst_rate}}%)--></span></td>
                <td class="checkout-table-price text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;width:20%'><span >RM {{ number_format($tax, 2) }}<span class="sub-price"></span></span></td>
            </tr>
        @endif
        </tbody>
        <tfoot>
        <tr>
            <td class="checkout-table-title text-right" colspan="2"style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;width:20%'></td>
            <td class="checkout-total-title" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'><span class="alignleft"><b>TOTAL</b></span></td>
            <td class="checkout-total-price cart-total" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; color: #E89E55;width:20%'><b>RM <?= number_format($order->totalPrice, 2) ?><span class="sub-price"></span></b></td>
        </tr>
        </tfoot>
    </table>



    <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:10px; background:#fff;">
        <tr>
            <td>
                <div class="col-md-12 review-comment-form box-radius" style="padding:15px;border: 10px solid #f2f2f2; border: 10px solid #ededed;padding: 30px;font-weight: bold;margin-bottom: 30px;">
                    <h4>Special Requests</h4>
                    <p>Please write requests in English or the property's language</p>
                    <div style="border: 1px inset #ccc;background-color: #eee;width: 100%;height: 100px;overflow: auto;opacity: 1;border-color: #e5e5e5 !important;border: 2px solid #e5e5e5; padding: 5px;border-radius: 5px;"><?php echo $order->special_requests; ?></div>
                    <div class="clearfix"></div><br/>
                    <div class="alert alert-warning" role="alert">
                        <strong>Note:</strong> Don't disclose any additional personal or payment information in your request.
                    </div>
                </div>
            </td>
        </tr>
    </table>


    <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:10px; background:#fff;">
        <tr>
            <td>
                @if(isset($order_to_products['0']->terms_and_conditions))
                    <h4 class="text-uppercase">Terms and Conditions</h4>
                    <?php echo $order_to_products['0']->terms_and_conditions; ?>
                @endif
            </td>
        </tr>
        <tr>
            <td>
                @if(isset($order_to_products['0']->cancellation_policy))
                    <h4 class="margin-top">Cancellation Policy</h4>
                    <?php echo $order_to_products['0']->cancellation_policy; ?>
                @endif
            </td>
        </tr>
    </table>


</div>
