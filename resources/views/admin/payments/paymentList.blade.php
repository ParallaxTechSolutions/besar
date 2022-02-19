<?php
/* print_r($data);
exit; */
?>
@extends('adminLayout')
@section('title', 'View All Bookings')
@section('content')
<div id="page-wrapper">
    <!--BEGIN PAGE HEADER & BREADCRUMB-->

    <div class="page-header-breadcrumb">
        <div class="page-heading hidden-xs">
            <h1 class="page-title">Global Setup</h1>
        </div>

        <ol class="breadcrumb page-breadcrumb">
            <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.html">Dashboard</a>&nbsp; <i
                    class="fa fa-angle-right"></i>&nbsp;</li>
            <li>Global Setup &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li class="active">Payment Gateways - Listing</li>
        </ol>
    </div>
    <!--END PAGE HEADER & BREADCRUMB-->
    <!--BEGIN CONTENT-->

    <div class="page-content">
        <div class="row">
            <div class="col-lg-12">
                @if (isset($success) && $success)
                <div class="alert alert-success alert-dismissable">
                    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                    <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                    <p>{{ $success }}</p>
                </div>
            @endif

            @if (isset($warning) && $warning)
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                    <i class="fa fa-times-circle"></i> <strong>Error!</strong>
                    <p>{{ $warning }}</p>
                </div>
            @endif

                @if (isset($last_updated) && $last_updated)
	                <div class="pull-left"> Last updated: <span class="text-blue">{{ $last_updated }}</span> </div>
    	            <div class="clearfix"></div>
        	        <p></p>
                @endif
                <div class="clearfix"></div>
            </div>
            <!-- end col-lg-12 -->
            <div class="col-lg-12">
                <div class="portlet">
                    <div class="portlet-header">
                        <div class="caption">Payment Gateways Listing</div>
                        <div class="clearfix"></div>
                        <p class="margin-top-10px"></p>
                        <!--<a href="#" class="btn btn-success" data-target="#modal-add-rate" data-toggle="modal">Add New Rate &nbsp;<i class="fa fa-plus"></i></a>&nbsp;-->

                    	<div class="tools"> <i class="fa fa-chevron-up"></i> </div>

                        <div id="modal-delete-selected" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                        <h4 id="modal-login-label3" class="modal-title"><a href="#"><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete the selected item(s)? </h4>
                                    </div>

                                    <div class="modal-body">
                                    	<div class="form-actions">
    		                                <div class="col-md-offset-4 col-md-8">
                                            	<a href="#" onclick="deletePromocodes($(this), 'selected')" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp;
                                                <a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
	                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $limit=10;?>

                        <div id="modal-delete-all" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                    	<h4 id="modal-login-label3" class="modal-title"><a href="#"><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete all items? </h4>
                                    </div>
                                    <div class="modal-body">
	                                    <div class="form-actions">
    		                                <div class="col-md-offset-4 col-md-8">
                                            	<a href="#" onclick="deletePromocodes($(this), 'all')" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp;
                                            	<a href="#" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a>
                                            </div>
	                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         
                        {{-- <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                        <!--Modal add new rate start-->
                        <div id="modal-add-rate" tabindex="-1" role="dialog" aria-labelledby="modal-login-label"
                            aria-hidden="true" class="modal fade">
                            <div class="modal-dialog modal-wide-width">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" data-dismiss="modal" aria-hidden="true"
                                            class="close">&times;</button>
                                        <h4 id="modal-login-label3" class="modal-title">Add New Rate</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form">
                                            <form class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Status <span
                                                            class="text-red">*</span></label>
                                                    <div class="col-md-6">
                                                        <div data-on="success" data-off="primary" class="make-switch">
                                                            <input type="checkbox" checked="checked" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Name <span
                                                            class="text-red">*</span></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control"
                                                            placeholder="eg. GST Rate">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputFirstName" class="col-md-3 control-label">Rate
                                                        <span class="text-red">*</span></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" placeholder="">
                                                        <div class="xs-margin"></div>
                                                        <select name="select" class="form-control">
                                                            <option value="%">%</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    <div class="col-md-offset-5 col-md-8"> <a href="#"
                                                            class="btn btn-red">Save &nbsp;<i
                                                                class="fa fa-floppy-o"></i></a>&nbsp; <a href="#"
                                                            data-dismiss="modal" class="btn btn-green">Cancel &nbsp;<i
                                                                class="glyphicon glyphicon-ban-circle"></i></a> </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--END MODAL add new discount -->
                        <!--Modal delete selected items start-->
                        <div id="modal-delete-selected" tabindex="-1" role="dialog" aria-labelledby="modal-login-label"
                            aria-hidden="true" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" data-dismiss="modal" aria-hidden="true"
                                            class="close">&times;</button>
                                        <h4 id="modal-login-label4" class="modal-title"><a href=""><i
                                                    class="fa fa-exclamation-triangle"></i></a> Are you sure you want to
                                            delete the selected item(s)? </h4>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>#1:</strong> PayPal</p>
                                        <div class="form-actions">
                                            <div class="col-md-offset-4 col-md-8"> <a href="#" class="btn btn-red">Yes
                                                    &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#"
                                                    data-dismiss="modal" class="btn btn-green">No &nbsp;<i
                                                        class="fa fa-times-circle"></i></a> </div>
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
                                                    class="fa fa-exclamation-triangle"></i></a> Are you sure you want to
                                            delete all items? </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-actions">
                                            <div class="col-md-offset-4 col-md-8"> <a href="#" class="btn btn-red">Yes
                                                    &nbsp;<i class="fa fa-check"></i></a>&nbsp; <a href="#"
                                                    data-dismiss="modal" class="btn btn-green">No &nbsp;<i
                                                        class="fa fa-times-circle"></i></a> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- modal delete all items end -->
                    </div>
                    <div class="portlet-body">

                        <div class="clearfix"></div>
                        <div class="table-responsive mtl">
                            <table id="example1" class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="1%"><input type="checkbox" /></th>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th><a href="#sort by name">Name</a></th>
                                        <th><a href="#sort by status">Status</a></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="checkbox" /></td>
                                        <td>1</td>
                                        <td>{{$data[0]->id}}</td>
                                        <td>{{$data[0]->Name}}</td>
                                    <td><span class="label {{($data[0]->status == '0') ? 'label-red' : 'label-success'}} label-xs ">{{($data[0]->status == '0') ? 'In-Active' : 'Active'}}</span></td>
                                        <td><a href="#" data-hover="tooltip" data-placement="top" title="Edit"
                                                data-target="#modal-edit-paypal" data-toggle="modal"><span
                                                    class="label label-sm label-success"><i
                                                        class="fa fa-pencil"></i></span></a> <a href="#"
                                                data-hover="tooltip" data-placement="top" title="Delete"
                                                data-target="#modal-delete-1" data-toggle="modal"><span
                                                    class="label label-sm label-red"><i
                                                        class="fa fa-trash-o"></i></span></a>
                                            <!--Modal edit paypal start-->
                                            <div id="modal-edit-paypal" tabindex="-1" role="dialog"
                                                aria-labelledby="modal-login-label" aria-hidden="true"
                                                class="modal fade">
                                                <div class="modal-dialog modal-wide-width">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" data-dismiss="modal"
                                                                aria-hidden="true" class="close">&times;</button>
                                                            <h4 id="modal-login-label3" class="modal-title">Edit PayPal
                                                            </h4>
                                                        </div>
                                                        <?php $content=json_decode($data[0]->content) ?>
                                                        <div class="modal-body">
                                                            <div class="form">
                                                                <form class="form-horizontal" method="POST" action="/web88cms/paymentGateWays/update/{{$data[0]->id}}" >
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Status
                                                                            <span class="text-red">*</span></label>
                                                                        <div class="col-md-6">
                                                                            <div data-on="success" data-off="primary" class="make-switch">
                                                                                <input name='status' type="checkbox" {{($data[0]->status=='1')?'checked':''}} />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Name <span
                                                                                class="text-red">*</span></label>
                                                                        <div class="col-md-6">
                                                                            <input type="text" name='name' class="form-control"
                                                                                placeholder="" value="{{(isset($data[0]->Name))?$data[0]->Name:''}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="inputFirstName"
                                                                            class="col-md-3 control-label">Type <span
                                                                                class="text-red">*</span></label>
                                                                        <div class="col-md-6">
                                                                            <div class="xss-margin"></div>
                                                                            <div class="checkbox-list">
                                                                                <label><input id="sand"
                                                                                        type="radio" name='paypalType' value="sandbox"
                                                                                        {{($content->paypalType=='sandbox')?'checked':''}} />&nbsp;
                                                                                    Sandbox</label>
                                                                                <label><input name='paypalType' id="prod"
                                                                                        type="radio"
                                                                                        value="production" {{($content->paypalType=='production')?'checked':''}} />&nbsp;
                                                                                    Production</label>

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group" id='sandBox'>
                                                                        <label class="col-md-3 control-label">Sandbox
                                                                            Code</label>
                                                                        <div class="col-md-9">
                                                                            <input type="text"  name='sandBox' class="form-control"
                                                                                placeholder="eg. AdJBPGNCfzPpaMFZ4SoGvJ8hr4tZpIQDkWMQA5dZ_db4keNRW9S1Ub1o6BFjUwqoGwFuodh9eykC5SoQ"
                                                                        value="{{$content->sandBox}}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group" id='productionCode'>
                                                                        <label class="col-md-3 control-label">Production
                                                                            Code</label>
                                                                        <div class="col-md-9">
                                                                        <input type="text" name='productionCode' id='productionCode' value="{{$content->productionCode}}" class="form-control"
                                                                                placeholder="eg. ATd4Ypl-uEcq8TyWxf2yzkxCn2-Bo14eM1_KShitd0gjC7ntnmKrYD0LO2WEvBt-ErQTb9GFquzIXMKr">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-actions">
                                                                        <div class="col-md-offset-5 col-md-8"> <button type="submit"
                                                                                 class="btn btn-red"  id='btnFormSave'>Save
                                                                                &nbsp;<i
                                                                                    class="fa fa-floppy-o"></i></button>&nbsp;
                                                                            <a href="#" data-dismiss="modal"
                                                                                class="btn btn-green">Cancel &nbsp;<i
                                                                                    class="glyphicon glyphicon-ban-circle"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--END MODAL edit payapl -->
                                            <!--Modal delete start-->
                                            <div id="modal-delete-1" tabindex="-1" role="dialog"
                                                aria-labelledby="modal-login-label" aria-hidden="true"
                                                class="modal fade">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" data-dismiss="modal"
                                                                aria-hidden="true" class="close">&times;</button>
                                                            <h4 id="modal-login-label4" class="modal-title"><a
                                                                    href=""><i
                                                                        class="fa fa-exclamation-triangle"></i></a> Are
                                                                you sure you want to delete this item? </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>#01:</strong> PayPal</p>
                                                            <div class="form-actions">
                                                                <div class="col-md-offset-4 col-md-8"> <a href="#"
                                                                        class="btn btn-red">Yes &nbsp;<i
                                                                            class="fa fa-check"></i></a>&nbsp; <a
                                                                        href="#" data-dismiss="modal"
                                                                        class="btn btn-green">No &nbsp;<i
                                                                            class="fa fa-times-circle"></i></a> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- modal delete end -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" /></td>
                                        <td>2</td>
                                        <td>{{$data[1]->id}}</td>
                                        <td>{{$data[1]->Name}}</td>
                                        <td><span class="label {{($data[1]->status == '0') ? 'label-red' : 'label-success'}} label-xs ">{{($data[1]->status == '0') ? 'In-Active' : 'Active'}}</span></td>
                                        <td><a href="#" data-hover="tooltip" data-placement="top" title="Edit"
                                                data-target="#modal-edit-ipay88" data-toggle="modal"><span
                                                    class="label label-sm label-success"><i
                                                        class="fa fa-pencil"></i></span></a> <a href="#"
                                                data-hover="tooltip" data-placement="top" title="Delete"
                                                data-target="#modal-delete-1" data-toggle="modal"><span
                                                    class="label label-sm label-red"><i
                                                        class="fa fa-trash-o"></i></span></a>
                                            <!--Modal edit ipay88 start-->
                                            <div id="modal-edit-ipay88" tabindex="-1" role="dialog"
                                                aria-labelledby="modal-login-label" aria-hidden="true"
                                                class="modal fade">
                                                <div class="modal-dialog modal-wide-width">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" data-dismiss="modal"
                                                                aria-hidden="true" class="close">&times;</button>
                                                            <h4 id="modal-login-label3" class="modal-title">Edit Ipay88
                                                            </h4>
                                                        </div>
                                                        <?php $content=json_decode($data[1]->content);?>
                                                        <div class="modal-body">
                                                            <div class="form">
                                                                <form class="form-horizontal"  method="POST" action="/web88cms/paymentGateWays/update/{{$data[1]->id}}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Status
                                                                            <span class="text-red">*</span></label>
                                                                        <div class="col-md-6">
                                                                            <div data-on="success" data-off="primary"
                                                                                class="make-switch">
                                                                                <input name="status" type="checkbox"
                                                                                {{($data[2]->status=='1')?'checked':''}} />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Name <span
                                                                                class="text-red">*</span></label>
                                                                        <div class="col-md-6">
                                                                            <input type="text" required name="name" class="form-control"
                                                                                placeholder="" value="{{$content->name}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Merchant
                                                                            Code</label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" name='merchantCode' class="form-control"
                                                                                placeholder="eg. M07198" value="{{$content->merchantCode}}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Merchant
                                                                            Key</label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" name="merchantKey" class="form-control"
                                                                                placeholder="eg. IDqHDFhHiQ"
                                                                                value="{{$content->merchantKey}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-actions">
                                                                        <div class="col-md-offset-5 col-md-8"> <button
                                                                                href="#" class="btn btn-red">Save
                                                                                &nbsp;<i
                                                                                    class="fa fa-floppy-o"></i></button>&nbsp;
                                                                            <a href="#" data-dismiss="modal"
                                                                                class="btn btn-green">Cancel &nbsp;<i
                                                                                    class="glyphicon glyphicon-ban-circle"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--END MODAL edit ipay88 -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" /></td>
                                        <td>3</td>
                                        <td>{{$data[2]->id}}</td>
                                        <td>{{$data[2]->Name}}</td>
                                        <td><span class="label {{($data[2]->status == '0') ? 'label-red' : 'label-success'}} label-xs ">{{($data[2]->status == '0') ? 'In-Active' : 'Active'}}</span></td>
                                        <td><a href="#" data-hover="tooltip" data-placement="top" title="Edit"
                                                data-target="#modal-edit-eGHL" data-toggle="modal"><span
                                                    class="label label-sm label-success"><i
                                                        class="fa fa-pencil"></i></span></a> <a href="#"
                                                data-hover="tooltip" data-placement="top" title="Delete"
                                                data-target="#modal-delete-1" data-toggle="modal"><span
                                                    class="label label-sm label-red"><i
                                                        class="fa fa-trash-o"></i></span></a>
                                            <!--Modal edit eGHL start-->
                                            <div id="modal-edit-eGHL" tabindex="-1" role="dialog"
                                                aria-labelledby="modal-login-label" aria-hidden="true"
                                                class="modal fade">
                                                <div class="modal-dialog modal-wide-width">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" data-dismiss="modal"
                                                                aria-hidden="true" class="close">&times;</button>
                                                            <h4 id="modal-login-label3" class="modal-title">Edit eGHL
                                                            </h4>
                                                        </div>
                                                        <?php $content=json_decode($data[2]->content);?>
                                                        <div class="modal-body">
                                                            <div class="form">
                                                                <form class="form-horizontal" method="POST" action="/web88cms/paymentGateWays/update/{{$data[2]->id}}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Status
                                                                            <span class="text-red">*</span></label>
                                                                        <div class="col-md-6">
                                                                            <div data-on="success" data-off="primary"
                                                                                class="make-switch">
                                                                                <input type="checkbox"
                                                                                {{($data[2]->status=='1')?'checked':''}} name='status' />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Name <span
                                                                                class="text-red">*</span></label>
                                                                        <div class="col-md-6">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="" name="name" value="{{$content->name}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Merchant
                                                                            ID</label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="eg. sit" name="merchantId" value="{{$content->merchantId}}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Merchant
                                                                            Password</label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" name="merchantPassword" class="form-control"
                                                                                placeholder="eg. sit12345"
                                                                                value="{{$content->merchantPassword}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-actions">
                                                                        <div class="col-md-offset-5 col-md-8"> <button
                                                                                href="#" class="btn btn-red">Save
                                                                                &nbsp;<i
                                                                                    class="fa fa-floppy-o"></i></button>&nbsp;
                                                                            <a href="#" data-dismiss="modal"
                                                                                class="btn btn-green">Cancel &nbsp;<i
                                                                                    class="glyphicon glyphicon-ban-circle"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--END MODAL edit eGHL -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" /></td>
                                        <td>4</td>
                                        <td>{{$data[3]->id}}</td>
                                        <td>{{$data[3]->Name}}</td>
                                        <td><span class="label {{($data[3]->status == '0') ? 'label-red' : 'label-success'}} label-xs ">{{($data[3]->status == '0') ? 'In-Active' : 'Active'}}</span></td>
                                        <td><a href="#" data-hover="tooltip" data-placement="top" title="Edit"
                                                data-target="#modal-edit-directbankin" data-toggle="modal"><span
                                                    class="label label-sm label-success"><i
                                                        class="fa fa-pencil"></i></span></a> <a href="#"
                                                data-hover="tooltip" data-placement="top" title="Delete"
                                                data-target="#modal-delete-1" data-toggle="modal"><span
                                                    class="label label-sm label-red"><i
                                                        class="fa fa-trash-o"></i></span></a>
                                            <!--Modal edit eGHL start-->
                                            <div id="modal-edit-directbankin" tabindex="-1" role="dialog"
                                                aria-labelledby="modal-login-label" aria-hidden="true"
                                                class="modal fade">
                                                <div class="modal-dialog modal-wide-width">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" data-dismiss="modal"
                                                                aria-hidden="true" class="close">&times;</button>
                                                            <h4 id="modal-login-label3" class="modal-title">Edit Direct
                                                                Bank In / Online Transfer</h4>
                                                        </div>
                                                        <?php $content=json_decode($data[3]->content);?>
                                                        <div class="modal-body">
                                                            <div class="form">
                                                                <form class="form-horizontal" method="POST" action="/web88cms/paymentGateWays/update/{{$data[3]->id}}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Status
                                                                            <span class="text-red">*</span></label>
                                                                        <div class="col-md-6">
                                                                            <div data-on="success" data-off="primary"
                                                                                class="make-switch">
                                                                                <input name="status" type="checkbox"
                                                                                {{($data[3]->status=='1')?'checked':''}} />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Name <span
                                                                                class="text-red">*</span></label>
                                                                        <div class="col-md-6">
                                                                            <input type="text" name="name" class="form-control"
                                                                                placeholder=""
                                                                                value="{{$content->name}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Payee To /
                                                                            Bank Account Name</label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" name="accountName" class="form-control"
                                                                                placeholder="eg. Tower Regency Hotel And Apartments"
                                                                                value="{{$content->accountName}}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Bank
                                                                        </label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" name="bank" class="form-control"
                                                                                placeholder="eg. Maybank Bhd"
                                                                                value="{{$content->bank}}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Bank
                                                                            Account Number </label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" name="accountNumber" class="form-control"
                                                                                placeholder="eg. 558 163 509 129"
                                                                                value="{{$content->accountNumber}}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Swift Code
                                                                        </label>
                                                                        <div class="col-md-9">
                                                                            <input type="text" name="swiftCode" class="form-control"
                                                                                placeholder="eg. TT12345"
                                                                                value="{{$content->swiftCode}}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-actions">
                                                                        <div class="col-md-offset-5 col-md-8"> <button
                                                                                href="#" class="btn btn-red">Save
                                                                                &nbsp;<i
                                                                                    class="fa fa-floppy-o"></i></button>&nbsp;
                                                                            <a href="#" data-dismiss="modal"
                                                                                class="btn btn-green">Cancel &nbsp;<i
                                                                                    class="glyphicon glyphicon-ban-circle"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--END MODAL edit direct bankin -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" /></td>
                                        <td>5</td>
                                        <td>{{$data[4]->id}}</td>
                                        <td>{{$data[4]->Name}}</td>
                                        <td><span class="label {{($data[4]->status == '0') ? 'label-red' : 'label-success'}} label-xs ">{{($data[4]->status == '0') ? 'In-Active' : 'Active'}}</span></td>
                                        <td><a href="#" data-hover="tooltip" data-placement="top" title="Edit"
                                                data-target="#modal-edit-creditcard" data-toggle="modal"><span
                                                    class="label label-sm label-success"><i
                                                        class="fa fa-pencil"></i></span></a> <a href="#"
                                                data-hover="tooltip" data-placement="top" title="Delete"
                                                data-target="#modal-delete-1" data-toggle="modal"><span
                                                    class="label label-sm label-red"><i
                                                        class="fa fa-trash-o"></i></span></a>
                                            <!--Modal edit paypal start-->
                                            <div id="modal-edit-creditcard" tabindex="-1" role="dialog"
                                                aria-labelledby="modal-login-label" aria-hidden="true"
                                                class="modal fade">
                                                <div class="modal-dialog modal-wide-width">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" data-dismiss="modal"
                                                                aria-hidden="true" class="close">&times;</button>
                                                            <h4 id="modal-login-label3" class="modal-title">Edit Credit
                                                                Card</h4>
                                                        </div>
                                                        <?php $content=json_decode($data[4]->content);?>
                                                        <div class="modal-body">
                                                            <div class="form">
                                                                <form class="form-horizontal" method="POST" action="/web88cms/paymentGateWays/update/{{$data[4]->id}}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Status
                                                                            <span class="text-red">*</span></label>
                                                                        <div class="col-md-6">
                                                                            <div data-on="success" data-off="primary"
                                                                                class="make-switch">
                                                                                <input type="checkbox"
                                                                        {{($data[4]->status=='1')?'checked':''}} name="status" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Name <span
                                                                                class="text-red">*</span></label>
                                                                        <div class="col-md-6">
                                                                            <input type="text" name="name" class="form-control"
                                                                                placeholder="" value="{{$data[4]->Name}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="inputFirstName"
                                                                            class="col-md-3 control-label">Enable Card
                                                                            Type <span class="text-red">*</span></label>
                                                                        <div class="col-md-6">
                                                                            <div class="xss-margin"></div>
                                                                            <div class="checkbox-list">
                                                                                <label><input id="inlineCheckbox6"
                                                                                        type="checkbox" name="visaCard"  value="1"
                                                                                {{(isset($content->visaCard))?"checked":''}} />&nbsp;
                                                                                    Visa</label>
                                                                                <label><input id="inlineCheckbox7"
                                                                                        type="checkbox" name="masterType" value="1"
                                                                                        {{(isset($content->masterType))?"checked":''}} />&nbsp;
                                                                                    Mastercard</label>

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-actions">
                                                                        <div class="col-md-offset-5 col-md-8"> <button
                                                                                href="#" class="btn btn-red">Save
                                                                                &nbsp;<i
                                                                                    class="fa fa-floppy-o"></i></button>&nbsp;
                                                                            <a href="#" data-dismiss="modal"
                                                                                class="btn btn-green">Cancel &nbsp;<i
                                                                                    class="glyphicon glyphicon-ban-circle"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--END MODAL edit credit card -->

                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="tool-footer text-right">
                                <p class="pull-left">Showing 1 to 5 of 5 entries</p>
                                {{-- <ul class="pagination pagination mtm mbm">
                                    <li class="disabled"><a href="#">&laquo;</a></li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li><a href="#">&raquo;</a></li>
                                </ul> --}}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <!-- end portlet -->
            </div>
            <!-- end col-lg-12 -->
        </div>
        <!-- end row -->
    </div>
    <!--END CONTENT-->

    <!--BEGIN FOOTER-->
    <div class="page-footer">
        <div class="copyright"><span class="text-15px">2016 © <a href="http://www.webqom.com" target="_blank">Webqom
                    Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom
                    Support</a>.</span>
            <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies Sdn Bhd"></div>
        </div>
    </div>
    <!--END FOOTER-->
</div>
<!--END PAGE WRAPPER-->
{{-- <script  src="{{ asset('/public/admin/js/jquery-1.9.1.js') }}"></script>
<script  src="{{ asset('/public/admin/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script  src="{{ asset('/public/admin/js/jquery-ui.js') }}"></script> --}}
<!--loading bootstrap js-->
{{-- <script  src="{{ asset('/public/admin/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
<script  src="{{ asset('/public/admin/vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js') }}"></script>
<script  src="{{ asset('/public/admin/js/html5shiv.js') }}"></script>
<script  src="{{ asset('/public/admin/js/respond.min.js') }}"></script>
<script  src="{{ asset('/public/admin/vendors/metisMenu/jquery.metisMenu.js') }}"></script>
<script  src="{{ asset('/public/admin/vendors/slimScroll/jquery.slimscroll.js') }}"></script>
<script  src="{{ asset('/public/admin/vendors/jquery-cookie/jquery.cookie.js') }}"></script>
<script  src="{{ asset('/public/admin/js/jquery.menu.js') }}"></script>
<script  data-pace-options='{ "ajax": false }'  src="{{ asset('/public/admin/vendors/jquery-pace/pace.min.js') }}"></script> --}}

<!--LOADING SCRIPTS FOR PAGE-->
{{-- <script src="{{ asset('/public/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/moment/moment.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-clockface/js/clockface.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/jquery-maskedinput/jquery-maskedinput.js') }}"></script>
<script src="{{ asset('/public/admin/js/form-components.js') }}"></script> --}}
<!--LOADING SCRIPTS FOR PAGE-->

{{-- <script  src="{{ asset('/public/admin/vendors/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script  src="{{ asset('/public/admin/vendors/ckeditor/ckeditor.js') }}"></script>
<script  src="{{ asset('/public/admin/js/ui-tabs-accordions-navs.js') }}"></script> --}}


<!--CORE JAVASCRIPT-->
{{-- <script src="{{ asset('/public/admin/js/main.js') }}"></script>
<script src="{{ asset('/public/admin/js/holder.js') }}"></script> --}}
<script>
    $(document).ready(function(){
        if(document.getElementById("sand").checked){
            $('#productionCode').hide();
        }
        else{
            $('#sandBox').hide();
        }
        $('#prod').change(function(){
            $('#sandBox').hide();
            $('#productionCode').show();
        })
        $('#sand').change(function(){
            $('#sandBox').show();
            $('#productionCode').hide();
        })
    });
</script>
@endsection
