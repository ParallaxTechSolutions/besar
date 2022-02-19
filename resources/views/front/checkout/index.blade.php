<?php
$p=DB::table('paymentMethods')->get();
$TaxRate='';
  $isReverseCalculated=false;
  foreach($cart['product'] as $key => $value){
    $roomCode=$value['room_code'];
    $BRoom=DB::table('products')->where('room_code',$roomCode)->first();
      if($BRoom && $BRoom->reverse_tax_calculation=='1'){
        $isReverseCalculated=true;
    }
  }
  if($isReverseCalculated){
      $TaxRate=DB::table('gst_rates')->get();
      /* print_r($TaxRate);
      exit; */
  }
  function reverseCalculation($totalBill,$TaxRate){
      return $totalBill/(1+intval($TaxRate[0]->rate)/100);
  }

//dd($TaxRate);exit();
?>
@extends('front/templateFront')

@section('content')
<?php

    foreach ($cart['product'] as $key => $value) {
        $order_count = DB::select("select COUNT(*) as count from order_to_product where product_id = ".$value['product_id']);

        $serch_terms = DB::table('search_terms')->insert(
                        ['keyword' => $value['type'], 'results' => $order_count[0]->count, 'number_uses' => 0]
                    );
    }
?>
<style>
    .btn-default[disabled]:hover{
        background-color: #A68A3A !important;
        border-color:#876A20 !important;
    }
     .custom-strong{
         font-weight: 600;
         font-size: 20px;
     }
