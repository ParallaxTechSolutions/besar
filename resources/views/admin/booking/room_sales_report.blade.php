@extends('adminLayout') 
@section('title', 'Room Sales - Listing') 
@section('content')
<div id="page-wrapper"><!--BEGIN PAGE HEADER & BREADCRUMB-->
        
        <div class="page-header-breadcrumb">
          <div class="page-heading hidden-xs">
            <h1 class="page-title">Bookings</h1>
          </div>
          
          <!-- InstanceBeginEditable name="EditRegion1" -->
          <ol class="breadcrumb page-breadcrumb">
            <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.html">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
            <li>Bookings &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</li>
            <li class="active">Room Sales Report</li>
          </ol>
          <!-- InstanceEndEditable --></div>
        <!--END PAGE HEADER & BREADCRUMB--><!--BEGIN CONTENT-->
        <!-- InstanceBeginEditable name="EditRegion2" -->
        <div class="page-content">
          <div class="row">
            <div class="col-lg-12">
              <h2>Room Sales Report</h2>
              <div class="clearfix"></div>
              
              	@if ($data['last_updated'])
	                <div class="pull-left"> Last updated: <span class="text-blue">{{ $data['last_updated'] }}</span> </div>
    	            <div class="clearfix"></div>
        	        <p></p>
                @endif
              <div class="clearfix"></div>
            </div>
            <!-- end col-lg-12 -->

            <div class="col-lg-12">
              <ul id="myTab" class="nav nav-tabs">
				<?php 
				$room_suits_active = 'active';
				$apartments_active = '';
				if(!empty($data['defaultTab']) && ($data['defaultTab'] == 'rooms_suits')){
					$room_suits_active = 'active';
					$apartments_active = '';
				}
				if(!empty($data['defaultTab']) && ($data['defaultTab'] == 'apartments')){
					$room_suits_active = '';
					$apartments_active = 'active';
				}
				?>
				
                <li class="<?php echo $room_suits_active; ?>"><a href="#rooms-suites" onclick="changeTab('rooms_suits')" data-toggle="tab">Rooms &amp; Suites</a></li>
                <li class="<?php echo $apartments_active; ?>" ><a href="#apartments" onclick="changeTab('apartments')" data-toggle="tab">Apartments</a></li>
              </ul> 
            
              <div id="myTabContent" class="tab-content" style="overflow:scroll;">
                <?php if(!empty($data['defaultTab']) && ($data['defaultTab'] == 'rooms_suits')){ ?>
				<div id="rooms-suites" class="tab-pane fade in active"> 	
                  <div class="portlet">
                    <div class="portlet-header">
                      <div class="caption">Rooms &amp; Suites Sales Report</div>
                      <br/>
                      <p class="margin-top-10px"></p>
                      
                      <a href="{{ url('web88cms/room_sales_report_graph') }}" class="btn btn-violet">Graph &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                      <a href="javascript:void(0);" onclick="exportExcelReport()"  class="btn btn-blue">Export to CSV &nbsp;<i class="fa fa-share"></i></a>  
                      <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                      
                    </div>
                    <div class="portlet-body">
                      <div class="form-inline pull-left">
                        <div class="form-group">
                          <label class="control-label">Year</label>&nbsp;
                          <select name="year" id="year" class="form-control">
                            <?php foreach($data['years'] as $val){ ?>
								<option <?php if($data['currentYear']==$val->years){ ?> selected="selected" <?php } ?>> <?php echo $val->years; ?></option>
							<?php } ?>
                          </select>
                        </div>
			<p class="margin-top-10px"></p>
                      </div>
                      
                      <div class="clearfix"></div>
						<?php
							$currentPage = 1;
							$currentYear = $data['currentYear'];
							$currentMonth = $data['currentMonth'];
							$defaultTab = $data['defaultTab'];
							if(!empty($data['page'])){
								$currentPage = $data['page'];
							}
							$dateObj   = DateTime::createFromFormat('!m', $currentMonth);
							$monthName = $dateObj->format('F');
							
							$number = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

							$product_count = $data['product_count'];
							
						?>
						<input type="hidden" name="currentMonth" id="currentMonth" value="{{$currentMonth}}" />
						<input type="hidden" name="currentPage" id="currentPage" value="{{$currentPage}}" />
						<input type="hidden" name="currentTab" id="currentTab" value="{{$defaultTab}}" />
						<div id="table-scroll" class="table-scroll">
  <div class="table-wrap">
    <table class="main-table" id="example1">
							  <thead>
								<tr>
								  <th class="fixed-side"></th>
								  <th class="fixed-side"></th>
								  <th class="text-center"><a href="javascript:void(0)" onclick="previousMonth()"><i class="fa fa-chevron-left"></i></a></th>
								  <th colspan="<?php echo $number-2 ?>" class="text-center">{{$monthName}}</th>
								  <th class="text-center"><a href="javascript:void(0)" onclick="nextMonth()"><i class="fa fa-chevron-right"></i></a></th>
							   </tr>
								<tr>
								  <th class="fixed-side"></th>
								  <th class="fixed-side"><a href="#sort by booking id">Room Type</a></th>
								  <?php for($i=1; $i<=$number; $i++){ ?>
									<th class="text-center">{{$i}}<br/><?php echo date('D', strtotime($currentYear.'-'.$currentMonth.'-'.$i)) ?></th>
								  <?php } ?>
								</tr>
							  </thead>
							  <tbody>
								@foreach($data['products'] as $product)
									<tr>
									  <td class="fixed-side">
										<?php
										$status_checked = '';
										if(!empty($product['productDetails']->status)){
											$status_checked = 'checked="checked"';
										}

										if($product['productDetails']->quantity_in_stock==0){
											$status_checked = '';
										}

										?> 
										<div class="make-switch switch-mini">
											<input type="checkbox" onchange="changeProductStatus('<?php echo $product['productDetails']->id ?>')" id="product<?php echo $product['productDetails']->id ?>" value="1" {{$status_checked}} />
										</div>
									  </td>
									  <td class="fixed-side"><span class="text-12px">{{ $product['productDetails']->type }}</span></td>
									  <?php for($i=1; $i<=$number; $i++){ ?>
										
											<?php if(empty($product['roomPricesArr'])){ ?>
												<td><div align="center"><span class="text-12px">N/A</div></td>
											<?php } else {
												$currentMonth = str_pad($currentMonth, 2, "0", STR_PAD_LEFT);
												$i = str_pad($i, 2, "0", STR_PAD_LEFT);
												if(empty($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i])){
													?>
													<td><div align="center"><span class="text-12px">N/A</div></td>
												<?php }else{
											
													if(!empty($product['orderToProductArr'][$currentYear.'-'.$currentMonth.'-'.$i])){

														if(($product['orderToProductArr'][$currentYear.'-'.$currentMonth.'-'.$i])>=($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->qty_stock)){
															?>
															<td class="active"><div align="center"><span class="text-12px"><b>SOLD OUT</b></span></div></td>
														<?php
														
														}else{

															$orderToProductArr = $product['orderToProductArr'][$currentYear.'-'.$currentMonth.'-'.$i];

															$roomPricesDividedByTwo = ceil($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->qty_stock/2);



															//if($orderToProductArr >= $roomPricesDividedByTwo){
																?>
																<td class="success"><div align="center"><span class="text-12px text-success">
																	<?php
																		$room_sales_percentage = ($orderToProductArr/$product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->qty_stock)*100;
																	?>
																	<b><?php 
																		echo number_format($room_sales_percentage,2);
																	?>% SOLD</b><br/>

																	<?php echo number_format($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->sale_price,2); ?>
																</span></div></td>
																<?php
															//}
														}
													}else{
														?>
														<td><div align="center"><span class="text-12px">
														<?php
														echo number_format($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->sale_price,2);
														?>
														</div></td>
													<?php
													}
											 } } ?>
											</span>
										</div></td>
									  <?php } ?>
									</tr>
								@endforeach
							  </tbody>
							</table>
							</div>
							<?php  
							$firstValue = 1;
							$lastValue = 10;
							if($currentPage>1){
								$firstValue = $currentPage*10-9;
								$lastValue = $currentPage*10;
							}
							if($lastValue>$product_count){
								$lastValue = $product_count;
							}
							
							?> 
							<div class="tool-footer text-right">
							  <p class="pull-left">Showing {{$firstValue}} to {{$lastValue}} of {{$product_count}} entries</p>
							  <ul class="pagination pagination mtm mbm">
								<li><a href="javascript:void(0)" onclick="changePage(1)">&laquo;</a></li>
								<?php for($i=1;$i<=ceil($product_count/10);$i++){ 
								$active_class = '';
								if($i==$currentPage){
									$active_class = 'active';
								}
								?>
									<li class="{{$active_class}}"><a href="javascript:void(0)" onclick="changePage({{$i}})">{{$i}}</a></li>
								<?php } ?>
								<li><a href="javascript:void(0)" onclick="changePage({{ceil($product_count/10)}})">&raquo;</a></li>
							  </ul>
							</div>
							<div class="clearfix"></div>
						</div>
                      
                    </div>
                  </div>
                  <!-- end porlet -->
                </div><!-- end tab rooms & suites -->
                <?php } ?>
                
				<?php if(!empty($data['defaultTab']) && ($data['defaultTab'] == 'apartments')){ ?>
                <div id="apartments" class="tab-pane fade in active"> 	
                  <div class="portlet">
                    <div class="portlet-header">
                      <div class="caption">Apartments Sales Report</div>
                      <br/>
                      <p class="margin-top-10px"></p>
                      
                      <a href="{{ url('web88cms/room_sales_report_graph') }}" class="btn btn-violet">Graph &nbsp;<i class="fa fa-plus"></i></a>&nbsp;
                      <a href="javascript:void(0);" onclick="exportExcelReport()" class="btn btn-blue">Export to CSV &nbsp;<i class="fa fa-share"></i></a>  
                      <div class="tools"> <i class="fa fa-chevron-up"></i> </div>
                      
                    </div>
                    <div class="portlet-body">
                      <div class="form-inline pull-left">
                        <div class="form-group">
                          <label class="control-label">Year</label>&nbsp;
                          <select name="year" id="year" class="form-control">
							<?php foreach($data['years'] as $val){ ?>
								<option <?php if($data['currentYear']==$val->years){ ?> selected="selected" <?php } ?>> <?php echo $val->years; ?></option>
							<?php } ?>
                          </select>
   
                        </div>
                      </div>
                      <div class="clearfix"></div>
						<?php
							$currentPage = 1;
							$currentYear = $data['currentYear'];
							$currentMonth = $data['currentMonth'];
							$defaultTab = $data['defaultTab'];
							if(!empty($data['page'])){
								$currentPage = $data['page'];
							}
							$dateObj   = DateTime::createFromFormat('!m', $currentMonth);
							$monthName = $dateObj->format('F');
							
							$number = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

							$product_count = $data['product_count'];
							
						?>
						<input type="hidden" name="currentMonth" id="currentMonth" value="{{$currentMonth}}" />
						<input type="hidden" name="currentPage" id="currentPage" value="{{$currentPage}}" />
						<input type="hidden" name="currentTab" id="currentTab" value="{{$defaultTab}}" />
						
						<div class=" mtl" id="apertmentsPriceCalendar">
							<table id="example1" class="table table-bordered">
							  <thead>
								<tr>
								  <th></th>
								  <th></th>
								  <th class="text-center"><a href="javascript:void(0)" onclick="previousMonth()"><i class="fa fa-chevron-left"></i></a></th>
								  <th colspan="<?php echo $number-2 ?>" class="text-center">{{$monthName}}</th>
								  <th class="text-center"><a href="javascript:void(0)" onclick="nextMonth()"><i class="fa fa-chevron-right"></i></a></th>
							   </tr>
								<tr>
								  <th></th>
								  <th><a href="#sort by booking id">Room Type</a></th>
								  <?php for($i=1; $i<=$number; $i++){ ?>
									<th class="text-center">{{$i}}<br/><?php echo date('D', strtotime($currentYear.'-'.$currentMonth.'-'.$i)) ?></th>
								  <?php } ?>
								</tr>
							  </thead>
							  <tbody>
								@foreach($data['products'] as $product)
									<tr>
									  <td>
										<?php
										$status_checked = '';
										if(!empty($product['productDetails']->status)){
											$status_checked = 'checked="checked"';
										}

										if($product['productDetails']->quantity_in_stock==0){
											$status_checked = '';
										}
										
										?> 
										<div class="make-switch switch-mini">
											<input type="checkbox" onchange="changeProductStatus('<?php echo $product['productDetails']->id ?>')" id="product<?php echo $product['productDetails']->id ?>" value="1" {{$status_checked}} />
										</div>
									  </td>
									  <td><span class="text-12px">{{ $product['productDetails']->type }}</span></td>
									  <?php for($i=1; $i<=$number; $i++){ ?>
										
											<?php if(empty($product['roomPricesArr'])){ ?>
												<td><div align="center"><span class="text-12px">N/A</div></td>
											<?php } else {
												$currentMonth = str_pad($currentMonth, 2, "0", STR_PAD_LEFT);
												$i = str_pad($i, 2, "0", STR_PAD_LEFT);
												if(empty($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i])){
													?>
													<td><div align="center"><span class="text-12px">N/A</div></td>
												<?php }else{
											
													if(!empty($product['orderToProductArr'][$currentYear.'-'.$currentMonth.'-'.$i])){
														if(($product['orderToProductArr'][$currentYear.'-'.$currentMonth.'-'.$i])>=($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->qty_stock)){
															?>
															<td class="active"><div align="center"><span class="text-12px"><b>SOLD OUT</b></span></div></td>
														<?php
														}else{
															
															$orderToProductArr = $product['orderToProductArr'][$currentYear.'-'.$currentMonth.'-'.$i];
															
															//$roomPricesDividedByTwo = ceil($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->qty_stock/2);
															//if($orderToProductArr >= $roomPricesDividedByTwo){
																?>
																



															<td class="success">
																<div align="center">
																	<span class="text-12px text-success">
																	<?php
																		$apartment_sales_percentage = ($orderToProductArr/$product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->qty_stock)*100;
																	?>
																	<b>
																		<?php
																		echo number_format($apartment_sales_percentage,2);
																		?>
																% SOLD</b><br/>

																	<?php echo number_format($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->sale_price,2); ?>
																	</span>
																</div>
															</td>

																<?php
															//}
														}
													}else{
														?>
														<td><div align="center"><span class="text-12px">
														<?php
														echo number_format($product['roomPricesArr'][$currentYear.'-'.$currentMonth.'-'.$i]->sale_price,2);
														?>
														</div></td>
													<?php
													}
											 } } ?>
											</span>
										</div></td>
									  <?php } ?>
									</tr>
								@endforeach
							  </tbody>
							</table>
							<?php  
							$firstValue = 1;
							$lastValue = 10;
							if($currentPage>1){
								$firstValue = $currentPage*10-9;
								$lastValue = $currentPage*10;
							}
							if($lastValue>$product_count){
								$lastValue = $product_count;
							}
							
							?> 
							<div class="tool-footer text-right">
							  <p class="pull-left">Showing {{$firstValue}} to {{$lastValue}} of {{$product_count}} entries</p>
							  <ul class="pagination pagination mtm mbm">
								<li><a href="javascript:void(0)" onclick="changePage(1)">&laquo;</a></li>
								<?php for($i=1;$i<=ceil($product_count/10);$i++){ 
								$active_class = '';
								if($i==$currentPage){
									$active_class = 'active';
								}
								?>
									<li class="{{$active_class}}"><a href="javascript:void(0)" onclick="changePage({{$i}})">{{$i}}</a></li>
								<?php } ?>
								<li><a href="javascript:void(0)" onclick="changePage({{ceil($product_count/10)}})">&raquo;</a></li>
							  </ul>
							</div>
							<div class="clearfix"></div>
						</div>
						
                    </div>
                  </div>
                  <!-- end porlet -->
                </div><!-- end tab apartments -->
				<?php } ?>
              </div><!-- end all tabs -->
              
            </div>
            <!-- end col-lg-12 -->
            
            
          </div>
          <!-- end row -->
        </div>
        <!-- InstanceEndEditable -->
        <!--END CONTENT-->
            
            <!--BEGIN FOOTER-->
