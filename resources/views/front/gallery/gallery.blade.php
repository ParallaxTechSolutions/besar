<?php
  $banners = \App\Models\BannerLeft::getBannerImages(13); 
  $header = DB::table('page_header')->where('page','gallery')->get();
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
    <div class="wedding-page-area bg-grey">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-title-area text-center">
              <h2 class="section-title"><?= $header[0]->content ?></h2>
            </div><!--/.section-title-area-->
          </div><!--/.col-md-12-->
        </div><!--/.row-->
      </div><!--/.container-->
      
      
      <div class="single-gallery-group">
      <div class="container">
        
        <div class="row">
          <div class="col-md-12">
            <div class="single-gallery-content">
              <div class="row">
                <div class="col-md-12">
                  <ul class="gallery-filter-menu">
                    <li class="current-tab"><a href="#" data-filter="*" class="filter">Show All</a></li>
                    @foreach($category as $cat)
                      <li><a href="#" data-filter=".cat-{{$cat->id}}" class="filter">{{$cat->name}}</a></li>
                    @endforeach
                    <!-- <li><a href="#" data-filter=".rooms" class="filter">Rooms</a></li>
                    <li><a href="#" data-filter=".dining" class="filter">Dining</a></li>
                    <li><a href="#" data-filter=".facilities" class="filter">Facilities</a></li>
                    <li><a href="#" data-filter=".wedding" class="filter">Weddings</a></li>
                    <li><a href="#" data-filter=".events-meetings" class="filter">Meetings</a></li> -->
                  </ul><!--/.gallery-filter-menu-->
                </div><!--/.col-md-12-->
              </div><!--/.row-->
              <div class="row gallery-item-content">
                @foreach($gallery as $key)
                <div class="col-md-3 grid cat-{{$key->category_id}}">
                  <div class="single-item format-zoom"><a href="{{ asset('public/front/images/gallery/'.$key->lg_image) }}" class="image-popup-btn" title="{{$key->name}}"><img src="{{ asset('public/front/images/gallery/'.$key->sm_image) }}" alt="{{$key->name}}"></a></div><!--/.single-item-->
                </div><!--/.grid-->
                @endforeach
                
                <!-- end functions and meetings -->
                
                
                
                
              </div><!--/.gallery-item-content-->
            </div><!--/.single-gallery-content-->
          </div><!--/.col-md-12-->
        </div><!--/.row-->
      </div><!--/.container-->
    </div><!--/.single-gallery-group-->
    </div><!--/.wedding-plan-area-->
    