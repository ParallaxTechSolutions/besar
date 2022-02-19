@extends('adminLayout') 
@section('title', 'Sold Rooms Per Available Settings') 
@section('content')
<div id="page-wrapper">
  <!--BEGIN PAGE HEADER & BREADCRUMB-->
  <div class="page-header-breadcrumb">
    <div class="page-heading hidden-xs">
      <h1 class="page-title">Sold Rooms Per Available Settings</h1>
    </div>

    <!-- InstanceBeginEditable name="EditRegion1" -->
    <ol class="breadcrumb page-breadcrumb">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
      <li>Sold Rooms Per Available Settings &nbsp;</li>
    </ol>

    <div class="page-content">
        <div class="row">

            <div class="col-md-12">

                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                        <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                        <p>{{ session()->get('success') }}</p>
                    </div>      
                @endif


                <div class="portlet portlet-blue">
                    <div class="portlet-header">
                        <div class="caption text-white">Sold Rooms Per Available Settings</div>
                    </div>

                    <div class="portlet-body">
                        <form class="form-horizontal" method="post" action="{{ url('/web88cms/sold_rooms_per_available') }}">
                        	
                        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                        	<?php
                        	$number_of_rooms = '';
                        	if(!empty($settings['number_of_rooms'])){
                        		$number_of_rooms = $settings['number_of_rooms'];
                        	}
                        	?>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Number Of Rooms </label>
                                <div class="col-md-6">
                                    <input type="text" name="5" value="{{$number_of_rooms}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-actions text-center">
                                <button type="submit" class="btn btn-red"><i class="fa fa-save"></i> &nbsp;Save </button>
                           </div>
                        </form>
                    </div>
                </div>
            </div>

    <!-- InstanceEndEditable -->
  </div>
</div>
@endsection