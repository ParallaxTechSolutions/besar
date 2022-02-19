@extends('front/templateFront')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{asset('public/src/dist/css/timepicker.min.css')}}">
    <script src="{{asset('public/src/dist/js/timepicker.min.js')}}"></script>

<style>
.pignose-calendar-body .pignose-calendar-wrapper .pignose-calendar {
    padding: 15px 0 0 0;
}

.pignose-calendar-body .pignose-calendar.pignose-calendar-light:after {
    content: "Please choose your check-in date";
    display: block;
    position: absolute;
    top: 12px;
    margin: auto;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 18px;
}

.pignose-calendar-body .pignose-calendar-wrapper + .pignose-calendar-wrapper .pignose-calendar.pignose-calendar-light:after {
    content: "Please choose your check-out date";
    display: block;
    position: absolute;
    top: 12px;
    margin: auto;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 18px;
}
.span-style {
 position: relative;
 z-index: 2;
 top: 65px;
 left: 20px;
 display: inline-block;
 /*background-color: rgba(140, 80, 19, 0.8);*/
 background-color: rgba(232, 158, 85, 0.8);
 width: auto;
 padding: 10px;
 border: none;
 color: #fff;
 text-align: center;
 text-transform: uppercase;
}
</style>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('body').addClass('pignose-calendar-body');
    });
</script>

<!--<div class="page-heading-area sub-banner9">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="page-heading">
                </h2>--><!--/.page-heading-->
            <!--/div>--><!--/.col-md-12-->
        <!--</div>--><!--/.row-->
    <!--</div>--><!--/.container-->
