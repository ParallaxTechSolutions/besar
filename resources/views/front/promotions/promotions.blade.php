<?php
  $banners = \App\Models\BannerLeft::getBannerImages(2); 
  $header = DB::table('page_header')->where('page','promotions')->get();
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
    <div class="blog-page-area bg-grey">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-full-width">
            <div class="section-title-area text-center">
              <?= $header[0]->content ?>
              <!-- <h2 class="section-title">Promotions</h2>
              <p class="section-title-dec">From simple white coffee and toast to German and Italy selection or even for a taste of Oriental delight, you will not be disappointed!</p> -->
            </div><!--/.section-title-area-->
          </div><!--/.col-md-6-->
        </div><!--/.row-->
        
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              {{-- {{ dd($promotion) }} --}}
              @foreach($promotion as $key)
              <?php $t = date_create_from_format("d/m/Y", $key->date); ?>

                <div class="col-md-4 col-sm-6 col-xs-6">
                    <!-- Single post-->
                    <div class="post hentry box-radius text-center">
                        <div class="entry-header">
                            <figure class="post-thumb"><a href="{{ asset('public/front/images/promotions/'.$key->enlarge_image) }}"  class="image-popup-btn"><img src="{{ asset('public/front/images/promotions/'.$key->image) }}" alt="{{$key->title}}" style="height:400px;"></a></figure><!--/.post-thumb-->
                            <div class="entry-meta">
                              <span class="entry-date">{{date('M d, Y', strtotime($key->date))}} </span>
                              {{-- <span class="entry-date">{{date_format($t, "M d, Y")}} </span> --}}
                              <span class="entry-cat">{{$key->title}} </span></div>
                        </div><!--/.entry-header-->
                        <h2 class="entry-title" style="height:72px;overflow: hidden;">{{$key->short_description}}</h2><!--/.entry-title-->
                        <div class="entry-footer">
                            <div class="entry-footer-meta entry-meta"><span class="entry-see"></span></div><!--/.entry-footer-meta-->
                        </div><!--/.entry-footer-->
                    </div><!--/.post-->
                </div><!--/.col-md-4--> 
                <div class="clearfix hidden-md hidden-lg"></div>
              @endforeach
                  <div class="clearfix hidden-xs hidden-sm"></div>
                  <div class="clearfix hidden-md hidden-lg"></div>
                </div><!--/.row-->        
          </div><!--/. col-md-12-->
        </div>
      </div>
    </div><!--/.promotions-->
