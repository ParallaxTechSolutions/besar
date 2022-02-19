      
       
<?php
  //$banners = \App\Models\BannerLeft::getBannerImages(2); 
  $header = DB::table('page_header')->where('page','home_promotions')->get();

  $promotion = DB::table('promotions')
              // ->select("*", DB::raw("DATE_FORMAT(date, '%M %d %Y') as formatdate"))
              //->select("*", DB::raw("DATE_FORMAT(date, '%Y %m %d') as formatdate"))
              ->where('status','Active')
              //->Orderby('id', 'asc')->limit(3)->get()
              ->Orderby('date', 'desc')->limit(3)->get()
              //->orderByRaw(DB::raw("DATE_FORMAT(date,'%Y-%m-%d')"), 'DESC')->limit(3)->get();
              
              //sortBy('count')->take(5)->get();
?>
    <section class="blog-post-section">
      <div class="container-fluid">
        <div class="container-large-screen">
          <div class="row">
            <div class="col-md-12">
              <div class="section-title-area text-center style-two">
                 <?= $header[0]->content ?>
              </div><!--/.section-title-area-->
            </div><!--/.col-md-12-->
          </div><!--/.row-->
          <div class="row">
            
            <div class="col-md-3">
              <div class="section-align-title-area">

                {{-- <h2 class="section-align-title">News &amp; Updates</h2>
                <p class="section-align-title-dec">F &amp; B promotions<br>Latest News<br/>Meeting &amp; Event Packages</p><a href="{{url('/promotions')}}" class="btn btn-default">More Promo</a> --}}
                 {!! html_entity_decode($index_fourth[0]) !!}

              </div><!--/.section-align-title-area-->
            </div><!--/.col-md-3-->
            
            <div class="col-md-9">
              <div class="row">

                
               {{--  <div class="col-md-4 col-sm-6 col-xs-6">                 
                  <div class="post hentry box-radius text-center">
                    <div class="entry-header">
                      <figure class="post-thumb"><a href="{{url('/rooms-suites/show/1330')}}"><img src="{{ asset('public/front/images/promotions/img_room_promo_malaysian.jpg') }}" alt="Deluxe Room Promotion - Malaysian only"></a></figure>
                      <div class="entry-meta"><span class="entry-date">July 06, 2019 </span><br/><span class="entry-cat"><a href="#">Malaysian only</a></span></div>
                    </div>
                    <h2 class="entry-title"><a href="{{url('/rooms-suites/show/1329')}}">Deluxe Room Promotion </a></h2>
                    <div class="entry-footer">
                      <div class="entry-footer-meta entry-meta"><span class="entry-see"></span></div>
                    </div>
                  </div>
                </div>
 --}}
                @foreach($promotion as $key)
                <?php //$t = date_create_from_format("d/m/Y", $key->date); ?>
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <!-- Single post-->
                        <div class="post hentry box-radius text-center">
                            <div class="entry-header">
                                <figure class="post-thumb"><a href="{{ asset('public/front/images/promotions/'.$key->enlarge_image) }}"  class="image-popup-btn"><img src="{{ asset('public/front/images/promotions/'.$key->image) }}" alt="{{$key->title}}" style="height: 270px;width: 100%;"></a></figure><!--/.post-thumb-->
                                <div class="entry-meta">
                                  {{-- <span class="entry-date" style="font-size: 13px;">{{date_format($t, "M d, Y")}} </span> --}}
                                  <span class="entry-date" style="font-size: 13px;">{{date('M d, Y', strtotime($key->date))}} </span>
                                  <span class="entry-cat" style="font-size: 13px;">{{$key->title}} </span></div><!--/.entry-meta-->
                            </div><!--/.entry-header-->
                            <h2 class="entry-title" style="font-size: 17px;">{{$key->short_description}}</h2><!--/.entry-title-->
                            <div class="entry-footer">
                                <div class="entry-footer-meta entry-meta"><span class="entry-see"></span></div><!--/.entry-footer-meta-->
                            </div><!--/.entry-footer-->
                        </div><!--/.post-->
                    </div><!--/.col-md-4--> 
                    <div class="clearfix hidden-md hidden-lg"></div>
                  @endforeach


                
              </div><!--/.row-->
            </div><!--/.col-md-9-->
            
          </div><!--/.row-->
        </div><!--/.container-large-screen-->
      </div><!--/.container-fluid -->
    </section><!--/.blog-post-section-->


    
    <section class="our-gallery-section">
      <div class="container-fluid">
        <div class="container-large-screen">

        <div class="row">
          <div class="col-md-12">
              {!! html_entity_decode($video_title[0]) !!}
           {{--  <div class="section-title-area text-center">
              <h2 class="section-title">Video</h2>
              <p class="section-title-dec">A Towering Achievement</p>
            </div> --}}
            <!--/.section-title-area-->
          </div><!--/.col-md-12-->
        </div><!--/.row-->
        
        <div class="row">
            @if($videos) @foreach($videos as $key => $video)
               <div class="col-md-6">
                <div class="format-video" style="@if($key > 1) padding-top: 20px;  @endif"><a href="{{ url($video->video) }}" class="video-popup-btn"><img src="{{ asset($video->background) }}" alt="{{ $video->title }}"></a></div>
              </div>
            @endforeach @endif
            {{-- <div class="col-md-6">
               <div class="format-video"><a href="{{url('https://www.youtube.com/watch?v=tY-UHSm8Ywg')}}" class="video-popup-btn"><img src="{{ asset('public/front/images/index/intro_video.jpg') }}" alt="Tower Regency Hotel &amp; Apartments"></a></div>
            </div>

        <div class="col-md-6">
            <div class="format-video"><a href="{{ asset('public/front/images/video/video1.mp4') }}" class="video-popup-btn"><img src="{{ asset('public/front/images/video/img_video1.jpg') }}" alt="Tower  Regency Hotel &amp; Apartments"></a></div>
          </div> --}}

        </div><!--/.row-->
        </div><!--.container large screen-->
      </div><!--/.container-fluid-->
    </section><!--/.page-gallery-area-->