<!--</div>--><!--/.page-heading-area-->
<!--================= Content Area ===================-->
<div class="room-single-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-full-width">
                <div class="section-title-area text-center">
                    <h2 class="section-title">Rooms &amp; Suites</h2>
                    <p class="section-title-dec">Truly a home away from home.</p>
                </div><!--/.section-title-area-->
            </div><!--/.col-md-8-->
        </div><!--/.row-->

        <div class="row">
            <div class="col-md-8 room-single-content">
                <div class="room-single-thumb">
                    <div class="room-thumb-full owl-carousel">
                        @foreach($images as $image)
                        <?php
                        if($attached_package_id){
                            $packages = DB::table('product_to_quantity_discount')->where('id',$attached_package_id)->get();
                        }else{
                            $packages = DB::table('product_to_quantity_discount')->where('product_id',$product->id)->get();
                        }
                        ?>
                        <div class="item">
                            @if(!empty($product->discount))
                            <span class="span-style">Save
                                {{$products->discount.'%'}}
                            </span>
                            @endif
                            <img src="{{ asset('public/admin/products/large/'.$image->file_name) }}"
                            alt="">
                            @if (count($packages) > 0)
                                <span class="label" style="background-color: green;top: 115px !important;position: absolute !important;right: 17px!important;font-size: inherit;">{{ $packages[0]->package_name }}</span>
                            @endif
                            @if($product->promo_behaviour === 'sale')
{{--                            @if (count($packages) > 0)--}}
{{--                                <span class="label" style="background-color: green;top: 115px !important;position: absolute !important;right: 5px!important;font-size: inherit;">{{ $packages[0]->package_name }}</span>--}}
{{--                            @endif--}}
                            <img class="promo_detail" src="{{ asset('public/promo/sale_label.png') }}">
                            @elseif($product->promo_behaviour === 'hot')
                            <img class="promo_detail" src="{{ asset('public/promo/hot_label.png') }}">
                            @elseif($product->promo_behaviour === 'new')
                            <img class="promo_detail" src="{{ asset('public/promo/new_label.png') }}">
                            @elseif($product->promo_behaviour === 'pwp')
                            <img class="promo_detail" src="{{ asset('public/promo/pwp_label.png') }}">
                            @elseif($product->promo_behaviour === 'last_minute')
                             <img class="promo" src="{{ asset('public/promo/last_minute.png') }}">
                            @elseif($product->promo_behaviour === '24hoursale')
                             <img class="promo" src="{{ asset('public/promo/24hour_sale.png') }}">
                            @elseif($product->promo_behaviour === 'popular')
                             <img class="promo" src="{{ asset('public/promo/popular.png') }}">
                            @elseif($product->promo_behaviour === 'early_bird')
                             <img class="promo" src="{{ asset('public/promo/early_bird.png') }}">

                             @elseif($product->promo_behaviour === 'black_friday')
                            <img class="promo" src="{{ asset('public/promo/black_friday.png') }}">
                             @elseif($product->promo_behaviour === 'singles_day')
                            <img class="promo" src="{{ asset('public/promo/singles_day.png') }}">
                             @elseif($product->promo_behaviour === 'merdeka')
                            <img class="promo" src="{{ asset('public/promo/merdeka.png') }}">
                             @elseif($product->promo_behaviour === 'valentines')
                            <img class="promo" src="{{ asset('public/promo/valentine.png') }}">

                            @endif

                        </div>
                        @endforeach
                    </div>

                    <div class="room-thumb-list owl-carousel">
                        @foreach($images as $image)
                        <div class="item"><img
                            src="{{ asset('public/admin/products/medium/'.$image->file_name) }}"
                            alt=""></div>
                            @endforeach
                        </div>
                    </div><!--/.room-single-thumb-->
                    <div class="single-room list mobile-extend">
                        <div class="room-info">
                            <div class="room-title-area clearfix">
                                <div class="pull-left">
                                    <h3 class="room-title"> {{$product->type}}</h3>

                                    <ul class="clearfix margin-top">
                                        <li><i class="fa fa-bed"></i> <b>BED: </b> {{$product->bed}} </li>
                                        <li><i class="fa fa-user"></i> <b>GUEST: </b> {{$product->guest}}</li>
                                        <li><i class="fa fa-cutlery"></i> <b>MEAL: </b> {{$product->meal}}</li>
                                    </ul>
                                </div>
                                <div class="pull-right">
                                    @if ($product->sale_price)
                                    <h5>
                                        {{ ($product->starting_from == 1)?"Starting from ":"" }}
                                        RM {{number_format((float)$product->sale_price, 2, '.', '')}}
                                        {{-- {{ ($product->is_tax == 0)?"nett":"" }} --}}
                                        @if($product->gross_price_per_night == 1)
                                        gross price
                                        @elseif($product->net_price_per_night == 1 ||  $product->is_tax == 0)
                                        nett price
                                        @endif / night</h5>
                                    @else
                                    <h5>Please call to enquire.</h5>
                                    @endif
                                </div>
                            </div><!--/.room-title-area-->
                            <div class="room-description clearfix margin-top">
                                @if(count($packages) > 0)
                                    <h4>Value Added Services</h4>
                                    @foreach(explode(",",$packages[0]->value_added_service) as $service)
                                        <p style=" color:#525252; margin-bottom: 2px;font-size: 16px;">&gt;&gt; {{ $service }}</p>
                                        <!-- <br> -->
                                    @endforeach