</style>
<div class="room-single-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-full-width">
                <div class="section-title-area text-center">
                    <h2 class="section-title">Checkout</h2>
                    <p class="section-title-dec">Review your booking and pay.</p>
                </div><!--/.section-title-area-->
            </div><!--/.col-md-8-->
   <?php if(Session::has("checkout")){
                if(Session::get("checkout.warning")){ ?>
                <div class="alert alert-danger"><?php echo (Session::has("checkout")? Session::get("checkout.warning") : "");  ?></div>
            <?php }
                Session::forget('checkout');
            } ?>
        </div><!--/.row-->

        <div class="row">
            <div class="col-md-12 room-single-content">
                <div class="single-room list mobile-extend" style="margin-bottom: 10px; ">


                   <!--  <ul>
                        <li>Check-in: <span class="text-black"><b><?= $cart['arrival'] ?></b></span></li>
                        <li>Check-out: <span class="text-black"><b><?= $cart['departure'] ?></b></span></li>
                        <li>Rooms: <span class="text-black"><b><?= $cart['rooms']?></b></span></li>
                        <li>Adults: <span class="text-black"><b><?= $cart['adults']?></b></span></li>
                        <li>Children: <span class="text-black"><b><?= $cart['children']?></b></span></li>
                    </ul> -->

                    @if(count($packages) > 0)
                        <div class="table-responsive margin-top package">
                            <table class="table">
                                <tr>
                                    <td style="width:50%">
                                        <ul style="text-align: left;">
                                            <li>Pick Up: <span class="text-black info-property"><b><?= $cart['property']?></b></span></li>
                                            <li>Drop Off: <span class="text-black"><b><?= $cart['arrival'] ?></b></span></li>
                                            <li>Date:  <span class="text-black"><b><?= $cart['departure'] ?></b></span></li>
                                            <li>Time:  <span class="text-black"><b><?= $cart['rooms']?></b></span></li>
                                            <li>Adults: <span class="text-black"><b><?= $cart['adults']?></b></span></li>
                                            <li>Children: <span class="text-black"><b><?= $cart['children']?></b></span></li>
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
                            {{-- <table width="1000" border="0" align="center" cellpadding="0" style="border:0px; padding: 10px;background: #fff;">
                                <tr>
                                    <td width="550" valign="top" align="left">
                                        <strong class="custom-strong">Package Name:</strong>
                                    </td>
                                    <td align="right" colspan="2" valign="top"></td>
                                    <td width="550" valign="top" align="right">
                                        <strong class="custom-strong">Package Code:</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="550" valign="top" align="left">
                                        {{$packages[0]->package_name}}
                                    </td>
                                    <td align="right" colspan="2" valign="top"></td>
                                    <td width="550" valign="top" align="right" style="padding-bottom: 15px;">
                                        {{$packages[0]->package_code}}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="550" valign="top" align="left">
                                        <strong class="custom-strong">Value Added Services:</strong>
                                    </td>
                                    <td align="right" colspan="2" valign="top"></td>
                                    <td width="550" valign="top" align="right">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="550" valign="top" align="left">
                                        {{$packages[0]->value_added_service}}
                                        <br>
                                        <b>Minimum Stay : </b>{{$packages[0]->minimum_stay}}
                                        <br>
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
                                        <br>
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
                                    <td align="right" colspan="2" valign="top"></td>
                                    <td width="550" valign="top" align="right">
                                    </td>
                                </tr>
                            </table> --}}

                        </div>
                    @else
                        <div class="table-responsive margin-top">


                            <table class="table cart-table">
                                <tbody>
                                        <tr>
                                            <td class="item-name-col">
                                                <ul>

                                                    @if(isset($cart['property']))
                                                        <li>Pick Up: <span class="text-black info-property"><b><?= $cart['property']?></b></span></li>
                                                    @endif
                                                    <li>Drop Off: <span class="text-black"><b><?= $cart['arrival'] ?></b></span></li>
                                                    <li>Date: <span class="text-black"><b><?= $cart['departure'] ?></b></span></li>
                                                    <li>Time: <span class="text-black"><b><?= $cart['rooms']?></b></span></li>
                                                    <li>Adults: <span class="text-black"><b><?= $cart['adults']?></b></span></li>
                                                    <li>Children: <span class="text-black"><b><?= $cart['children']?></b></span></li>
                                                </ul>
                                            </td>
                                            {{-- <td class="item-name-col">
                                                <div align="left"><b>Package Name:</b> 3 Days 2 Nights Package<br/>
                                                <b>Package Code:</b> 3D2N <br/><b>Value Added Services:</b></div>
                                                <ul class="list-unstyled">
                                                    <li><i class="fa fa-angle-double-right"></i> 2 nights with breakfast.<span class="text-black"><b></b></span></li>
                                                    <li><i class="fa fa-angle-double-right"></i> Bird park visit.</li>
                                                    <li><i class="fa fa-angle-double-right"></i> National Science Museum visit.</li>
                                                </ul>
                                            </td> --}}
                                        </tr>

                                </tbody>
                            </table>
                        </div>
                    @endif



                    <div class="table-responsive margin-top">


                        <table class="table cart-table">
                            <thead>
                                <tr>
                                    <th class="table-title">Types</th>
                                    <th class="table-title">Room Code</th>
                                    <th class="table-title">Unit Price / night (nett)</th>
                                    <!-- <th class="table-title">Quantity</th> -->
                                    <th class="table-title">SubTotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // cart info
                                $total_amount = 0;
                                foreach ($cart['product'] as $key => $value) {

                                    $total_amount += $value['sale_price'] * 1; // $value['qty'];
                                    ?>
                                    <tr>
                                        <td class="item-name-col">
                                            <div class="row">
                                                <div class="col-md-3">

                                                
                                            <figure>
                                                <a href="#room-details"><img src="public/admin/products/medium/<?= $value['thumbnail_image_1'] ?>" alt="Deluxe Room" class="img-responsive"></a>
                                                <?php
                                                $packages = DB::table('product_to_quantity_discount')->where('product_id', $value['product_id'])->get();
                                                ?>
                                                
                                                  @if (count($packages) > 0)
                                                      {{-- <span class="label" style="background-color: orangered;top: -13px !important;position: absolute !important;left: 50px !important;height: 30px;font-size: large;">This is the package</span> --}}
                                                      <span class="label" style="background-color: green;top: 40px !important;position: absolute !important;right: 55px!important;">{{ $packages[0]->package_name }}</span>
                                                  @endif
                                                @if($value['promo_behaviour'] === 'sale')
                                            <img class="promo" src="{{ asset('public/promo/sale_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 30px !important;">
                                            @elseif($value['promo_behaviour'] === 'hot')
                                            <img class="promo" src="{{ asset('public/promo/hot_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 30px !important;">
                                            @elseif($value['promo_behaviour'] === 'new')
                                            <img class="promo" src="{{ asset('public/promo/new_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 30px !important;">
                                            @elseif($value['promo_behaviour'] === 'pwp')
                                            <img class="promo" src="{{ asset('public/promo/pwp_label.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 30px !important;">
                                            @elseif($value['promo_behaviour'] === 'last_minute')
                                            <img class="promo" src="{{ asset('public/promo/last_minute.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 30px !important;">
                                            @elseif($value['promo_behaviour'] === '24hoursale')
                                            <img class="promo" src="{{ asset('public/promo/24hour_sale.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 30px !important;">
                                            @elseif($value['promo_behaviour'] === 'popular')
                                            <img class="promo" src="{{ asset('public/promo/popular.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 30px !important;">
                                            @elseif($value['promo_behaviour'] === 'early_bird')
                                            <img class="promo" src="{{ asset('public/promo/early_bird.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 30px !important;">
                                            @elseif($value['promo_behaviour'] === 'black_friday')
                                            <img class="promo" src="{{ asset('public/promo/black_friday.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 30px !important;">
					    @elseif($value['promo_behaviour'] === 'singles_day')
                                            <img class="promo" src="{{ asset('public/promo/singles_day.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 30px !important;">
					    @elseif($value['promo_behaviour'] === 'merdeka')
                                            <img class="promo" src="{{ asset('public/promo/merdeka.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 30px !important;">
					    @elseif($value['promo_behaviour'] === 'valentines')
                                            <img class="promo" src="{{ asset('public/promo/valentine.png') }}" style="width: 35px !important;height: 35px !important;position: relative !important;top: -85px !important;left: 30px !important;">                                            
@endif
                                            </figure>
                                            </div>
                                            
                                            <div class="col-md-9" style="padding-left:20px">
                                            <header class="item-name">
                                                <a href="{{url('rooms-suites/show')}}/<?= $value['product_id'] ?>" target="_blank"><?= $value['type'] ?></a>
                                            </header>
                                            <ul class="product--type">
                                                <li><i class="fa fa-bed"></i> <b>BED:</b> <?= $value['bed'] ?> </li>
                                                <li><i class="fa fa-user"></i> <b>GUEST:</b> <?= $value['guest'] ?></li>
                                                <li><i class="fa fa-cutlery"></i> <b>MEAL:</b> <?= $value['meal'] ?></li>
                                                @if(isset($value['ota_checklist_id']) && $value['ota_checklist_id']) 
                                                    <li class="lowest-price"><i class="fa  fa-dot-circle-o"></i> <b>Lowest price available</b> </li>
                                                @endif
                                            </ul>
                                            </div>
                                            </div>
                                        </td>
                                        <?php $total_amount *= $cart['rooms'];?>
                                        <td class="item-price-col"><?= $value['room_code'] ?></td>
                                        <td>{!! $value['priceByDates'] !!}</td>
                                        <!-- <td class="item-price-col"><span class="item-price-special">RM <?= number_format((float)$value['sale_price'], 2, '.', '') ?><span class="sub-price"></span></span></td> -->
                                        <!-- <td><?= $value['qty'] ?></td> -->
                                        <td class="item-total-col"><span class="item-price-special">RM {{ ($isReverseCalculated)?number_format(reverseCalculation($total_amount,$TaxRate), 2):number_format((float)($value['sale_price']*$cart['rooms']), 2, '.', '') }}<span class="sub-price"></span></span>
                                        </td>
                                    </tr>
                                <?php }

                                ?>
                            </tbody>
                        </table>
                    </div><!-- end table responsive -->

                </div>


                <div class="hidden-md hidden-lg text-center extend-btn"><span class="extend-icon"><i class="fa fa-angle-down"></i></span></div>
            </div><!--/.col-md-12-->

        </div><!--/.row-->

        <div class="row result-container">
            <div class="col-md-12 review-comment-form box-radius" style="padding:15px;">
                <h4>Special Requests</h4>
                <p>Please write requests in English or the property's language</p>
                <textarea class="form-control" name="special_requests" id="special_requests" rows="5" readonly><?php echo $cart['special_requests']; ?></textarea>
                <div class="clearfix"></div><br/>
                <div class="alert alert-warning" role="alert">
                  <strong>Note:</strong> Don't disclose any additional personal or payment information in your request.
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">

                <div class="room-comments-area" style="/* display: none; */">
                    @if(!$isUserLogin)
                    <div id="respond" class="comment-respond box-radius">
                        <div class="row">
                            <div class="col-md-12">

                                <h4 class="comment-reply-title">Returning Customers</h4><!--/.comment-reply-title-->
                            </div><!--/.col-md-12-->
                        </div><!--/.row-->
                        <div class="row">
                            @if(Session::has('error'))
                            <div class="alert alert-danger" style="margin-top: 15px;">
                                <i class="fa fa-exclamation-triangle"></i> &nbsp; {{ Session::get('error') }}
                            </div>
                            @else
                            <div class="alert alert-danger" style="margin-top: 15px;">
                                <i class="fa fa-exclamation-triangle"></i> &nbsp; <span>Please sign in or sign up to place order and payment.</span>
                            </div>
                            @endif

                            <div class="col-md-12">
                                <form action="{{ url('login') }}" method="post" id="comment_form" name="commentForm">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="redirect" value="checkout">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 padding-right">
                                            <p>
                                                <input type="text" name="email" id="email" aria-required="true" placeholder="Email *" class="form-controllar" required="true">
                                            </p>
                                        </div><!--/.col-md-6-->
                                        <div class="col-md-6 col-sm-6 padding-right">
                                            <p>
                                                <input type="password" name="password" id="email" aria-required="true" placeholder="Password *" class="form-controllar" required="true">
                                            </p>
                                        </div><!--/.col-md-6-->

                                        <div class="pull-left">
                                            <button type="submit" class="btn btn-default">Continue</button>
                                        </div>

                                        <div class="pull-right">
                                            <a href="{{ url('create_account') }}" class="btn btn-default">Create an Account</a>
                                        </div>

                                    </div><!--/.row-->


                                </form><!--/#comment_form-->

                                <div class="margin-top">
                                    <a href="#" data-toggle="modal" data-target="#modal-forgot-password">Forgot Password?</a>
                                </div>
                                <!-- Modal Forgot Passwrod start -->
                                <div class="modal fade" id="modal-forgot-password" tabindex="-1" role="dialog" aria-labelledby="login-modal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Forgot Your Password?</h4>
                                            </div><!-- End .modal-header -->
                                            <form id="login-form-2" method="post" action="login/reset" name="login-form-2" enctype="multipart/form-data" >
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <div class="modal-body clearfix">
                                              <!-- <form action="#" method="post" id="comment_form" name="commentForm"> -->
                                                <p>Please enter your registered email address and we will help you to reset the password. The new generated password will be sent to the email address you entered below.</p>


                                                <div class="input-group"><span class="input-group-addon input-group-addon-new"><i class="fa fa-envelope"></i> <span class="input-text">Email &#42;</span></span>
                                                        <input  id="email"  name="email" type="text" required class="form-control mail-forget" placeholder="Your Email">
                                                 </div>
                                                 <div class="clearfix margin-top"></div>

                                               <!-- </form> -->
                                            </div><!-- End .modal-body -->
                                            <div class="modal-footer">
                                                <button class="btn btn-default btn-sm" name="reset" id="reset" onclick="document.getElementById('login-form-2').submit();">RESET PASSWORD</button>
                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">CLOSE</button>
                                            </div><!-- End .modal-footer -->
                                            </form>
                                        </div><!-- End .modal-content -->
                                    </div><!-- End .modal-dialog -->

                                </div><!-- End .modal forgot password -->


                            </div><!--/.col-md-12-->

                        </div><!--/.row-->
                    </div><!--/.comment-respond-->
                    @endif
                </div>

            </div><!--/.col-md-6-->


            <div class="col-md-6 col-sm-12 col-xs-12 pull-right">

                <table class="table total-table table-responsive">
                    <tbody>
                        <tr>
                            <td class="checkout-table-title text-right" colspan="2"><span
                                    class="alignleft">Subtotal</span></td>
                            <td class="checkout-table-price text-black text-right" colspan="2"><span
                                    class="sub-price alignright">RM
                                    {{ ($isReverseCalculated)?number_format(reverseCalculation($total_amount,$TaxRate), 2):number_format((float)$total_amount, 2, '.', '') }}
                                </span></td>
                        </tr>
                        @if($isReverseCalculated)
                        <tr>
                            <td class="checkout-table-title text-black" colspan="2"><span
                                    class="alignleft">{{$TaxRate[0]->name}} ({{ $TaxRate[0]->rate }}%)</span></td>
                            <td class="checkout-table-price text-black" colspan="2"><span
                                    class="item-price-special text-right alignright">RM
                                    {{ ($isReverseCalculated)?number_format($total_amount-reverseCalculation($total_amount,$TaxRate), 2):'0.00' }}<span
                                        class="sub-price"></span></span></td>
                        </tr>
                        @endif
                        <tr>
                            <td class="checkout-table-title text-danger" colspan="2"><span class="alignleft"
                                    style="text-align: start;">Discount @if(isset($promo->promo_code))
                                    ({{$promo->promo_code}}) @endif<span class="text-12px"></span></span></span> </td>
                            <?php

                             $finalAmount = ($total_amount - $cart['discount_amount']) + $cart['tax_amount'];
                             ?>
                            <td class="checkout-table-price text-danger"><span class="sub-price alignright">- RM
                                    {{ number_format($cart['discount_amount'],2) }}</span></td>
                        </tr>

                        @if($cart['tax_rate'] > 0)
                        <tr>
                            <td class="checkout-table-title " colspan="2"><span class="alignleft">{{$cart['tax_name']}} ({{ $cart['tax_rate'] }}%)</span>
                            </td>
                            <td class="amount"><span class="alignright">RM
                                    {{ number_format($cart['tax_amount'],2) }}<span class="sub-price"></span></span>
                            </td>
                        </tr>
                        @endif
                        @if(count($packages) > 0)
                        <tr>
                            <td class="checkout-table-title text-danger" colspan="2"><span class="alignleft"
                                    style="text-align: start;">Package Discount</td>
                            <?php

                             $finalAmount = $finalAmount - $packages[0]->discount;
                             ?>
                            <td class="checkout-table-price text-danger"><span class="sub-price alignright">- RM
                                    {{ number_format($packages[0]->discount) }}</span></td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span class="alignleft">Total</span></td>
                            <td class="amount-total" colspan="2"><span class="alignright">RM
                                    <?= number_format($finalAmount, 2) ?><span class="sub-price"></span>
                                </span></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="margin-top"></div>



            </div>
        </div><!--/.row-->

        @if(Session::get('userId') != '')
        <div class="row">
        	<div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="room-info">

                        <div class="room-description clearfix">

        					<h4 class="margin-top">Please select the payment option and proceed.</h4>
                        </div>
                    </div>
            </div>
        </div><!--/.row-->

        <div class="row">
            @if(isset($p[3]) && $p[3]->status==1)
                <?php $payData=json_decode($p[3]->content) ?>
            <div class="col-md-6 col-sm-12 col-xs-12">

                <div class="input-group" style="margin-top:10px;">
                	<input name="payment_method" id="bank_method" type="radio"> <span class="checbox-container"></span> Direct Bank In
                	<div class="alert alert-link">
                    	<p>Payee to:</p>
                        <b>{{$payData->accountName}}</b><br/>
                        Bank : <b>{{$payData->bank}}</b><br/>
                        Bank Account Number : <b>{{$payData->accountNumber}}</b><br>
                        Swift Code : <b>{{$payData->swiftCode}}</b>
                    </div>

                    <div class="clearfix"></div>

                    <div class="input-group" id="bankDiv" style="display:none;">
                    	<a class="btn btn-default"
                        href="checkout/addedorderbank">Place order and pay</a>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                </div>

            </div><!-- end col-md-6-->
            @endif

            <div class="col-md-6 col-sm-12 col-xs-12 pull-right">






                @if(isset($p[1]) && $p[1]->status!='0')
            <div class="input-group custom-checkbox">
                    <input type="radio" checked="true" id="ipay88_method" name="payment_method"> <span class="checbox-container"></span> Ipay88
                    <img src="{{asset("public/images/checkout/ipay88.png")}}" alt="Ipay88">
                </div>
                   <div class="row" id="ipay88div">
                        <div class="input-group pull-right">

                            <a class="btn btn-default" href="checkout/addedorder">Pay with Ipay88</a>
                        </div>
                   </div>
                   <div class="clearfix"></div>
                <hr>
                @endif
                <!-- hide paypal button start -->
                @if(isset($p[0]) && $p[0]->status!=0)
                <?php $payData=json_decode($p[0]->content) ?>
                <div class="input-group custom-checkbox">
                <input type="radio" id="PayPal_method" name="payment_method"> <span class="checbox-container"></span> PayPal
                    <img src="{{asset("public/images/checkout/img_paypal.png")}}" alt="PayPal">
                </div>
                <hr>
                <div class="pull-right" id="paypaldiv" style="display:none;">
                    <div id="paypal-button"></div>
                    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
                    <script>
                    paypal.Button.render({

                        //env: 'production', // Or 'sandbox'
                        env: 'sandbox',//'{!! $payData->paypalType !!}',
                        client: {
                            sandbox: '{!!$payData->sandBox!!}',
                            production: '{!!$payData->productionCode!!}'
                        },

                        commit: true, // Show a 'Pay Now' button

                        payment: function (data, actions) {
                            return actions.payment.create({
                                payment: {
                                    transactions: [
                                        {
                                            amount: {total: '{{ number_format($finalAmount, 2) }}', currency: 'MYR'}
                                        }
                                    ]
                                }
                            });
                        },

                        onAuthorize: function (data, actions) {
                            window.location = "{{url('paypal')}}" + '?PaymentID=' + data.paymentID + '&PayerID=' + data.payerID + '&paymentToken=' + data.paymentToken;
                        },

                        style: {
                            size: 'medium',
                            color: 'blue',
                            label: 'pay'
                        }

                    }, '#paypal-button');
                    </script>
                </div>

                <div class="clearfix"></div>
                <hr>
                @endif
                @if(isset($p[2]) && $p[2]->status==1)
                <?php $payData=json_decode($p[2]->content)?>
                <div class="input-group">
                	<input type="radio" name="payment_method" id="eGHL_method"> <span class="checbox-container"></span> eGHL <img src="{{asset('public/images/checkout/img_eGHL.png')}}" alt="eGHL">
                </div>
                <div class="input-group pull-right" id="eGHLdiv" style="display:none;">
                	<a class="btn btn-default" href="checkout/addedorderToeGHL">Pay with eGHL</a>
                </div><!-- end eGHL-->
                <div class="clearfix"></div>
                <hr>
                @endif
                @if(isset($p[4]) && $p[4]->status==1)
                <?php $payData=json_decode($p[4]->content)?>
                <div class="form-group margin-top-10px">
                    <input type="radio" name="payment_method" id="cc_method"> Credit Card
                    <form method="POST" action="checkout/addedorderCC">
                                             	<div class="clearfix"></div><br/>
                                             	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                     @if(isset($payData->visaCard) && $payData->visaCard=='1')
                                                        <input id name="card_type" value="Visa" class="ct" type="radio"> Visa <img src="{{asset('public/images/checkout/visa.png')}}" alt="Visa"> &nbsp;
                                                     @endif
                                                     @if(isset($payData->masterType) && $payData->masterType)
                                                        <input name="card_type" class="ct" value="Master Card" type="radio"> Mastercard <img src="{{asset('public/images/checkout/img_mastercard.png')}}" alt="Mastercard">
                                                     @endif
                                                    </div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <label class="">Cardholder Name *</label>
                                                    <div class="input box-radius">
                                                    	<input id="cardname" type="text" name="cus_name" placeholder="" required="required" class="form-controller">
                                                  </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <label class="">Card Number *</label>
                                                    <div class="input box-radius">
                                                    	<input id="cardnumber" type="text" onkeypress="return isNumberKey(event)" name="card_num" placeholder="" required="" class="form-controller">
                                                    </div>
                                                    <span class="text-12px text-red">Please do not leave any space in this field. </span>
                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <label class="">CVC/CVV2 *</label>
                                                    <div class="input box-radius">
                                                    	<input id="cv" type="text" name="cvc_cvv2"  required class="form-controller">
                                                    </div>
                                                    <span class="text-12px text-primary">3 digits on the back of the card</span>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                	<label class="">Expiration Date *</label>
                                                </div>

                                                <div class="col-md-3 col-sm-6 col-xs-12">
                                                	<div class="input box-radius">
                                                        <select id="month" name="exp_month" required>
                                                          <option value="">- Month -</option>
                                                          <option value="01">01</option>
                                                          <option value="02">02</option>
                                                          <option value="03">03</option>
                                                          <option value="04">04</option>
                                                          <option value="05">05</option>
                                                          <option value="06">06</option>
                                                          <option value="07">07</option>
                                                          <option value="08">08</option>
                                                          <option value="09">09</option>
                                                          <option value="10">10</option>
                                                          <option value="11">11</option>
                                                          <option value="12">12</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-sm-6 col-xs-12">
                                                	<div class="input box-radius">
                                                        <select id="year" name="exp_year" required>
                                                          <option value="">- Year -</option>
                                                          <option value="2020">2020</option>
                                                          <option value="2021">2021</option>
                                                          <option value="2022">2022</option>
                                                          <option value="2023">2023</option>
                                                          <option value="2024">2024</option>
                                                          <option value="2025">2025</option>
                                                          <option value="2026">2026</option>
                                                          <option value="2027">2027</option>
                                                          <option value="2028">2028</option>
                                                          <option value="2029">2029</option>
                                                          <option value="2030">2030</option>
                                                          <option value="2032">2032</option>
                                                          <option value="2033">2033</option>
                                                          <option value="2034">2034</option>
                                                          <option value="2035">2035</option>
                                                          <option value="2036">2036</option>
                                                          <option value="2037">2037</option>
                                                          <option value="2038">2038</option>
                                                          <option value="2039">2039</option>
                                                          <option value="2040">2040</option>
                                                          <option value="2041">2041</option>
                                                          <option value="2042">2042</option>
                                                          <option value="2043">2043</option>
                                                          <option value="2044">2044</option>
                                                          <option value="2045">2045</option>
                                                          <option value="2046">2046</option>
                                                          <option value="2047">2047</option>
                                                          <option value="2048">2048</option>
                                                          <option value="2049">2049</option>
                                                          <option value="2050">2050</option>
                                                        </select>
                                                     </div>

                                                </div>

                                        	</div><!-- end credit card -->
                                            <div class="clearfix"></div>

                                            <div class="input-group pull-right" style="display:none" id="ccDiv">
                                                <button id="ccbtn" class="btn btn-default" >Place order and pay</a>
                                            </div>
                                        </form>
                                            <div class="clearfix"></div>
                                            <hr>
                                            @endif


            </div><!-- end col-md-6-->



        </div><!--/.row-->
        @endif
        <div class="row">

            <div class="col-md-12">

                <div class="single-room list mobile-extend ">
                    <div class="room-info">

                        <div class="room-description clearfix">

                            <h4 class="margin-top">Terms and Conditions</h4>

                            {!! $product_details != null ? $product_details->terms_and_conditions : '' !!}

                            <h4 class="margin-top">Cancellation Policy</h4>
                            {!! $product_details != null ? $product_details->cancellation_policy : '' !!}

                        </div><!--/.room-description-->

                    </div><!--/.room-info-->
                </div><!--/.room-single-content-->
            </div><!--/. col-md-12-->
        </div><!--/.row-->

    </div><!--/.container-->
