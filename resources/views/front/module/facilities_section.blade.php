
{{-- {{ dd($background->background) }} --}}
  <section data-jarallax="{&quot;speed&quot;: 0.3, &quot;imgSrc&quot;: &quot;  @if($background->background) {{ $background->background }} @else public/front/images/parallax/bg_facilities.jpg @endif&quot; }" class="our-hospitality-section jarallax">
      <div class="container-fluid">
        <div class="container-large-screen">

          {!! html_entity_decode($facility[0]) !!}
          
         {{--  <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <div class="section-title-area text-center">
                  <h2 class="section-title"><div class="text-white">Our Facilities</div></h2>
                  <p class="section-title-dec">A wide range of facilities and amenities for your living convenience</p>
                </div>
            </div>
          </div> --}}

          <div class="row">
            <div class="col-md-12">
              <div class="aravira-hospitality owl-carousel">

                @if($facilities) @foreach($facilities as $facility)
                <div class="item">
                  <div class="single-hospitality box-radius">
                    <div class="icon">
                      <img src="{{ asset($facility->icon) }}" alt="Swimmimg Pool">
                    </div>
                    <h3>{{ $facility->name }}</h3>
                  </div>
                </div>
                @endforeach @endif
                
                
              </div><!--/.end facilities-->
              <div class="hospitality-more btn btn-default"><span class="prev"><i class="fa fa-angle-left"></i></span>More<span class="next"><i class="fa fa-angle-right"></i></span></div>
            </div><!--/.col-md-12-->
          </div><!--/.row-->


        </div><!--/.container-large-screen-->
      </div><!--/.container-fluid-->
    </section><!--/.end facilities-section-->
