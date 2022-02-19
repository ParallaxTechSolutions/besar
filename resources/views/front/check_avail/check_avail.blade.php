<?php

$reverseCheck=(isset($product_details->reverse_tax_calculation))?$product_details->reverse_tax_calculation:'';
$TaxRate=DB::table('gst_rates')->where('status','1')->get();

$rt=$TaxRate[0]->rate;

?>

<?php
use App\Http\Models\Admin\Orders;
$orderModel = new Orders();
$newOrders = $orderModel->getTotalOrderByStatus('New Order');

use Illuminate\Support\Facades\Route;
$current_route = Route::getCurrentRoute()->getActionName();

use App\Loader;
$loader = new Loader();
$loaderText= Loader::get();
?>
@extends('front/templateFront')
@section('content')
    <link rel="stylesheet" href="https://besarhati8.webqom.com/public/src/dist/css/timepicker.min.css">

    <div class="loader-cover"></div>
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

        .pignose-calendar-body .pignose-calendar-wrapper+.pignose-calendar-wrapper .pignose-calendar.pignose-calendar-light:after {
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

        .float {
            position: fixed;
            width: 50px;
            height: 150px;
            bottom: 40px;
            top: 300px;
            right: 0px;
            background-color: #cc0000;
            color: #FFF;
            /*border-radius:10px;*/
            text-align: center;
            box-shadow: 2px 2px 3px #999;
            z-index: 1;
        }

        .my-float {
            margin-top: 22px;
        }

        .vertical-text {
            writing-mode: vertical-rl;
            padding: 13px;
            font-size: 16px;
            font-weight: 600;
        }

        /* for loader which works on each page load */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .displayLoader{
            display: block !important;
        }
        .hideLoader{
            display: none !important;
        }
        #se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('{{ asset('/public/loader/Preloader_4.gif') }}') center no-repeat #fff;
        }
        #se-pre-con h1 {
            /* width: 100px; */
            height: 100px;
            text-align: center;
            position: absolute;
            top: 0px;
            bottom: 30px;
            left: 0;
            right: 0;
            margin: auto;
        }
        #se-pre-con h1 {
            /* width: 100px; */
            height: 100px;
            text-align: center;
            position: absolute;
            top: 0px;
            bottom: 30px;
            left: 0;
            right: 0;
            margin: auto;
        }
    </style>

    <!--================= Content Area ===================-->
    <div id="se-pre-con">
        <h1>{{$loaderText[0]->name}}</h1>
    </div>

    @include('front/check_avail/onlinebook_CheckAvail')

    <!--/.online-book-section-->

    <div class="room-single-area" id="reservations">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-full-width">
                    <div class="section-title-area text-center">
                        <h2 class="section-title">Online Booking</h2>
                        <p class="section-title-dec">Our vehicle has been designed carefully for you to enjoy safe and comfortable travels.</p>
                    </div>
                    <!--/.section-title-area-->
                </div>
                <!--/.col-md-8-->
            </div>
            <!--/.row-->

            <div class="row" id="no-result">
                <div class="col-md-12 room-single-content">
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle"></i> &nbsp; No result found.
                    </div><!-- End .alert-danger -->
                </div>

                <form action="{{url('/check-availability/signup')}}" method="post" id="checkAvailSignupForm"
                      name="checkAvailSignupForm" action="">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="notify_product_id" id="notify_product_id"
                           value="<?php echo empty($pid) ? '' : $pid ?>" />
                    <input type="hidden" name="notify_checkin_date" id="notify_checkin_date"
                           value="<?php echo empty($arrival) ? '' : $arrival ?>" />
                    <input type="hidden" name="notify_checkout_date" id="notify_checkout_date"
                           value="<?php echo empty($departure) ? '' : $departure ?>" />
                    <input type="hidden" name="notify_room" id="notify_room"
                           value="<?php echo empty($room) ? '' : $room ?>" />
                    <input type="hidden" name="notify_adult" id="notify_adult"
                           value="<?php echo empty($adult) ? '' : $adult ?>" />
                    <input type="hidden" name="notify_children" id="notify_children"
                           value="<?php echo empty($children) ? '' : $children ?>" />
                    <div class="col-md-4">
                        <h4>Please sign up for the notification:</h4>
                        <div class="form-group">
                            <input type="text" name="email" id="email" aria-required="true" placeholder="Email *"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-default" type="submit">Submit</button>
                        </p>
                    </div>
                </form>
            </div>

            <div class="row result-container" style="display: block;">
                <div class="col-md-12 room-single-content">
                    <div class="single-room list mobile-extend" style="margin-bottom: 20px; ">
                        <div class="table-responsive margin-top package" style="display: block;">
                            <table class="table">
                                <tr>
                                    <td style="width:50%">
                                        <ul style="text-align: left;">
                                            <li>Pick Up: <span class="text-black info-property"><b>{{@($product_details[0]->property_id)}}</b></span></li>
                                            <li>Drop Off: <span class="text-black info-checkin"><b>{{@($product_details[0]->drop_list_id)}}</b></span></li>
                                            <li>Date: <span class="text-black info-checkout"><b>{{@($departure)}}</b></span></li>
                                            <li>Time: <span class="text-black info-rooms"><b>{{@($product_details[0]->created)}}</b></span></li>
                                            <li>Adults: <span class="text-black info-adults"><b>{{@($adult)}}</b></span></li>
                                            <li>Children: <span class="text-black info-children"><b>{{@($childrens)}}</b></span></li>
                                        </ul>
                                    </td>
                                    <td style="width:50%">
                                        <ul style="text-align: left;">
                                            <li>Package Name: <span class="text-black info-package-name"><b>1</b></span></li>
                                            <li>Package Code: <span class="text-black info-package-code"><b>1</b></span></li>
                                            <li>Value Added Services: <span class="text-black info-package-value"><b>1</b></span></li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <ul class="non-package" style="text-align: left;">
                            <li>Pick Up: <span class="text-black info-property"><b>{{@($product_details[0]->property_id)}}</b></span></li>
                            <li>Drop Off: <span class="text-black info-checkin"><b>{{@($product_details[0]->drop_list_id)}}</b></span></li>
                            <li>Date: <span class="text-black info-checkout"><b>{{@($departure)}}</b></span></li>
                            <li>Time: <span class="text-black info-rooms"><b>{{@($product_details[0]->created)}}</b></span></li>
                            <li>Adults: <span class="text-black info-adults"><b>{{@($adult)}}</b></span></li>
                            <li>Children: <span class="text-black info-children"><b>{{@($childrens)}}</b></span></li>
                        </ul>

                        <div class="table-responsive margin-top">


                            <table class="table cart-table">
                                <thead>
                                <tr>
                                    <th class="table-title">Types</th>
                                    <th class="table-title">Vehicle Code</th>
                                    <th class="table-title">Price / night (nett)</th>
                                    <!-- <th class="table-title">Quantity</th> -->
                                    <th class="table-title">SubTotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="item-name-col">

                                        <figure>
                                            <a href="#room-details"><img src=""
                                                                         alt="Deluxe Room" class="img-responsive"></a>
                                        </figure>
                                        <header class="item-name">
                                            <a href="#room-details">Deluxe Room </a>
                                        </header>
                                        <ul>
                                            <li><i class="fa fa-bed"></i> <b>BED:</b> 1 King or 2 Singles</li>
                                            <li><i class="fa fa-user"></i> <b>GUEST:</b> Max. 2 guests</li>
                                            <li><i class="fa fa-cutlery"></i> <b>MEAL:</b> 2 breakfasts</li>
                                        </ul>
                                    </td>
                                    <td class="item-price-col">DR-XXXXX01</td>
                                    <td class="item-price-col"><span class="item-price-special">RM 145.<span
                                                    class="sub-prices">00</span></span></td>
                                    <td>
                                        <div class="custom-quantity-input">
                                            <input type="text" name="quantity" value="1"> <a href="#" onClick="return!1"
                                                                                             class="quantity-btn quantity-input-up"><i
                                                        class="fa fa-angle-up"></i></a> <a href="#" onClick="return!1"
                                                                                           class="quantity-btn quantity-input-down"><i
                                                        class="fa fa-angle-down"></i></a></div>
                                    </td>
                                    <td class="item-total-col"><span class="item-price-special">RM 145.<span
                                                    class="sub-prices">00</span></span>
                                        <a href="#" class="close-button add-tooltip" data-toggle="tooltip"
                                           data-placement="top" title="Remove item"></a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="hidden-md hidden-lg text-center extend-btn"><span class="extend-icon"><i
                                    class="fa fa-angle-down"></i></span></div>
                </div>
                <!--/.col-md-12-->

            </div>
            <!--/.row-->

            <div class="row result-container" style="display: none;">
                <div class="col-md-12 review-comment-form box-radius" style="padding:15px;">
                    <h4>Special Requests</h4>
                    <p>Please write requests in English or the property's language</p>
                    <textarea class="form-control" name="special_requests" id="special_requests" rows="5"></textarea>
                    <div class="clearfix"></div><br />
                    <div class="alert alert-warning" role="alert">
                        <strong>Note:</strong> Don't disclose any additional personal or payment information in your
                        request.
                    </div>
                </div>
            </div>

            <div class="row result-container" style="display: none;">
                <div class="col-md-7 col-sm-12 col-xs-12">
                    <div class="tab-container left clearfix">
                        <ul class="nav-tabs">
                            <li class="active"><a href="#discount" data-toggle="tab">Promo Code</a></li>
                            <li><a href="#gift" data-toggle="tab">Gift Voucher</a></li>
                        </ul>
                        <div class="tab-content clearfix">

                            <div class="tab-pane active" id="discount">
                                <p>Please enter your discount Promo code here.</p>
                                <form action="#" class="review-comment-form box-radius"
                                      onsubmit="checkDiscount(this, event)">
                                    <input type="hidden" name="promocode_id" value="">
                                    <div class="single-input">
                                        <p class="coupon-error text-danger"></p>
                                        <div class="input box-radius">
                                            <input autocomplete="off" type="text" onchange="activeDiscount(this)"
                                                   class="form-control input-discount" name="discount"
                                                   onkeyup="activeDiscount(this)">

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <button type="submit" class="btn btn-submit btn-disc disabled">Apply Coupon</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="gift">
                                <p>Enter your discount gift voucher number here.</p>
                                <form action="#" class="review-comment-form box-radius">

                                    <div class="single-input">
                                        <div class="input box-radius">
                                            <input type="text" class="form-control">

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <button type="submit" class="btn btn-submit disabled">Apply Voucher</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12 col-xs-12">
                    <table class="table total-table">
                        <tbody>
                        <tr>
                            <td class="total-table-title">Subtotal:</td>
                            <td class="amount"><span id="ca-sub-total" class="alignright">RM 513</span></td>
                        </tr>
                        <tr class="row-reverse">
                            <td class="total-table-title" id="desc-reverse">Row reverse</td>
                            <td class="amount"><span id="ca-reverse" class="alignright">RM 0</span></td>
                        </tr>
                        <tr>
                            <td class="total-table-title text-danger">Discount:</td>
                            <td class="amount text-danger"><span id="ca-discount" class="alignright">RM 0</span></td>
                        </tr>
                        <tr class="sst-row">
                            <td class="total-table-title gst-title">Tax Rates</td>
                            <td class="amount"><span class="gst alignright">RM 0</span></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>Total:</td>
                            <td class="amount-total"><span id="ca-total" class="alignright">RM 493</span></td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="margin-top"></div>
                    <div class="pull-right">
                        <a onclick="prepareCart()" class="btn btn-default">Book Now</a>
                    </div>
                </div>
                <!--/.row-->
                <form style="display: none;" id="checkout" action="{{url('checkout')}}"></form>
                <div class="row">
                    <div class="col-md-12">

                        <div class="single-room list mobile-extend" style="margin-bottom: 0px; ">
                            <div class="room-info">

                                <div class="room-description margin-top clearfix">


                                </div>
                                <!--/.room-description-->

                            </div>
                            <!--/.room-info-->
                        </div>
                        <!--/.room-single-content-->
                    </div>
                    <!--/.col-md-12-->
                </div>
                <!--/.row-->

            </div>
            <!--/.container-->
        </div>
        <!--/.room-grid-area-->




    </div>

    <!--<a href="#" data-toggle="modal" data-target="#modal-check-ota" class="float vertical-text"><span>Lowest Rate</span></a>-->

    <!-- Modal check ota start -->
    <div class="modal fade" id="modal-check-ota" tabindex="-1" role="dialog" aria-labelledby="login-modal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title text-center">Lowest Rate Available</h4>
                </div><!-- End .modal-header -->
                <div class="modal-body clearfix">
                    <span>Please enter your dates. Compare and book direct.</span>
                    <form action="#" method="post" id="comment_form" name="commentForm" class="online-book-form">

                        <div class="col-md-6 col-lg-6 padding-left">
                            <label class="text-uppercase">Pick Up</label>
                            <div class="input box-radius"><i class="fa fa-calendar"></i>
                                <input type="text" id="date-arrival" placeholder="Check-in Date"
                                       class="calendar form-controller" value="18th Jul, 2017">
                            </div>
                            <!--/.input-->
                        </div>
                        <!--/.col-md-6-->
                        <div class="col-md-6 col-lg-6 padding-left">
                            <label class="text-uppercase">Drop Off</label>
                            <div class="input box-radius">
                                <input type="text" id="date-departure" placeholder="Check-out Date"
                                       class="calendar form-controller">
                            </div>
                            <!--/.input-->
                        </div>
                        <!--/.col-md-6-->
                        <div class="clearfix margin-top"></div>

                        <h5 class="modal-title margin-top col-md-3">Book with Us</h5>

                        <div class="col-md-6 margin-top">
                            <b>RM 160.00</b>&nbsp;
                            <a href="checkout.html" class="btn btn-danger btn-sm">BOOK NOW<i
                                        class="fa fa-chevron-right"></i></a>
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
    <div class="modal fade" id="modal-validation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onClick="$('.form-horizontal').trigger('reset');" class="close"
                            data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Validation</h4>
                </div><!-- End .modal-header -->
                <div class="modal-body clearfix">
                    <p class='modal-text'>Please insert the Check-in Date and Check-out Date.</p>
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
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://besarhati8.webqom.com/public/src/dist/js/timepicker.min.js"></script>

