@extends('front/templateFront')
@section('styles')
    <style>
        .span-style {
            display: inline-block;
            /*background-color: rgba(120, 169, 148, 0.8);*/
			background-color: rgba(232, 158, 85, 0.8);
			width: auto;
            padding: 10px;
            border: none;
            color: #fff;
            position: absolute;
            left: 20px;
            top: 10px;
            text-align: center;
            text-transform: uppercase
        }
    </style>
@endsection

@section('content')
@include('front.check_avail.search_area')
<div class="room-grid-area bg-grey">
    <div class="container">
   
      {!! html_entity_decode($index_second[0]) !!}
      <!--/.row-->
      {{-- <div class="row" style="margin:15px">
        <div class="col-md-2">
            <label class="text">Sort by :</label>
            <div class="input box-radius">
                <select name="room" id='cmbSorting'>
                    <!-- <option value="new">New Arrivals</option> -->
                    <option value="priceAsc">Price: Low - High</option>
                    <option value="priceDesc">Price: High - Low</option>
                </select>
            </div>
        </div>
      </div> --}}
      <div class="row align-items-start" id='apartsection'>
       @foreach($products as $product)
         <div class="col-md-4 col-sm-6 col-xs-6">
           <div class="single-room grid">
             @if(!empty($product->discount))
                 <span class="span-style">Save
                  @if($product->discount_by == 'percentage')
                  {{$product->discount}}%
                  @endif
                  @if($product->discount_by == 'amount')
                  RM{{$product->discount}}
                  @endif
                 </span>
             @endif
             <img src="{{ asset('public/admin/products/medium/'.$product->thumbnail_image_1) }}" alt="deluxe room" class="room-thumb">
              @if($product->quantity_in_stock == 1 || $product->quantity_in_stock == 2 || $product->quantity_in_stock == 3)
                <div style="width: 30%;" class="text-center"><div class="highlight second-color text-12px" style="position: absolute; top:290px;"><b>ONLY {{$product->quantity_in_stock}} LEFT</b></div></div>
              @endif
              @if($product->promo_behaviour === 'sale')
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
             <?php
                  $packages = DB::table('product_to_quantity_discount')->where('product_id',$product->id)->get();
             ?>
             @if (count($packages) > 0)
                 <span class="label" style="background-color: green;top: 115px !important;position: absolute !important;right: 17px!important;font-size: inherit;">{{ $packages[0]->package_name }}</span>
             @endif
             <div class="room-info box-radius">
              @if ($product->sale_price)
              <h5 style="font-size:17px !important">
                {{ ($product->starting_from == 1)?"Starting from ":"" }}
                RM {{ number_format((float)$product->sale_price, 2, '.', '') }} 
                {{-- {{ ($product->is_tax == 0)?"nett":"" }}  --}}
               @if($product->gross_price_per_night == 1)
               gross price
               @elseif($product->net_price_per_night == 1 || $product->is_tax == 0)
               nett price
               @endif / trip 
              </h5>
              @else
             <h5 style="font-size: 17px !important">Please call to enquire.</h5>
              @endif
               <h3 class="room-title"><a href="{{route('apartments/show',$product->id)}}">{{$product->type}}</a></h3>
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
                 <a href="{{route('apartments/show',$product->id)}}" class="btn btn-details">more details</a>
             </div>
           </div><!--/.single-room-->
         </div><!--/.col-md-4-->
      @endforeach
      </div>
    </div><!--/.container-->
  </div><!--/.room-grid-area-->

@endsection
@section('scripts')
    <script>
        // $('#onload').fancybox();
        $(window).load(function() {
            $('#onload').click();
            // $('.available-booking').removeClass('hidden');
        });

    </script>
@endsection