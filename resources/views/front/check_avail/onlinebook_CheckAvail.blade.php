
<link rel="stylesheet" href="https://besarhati8.webqom.com/public/src/dist/css/timepicker.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://besarhati8.webqom.com/public/src/dist/js/timepicker.min.js"></script>

<section class="online-book-section style-two">
    <div class="bg-grey">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 pd-left clearfix">
                    <div class="section-title-area">
                        <div class="title-box tb">
                            <div class="title-box-text tb-cell">
                                <h2 class="section-title">Airport Transfers</h2>
                            </div>
                            <div class="tb-cell box-inner">
                                <div class="title-box-inner">
                                    <h3 class="section-name">Search<span>Cars</span></h3><i
                                            class="fa fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                        <!--/.site-header-->
                    </div>
                    <!--/.section-title-area-->
                </div>
                <!--/.col-md-12-->
                <div class="col-md-9 form-content">
                    <form class="online-book-form" method="post">
                        <div class="row">
                            <div class="col-md-2 col-lg-2 padding-left">
                                <label class="text-uppercase">Pick Up</label>
                                <div class="input box-radius"><i class="fa fa-caret-down"></i>
                                    <select name="property" id="pickUpLocation">
                                        @foreach($properties as $key => $val)
                                            <option value="{{$val->property_id}}"
                                                    {{@($property == $val->property_id ? 'selected' : '')}}>{{$val->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--/.input-->
                            </div>
                            <div class="col-md-2 col-lg-2 padding-left">
                                <label class="text-uppercase">Drop Off</label>
                                <div class="input box-radius"><i class="fa fa-caret-down"></i>
                                    <select name="dropOfLocation" id="drop-list" class=" form-controller">
                                        @foreach($drop_off_list as $key => $val)
                                            <option value="{{$val->drop_list_id}}"
                                                    {{@($arrival == $val->drop_list_id ? 'selected' : '')}}>{{$val->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--/.input-->
                            </div>
                            <!--/.col-md-3-->
                            <div class="col-md-2 col-lg-2 padding-left">
                                <label class="text-uppercase">Date</label>
                                <div class="input box-radius"><i class="fa fa-calendar"></i>
                                    <input type="text" id="date-departure" placeholder="Check-out Date"
                                           class=" form-controller"
                                           value="<?php echo empty($departure) ? '' : $departure ?>">
                                </div>
                                <!--/.input-->
                            </div>
                            <!--/.col-md-3-->
                            <div class="col-md-2 col-lg-1 padding-left">
                                <label class="text-uppercase">Time</label>
                                <div class="input box-radius">
                                    <input type='text' name="room" id="timepicker" class="form-controller bs-timepicker" style="width:100%" value="<?php echo empty($room) ? '' : $room ?>" placeholder="Time" id="departTime" >
                                </div>
                                <!--/.input-->
                            </div>
                            <!--/.col-md-2-->
                            <div class="col-md-2 col-lg-1 padding-left">
                                <label class="text-uppercase">Adult</label>
                                <div class="input box-radius"><i class="fa fa-caret-down"></i>
                                    <select name="adult" id="adult-avail"
                                            value="<?php echo empty($adult) ? '' : $adult ?>">
                                        <option value="1"
                                        <?php if (!empty($adult) && $adult == 1) echo "selected='selected'"; ?>>
                                            1
                                        </option>
                                        <option value="2"
                                        <?php if (!empty($adult) && $adult == 2) echo "selected='selected'"; ?>>
                                            2
                                        </option>
                                        <option value="3"
                                        <?php if (!empty($adult) && $adult == 3) echo "selected='selected'"; ?>>
                                            3
                                        </option>
                                        <option value="4"
                                        <?php if (!empty($adult) && $adult == 4) echo "selected='selected'"; ?>>
                                            4
                                        </option>
                                        <option value="5"
                                        <?php if (!empty($adult) && $adult == 5) echo "selected='selected'"; ?>>
                                            5
                                        </option>
                                        <option value="6"
                                        <?php if (!empty($adult) && $adult == 6) echo "selected='selected'"; ?>>
                                            6
                                        </option>
                                        <option value="7"
                                        <?php if (!empty($adult) && $adult == 7) echo "selected='selected'"; ?>>
                                            7
                                        </option>
                                        <option value="8"
                                        <?php if (!empty($adult) && $adult == 8) echo "selected='selected'"; ?>>
                                            8
                                        </option>
                                        <option value="9"
                                        <?php if (!empty($adult) && $adult == 9) echo "selected='selected'"; ?>>
                                            9
                                        </option>
                                        <option value="10"
                                        <?php if (!empty($adult) && $adult == 10) echo "selected='selected'"; ?>>
                                            10
                                        </option>
                                    </select>
                                </div>
                                <!--/.input-->
                            </div>
                            <!--/.col-md-2-->
                            <div class="col-md-2 col-lg-2 padding-left">
                                <label class="text-uppercase">Children</label>
                                <div class="input box-radius"><i class="fa fa-caret-down"></i>
                                    <select name="childrens" id="children-avail"
                                            value="<?php echo empty($childrens) ? '' : $childrens ?>">
                                        <option value="0"
                                        <?php if (empty($childrens) || $childrens == 0) echo "selected='selected'"; ?>>
                                            0
                                        </option>
                                        <option value="1"
                                        <?php if (!empty($childrens) && $childrens == 1) echo "selected='selected'"; ?>>
                                            1
                                        </option>
                                        <option value="2"
                                        <?php if (!empty($childrens) && $childrens == 2) echo "selected='selected'"; ?>>
                                            2
                                        </option>
                                        <option value="3"
                                        <?php if (!empty($childrens) && $childrens == 3) echo "selected='selected'"; ?>>
                                            3
                                        </option>
                                        <option value="4"
                                        <?php if (!empty($childrens) && $childrens == 4) echo "selected='selected'"; ?>>
                                            4
                                        </option>
                                        <option value="5"
                                        <?php if (!empty($childrens) && $childrens == 5) echo "selected='selected'"; ?>>
                                            5
                                        </option>
                                        <option value="6"
                                        <?php if (!empty($childrens) && $childrens == 6) echo "selected='selected'"; ?>>
                                            6
                                        </option>
                                        <option value="7"
                                        <?php if (!empty($childrens) && $childrens == 7) echo "selected='selected'"; ?>>
                                            7
                                        </option>
                                        <option value="8"
                                        <?php if (!empty($childrens) && $childrens == 8) echo "selected='selected'"; ?>>
                                            8
                                        </option>
                                        <option value="9"
                                        <?php if (!empty($childrens) && $childrens == 9) echo "selected='selected'"; ?>>
                                            9
                                        </option>
                                        <option value="10"
                                        <?php if (!empty($childrens) && $childrens == 10) echo "selected='selected'"; ?>>
                                            10
                                        </option>
                                    </select>
                                </div>
                                <!--/.input-->
                            </div>
                            <!--/.col-md-2-->
                            <div class="col-md-2 padding-left button-booking">
                                <a class="btn btn-default" onclick="checkAvail()"
                                   style="padding-top: 6px;line-height: normal;">Check Availability</a>
                            </div>
                        </div>
                        <!--/.row-->
                    </form>
                    <!--/.online-book-form-->
                </div>
                <!--/.col-md-12-->
            </div>
            <!--/.row-->
        </div>
        <!--/.container-fluid-->
    </div>
</section>
<!--/.online-book-section-->


<script type="text/javascript">
    $(document).ready(function () {
        $('#timepicker').timepicker();
    });
</script>