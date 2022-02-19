@extends('adminLayout')
@section('content')

<div id="page-wrapper">
    <div class="page-header-breadcrumb">
        <div class="page-heading hidden-xs">
        	<h1 class="page-title">Partners</h1>
        </div>

        <ol class="breadcrumb page-breadcrumb">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
            <li>Partners &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li><a href="{{ url('web88cms/partners') }}">Partners Listing</a> &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li class="active">Partners - Edit</li>
        </ol>
    </div>
    <div class="page-content">
        <div class="row">
            <div class="col-lg-12">
                <h2>Partner <i class="fa fa-angle-right"></i> Listing</h2>
                <div class="clearfix"></div>
                @if ($success)
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                        <i class="fa fa-check-circle"></i> <strong>Success!</strong>
                        <p>{{ $success }}</p>
                    </div>
                @endif

                @if ($warning)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                        <i class="fa fa-times-circle"></i> <strong>Error!</strong>
                        <p>{{ $warning }}</p>
                    </div>
                @endif

                <div class="pull-left"> Last updated: <span class="text-blue">{{ date('d M, Y @ h:iA', strtotime($customer->modifydate))}}</span> </div>
                <div class="clearfix"></div>
                <p></p>
                <div class="clearfix"></div>

                <ul id="myTab" class="nav nav-tabs">
                    <li <?= ($tab == 'overview' ? 'class="active"' : '') ?>><a href="#overview" data-toggle="tab">Overview</a></li>
                    <li <?= ($tab == 'orders' ? 'class="active"' : '') ?>><a href="#past-orders" data-toggle="tab">Past Orders &nbsp;<span class="badge badge-red">{{ count($orders) }}</span></a></li>
                    <li <?= ($tab == 'wishlist' ? 'class="active"' : '') ?>><a href="#wishlist" data-toggle="tab">Wishlist</a></li>
                    <li <?= ($tab == 'special-list' ? 'class="active"' : '') ?>><a href="#special-list" data-toggle="tab">Special List</a></li>
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div id="overview" class="tab-pane fade <?= ($tab == 'overview' ? 'in active' : '') ?>">
                        <div class="portlet">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    	<!-- user account information start -->
	                                    <h4 class="block-heading"><i class="fa fa-user"></i> Partner Account Information</h4>
    	                                <div class="md-margin-2x"></div>
                                        <div class="form-group">
                                        	<label class="col-md-4 control-label">Status <span class="text-red">*</span></label>
	                                        <div class="col-md-6">
    		                                    <div data-on="success" data-off="primary" class="make-switch">
            		    	                        <input id="switch-status" type="checkbox" <?php echo ($customer->status ? 'checked="checked"' : ''); ?> name="status" />
                    	    	                </div>
                                	        </div>
                                        </div>
                                    	<div class="clearfix"></div>
	                                    <div class="xs-margin"></div>

                                        <div class="form-group">
                                        	<label for="inputFirstName" class="col-md-4 control-label">First Name <span class="text-red">*</span></label>
	                                        <div class="col-md-6">
    		                                    <input type="text" name="first_name" class="form-control" placeholder="" value="{{ $customer->first_name }}">
            	                            </div>
                                        </div>
                                    	<div class="clearfix"></div>
                                    	<div class="xs-margin"></div>

                                        <div class="form-group">
                                        	<label for="inputFirstName" class="col-md-4 control-label">Last Name <span class="text-red">*</span></label>
                                        	<div class="col-md-6">
                                        		<input type="text" name="last_name" class="form-control" placeholder="" value="{{ $customer->last_name }}">
                                        	</div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="xs-margin"></div>

                                        <div class="form-group">
                                        	<label for="inputFirstName" class="col-md-4 control-label">Email <span class="text-red">*</span></label>
	                                        <div class="col-md-6">
    		                                    <input type="text" name="email" class="form-control" placeholder="" value="{{ $customer->email }}">
            	                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="xs-margin"></div>

                                        <div class="form-group">
                                        	<label for="inputFirstName" class="col-md-4 control-label">Telephone <span class="text-red">*</span></label>
                                        	<div class="col-md-6">
                                                <input type="text" name="telephone" class="form-control" placeholder="" value="{{ $customer->telephone }}">
                                        	</div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="xs-margin"></div>

                                        <div class="form-group">
                                        	<label for="inputFirstName" class="col-md-4 control-label">Birth Date <span class="text-red">*</span></label>
	                                        <div class="col-md-3">
    		                                    <div class="input-group">
            			                            <input type="text" name="birth_date" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" class="datepicker-default form-control" value="{{ date('dS M, Y', strtotime($customer->birth_date))}}"/>
			                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            		                            </div>
                    	                    </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="xs-margin"></div>

                                        <div class="form-group">
                                        	<label for="password" class="control-label col-md-4">Password </label>
	                                        <div class="col-md-6">
    		                                    <div class="input-icon"><i class="fa fa-key"></i>
                                                	<input id="password" type="password" name="password" class="form-control" value=""/>
                                                	<span class="text-10px">(Password length should be between 6-12 characters)</span>
                                            	</div>
	                                        </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="xs-margin"></div>

                                        <div class="form-group">
                                        	<label for="password" class="control-label col-md-4">Confirm Password </label>
                                        	<div class="col-md-6">
                                        		<div class="input-icon"><i class="fa fa-key"></i>
                                        			<input id="password" type="password" name="password_confirmation" class="form-control" value=""/>
                                        			<span class="text-10px">(Password length should be between 6-12 characters)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="xs-margin"></div>

                                        <div class="lg-margin"></div>
                                        <!-- Credit Management -->
                                        <h5>Credit Management</h5>
                                        <div class="form-group">
                                            <label for="inputFirstName" class="col-md-4 control-label">Current Credit</label>
                                            <div class="col-md-6">
                                                <div class="form-control">
                                                    RM {{$customer->credit[0]->total_credit}}
                                                </div>
                                                <span class="text-10px">Last Updated: value="{{ date('dS M, Y', strtotime($customer->credit[0]->created_at))}}</span>

                                            </div>
                                        </div>
                                        <div class="clearfix"> </div>

                                        <div class="form-group">
                                            <label for="inputFirstName" class="col-md-4 control-label">Add Credit</label>
                                            <div class="col-md-6">
                                                <input type="number" name="add_credit" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                    	<!-- end shipping address -->
	                                    <div class="lg-margin"></div>
                                    </div>
                                </div>
	                            <div class="md-margin"></div>
                            </div>
	                        <div class="clearfix"></div>

                            <div class="form-actions text-center">
	                            <a href="javascript:void(0)" class="btn btn-red" onclick="saveCustomer($(this))">Save &nbsp;<i class="fa fa-floppy-o"></i></a>&nbsp;
                                <a href="#" class="btn btn-green">Cancel &nbsp;<i class="glyphicon glyphicon-ban-circle"></i></a>
                            </div>
                        </div>
                    </div>

                    <div id="past-orders" class="tab-pane fade <?= ($tab == 'orders' ? 'in active' : '') ?>">
                        <div class="portlet">

                            <div class="portlet-body">

                                <div class="table-responsive mtl">
                                    <table id="example1" class="table table-hover table-striped" style="word-wrap: break-word;table-layout: fixed;">
                                    <thead>
                                      <tr>
                                        <th style="width: 20px"><input type="checkbox"/></th>
                                        <th style="width: 50px">#</th>
                                        <th><a href="{{ $sorting_url }}tab=orders&sort_by=order_id&sort={{ (($tab == 'orders')&&($sort_by == 'order_id') && ($sort == 'ASC'))?'DESC':'ASC' }}">Order ID</a></th>
                                        <th><a href="{{ $sorting_url }}tab=orders&sort_by=createdate&sort={{ (($tab == 'orders')&&($sort_by == 'createdate') && ($sort == 'ASC'))?'DESC':'ASC' }}">Order Date</a></th>
                                        <th><a href="{{ $sorting_url }}tab=orders&sort_by=billing_email&sort={{ (($tab == 'orders')&&($sort_by == 'billing_email') && ($sort == 'ASC'))?'DESC':'ASC' }}">Login/E-mail</a></th>
                                        <th><a href="{{ $sorting_url }}tab=orders&sort_by=name&sort={{ (($tab == 'orders')&&($sort_by == 'name') && ($sort == 'ASC'))?'DESC':'ASC' }}">Partner Name</a></th>
                                        <th><a href="{{ $sorting_url }}tab=orders&sort_by=totalPrice&sort={{ (($tab == 'orders')&&($sort_by == 'totalPrice') && ($sort == 'ASC'))?'DESC':'ASC' }}">Amount</a></th>
                                        <th><a href="{{ $sorting_url }}tab=orders&sort_by=status&sort={{ (($tab == 'orders')&&($sort_by == 'status') && ($sort == 'ASC'))?'DESC':'ASC' }}">Order Status</a></th>
                                        <th><a href="{{ $sorting_url }}tab=orders&sort_by=payment_status&sort={{ (($tab == 'orders')&&($sort_by == 'payment_status') && ($sort == 'ASC'))?'DESC':'ASC' }}">Payment Status</a></th>
                                        <th style="width: 70px">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
									  	$totalAmountOrders = '0.00';
										$totalPaid = '0.00';
									  ?>
                                      @if($orders)
                                      	@foreach($orders as $order)

                                          <tr>
                                            <td><input name="order_id[]" value="{{ $order->id }}" type="checkbox"/></td>
                                            <td>{{ $order->id }}</td>
                                            <td ><a href="{{ url('web88cms/orders/detail/' . $order->id) }}">{{ $order->order_id }}</a></td>
                                            <td>{{ date('dS M, Y', strtotime($order->createdate)) }}</td>
                                            <td><a href="{{ url('web88cms/orders/detail/' . $order->id) }}">{{ $order->billing_email }}</a></td>
                                            <td>{{ $order->billing_first_name }} {{ @$order->billing_last_name }}</td>

                                            <td>RM {{ @number_format($order->totalPrice,2) }}</td>

                                            <td align="center">
                                                @if($order->status == 'Processing')
                                                    <span class="label label-sm label-info">Processing</span>
                                                @elseif($order->status == 'New Order')
                                                    <span class="label label-sm label-warning"><i class="fa fa-star"></i>&nbsp; New Order</span>
                                                @elseif($order->status == 'Ready To Ship')
                                                    <span class="label label-sm label-info">Ready To Ship</span>
                                                @elseif($order->status == 'Shipped')
                                                    <span class="label label-sm label-blue">Shipped</span>
                                                @elseif($order->status == 'Completed')
                                                    <span class="label label-sm label-success">Completed</span>
                                                @elseif($order->status == 'Declined')
                                                    <span class="label label-sm label-red">Declined</span>
                                                @elseif($order->status == 'Cancelled')
                                                    <span class="label label-sm label-primary">Cancelled</span>
                                                @endif
                                            </td>

                                            <td align="center">
                                            	@if($order->payment_status == 'Paid')
                                                	<span class="label label-sm label-success">Paid</span>
                                                @elseif($order->payment_status == 'Processing')
                                                    <span class="label label-sm label-info">Processing</span>
                                                @elseif($order->payment_status == 'Payment Error')
                                                	<span class="label label-sm label-red">Payment Error</span>
                                                @elseif($order->payment_status == 'Cancelled')
                                                    <span class="label label-sm label-primary">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>
                                            	<a href="{{ url('web88cms/orders/detail/' . $order->id) }}" data-hover="tooltip" data-placement="top" title="View Details"><span class="label label-sm label-yellow"><i class="fa fa-search"></i></span></a>
                                                <a href="javascript:void(0)" data-hover="tooltip" data-placement="top" title="Delete" data-target="#modal-delete-{{ $order->id }}" data-toggle="modal"><span class="label label-sm label-red"><i class="fa fa-trash-o"></i></span></a>

                                                <!--Modal delete start-->
                                                <div id="modal-delete-{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                                                  <div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                                                        <h4 id="modal-login-label3" class="modal-title"><a href=""><i class="fa fa-exclamation-triangle"></i></a> Are you sure you want to delete this order? </h4>
                                                      </div>
                                                      <div class="modal-body">
                                                        <p><strong>#{{ $order->id }}:</strong> {{ $order->order_id }} / {{ $order->billing_first_name }} {{ $order->billing_last_name }}</p>
                                                        <div class="form-actions">
                                                          <div class="col-md-offset-4 col-md-8">
                                                          	<a href="{{ url('web88cms/customers/deleteOrder/' . $customer->id . '/' . $order->id) }}" class="btn btn-red">Yes &nbsp;<i class="fa fa-check"></i></a>&nbsp;
                                                            <a href="javascript:void(0)" data-dismiss="modal" class="btn btn-green">No &nbsp;<i class="fa fa-times-circle"></i></a> </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                              </div>
                                              <!-- modal delete end -->
                                              </td>
                                          </tr>
                                          <?php
										  // totalPaid
                                          if($order->payment_status == 'Paid'){
                                          	if(isset($order->totalPrice)){
                                                $totalPaid += $order->totalPrice;
                                            } 
                                          }
										  
										  
										
											if(in_array($order->status, ['New Order', 'Shipped', 'Ready To Ship', 'Processing', 'Completed'])){
												if(isset($order->totalPrice)){
													$totalAmountOrders += $order->totalPrice;
												}
											} 

                                         ?>
                                        @endforeach
                                      @else
                                      	<tr>
                                        	<td colspan="10">No records available</td>
                                        </tr>
                                      @endif
                                    </tbody>
                                    <tfoot>
                                      <tr>
                                        <td colspan="10"></td>
                                      </tr>
                                    </tfoot>
                                  </table>
                                  <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6 col-md-offset-6">
                                                <div class="well">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <i class="glyphicon glyphicon-shopping-cart fa-4x"></i>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="row text-right">
                                                                <div class="col-md-7">
                                                                     <span class="red-title">Total Amount Orders:</span>
                                                                </div>
                                                                <div class="col-md-5">
                                                                     <span class="red-title"><strong>RM {{ number_format($totalAmountOrders, 2) }}</strong></span>
                                                                </div>
                                                            </div>

                                                            <div class="row text-right">
                                                                <div class="col-md-7">
                                                                     <span class="red-title">Total Paid:</span>
                                                                </div>
                                                                <div class="col-md-5">
                                                                     <span class="red-title"><strong>RM {{ number_format($totalPaid, 2) }}</strong></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                  </div>
                                  <!-- end row -->


                                  <div class="clearfix"></div>
                                </div>

                                <div class="clearfix"></div>
                            </div>
                            <!-- end portlet-body -->


                          </div>
                    </div>

                    <div id="wishlist" class="tab-pane fade <?= ($tab == 'wishlist' ? 'in active' : '') ?>">
                        <div class="portlet">
                            <div class="portlet-body">
                                 <div class="row">
                                    <div class="table-responsive mtl">
                                    <table id="example1" class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th width="1%"><input type="checkbox"/></th>
                                                <th>#</th>
                                                <th><a href="{{ $sorting_url }}tab=wishlist&sort_by=list_name&sort={{ (($tab == 'wishlist')&&($sort_by == 'list_name') && ($sort == 'ASC'))?'DESC':'ASC' }}">Name</a></th>
                                                <th><a href="{{ $sorting_url }}tab=wishlist&sort_by=createdate&sort={{ (($tab == 'wishlist')&&($sort_by == 'createdate') && ($sort == 'ASC'))?'DESC':'ASC' }}">Created Date</a></th>
                                                <th><a href="{{ $sorting_url }}tab=wishlist&sort_by=totalItems&sort={{ (($tab == 'wishlist')&&($sort_by == 'totalItems') && ($sort == 'ASC'))?'DESC':'ASC' }}">Qty</a></th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	@foreach($wishlists as $wishlist)
                                            <tr>
                                                <td><input type="checkbox" name="wishlist_id[]" value="{{ $wishlist->id }}"/></td>
                                                <td>{{ $wishlist->id }}</td>
                                                <td>{{ $wishlist->list_name }}</td>
                                                <td>{{ date('dS M, Y', strtotime($wishlist->createdate)) }}</td>
                                                <td>{{ $wishlist->totalItems }}</td>
                                                <td><a href="{{ url('web88cms/customers/wishlistDetails/' . $wishlist->id) }}" data-hover="tooltip" data-placement="top" title="View List Details"><span class="label label-sm label-yellow"><i class="fa fa-search"></i></span></a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
	                                            <td colspan="6"></td>
                                            </tr>
                                        </tfoot>
                                      </table>
                                      <div class="tool-footer text-right">
                                        <p class="pull-left">{{ $wishlistPaginateMsg }}</p>
                                        <?php echo $wishlists->appends($_GET)->render() ?>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                 </div>
                                 <!-- end row -->



                            </div>
                            <!-- end portlet-body -->

                        </div>
                        <!-- end portlet -->
                    </div>

                    <div id="special-list" class="tab-pane fade <?= ($tab == 'special-list' ? 'in active' : '') ?>">
                        <div class="portlet">

                            <div class="portlet-body">

                                 <div class="row">

                                    <div class="table-responsive mtl">
                                    <table id="example1" class="table table-hover table-striped">
                                        <thead>
                                          <tr>
                                            <th width="1%"><input type="checkbox"/></th>
                                            <th>#</th>
                                            <th><a href="{{ $sorting_url }}tab=special-list&sort_by=event_type&sort={{ (($tab == 'special-list')&&($sort_by == 'event_type') && ($sort == 'ASC'))?'DESC':'ASC' }}" title="Sort by name">Event Name</a></th>
                                            <th><a href="{{ $sorting_url }}tab=special-list&sort_by=event_date&sort={{ (($tab == 'special-list')&&($sort_by == 'event_date') && ($sort == 'ASC'))?'DESC':'ASC' }}" title="Sort by event date">Event Date</a></th>
                                            <th><a href="{{ $sorting_url }}tab=special-list&sort_by=totalGifts&sort={{ (($tab == 'special-list')&&($sort_by == 'totalGifts') && ($sort == 'ASC'))?'DESC':'ASC' }}" title="Sort by event date">Gifts</th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tbody>
                                        	@foreach($specials as $special)
                                            <tr>
                                                <td><input type="checkbox" name="special_id[]" value="{{ $special->id }}"/></td>
                                                <td>{{ $special->id }}</td>
                                                <td>{{ $special->event_type }}</td>
                                                <td>{{ date('dS M, Y', strtotime($special->event_date)) }}</td>
                                                <td>{{ $special->totalGifts }}</td>
                                                <td><a href="{{ url('web88cms/customers/specialListDetails/' . $special->id) }}" data-hover="tooltip" data-placement="top" title="View List Details"><span class="label label-sm label-yellow"><i class="fa fa-search"></i></span></a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
	                                            <td colspan="6"></td>
                                            </tr>
                                        </tfoot>
                                      </table>
                                      <div class="tool-footer text-right">
                                        <p class="pull-left">{{ $specialPaginateMsg }}</p>
                                        <?php echo $specials->appends($_GET)->render() ?>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                 </div>
                                 <!-- end row -->



                            </div>
                            <!-- end portlet-body -->

                        </div>
                        <!-- end portlet -->
                    </div>
				</div>
			</div>
		</div>
	</div>

    <div class="page-footer">
        <div class="copyright"><span class="text-15px">2015 © <a href="https://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
            <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies Sdn Bhd"></div>
        </div>
    </div>
