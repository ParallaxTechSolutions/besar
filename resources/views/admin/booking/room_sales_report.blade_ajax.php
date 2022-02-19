@extends('adminLayout') 
@section('title', 'Room Sales - Listing') 
@section('content')
<div id="page-wrapper">
	<!--BEGIN PAGE HEADER & BREADCRUMB-->
	  <div class="page-header-breadcrumb">
		<div class="page-heading hidden-xs">
		  <h1 class="page-title">Room Sales Listings Graph</h1>
		</div>
	
		<!-- InstanceBeginEditable name="EditRegion1" -->
		<ol class="breadcrumb page-breadcrumb">
		  <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
		  <li>Bookings &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
		  <li class="active">Room Sales Report &nbsp;<i class="fa fa-angle-right"></i></li>
		  <li>Room Sales Report Graph</li>
		</ol>
		<!-- InstanceEndEditable -->
	  </div>
</div>
@endsection