<script type="text/javascript">
       $(document).ready(function () {
        $('#timepicker').timepicker();

        // Handler for .ready() called.
        $('html, body').animate({
            scrollTop: $('#reservations').offset().top
        }, 'slow');

        jQuery('body').addClass('pignose-calendar-body');
        jQuery('.row-reverse').hide();
    });

    var rooms;
    var is_tax = 0;
    var gst_rate = 0;
    var gst_name ='';

    function activeDiscount(elm) {
        if (jQuery(elm).val().length >= 4) {
            jQuery('.btn-disc').removeClass('disabled').removeAttr('disabled');
        } else {
            jQuery('.btn-disc').addClass('disabled').attr('disabled', 'disabled');
        }
    }
    jQuery('#Ldate-arrival').pignoseCalendar({
        buttons: true,
        minDate: new Date(),
        select: function (date, context) {
        },
        apply: function (date, context) {
            console.log(date);
            var ddt = moment(date);
            ddt.set('date', ddt.get('date') + 1);
            checkDates();
            console.log("date ==", ddt.format('YYYY-MM-DD'));
            if (jQuery('#Ldate-departure').val() != '' && new Date(jQuery('#Ldate-arrival').val()) >= new Date(jQuery('#Ldate-departure').val())) {
                jQuery('#Ldate-departure').val(ddt.format('YYYY-MM-DD'));
            }
            jQuery('#Ldate-departure').pignoseCalendar('set', ddt.format('YYYY-MM-DD'));
            jQuery('#Ldate-departure').trigger("click");
        }
    });
    function checkDiscount(elm, event) {
        event = event || window.event;
        event.preventDefault();
        event.stopPropagation();
        var pids = [];
        jQuery('.single-room tbody tr').each(function (i, e) {
            pids.push(jQuery(e).data('id'));
        });
        // remove error
        $('.coupon-error').text('');
        jQuery.ajax({
            url: '/check-availability/check-discount',
            data: {
                'code': jQuery('input[name=discount]').val(),
                'pids': pids
            }
        }).done(function (response) {
            if (response != 0) {
                var res = JSON.parse(response);
                if (res.error) {
                    $('.coupon-error').text(res.error);
                    return;
                }
                $('input[name=promocode_id]').val(res.id);

                if (jQuery('#ca-discount').hasClass('promo')) {
                    if (res.promo_code != jQuery("#ca-discount").data('data-promo'))
                        ;
                    {
                        jQuery('.total-table-title.text-danger').html('DISCOUNT: (' + res.promo_code + ')');
                        var total = Number(jQuery('#ca-total').html().replace('RM ', '')).toFixed(2);
                        var subtotal = Number(jQuery('#ca-sub-total').html().replace('RM ', '')).toFixed(2);
                        var gst = Number(jQuery('.amount .gst').html().replace('RM ', '')).toFixed(2);


                        if (res.discount_type != 'P') {
                            jQuery('#ca-discount').html('- RM ' + res.discount + '');
                            jQuery('#ca-discount').addClass('promo');
                            jQuery('#ca-discount').data('data-promo', res.discount);
                            jQuery('#ca-total').html('RM ' + (Number(subtotal) - res.discount + Number(gst)).toFixed(2) + '');

                        } else {
                            jQuery('#ca-discount').html('- RM ' + (Number(subtotal) * (Number(res.discount) / 100)).toFixed(2) + '');
                            jQuery('#ca-discount').addClass('promo');
                            jQuery('#ca-discount').data('data-promo', res.discount);
                            jQuery('#ca-total').html('RM ' + (Number(subtotal) + Number(gst) - (Number(subtotal) * (Number(res.discount) / 100))).toFixed(2) + '');
                        }
                    }
                } else {


                    jQuery('.total-table-title.text-danger').html('DISCOUNT: (' + res.promo_code + ')');
                    var total = Number(jQuery('#ca-total').html().replace('RM ', '')).toFixed(2);
                    var subtotal = Number(jQuery('#ca-sub-total').html().replace('RM ', '')).toFixed(2);
                    var gst = Number(jQuery('.amount .gst').html().replace('RM ', '')).toFixed(2);


                    if (res.discount_type != 'P') {
                        jQuery('#ca-discount').html('- RM ' + res.discount + '');
                        jQuery('#ca-discount').addClass('promo');
                        jQuery('#ca-discount').data('data-promo', res.discount);
                        jQuery('#ca-total').html('RM ' + (Number(subtotal) - res.discount + Number(gst)).toFixed(2) + '');

                    } else {
                        jQuery('#ca-discount').html('- RM ' + (Number(subtotal) * (Number(res.discount) / 100)).toFixed(2) + '');
                        jQuery('#ca-discount').addClass('promo');
                        jQuery('#ca-discount').data('data-promo', res.discount);
                        jQuery('#ca-total').html('RM ' + (Number(subtotal) + Number(gst) - (Number(subtotal) * (Number(res.discount) / 100))).toFixed(2) + '');
                    }


                    jQuery('.sub-price').remove();
                }                //   jQuery('#ca-total').html('RM '+(Number(total)-(Number(total)*(Number(res.discount)/100))).toFixed(2)+'');
            }
        });
    }