</div>
<input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">

<script src="{{ asset('/public/admin/js/jquery-1.9.1.js') }}"></script>
<script src="{{ asset('/public/admin/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script src="{{ asset('/public/admin/js/jquery-ui.js') }}"></script>
<!--loading bootstrap js-->
<script src="{{ asset('/public/admin/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js') }}"></script>
<script src="{{ asset('/public/admin/js/html5shiv.js') }}"></script>
<script src="{{ asset('/public/admin/js/respond.min.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/slimScroll/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/jquery-cookie/jquery.cookie.js') }}"></script>
<script src="{{ asset('/public/admin/js/jquery.menu.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/jquery-pace/pace.min.js') }}"></script>

<!--LOADING SCRIPTS FOR PAGE-->
<script src="{{ asset('/public/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/moment/moment.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-clockface/js/clockface.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/jquery-maskedinput/jquery-maskedinput.js') }}"></script>
<script src="{{ asset('/public/admin/js/form-components.js') }}"></script>
<!--LOADING SCRIPTS FOR PAGE-->

<script src="{{ asset('/public/admin/vendors/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/public/admin/js/ui-tabs-accordions-navs.js') }}"></script>


<!--CORE JAVASCRIPT-->
<script src="{{ asset('/public/admin/js/main.js') }}"></script>
<script src="{{ asset('/public/admin/js/holder.js') }}"></script>

