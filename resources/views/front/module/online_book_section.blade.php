<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="{{asset('public/src/dist/css/timepicker.min.css')}}">
<script src="{{asset('public/src/dist/js/timepicker.min.js')}}"></script>

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
</style>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('body').addClass('pignose-calendar-body');
    });

    $(function () {
        $('#datetimepicker3').datetimepicker({
            format: 'LT'
        });
    });
</script>


<section class="online-book-section style-two">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 pd-left clearfix">
                <div class="section-title-area">
                    <div class="title-box tb">
                        <div class="title-box-text tb-cell">
                            <h2 class="section-title">Airport <br />
                                Transfers</h2>
                        </div>
                        <div class="tb-cell box-inner">
                            <div class="title-box-inner">
                                <h3 class="section-name">Search<span>Cars</span></h3><i class="fa fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                    <!--/.site-header-->
                </div>
                <!--/.section-title-area-->
            </div>
            <!--/.col-md-12-->

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

                <form action="{{ url('check-availability')}}" method="get" id="online-book-form"
                      style="padding-left: 15px;padding-top: 15px;">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 padding-left">
                            <label class="text-uppercase">Pick Up</label>
                            <div class="input box-radius">
                                <!-- <i class="fa fa-caret-down"></i> -->
                                <select name="pickup">
                                    @foreach($properties as $key => $val)
                                        <option value="{{$val->property_id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--/.input-->
                        </div>
                        <div class="col-md-2 col-lg-2 padding-left">
                            <label class="text-uppercase">Drop Off</label>
                            <div class="input box-radius">
                                <select name="dropoff">
                                    @foreach($drop_off_list as $key => $val)
                                        <option value="{{$val->drop_list_id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--/.input-->
                        </div>
                        <!--/.col-md-3-->
                        <div class="col-md-2 col-lg-2 padding-left">
                            <label class="text-uppercase">Date</label>
                            <div class="input box-radius"><i class="fa fa-calendar"></i>
                                <input type="text" id="date-departure" placeholder="Date" name="departureDate"
                                       class="form-controller">
                            </div>
                            <!--/.input-->
                        </div>
                        <!--/.col-md-3-->
                        <div class="col-md-2 col-lg-1 padding-left">
                            <label class="text-uppercase">Time</label>
                            <div class="input box-radius">
                                <input type='text' name="departureTime" style="width:100%"  placeholder="Time"    class="form-controller bs-timepicker">
                            </div>
                            <!--/.input-->
                        </div>
                        <!--/.col-md-2-->
                        <div class="col-md-2 col-lg-1 padding-left">
                            <label class="text-uppercase">Adult</label>
                            <div class="input box-radius">
                                <!--<i class="fa fa-caret-down"></i>-->
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
                            </div>
                            <!--/.input-->
                        </div>
                        <!--/.col-md-2-->
                        <div class="col-md-2 col-lg-2 padding-left">
                            <label class="text-uppercase">children</label>
                            <div class="input box-radius">
                                <!--<i class="fa fa-caret-down"></i>-->
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
                            </div>
                            <!--/.input-->
                        </div>
                        <!--/.col-md-2-->
                        <div class="col-md-2 padding-left button-booking">
                            <a class="btn btn-default" type="submit" id="online-book-form-btn"
                               style="padding-top: 6px;line-height: normal;">Check Availability</a>
                            <!--/.btn-->
                        </div>
                        <!--/.col-md-3-->
                    </div>
                    <!--/.row-->

                </form>
                <!--/.online-book-form-->
            </div>
            <!--/.col-md-9-->
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>
<!--/.online-book-section-->

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
                <p class='modal-text'>Please insert the all fields.</p>
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

<div class="modal fade" id="modal-lowest-room" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
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
                <p class='modal-text'>Vehicle are not available for the lowest rate.</p>
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


<!--<a href="#" data-toggle="modal" id="Low"  class="float vertical-text"><span>Lowest Rate</span></a>-->

