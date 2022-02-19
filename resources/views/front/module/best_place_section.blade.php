<?php 

 $page_images_top = DB::table('page_images')
    ->where(array('page' => 'home','type' => 'top','status' => 1))
    ->Orderby('order', 'asc')->limit(4)->get();
?>


<section class="best-place-section best-place-style-one">
      <div class="container-fluid">
        <div class="container-large-screen">
          <div class="row">
            <div class="col-md-8 col-full-width">
              <div class="section-title-area text-center section-title-style-two">
                <div class="section-title-style-inner">
                 {{--  <h3 class="section-sub-title">Retreat within stylish hotel rooms and suites</h3>
                  <h2 class="section-title">A Uniquely Sophisticated <br/>Living Experience</h2>
                  <p class="section-title-dec">Strategically located within the main business hub of Ipoh city centre, Tower Regency Hotel &amp; Apartments combine refined luxury with unparalleled accessibility to provide a uniquely sophisticated living experience. </p> --}}

                {!! html_entity_decode($index_first[0]) !!}
                </div><!--/.section-title-style-inner-->
              </div><!--/.section-title-area-->
            </div><!--/.col-md-6-->
          </div><!--/.row-->
          <div class="row mobile-extend">
            @if($page_images_top) @foreach($page_images_top as $top)
            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="single-best-place">
                <div class="best-place-thumb"><img src="{{ asset('public/images/home/'. $top->image) }}" alt="{{ $top->title }}" class="box-radius"></div>
                <div class="place-overlay">
                  <div class="place-overlay-outer"><a target="_blank" href="{{ $top->link }}">{{ $top->title }}</a></div><!--/.place-overlay-outer-->
                </div>
              </div>
            </div>
            @endforeach @endif
           {{--  <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="single-best-place">
                <div class="best-place-thumb"><img src="{{ asset('public/front/images/index/img_room.jpg') }}" alt="Rooms / Apartments" class="box-radius"></div><!--/.best-place-thumb-->
                <div class="place-overlay">
                  <div class="place-overlay-outer"><a href="{{url('/rooms-suites/8')}}">Elegantly Appointed Rooms / Apartments</a></div><!--/.place-overlay-outer-->
                </div>
              </div>
            </div>
           
            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="single-best-place">
                <div class="best-place-thumb"><img src="{{ asset('public/front/images/index/img_meeting.jpg') }}" alt="Meetings &amp; Functions" class="box-radius"></div><!--/.best-place-thumb-->
                <div class="place-overlay">
                  <div class="place-overlay-outer"><a href="{{url('/events-meetings/25')}}">Versatile for Events and Seminars</a></div><!--/.place-overlay-outer-->
                </div>
              </div>
            </div>
           
            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="single-best-place">
                <div class="best-place-thumb"><img src="{{ asset('public/front/images/index/img_facility.jpg') }}" alt="Facilities" class="box-radius"></div><!--/.best-place-thumb-->
                <div class="place-overlay">
                  <div class="place-overlay-outer"><a href="{{url('/facilities')}}">Wide Range of Facilities and Services</a></div><!--/.place-overlay-outer-->
                </div>
              </div>
            </div>
           
            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="single-best-place">
                <div class="best-place-thumb"><img src="{{ asset('public/front/images/index/img_wedding.jpg') }}" alt="Wedding" class="box-radius"></div><!--/.best-place-thumb-->
                <div class="place-overlay">
                  <div class="place-overlay-outer"><a href="{{url('/weddings/10')}}">Perfect Wedding Events arrangement</a></div><!--/.place-overlay-outer-->
                </div>
              </div>
            </div>   --}}          
            <div class="clearfix hidden-xs"></div>
            
          </div><!--/.row-->
  
        </div><!--/.container-large-screen-->
      </div><!--/.container-->
    </section><!--/.best-place-section-->
