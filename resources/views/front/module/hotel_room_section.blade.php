<section class="hotel-room-section">
      <div class="container-fluid">
        <div class="container-large-screen">

        {{--   <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
            <div class="hotel-room-section-title">
              <h3 class="section-sub-title">Luxurious comfort with a spectacular view of the city</h3>
              <h2 class="section-title">Rooms &amp;<span> Apartments</span></h2>
              <p class="section-title-dec">We guarantee your stay only in the comfort of newly refreshed rooms &amp; suites.</p>
            </div>
          </div>
          </div> --}}
          {!! html_entity_decode($index_second[0]) !!}

          <div class="row mobile-extend">
            {{-- Added By Sagar 4th Sept 2019 (Rooms Only 4)--}}
            <?php
              // merge two array merge into one (rooms as apartments)
              $products = array_merge($rooms,$aparts);
            ?>
            @if($rooms)
             @foreach($products as $key => $product)
            {{-- @if($key == 4)  --}}  <?php //break; ?> {{-- @endif --}}
            <?php
            $packages = DB::table('product_to_quantity_discount')->where('product_id',$product->id)->get();
            ?>
            @if (count($packages) && count($packages) > 1)
              @foreach ($packages as $package)
              <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="single-room">
                  <div class="room-thumb box-radius"><a href="{{route('rooms-suites/show',[$product->id, $package->id])}}"><img src="{{ asset('public/admin/products/medium/'.$product->thumbnail_image_1) }}"" alt="{{$product->type}}"></a>
                            {{-- <span class="label" style="background-color: orangered;top: -13px !important;position: absolute !important;left: 50px !important;height: 30px;font-size: large;">This is the package</span> --}}
                            <span class="label" style="background-color: green;top: 115px !important;position: absolute !important;right: 17px!important;font-size: inherit;">{{ $package->package_name }}</span>   
                  @if($product->promo_behaviour === 'sale')
                      {{--  
                          @if (count($packages) <= 0)
                              <span class="label" style="background-color: orangered;top: -13px !important;position: absolute !important;left: 50px !important;height: 30px;font-size: large;">This is the room promo</span>
                          @endif
                           --}}
                  <img class="promo" src="{{ asset('public/promo/sale_label.png') }}">
                  @elseif($product->promo_behaviour === 'hot')
                  <img class="promo" src="{{ asset('public/promo/hot_label.png') }}">
                  @elseif($product->promo_behaviour === 'new')
                  <img class="promo" src="{{ asset('public/promo/new_label.png') }}">
                  @elseif($product->promo_behaviour === 'pwp')
                  <img class="promo" src="{{ asset('public/promo/pwp_label.png') }}">
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
                    <div class="room-info box-radius"> <!-- style="height:125px" -->
                    <h3 class="room-title"><a href="{{route('rooms-suites/show',[$product->id, $package->id])}}"><span> {{$product->type}} </span></a></h3>
                    {{-- <h5>RM 188 nett / night </h5> --}}
                    @if ($product->sale_price)
                        @if($product->starting_from == 1)
                        <h5 style="font-size: 12px !important;height: 20px;">
                          {{-- <span style="font-size:12px !important">Starting from </span> --}}
                          Starting from
                        @else
                        <h5 style="font-size: 14px !important;height: 20px;">
                        @endif
                        RM {{ number_format((float)$product->sale_price, 2, '.', '') }} @if($product->gross_price_per_night == 1) gross price @elseif($product->net_price_per_night == 1 ||  $product->is_tax == 0) nett price @endif/ trip </h5>
                    @else
                        <h5 style="font-size: 14px !important;height: 20px;"> Please call to enquire.</h5>
                    @endif
                    <h4 class="room-structure">{{$product->guest}}</h4>
               <div class="room-services">
                   <?php $amen = json_decode($product->amenities); ?>
                   @if(!empty($amen))
                   @if(isset($amen->computer)) <i class="fa fa-computer"></i> @endif
                   @if(isset($amen->tv)) <i class="fa fa-television"></i> @endif
                   @if(isset($amen->air)) <i class="fa-air-conditioner"></i> @endif
                   @if(isset($amen->awesome)) <i class="fa fa-eye"></i> @endif
                   @if(isset($amen->service )) <i class="fa fa-diamond"></i> @endif
                   @if(isset($amen->pickup)) <i class="fa fa-plane"></i> @endif
                   @if(isset($amen->wifi)) <i class="fa fa-wifi"></i> @endif
                   @if(isset($amen->coffee )) <i class="fa fa-coffee"></i> @endif
                 @if(isset($amen->lock )) <i class="fa fa-key"></i> @endif
                                    @else
                                            <i class="fa fa-computer" style="visibility: hidden;"></i>
                                          @endif
               </div>
                  </div>
                </div>
              </div>
              @endforeach
            @else
            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="single-room">
                <div class="room-thumb box-radius"><a href="{{route('rooms-suites/show',$product->id)}}"><img src="{{ asset('public/admin/products/medium/'.$product->thumbnail_image_1) }}"" alt="{{$product->type}}"></a>
                   
                    
                      @if (count($packages) > 0)

                          {{-- <span class="label" style="background-color: orangered;top: -13px !important;position: absolute !important;left: 50px !important;height: 30px;font-size: large;">This is the package</span> --}}
                          <span class="label" style="background-color: green;top: 115px !important;position: absolute !important;right: 17px!important;font-size: inherit;">{{ $packages[0]->package_name }}</span>
                      @endif
                   
                @if($product->promo_behaviour === 'sale')
                    {{--  
                        @if (count($packages) <= 0)
                            <span class="label" style="background-color: orangered;top: -13px !important;position: absolute !important;left: 50px !important;height: 30px;font-size: large;">This is the room promo</span>
                        @endif
                         --}}
                <img class="promo" src="{{ asset('public/promo/sale_label.png') }}">
                @elseif($product->promo_behaviour === 'hot')
                <img class="promo" src="{{ asset('public/promo/hot_label.png') }}">
                @elseif($product->promo_behaviour === 'new')
                <img class="promo" src="{{ asset('public/promo/new_label.png') }}">
                @elseif($product->promo_behaviour === 'pwp')
                <img class="promo" src="{{ asset('public/promo/pwp_label.png') }}">
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
                  <div class="room-info box-radius"> <!-- style="height:125px" -->
                  <h3 class="room-title"><a href="{{route('rooms-suites/show',$product->id)}}"><span> {{$product->type}} </span></a></h3>
                  {{-- <h5>RM 188 nett / night </h5> --}}
                  @if ($product->sale_price)
                      @if($product->starting_from == 1)
                      <h5 style="font-size: 12px !important;height: 20px;">
                        {{-- <span style="font-size:12px !important">Starting from </span> --}}
                        Starting from
                      @else
                      <h5 style="font-size: 14px !important;height: 20px;">
                      @endif
                      RM {{ number_format((float)$product->sale_price, 2, '.', '') }} @if($product->gross_price_per_night == 1) gross price @elseif($product->net_price_per_night == 1 ||  $product->is_tax == 0) nett price @endif/ trip </h5>
                  @else
                      <h5 style="font-size: 14px !important;height: 20px;"> Please call to enquire.</h5>
                  @endif
                  <h4 class="room-structure">{{$product->guest}}</h4>
               <div class="room-services">
                   <?php $amen = json_decode($product->amenities); ?>
                   @if(!empty($amen))
                   @if(isset($amen->computer)) <i class="fa fa-computer"></i> @endif
                   @if(isset($amen->tv)) <i class="fa fa-television"></i> @endif
                   @if(isset($amen->air)) <i class="fa-air-conditioner"></i> @endif
                   @if(isset($amen->awesome)) <i class="fa fa-eye"></i> @endif
                   @if(isset($amen->service )) <i class="fa fa-diamond"></i> @endif
                   @if(isset($amen->pickup)) <i class="fa fa-plane"></i> @endif
                   @if(isset($amen->wifi)) <i class="fa fa-wifi"></i> @endif
                   @if(isset($amen->coffee )) <i class="fa fa-coffee"></i> @endif
                 @if(isset($amen->lock )) <i class="fa fa-key"></i> @endif
                                    @else
                                            <i class="fa fa-computer" style="visibility: hidden;"></i>
                                          @endif
               </div>
                </div>
              </div>
            </div>
            @endif
            @endforeach @endif

          </div><!--/.row-->
          <div class="row hidden-md hidden-lg text-center extend-btn"><span class="extend-icon"><i class="fa fa-angle-down"></i></span></div>
        </div><!--/.container-large-screen-->
      </div><!--/.container-fluid-->
    </section><!--/.hotel-room-section-->