<!-- Modal check ota start -->
<div class="modal fade" id="modal-check-ota" tabindex="-1" role="dialog" aria-labelledby="Low"
     aria-hidden="true">
    <div class="modal-dialog" style="width:400px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title text-center">Lowest Rate Available</h4>
            </div><!-- End .modal-header -->
            <div class="modal-body clearfix">
                <span>Please enter your dates. Compare and book direct.</span>
                <div class="alert alert-warning" style="display:none" id="less_rooms_available_for_lowest_rate">
                    <i class="fa fa-exclamation-circle"></i>
                    Sorry, no Vehicle is available for the selected date. Please choose another date.
                </div>

                <form action="#" method="post" id="lowest_rate_form" name="commentForm" class="online-book-form">

                    <div class="col-md-12 col-lg-12 padding-left">
                        <label class="text-uppercase">Check-in Date</label>
                        <div class="input box-radius"><i class="fa fa-calendar"></i>
                            <input type="text" id="Ldate-arrival" name="checkin" placeholder="Check-in Date"
                                   class="form-controller">
                        </div>
                        <!--/.input-->
                    </div>
                    <!--/.col-md-6-->
                    <div class="col-md-12 col-lg-12 padding-left">
                        <label class="text-uppercase">Check-out Date</label>
                        <div class="input box-radius"><i class="fa fa-calendar"></i>
                            <input type="text" id="Ldate-departure" name="checkout" placeholder="Check-out Date"
                                   class="form-controller">
                        </div>
                        <!--/.input-->
                    </div>
                    <!--/.col-md-6-->
                    <div class="clearfix margin-top"></div>

                    <!--<h5 class="modal-title margin-top col-md-3">Book with Us</h5>-->

                    <div class="col-md-12 margin-top text-center">
                        <input type="hidden" id="product-data" value="">
                        <b id="RateFix" style="visibility: hidden;"></b>&nbsp;
                        <a href="#" class="btn btn-danger btn-sm" style="display: none;" id="lowest_rate"></a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-md-12 text-center" style="text-align: center;">
                        <table class="table margin-top" style="font-size: 14px;">
                            <tbody id="LowestRate">

                            </tbody>
                        </table>
                    </div>


                </form>
            </div><!-- End .modal-body -->

        </div><!-- End .modal-content -->
    </div><!-- End .modal-dialog -->

</div><!-- End .modal check ota -->


