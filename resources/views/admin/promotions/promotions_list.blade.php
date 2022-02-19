@extends('adminLayout')
@section('title', 'Promotions')
@section('content')

    <div id="page-wrapper">

        <div class="page-header-breadcrumb">
            <div class="page-heading hidden-xs">
                <h1 class="page-title">Promotions</h1>
            </div>

            <ol class="breadcrumb page-breadcrumb">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/web88cms/dashboard') }}">Dashboard</a>&nbsp; <i
                            class="fa fa-angle-right"></i>&nbsp;
                </li>
                <li>Promotions &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
                <li class="active">Promotions - Listing</li>
            </ol>

        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                <div class="portlet">
                    <div class="portlet-header">
                        <div class="caption" style="float:none">Page Info</div>
                        <br/>
                        <span class="text-blue text-12px">You can edit the content by clicking the text section below.</span>
                        <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                    </div>
                    <div class="portlet-body">
                        <div id="textToBeSavedcontent1" contenteditable="true"> 
                            <?= !empty($header)? $header[0]->content:''; ?>
                        </div>
                    </div>
                </div>
                <!-- save button start -->
                <div class="form-actions none-bg"> 
                    <a href="#preview in browser/not yet published" onclick="ClickToSave()" class="btn btn-red">Save &amp; Preview &nbsp;<i class="fa fa-search"></i></a>&nbsp; 
                    <a href="#publish online"  onclick="ClickToSave()" class="btn btn-blue">Save &amp; Publish &nbsp;<i class="fa fa-globe"></i></a>&nbsp; 
                    <a href="#" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a> </div>
                <!-- save button end -->
                <div id="saved" style="display:none;" class="alert alert-success alert-dismissable">
                    <button type="button" onclick="document.getElementById('saved').style.display='none'" class="close">&times;</button>
                    <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                    <p>The information has been saved/updated successfully.</p>
                </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Promotions <i class="fa fa-angle-right"></i> Listing</h2>
                    <div class="clearfix"></div>
                    <div class="alert alert-success alert-dismissable"
                         @if( Session::has('success') )
                         style="display: block;">
                        <script>setTimeout(function () {
                                $("body").animate({"scrollTop": 0}, 100);
                            }, 3000);</script>
                        <?php Session::forget('success'); ?>
                        @else
                            style="display: none;">
                        @endif
                        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                        <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                        <p>The information has been saved/updated successfully.</p>
                    </div>
                    <div class="alert alert-danger alert-dismissable"
                         @if( Session::has('fail') )
                         style="display: block;">
                        <script>setTimeout(function () {
                                $("body").animate({"scrollTop": 0}, 100);
                            }, 3000);</script>
                        <?php Session::forget('fail'); ?>
                        @else
                            style="display: none;">
                        @endif
                        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                        <i class="fa fa-times-circle"></i> <strong>Error!</strong>
                        <p>The information has not been saved/updated. Please correct the errors.</p>
                    </div>
                    @if(count($promotions))
                        <div class="pull-left"> Last updated: <span
                                    class="text-blue">{{ date('d M, Y @ g.iA', strtotime(end($promotions)->updated_at)) }}</span>
                        </div>

                    @endif


                    <div class="clearfix"></div>
                    <p></p>
                    <!--
                    <div class="clearfix"></div>
                    <div class="portlet">
                        <div class="portlet-header">
                            <div class="caption">Page Info</div>
                            <div class="clearfix"></div>
                            <span class="text-blue text-12px">You can edit the content by clicking the text section below.</span>
                            <div class="tools"><i class="fa fa-chevron-up"></i></div>
                        </div>
                        <div class="portlet-body">
                            <div contenteditable="true">
                                <div class="blog-page-area">
                                    <div class="section-title-area text-center">
                                        <h2 class="section-title">Promotions</h2>
                                        <p class="section-title-dec">From simple white coffee and toast to German and
                                            Italy selection or even for a taste of Oriental delight, you will not be
                                            disappointed!</p>
                                    </div><!--/.section-title-area
                                </div>
                            </div>
                        </div>
                    </div>-->

                    <div class="portlet">
                        <div class="portlet-header">
                            <div class="caption">Promotions Listing</div>
                            <br/>
                            <p class="margin-top-10px"></p>
                            <a href="#" data-target="#modal-add-new" data-toggle="modal" class="btn btn-success">Add New
                                &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary">Delete</button>
                                <button type="button" data-toggle="dropdown" class="btn btn-red dropdown-toggle"><span
                                            class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                                <ul role="menu" class="dropdown-menu">
                                    <li><a href="#" id="dellselobjapp">Delete selected item(s)</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" data-target="#modal-delete-all" data-toggle="modal">Delete all</a>
                                    </li>
                                </ul>
                            </div>
                             
                            <div class="tools"><i class="fa fa-chevron-up"></i></div>
                            <!--Modal Add New start-->
                            <div id="modal-add-new" tabindex="-1" role="dialog" aria-labelledby="modal-login-label"
                                 aria-hidden="true" class="modal fade">
                                <div class="modal-dialog modal-wide-width">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true"
                                                    class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">Add New Promotion</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form">
                                                <form action="{{ url('/web88cms/promotions_list') }}" method="POST"
                                                      class="form-horizontal" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token"
                                                           value="{{ csrf_token() }}"/>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Status</label>
                                                        <div class="col-md-6">
                                                            <div data-on="success" data-off="primary"
                                                                 class="make-switch">
                                                                <input type="checkbox" name="status_chk"
                                                                       checked="checked"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-error">
                                                        <label class="col-md-3 control-label">Title <span
                                                                    class="require">*</span></label>
                                                        <div class="col-md-6">
                                                            <input type="text" name="title" class="form-control"
                                                                   placeholder="eg. Western Set Lunch Promo"
                                                                   required="required" autocomplete="off">
                                                        </div>
                                                        {{--   <div class="col-md-3">
                                                            <div class="popover popover-validator right">
                                                              <div class="arrow"></div>
                                                              <div class="popover-content">
                                                                <p class="mbn">Title is empty!</p>
                                                              </div>
                                                            </div>
                                                          </div> --}}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Short Description </label>
                                                        <div class="col-md-6">
                                                            <textarea class="form-control" name="sh_des"
                                                                      placeholder="eg. With complimentary cordial drink"
                                                                      required="required"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Date <span
                                                                    class="require">*</span></label>
                                                        <div class="col-md-5">
                                                            <div class="input-group">
                                                                <input type="text" name="date_t"
                                                                       class="datepicker-default form-control"
                                                                       data-date-format="yyyy-mm-dd" required="required"
                                                                       placeholder="eg. 25th Apr, 2017"
                                                                       autocomplete="off"/>
                                                                <div class="input-group-addon"><i
                                                                            class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Upload Image <span
                                                                    class='require'>*</span></label>
                                                        <div class="col-md-9">
                                                            <div class="text-15px margin-top-10px">
                                                                <input id="exampleInputFile2" required="required"
                                                                       name="file_name" type="file"/>
                                                                <br/>
                                                                <span class="help-block">(Image dimension: 318 x 350 pixels, JPEG/GIF/PNG only, Max. 1MB) </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Upload Enlarge
                                                            Image</label>
                                                        <div class="col-md-9">

                                                            <input id="exampleInputFile2" required="required"
                                                                   name="large_file" type="file"/>
                                                            <br/>
                                                            <span class="help-block">(JPEG/GIF/PNG only, Max. 2MB) </span>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="form-actions">
                                                        <div class="col-md-offset-5 col-md-8">
                                                            <button type="submit" class="btn btn-red">Save &nbsp;<i
                                                                        class="fa fa-floppy-o"></i></button>
                                                            &nbsp;

                                                            <a href="#" data-dismiss="modal" class="btn btn-green">Cancel
                                                                &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--END MODAL Add New banner -->
                            <div id="modal-select-confirm" tabindex="-1" role="dialog"
                                 aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">
                                                ×
                                            </button>
                                            <h4 class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"
                                                                                  style="color:#2598b0"></i></a> Please
                                                Select at least one item.</h4>
                                        </div>

                                        <div class="modal-body">
                                            <div class="alert alert-danger">
                                                Please Select atleast one Promotion to delete.

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div><!-- modal select confirm -->
                            <form class="delete_text_objective form-horizontal"
                                  action="{{ url('/web88cms/promotion_selected_all_del') }}" method="POST">
                                <input type="hidden" name="_token"
                                       value="{{ csrf_token() }}"/>

                                <input type="hidden" name="index">
                            </form>
                            <!--Modal delete selected items start-->

                            <div id="modal-delete-selected" tabindex="-1" role="dialog"
                                 aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true"
                                                    class="close">&times;</button>
                                            <h4 id="modal-login-label4" class="modal-title"><a href=""><i
                                                            class="fa fa-exclamation-triangle"></i></a> Are you sure you
                                                want to delete the selected item(s)? </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-actions">
                                                <div class="col-md-offset-4 col-md-8"><a href="#" id="dellselobj"
                                                                                         class="btn btn-red">Yes
                                                        &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#"
                                                                                                       data-dismiss="modal"
                                                                                                       class="btn btn-green">No
                                                        &nbsp;<i class="fa fa-times-circle"></i></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal delete selected items end -->
                            <!--Modal delete all items start-->
                            <div id="modal-delete-all" tabindex="-1" role="dialog" aria-labelledby="modal-login-label"
                                 aria-hidden="true" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true"
                                                    class="close">&times;</button>
                                            <h4 id="modal-login-label4" class="modal-title"><a href=""><i
                                                            class="fa fa-exclamation-triangle"></i></a> Are you sure you
                                                want to delete all items? </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-actions">
                                                <div class="col-md-offset-4 col-md-8">
                                                    <form action="{{ url('/web88cms/promotions_list_all_del') }}"
                                                          method="POST">
                                                        <input type="hidden" name="_token"
                                                               value="{{ csrf_token() }}"/>

                                                        <input type="hidden" name="chk" value="1">
                                                        <button type="submit" class="btn btn-red">Yes &nbsp;<i
                                                                    class="fa fa-check"></i></button>
                                                        &nbsp; <a href="#" data-dismiss="modal" class="btn btn-green">No
                                                            &nbsp;<i class="fa fa-times-circle"></i></a>
                                                    </form>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal delete all items end -->
                        </div>
                        <div class="portlet-body">
                            <!--
                            <div class="form-inline pull-left">
                                <div class="form-group">
                                    <select name="select" class="form-control">
                                        <option>10</option>
                                        <option>20</option>
                                        <option selected="selected">30</option>
                                        <option>50</option>
                                        <option>100</option>
                                    </select>
                                    &nbsp;
                                    <label class="control-label">Records per page</label>
                                </div>
                            </div>
                            -->
                            <div class="clearfix"></div>
                            <br/>
                            <br/>
                            <div class="portlet-body">
                                <div class="table-responsive mtl">
                                    <table id="table-title-slider" class="table table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th width="1%"><input type="checkbox" onclick="$('input[type=checkbox]').prop('checked', $(this).is(':checked'))" /></th>
                                            <th>#</th>
                                            <th>Status</th>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        @if(isset($promotions) && !empty($promotions))
                                            @foreach ($promotions as $key => $value)

                                                <tbody>
                                                <tr>
                                                    <td><input data="{{$value->id}}" type="checkbox"
                                                               class="mooncake-mod-checkbox"/></td>
                                                    <td>{{ $value->id }}</td>
                                                    <td>

                                                        <span class="label label-sm label-success">{{ $value->status }}</span>

                                                    </td>
                                                    <td>{{ $value->title }}</td>
                                                    <td>{{ $value->date }}</td>
                                                    <td><a href="#" data-hover="tooltip" data-placement="top"
                                                           data-target="#modal-edit-banner{{ $key }}"
                                                           data-toggle="modal" title="Edit"><span
                                                                    class="label label-sm label-success"><i
                                                                        class="fa fa-pencil"></i></span></a> <a href="#"
                                                                                                                data-hover="tooltip"
                                                                                                                data-placement="top"
                                                                                                                title="Delete"
                                                                                                                data-target="#modal-delete-{{ $key }}"
                                                                                                                data-toggle="modal"><span
                                                                    class="label label-sm label-red"><i
                                                                        class="fa fa-trash-o"></i></span></a>
                                                        <!--Modal Edit banner start-->
                                                        <div id="modal-edit-banner{{ $key }}" tabindex="-1"
                                                             role="dialog" aria-labelledby="modal-login-label"
                                                             aria-hidden="true" class="modal fade">
                                                            <div class="modal-dialog modal-wide-width">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" data-dismiss="modal"
                                                                                aria-hidden="true"
                                                                                class="close">&times;</button>
                                                                        <h4 id="modal-login-label3" class="modal-title">
                                                                            Edit Promotion</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form">

                                                                            <form class="form-horizontal" method="post"
                                                                                  enctype="multipart/form-data"
                                                                                  action="{{ url('/web88cms/editpromotions_list') }}">
                                                                                <input type="hidden" name="_token"
                                                                                       value="{{ csrf_token() }}"/>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label">Status</label>
                                                                                    <div class="col-md-6">
                                                                                        <div data-on="success"
                                                                                             data-off="primary"
                                                                                             class="make-switch">
                                                                                            @if ($value->status == "Active")
                                                                                                <input name="status_chk"
                                                                                                       type="checkbox"
                                                                                                       checked="checked"/>
                                                                                            @else
                                                                                                <input name="status_chk"
                                                                                                       type="checkbox"/>
                                                                                            @endif

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label">Title
                                                                                        <span class="require">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6">
                                                                                        <input name="title"
                                                                                               required="required"
                                                                                               id="text" type="text"
                                                                                               class="form-control"
                                                                                               placeholder="eg. Western Set Lunch Promo"
                                                                                               value="{{$value->title}}"
                                                                                               autocomplete="off">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label">Short
                                                                                        Description </label>
                                                                                    <div class="col-md-6">
                                                                                        <textarea name="sh_des"
                                                                                                  required="required"
                                                                                                  class="form-control"
                                                                                                  placebolder="With complimentary cordial drink">{{$value->short_description}}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label">Date
                                                                                        <span class="require">*</span></label>
                                                                                    <div class="col-md-5">
                                                                                        <div class="input-group">
                                                                                            <input name="date_t"
                                                                                                   required="required"
                                                                                                   type="text"
                                                                                                   class="datepicker-default form-control"
                                                                                                   data-date-format="yyyy-mm-dd"
                                                                                                   placeholder="eg. 25th Apr, 2017"
                                                                                                   value="{{ $value->date }}"
                                                                                                   autocomplete="off"/>
                                                                                            <div class="input-group-addon">
                                                                                                <i class="fa fa-calendar"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label">Upload
                                                                                        Image <span
                                                                                                class='require'>*</span></label>
                                                                                    <div class="col-md-9">
                                                                                        <div class="text-15px margin-top-10px">
                                                                                            <?php if($value->image){?>
                                                                                            <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . '/public/front/images/promotions/', $value->image?>"
                                                                                                 alt="Promotion Image"
                                                                                                 class="img-responsive"><br/>
                                                                                            <a href="#"
                                                                                               data-hover="tooltip"
                                                                                               data-placement="top"
                                                                                               title="Delete"
                                                                                               data-target="#modal-delete-promotion-image{{ $key }}"
                                                                                               data-toggle="modal"><span
                                                                                                        class="label label-sm label-red"><i
                                                                                                            class="fa fa-trash-o"></i></span></a>
                                                                                            <div class="clearfix"></div>
                                                                                            <br/>
                                                                                            <?php }?>
                                                                                            <input name="file_name" <?php if(!$value->image){?> required="required" <?php }?>
                                                                                                   id="exampleInputFile2"
                                                                                                   type="file"/>
                                                                                            <br/>
                                                                                            <span class="help-block">(Image dimension: 318 x 350 pixels, JPEG/GIF/PNG only, Max. 1MB) </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label">Upload
                                                                                        Enlarge Image</label>
                                                                                    <div class="col-md-9">
                                                                                        <div class="text-15px margin-top-10px">
                                                                                            <?php if($value->enlarge_image){?>
                                                                                            <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . '/public/front/images/promotions/', $value->enlarge_image?>"
                                                                                                 alt="Promtion Large Image"
                                                                                                 class="img-responsive"><br/>
                                                                                            <a href="#"
                                                                                               data-hover="tooltip"
                                                                                               data-placement="top"
                                                                                               title="Delete"
                                                                                               data-target="#modal-delete-large-image{{ $key }}"
                                                                                               data-toggle="modal"><span
                                                                                                        class="label label-sm label-red"><i
                                                                                                            class="fa fa-trash-o"></i></span></a>
                                                                                            <div class="clearfix"></div>
                                                                                            <br/>
                                                                                                <?php }?>
                                                                                            <input name="large_file"
                                                                                                   id="exampleInputFile2"
                                                                                                   type="file"/>
                                                                                            <br/>
                                                                                            <span class="help-block">(JPEG/GIF/PNG only, Max. 2MB) </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="clearfix"></div>
                                                                                <input type="hidden"
                                                                                       value="{{$value->id}}"
                                                                                       name="key"/>
                                                                                <div class="form-actions">
                                                                                    <div class="col-md-offset-5 col-md-8">
                                                                                        <button type="submit"
                                                                                                class="btn btn-red">Save
                                                                                            &nbsp;<i
                                                                                                    class="fa fa-floppy-o"></i>
                                                                                        </button>
                                                                                        &nbsp; <a href="#"
                                                                                                  data-dismiss="modal"
                                                                                                  class="btn btn-green">Cancel
                                                                                            &nbsp;<i
                                                                                                    class="glyphicon glyphicon-ban-circle"></i></a>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--END MODAL Edit promotion-->
                                                        <!--Modal delete promotion image start-->
                                                        <div id="modal-delete-promotion-image{{ $key }}" tabindex="-1"
                                                             role="dialog" aria-labelledby="modal-login-label"
                                                             aria-hidden="true" class="modal fade">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" data-dismiss="modal"
                                                                                aria-hidden="true"
                                                                                class="close">&times;</button>
                                                                        <h4 id="modal-login-label3" class="modal-title">
                                                                            <a href=""><i
                                                                                        class="fa fa-exclamation-triangle"></i></a>
                                                                            Are you sure you want to delete this
                                                                            promotion image? </h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>
                                                                            <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . '/public/front/images/promotions/', $value->image?>"
                                                                                 alt="Delete Img"
                                                                                 class="img-responsive"></p>
                                                                        <input id="images_icon_del" type="hidden"
                                                                               data="{{$value->image}}">
                                                                        <div class="form-actions">
                                                                            <div class="col-md-offset-4 col-md-8">
                                                                                <a href="#preview in browser/not yet published"
                                                                                   class="del_img_t btn btn-red">Yes
                                                                                    &nbsp;<i
                                                                                            class="fa fa-check"></i></a>
                                                                                &nbsp;
                                                                                <a href="#" data-dismiss="modal"
                                                                                   class="btn btn-green">No &nbsp;<i
                                                                                            class="fa fa-times-circle"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- modal delete promotion image end -->
                                                        <div id="modal-delete-large-image{{ $key }}" tabindex="-1"
                                                             role="dialog" aria-labelledby="modal-login-label"
                                                             aria-hidden="true" class="modal fade">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" data-dismiss="modal"
                                                                                aria-hidden="true"
                                                                                class="close">&times;</button>
                                                                        <h4 id="modal-login-label3" class="modal-title">
                                                                            <a href=""><i
                                                                                        class="fa fa-exclamation-triangle"></i></a>
                                                                            Are you sure you want to delete this
                                                                            promotion image? </h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>
                                                                            <img src="<?php echo "https://" . $_SERVER['HTTP_HOST'] . '/public/front/images/promotions/', $value->enlarge_image?>"
                                                                                 alt="Delete Large img"
                                                                                 class="img-responsive"></p>
                                                                        <input id="images_large_del" type="hidden"
                                                                               data="{{$value->enlarge_image}}">
                                                                        <div class="form-actions">
                                                                            <div class="col-md-offset-4 col-md-8">
                                                                                <a href="#preview in browser/not yet published"
                                                                                   class="del_large_t btn btn-red">Yes
                                                                                    &nbsp;<i
                                                                                            class="fa fa-check"></i></a>&nbsp;
                                                                                <a href="#" data-dismiss="modal"
                                                                                   class="btn btn-green">No &nbsp;<i
                                                                                            class="fa fa-times-circle"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- modal delete promotion image end -->
                                                        <!--Modal delete start-->
                                                        <div id="modal-delete-{{ $key }}" tabindex="-1" role="dialog"
                                                             aria-labelledby="modal-login-label" aria-hidden="true"
                                                             class="modal fade">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" data-dismiss="modal"
                                                                                aria-hidden="true"
                                                                                class="close">&times;</button>
                                                                        <h4 id="modal-login-label4" class="modal-title">
                                                                            <a href=""><i
                                                                                        class="fa fa-exclamation-triangle"></i></a>
                                                                            Are you sure you want to delete this
                                                                            promotion? </h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p><strong>#{{$value->id}}
                                                                                :</strong> {{$value->title}}</p>
                                                                        <div class="form-actions">
                                                                            <div class="col-md-offset-4 col-md-8">

                                                                                <form action="{{ url('/web88cms/promotions_list_del') }}"
                                                                                      method="post">
                                                                                    <input type="hidden" name="_token"
                                                                                           value="{{ csrf_token() }}"/>

                                                                                    <input type="hidden"
                                                                                           value="{{$value->id}}"
                                                                                           name="keys"/>
                                                                                    <button type="submit"
                                                                                            class="btn btn-red">Yes
                                                                                        &nbsp;<i
                                                                                                class="fa fa-check"></i>
                                                                                    </button>
                                                                                    &nbsp; <a href="#"
                                                                                              data-dismiss="modal"
                                                                                              class="btn btn-green">No
                                                                                        &nbsp;<i
                                                                                                class="fa fa-times-circle"></i></a>
                                                                                </form>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <form class="t_icon_del form-horizontal" method="post"
                                                              action="{{ url('/web88cms/promotion_del_img') }}">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}"/>

                                                            <input type="hidden" name="img_path">
                                                        </form>


                                                        <form class="t_large_del form-horizontal" method="post"
                                                              action="{{ url('/web88cms/promotion_large_img') }}">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}"/>

                                                            <input type="hidden" name="large_path">
                                                        </form>
                                                        <!-- modal delete end -->
                                                    </td>
                                                </tr>
                                                </tbody>

                                            @endforeach
                                        @endif
                                        <tfoot>
                                        <tr>
                                            <td colspan="8"></td>

                                        </tr>
                                        </tfoot>
                                    </table>
                                    <div class="tool-footer text-right">
                                        {{--   <p class="pull-left">Showing 1 to 10 of 57 entries</p> --}}

                                    </div>

                                    <div class="clearfix"></div>
                                </div>
                                <!-- end table responsive -->
                            </div>
                        </div>
                        <!-- end portlet -->
                    </div>
                </div>
            </div>

            <div class="page-footer">
                <div class="copyright"><span class="text-15px">2015 &copy; <a href="http://www.webqom.com"
                                                                              target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a
                                href="mailto:support@webqom.com">Webqom Support</a>.</span>
                    <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}"
                                                 alt="Webqom Technologies Sdn Bhd"></div>
                </div>
            </div>
        </div>
    </div>


    <!--LOADING SCRIPTS FOR PAGE-->
    <script src="{{ asset('/public/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/moment/moment.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/bootstrap-clockface/js/clockface.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
    <script src="{{ asset('/public/admin/vendors/jquery-maskedinput/jquery-maskedinput.js') }}"></script>
    <script src="{{ asset('/public/admin/js/form-components.js') }}"></script>
    <!--LOADING SCRIPTS FOR PAGE-->
    <script type="text/javascript">

        $('#dellselobjapp').on('click', function () {

            if ($('.mooncake-mod-checkbox:checked').length == 0) {
                $("#modal-select-confirm").modal();
            } else {
                $("#modal-delete-selected").modal();

            }

        });


        // Del select objective
        $('#dellselobj').click(function (e) {
            e.preventDefault();
            var str = '';
            $("#table-title-slider td:first-child input:checked").each(function (i, e) {
                str += $(e).attr('data') + ",";
            });
            $('.delete_text_objective > input[name=index]').val(str);
            $('.delete_text_objective').submit();
        });

        // Del Small Image
        $('.del_img_t').on('click', function (e) {
            e.preventDefault();
            var str = '';
            $("#images_icon_del").each(function (i, e) {
                str += $(e).attr('data');
            });

            $('.t_icon_del > input[name=img_path]').val(str);
            $('.t_icon_del').submit();
        });
        // Dell Large Image
        //
        $('.del_large_t').on('click', function (e) {
            e.preventDefault();
            var str = '';
            $("#images_large_del").each(function (i, e) {
                str += $(e).attr('data');
            });

            $('.t_large_del > input[name=large_path]').val(str);
            $('.t_large_del').submit();
        });

        function ClickToSave () {
            $.post("headerUpdate",{
                _token : 	'{{{ csrf_token() }}}',
                content : document.getElementById('textToBeSavedcontent1').innerHTML,
                page : 'promotions'
            },
            function(data,status){
                //alert("Status: " + status);
                document.getElementById('saved').style.display='block';
            });
        }
    </script>
@endsection
