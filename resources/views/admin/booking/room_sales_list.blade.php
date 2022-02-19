@extends('adminLayout') 
@section('title', 'Room Sales - Listing') 
@section('content')
<div id="page-wrapper">
  <!--BEGIN PAGE HEADER & BREADCRUMB-->
  <div class="page-header-breadcrumb">
    <div class="page-heading hidden-xs">
      <h1 class="page-title">Room Sales Listings</h1>
    </div>

    <!-- InstanceBeginEditable name="EditRegion1" -->
    <ol class="breadcrumb page-breadcrumb">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
      <li>Bookings &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
      <li class="active">Room Sales - Listing</li>
    </ol>
    <!-- InstanceEndEditable -->
  </div>
  <!--END PAGE HEADER & BREADCRUMB-->
  <!--BEGIN CONTENT-->
  <!-- InstanceBeginEditable name="EditRegion2" -->
  <div class="page-content">
    <div class="row">
      <div class="col-lg-12">
        <h2>Room Sales <i class="fa fa-angle-right"></i> Listing</h2>
        <div class="clearfix"></div>
        <p>
          @if (Session::has('flash_message'))
          <div class="alert alert-success alert-dismissable">
            <button type="button" data-dismiss="alert" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
            <i class="fa fa-check-circle"></i>
            <strong>Success!</strong> {{ Session::get('flash_message') }}
          </div>
          @endif
        </p>
        <?php $error = ''; ?> @if($error)
        <div class="alert alert-danger alert-dismissable">
          <button type="button" data-dismiss="alert" aria-hidden="true" onClick="$('.form-horizontal').trigger('reset');" class="close">&times;</button>
          <i class="fa fa-times-circle"></i> <strong>Error!</strong>
          <p>{{ $error }}</p>
        </div>
        @endif
        <div class="pull-left"> Last updated: <span class="text-blue">15 Sept, 2014 @ 12.00PM</span> </div>
        <div class="clearfix"></div>
        <p></p>
        <div class="clearfix"></div>
      </div>
      <!-- end col-lg-12 -->
@endsection