<script>
function saveCustomer(obj){
	$.ajax({
		url: "{{ url('web88cms/partners/editPartners/' . $customer->id) }}",
		type: 'POST',
		data: $('#overview input[type=text],#overview input[type=number], #overview input[type=password], #overview select, #overview textarea, #overview input[type=checkbox]:checked, #_token'),
		dataType: 'json',
		async: false,
		cache: false,
		beforeSend:function (){
			obj.html('Saving... <i class="fa fa-floppy-o"></i>');
		},
		complete: function(){
			obj.html('Save <i class="fa fa-floppy-o"></i>');
		},
		success: function (response) {
			var html = '';

			$('#warning-box').remove();
			$('#success-box').remove();

			if(response['error'])
			{
				 html += '<div id="warning-box" class="alert alert-danger alert-dismissable">';
					html += '<button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>';
					html += '<i class="fa fa-times-circle"></i> <strong>Error!</strong>';

					for(var i=0; i < response['error'].length; i++)
					{
						html += '<p>'+ response['error'][i] +'</p>';
					}

				html += '</div>';
				$('#overview > .portlet').after(html);
			}

			if(response['success'])
			{
				window.open("{{ url('web88cms/partners/view/' . $customer->id) }}","_parent");
			}
		}
	});
}

$(function (){
	$('select[name="billing_country"]').change(function(){
		var country_id = $(this).val();
		if(country_id != ''){
			$.ajax({
				url: "{{ url('web88cms/partners/getStates') }}",
				type: 'POST',
				data: {country_id:country_id, _token: $('#_token').val()},
				dataType: 'json',
				async: false,
				cache: false,
				beforeSend:function (){
					$('select[name="billing_state"]').html('<option value="">Loading...</option>');
				},
				complete: function(){

				},
				success: function (response) {
					var html = '';
					html += '<option value="">States</option>';
					if(response['states']){
						for(var i = 0; i < response['states'].length; i++){
							html += '<option value="' + response['states'][i]['zone_id'] + '">' + response['states'][i]['name'] + '</option>';
						}
					}

					$('select[name="billing_state"]').html(html);
				}
			});
		}
		else{
			$('select[name="billing_state"]').html('<option value="">State</option>');
		}
	});
});

