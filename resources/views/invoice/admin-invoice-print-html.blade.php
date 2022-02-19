@extends('adminLayout')
@section('content')
<!--Loading bootstrap css-->
<?php
$TaxRate='';
$property_id='';
  $ordersModel = new App\Http\Models\Admin\Orders();
  $orderTax = $ordersModel->getOrderTax($order->id);
  $isReverseCalculated=false;
  foreach($orderTax->products as $orderProduct){
    $roomCode=$orderProduct->room_code;
    $BRoom=DB::table('products')->where('room_code',$roomCode)->first();
      $property_id = $BRoom->property_id;
    if($BRoom->reverse_tax_calculation=='1'){
        $isReverseCalculated=true;
    }
  }
$TaxRate=DB::table('gst_rates')->get();
if($isReverseCalculated){
    /* print_r($TaxRate);
    exit; */
  }
  function reverseCalculation($totalBill,$TaxRate){
      return $totalBill/(1+intval($TaxRate[0]->rate)/100);
  }

$property = DB::table('property')->where('property_id','=',$property_id)->first();
$propertyName = $property->name;
//dd($order, $orderTax);
?>
<style type="text/css">
    #print-invoice {
        display: none !important;
    }

    #print-image {
        display: none !important;
    }

    .page-footer {
        /*position: relative;*/
        width: 100%;
        bottom: 0px;
        padding: 15px 20px 25px;
        background: #FFFFFF;
    }
    .checkout-table .item-name-col figure {
        width: 100px;
        float: left;
        margin-right: 20px;
        height: 123px;
    }
    .table>tbody>tr>td, .table>tfoot>tr>td, .table>thead>tr>td {
        border-top: 1px solid #e0e0e0;
        border-right: 1px solid #e0e0e0;
        border-left: 1px solid #e0e0e0;
    }
    .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > th, .table > caption + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > td, .table > thead:first-child > tr:first-child > td {
        border-top: 1px solid #ddd;
        background: #efefef;
        border-right: 1px solid #ddd;
        border-left: 1px solid #ddd;
        text-align: center;
    }
</style>

