<?php
  $banners = \App\Models\BannerLeft::getBannerImages(7);
  $footer_data = DB::table('pages')->where('page', 'footer_setup')->first();
	$footer_data = unserialize($footer_data->slider_text);
?>
<!--================= Page Wellcome Area ===================-->
@if($banners != NULL)
<div id="subcatCarousel" class="carousel slide subcat-slider" data-ride="carousel">

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    @foreach($banners as $key =>$banner)
    <div class="item @if($key == 0) active @endif" style="background-image:url('{{ asset('public/admin/images/banner/left/'.$banner->banner) }}')">

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
    <div class="room-single-area bg-grey">
      <div class="container">
      	        <div class="row" id="head">
          <div class="col-md-12 col-full-width">
            <div class="section-title-area text-center">
              <h2 class="section-title">Contact Us</h2>
              <p class="section-title-dec">The place, our services &amp; our team.</p>
                    <?php if (Session::get('contact_us') == '1') { ?>
                        <div class="alert alert-success">
                            <strong>Thank You for Contacting Us!</strong> We will contact you shortly! .
                        </div>

                    <?php } elseif (Session::get('contact_us') == '0') { ?>
                        <div class="alert alert-danger">
                            <strong>Please Try Again!</strong> Error while saving the form!.
                        </div>
                    <?php } ?>
            </div><!--/.section-title-area-->
          </div><!--/.col-md-8-->
        </div><!--/.row-->



        <div class="row">
        	<div class="col-md-6 col-sm-12 col-xs-12">

            <div class="room-comments-area">
               <div id="respond" class="comment-respond box-radius">
                <iframe id="map_load_dynamic1" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCuGRp7Cn9FrtJXeZ2Kp_WqqieB7P18K88&q={{ isset($footer_data['address']['address']) ? $footer_data['address']['address'] : '22A, Jalan Lang Jaya 1, Pusat Komersial Lang Jaya, 30010 Ipoh, Perak, Malaysia.'  }} " width="100%" height="355" frameborder="0" style="border:0;" allowfullscreen></iframe>
               	  {{--  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.9625199549178!2d101.08572531426415!3d4.600735996657664!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31caec842fe6ce25%3A0xa7c190fa8ebe8736!2sTower+Regency+Hotel+And+Apartments!5e0!3m2!1sen!2smy!4v1556464939794!5m2!1sen!2smy" width="100%" height="355" frameborder="0" style="border:0" allowfullscreen></iframe> --}}

               </div><!--/.comment-respond-->
            </div>

            <div class="contact-us-content">
              <div class="single-contact-info">
                <h2 class="title">J-Horizons Travel (M) Sdn. Bhd (9881-H/KPL/LN 0080)</h2>
                <div class="content">
                  <p>Lot L4-C, Level 4, The Weld, No. 76, Jalan Raya Chulan, 50200, Kuala Lumpur, Malaysia. </p>
                  <p>Hunting Line: (03) 2161-0922</p>
                  <p>Fax: (03) 2161-4719</p>
                  <p>Email: <a href="mailto:tour@j-horizons.com.my">tour@j-horizons.com.my</a></p>
                  <hr>
                </div>
              </div><!--/.single-contact-info-->

            </div><!--/.contact-us-content-->
          </div><!--/.col-md-6-->


            <div class="col-md-6 col-sm-12 col-xs-12">
            	<div class="room-comments-area">
                  <div id="respond" class="comment-respond box-radius">
                    <div class="row">
                      <div class="col-md-12">
                        <h4 class="comment-reply-title">General Details</h4><!--/.comment-reply-title-->
                      </div><!--/.col-md-12-->
                    </div><!--/.row-->
                         <form action="{{url('/contact-us/create')}}" method="post" id="comment_form" name="commentForm" action="">
                            <div class="row">
                                <div class="col-md-12">

                                    <input type="hidden" name="_token" id="_token"  value="{{ csrf_token() }}" />

                          <div class="row">
                            <div class="col-md-6 col-sm-6 padding-right">
                              <p>
                                <input type="text" name="first_name" id="first_name" aria-required="true" placeholder="First Name *" class="form-controllar">
                              </p>
                            </div><!--/.col-md-6-->
                            <div class="col-md-6 col-sm-6 padding-right">
                              <p>
                                <input type="text" name="last_name" id="last_name" aria-required="true" placeholder="Last Name *" class="form-controllar">
                              </p>
                            </div><!--/.col-md-6-->
                            <div class="col-md-6 col-sm-6 padding-right">
                              <p>
                                <input type="text" name="company_name" id="company_name" aria-required="true" placeholder="Company Name" class="form-controllar">
                              </p>
                            </div><!--/.col-md-6-->

                            <div class="col-md-6 col-sm-6 padding-right">
                              <p>
                                <input type="text" name="occupation" id="occupation" aria-required="true" placeholder="Occupation" class="form-controllar">
                              </p>
                            </div><!--/.col-md-6-->
                            <div class="col-md-6 col-sm-6 padding-right">
                              <p>
                                <input type="text" name="tel" id="tel" aria-required="true" placeholder="Telephone *" class="form-controllar">
                              </p>
                            </div><!--/.col-md-6-->
                            <div class="col-md-6 col-sm-6 padding-right">
                              <p>
                                <input type="text" name="fax" id="fax" aria-required="true" placeholder="Fax" class="form-controllar">
                              </p>
                            </div><!--/.col-md-6-->
                            <div class="clearfix"></div>
                            <div class="col-md-6 col-sm-6 padding-right">
                              <p>
                                <input type="text" name="email" id="email" aria-required="true" placeholder="Email *" class="form-controllar">
                              </p>
                            </div><!--/.col-md-6-->


                          </div><!--/.row-->

                      </div><!--/.col-md-12-->
                    </div><!--/.row-->

                    <div class="clearfix margin-top"></div>

                    <div class="row">
                      <div class="col-md-12">
                        <h4 class="comment-reply-title">Address</h4><!--/.comment-reply-title-->
                      </div><!--/.col-md-12-->
                    </div><!--/.row-->
                    <div class="row">
                      <div class="col-md-12">

                          <div class="row">
                            <div class="col-md-12">
                              <p>
                                <textarea name="Address" id="message" aria-required="true" rows="3" cols="45" placeholder="Address *" class="form-controllar"></textarea>
                              </p>
                            </div><!--/.col-md-12-->

                            <div class="col-md-6 col-sm-6 padding-right">
                              <p>
                                <input type="text" name="city" id="city" aria-required="true" placeholder="City *" class="form-controllar">
                              </p>
                            </div><!--/.col-md-6-->

                            <div class="col-md-6 col-sm-6 padding-right">
                              <p>
                                <input type="text" name="postcode" id="postcode" aria-required="true" placeholder="Post Code *" class="form-controllar">
                              </p>
                            </div><!--/.col-md-6-->
                            <div class="col-md-6 col-sm-6 padding-right">
                              <p>
                               <div class="input box-radius">
                                     <select id="billing_state" name="billing_state" class="selectbox">
                                         <option value="1971">Johor</option>
                                         <option value="1972">Kedah</option>
                                         <option value="1973">Kelantan</option>
                                         <option value="1974">Labuan</option>
                                         <option value="1975">Melaka</option>
                                         <option value="1976">Negeri Sembilan</option>
                                         <option value="1977">Pahang</option>
                                         <option value="1978">Perak</option>
                                         <option value="1979">Perlis</option>
                                         <option value="1980">Pulau Pinang</option>
                                         <option value="4035">Putrajaya</option>
                                         <option value="1981">Sabah</option>
                                         <option value="1982">Sarawak</option>
                                         <option value="1983">Selangor</option>
                                         <option value="1984">Terengganu</option>
 					 <option value="1985">Wilayah Persekutuan</option>
                                     </select>

                                  </div>
                              </p>
                            </div><!--/.col-md-6-->
                            <div class="col-md-6 col-sm-6 padding-right">
                              <p>
                              <div class="input box-radius">
                                     <select id="billing_country" name="billing_country" class="selectbox">
                                        <option value="">Country</option>
                                          @foreach($countries as $country)
                                              <option <?php if($country->country_id==129){ echo "selected=selected";} ?> value="{{ $country->country_id }}">{{ $country->name }}</option>
                                          @endforeach
                                    </select>
                                  </div>
                              </p>
                            </div><!--/.col-md-6-->

                          </div><!--/.row-->

                          <div class="clearfix margin-top"></div>

                          <div class="row">
                              <div class="col-md-12">
                                <h4 class="comment-reply-title">Comments</h4><!--/.comment-reply-title-->
                              </div><!--/.col-md-12-->
                            </div><!--/.row-->

                            <div class="row">
                              <div class="col-md-12">
                              <p>
                                <input type="text" name="subject" id="subject" aria-required="true" placeholder="Subject *" class="form-controllar">
                              </p>
                            </div><!--/.col-md-12-->
                              <div class="col-md-12">
                              <p>
                                <textarea name="comment_enquiry" id="message" aria-required="true" rows="3" cols="45" placeholder="Comment/Enquiry *" class="form-controllar"></textarea>
                              </p>

                              <p>Please enter the security code shown below: </p>
                              <p><div class="g-recaptcha" data-sitekey="6LcUU6cUAAAAABGcof-UH_eAhxJlo-6QLt5cbWMH"></div></p>
                            </div><!--/.col-md-12-->
                            </div><!--/.row-->


                            <div class="text-center">
                                <p><button class="btn btn-default" type="submit">Submit</button></p>
                            </div>

                        </form><!--/#comment_form-->
                      </div><!--/.col-md-12-->
                    </div><!--/.row-->

                  </div><!--/.comment-respond-->
                </div>

            </div><!--/.col-md-6-->

        </div><!--/.row-->
        <div class="clearfix margin-top"></div>

      </div><!--/.container-->
    </div><!--/.room-grid-area-->


<script>
$(function (){
  $('select[name="billing_country"]').change(function(){
    var country_id = $(this).val();
    if(country_id != ''){
      $.ajax({
        url: "{{ url('users/getStates') }}",
        type: 'POST',
        data: {country_id:country_id, _token: $('#_token').val()},
        dataType: 'json',
        async: false,
        cache: false,
        beforeSend:function (){
          $('select[name="billing_state"]').html('<option value="">Loading...</option>');
        },
        complete: function(){

        },
        success: function (response) {

          var html = '';
          //html += '<option value="">States</option>';
          if(response['states']){
            for(var i = 0; i < response['states'].length; i++){
              html += '<option value="' + response['states'][i]['zone_id'] + '">' + response['states'][i]['name'] + '</option>';
            }
          }

          $('select[name="billing_state"]').html(html);
        }
      });
    }
    else{
      $('select[name="billing_state"]').html('<option value="">State</option>');
    }
  });
});
</script>