<!--                                     <p style=" color:#525252; font-size: 16px; margin-bottom: 0px;">
                                        <b>Minimum Stay : </b>
                                        {{$packages[0]->minimum_stay}}
                                    </p>
                                    <p style=" color:#525252; font-size: 16px;margin-bottom: 0px;">
                                        <b>Check In : </b>
                                        @if($packages[0]->checkin_mo == 1)
                                            Monday ,
                                        @endif
                                        @if($packages[0]->checkin_tu == 1)
                                            Tuesday ,
                                        @endif
                                        @if($packages[0]->checkin_we == 1)
                                            Wednesday ,
                                        @endif
                                        @if($packages[0]->checkin_th == 1)
                                            Thursday ,
                                        @endif
                                        @if($packages[0]->checkin_fr == 1)
                                            Friday ,
                                        @endif
                                        @if($packages[0]->checkin_sa == 1)
                                            Saturday ,
                                        @endif
                                        @if($packages[0]->checkin_su == 1)
                                            Sunday
                                        @endif
                                    </p>
                                    <p style=" color:#525252; font-size: 16px;">
                                        <b>Check Out : </b>
                                        @if($packages[0]->checkout_mo == 1)
                                            Monday ,
                                        @endif
                                        @if($packages[0]->checkout_tu == 1)
                                            Tuesday ,
                                        @endif
                                        @if($packages[0]->checkout_we == 1)
                                            Wednesday ,
                                        @endif
                                        @if($packages[0]->checkout_th == 1)
                                            Thursday ,
                                        @endif
                                        @if($packages[0]->checkout_fr == 1)
                                            Friday ,
                                        @endif
                                        @if($packages[0]->checkout_sa == 1)
                                            Saturday ,
                                        @endif
                                        @if($packages[0]->checkout_su == 1)
                                            Sunday
                                        @endif
                                    </p> -->

                                @endif

                                <h4>Room Overview</h4>
                                <p>{!! $product->description !!}</p>

                                <h4>Room Amenities</h4>
                                <?php
                                $amenities = json_decode($product->amenities, true);
                                ;
                                //  dd($amenities);
                                ?>
                                <div class="room-service-area clearfix">
                                    <ul class="room-services list-unstyled">
                                    <!--@if(isset($amenities['r_size']))
                                        <li><i class="fa fa-home"></i>Room Size {{$amenities['r_size_ft'] or ''}} FT<sup>2</sup></li>
                                        @endif-->
                                        @if(isset($amenities['fridge']))
                                        <li><i class="fa fa-angle-double-right"></i>Mini fridge</li>
                                        @endif
                                        @if(isset($amenities['singledoorfridge']))
                                        <li><i class="fa fa-angle-double-right"></i>Single door fridge</li>
                                        @endif
                                        @if(isset($amenities['twodoorfridge']))
                                        <li><i class="fa fa-angle-double-right"></i>2 door fridge</li>
                                        @endif
                                        @if(isset($amenities['minibar']))
                                        <li><i class="fa fa-glass"></i>Mini-bar</li>
                                        @endif
                                        @if(isset($amenities['wifi']))
                                        <li><i class="fa fa-wifi"></i>Free wifi</li>
                                        @endif
                                        @if(isset($amenities['tv']))
                                        <li><i class="fa fa-television"></i>32" Flat screen TV</li>
                                        @endif
                                        @if(isset($amenities['inchtv']))
                                        <li><i class="fa fa-television"></i>42" Flat screen TV</li>
                                        @endif
                                        @if(isset($amenities['selectedastro']))
                                        <li><i class="fa fa-list-ul"></i>Selected Astro channels</li>
                                        @endif
                                        @if(isset($amenities['astro']))
                                        <li><i class="fa fa-list-ul"></i>Astro channels</li>
                                        @endif
                                        @if(isset($amenities['coffee']))
                                        <li><i class="fa fa-coffee"></i>Coffee making facilities</li>
                                        @endif
                                        @if(isset($amenities['coffeetable']))
                                        <li><i class="fa fa-angle-double-right"></i>Coffee table</li>
                                        @endif
                                        @if(isset($amenities['diningtable']))
                                        <li><i class="fa fa-angle-double-right"></i>Dining table for 6</li>
                                        @endif
                                        @if(isset($amenities['shower']))
                                        <li><i class="fa fa-shower"></i>Standing shower</li>
                                        @endif
                                        @if(isset($amenities['bathroom']))
                                        <li><i class="fa fa-bath"></i>Bathroom (2 units)</li>
                                        @endif
                                        @if(isset($amenities['bathtub']))
                                        <li><i class="fa fa-bath"></i>Bathtub</li>
                                        @endif
                                        @if(isset($amenities['jacuzzi']))
                                        <li><i class="fa fa-angle-double-right"></i>Jacuzzi</li>
                                        @endif
                                        @if(isset($amenities['pantry']))
                                        <li><i class="fa fa-angle-double-right"></i>Pantry area</li>
                                        @endif
                                        @if(isset($amenities['livingroom']))
                                        <li><i class="fa fa-angle-double-right"></i>Living room with 2 seater sofa</li>
                                        @endif
                                        @if(isset($amenities['twosinglesofa']))
                                        <li><i class="fa fa-angle-double-right"></i>2 Single sofa</li>
                                        @endif
                                        @if(isset($amenities['largesofa']))
                                        <li><i class="fa fa-angle-double-right"></i>Large sofa</li>
                                        @endif
                                        @if(isset($amenities['woodenfloor']))
                                        <li><i class="fa fa-angle-double-right"></i>Wooden floor</li>
                                        @endif
                                        @if(isset($amenities['carpetedfloor']))
                                        <li><i class="fa fa-angle-double-right"></i>Carpeted floor</li>
                                        @endif
                                        @if(isset($amenities['balcony']))
                                        <li><i class="fa fa-angle-double-right"></i>Spacious balcony</li>
                                        @endif

                                        <!-- ritz garden original amenities -->
                                        @if(isset($amenities['aircon']))
                                        <li><i class="fa fa-thermometer"></i>Individually controllable
                                            Air-conditioning
                                        </li>
                                        @endif

                                        @if(isset($amenities['water']))
                                        <li><i class="fa fa-check-circle-o"></i>Bottled drinking water</li>
                                        @endif

                                        @if(isset($amenities['safe']))
                                        <li><i class="fa fa-lock"></i>In room electronic safe</li>
                                        @endif
                                        @if(isset($amenities['hairdryer']))
                                        <li><i class="fa fa-check-circle-o"></i>Built-in hairdryer</li>
                                        @endif

                                        @if(isset($amenities['phone']))
                                        <li><i class="fa fa-fax"></i>IDD phone</li>
                                        @endif

                                            @if(isset($amenities['kiblat']))
                                            <li><i class="fa fa-arrows"></i>Kiblat directional sign</li>
                                            @endif
                                            @if(isset($amenities['laundry']))
                                            <li><i class="fa fa-check-circle-o"></i>Laundry service</li>
                                            @endif
                                            @if(isset($amenities['ironboard']))
                                            <li><i class="fa fa-check-circle-o"></i>Ironing board</li>
                                            @endif
                                            @if(isset($amenities['pool']))
                                            <li><i class="fa fa-check-circle-o"></i>Private swimming pool</li>
                                            @endif

                                            @if(isset($amenities['sauna']))
                                            <li><i class="fa fa-check-circle-o"></i>Steam/sauna bath</li>
                                            @endif
                                            @if(isset($amenities['kitchen']))
                                            <li><i class="fa fa-free-code-camp"></i>Kitchen facilities</li>
                                            @endif

                                            @if(isset($amenities['sitting']))
                                            <li><i class="fa fa-check-circle-o"></i>Comfortable sitting room
                                                with sofa &amp; dining table
                                            </li>
                                            @endif
                                            <!-- end ritz garden original amenities -->




                                       <!--@if(isset($amenities['safe']))
                                        <li><i class="fa fa-lock"></i>In room electronic safe</li>
                                        @endif
                                        @if(isset($amenities['hairdryer']))
                                        <li><i class="fa fa-check-circle-o"></i>Built-in hairdryer</li>
                                        @endif

                                        @if(isset($amenities['phone']))
                                        <li><i class="fa fa-fax"></i>IDD phone</li>
                                        @endif
                                        @if(isset($amenities['computer']))
                                            <li><i class="fa fa-laptop"></i>Computer</li>
