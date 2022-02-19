<?php
  //$banners = \App\Models\BannerLeft::getBannerImages(2); 
  $header = DB::table('page_header')->where('page','home_promotions')->get();

  $promotion = DB::table('promotions')
              // ->select("*", DB::raw("DATE_FORMAT(date, '%M %d %Y') as formatdate"))
              ->where('status','Active')
              ->Orderby('id', 'asc')->limit(3)->get();
              //sortBy('count')->take(5)->get();
  $page_images_right = DB::table('page_images')
    ->where(array('page' => 'home','type' => 'right', 'status' => 1))
    ->Orderby('order', 'asc')->limit(4)->get();
?>

<section class="our-gallery-section">
    <!--<h2 class="water-wrap rotated">Banquets</h2>--><!--/.water-wrap-->
    <div class="container">
    <div class="row">
        <div class="col-md-6">
        <div class="section-align-title-area">

          {{--   <h2 class="section-align-title">Banquets</h2>
            <p class="section-align-title-dec">The Leading Choice for<br> Business Meetings &amp; Functions</p>
            <p>Whether you are hosting a Conference, Seminar, Workshop, Theatre Performance or a formal dinner, you can rest assure that all your needs and requirements will be well taken care.</p><a href="{{url('/events-meetings/25')}}" class="btn btn-default">Read More</a> --}}

                {!! html_entity_decode($index_third[0]) !!}

        </div><!--/.section-align-title-area-->
        </div><!--/.col-md-6-->


        <div class="col-md-6">
        <div id="gallery" class="our-gallery-content">
            @if($page_images_right) @foreach($page_images_right as $gallery)
              <a href="{{ $gallery->link }}"><img alt="{{ $gallery->title }}" src="{{ asset('public/images/home/'. $gallery->image) }}" data-image="{{ asset('public/images/home/'. $gallery->image) }}" data-description="{{ $gallery->title }}"></a>
            @endforeach @endif
         {{--    <a href="{{url('/weddings/10')}}"><img alt="Function Room" src="{{ asset('public/front/images/index/img_function_room.jpg') }}" data-image="public/front/images/index/img_function_room_large.jpg" data-description="Function Room"></a>
            <a href="{{url('/events-meetings/25')}}"><img alt="Regency Halls" src="{{ asset('public/front/images/index/img_regency_halls.jpg') }}" data-image="public/front/images/index/img_regency_halls_large.jpg" data-description="Regency Halls"></a>
            <a href="{{url('/weddings/10')}}"><img alt="Meeting" src="{{ asset('public/front/images/index/img_meeting.jpg') }}" data-image="public/front/images/index/img_meeting_large.jpg" data-description="Meeting"></a>
            <a href="#"><img alt="Wedding" src="{{ asset('public/front/images/index/img_wedding2.jpg') }}" data-image="public/front/images/index/img_wedding_large.jpg" data-description="Wedding"></a> --}}

            <!--<a href="{{url('/events-meetings/25')}}"><img alt="Auditorium" src="{{ asset('public/front/images/index/img_auditorium.jpg') }}" data-image="public/front/images/index/img_auditorium_large.jpg" data-description="Auditorium"></a></div>-->
        </div>
    </div><!--/.row-->
    </div><!--/.container-->
</section><!--/.our-gallery-section-->