<script type="text/javascript">
    $(document).ready(function () {
        jQuery('#date-arrival').pignoseCalendar({
            buttons: true,
            minDate: new Date(),
            select: function (date, context) {
            },
            apply: function (date, context) {
                var dd = moment(date);
                dd.set('date', dd.get('date') + 1);
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
                    jQuery('#modal-check-ota').hide()
                }
            }
        });

        jQuery('#Low').click(function(){
            jQuery('#modal-check-ota').modal('show');
        })
        function check() {
            return false;
        }

        jQuery('#online-book-form-btn').click(function () {
            if (jQuery('#date-arrival').val() == '' || jQuery('#date-departure').val() == '') {
                jQuery('.modal-text').text('Please insert the Date & Time.');
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

    });

    $(function () {
        $('.bs-timepicker').timepicker();
    });

    window.onload = function () {
        jQuery('#date-arrival').pignoseCalendar({
            buttons: true,
            minDate: new Date(),
            select: function (date, context) {
            },
            apply: function (date, context) {
                var dd = moment(date);
                dd.set('date', dd.get('date') + 1);
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
                    jQuery('#modal-data-text').text('Please select departure date bigger than arrival date.');
                    jQuery('#modal-validation').modal('show');

                    //alert('Please select departure date bigger than arrival date.');
                }
            }
        });
    };
    $(document).ready(function(){
        jQuery('#Ldate-arrival').pignoseCalendar({
            buttons: true,
            minDate: new Date(),
            select: function (date, context) {
            },
            apply: function (date, context) {
                var ddt = moment(date);
                ddt.set('date', ddt.get('date') + 1);
                checkDates();
                if (jQuery('#Ldate-departure').val() != '' && new Date(jQuery('#Ldate-arrival').val()) >= new Date(jQuery('#Ldate-departure').val())) {
                    jQuery('#Ldate-departure').val(ddt.format('YYYY-MM-DD'));
                }
                jQuery('#Ldate-departure').pignoseCalendar('set', ddt.format('YYYY-MM-DD'));
                jQuery('#Ldate-departure').trigger("click");
            }
        });
        jQuery('#Ldate-departure').pignoseCalendar({
            buttons: true,
            minDate: new Date(),
            select: function (dates, context) {
            },
            apply: function (date, context) {
                checkDates();
                if (new Date(jQuery('#Ldate-arrival').val()) >= new Date(date)) {
                    jQuery('#Ldate-departure').val('');
                    jQuery('.modal-text').text('Please select departure date bigger than arrival date.');
                    jQuery('#modal-validation').modal('show')
                }
            }
        });
    });

    function checkDates(){
        let date1 = $('#Ldate-arrival').val();
        let date2 = $('#Ldate-departure').val();
        if(date1 != '') {
            if (date2 != '') {
                $('#lowest_rate').show();
                $('#lowest_rate').html('CHECK' + ' ' + '<i class="fa fa-chevron-right"></i>');
            }
        }
    }

    function GetNightsFromDates() {
        var arrival = moment($('#Ldate-arrival').val());
        var departure = moment($('#Ldate-departure').val());

        return departure.diff(arrival, 'days');
    }

    function prepareCart(product) {
        var order = [];
        var pr = {
            product_id: product.id,
            qty: GetNightsFromDates(),
        };
        order.push(pr);

        var data = {
            _token: '{{ csrf_token() }}',
            order: order,
            rooms: 1,
            adults: 1,
            children: 0,
            arrival: product.arrival,
            departure: product.departure,
            promocode_id: '',
            special_requests: '',
            new_rate: product.new_rate,
            ota_checklist_id: product.ota_checklist_id
        };

        jQuery.ajax({
            url: "{{ url('make-cart') }}",
            type: 'POST',
            data: data,
            dataType: 'json',
            async: false,
            cache: false,
            success: function (response) {
                $("#lowest_rate").attr("disabled", true);
                window.location.href = "checkout";
            }
        });
    }

    function getRooms(data) {
        jQuery.ajax({
            url: "{{ url('get-rooms') }}",
            type: 'POST',
            data: data,
            dataType: 'json',
            async: false,
            cache: false,
            success: function (response) {
                console.log(response);
                if(!response.length) {
                    $("#modal-lowest-room").modal("show");
                    return
                }
                // Check the lowest price from the available rooms
                let lowestPriceRoom = response.filter(room => {
                    return room.new_rate == data.new_rate;
                });

                if(lowestPriceRoom && lowestPriceRoom.length) {
                    lowestPriceRoom = lowestPriceRoom[0];
                } else {
                    lowestPriceRoom = response[0];
                    data['ota_checklist_id'] = data['ota_checklist_id'];
                    data['id'] = lowestPriceRoom.id;
                    console.log(data);
                    $("#lowest_rate").attr("disabled", true);
                    prepareCart(data);
                }
            }
        });
    }

    $(function () {
        $('#lowest_rate').click(function () {
            var btnTxt = $(this).html();
            $("#lowest_rate").attr("disabled", true);
            $("#less_rooms_available_for_lowest_rate").hide();
            if(btnTxt.toLowerCase().indexOf("book") !== -1) {
                console.log(btnTxt);
                var product = JSON.parse($('#product-data').val());
                product.arrival = $('#Ldate-arrival').val();
                product.departure = $('#Ldate-departure').val();
                product.ota_checklist_id = product.id;
                product._token = "{{ csrf_token() }}";
                getRooms(product);
                return;
            }
            console.log(btnTxt);
            $.ajax({
                url: "{{ url('search_lowest_rate') }}/"+$('#Ldate-arrival').val()+'/'+$('#Ldate-departure').val(),
                type: 'GET',
                dataType: 'json',
                success: function (response) {

                    $("#lowest_rate").removeAttr("disabled");
                    var html = '';
                    console.log('response data')
                    console.log(response.length)
                    if(!response.length) {
                        $('#LowestRate').html("");
                        $('#product-data').val('');
                        $('#RateFix').text('');
                        $("#less_rooms_available_for_lowest_rate").show();
                        return
                    }
                    $(response).each(function(i,v){
                        if(i % 2 == 0){
                            html += '<tr bgcolor="#f1f1f1" width=""><td class="item-name-col">'+v.sitename+'</td><td>RM '+v.new_rate+'.00</td></tr>';
                        } else {
                            html += '<tr><td class="item-name-col">'+v.sitename+'</td><td>RM '+v.new_rate+'.00</td></tr>';
                        }
                    });
                    var new_rate = response[0].new_rate - response[0].new_rate * 10 / 100;
                    response[0]['new_rate'] = new_rate;

                    if(new_rate){
                        $('#lowest_rate').show();
                        $('#lowest_rate').html('BOOK NOW'+' '+'<i class="fa fa-chevron-right"></i>');
                    }
                    $('#LowestRate').html(html);
                    $('#product-data').val(JSON.stringify(response[0]));
                    $('#RateFix').text('RM '+new_rate.toFixed(2));
                    $('#RateFix').css('visibility','visible');
                }
            });
        });
    });

</script>