$(function (){
	$('select[name="shipping_country"]').change(function(){
		var country_id = $(this).val();
		if(country_id != ''){
			$.ajax({
				url: "{{ url('web88cms/partners/getStates') }}",
				type: 'POST',
				data: {country_id:country_id, _token: $('#_token').val()},
				dataType: 'json',
				async: false,
				cache: false,
				beforeSend:function (){
					$('select[name="shipping_state"]').html('<option value="">Loading...</option>');
				},
				complete: function(){

				},
				success: function (response) {
					var html = '';
					html += '<option value="">States</option>';
					if(response['states']){
						for(var i = 0; i < response['states'].length; i++){
							html += '<option value="' + response['states'][i]['zone_id'] + '">' + response['states'][i]['name'] + '</option>';
						}
					}

					$('select[name="shipping_state"]').html(html);
				}
			});
		}
		else{
			$('select[name="shipping_state"]').html('<option value="">State</option>');
		}
	});
});

//Shipping address is the same as billing address
$(function(){
	$('input[name=same_billing_address]').click(function(){
		if($(this).is(':checked')){

			$('input[name=shipping_first_name]').val($('input[name=billing_first_name]').val());
			$('input[name=shipping_last_name]').val($('input[name=billing_last_name]').val());
			$('input[name=shipping_email]').val($('input[name=billing_email]').val());
			$('input[name=shipping_telephone]').val($('input[name=billing_telephone]').val());
			$('textarea[name=shipping_address]').val($('textarea[name=billing_address]').val());
			$('input[name=shipping_city]').val($('input[name=billing_city]').val());
			$('input[name=shipping_post_code]').val($('input[name=billing_post_code]').val());

			$('select[name=shipping_state]').html($('select[name=billing_state]').html());
			$('select[name=shipping_country]').html($('select[name=billing_country]').html());

			$('select[name=shipping_state]').val($('select[name=billing_state]').val());
			$('select[name=shipping_country]').val($('select[name=billing_country]').val());
		}
	});
});

$(document).ready(function(){
    $("#switch-status").bootstrapSwitch();
});
</script>
@endsection