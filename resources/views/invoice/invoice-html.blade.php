<?php
$TaxRate='';
$product = '';
  $isReverseCalculated=false;
  foreach($cart['product'] as $key => $value){
    $roomCode=$value['room_code'];
    $product = DB::table('products')->where('id','=',$value['product_id'])->first();
    $BRoom=DB::table('products')->where('room_code',$roomCode)->first();
    if($BRoom->reverse_tax_calculation=='1'){
        $isReverseCalculated=true;
    }
  }
  if($isReverseCalculated){
      $TaxRate=DB::table('gst_rates')->get();
      /* print_r($TaxRate);
      exit; */
  }

    function isreverseCalculation($totalBill,$TaxRate){
      return $totalBill/(1+intval($TaxRate[0]->rate)/100);
  }

/* get property data */
$property = DB::table('property')->where('property_id','=',$product->property_id)->first();
$propertyName = $property->name;
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
            <td align="right" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><h4 class="block-heading pull-right"><B style"color:#2EFE2E;"><font color="green">Booking ID:</font></B> <span class="text-red">{{$bookid}}</span></h4></td>
        </tr>
        <tr>
            <td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->billing_first_name . ' ' . $order->billing_last_name }}</td>
            <!-- <td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->shipping_first_name . ' ' . $order->shipping_last_name }}</td> -->
        </tr>
        <tr>
            <td align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->billing_address }},<br/> {{ $order->billing_post_code }} {{ $order->billing_city }}, <br/>{{ $billing_info['state']->name }}, {{ $billing_info['country']->name }}.</td>
            <!-- <td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">{{ $order->shipping_address }},<br/> {{ $order->shipping_post_code }} {{ $order->shipping_city }}, <br/>{{ $order->shipping_state}}, {{ $order->shipping_country }}.</td> -->
        </tr>
        <tr>
            <td align="left" valign="top">&nbsp;</td>
            <!-- <td align="right" valign="top">&nbsp;</td> -->
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
        @if( ! empty($cart['arrival']))
        <tr>
            <td colspan="2" align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">Property: {{ $propertyName }}</td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">Check-in: {{ date('dS M, Y', strtotime($cart['arrival'])) }}</td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">Check-out: {{ date('dS M, Y', strtotime($cart['departure'])) }}</td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">Rooms: {{ $cart['rooms'] }}</td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">Adults: {{ $cart['adults'] }}</td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">Children: {{ $cart['children'] }}</td>
        </tr>
        @endif

        <tr>
          <td colspan="2">
            <div style="padding:0px; margin:0px; width: 100%">
            <div class="table-responsive" style="width:100%">


                <table class="table checkout-table" style='border: 1px solid #e0e0e0;margin-bottom: 0;width: 100%;max-width: 100%;margin: 0 0 1.5em;background-color: transparent;border-spacing: 0;border-collapse: collapse;display: table;background-color: white; font-family: "Poppins", sans-serif;font-size: 15px;font-weight: 400;line-height: 1.45em;color: #787878;-webkit-font-smoothing: antialiased;'>
                    <thead>
                        <tr>
                            <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>Types</th>
                            <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>Room Code</th>
                            <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>Unit Price / night (nett)</th>
                            <!-- <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>Quantity</th> -->
                            <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // cart info
                        $total_amount = 0;
                        foreach ($cart['product'] as $key => $value) {
                            $total_amount += $value['sale_price']; // * $value['qty'];
                            $img = asset('/public/admin/products/medium/' . $value['thumbnail_image_1']);
                            ?>
                            <tr>
                                <td class="item-name-col" style='text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;width: 410px;'>
                                    <div style="float:left">
                                        <figure style="width: 100px;float: left;margin-right: 20px;margin: 0;">
                                            <a href="#room-details"><img src="{{ $img }}" alt="Deluxe Room" class="img-responsive" style="display: inline-block; max-width: 100%; height: auto; width: 100px;height:87px; margin: auto; vertical-align: middle; border: 0;"></a>
                                                @if($value['promo_behaviour'] === 'sale')
                                                <img class="promo" src="{{ asset('public/promo/sale_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                @elseif($value['promo_behaviour'] === 'hot')
                                                <img class="promo" src="{{ asset('public/promo/hot_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                @elseif($value['promo_behaviour'] === 'new')
                                                <img class="promo" src="{{ asset('public/promo/new_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                @elseif($value['promo_behaviour'] === 'pwp')
                                                <img class="promo" src="{{ asset('public/promo/pwp_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                @elseif($value['promo_behaviour'] === 'last_minute')
                                                <img class="promo" src="{{ asset('public/promo/last_minute.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                @elseif($value['promo_behaviour'] === '24hoursale')
                                                <img class="promo" src="{{ asset('public/promo/24hour_sale.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                @elseif($value['promo_behaviour'] === 'popular')
                                                <img class="promo" src="{{ asset('public/promo/popular.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                @elseif($value['promo_behaviour'] === 'early_bird')
                                                <img class="promo" src="{{ asset('public/promo/early_bird.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">


                                                 @elseif($value['promo_behaviour'] === 'black_friday')
                                                <img class="promo" src="{{ asset('public/promo/black_friday.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                 @elseif($value['promo_behaviour'] === 'singles_day')
                                                <img class="promo" src="{{ asset('public/promo/singles_day.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                 @elseif($value['promo_behaviour'] === 'merdeka')
                                                <img class="promo" src="{{ asset('public/promo/merdeka.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                 @elseif($value['promo_behaviour'] === 'valentines')
                                                <img class="promo" src="{{ asset('public/promo/valentine.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">


                                                @endif

                                        </figure>
                                    </div>
                                    <div style="float:left; margin-left: 10px; margin-top: -5px;">
                                        <header style='font-size: 18px;color: #333;line-height: 18px;font-weight: 600;margin-bottom: 15px;text-align: left;'>
                                            <a href="{{url('rooms-suites/show')}}/<?= $value['product_id'] ?>" target="_blank" style="color: #78A994;"><?= $value['type'] ?></a>
                                        </header>
                                        <ul style="font-size:15px; margin-top:0px;  margin-left:-20px; display: inherit">
                                            <li><b>BED:</b> <span style="text-transform: lowercase;"><?= $value['bed'] ?> </span></li>
                                            <li><b>GUEST:</b> <span style="text-transform: lowercase;"><?= $value['guest'] ?></span></li>
                                            <li><b>MEAL:</b> <span style="text-transform: lowercase;"><?= $value['meal'] ?></span></li>
                                            @if($order->ota_checklist_id || (isset($value['ota_checklist_id']) && $value['ota_checklist_id'])) 
                                                <li class="lowest-price"><i class="fa  fa-dot-circle-o"></i> <b>Lowest price available</b> </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                                <?php
                                $total_amount *= $cart['rooms'];
                                ?>
                                <td class="item-price-col" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;'><?= $value['room_code'] ?></td>
                                <td class="item-price-col" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;'><?= $value['priceByDates'] ?></td>
                                <!-- <td class="item-price-col" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;'><span class="item-price-special">RM <?= number_format((float) $value['sale_price'], 2, '.', '') ?><span class="sub-price"></span></span></td>
                                <td style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;'><?= $value['qty'] ?></td> -->
                                <td class="item-total-col" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;'><span class="item-price-special">RM {{ ($isReverseCalculated)?number_format(isreverseCalculation($total_amount,$TaxRate), 2):number_format((float)$total_amount, 2, '.', '') }}<span class="sub-price"></span></span>
                                </td>
                            </tr>
                        <?php }
                        $total_amount *= $cart['rooms'];
                        ?>
                        <tr>
                            <td class="checkout-table-title text-right" colspan="2" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'></td>
                            <td class="checkout-table-title text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'><span class="alignleft">Subtotal:</span></td>
                            <td class="checkout-table-price text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'>RM {{ ($isReverseCalculated)?number_format(isreverseCalculation($total_amount,$TaxRate), 2):number_format((float)$total_amount, 2, '.', '') }}<span class="sub-price"></span></span></td>
                        </tr>
                        @if($isReverseCalculated)
                        <tr>
                            <td class="checkout-table-title text-right" colspan="2" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'></td>
                            <td class="checkout-table-title text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'><span class="alignleft">{{$TaxRate[0]->name}} ({{$TaxRate[0]->rate}})</span></td>
                            <td class="checkout-table-price text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'>RM {{ ($isReverseCalculated)?number_format($total_amount-isreverseCalculation($total_amount,$TaxRate), 2):'0.00' }}<span class="sub-price"></span></span></td>
                        </tr>
                        @endif
                        <tr>
                            <td class="checkout-table-title text-right" colspan="2" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'></td>
                            <td class="checkout-table-title text-danger" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'>
                                <span class="alignleft" style="color:#a94442;">
                                    Discount:
                                    @if(isset($promo->promo_code)) ({{$promo->promo_code}}) @endif:
                                    <span class="text-12px" style="color:#a94442;">
                                    </span>
                                </span>
                            </td>
                            <?php
                            $finalAmount = ($total_amount - $cart['discount_amount']) + $cart['tax_amount'];
                            ?>
                            <td class="checkout-table-price text-danger" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; color:#a94442;"'>RM <?= number_format($order->discount, 2) ?><span class="sub-price" style="color:#a94442;"></span></td>
                        </tr>
                        @if((float)$cart['tax_amount'] > 0)
                        <?php
                            //$rate = $tax_name;
                        ?>
                            <tr>
                                <td class="checkout-table-title text-right" colspan="2" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'></td>

                                <td class="checkout-table-title text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'><span class="alignleft">{{isset($tax_name) ? $tax_name : 'SST'}} ({{ $cart['tax_rate'] }}%)</span></td>
                                <td class="checkout-table-price text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'><span >RM {{ number_format($cart['tax_amount'],2) }}<span class="sub-price"></span></span></td>

                            </tr>
                          @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="checkout-table-title text-right" colspan="2"style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'></td>
                            <td class="checkout-total-title" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'><span class="alignleft"><b>TOTAL:</b></span></td>
                            <td class="checkout-total-price cart-total" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; color: #E89E55;'><b>RM <?= number_format($finalAmount, 2) ?><span class="sub-price"></span></b></td>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- end table responsive -->

            @if(isset($cart['special_requests']))
             <div class="row result-container">
                <div class="col-md-12 review-comment-form box-radius" style="padding:15px;border: 10px solid #f2f2f2; border: 10px solid #ededed;padding: 30px;font-weight: bold;margin-bottom: 30px;">
                    <h4>Special Requests</h4>
                    <p>Please write requests in English or the property's language</p>
                    <div style="border: 1px inset #ccc;background-color: #eee;width: 100%;height: 100px;overflow: auto;opacity: 1;border-color: #e5e5e5 !important;border: 2px solid #e5e5e5; padding: 5px;border-radius: 5px;"><?php echo $cart['special_requests']; ?></div>
                    <div class="clearfix"></div><br/>
                    <div class="alert alert-warning" role="alert">
                      <strong>Note:</strong> Don't disclose any additional personal or payment information in your request.
                    </div>
                </div>
            </div>
            @endif

             @if(isset($product_details->terms_and_conditions ))
              <h4 class="text-uppercase">Terms and Conditions</h4>
              <?php echo $product_details->terms_and_conditions; ?>
            @endif

            @if(isset($product_details->cancellation_policy))
                  <h4 class="margin-top">Cancellation Policy</h4>
                  <?php echo $product_details->cancellation_policy; ?>
            @endif


        </div>

    </td>
  </tr>
</table>
</div>