</div>

<script>
    function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
        jQuery(document).ready(function(){
        //jQuery('.info-property b').html(localStorage.getItem('propertyName'));
            toastr.options.timeOut = 2500; // 1.5s
            jQuery('#ccbtn').prop('disabled', true);
            /* jQuery('#cardnumber').on('change, input keydown', function(e) {
                if( e.which == 8 || e.which == 46 ){
                    return;
                }else{
                var cnum=jQuery('#cardnumber').val();
                if(/\D/.test(cnum)){
                jQuery('#ccbtn').prop('disabled', true);
                toastr.error('You can enter digits only please remove other characters');
                return;
                }
                }
            });
            jQuery('#cardnumber').on('change, input',function(){

            }); */
            jQuery('#cv').change(function(){
                var cval=jQuery('#cv').val();
            if(cval.length!=3){

                jQuery('#ccbtn').prop('disabled', true);
                toastr.error('Enter 3 digits only in cvc');
                jQuery('#cv').focus();
                return;
            }
            if(/\D/.test(cval)){
                jQuery('#ccbtn').prop('disabled', true);
                toastr.error('Enter digits only');
                jQuery('#cv').focus();
                return;
            }

                jQuery('#ccbtn').prop('disabled', false);


            })

        })
        function checkcv(){

        }
</script>
@endsection
