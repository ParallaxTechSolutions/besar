<style>
    .pignose-calendar-body .pignose-calendar-wrapper .pignose-calendar {
        padding: 15px 0 0 0;
    }

    .pignose-calendar-body .pignose-calendar.pignose-calendar-light:after {
        content: "Please choose your check-in date";
        display: block;
        position: absolute;
        top: 12px;
        margin: auto;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 18px;
    }

    .pignose-calendar-body .pignose-calendar-wrapper + .pignose-calendar-wrapper .pignose-calendar.pignose-calendar-light:after {
        content: "Please choose your check-out date";
        display: block;
        position: absolute;
        top: 12px;
        margin: auto;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 18px;
    }

    .available-booking {
        width: auto !important;
    }

    @keyframes cssAnimation {
        to {
            width: 0;
            height: 0;
            overflow: hidden;
            opacity: 0;
        }
    }

    @-webkit-keyframes cssAnimation {
        to {
            width: 0;
            height: 0;
            visibility: hidden;
        }

    }
	
	.float{
		position: fixed;
		width:50px;
		height:150px;
		bottom:40px;
		top: 300px;
		right:0px;
		background-color:#cc0000;
		color:#FFF;
		/*border-radius:10px;*/
		text-align:center;
		box-shadow: 2px 2px 3px #999;
		z-index:1;
	}
	
	.my-float{
		margin-top:22px;
	}
	
	.vertical-text {
	 writing-mode: vertical-rl;
	 padding: 13px;
	 font-size: 16px;
	 font-weight: 600;
	}
</style>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('body').addClass('pignose-calendar-body');
    });
</script>


<section class="online-book-section style-two">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 pd-left clearfix">
            <div class="section-title-area">
              <div class="title-box tb">
                <div class="title-box-text tb-cell">
                  <h2 class="section-title">Rates &amp; <br/> Availability</h2>
                </div>
                <div class="tb-cell box-inner">
                  <div class="title-box-inner">
                    <h3 class="section-name">Search<span>Room</span></h3><i class="fa fa-angle-right"></i>                  </div>
                </div>
              </div>
              <!--/.site-header-->
            </div><!--/.section-title-area-->
          </div><!--/.col-md-12-->

            <div class="col-sm-4" style="position: fixed;
    bottom: 0;
    z-index: 2;
    width: 370px;
    left: 0;">
                <?php $animate = 1; ?>
                @foreach($booking as $index=>$book)
                    @if(isset($book->status) && $book->status)

                        <div class="alert alert-warning alert-dismissible hidden col-sm-4 available-booking" style="
                                -moz-animation: cssAnimation {{($animate-1)*2}}s ease-in {{$animate*2}}s forwards;
                                -webkit-animation: cssAnimation {{($animate-1)*2}}s ease-in {{$animate*2}}s forwards;
                                -o-animation: cssAnimation {{($animate-1)*2}}s ease-in {{$animate*2}}s forwards;
                                animation: cssAnimation {{($animate-1)*2}}s ease-in {{$animate*2}}s forwards;
                                -webkit-animation-fill-mode: forwards;
                                animation-fill-mode: forwards;">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><span class="fa fa-calendar-check-o"></span></strong> {{$book->description}}
                        </div>
                        <?php $animate += 1; ?>
                    @endif
                @endforeach
            </div>
            <div class="col-md-9 form-content">
                <form action="{{ url('check-availability')}}" method="get" id="online-book-form" style="padding-left: 15px;padding-top: 15px;">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 padding-left">
                            <label class="text-uppercase">Check-in Date</label>
                            <div class="input box-radius"><i class="fa fa-calendar"></i>
                                <input type="text" name="arrival" id="date-arrival" placeholder="Check-in Date"
                                       class=" form-controller">
                            </div><!--/.input-->
                        </div><!--/.col-md-3-->
                        <div class="col-md-3 col-lg-3 padding-left">
                            <label class="text-uppercase">Check-out Date</label>
                            <div class="input box-radius"><i class="fa fa-calendar"></i>
                                <input type="text" name="departure" id="date-departure" placeholder="Check-out Date"
                                       class=" form-controller">
                            </div><!--/.input-->
                        </div><!--/.col-md-3-->
                        <div class="col-md-2 col-lg-1 padding-left">
                            <label class="text-uppercase">room</label>
                            <div class="input box-radius"><i class="fa fa-caret-down"></i>
                                <select name="room">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div><!--/.input-->
                        </div><!--/.col-md-2-->
                        <div class="col-md-2 col-lg-1 padding-left">
                            <label class="text-uppercase">Adult</label>
                            <div class="input box-radius"><i class="fa fa-caret-down"></i>
                                <select name="adult">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div><!--/.input-->
                        </div><!--/.col-md-2-->
                        <div class="col-md-2 col-lg-2 padding-left">
                            <label class="text-uppercase">children</label>
                            <div class="input box-radius"><i class="fa fa-caret-down"></i>
                                <select name="childrens">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div><!--/.input-->
                        </div><!--/.col-md-2-->
                        <div class="col-md-3 padding-left button-booking">
                            <a class="btn btn-default" id="online-book-form-btn">Check Availability</a><!--/.btn-->
                    	</div><!--/.col-md-3-->
                    </div><!--/.row-->
                    
                </form><!--/.online-book-form-->
            </div><!--/.col-md-9-->
        </div><!--/.row-->
    </div><!--/.container-->