<div class="page-footer">
                <div class="copyright"><span class="text-15px">2017 &copy; <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
                	<div class="pull-right"><img src="images/logo_webqom.png" alt="Webqom Technologies Sdn Bhd"></div>
                </div>
        </div>
    <!--END FOOTER--></div>
@endsection
@push('scripts')
<script type="text/javascript">
	
	$( document ).ready(function() {
		$('#year').on('change', function() {
		  changeYear();
		});
	});
	
	function previousMonth(){
		var currentTab = $('#currentTab').val();
		var prevMonth = (parseInt($('#currentMonth').val())-1);
		var currentPage = $('#currentPage').val();
		var currentYear = $('#year').val();
		
		var currentUrl = window.location.href;
		
		questionMarkExist = currentUrl.indexOf("?");
		if(questionMarkExist==-1){
			var clean_uri = currentUrl;
		}else{
			var clean_uri = currentUrl.substring(currentUrl.indexOf("?"),0);
		}
			
		window.location.href = clean_uri+'?active_tab='+currentTab+'&page='+currentPage+'&month='+prevMonth+'&year='+currentYear;
		
	}
	
	function nextMonth(){
		var currentTab = $('#currentTab').val();
		var prevMonth = (parseInt($('#currentMonth').val())+1);
		var currentPage = $('#currentPage').val();
		var currentYear = $('#year').val();
		
		var currentUrl = window.location.href;
		
		questionMarkExist = currentUrl.indexOf("?");
		if(questionMarkExist==-1){
			var clean_uri = currentUrl;
		}else{
			var clean_uri = currentUrl.substring(currentUrl.indexOf("?"),0);
		}
			
		window.location.href = clean_uri+'?active_tab='+currentTab+'&page='+currentPage+'&month='+prevMonth+'&year='+currentYear;
	}
	
	function changeYear(){
		var prevMonth = parseInt($('#currentMonth').val());
		var currentPage = $('#currentPage').val();
		var currentYear = $('#year').val();
		var currentTab = $('#currentTab').val();
		
		var currentUrl = window.location.href;
		
		questionMarkExist = currentUrl.indexOf("?");
		if(questionMarkExist==-1){
			var clean_uri = currentUrl;
		}else{
			var clean_uri = currentUrl.substring(currentUrl.indexOf("?"),0);
		}
			
		window.location.href = clean_uri+'?active_tab='+currentTab+'&page='+currentPage+'&month='+prevMonth+'&year='+currentYear;
	}
	
	function changePage(pageno){
		var prevMonth = parseInt($('#currentMonth').val());
		var currentPage = pageno;
		var currentYear = $('#year').val();
		var currentTab = $('#currentTab').val();
		
		var currentUrl = window.location.href;
		
		questionMarkExist = currentUrl.indexOf("?");
		if(questionMarkExist==-1){
			var clean_uri = currentUrl;
		}else{
			var clean_uri = currentUrl.substring(currentUrl.indexOf("?"),0);
		}
			
		window.location.href = clean_uri+'?active_tab='+currentTab+'&page='+currentPage+'&month='+prevMonth+'&year='+currentYear;
	}
	
	function changeTab(tab){
		var currentUrl = window.location.href;
		
		questionMarkExist = currentUrl.indexOf("?");
		if(questionMarkExist==-1){
			var clean_uri = currentUrl;
		}else{
			var clean_uri = currentUrl.substring(currentUrl.indexOf("?"),0);
		}
			
		window.location.href = clean_uri+'?active_tab='+tab;
	}
	
	function changeProductStatus(product_id){
		var product_checked = $('#product'+product_id).prop('checked');
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		})
		
		$.ajax({
			url: '/web88cms/changeProductStatus',
			type: 'post',
			data: {'product_checked':product_checked, 'product_id':product_id},
			async: false,
			beforeSend: function () {
				//Can we add anything here.
			},
			cache: true,
			dataType: 'json',
			success: function (data) {
				//alert(JSON.stringify());
			}
		});
		
	}

	function exportExcelReport(){
		var currentUrl = window.location.href;

		var currentMonth = parseInt($('#currentMonth').val());
		var currentYear = $('#year').val();
		var currentTab = $('#currentTab').val();

		questionMarkExist = currentUrl.indexOf("?");
		if(questionMarkExist==-1){
			var clean_uri = currentUrl;
		}else{
			var clean_uri = currentUrl.substring(currentUrl.indexOf("?"),0);
		}

		clean_uri = clean_uri+'/csv/'+currentYear+'/'+currentMonth+'/'+currentTab;
		window.location.href = clean_uri;
	}
// requires jquery library
$(document).ready(function() {
   $(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');
$(".main-table1").clone(true).appendTo('#table-scroll1').addClass('clone');   
 });

</script>
<style>
.table-scroll {
	position:relative;
	
	margin:auto;
	overflow:hidden;
	border:1px solid #000;
}
.table-wrap {
	width:100%;
	overflow:auto;
}
.table-scroll table {
	width:100%;
	margin:auto;
	border-collapse:separate;
	border-spacing:0;
}
.table-scroll th, .table-scroll td {
	padding:5px 10px;
	border:1px solid #000;
	background:#fff;
	white-space:nowrap;
	vertical-align:top;
}
.table-scroll thead, .table-scroll tfoot {
	background:#f9f9f9;
}
.clone {
	position:absolute;
	top:0;
	left:0;
	pointer-events:none;
}
.clone th, .clone td {
	visibility:hidden
}
.clone td, .clone th {
	border-color:transparent
}
.clone tbody th {
	visibility:visible;
	color:red;
}
.clone .fixed-side {
	border:1px solid #000;
	background:#eee;
	visibility:visible;
}
.clone thead, .clone tfoot{background:transparent;}
</style>
@endpush
