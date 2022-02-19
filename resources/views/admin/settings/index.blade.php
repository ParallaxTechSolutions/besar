@extends('adminLayout') 
@section('title', 'DDR Settings') 
@section('content')
<div id="page-wrapper">
  <!--BEGIN PAGE HEADER & BREADCRUMB-->
  <div class="page-header-breadcrumb">
    <div class="page-heading hidden-xs">
      <h1 class="page-title">DDR Settings</h1>
    </div>

    <!-- InstanceBeginEditable name="EditRegion1" -->
    <ol class="breadcrumb page-breadcrumb">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
      <li>DDR Settings &nbsp;</li>
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
                        <div class="caption text-white">DDR Settings</div>
                    </div>

                    <div class="portlet-body">
                        <form class="form-horizontal" method="post" action="{{ url('/web88cms/settings') }}">
                        	
                        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                        	<?php
                        	$third_party_sale = '';
                        	if(!empty($settings['third_party_sale'])){
                        		$third_party_sale = $settings['third_party_sale'];
                        	}
                        	?>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Third party sale </label>
                                <div class="col-md-6">
                                    <input type="text" name="3" value="{{$third_party_sale}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Third party sale <strong>Period</strong> </label>
                                <div class="col-md-6">
                                	<select name="4" id="third_party_sale_period" class="form-control">
                                		<option value="">--Select Period--</option>
                                		<option <?php echo ($settings['third_party_sale_period'] == 'Monthly') ? 'selected="selected"' : '' ?> value="Monthly">Monthly</option>
                                		<option <?php echo ($settings['third_party_sale_period'] == 'Quarterly') ? 'selected="selected"' : '' ?> value="Quarterly">Quarterly</option>
                                		<option <?php echo ($settings['third_party_sale_period'] == 'Yearly') ? 'selected="selected"' : '' ?> value="Yearly">Yearly</option>
                                	</select>
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