</section><!--/.online-book-section-->

<div class="modal fade" id="modal-validation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onClick="$('.form-horizontal').trigger('reset');" class="close"
                        data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Validation</h4>
            </div><!-- End .modal-header -->
            <div class="modal-body clearfix">
                <p>Please insert the Check-in Date and Check-out Date.</p>
                <div class="xs-margin"></div>
                <div class="pull-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                            onClick="$('.form-horizontal').trigger('reset');">CLOSE
                    </button>
                </div>



            </div><!-- End .modal-body -->
        </div><!-- End .modal-content -->
	</div><!-- End .modal-dialog -->
</div><!-- End .modal forgot password -->
<script type="text/javascript">
    window.onload = function () {
        jQuery('#date-arrival').pignoseCalendar({
            buttons: true,
            minDate: new Date(),
            select: function (date, context) {
            },
            apply: function (date, context) {
                console.log(date);
                var dd = moment(date);
                dd.set('date', dd.get('date') + 1);
                console.log("date ==", dd.format('YYYY-MM-DD'));
                if (jQuery('#date-departure').val() != '' && new Date(jQuery('#date-arrival').val()) >= new Date(jQuery('#date-departure').val())) {
                    jQuery('#date-departure').val(dd.format('YYYY-MM-DD'));
                }
                jQuery('#date-departure').pignoseCalendar('set', dd.format('YYYY-MM-DD'));
                jQuery('#date-departure').trigger("click");
            }
        });
        jQuery('#date-departure').pignoseCalendar({
            buttons: true,
            minDate: new Date(),
            select: function (dates, context) {
            },
            apply: function (date, context) {
                if (new Date(jQuery('#date-arrival').val()) >= new Date(date)) {
                    jQuery('#date-departure').val('');
                    alert('Please select departure date bigger than arrival date.');
                }
            }
        });

        function check() {
            return false;
        }

        jQuery('#online-book-form-btn').click(function(){
            if (jQuery('#date-arrival').val() == '' || jQuery('#date-departure').val() == '') {
                jQuery('#modal-validation').modal('show')
            } else {
                // return true;
                jQuery('#online-book-form').submit();
            }
        })

        jQuery('.btn-check').click(function () {
            if (jQuery('#date-arrival').val() == '' || jQuery('#date-departure').val() == '') {
                jQuery('#modal-validation').modal('show')
            } else {
                // return true;
                jQuery('.online-book-form').submit();
            }
        })
    }
</script>

<a href="#" data-toggle="modal" data-target="#modal-check-ota" class="float vertical-text"><span>Lowest Rate</span></a>
    
    <!-- Modal check ota start -->
    <div class="modal fade" id="modal-check-ota" tabindex="-1" role="dialog" aria-labelledby="login-modal" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4 class="modal-title text-center">Lowest Rate Available</h4>
                                                        </div><!-- End .modal-header -->
                                                        <div class="modal-body clearfix">
            												<span>Please enter your dates. Compare and book direct.</span>
                                                            <form action="#" method="post" id="comment_form" name="commentForm" class="online-book-form">
       
                                                            <div class="col-md-6 col-lg-6 padding-left">
                                                              <label class="text-uppercase">Check-in Date</label>
                                                              <div class="input box-radius"><i class="fa fa-calendar"></i>
                                                                <input type="text" id="date-arrival" placeholder="Check-in Date" class="calendar form-controller" value="18th Jul, 2017">
                                                              </div><!--/.input-->
                                                            </div><!--/.col-md-6-->
                                                            <div class="col-md-6 col-lg-6 padding-left">
                                                              <label class="text-uppercase">Check-out Date</label>
                                                              <div class="input box-radius"><i class="fa fa-calendar"></i>
                                                                <input type="text" id="date-departure" placeholder="Check-out Date" class="calendar form-controller" value="19th Jul, 2017">
                                                              </div><!--/.input-->
                                                            </div><!--/.col-md-6-->
                                                             <div class="clearfix margin-top"></div>
                      
                                                           	 <h5 class="modal-title margin-top col-md-3">Book with Us</h5>
                                                             
                                                       		 <div class="col-md-6 margin-top">
                                                             	<b>RM 160.00</b>&nbsp;
                                                             	<a href="checkout.html" class="btn btn-danger btn-sm">BOOK NOW <i class="fa fa-chevron-right"></i></a> 
                                                             </div>
                                                             <div class="clearfix"></div>
                                                             <table class="table compare-item-table margin-top" style="font-size: 14px;">
                                                             	<tbody>
                                                                    <tr bgcolor="#f1f1f1">
                                                                        <td class="item-name-col">Agoda</td>
                                                                         <td>RM 195.00</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="item-name-col">Booking.com</td>
                                                                         <td>RM 210.00</td>
                                                                    </tr>
                                                                </tbody>
                                                             </table>
                                                             
                                                                
            											</form>
                                                        </div><!-- End .modal-body -->
                                                        
                                                    </div><!-- End .modal-content -->
                                                </div><!-- End .modal-dialog -->

                                            </div><!-- End .modal check ota -->
