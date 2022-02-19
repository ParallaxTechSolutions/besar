@extends('adminLayout')
@section('title', 'Gallery')
@section('content')

<div id="page-wrapper">
	<div class="page-header-breadcrumb">
		<div class="page-heading hidden-xs">
			<h1 class="page-title">Gallery</h1>
		</div>
		<ol class="breadcrumb page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>&nbsp;
				<a href="{{ url('/web88cms/dashboard') }}">Dashboard</a>&nbsp; 
				<i class="fa fa-angle-right"></i>&nbsp;
			</li>
			<li>Gallery &nbsp;
				<i class="fa fa-angle-right"></i>&nbsp;
			</li>
			<li class="active">Gallery - Listing</li>
		</ol>
	</div>
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h2>Gallery 
					<i class="fa fa-angle-right"></i> Listing
				</h2>
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
					<i class="fa fa-check-circle"></i>
					<strong>Success!</strong>
					<p>The information has been saved/updated successfully.</p>
				</div>

				@if(count($category))
                    <div class="pull-left"> Last updated: 
                        <span class="text-blue">{{ $latest_activity_date }}</span>
                    </div>
                @endif

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
					<i class="fa fa-times-circle"></i>
					<strong>Error!</strong>
					<p>The information has not been saved/updated. Please correct the errors.</p>
				</div>
                @if(count($category))
                   {{--  <div class="pull-left"> Last updated: 
                        <span class="text-blue">{{ date('d M, Y @ g.iA', strtotime($category->last()->updated_at)) }}</span>
                    </div> --}}
                @endif
                  
				<div class="clearfix"></div>
				<div class="portlet">
					<div class="portlet-header">
						<div class="caption" style="float:none">Page Info</div>
						<br/>
						<span class="text-blue text-12px">You can edit the content by clicking the text section below.</span>
						<div class="tools">
							<i class="fa fa-chevron-up"></i>
						</div>
					</div>
					<div class="portlet-body">
						<div id="textToBeSavedcontent1" contenteditable="true">
							<?= !empty($header)? $header[0]->content:''; ?>
						</div>
					</div>
				</div>
				<!-- save button start -->
				<div class="form-actions none-bg">
					<a href="#preview in browser/not yet published" onclick="ClickToSave()" class="btn btn-red">Save &amp; Preview &nbsp;
						<i class="fa fa-search"></i>
					</a>&nbsp; 
                        
					<a href="#publish online"  onclick="ClickToSave()" class="btn btn-blue">Save &amp; Publish &nbsp;
						<i class="fa fa-globe"></i>
					</a>&nbsp; 
                        
					<a href="#" class="btn btn-green">Cancel &nbsp;
						<i class="glyphicon glyphicon-ban-circle"></i>
					</a>
				</div>
				<!-- save button end -->
				<div id="saved" style="display:none;" class="alert alert-success alert-dismissable">
					<button type="button" onclick="document.getElementById('saved').style.display='none'" class="close">&times;</button>
					<i class="fa fa-check-circle"></i>
					<strong>Success!</strong>
					<p>The information has been saved/updated successfully.</p>
				</div>
                <!-- <div class="clearfix"></div> -->
                <div class="portlet">
                    <div class="portlet-header">
                        <div class="caption">Category Listing</div>
                        <br/>
                        <p class="margin-top-10px"></p>
                        <a href="#" data-target="#modal-add-new" data-toggle="modal" class="btn btn-success">Add New &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary">Delete</button>
                            <button type="button" data-toggle="dropdown" class="btn btn-red dropdown-toggle">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul role="menu" class="dropdown-menu">
                                <li>
                                    <a href="#" id="dellselobjapp">Delete selected item(s)</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#" data-target="#modal-delete-all" data-toggle="modal">Delete all</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tools">
                            <i class="fa fa-chevron-up"></i>
                        </div>
                        <!--Modal Add New start-->
                        <div id="modal-add-new" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                            <div class="modal-dialog modal-wide-width">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" data-dismiss="modal" aria-hidden="true"
                                                class="close">&times;</button>
                                        <h4 id="modal-login-label3" class="modal-title">Add New Category</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form">
                                            <form action="{{ url('/web88cms/category') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Status</label>
                                                    <div class="col-md-6">
                                                        <div data-on="success" data-off="primary"class="make-switch">
                                                            <input type="checkbox" name="status" checked="checked"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-error">
                                                    <label class="col-md-3 control-label">Title 
                                                        <span class="require">*</span>
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="name" class="form-control" required="required" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="form-actions">
                                                    <div class="col-md-offset-5 col-md-8">
                                                        <button type="submit" class="btn btn-red">Save &nbsp;
                                                            <i class="fa fa-floppy-o"></i>
                                                        </button>&nbsp;                                                    
                                                        <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;
                                                            <i class="glyphicon glyphicon-ban-circle"></i>
                                                        </a>
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
                                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
                                        <h4 class="modal-title">
                                            <a href="">
                                                <i class="fa fa-exclamation-triangle" style="color:#2598b0"></i>
                                            </a> Please select at least one item.
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-danger"> Please select at least one Category to delete. </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal select confirm -->
                        <form class="delete_text_objective form-horizontal" action="{{ url('/web88cms/category_selected_del') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <input type="hidden" name="index">
                        </form>
                        <!--Modal delete selected items start-->
                        <div id="modal-delete-selected" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                        <h4 id="modal-login-label4" class="modal-title">
                                            <a href="">
                                                <i class="fa fa-exclamation-triangle"></i>
                                            </a> Are you sure you want to delete the selected item(s)? 
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-actions">
                                            <div class="col-md-offset-4 col-md-8">
                                                <a href="#" id="dellselobj" class="btn btn-red">Yes &nbsp;
                                                    <i class="fa fa-check"></i>
                                                </a>&nbsp; 
                                                <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;
                                                    <i class="fa fa-times-circle"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal delete selected items end -->
                        <!--Modal delete all items start-->
                        <div id="modal-delete-all" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                        <h4 id="modal-login-label4" class="modal-title">
                                            <a href="">
                                                <i class="fa fa-exclamation-triangle"></i>
                                            </a> Are you sure you want to delete all items? 
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-actions">
                                            <div class="col-md-offset-4 col-md-8">
                                                <form action="{{ url('/web88cms/category_all_del') }}" method="POST">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                    <input type="hidden" name="chk" value="1">
                                                    <button type="submit" class="btn btn-red">Yes &nbsp;
                                                        <i class="fa fa-check"></i>
                                                    </button> &nbsp; 
                                                    <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;
                                                        <i class="fa fa-times-circle"></i>
                                                    </a>
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
                        <div class="table-responsive mtl">
                            <table id="table-title-slider" class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="1%"><input type="checkbox" onclick="$('input[type=checkbox]').prop('checked', $(this).is(':checked'))" /></th>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($category) && !empty($category))
                                        @foreach ($category as $key => $value)
                                            <tr>
                                                <td>
                                                    <input data="{{$value->id}}" type="checkbox" class="mooncake-mod-checkbox"/>
                                                </td>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td><span class="label label-sm label-{{ $value->status =='Active'? 'success': 'danger' }}">{{ $value->status }}</span></td>
                                                <td>
                                                    <a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-category{{ $key }}" data-toggle="modal" title="Edit">
                                                        <span class="label label-sm label-success">
                                                            <i class="fa fa-pencil"></i>
                                                        </span>
                                                    </a>
                                                    <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-cat{{ $key }}" data-toggle="modal">
                                                        <span class="label label-sm label-red">
                                                            <i class="fa fa-trash-o"></i>
                                                        </span>
                                                    </a>
                                                    <!--Modal Edit banner start-->
                                                    <div id="modal-edit-category{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                                            <div class="modal-dialog modal-wide-width">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                                                        <h4 id="modal-login-label3" class="modal-title"> Edit Gallery</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form">
                                                                            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ url('/web88cms/category') }}">
                                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label">Status</label>
                                                                                    <div class="col-md-6">
                                                                                        <div data-on="success" data-off="primary"class="make-switch">
                                                                                            @if ($value->status == "Active")
                                                                                                <input name="status" type="checkbox" checked="checked"/>
                                                                                            @else
                                                                                                <input name="status" type="checkbox"/>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group has-error">
                                                                                    <label class="col-md-3 control-label">Title <span class="require">*</span></label>
                                                                                    <div class="col-md-6">
                                                                                        <input name="name" required="required" type="text" class="form-control" placeholder="eg. Apartment" value="{{$value->name}}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="clearfix"></div>
                                                                                <input type="hidden" value="{{$value->id}}" name="key"/>
                                                                                <div class="form-actions">
                                                                                    <div class="col-md-offset-5 col-md-8">
                                                                                        <button type="submit" class="btn btn-red">Save &nbsp;
                                                                                            <i class="fa fa-floppy-o"></i>
                                                                                        </button> &nbsp; 
                                                                                        <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;
                                                                                            <i class="glyphicon glyphicon-ban-circle"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--END MODAL Edit promotion-->
                                                    <!--Modal delete start-->
                                                    <div id="modal-delete-cat{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                                                    <h4 id="modal-login-label4" class="modal-title">
                                                                        <a href="">
                                                                            <i class="fa fa-exclamation-triangle"></i>
                                                                        </a>
                                                                        Are you sure you want to delete this category? 
                                                                    </h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>#{{$value->id}} :</strong> {{$value->name}} </p>
                                                                    <div class="form-actions">
                                                                        <div class="col-md-offset-4 col-md-8">
                                                                            <form action="{{ url('/web88cms/category_del') }}" method="post">
                                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                                                <input type="hidden" value="{{$value->id}}" name="keys"/>
                                                                                <button type="submit" class="btn btn-red">Yes &nbsp;
                                                                                    <i class="fa fa-check"></i>
                                                                                </button> &nbsp; 
                                                                                <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;
                                                                                    <i class="fa fa-times-circle"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- modal delete end -->
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8"></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="clearfix"></div>
                        </div>
                        <!-- end table responsive -->
                    </div>
                    <br/>
                    <hr/>
                    <!-- // Gallery -->
                    <div class="portlet">
                        <div class="portlet-header">
                            <div class="caption">Gallery Listing</div>
                            <br/>
                            <p class="margin-top-10px"></p>
                            <a href="#" data-target="#modal-add-gallery" data-toggle="modal" class="btn btn-success">Add New&nbsp;
                                <i class="fa fa-plus"></i>
                            </a>&nbsp;
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary">Delete</button>
                                <button type="button" data-toggle="dropdown" class="btn btn-red dropdown-toggle">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul role="menu" class="dropdown-menu">
                                    <li>
                                        <a href="#" id="dellselobjapp1">Delete selected item(s)</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#" data-target="#modal-delete-all1" data-toggle="modal">Delete all</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tools">
                                <i class="fa fa-chevron-up"></i>
                            </div>


                            
                            <!--Modal Add New start-->
                            <div id="modal-add-gallery" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog modal-wide-width">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label3" class="modal-title">Add New Gallery</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form">
                                                <form action="{{ URL('/web88cms/gallery')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Status</label>
                                                        <div class="col-md-6">
                                                            <div data-on="success" data-off="primary"class="make-switch">
                                                                <input type="checkbox" name="status" checked="checked"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-error">
                                                        <label class="col-md-3 control-label">Title <span class="require">*</span></label>
                                                        <div class="col-md-6">
                                                            <input name="name" required="required" type="text" class="form-control" placeholder="eg. Apartment">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Category</label>
                                                        <div class="col-md-6">
                                                            <select class="form-control" required="required" name="category_id">
                                                                <option>- Select a category -</option>
                                                                @foreach($category as $key)
                                                                    <option value="{{$key->id}}">{{$key->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> 
                                                    </div> 
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Upload Image <span class="require">*</span></label>
                                                        <div class="col-md-9">
                                                        <div class="text-15px margin-top-10px">
                                                            <input name="sm_file" required="required" id="exampleInputFile2" type="file">
                                                            <br>
                                                            <span class="help-block">(Image dimension: 360 x 314 pixels, JPEG/GIF/PNG only, Max. 1MB) </span> </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Upload Enlarge Image</label>
                                                        <div class="col-md-9">
                                                            <input name="lg_file" required="required" id="exampleInputFile2" type="file">
                                                            <br>
                                                            <span class="help-block">(JPEG/GIF/PNG only, Max. 2MB) </span> 
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="form-actions">
                                                        <div class="col-md-offset-5 col-md-8"> 
                                                            <button type="submit" class="btn btn-red">Save &nbsp;<i class="fa fa-floppy-o"></i></button>&nbsp; 
                                                            <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END MODAL Add New banner -->
                            <div id="modal-select-confirm1" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close"> × </button>
                                            <h4 class="modal-title">
                                                <a href="">
                                                    <i class="fa fa-exclamation-triangle" style="color:#2598b0"></i>
                                                </a> Please select at least one item.
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-danger"> Please select at least one item to delete. </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal select confirm -->
                            <form class="delete_text_objective1 form-horizontal" action="{{ url('/web88cms/gallery_selected_del') }}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                <input type="hidden" name="index">
                            </form>
                            <!--Modal delete selected items start-->
                            <div id="modal-delete-selected1" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label4" class="modal-title">
                                                <a href="">
                                                    <i class="fa fa-exclamation-triangle"></i>
                                                </a> Are you sure you want to delete the selected item(s)? 
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-actions">
                                                <div class="col-md-offset-4 col-md-8">
                                                    <a href="#" id="dellselobj1" class="btn btn-red">Yes &nbsp;
                                                        <i class="fa fa-check"></i>
                                                    </a>&nbsp; 
                                                    <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;
                                                        <i class="fa fa-times-circle"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal delete selected items end -->
                            <!--Modal delete all items start-->
                            <div id="modal-delete-all1" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                            <h4 id="modal-login-label4" class="modal-title">
                                                <a href="">
                                                    <i class="fa fa-exclamation-triangle"></i>
                                                </a> Are you sure you want to delete all items? 
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-actions">
                                                <div class="col-md-offset-4 col-md-8">
                                                    <form action="{{ url('/web88cms/gallery_all_del') }}" method="POST">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                        <input type="hidden" name="chk" value="1">
                                                            <button type="submit" class="btn btn-red">Yes &nbsp;
                                                                <i class="fa fa-check"></i>
                                                            </button> &nbsp; 
                                                            <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;
                                                                <i class="fa fa-times-circle"></i>
                                                            </a>
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
                            <div class="clearfix"></div>
                            <div class="portlet-body">
                                <div class="table-responsive mtl">

                                    <?php                     
                                    if(sizeof($gallery) > 0)
                                    {
                                         // echo http_build_query(Input::get());
                                     
                                     $arr_get = Input::get();
                                     unset($arr_get['page']);
                                     $query_string = http_build_query($arr_get);
                                     
                                     $per_page_records = (Session::has('gallery.per_page')) ? Session::get('gallery.per_page') : 100;
                                     
                                     ?>
                                     <div class="form-inline pull-left">
                                      <div class="form-group">
                                        <select name="select" class="form-control" onchange="set_per_limit(this.value)">                      <option <?php if($per_page_records == 10){ echo 'selected="selected"'; } ?>>10</option>
                                          <option <?php if($per_page_records == 20){ echo 'selected="selected"'; } ?>>20</option>
                                          <option <?php if($per_page_records == 30){ echo 'selected="selected"'; } ?>>30</option>
                                          <option <?php if($per_page_records == 50){ echo 'selected="selected"'; } ?>>50</option>
                                          <option <?php if($per_page_records == 100){ echo 'selected="selected"'; } ?>>100</option>
                                        </select>
                                        &nbsp;
                                        <label class="control-label">Records per page</label>
                                      </div>                    
                                    </div>
                                <?php } ?>    


                                    <table id="table-title-slider1" class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th width="1%"><input type="checkbox" onclick="$('input[type=checkbox]').prop('checked', $(this).is(':checked'))" /></th>
                                                <th>#</th>
                                                <th>Status</th>  
                                                <th>Title</th>  
                                                <!-- <th>Category</th> -->
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>                                                
                                        <tbody>
                                            @if(isset($gallery) && !empty($gallery))
                                                @foreach ($gallery as $key => $value)
                                                <tr>
                                                    <td>
                                                        <input data="{{$value->id}}" type="checkbox" class="mooncake-mod-checkbox1"/>
                                                    </td>
                                                    <td>{{ $value->id }}</td>
                                                    <td><span class="label label-sm label-{{ $value->status =='Active'? 'success': 'danger' }}">{{ $value->status }}</span></td>
                                                    <td>{{ $value->name }}</td>
                                                    <!-- <td>{{ $value->category_id }}</td> -->
                                                    <td><img src="{{ asset('public/front/images/gallery/' .$value->sm_image) }}" alt="{{ $value->name }}" class="img-responsive" width="100px"></td>
                                                    <td>
                                                        <a href="#" data-hover="tooltip" data-placement="top" data-target="#modal-edit-gallery{{ $key }}" data-toggle="modal" title="Edit">
                                                            <span class="label label-sm label-success">
                                                                <i class="fa fa-pencil"></i>
                                                            </span>
                                                        </a>
                                                        <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-{{ $key }}" data-toggle="modal">
                                                            <span class="label label-sm label-red">
                                                                <i class="fa fa-trash-o"></i>
                                                            </span>
                                                        </a>
                                                        <!--Modal Edit banner start-->
                                                        <div id="modal-edit-gallery{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                                            <div class="modal-dialog modal-wide-width">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                                                        <h4 id="modal-login-label3" class="modal-title"> Edit Gallery</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form">
                                                                            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ url('/web88cms/gallery') }}">
                                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label">Status</label>
                                                                                    <div class="col-md-6">
                                                                                        <div data-on="success" data-off="primary"class="make-switch">
                                                                                            @if ($value->status == "Active")
                                                                                                <input name="status" type="checkbox" checked="checked"/>
                                                                                            @else
                                                                                                <input name="status" type="checkbox"/>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group has-error">
                                                                                    <label class="col-md-3 control-label">Title <span class="require">*</span></label>
                                                                                    <div class="col-md-6">
                                                                                        <input name="name" required="required" type="text" class="form-control" placeholder="eg. Apartment" value="{{$value->name}}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label">Category</label>
                                                                                    <div class="col-md-6">
                                                                                        <select class="form-control" required="required" name="category_id">
                                                                                            <option>- Select Category -</option>
                                                                                            @foreach($category as $k)
                                                                                                <option <?= $value->id == $k->id ?'selected':''?> value="{{$k->id}}">{{$k->name}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label">Upload Small Image</label>
                                                                                    <div class="col-md-9">
                                                                                        <div class="text-15px margin-top-10px">
                                                                                            <?php if($value->sm_image){?>
                                                                                                <img src="<?= "https://" . $_SERVER['HTTP_HOST'] . '/public/front/images/gallery/', $value->sm_image?>" width='150' alt="Image" class="img-responsive"> <br/>
                                                                                                <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-image{{ $key }}" data-toggle="modal">
                                                                                                    <span class="label label-sm label-red">
                                                                                                        <i class="fa fa-trash-o"></i>
                                                                                                    </span>
                                                                                                </a>
                                                                                                <div class="clearfix"></div>
                                                                                                <br/>
                                                                                            <?php }?>
                                                                                            <input name="sm_file" id="exampleInputFile" type="file"/>
                                                                                            <br/>
                                                                                            <span class="help-block">(JPEG/GIF/PNG only, Max. 2MB) </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label">Upload large Image</label>
                                                                                    <div class="col-md-9">
                                                                                            <?php if($value->lg_image){?>
                                                                                                <img src="<?= "https://" . $_SERVER['HTTP_HOST'] . '/public/front/images/gallery/', $value->lg_image?>" width="150" alt="Image" class="img-responsive"> <br/>
                                                                                                <a href="#" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-image{{ $key }}" data-toggle="modal">
                                                                                                    <span class="label label-sm label-red">
                                                                                                        <i class="fa fa-trash-o"></i>
                                                                                                    </span>
                                                                                                </a>
                                                                                                <div class="clearfix"></div>
                                                                                                <br/>
                                                                                            <?php }?>
                                                                                        <input name="lg_file" id="exampleInputFile2" type="file">
                                                                                        <br>
                                                                                        <span class="help-block">(JPEG/GIF/PNG only, Max. 2MB) </span> 
                                                                                    </div>
                                                                                </div>
                                                                                <div class="clearfix"></div>
                                                                                <input type="hidden" value="{{$value->id}}" name="key"/>
                                                                                <div class="form-actions">
                                                                                    <div class="col-md-offset-5 col-md-8">
                                                                                        <button type="submit" class="btn btn-red">Save &nbsp;
                                                                                            <i class="fa fa-floppy-o"></i>
                                                                                        </button> &nbsp; 
                                                                                        <a href="#" data-dismiss="modal" class="btn btn-green">Cancel &nbsp;
                                                                                            <i class="glyphicon glyphicon-ban-circle"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--END MODAL Edit promotion-->
                                                        <!--Modal delete start-->
                                                        <div id="modal-delete-{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                                                        <h4 id="modal-login-label4" class="modal-title">
                                                                            <a href="">
                                                                                <i class="fa fa-exclamation-triangle"></i>
                                                                            </a>
                                                                            Are you sure you want to delete this promotion? 
                                                                        </h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p><strong>#{{$value->id}} :</strong> {{$value->name}} </p>
                                                                        <div class="form-actions">
                                                                            <div class="col-md-offset-4 col-md-8">
                                                                                <form action="{{ url('/web88cms/gallery_del') }}" method="post">
                                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                                                    <input type="hidden" value="{{$value->id}}" name="keys"/>
                                                                                    <button type="submit" class="btn btn-red">Yes &nbsp;
                                                                                        <i class="fa fa-check"></i>
                                                                                    </button> &nbsp; 
                                                                                    <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;
                                                                                        <i class="fa fa-times-circle"></i>
                                                                                    </a>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form class="t_icon_del form-horizontal" method="post" action="{{ url('/web88cms/gallery_del_img') }}">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                            <input type="hidden" name="img_path">
                                                        </form>
                                                        <!-- modal delete end -->
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                <div class="tool-footer text-right">
                                    <p class="pull-left"><?php echo "Showing ".$gallery->firstItem()." to ".$gallery->lastItem()." of ". $gallery->total() ." entries"; ?></p>
                        
                                     <?php echo $gallery->setPath(Request::url())->appends(Input::get())->render(); ?>
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
    </div>
    <div class="page-footer">
        <div class="copyright">
            <span class="text-15px">2015 &copy; 
                <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact 
                <a href="mailto:support@webqom.com">Webqom Support</a>.
            </span>
            <div class="pull-right">
                <img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies Sdn Bhd">
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

        // Gallery

        $('#dellselobjapp1').on('click', function () {
            if ($('.mooncake-mod-checkbox1:checked').length == 0) {
                $("#modal-select-confirm1").modal();
            } else {
                $("#modal-delete-selected1").modal();
            }
        });
        // Del select objective
        $('#dellselobj1').click(function (e) {
            e.preventDefault();
            var str = '';
            $("#table-title-slider1 td:first-child input:checked").each(function (i, e) {
                str += $(e).attr('data') + ",";
            });
            $('.delete_text_objective1 > input[name=index]').val(str);
            $('.delete_text_objective1').submit();
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
                page : 'gallery'
            },
            function(data,status){
                //alert("Status: " + status);
                document.getElementById('saved').style.display='block';
                window.location.reload();

            });
        }

        function set_per_limit(value){
            window.location.href = base_url + 'web88cms/gallery_list?per_page='+value;
        }

    </script>
@endsection