@endif
                                            @if(isset($amenities['awesome']))
                                            <li><i class="fa fa-eye"></i>Awesome View</li>
                                            @endif


                                            @if(isset($amenities['kiblat']))
                               				<li><i class="fa fa-arrows"></i>Kiblat directional sign</li>
                                            @endif
                                            @if(isset($amenities['laundry']))
                                            <li><i class="fa fa-check-circle-o"></i>Laundry service</li>
                                            @endif
                                            @if(isset($amenities['ironboard']))
                                            <li><i class="fa fa-check-circle-o"></i>Ironing board</li>
                                            @endif
                                            @if(isset($amenities['pool']))
                                            <li><i class="fa fa-check-circle-o"></i>Private swimming pool</li>
                                            @endif

                                            @if(isset($amenities['sauna']))
                                            <li><i class="fa fa-check-circle-o"></i>Steam/sauna bath</li>
                                            @endif
                                            @if(isset($amenities['kitchen']))
                                            <li><i class="fa fa-free-code-camp"></i>Kitchen facilities</li>
                                            @endif
                                            @if(isset($amenities['flatscreen']))
                                            <li><i class="fa fa-television"></i>Flat screen TV in all rooms</li>
                                            @endif
                                            @if(isset($amenities['sitting']))
                                            <li><i class="fa fa-check-circle-o"></i>Comfortable sitting room
                                                with sofa &amp; dining table
                                            </li>
                                            @endif
                                            @if(isset($amenities['air']))
                                                <li><i class="fa fa-spinner"></i>Air Conditioning</li>