<div id="page-wrapper">
    <div class="page-header-breadcrumb">
        <div class="page-heading hidden-xs">
            <h1 class="page-title">Orders</h1>
        </div>

        <ol class="breadcrumb page-breadcrumb">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('web88cms/dashboard') }}">Dashboard</a>&nbsp; <i
                    class="fa fa-angle-right"></i>&nbsp;</li>
            <li>Orders &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li><a href="{{ url('web88cms/orders') }}">Orders Listing</a> &nbsp;<i class="fa fa-angle-right"></i>&nbsp;
            </li>
            <li><a href="{{ url('web88cms/orders/detail/' . $order->id) }}">Order Details</a>&nbsp; <i
                    class="fa fa-angle-right"></i>&nbsp;</li>
            <li class="active">Order Confirmation </li>
        </ol>
        <div class="pull-right"><a onClick="javascript:CallPrint('print-content');" class="btn btn-default"
                style="margin-right:10px;margin-top:10px;" title="Print">Print invoice</a></div>

        <script language="javascript">
            function CallPrint(strid) {

                var prtContent = document.getElementById(strid);
                $(prtContent).find("#print-invoice").show();
                $(prtContent).find("#print-image").show();
                var prtCSS = '<link type="text/css" rel="stylesheet" href="/public/admin/vendors/jquery-ui-1.10.3.custom/css/ui-lightness/jquery-ui-1.10.3.custom.css">' +
                    '<link type="text/css" rel="stylesheet" href="/public/admin/vendors/bootstrap/css/bootstrap.min.css">' +
                    '<style type="text/css">.checkout-table .item-name-col { width: 410px; }.checkout-table .item-name-col figure { width: 100px;float: left;margin-right: 20px;}figure { margin: 0;}</style>' +
                    '<style type="text/css"> @media print { #print-invoice { display: none !important; } } </style>';
                var WinPrint = window.open('', '', 'left=50,top=50,width=800,height=640,toolbar=0,scrollbars=1,status=0');
                WinPrint.document.write('<div id="print" class="contentpane">');
                WinPrint.document.write(prtCSS);
                WinPrint.document.write(prtContent.innerHTML);
                WinPrint.document.write('</div>');
                WinPrint.document.close();
                WinPrint.focus();//
                //WinPrint.print();
                //WinPrint.close();
                //prtContent.innerHTML=strOldOne;
            }
        </script>

        <div class="page-content">
            <div id="print-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-body">

                                <div style="padding:0px; margin:0px;">
                                    <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0"
                                        style="padding:10px; background:#fff;">
                                        <tr>
                                            <td width="550" align="left" valign="top"
                                                style="border-bottom:1px solid #ccc;"><img
                                                    src="{{ asset('/public/front/images/index/logo.png') }}" /></td>
                                            <td align="left" valign="top" style="border-bottom:1px solid #ccc;"></td>
                                            <td width="500" align="right" valign="top"
                                                style="border-bottom:1px solid #ccc; padding:10px 0 20px; ">
                                                <strong>TOWER REGENCY HOTEL & APARTMENTS</strong><br />
                                                No.6,<br />Jalan Dato Seri Ahmad Said, 30450 Ipoh, Perak,
                                                Malaysia.<br />
                                                Tel: (605) 208 6888<br />
                                                Fax: (605) 255 8399<br />
                                                inquiry@towerregency.com.my<br />
                                                <div class="pull-right" id="print-invoice"><a onClick="window.print();"
                                                        class="btn btn-default"
                                                        style="margin-right:10px;margin-top:10px;" title="Print">Print
                                                        invoice</a></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="550" align="left" valign="top"
                                                style="border-bottom:1px solid #ccc; padding:10px 0 20px;">&nbsp;</td>
                                            <td align="left" valign="top" style="border-bottom:1px solid #ccc;"></td>
                                            <td width="500" align="right" valign="top"
                                                style="border-bottom:1px solid #ccc; padding:10px 0 20px;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="550" align="left" valign="top"
                                                style="border-bottom:1px solid #ccc; padding:10px 0 20px;">
                                                <h2
                                                    style="padding:10px 0 0 0; margin:0px; color:#444645; font-size:32px; line-height: 32px;">
                                                    Order Confirmation</h2>
                                            </td>
                                            <td align="left" valign="top" style="border-bottom:1px solid #ccc;"></td>
                                            <td width="500" align="right" valign="top"
                                                style="border-bottom:1px solid #ccc; padding:10px 0 20px;">
                                                <h2 style="padding:0px; margin:0px; color:#444645; font-size:15px;">
                                                    Order #{{ $order->order_id }}</h2>
                                                <h2 style="padding:0px; margin-top:5px; color:#444645; font-size:15px;">
                                                    Book ID: {{ $bookid }}</h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="550">&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td width="500">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="550" align="left" valign="top"
                                                style="color:#646464; font-size:20px; padding:5px 0; margin:0px;">
                                                <strong>Billed To:</strong></td>
                                            <td align="right" valign="top">&nbsp;</td>
                                            <td width="500" align="right" valign="top">&nbsp;</td>
                                            <!-- <td align="right" valign="top" style="color:#646464; font-size:20px; padding:5px 0; margin:0px;"><strong>Shipped To:</strong></td> -->
                                        </tr>
                                        <tr>
                                            <td width="550" align="left" valign="top"
                                                style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">
                                                {{ $order->billing_first_name . ' ' . $order->billing_last_name }}</td>
                                            <td align="right" valign="top">&nbsp;</td>
                                            <td width="500" align="right" valign="top">&nbsp;</td>
                                            <!-- <td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">$order->shipping_first_name . ' ' . $order->shipping_last_name</td> -->
                                        </tr>
                                        <tr>
                                            <td width="550" align="left" valign="top"
                                                style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">
                                                {{ $order->billing_address }},<br /> {{ $order->billing_post_code }}
                                                {{ $order->billing_city }}, <br />{{ $order->billing_state_name }},
                                                {{ $order->billing_country_name }}.</td>
                                            <td align="right" valign="top">&nbsp;</td>
                                            <td width="500" align="right" valign="top">&nbsp;</td>
                                            <!-- <td align="right" valign="top" style="color:#646464; font-size:14px; padding:3px 0; margin:0px;"> $order->shipping_address ,<br/>  $order->shipping_post_code   $order->shipping_city , <br/> $order->shipping_state_name ,  $order->shipping_country_name .</td> -->
                                        </tr>
                                        <tr>
                                            <td width="550" align="left" valign="top">&nbsp;</td>
                                            <td align="right" valign="top">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="550" align="left" valign="top"
                                                style="color:#646464; font-size:20px; padding:5px 0; margin:0px;">
                                                <strong>Order Status:</strong></td>
                                            <td align="right" valign="top">&nbsp;</td>
                                            <td width="500" align="right" valign="top"
                                                style="color:#646464; font-size:20px; padding:5px 0; margin:0px;">
                                                <strong>Payment Status:</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="550" align="left" valign="top"
                                                style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">
                                                {{ $order->status }}</td>
                                            <td align="right" valign="top">&nbsp;</td>
                                            <td width="500" align="right" valign="top"
                                                style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">
                                                {{ $order->payment_status }}</td>
                                        </tr>

                                        <tr>
                                            <td width="550" align="left" valign="top"
                                                style="color:#646464; font-size:20px; padding:5px 0; margin:0px;">
                                                <strong>Payment Method:</strong></td>
                                            <td align="right" valign="top">&nbsp;</td>
                                            <td width="500" align="right" valign="top"
                                                style="color:#646464; font-size:20px; padding:5px 0; margin:0px;">
                                                <strong>Order Date:</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="550" align="left" valign="top"
                                                style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">
                                                {{ $order->payment_method }}</td>
                                            <td align="right" valign="top">&nbsp;</td>
                                            <td width="500" align="right" valign="top"
                                                style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">
                                                {{ date('dS M, Y', strtotime($order->createdate)) }}</td>
                                        </tr>

                                        <tr>
                                            <td width="550" align="left" valign="top"
                                                style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">
                                                {{ $order->billing_email }}</td>
                                            <td align="right" valign="top">&nbsp;</td>
                                            <td width="500" align="right" valign="top"
                                                style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">&nbsp;
                                            </td>
                                        </tr>
                                        @if(count($packages) > 0)                                        
                                            <tr>
                                                <td width="550" align="left" valign="top"
                                                    style="color:#646464; font-size:20px; padding:5px 0; margin:0px;">
                                                    <strong>Package Name:</strong></td>
                                                <td align="right" valign="top">&nbsp;</td>
                                                <td width="500" align="right" valign="top"
                                                    style="color:#646464; font-size:20px; padding:5px 0; margin:0px;">
                                                    <strong>Package Code:</strong></td>
                                            </tr>
                                            <tr>
                                                <td width="550" align="left" valign="top"
                                                    style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">
                                                    {{ $packages[0]->package_name }}</td>
                                                <td align="right" valign="top">&nbsp;</td>
                                                <td width="500" align="right" valign="top"
                                                    style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">
                                                    {{ $packages[0]->package_code }}</td>
                                            </tr>

                                            <tr>
                                                <td width="550" align="left" valign="top"
                                                    style="color:#646464; font-size:20px; padding:5px 0; margin:0px;">
                                                    <strong>Value Added Services:</strong></td>
                                                <td align="right" valign="top">&nbsp;</td>
                                                <td width="500" align="right" valign="top"
                                                    style="color:#646464; font-size:20px; padding:5px 0; margin:0px;">
                                                    </td>
                                            </tr>
                                            <tr>
                                                <td width="550" align="left" valign="top"
                                                    style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">
                                                    @foreach(explode(",",$packages[0]->value_added_service) as $service)                                                    
                                                        &gt;&gt; {{ $service }}
                                                        <br>
                                                        @endforeach
                                                    <!-- {{ $packages[0]->value_added_service }} -->

                                                </td>
                                                <td width="500" align="right" valign="top"
                                                    style="color:#646464; font-size:14px; padding:3px 0; margin:0px;">
                                                    </td>
                                            </tr>
                                            <!-- <tr>
                                                <td align="left" valign="top">
                                                    <b>Minimum Stay : </b>
                                                    {{$packages[0]->minimum_stay}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="top">
                                                    <b>Check In : </b>
                                                    @if($packages[0]->checkin_mo == 1)
                                                        Monday
                                                    @endif
                                                    @if($packages[0]->checkin_tu == 1)
                                                        Tuesday
                                                    @endif
                                                    @if($packages[0]->checkin_we == 1)
                                                        Wednesday
                                                    @endif
                                                    @if($packages[0]->checkin_th == 1)
                                                        Thursday
                                                    @endif
                                                    @if($packages[0]->checkin_fr == 1)
                                                        Friday
                                                    @endif
                                                    @if($packages[0]->checkin_sa == 1)
                                                        Saturday
                                                    @endif
                                                    @if($packages[0]->checkin_su == 1)
                                                        Sunday
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left" valign="top">
                                                    <b>Check Out : </b>
                                                    @if($packages[0]->checkout_mo == 1)
                                                        Monday
                                                    @endif
                                                    @if($packages[0]->checkout_tu == 1)
                                                        Tuesday
                                                    @endif
                                                    @if($packages[0]->checkout_we == 1)
                                                        Wednesday
                                                    @endif
                                                    @if($packages[0]->checkout_th == 1)
                                                        Thursday
                                                    @endif
                                                    @if($packages[0]->checkout_fr == 1)
                                                        Friday
                                                    @endif
                                                    @if($packages[0]->checkout_sa == 1)
                                                        Saturday
                                                    @endif
                                                    @if($packages[0]->checkout_su == 1)
                                                        Sunday
                                                    @endif
                                                </td>
                                            </tr> -->
                                            <tr>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td colspan="2" align="left" valign="top"
                                                style=" padding:0px 0 0; margin:0 0 0px;">
                                                <h2 style="padding:10px 0; margin:0px; color:#444645; font-size:22px;">
                                                    Order summary</h2>
                                            </td>
                                        </tr>
                                    </table>
                                    <div id="item-details" class="row">
                                        <div class="col-md-12">
                                            <div class="portlet-body">
                                                <table class="table checkout-table table-responsive"
                                                    style="width: 1000px" align="center">
                                                    <!--<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" style="padding:10px; background:#fff;"> -->
                                                    <thead>
                                                        <tr>
                                                            <th class="table-title" colspan="1" width="300">TYPES</th>
                                                            <th class="table-title" width="100" colspan="1">ROOM CODE</th>
                                                            <!-- <th class="table-title" style="text-align: right;">Qty</th> -->
                                                            <th class="table-title" style="text-align: center;"
                                                                width="150" colspan="3">UNIT PRICE/NIGHT (NETT)</th>
{{--                                                            <th class="table-title" style="text-align: right;"--}}
{{--                                                                width="150">Tax (RM)</th>--}}
                                                            <th class="table-title" style="text-align: center;"
                                                                width="150" colspan="2">SUBTOTAL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $tax=0; ?>
                                                        @foreach($orderTax->products as $orderProduct)
                                                        <?php

                                        if($orderTax->payment_method == 'PayPal'){
                                            $tax = (($tax + $orderProduct->gst)*$orderTax->rooms);
                                        }else{
                                            // $tax = $tax + $orderProduct->gst;
                                            $tax = $tax + ($orderProduct->amount * $orderProduct->gst_rate / 100);
                                        }

                                            if($booking_date->price_details != ''){
                                                $roomDates = json_decode($booking_date->price_details);
                                            }else{
                                                $checkAvailModel = new App\Http\Models\Front\CheckAvail();
                                                $roomDates = $checkAvailModel->getPriceByDates($orderProduct->id, $booking_date->date_checkin, $booking_date->date_checkout);
                                            }

                                            $priceByDates = "";
                                            foreach ($roomDates as $pd) {
                                                if($orderTax->ota_checklist_id) {
                                                    $pd->sale_price = $orderProduct->amount_sold_at;
                                                }
                                                $priceByDates .= "<span>". date('l', strtotime($pd->date)) .", ". date('d/M/Y', strtotime($pd->date)) ." MYR " .number_format($pd->sale_price, 2)." </span><br/>";
                                            }
                                        ?>
                                                        <tr>
                                                            <td colspan="1" class="item-name-col">
                                                                <figure><a
                                                                        href="{{ url('web88cms/products/editProduct/' . $orderProduct->product_id) }}">
                                                                        <img src="{{ asset('/public/admin/products/medium/' . $orderProduct->thumbnail_image_1) }}"
                                                                            alt="{{ $orderProduct->type }}"
                                                                            class="img-responsive">
                                                                    </a>
                                                                    @if($orderProduct->product_promo_behaviour != null)
                                                                    @if($orderProduct->product_promo_behaviour ===
                                                                    'sale')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/sale_label.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->product_promo_behaviour ===
                                                                    'hot')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/hot_label.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->product_promo_behaviour ===
                                                                    'new')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/new_label.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->product_promo_behaviour ===
                                                                    'pwp')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/pwp_label.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->product_promo_behaviour ===
                                                                    'last_minute')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/last_minute.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->product_promo_behaviour ===
                                                                    '24hoursale')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/24hour_sale.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->product_promo_behaviour ===
                                                                    'popular')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/popular.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->product_promo_behaviour ===
                                                                    'early_bird')
                                                                    <img src="{{ asset('public/promo/early_bird.png') }}"
                                                                        alt="Deluxe Room" class="img-responsive"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">

                                                                    @elseif($orderProduct->product_promo_behaviour ===
                                                                    'black_friday')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/black_friday.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->product_promo_behaviour ===
                                                                    'singles_day')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/singles_day.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->product_promo_behaviour ===
                                                                    'merdeka')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/merdeka.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->product_promo_behaviour ===
                                                                    'valentines')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/valentine.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 63px !important;">


                                                                    @endif
                                                                    @else
                                                                    @if($orderProduct->promo_behaviour === 'sale')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/sale_label.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->promo_behaviour === 'hot')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/hot_label.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->promo_behaviour === 'new')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/new_label.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->promo_behaviour === 'pwp')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/pwp_label.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->promo_behaviour ===
                                                                    'last_minute')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/last_minute.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->promo_behaviour ===
                                                                    '24hoursale')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/24hour_sale.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->promo_behaviour ===
                                                                    'popular')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/popular.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->promo_behaviour ===
                                                                    'early_bird')
                                                                    <img src="{{ asset('public/promo/early_bird.png') }}"
                                                                        class="img-responsive"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 63px !important;">

                                                                    @elseif($orderProduct->promo_behaviour ===
                                                                    'black_friday')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/black_friday.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->promo_behaviour ===
                                                                    'singles_day')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/singles_day.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->promo_behaviour ===
                                                                    'merdeka')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/merdeka.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 63px !important;">
                                                                    @elseif($orderProduct->promo_behaviour ===
                                                                    'valentines')
                                                                    <img class="promo"
                                                                        src="{{ asset('public/promo/valentine.png') }}"
                                                                        style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 63px !important;">

                                                                    @endif
                                                                    @endif
                                                                </figure>
                                                                <header class="item-name">
                                                                    <a style="color:#A68A3A;font-weight: 600;font-size: 15px;"
                                                                        href="{{ url('web88cms/products/editProduct/' . $orderProduct->product_id) }}">{{ $orderProduct->type }}</a>
                                                                    @if (!is_null($orderProduct->pwp_price))
                                                                    <span class="pwp-item">PWP ITEM</span>
                                                                    @endif
                                                                </header>
                                                                <ul>
                                                                    @if($orderProduct->color_name)
                                                                    <li>Color: {{ $orderProduct->color_name }}</li>
                                                                    @endif

                                                                    @if($orderProduct->event_type)
                                                                    <li><i class="fa fa-gift text-red"></i> <span
                                                                            class="text-red"><b>For:
                                                                                {{ $orderProduct->event_type }}</b></span>
                                                                    </li>
                                                                    @endif
                                                                </ul>
                                                                <div>
                                                                    <div>
                                                                        <i class="fa fa-bed"></i> <b>BED:</b><span class="text-black">
                                                                            {{ (isset($orderTax->products[0]->product_bed) ? $orderTax->products[0]->product_bed : $orderTax->products[0]->bed) }}
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <i class="fa fa-user"></i> <b>GUEST:</b><span class="text-black">
                                                                            {{ (isset($orderTax->products[0]->product_guest) ? $orderTax->products[0]->product_guest : $orderTax->products[0]->guest) }}
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                            <i class="fa fa-cutlery"></i> <b>MEAL:</b><span class="text-black">
                                                                            {{ (isset($orderTax->products[0]->product_meal) ? $orderTax->products[0]->product_meal : $orderTax->products[0]->meal) }}
                                                                        </span>
                                                                    </div>
                                                                    @if($orderTax->ota_checklist_id)
                                                                        <div >
                                                                        <i class="fa  fa-dot-circle-o"></i><span class="text-black lowest-price">
                                                                        <b>Lowest price available</b>
                                                                        </span>                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="item-code" align="center" colspan="1">{{ $orderProduct->room_code }}</td>
                                                            <td colspan="2">
                                                                <div>
                                                                    <span class="text-black">Property:</span><b>{{ $propertyName }}</b>
                                                                </div>
                                                                <div>
                                                                    <span class="text-black">{!! $priceByDates !!}</span>
                                                                </div>
                                                                {{-- {{ $propertyName->name }},
                                                                {!! $priceByDates !!} --}}
        
                                                                {{-- @if ($orderTax->ota_checklist_id)
                                                                    <p for="inputFirstName" class="control-label">
                                                                        Check in:
                                                                        <b>{{ date('dS M, Y', strtotime($orderTax->check_date->date_checkin)) }}</b>
                                                                        <br>
                                                                        Check out:
                                                                        <b>{{ date('dS M, Y', strtotime($orderTax->check_date->date_checkout)) }}</b>
                                                                    </p>
                                                                @endif --}}
                                                                <div>
                                                                    <span>Check-in:</span><b>{{ date('dS M, Y', strtotime($orderTax->check_date->date_checkin)) }}</b>
                                                                </div>
                                                                <div>
                                                                    <span>Check-out:</span><b>{{ date('dS M, Y', strtotime($orderTax->check_date->date_checkout)) }}</b>
                                                                </div>
                                                                <div>
                                                                    <span>Rooms:</span><b>{{$orderTax->rooms}}</b>
                                                                </div>
                                                                <div>
                                                                    <span>Adutls:</span><b>{{$orderTax->adults}}</b>
                                                                </div>
                                                                <div>
                                                                    <span>Children:</span><b>{{$orderTax->children}}</b>
                                                                </div>
                                                                {{-- {{ ($isReverseCalculated)?number_format(reverseCalculation($orderProduct->subtotal*$orderTax->rooms,$TaxRate), 2):number_format($orderProduct->subtotal*$orderTax->rooms, 2) }} --}}
                                                            </td>
{{--                                                            <td class="item-total-col" align="right"><span--}}
{{--                                                                    class="item-price-special">{{ ($isReverseCalculated)?number_format($orderProduct->subtotal*$orderTax->rooms-reverseCalculation($orderProduct->subtotal*$orderTax->rooms,$TaxRate), 2):number_format($tax,2)}}</span>--}}
{{--                                                            </td>--}}
                                                            <td class="item-total-col" align="center" colspan="2"><span
                                                                    class="item-price-special">
                                                               RM {{ ($isReverseCalculated)?number_format(reverseCalculation($orderProduct->subtotal*$orderTax->rooms,$TaxRate), 2):number_format($orderTax->subtotal, 2) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        <tr style="border-bottom:1px solid #ddd;">
                                                            <td colspan="2"></td>
                                                            <td style="text-align: left;" colspan="3">SUBTOTAL:</td>
                                                            <td align="center" colspan="2">
                                                                <?php 
                                                                    $totalCalculatedPrice = ($isReverseCalculated)?number_format(reverseCalculation($orderProduct->subtotal*$orderTax->rooms,$TaxRate), 2):number_format($orderTax->subtotal, 2);    
                                                                ?>
                                                               RM {{ $totalCalculatedPrice }}
                                                            </td>
                                                        </tr>
                                                        <tr style="border-bottom:1px solid #ddd;">
                                                            <td colspan="2"></td>
                                                            <td style="text-align: left;" class="text-red" colspan="3">
                                                                Discount:</td>
                                                            <td class="text-red" align="center" colspan="2"> RM
                                                                {{ number_format($orderTax->discount, 2) }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td style="padding:8px;border-bottom: 1px solid #e0e0e0;text-align: left;" colspan="3">{{($TaxRate[0]->name)}} ({{$TaxRate[0]->rate}}%):</td>
                                                            <td align="center" colspan="2">RM 
                                                                <?php 
                                                                    $tax = ($isReverseCalculated)?number_format($orderProduct->subtotal*$orderTax->rooms-reverseCalculation($orderProduct->subtotal*$orderTax->rooms,$TaxRate), 2):number_format($tax,2);    
                                                                ?>
                                                                <span
                                                                class="item-price-special">{{ $tax }}</span></td>
                                                        </tr>
                                                        @if(isset($TaxRate[1]->rate))
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td style="text-align: left;" colspan="3">{{(isset($TaxRate[0]->name))?$TaxRate[1]->name:'Tax'}}</td>
                                                            <td align="center" colspan="2">RM <span
                                                                class="item-price-special">
                                                                <?php 
                                                                
                                                                if($isReverseCalculated){
                                                                    $totalPrice=$orderProduct->subtotal*$orderTax->rooms;
                                                                    $cal1=$totalPrice/(1+$TaxRate[1]->rate);
                                                                    echo $cal1;

                                                                }else{
                                                                    echo '0.00';
                                                                }
                                                                ?></span></td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td style="border: none; text-transform: none; text-align: left;"
                                                                colspan="3"><b>Total:</b></td>
                                                            <td align="center" colspan="2">
                                                                <b style="color: #A68A3A;">
                                                                    RM
                                                                    <?php
                                                                   
//                                                                        $v2 = ($isReverseCalculated)?number_format($orderProduct->subtotal*$orderTax->rooms-reverseCalculation($orderProduct->subtotal*$orderTax->rooms,$TaxRate), 2):number_format($tax,2);
$subtotalPrice = (float)str_replace(",","",$totalCalculatedPrice);
$totalTax = (float)str_replace(",","",$tax);
                                                                    $v1 = number_format(($subtotalPrice*$orderTax->rooms + $totalTax) - $orderTax->discount, 2);
                                                                    echo $v1;
//                                                                    if($isReverseCalculated) {
//                                                                        } else {
//                                                                        $totalData = number_format($v1+$v2,2);
//                                                                        echo $totalData;
//                                                                    }
                                                                    ?>
                                                                </br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <div class="clearfix"></div>

                                                <table class="table checkout-table table-responsive"
                                                    style="width: 1000px" align="center">
                                                    <tr>
                                                        <td>
                                                            <div class="row result-container">
                                                                <div class="col-md-12 review-comment-form box-radius"
                                                                    style="padding:15px;">
                                                                    <h4>Special Requests</h4>
                                                                    <p>Please write requests in English or the
                                                                        property's language</p>
                                                                    <div
                                                                        style="border: 1px inset #ccc;background-color: #eee;width: 100%;min-height: 100px;overflow: auto;opacity: 1;border-color: #e5e5e5 !important;padding: 5px;">
                                                                        <?php echo $order->special_requests; ?></div>
                                                                    <div class="clearfix"></div><br />
                                                                    <div class="alert alert-warning" role="alert">
                                                                        <strong>Note:</strong> Don't disclose any
                                                                        additional personal or payment information in
                                                                        your request.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <table class="table checkout-table table-responsive"
                                                    style="width: 1000px" align="center">
                                                    <tr>
                                                        <td>
                                                            @if(isset($orderProduct->terms_and_conditions))
                                                            <h4 class="text-uppercase">Terms and Conditions</h4>
                                                            <?php echo $orderProduct->terms_and_conditions; ?>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            @if(isset($orderProduct->cancellation_policy))
                                                            <h4 class="margin-top">Cancellation Policy</h4>
                                                            <?php echo $orderProduct->cancellation_policy; ?>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>


                                            </div>
                                        </div>
                                    </div>
                                    <!--<div style="padding-left:00px; margin:0px;">
  <table class="table checkout-table" style='border: 1px solid #e0e0e0;margin-bottom: 0;margin-left:100px;width: 1100px; padding-left:400px;max-width: 100%;margin: 0 0 1.5em;background-color: transparent;border-spacing: 0;border-collapse: collapse;display: table;background-color: white; font-family: "Poppins", sans-serif;font-size: 15px;font-weight: 400;line-height: 1.45em;color: #787878;-webkit-font-smoothing: antialiased;'>
      <thead>
          <tr>
              <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>Types</th>
              <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>Room Code</th>
              <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>Unit Price / night (nett)</th>
              <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>Quantity</th>
              <th class="table-title" style='font: 700 16px/22px "Montserrat", sans-serif;color: #4d4d4d;font-weight: 700;text-transform: uppercase;padding: 15px;border-color: transparent;border-right: 1px solid #e0e0e0;background: #fafafa; border-bottom: 1px solid #e0e0e0;text-align: center;vertical-align: bottom;border-collapse: collapse;'>SubTotal</th>
          </tr>
      </thead>
      <tbody>
        <?php
         // cart info
         $total_amount = 0;
         foreach ($order_to_products as $key => $value) {

             $total_amount += $value->sale_price * $value->quantity;
             $img = asset('/public/admin/products/medium/'.$value->thumbnail_image_1);
             ?>
             <tr>
                 <td class="item-name-col" style='text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;width: 390px;'>
                  <div style="float:left">
                     <figure>
                         <a href="#room-details"><img src="{{ $img }}" alt="Deluxe Room" class="img-responsive" style="display: inline-block; max-width: 100%; height: auto; width: 100px;height:87px; margin: auto; vertical-align: middle; border: 0;"></a>
                     </figure>
                   </div>
                     <div style="float:left; margin-left: 10px; margin-top: -5px;">
                     <header style='font-size: 18px;color: #333;line-height: 18px;font-weight: 600;margin-bottom: 15px;text-align: left;'>
                         <?= $value->type ?>
                     </header>
                     <ul style="font-size:15px; margin-top:0px;  margin-left:-20px;">
                         <li><b>BED:</b> <span style="text-transform: lowercase;"><?= $value->bed ?> </span></li>
                         <li><b>GUEST:</b> <span style="text-transform: lowercase;"><?= $value->guest ?></span></li>
                         <li><b>MEAL:</b> <span style="text-transform: lowercase;"><?= $value->meal ?></span></li>
                     </ul>
                    </div>
                 </td>

                 <td class="item-price-col" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center; width:150px;'><?= $value->room_code ?></td>
                 <td class="item-price-col" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center; width:150px;'><span class="item-price-special">RM <?= $value->sale_price ?>.<span class="sub-price">00</span></span></td>
                 <td style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;'><?= $value->quantity ?></td>
                 <td class="item-total-col" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; font-size:15px; text-align:center;'><span class="item-price-special">RM <?= $value->sale_price * $value->quantity ?>.<span class="sub-price">00</span></span>
                 </td>
             </tr>
         <?php } ?>
          <tr>
              <td class="checkout-table-title text-right" colspan="3" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'></td>
              <td class="checkout-table-title text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'><span class="alignleft">Subtotal</span></td>
              <td class="checkout-table-price text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'>RM <?= $total_amount ?><span class="sub-price">.00</span></span></td>
          </tr>
          <tr>
              <td class="checkout-table-title text-right" colspan="3" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'></td>
              <td class="checkout-table-title text-danger" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'><span class="alignleft" style="color:#a94442;">Discount @if(isset($promo->promo_code)) ({{$promo->promo_code}}) @endif<span class="text-12px" style="color:#a94442;"></span></span></span> </td>
              <?php
              $discount_price = $discount;
              $promo_d = isset($promo->discount) ? ($total_amount - $discount_price - (($total_amount - $discount_price) / 100 * $promo->discount)) : $total_amount - $discount_price;
              $p_disc = isset($promo->discount) ? $promo->discount : 0;
              ?>
              <td class="checkout-table-price text-danger" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; color:#a94442;"'>- RM <?= (($total_amount - $discount_price) / 100 * $p_disc) ?><span class="sub-price" style="color:#a94442;">.00</span></td>
          </tr>

          <tr>
              <td class="checkout-table-title text-right" colspan="3" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'></td>
              <td class="checkout-table-title text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'><span class="alignleft">GST (6%)</span></td>
              <td class="checkout-table-price text-black" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'><span >RM {{ number_format($total_amount/100*6,2) }}<span class="sub-price"></span></span></td>
          </tr>
      </tbody>
      <tfoot>
        <tr>
             <td class="checkout-table-title text-right" colspan=" 3"style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'></td>
             <td class="checkout-total-title" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top;'><span class="alignleft"><b>TOTAL</b></span></td>
             <td class="checkout-total-price cart-total" style='font: 500 18px/20px "Poppins", sans-serif;text-transform: uppercase;padding: 5px;border-top: 1px solid #e0e0e0!important; border-right: 1px solid #e0e0e0!important;vertical-align: top; color: #78A994;'><b>RM <?= number_format($promo_d + ($total_amount / 100 * 6), 2) ?><span class="sub-price"></span></b></td>
          </tr>
      </tfoot>
  </table>

</div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-footer">
                    <div class="copyright"><span class="text-15px">2015 © <a href="http://www.webqom.com"
                                target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a
                                href="mailto:support@webqom.com">Webqom Support</a>.</span>
                        <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}"
                                alt="Webqom Technologies Sdn Bhd"></div>



                        @endsection
