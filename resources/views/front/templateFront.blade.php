        <!DOCTYPE html>
<!--[if IE 8]>
<html class="ie8"><![endif]-->
<!--[if IE 9]>
<html class="ie9"><![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]--><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--================= Specific Meta ===================-->
    <meta name="description" content="">
    <meta name="keywords" content="Ipoh hotel">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--================= Page Title ======================-->
    <title>Low Cost Airport Transfers | J-Horizons  </title>
    <!--================= Favicons ========================-->
    <!--================= Favicons ========================-->
    <link rel="shortcut icon" href="{{ asset('/public/front/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('/public/front/images/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('/public/front/images/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('/public/front/images/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('/public/front/images/apple-icon-144x144.png') }}">

    <!--================= Custom Font =====================-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7cPlayfair+Display:400,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,300i,400,400i,500,500i,600,600i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" integrity="sha256-xykLhwtLN4WyS7cpam2yiUOwr709tvF3N/r7+gOMxJw=" crossorigin="anonymous" />

    <!--====== Custom CSS  =======-->
    <link href="{{ asset('/public/front/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/front/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/front/colors/color-schemer.css') }}" rel="stylesheet">

  <!--================= Font Awesome =======================-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!--================= Modernize =======================-->
    <script src="{{ asset('/public/front/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="{{ asset('/public/admin/js/jquery-1.9.1.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.5.4/src/loadingoverlay.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.5.4/extras/loadingoverlay_progress/loadingoverlay_progress.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>

  <script type="text/javascript" src="{{ asset('/public/front/fancybox/jquery.mousewheel-3.0.4.pack.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/public/front/fancybox/jquery.fancybox-1.3.4.pack.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('/public/front/fancybox/jquery.fancybox-1.3.4.css') }}" type="text/css" media="screen" />


  <!-- Google Tag Manager -->

  <!-- End Google Tag Manager -->

  @yield('styles')
</head>



<style>
  /* for loader which works on each page load */
  .no-js #loader { display: none;  }
  .js #loader { display: block; position: absolute; left: 100px; top: 0; }
  .se-pre-con {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('{{ asset('/public/loader/Preloader_4.gif') }}') center no-repeat #fff;
  }
</style>

<body>
@if($popup->status)
<a class="hidden" data-fancybox  id="onload" href="{{url($popup->image)}}"> </a>
@endif
<!--================= Header ==========================-->
{{--<div class="se-pre-con"></div>--}}
    <header id="masthead" class="site-header">
      <div class="header-top">
        <div class="container">
          <div class="row">
            <div class="col-md-8 hidden-xs">
              <div class="addresses">
                <div class="block-time">
                  <?php
                  $data = DB::table('pages')->where('page', 'header_setup')->first();
                  $data = unserialize($data->slider_text);
                  echo '<a href="'.$data['url'].'" style="color:white;float:left;decoration:none;"><i  class="'.$data['icon_1'].'">&ensp;<span style = "font-family: Poppins, sans-serif; font-size: 13px; font-weight: bold;">'.$data['icon_1_text'].'</span>&ensp;&ensp;&ensp;</i> </a> <i class="'.$data['icon_2'].'">&ensp;<span style = "font-family: Poppins, sans-serif; font-size: 13px; font-weight: bold;">'.$data['icon_2_text'].'</span>&ensp;&ensp;&ensp;</i>  <i class="'.$data['icon_3'].'">&ensp;<span style = "font-family: Poppins, sans-serif; font-size: 13px; font-weight: bold;">'.$data['icon_3_text'].'</span></i>';
                  ?>
                </div>
              </div><!--/.addresses-->
            </div><!--/.col-md-7-->
            <div class="col-md-4">
              <div class="social-links pull-right">
              @if(Session::get('userId')!='' and Session::get('userEmail')!='')
              <a href="{{ url('dashboard') }}">Dashboard</a> | Welcome, &nbsp;{{ Session::get('userFirstName') }} {{ Session::get('userLastName') }}! <a href="{{ url('/logout')}}">Logout</a>

                @else
              	<a href="{{ url('login') }}">Login</a> or <a href="{{ url('create_account') }}">Create an Account</a>

                @endif
         <a href="https://www.facebook.com/J-Horizons-Travel-M-Sdn-Bhd-373441562686739/" target="_blank"><i class="fa fa-facebook"></i></a></div><!--/.social-links-->

              <div class="mobile-search-area hidden-sm hidden-md hidden-lg">
                <!--i.fa.fa-search-->
                <div class="header-search">
                  <div class="search default">
                    <form action="#" method="get" class="searchform">
                      <div class="input-group">
                        <input type="search" name="s" placeholder="Search here..." class="form-controller"><span class="input-group-btn">
                          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button></span>
                      </div>
                    </form>
                  </div>
                </div>
              </div><!--/.search-area-->
            </div><!--/.col-md-5-->
          </div><!--/.row-->
        </div><!--/.container-->
      </div><!--/.header-top-->
      <!--Header Bottom-->
      <div class="header-bottom">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="menu-wrapper clearfix">
                <div class="navbar-header pull-left">
				<div class="logo-block"><a href="{{url('/')}}" class="site-logo"><img src="{{ asset('/public/front/images/index/logo.png') }}" alt="J-Horizons Travel" class="logo"></a><!--/.site-logo--></div>
                </div><!--/.navbar-header-->
                <div class="collapse navbar-collapse pull-right">
                  <div class="navigation hidden-sm hidden-xs">
                    <ul class="nav navbar-nav mainmenu">
                      <li><a href="{{ url('/') }}">Home</a></li>
                      <?php foreach ($categories_name as $key => $value) {
                          if(!$value['status']) continue;
                      ?>

                        <li><a href="<?php echo empty($value['code'])?'#':url($value['code']) ?>"><?php echo $value['title'] ?></a>

                          <?php   if(!empty($value['sub_categories'])){ ?>

                          <ul class="sub-menu">
                            <?php   foreach ($value['sub_categories'] as $keySub => $valueSub) {
                                if(!$valueSub['status']) continue;
                              ?>

                              <li><a href="{{ url($valueSub['code']) }}/{{$valueSub['category_id']}}"><?= $valueSub['title'] ?></a></li>

                            <?php } ?>

                          </ul>
                          <?php } ?>

                        </li>

                        <?php
                      }
                      ?>
                      <!-- <li> -->
                      <!-- <a href="#">Rooms</a>
                        <ul class="sub-menu">
                          <li><a href="{{ url('rooms-suites') }}">Rooms &amp; Suites</a></li>
                          <li><a href="{{ url('apartments') }}">Apartments</a></li>
                        </ul>
                      </li>
                      <li><a href="{{ url('promotions') }}">Promotions</a></li>
                      <li><a href="{{ url('dining') }}">Dining</a></li>
                      <li><a href="{{ url('facilities') }}">Facilities</a></li>
                      <li><a href="#">Events &amp; Meetings</a>
                      	 <ul class="sub-menu">
                          <li><a href="{{ url('weddings') }}">Weddings</a></li>
                          <li><a href="{{ url('events-meetings') }}">Events &amp; Meetings</a></li>
                        </ul>
                      </li>
                      <li><a href="#">About</a>
                      	<ul class="sub-menu">
                          <li><a href="{{ url('about-us') }}">About Ritz Garden Hotel</a></li>
                          <li><a href="{{ url('gallery') }}">Gallery</a></li>
                        </ul>
                      </li>
                      <li><a href="{{ url('contact-us') }}">Contact</a></li> -->
                    </ul><!--/.mainmenu-->
                  </div><!--/.navigation-->
                  <!--Mobile Main Menu-->
                  <div class="mobile-menu-main hidden-md hidden-lg">
                    <div class="menucontent overlaybg"> </div>
                    <div class="menuexpandermain slideRight"><a id="navtoggole-main" class="animated-arrow slideLeft menuclose"><span></span></a><span id="menu-marker"></span></div><!--/.menuexpandermain-->
                    <div id="mobile-main-nav" class="main-navigation slideLeft">
                      <div class="menu-wrapper">
                        <div id="main-mobile-container" class="menu-content clearfix"></div>
                      </div>
                    </div><!--/#mobile-main-nav-->
                  </div><!--/.mobile-menu-main-->
                </div><!--/.navbar-collapse-->
              </div><!--/.menu-wrapper-->
            </div><!--/.col-md-12-->
          </div><!--/.row-->
        </div><!--/.container-->
      </div><!--/.header-bottom-->
    </header><!--/.site-header-->
@yield('content')
<!--================= Site Footer ===================-->
<?php
	$footer_data = DB::table('pages')->where('page', 'footer_setup')->first();
	$footer_data = unserialize($footer_data->slider_text);

?>
    <!--/#footer-top-section-->
    <div id="footer-top-section" style="background-image:url('/public/front/images/footer-top-bg.jpg')" class="bg-image">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-title-area text-center">
              <h2 class="section-title">{!! $footer_data['title']['title'] !!}</h2>
              <p class="section-title-dec">{!! $footer_data['description']['description'] !!}</p>

            </div><!--/.section-title-area-->
          </div><!--/.col-md-12-->
        </div><!--/.row-->
        <div class="row">
          <div class="col-sm-6 col-md-3">
            <div class="widget-area footer-sidebar-top-1">
              <aside class="widget clearfix widget_address">
                <div class="widget-title-area">
                  <h4 class="widget-title">address</h4>
                </div><!--/.widget-title-area-->
                <div class="widget-content">
                  <p>{!! $footer_data['address']['address'] !!}</p>
                </div>
              </aside><!--/.widget_address-->
            </div><!--/.footer-sidebar-top-1-->
          </div><!--/.col-md-3-->
          <div class="col-sm-6 col-md-3">
            <div class="widget-area footer-sidebar-top-2">
              <aside class="widget clearfix widget_call_us">
                <div class="widget-title-area">
                  <h4 class="widget-title">call</h4>
                </div><!--/.widget-title-area-->
                <div class="widget-content">
                  <p>{!! $footer_data['contact_no']['contact_no'] !!}</p>
                  <p>{!! $footer_data['fax']['fax'] !!}</p>
                </div>
              </aside><!--/.widget_call_us-->
            </div><!--/.footer-sidebar-top-2-->
          </div><!--/.col-md-3-->
          <div class="col-sm-6 col-md-3">
            <div class="widget-area footer-sidebar-top-3">
              <aside class="widget clearfix widget_mail_us">
                <div class="widget-title-area">
                  <h4 class="widget-title">E-mail</h4>
                </div><!--/.widget-title-area-->
                <div class="widget-content">
                  <p><a href="mailto:{!! $footer_data['email_1']['email_1'] !!}" class="text-white">{!! $footer_data['email_1']['email_1'] !!}</a></p>
                  <p><a href="mailto:{!! $footer_data['email_2']['email_2'] !!}" class="text-white">{!! $footer_data['email_2']['email_2'] !!}</a></p>
                </div>
              </aside><!--/.widget_mail_us-->
            </div><!--/.footer-sidebar-top-3-->
          </div><!--/.col-md-3-->
          <div class="col-sm-6 col-md-3">
            <div class="widget-area footer-sidebar-top-4">
              <aside class="widget clearfix widget_social_media">
                <div class="widget-title-area">
                  <h4 class="widget-title">social Account</h4>
                </div><!--/.widget-title-area-->
                <div class="widget-social">

					@if($footer_data['icon'])
						@foreach($footer_data['icon'] as $key=>$icon)
            @if(isset($icon['active']) && $icon['active'] == 1 && $icon['icon'] != "" && $icon['link'] != "")
						<a href="{{ $icon['link'] }}">
							<i class="{{ $icon['icon'] }}"></i>
						</a>
            @endif
						@endforeach
					@endif
					<!--<a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-google-plus"></i></a><a href="#"><i class="fa fa-instagram"></i></a-->
				</div><!--/.widget-social-->
              </aside><!--/.widget_social_media-->
            </div><!--/.footer-sidebar-top-4-->
          </div><!--/.col-md-3-->
        </div><!--/.row-->
      </div><!--/.container-fluid-->
    </div><!--/#footer-top-section-->
    <footer id="colophon" class="site-footer">
      <!-- Footer Bottom Section-->
      <div id="footer-bottom-section">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-md-4">
              <div class="widget-area footer-sidebar-1">
                <aside class="widget clearfix widget_about-us">
                  <div class="widget-title-area">
                    <h4 class="widget-title">About Us</h4>
                  </div><!--/.widget-title-area-->
                  <div class="widget-content">
                    <p>{!! $footer_data['about']['about'] !!}</p><a href="{{ url('/about-us/12') }}" class="btn btn-default">more</a>                  </div>
                </aside><!--/.widget-about-us-->
              </div><!--/.footer-sidebar-1-->
            </div><!--/.col-md-4-->
            <div class="col-sm-6 col-md-4">
              <div class="widget-area footer-sidebar-2">
                <aside class="widget clearfix widget_instafeed">
                  <div class="widget-title-area">
                    <h4 class="widget-title">Location</h4>
                  </div><!--/.widget-title-area-->
                  <iframe id="map_load_dynamic1" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCuGRp7Cn9FrtJXeZ2Kp_WqqieB7P18K88&q={{ isset($footer_data['address']['address']) ? $footer_data['address']['address'] : '22A, Jalan Lang Jaya 1, Pusat Komersial Lang Jaya, 30010 Ipoh, Perak, Malaysia.'  }} " width="100%" height="215" frameborder="0" style="border:0;" allowfullscreen></iframe>
                  {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.9625199549178!2d101.08572531426415!3d4.600735996657664!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31caec842fe6ce25%3A0xa7c190fa8ebe8736!2sTower+Regency+Hotel+And+Apartments!5e0!3m2!1sen!2smy!4v1556464939794!5m2!1sen!2smy" width="100%" height="215" frameborder="0" style="border:0" allowfullscreen></iframe> --}}
                </aside><!--/.widget-categories-->
              </div><!--/.footer-sidebar-2-->
            </div><!--/.col-md-4-->
            <div class="col-sm-6 col-md-4">
              <div class="widget-area footer-sidebar-3">
                <aside class="widget clearfix widget_newsletter">
                  <div class="widget-title-area">
                    <h4 class="widget-title">newsletter Sign-up</h4>
                  </div><!--/.widget-title-area-->
                  <div class="newsletter-area text-center">
                    <div class="alert alert-success alert-dismissable" id="subscribe-success" style="display: none;">
                      <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
                      <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                      <p></p>
                    </div>
                    <div class="alert alert-danger alert-dismissable" id="subscribe-error" style="display: none;">
                      <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
                      <i class="fa fa-exclamation-triangle"><strong>Oops!</strong></i>
                      <p></p>
                    </div>
                    <p>{!! $footer_data['newsletter']['newsletter'] !!}</p>
{{--                    <form action="#" method="post" name="form-newsletter" id="form-newsletter">--}}
{{--                      <input type="hidden" name="_token" value="{{ csrf_token() }}" />--}}
{{--                      <input type="hidden" name="status" value="1">--}}
{{--                      <input value="" placeholder="" aria-required="true" id="email_1" name="email" type="email" class="form-controller">--}}
{{--                      <button id="mc-embedded-subscribe" value="Subscribe" type="submit" class="mail-chip-button">Subscribe</button>--}}
                    <button data-toggle="modal" data-target="#subscribe-modal" class="btn btn-default">Subscribe</button>
                    {{--                    </form><!--/.form-newsletter-->--}}
                  </div><!--/.newsletter-area-->
                </aside><!--/.widget_newsletter-->
              </div><!--/.footer-sidebar-3-->
            </div><!--/.col-md-4-->
          </div><!--/.row-->
          <div class="row">

            <!--<div class="col-md-12">
              <div class="payment-method text-center">We accept <img src="{{ asset('/public/front/images/card/card-1.png') }}" alt="Visa">&nbsp;</div>-->
              <!--/.payment-method-->
            <!--</div>--><!--/.copyright-->
            <div class="col-md-12">
              <div class="copyright text-center">
               {!! $footer_data['copyright']['copyright'] !!}
              </div><!--/.copyright-->
            </div><!--/.copyright-->
          </div><!--/.row-->
        </div><!--/.container-->
      </div><!--/#footer-bottom-section-->
    </footer><!--/.site-footer-->
<div class="modal fade" id="subscribe-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="clear:none">Enter Email Address</h4>
      </div>
      <div class="modal-body">
        Enter an email address you want to subscribe
        <input type="email" placeholder="Email Address" class="form-control" id="email_1">
        <input type="hidden" name="status" id="status" value="1">
        <p class="text-danger" id="email-error" style="display: none; margin-bottom: 10px;"></p>
      </div>

      <div class="modal-footer" style="text-align: right;">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 12px; padding: 10px">Close</button>
        <button type="button" class="btn btn-default" style="font-size: 12px; padding: 10px;" id="btn-send-subscribe">Send</button>
      </div>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
    <!--********************* JS FILE DECLARATION *****************************  -->
    <script src="{{ asset('/public/front/js/vendor/jquery-1.12.4.min.js') }}"></script><!--Jquery-->
    <script src="{{ asset('/public/front/js/vendor/jQuery-Migrate.min.js') }}"></script><!--jQuery-Migrate-->
    <script src="{{ asset('/public/front/js/plugins.js') }}"></script><!--plugins js-->

    <script src="{{ asset('/public/front/js/aravira.js') }}"></script><!--aravira-app-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha256-3blsJd4Hli/7wCQ+bmgXfOdK7p/ZUMtPXY08jmxSSgk=" crossorigin="anonymous"></script>

    <script type="text/javascript">
      // Wait for window load
      $(window).load(function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
      });
      // jQuery('#form-newsletter').submit(function() {
      //       var form_data = new window.FormData(jQuery('#form-newsletter')[0]);
      //
      //             jQuery.ajax({
      //               url: '/newsletter/addSubscriber',
      //               type:'post',
      //               dataType:'json',
      //               data: form_data,
      //               enctype: 'multipart/form-data',
      //               processData: false,
      //               contentType: false,
      //               success: function(response) {
      //                 if(response['error'])
      //                 {
      //                   //alert(response['error']);
      //                   }
      //
      //                   if(response['success'])
      //                   {
      //                     alert('Newsletter is subscribed!');
      //                     jQuery('#email_1').val('');
      //                   }
      //                 }
      //               });
      //             return false;
      //   });


      jQuery(document).on('click', '#subscribe-modal #btn-send-subscribe', function(){
        btn = jQuery(this);

        if(jQuery("#subscribe-modal #email_1").val() == ""){
            jQuery("#subscribe-modal #email-error").css('display', 'block');
            jQuery("#subscribe-modal #email-error").html("Please enter an email address.");
        }
        else{
          jQuery("#email-modal #email-error").css('display', 'none');
          jQuery(this).attr('disabled', true);

          jQuery.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          jQuery.ajax({
            type: "POST",
            url: '/newsletter/addSubscriber',
            data: {status: jQuery("#subscribe-modal #status").val(), email: jQuery("#subscribe-modal #email_1").val()},
            dataType: 'JSON',


            success: function(response){
              jQuery('#subscribe-success').css('display', 'none');
              jQuery('#subscribe-error').css('display', 'none');

              if(response.success){
                jQuery('#subscribe-success').css('display', 'block');
                jQuery('#subscribe-success p').html(response.success);
              }
              else{
                jQuery('#subscribe-error').css('display', 'block');
                jQuery('#subscribe-error p').html(response.error);
              }
             },

            complete:function(){
              jQuery('#subscribe-modal').modal('toggle');
              // jQuery("#email-modal #email-address").val("");
              btn.removeAttr('disabled');
            }
          });
        }
      });


            jQuery(document).on("click","#ipay88_method", function(){
              jQuery("#ipay88div").show();
              jQuery("#paypaldiv").hide();
              jQuery("#eGHLdiv").hide();
              jQuery("#ccDiv").hide();
              jQuery("#bankDiv").hide();
           });
           jQuery(document).on("click","#PayPal_method", function(){
              jQuery("#paypaldiv").show();
              jQuery("#ipay88div").hide();
              jQuery("#ccDiv").hide();
              jQuery("#eGHLdiv").hide();
              jQuery("#bankDiv").hide();
           });
           jQuery(document).on("click","#eGHL_method", function(){
            jQuery("#eGHLdiv").show();
              jQuery("#ipay88div").hide();
              jQuery("#ccDiv").hide();
              jQuery("#paypaldiv").hide();
              jQuery("#bankDiv").hide();
           })
           jQuery(document).on("click","#cc_method", function(){
            jQuery("#eGHLdiv").hide();
              jQuery("#ipay88div").hide();
              jQuery("#ccDiv").show();
              jQuery("#paypaldiv").hide();
              jQuery("#bankDiv").hide();
           })
           jQuery(document).on("click","#bank_method", function(){
            jQuery("#eGHLdiv").hide();
              jQuery("#ipay88div").hide();
              jQuery("#ccDiv").hide();
              jQuery("#paypaldiv").hide();
              jQuery("#bankDiv").show();

           })

    </script>



    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-140396948-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-140396948-1');
    </script>



    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-54GQSVK"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    @yield('scripts')
  </body>

</html>