@endif
                                            @if(isset($amenities['lock']))
                                                <li><i class="fa fa-key"></i>Double Locking Doors</li>
@endif
                                            @if(isset($amenities['coffee']))
                                                <li><i class="fa fa-coffee"></i>Tea/Coffee Making Facilities</li>
@endif
                                            @if(isset($amenities['service']))
                                                <li><i class="fa fa-user-plus"></i>Room Service</li>
@endif
                                            @if(isset($amenities['pickup']))
                                                <li><i class="fa fa-plane"></i>Airport Pickup</li>
                                                @endif-->
                                            </ul>
                                        </div><!--/.room-service-area-->

                                        <!--<h4>Terms and Conditions</h4>

                                        <ul class="list-group-item">
                                            <li>- All rates are inclusive of breakfast.</li>
                                            <li>- Connecting Room is available upon request and subject to availability.</li>
                                            <li>- Extra bed at RM55 Nett per night inclusive of 1 breakfast.</li>
                                            <li>- Late check-out, day use rate will apply.</li>
                                            <li>- Full day rate will apply, if check out time exceeds 6pm.</li>
                                            <li>- Long term, group and corporate rate available upon request.</li>
                                            <li>- All major credit cards accepted.</li>
                                            <li>- Rates are subject to change without prior notice.</li>
                                            <li>- Check-in time: 3:00 pm.</li>
                                            <li>- Check-out time: 12:00 noon.</li>
                                        </ul>
                                        <h4 class="margin-top">Cancellation Policy</h4>
                                        <p>One night's room charge shall be levied on guaranteed reservations, in the event of
                                            "no show" or if cancelled within/less than 48 hours before the day of arrival.
                                        Please cancel online or contact us at (05) 242-7777.</p>
                                        <p>For bookings made less than 2 working days before arrival date, the hotel reserves
                                        the right to charge your credit card upon confirmation.</p>
                                        <p>Cancellation policy for festive/peak season will supercede those stated here.
                                            Customers are deemed to have understood and agreed to the above before making this
                                        reservation.</p>-->

                                    </div><!--/.room-description-->


                                </div><!--/.room-info-->
                            </div><!--/.room-single-content-->
                            <div class="hidden-md hidden-lg text-center extend-btn"><span class="extend-icon"><i
                                class="fa fa-angle-down"></i></span></div>
                            </div><!--/.col-md-8-->
                            <div class="col-md-4 room-single-sidebar">

                                <div class="alert alert-warning" style="display: none; " id="room_not_available">
                                    <i class="fa fa-exclamation-circle"></i>
                                    Rooms not available for these dates.
                                    <!-- Only <strong ><span id="rooms_left"></span> left</strong> of this type. -->
                                </div>
                                <div class="alert alert-warning" style="display: none; " id="less_rooms_available">
                                    <i class="fa fa-exclamation-circle"></i>
                                    {{-- Only <strong ><span id="rooms_left"></span> left</strong> of this room type. --}}
                                    Sorry, no room is available for the selected date. Please choose another date.
                                </div>
                                <div class="alert alert-warning" style="display: none; " id="room_not_available_selected_date">
                                    <i class="fa fa-exclamation-circle"></i>
                                    Sorry, no room is available for the selected date. Please choose another date.
                                </div>

                                <form action="{{url('check-availability')}}" class="review-comment-form box-radius" id="checkavailabilityform">
                                    <input type="hidden" name="pid" value="{{$product->id}}">
                                    <p>Your reservation</p>

                                    <div class="single-input">
                                        <label class="text-uppercase">Pick Up</label>
                                        <div class="input box-radius"><i class="fa fa-caret-down"></i>
                                            <select name="property" id="property">
                                                @foreach($properties as $key => $val)
                                                    @if($val->property_id==$product->property_id)
                                                    <option value="{{$val->property_id}}">{{$val->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="single-input">
                                        <label class="text-uppercase">Drop Off</label>
                                        <div class="input box-radius"><i class="fa fa-caret-down"></i>
                                            <select name="arrival" id="property">
                                                @foreach($dropOffList as $key => $val)
                                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="single-input">
                                        <label class="text-uppercase">Date</label>
                                        <div class="input box-radius"><i class="fa fa-calendar"></i>
                                            <input type="text" id="date-departure" placeholder="Date" name="departure"
                                            class="form-controller">
                                        </div>
                                    </div>

                                    <div class="single-input">
                                        <label class="text-uppercase">Time</label>
                                        <div class="input box-radius">
                                            <input type='text' name="room" style="width:100%"  placeholder="Time"    class="form-controller bs-timepicker">
                                        </div>
                                    </div>
                                    <div class="single-input">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label class="text-uppercase">Adult</label>
                                                <div class="input box-radius"><i class="fa fa-caret-down"></i>
                                                    <select name="adult" id="adult-avail">
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
                                            <div class="col-xs-6">
                                                <label class="text-uppercase">Children</label>
                                                <div class="input box-radius"><i class="fa fa-caret-down"></i>
                                                    <select name="childrens" id="children-avail">
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
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-submit" onclick="checkAvail()">Check Availability</button>
                                </form><!--/.review-comment-form-->
                            </div><!--/.col-md-4-->
                        </div><!--/.row-->

                    </div><!--/.container-->
                </div>
                <div class="modal fade" id="modal-validation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onClick="$('.form-horizontal').trigger('reset');" class="close"
                    data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Validation</h4>
            </div><!-- End .modal-header -->
            <div class="modal-body clearfix">
                <div class="modal-html-text">
                    <p id=modal-data-text>Please insert the Check-in Date and Check-out Date.</p>
                </div>

                <div class="xs-margin"></div>
                <div class="pull-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                        onClick="$('.form-horizontal').trigger('reset');">CLOSE
                    </button>
                </div>



            </div><!-- End .modal-body -->
        </div><!-- End .modal-content -->
    </div><!-- End .modal-dialog -->
</div><!-- End .modal forgot password -->
                <script type="text/javascript">

                    $(function () {
                        $('.bs-timepicker').timepicker();
                    });

                    window.onload = function () {
                        jQuery('#date-arrival').pignoseCalendar({
                            buttons: true,
                            minDate: new Date(),
                            select: function (date, context) {
                            },
                            apply: function (date, context) {
                                console.log(date);
                                var dd = moment(date);
                                dd.set('date', dd.get('date') + 1);
                                console.log("date ==", dd.format('YYYY-MM-DD'));
                                if (jQuery('#date-departure').val() != '' && new Date(jQuery('#date-arrival').val()) >= new Date(jQuery('#date-departure').val())) {
                                    jQuery('#date-departure').val(dd.format('YYYY-MM-DD'));
                                }
                                jQuery('#date-departure').pignoseCalendar('set', dd.format('YYYY-MM-DD'));
                                jQuery('#date-departure').trigger("click");
                            }
                        });
                        jQuery('#date-departure').pignoseCalendar({
                            buttons: true,
                            minDate: new Date(),
                            select: function (dates, context) {
                            },
                            apply: function (date, context) {
                                if (new Date(jQuery('#date-arrival').val()) >= new Date(date)) {
                                    jQuery('#date-departure').val('');
                                    jQuery('#modal-data-text').text('Please select departure date bigger than arrival date.');
                                    jQuery('#modal-validation').modal('show');

                                    //alert('Please select departure date bigger than arrival date.');
                                }
                            }
                        });
                    };
                    function checkAvail() {

                        jQuery('#room_not_available').hide();
                        jQuery('#less_rooms_available').hide();
                        jQuery('#room_not_available_selected_date').hide();

                        @if (!$product->sale_price)
                            //jQuery('#room_not_available').html('<i class="fa fa-exclamation-circle"></i> Please call to enquire.');

                            /* jQuery('#modal-html-text').html('<i class="fa fa-exclamation-circle"></i> Please call to enquire.')
                            jQuery('#modal-validation').modal('show') */
                            //jQuery('#room_not_available').show();
                            /* $('html, body').animate({
                                scrollTop: $("#room_not_available").offset().top-100
                            }, 2000); */

                        @endif

                        var arrival = jQuery('#date-arrival').val();
                        var departure = jQuery('#date-departure').val();
                        var roomsAvail = jQuery("#room-avail").val();
                        var adultsAvail = jQuery("#adult-avail").val();
                        var childrenAvail = jQuery("#children-avail").val();
                        var property = jQuery("#property").val();

                //console.log(rooms);

                if (arrival == '' || departure == '') {
                    jQuery('#modal-data-text').text('Please select arrival and departure date.');
                    jQuery('#modal-validation').modal('show');
                    return;
                }
                // $.LoadingOverlay("show");

                jQuery('#no-result').hide();

                var data = {
                    _token: '{{ csrf_token() }}',
                    checkin_date: arrival,
                    checkout_date: departure,
                    room: jQuery('#room-avail').val(),
                    adult: jQuery('#adult-avail').val(),
                    childrens: jQuery('#children-avail').val(),
                    property: property,
                    product_id: '<?php echo empty($product->id) ? '' : $product->id ?>'
                };
                jQuery.ajax({
                    url: "{{ url('check-availability-left') }}",
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    cache:false,
                    success: function (response) {
                        if (response.status) {

                            if (response.dates) {
                                /* jQuery('#modal-html-text').html('<i class="fa fa-exclamation-circle"></i> Rooms not available for these dates.');
                                jQuery('#modal-validation').modal('show'); */
                                jQuery('#room_not_available').show();
                                 $('html, body').animate({
                                      scrollTop: $("#room_not_available").offset().top
                                    },1000);
                                var dateArray = response.dates.split(' ');
                                dateArray.pop();
                                var errorMessage = '';

                                if (dateArray.length == 1) {
                                    jQuery('#modal-data-text').text("Date " + dateArray[0] + ' is not available. Please select different date(s).');
                                    jQuery('#modal-validation').modal('show');
                                } else if (dateArray.length > 1) {
                                    var errorMessage = '';

                                    for (var i = 0; i < dateArray.length; i++) {
                                        if (i == 0) {
                                            errorMessage += "Dates " + dateArray[i];
                                        } else if (dateArray.length == i + 1) {
                                            errorMessage += " and " + dateArray[i] + " are not available. Please select different date(s)."
                                        } else {
                                            errorMessage += ", " + dateArray[i];
                                        }
                                    }
                                    jQuery('#modal-data-text').text(errorMessage);
                                    jQuery('#modal-validation').modal('show');
                                    // alert(errorMessage);
                                }
                                return false;
                            } else if (response.avail.length) {
                                if(roomsAvail > response.available){
                                    /* jQuery('#modal-html-text').html('<i class="fa fa-exclamation-circle"></i>Only <strong ><span id="rooms_left"></span> left</strong> of this room type.');
                                jQuery('#modal-validation').modal('show'); */
                                    jQuery('#less_rooms_available').show();
                                  $('html, body').animate({
                                      scrollTop: $("#less_rooms_available").offset().top
                                    },1000);
                                    jQuery('#rooms_left').html(response.available);
                                    return false;
                                }
                                rooms = response.avail;
                                console.log("response.avail = ", response.avail);

                                jQuery("#checkavailabilityform").submit();
                                return true;

                            } else {
                                $("#room_not_available_selected_date").show();
                                $('html, body').animate({
                                    scrollTop: $("#room_not_available_selected_date").offset().top
                                },1000);
                                jQuery('#rooms_left').html(response.available);
                                return false;
                            }
                        } else {

                        }

                    },
                    async: false,
                });

}
</script>

@endsection