</script>

<script type="text/javascript">
    function prepareCart() {
        var order = [];
        var tr = jQuery('.cart-table tbody tr');
        jQuery.each(tr, function (index, value) {
            var id = jQuery(value).attr('data-id');
            var qty = jQuery(value).find('.custom-quantity-input input').val();
            // var rooms = jQuery(value).attr('data-rooms');
            var product = {
                product_id: id,
                qty: qty,
            };
            order.push(product);
        });
        var data = {
            _token: '{{ csrf_token() }}',
            order: order,
            rooms: jQuery("#room-avail").val(),
            adults: jQuery("#adult-avail").val(),
            children: jQuery("#children-avail").val(),
            arrival: jQuery('#date-arrival').val(),
            departure: jQuery('#date-departure').val(),
            promocode_id: $('input[name=promocode_id]').val(),
            special_requests: $("#special_requests").val(),
            _type: ''
        };

        jQuery.ajax({
            url: "{{ url('make-cart') }}",
            type: 'POST',
            data: data,
            dataType: 'json',
            async: false,
            cache: false,
            success: function (response) {
                jQuery('#checkout').submit();
            }
        });
    }

    function calculate_sub_total() {
        var row = jQuery('.cart-table tbody tr');
        var sub_total = 0;
        var discount = 0;
        var total = 0;

        jQuery.each(row, function (index, value) {
            //var qnt = jQuery(value).find('.custom-quantity-input input').val();
            //var qnt = 1; // for that now it fetches subtotal from db
            var qnt = parseInt(jQuery("#room-avail").val());
            var price = parseFloat(jQuery(value).attr('data-price'));
            var off = parseFloat(jQuery(value).attr('data-off'));
            var temp_total = qnt * price;
            discount += qnt * off;
            sub_total += temp_total;
        });
        jQuery('.sst-row').show()

        if (is_tax == 1) {
            const tax = (sub_total / 100 * gst_rate);
            total = sub_total - discount + tax;
            // // jQuery('.amount .gst').html('RM ' + (sub_total / 100 * 6).toFixed(2));
            // // jQuery('.gst-title').html('SST (6%)');
            // total = sub_total - discount + (sub_total / 100 * gst_rate);
            jQuery('.amount .gst').html('RM ' + tax.toFixed(2));
            jQuery('.gst-title').html(gst_name+' (' + gst_rate + '%)');


        } else {
            total = sub_total - discount;
            jQuery('.sst-row').hide()
            jQuery('.amount .gst').html('RM 0.00');
            jQuery('.gst-title').html('Tax Rates (0%)');
        }
        console.log(is_tax, total);
        var reverseCalCheck = {!! intval($reverseCheck)!!};
        var taxRate = {!!$rt!!} ;
        if (reverseCalCheck == 1) {
            console.log(sub_total, taxRate);
            sub_total = sub_total / (1 + parseInt(taxRate) / 100);
            console.log(total, sub_total, taxRate);

            jQuery('.row-reverse').show();
            jQuery('#desc-reverse').html("<?php echo $TaxRate[0]->name.'('.$rt.'%)' ?>");
            taxnum = ((total + discount) - sub_total).toFixed(2).toString(); //If it's not already a String
            num = taxnum.slice(0, (taxnum.indexOf("."))+3);
            jQuery('#ca-reverse').text('RM '.concat(num));

        }
        jQuery('#ca-sub-total').html('RM ' + sub_total.toFixed(2));
        jQuery('#ca-total').html('RM ' + total.toFixed(2));
        jQuery('#ca-discount').html('RM ' + discount.toFixed(2));


    }

    window.onload = function () {
        jQuery('.amount.text-danger').removeClass('promo');
        calculate_sub_total();
        @if (!empty($arrival))
        checkAvail();
        @endif

        jQuery(document).on('click', '.close-button', function () {
            jQuery(this).closest('tr').remove();
            if (jQuery('.cart-table tbody tr').length == 0) {
                jQuery('.result-container').hide();
                jQuery('#no-result').show();
            }
            calculate_sub_total();
        });
        jQuery(document).on('click', '.quantity-input-down', function () {
            return; // to disable
            console.log('down');
            var tr = jQuery(this).closest('tr');
            var qnt = jQuery(this).closest('.custom-quantity-input').find('input').val();
            if (qnt <= 1)
                return;
            var newQnt = parseInt(qnt) - 1;
            tr.find('.max-qnt').hide();
            var price = tr.attr('data-price');
            var newDate = moment(jQuery('.info-checkout').html(), "YYYY-MM-DD");
            console.log(jQuery('.info-checkout').html());
            newDate = newDate.subtract(1, 'd');
            jQuery('.info-checkout b').html(moment(newDate).format("YYYY-MM-DD").toString());
            jQuery('#date-departure').val();
            console.log(price);
            var subPrice = price * newQnt;
            jQuery(this).closest('.custom-quantity-input').find('input').val(newQnt);
            //var reverseCalCheck = {!! intval($reverseCheck)!!};
            //console.log(reverseCalCheck);
            //var taxRate = {!!$rt!!} ;
            /* if (reverseCalCheck == 1) {
                subPrice = subPrice / (1 + parseInt(taxRate) / 100);
                tr.find('.item-price-special.s-b .mp').html('RM ' + subPrice.toFixed(2) + '');
            }else{ */
            tr.find('.item-price-special.s-b .mp').html('RM ' + subPrice.toFixed(2) + '');
            /* } */
            calculate_sub_total();

        });

        jQuery(document).on('click', '.quantity-input-up', function () {
            return; // to disable
            console.log('up');
            var tr = jQuery(this).closest('tr');
            var avail = parseInt(tr.attr('data-avail'));
            var qnt = jQuery(this).closest('.custom-quantity-input').find('input').val();
            var newQnt = parseInt(qnt) + 1;
            if (avail <= qnt) {
                tr.find('.max-qnt').show();
                return;
            }

            var newDate = moment(jQuery('.info-checkout').html(), "YYYY-MM-DD");
            console.log(jQuery('.info-checkout').html());
            newDate = newDate.add(1, 'd');
            jQuery('.info-checkout b').html(moment(newDate).format("YYYY-MM-DD").toString());
            jQuery('#date-departure').val(moment(newDate).format("YYYY-MM-DD").toString());
            var price = tr.attr('data-price');
            console.log(price);
            var subPrice = price * newQnt;
            jQuery(this).closest('.custom-quantity-input').find('input').val(newQnt);
            //tr.find('.item-price-special.s-b .mp').html('RM ' + subPrice.toFixed(2) + '');
            //var reverseCalCheck = {!! intval($reverseCheck)!!};
            //var taxRate = {!!$rt!!} ;
            /* if (reverseCalCheck == 1) {
                subPrice = subPrice / (1 + parseInt(taxRate) / 100);
                tr.find('.item-price-special.s-b .mp').html('RM ' + subPrice.toFixed(2) + '');
            }else{ */
            tr.find('.item-price-special.s-b .mp').html('RM ' + subPrice.toFixed(2) + '');
            /* } */
            calculate_sub_total();

        });
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
                    jQuery('.modal-text').text('Please select departure date bigger than arrival date.');
                    jQuery('#modal-validation').modal('show');
                    //alert('');
                }
            }
        });
        calculate_sub_total();
    };

    function checkAvail() {
        $('#se-pre-con').show();
        var pickUpLocation=jQuery("#pickUpLocation option:selected").text();
        var DropOffLocation = jQuery("#drop-list option:selected").text();
        var departure = jQuery('#date-departure').val();
        var timedepart = jQuery('#departTime').val();
        var adultsAvail = jQuery("#adult-avail").val();
        var childrenAvail = jQuery("#children-avail").val();
        var check =localStorage.getItem('change');

        localStorage.setItem('pickUpLocation',pickUpLocation);

        if (DropOffLocation == '' || pickUpLocation == '') {
            $('#se-pre-con').hide();
            jQuery('.modal-text').text('Please select Check In and Drop Off.');
            jQuery('#modal-validation').modal('show');
          }
        jQuery('#no-result').hide();

        var data = {
            _token: '{{ csrf_token() }}',
            checkin: pickUpLocation,
            checkout: DropOffLocation,
            dateDeparture: departure,
            timeDeparture: timedepart,
            adult: jQuery('#adult-avail').val(),
            childrens: jQuery('#children-avail').val(),
            product_id: '<?php echo empty($pid) ? '' : $pid ?>'
        };
        jQuery.ajax({
            url: "{{ url('check-availability') }}",
            type: 'POST',
            data: data,
            dataType: 'json',
            async: false,
            cache: false,
            success: function (response) {
                console.log(response.status );
                console.log(response.status);
                if (response.status) {
                    jQuery('.cart-table tbody').empty();

                    if (response.dates) {
                        var dateArray = response.dates.split(' ');
                        dateArray.pop();
                        var errorMessage = '';

                        if (dateArray.length == 1) {
                            jQuery('.modal-text').text("Date " + dateArray[0] + ' is not available. Please select different date(s).');
                            jQuery('#modal-validation').modal('show');
                            //alert()
                        } else if (dateArray.length > 1) {
                            var errorMessage = '';

                            for (var i = 0; i < dateArray.length; i++) {
                                if (i == 0) {
                                    errorMessage += "Dates " + dateArray[i];
                                } else if (dateArray.length == i + 1) {
                                    errorMessage += " and " + dateArray[i] + " are not available. Please select different date(s)."
                                } else {
                                    errorMessage += ", " + dateArray[i];
                                }
                            }
                            jQuery('.modal-text').text(errorMessage);
                            jQuery('#modal-validation').modal('show');
                        }
                    } else if (response.avail.length) {
                        rooms = response.avail;
                        console.log("response.avail = ", response.avail);
                        jQuery.each(response.avail, function (index, value) {
                            jQuery('.cart-table tbody').append(template(value));
                            is_tax = value.is_tax;
                            if (value.gst_rate != null) {
                                gst_rate = value.gst_rate;
                                gst_name = value.gst_name;
                            }

                        });
                        calculate_sub_total();
                        jQuery('.info-property b').html(localStorage.getItem('propertyName'));
                        jQuery('.info-checkin b').html(arrival);
                        jQuery('.info-checkout b').html(departure);
                        jQuery('.info-adults b').html(adultsAvail);
                        jQuery('.info-children b').html(childrenAvail);
                        jQuery('.info-rooms b').html(roomsAvail);

                        if(response.package != null && response.package.length > 0){
                            jQuery('.package').show();
                            jQuery('.non-package').hide();
                            jQuery('.info-package-name b').html(response.package[0].package_name);
                            jQuery('.info-package-code b').html(response.package[0].package_code);
                            jQuery('.info-package-value b').html(response.package[0].value_added_service);
                        }

                        var quantity = GetNightsFromDates() * roomsAvail;

                        jQuery('input[name="quantity"]').val(quantity);

                        jQuery('.result-container').show();
                        jQuery('#no-result').hide();
                    } else {
                        jQuery('.cart-table tbody').append('<tr><td colspan="5"> No Result </td></tr>');
                        jQuery('.result-container').hide();
                        jQuery('#no-result').show();
                    }
                    $('#se-pre-con').hide();
                    // $('#se-pre-con').removeClass('displayLoader');
                    // $('#se-pre-con').addClass('hideLoader');
                } else {
                    console.log('fail nothing to do ... ');
                    jQuery('.result-container').hide();
                    jQuery('#no-result').show();
                    // $('#se-pre-con').removeClass('displayLoader');
                    // $('#se-pre-con').addClass('hideLoader');
                    $('#se-pre-con').hide();
                }
                // $.LoadingOverlay("hide");
            }
        });
        calculate_sub_total();

        // Handler for .ready() called.
        $('html, body').animate({
            scrollTop: $('#reservations').offset().top
        }, 'slow');
    }

    function template(row) {
        var roomsAvail = jQuery("#room-avail").val();
        var reverseCalCheck = {!! intval($reverseCheck)!!};
        var subPrice=(parseFloat(parseFloat(row.sale_price) * parseInt( roomsAvail))).toFixed(2)
        var taxRate = {!!$rt!!} ;
        if (reverseCalCheck == 1) {
            subPrice = subPrice / (1 + parseInt(taxRate) / 100);
            subPrice=subPrice.toFixed(2);
        }

        html = '<tr data-rooms="' + roomsAvail + '" data-id="' + row.id + '" data-off="' + row.discount + '" data-price="' + row.sale_price + '" data-avail="' + row.quantity_in_stock + '">';
        html += '<td class="item-name-col">';
        html += '<figure>';
        html += '<a href="#room-details"><img src="public/admin/products/medium/' + row.thumbnail_image_1 + '" alt="Deluxe Room" class="img-responsive"></a>';
        if (row.promo_behaviour === 'sale') {
            jQuery.ajax({
                url: "{{ url('get_packages') }}/"+row.id,
                type: 'GET',
                dataType: 'json',
                async: false,
                cache: false,
                success: function (response) {
                    if(response.packages.length > 0){
                        html += '<span class="label" style="background-color: green;position: absolute !important;left: 17px!important;font-size: xx-small;margin-top: 40px;">'+response.packages[0].package_name+'</span>';
                    }
                }
            });
            html += '<img class="promo" src="public/promo/sale_label.png" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">';
        } else if (row.promo_behaviour === 'hot') {
            html += '<img class="promo" src="public/promo/hot_label.png" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">';
        } else if (row.promo_behaviour === 'new') {
            html += '<img class="promo" src="public/promo/new_label.png" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">';
        } else if (row.promo_behaviour === 'pwp') {
            html += '<img class="promo" src="public/promo/pwp_label.png" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">';
        } else if (row.promo_behaviour === 'last_minute') {
            html += '<img class="promo" src="public/promo/last_minute.png" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">';
        } else if (row.promo_behaviour === '24hoursale') {
            html += '<img class="promo" src="public/promo/24hour_sale.png" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">';
        } else if (row.promo_behaviour === 'popular') {
            html += '<img class="promo" src="public/promo/popular.png" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">';
        } else if (row.promo_behaviour === 'early_bird') {
            html += '<img class="promo" src="public/promo/early_bird.png" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">';
        }

        else if (row.promo_behaviour === 'black_friday') {
            html += '<img class="promo" src="public/promo/black_friday.png" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">';
        } else if (row.promo_behaviour === 'singles_day') {
            html += '<img class="promo" src="public/promo/singles_day.png" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">';
        } else if (row.promo_behaviour === 'merdeka') {
            html += '<img class="promo" src="public/promo/merdeka.png" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">';
        } else if (row.promo_behaviour === 'valentines') {
            html += '<img class="promo" src="public/promo/valentine.png" style="width: 35px !important;height: 35px !important;position: relative !important;top: -86px !important;left: 30px !important;">';
        }

        html += '</figure>';

        html += '<header class="item-name">';
        html += '<a href="{{url("rooms-suites/show")}}/' + row.id + '" target="_blank">' + row.type + '</a>';
        html += '</header>';
        html += '<ul>';
        jQuery.ajax({
            url: "{{ url('get_packages') }}/"+row.id,
            type: 'GET',
            dataType: 'json',
            async: false,
            cache: false,
            success: function (response) {
                if(response.packages.length > 0){
                    let mon_in = '', tue_in = '' , wed_in = '' , thu_in = '' , fri_in = '' , sat_in = '' , sun_in = '';
                    let mon_out =  '' , tue_out = '' , wed_out = '' , thu_out = '' , fri_out = '' , sat_out = '' , sun_out = '';
                    if(response.packages[0].checkin_mo == 1) {
                        mon_in = 'Monday';
                    }
                    if(response.packages[0].checkin_tu == 1) {
                        tue_in = 'Tuesday';
                    }
                    if(response.packages[0].checkin_we == 1) {
                        wed_in = 'Wednesday';
                    }
                    if(response.packages[0].checkin_th == 1) {
                        thu_in = 'Thursday';
                    }
                    if(response.packages[0].checkin_fr == 1) {
                        fri_in = 'Friday';
                    }
                    if(response.packages[0].checkin_sat == 1) {
                        sat_in = 'Saturday';
                    }
                    if(response.packages[0].checkin_su == 1) {
                        sun_in = 'Sunday';
                    }
                    if(response.packages[0].checkout_mo == 1) {
                        mon_out = 'Monday';
                    }
                    if(response.packages[0].checkout_tu == 1) {
                        tue_out = 'Tuesday';
                    }
                    if(response.packages[0].checkout_we == 1) {
                        wed_out = 'Wednesday';
                    }
                    if(response.packages[0].checkout_th == 1) {
                        thu_out = 'Thursday';
                    }
                    if(response.packages[0].checkout_fr == 1) {
                        fri_out = 'Friday';
                    }
                    if(response.packages[0].checkout_sat == 1) {
                        sat_out = 'Saturday';
                    }
                    if(response.packages[0].checkout_su == 1) {
                        sun_out = 'Sunday';
                    }
                    console.log(mon_in,tue_in,wed_in,thu_in,fri_in,sat_in,sun_in);
                    html += '<li><b>PACKAGE NAME:</b> ' + response.packages[0].package_name + ' </li>';
                    html += '<li><b>PACKAGE CODE:</b> ' + response.packages[0].package_code + '</li>';
                    html += '<li>' +
                        '<b>VALUE ADDED SERVICES:</b>' +
                        '<br> '
                        + response.packages[0].value_added_service +
                        '<br><b style="padding-left: 120px;font-size: 14px;">Minimum Stay:</b> ' +
                        '<span style="font-size: 14px;">'+ response.packages[0].minimum_stay+'</span>' +
                        '<br><b style="padding-left: 120px;font-size: 14px;">Check In:</b> '
                        + '<span style="font-size: 14px;">'
                        + mon_in +' '+ tue_in +' '+ wed_in +' '+ thu_in +' '+ fri_in +' '+ sat_in +' '+ sun_in +
                        '</span>' +
                        '<br><b style="padding-left: 120px;font-size: 14px;">Check Out:</b> '
                        + '<span style="font-size: 14px;">'
                        + mon_out +' '+ tue_out +' '+ wed_out +' '+ thu_out +' '+ fri_out +' '+ sat_out +' '+ sun_out +
                        '</span>' +
                        '</li>';
                } else {
                    html += '<li><i class="fa fa-bed"></i> <b>BED:</b> ' + row.bed + ' </li>';
                    html += '<li><i class="fa fa-user"></i> <b>GUEST:</b> ' + row.guest + '</li>';
                    html += '<li><i class="fa fa-cutlery"></i> <b>MEAL:</b> ' + row.meal + '</li>';
                }
            }
        });
        html += '</ul> ';
        html += '</td>';
        html += '<td class="item-price-col">' + row.room_code + '</td>';
        html += '<td>' + row.priceByDates + '</td>';
        html += '<td style="display: none; class="item-price-col"><span class="item-price-special">RM ' + row.sale_price.toFixed(2) + '<span class="sub-prices"></span></span></td>';
        html += '<td style="display: none;">';
        html += '<div class="custom-quantity-input">';
        html += '<input disabled type="text" name="quantity" value="' + GetNightsFromDates() + '"> <a class="quantity-btn quantity-input-up"><i class="fa fa-angle-up"></i></a> <a class="quantity-btn quantity-input-down"><i class="fa fa-angle-down"></i></a></div>';
        html += '<span class="max-qnt" style="color:red;display:none;">Max</span>';
        html += '</td>';
        html += '<td class="item-total-col"><span class="item-price-special s-b"><span class="mp">RM ' + subPrice + '</span><span class="sub-prices"></span></span>';
        html += '<a class="close-button add-tooltip" data-toggle="tooltip" data-placement="top" title="Remove item"></a></td>';
        html += '</tr>';
        return html;
    }

    function GetNightsFromDates() {
        var arrival = jQuery('#date-arrival').val();
        var departure = jQuery('#date-departure').val();

        return departure.diff(arrival, 'days');
    }

</script>
