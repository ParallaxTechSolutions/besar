<?php
  $banners = \App\Models\BannerLeft::getBannerImages(10);
  $header = DB::table('page_header')->where('page','wedding')->get();
  $content = DB::table('pages')->where('page','=','wedding')->first();
  $content=unserialize($content->new_content);

  $page_images_left = DB::table('page_images')
    ->where(array('page' => 'wedding','type' => 'left','status'=>1))
    ->Orderby('order', 'asc')->limit(2)->get();
    $page_images_bottom = DB::table('page_images')
    ->where(array('page' => 'wedding','type' => 'bottom','status'=>1))
    ->Orderby('order', 'asc')->limit(10)->get();
?>
<!--================= Page Wellcome Area ===================-->
@if($banners != NULL)
<div id="subcatCarousel" class="carousel slide subcat-slider" data-ride="carousel">

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    @foreach($banners as $key =>$banner)
    <div class="item @if($key == 0) active @endif" style="background-image:url('{{ asset('public/admin/images/banner/left/'.$banner->banner) }}');height:350px">
    </div>
    @endforeach
  <!-- Left and right controls -->
  <a class="left carousel-control" href="#subcatCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#subcatCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
@endif
    <!--================= Content Area ===================-->
    <div class="spa-page-area">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-full-width">
            <div class="section-title-area text-center">
                <?= $header[0]->content ?>
            </div><!--/.section-title-area-->
          </div><!--/.col-md-8-->
        </div><!--/.row-->
        <div class="row">
          <div class="col-md-7">
            <div class="section-gallery-group">
                 @if($page_images_left) @foreach($page_images_left as $image)
                       <div class="col-sm-6 col-sm-6 col-xs-6">
                        <figure class="item"><img src="{{ asset('public/images/wedding/'.$image->image) }}" alt="{{ $image->title }}"></figure>
                      </div>
                    @endforeach @endif
              {{-- <div class="col-sm-6 col-xs-6">
                <figure class="item"><img src="{{ asset('public/front/images/weddings/img_wedding1.jpg') }}" alt="Wedding"></figure>
              </div> --}}
              {{-- <div class="col-sm-6 col-xs-6">
                <figure class="item"><img src="{{ asset('public/front/images//weddings/img_wedding2.jpg') }}" alt="Grand Ballroom"></figure>
              </div> --}}
              <div class="clearfix"></div>
            </div><!--/.section-gallery-group-->
          </div><!--/.col-md-7-->

          <div class="col-md-5">
            <div class="section-align-title-area">
                {!! $content[0] !!}
             {{--  <h2 class="section-align-title">A perfect wedding.</h2>
              <h3 class="dining-title">Regency Grand Ballroom</h3>
              <p class="section-title-dec">Let us take care of your auspicious day with a team of experiences and dedicated professionals. Our chefs will create a menu tailored to your own specifications secured to you and your guests in an elegant and comfortable wedding venue. An unforgettable experience you will always cherish.</p> --}}

            </div><!--/.section-align-title-area-->
          </div><!--/.col-md-5-->

        </div><!--/.row-->

        <div class="clearfix margin-top"></div>

      </div><!--/.container-->
    </div><!--/.wedding -->

    <div class="page-gallery-area padding-top-70px">
      <div class="page-gallery-carousel owl-carousel">
        @if($page_images_bottom) @foreach($page_images_bottom as $image)
        <div class="item"><img src="{{ asset('public/images/wedding/'.$image->image) }}" alt="{{ $image->title }}"></div>
         @endforeach @endif
       {{--  <div class="item"><img src="{{ asset('public/front/images/weddings/img_wedding3.jpg') }}" alt="Wedding"></div><!--/.item-->
        <div class="item"><img src="{{ asset('public/front/images/weddings/img_wedding4.jpg') }}" alt="Wedding"></div><!--/.item-->
        <div class="item"><img src="{{ asset('public/front/images/weddings/img_wedding5.jpg') }}" alt="Wedding"></div><!--/.item-->
        <div class="item"><img src="{{ asset('public/front/images/weddings/img_wedding6.jpg') }}" alt="Wedding"></div><!--/.item--> --}}

      </div><!--/.page-gallery-carousel-->
    </div><!--/.page-gallery-area-->



