@extends('adminLayout') 
@section('title', 'Room Sales - Listing') 
@section('content')
{{-- <style>
	#bar-chart div.xAxis div.tickLabel 
	{    
		transform: rotate(-55deg);
		-ms-transform:rotate(-55deg);
		-moz-transform:rotate(-55deg);
		-webkit-transform:rotate(-55deg);
		-o-transform:rotate(-55deg); 
	}
</style> --}}
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
  <!--END PAGE HEADER & BREADCRUMB-->
  <!--BEGIN CONTENT-->
  <!-- InstanceBeginEditable name="EditRegion2" -->
  
	<div class="page-content">
		<div id="tab-shopping">
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">Sales Report</div>
						<div class="panel-body">
							<div id="sp-chart-orders" style="width: 100%; height:300px"></div>
							<div class="order-detail">
								<div class="row">
									<div class="col-md-4">
										<div class="revenue-total">RM<span id='revenue-number'>0</span></div>
										<div class="revenue-title">Sales</div>
									</div>
									<div class="col-md-4">
										<div class="tax-total">RM<span id='tax-number'>0</span></div>
										<div class="tax-title">Average Daily Ration (ADR)</div>
									</div>
									<div class="col-md-4">
										<div class="shipping-total">RM<span id='shipping-number'>0</span></div>
										<div class="shipping-title">Revenue Per Available Room (RevPar)</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					

					
					<div class="panel panel-primary">
						<div class="panel-heading">Top 5 Customer Geographical Location</div>
						<div class="panel-body">
							<div id="area-chart-spline" style="width: 100%; height:300px"></div>
						</div>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="row ">
						<div class="col-md-12">
						  <div class="portlet portlet-blue">
							<div class="portlet-header">
							  <div class="caption text-white">Search Room Sales Report By Date</div>
							</div>
							<div class="portlet-body">
							  <form class="form-horizontal">
								<div class="form-group">
								  <label class="col-md-4 control-label">Booking Date</label>
								  <div class="col-md-8">
									<div class="input-group input-daterange">
										<?php   
										$start = $end = '';
										if(!empty($data['datesArr']['start'])){
											$start = $data['datesArr']['start'];
										}
										if(!empty($data['datesArr']['end'])){
											$end = $data['datesArr']['end'];
										}
										
										?>
									  <input type="text" name="start" class="form-control" required data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $start ?>"/>
									  <span class="input-group-addon">to</span>
									  <input type="text" name="end" class="form-control" required data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $end ?>"  />
									</div>
								  </div>
								</div>
								
								<!-- save button start -->
								<div class="form-actions text-center"> <button type="submit" class="btn btn-red">Search &nbsp;<i class="fa fa-search"></i></button> </div>
								<!-- save button end -->
							  </form>
							</div>
							<!-- end portlet-body -->
						  </div>
						  <!-- end portlet -->
						</div>
						<!-- end col-md-6 -->
					</div>
					<div class="row">
						<div class="col-md-6 col-xs-12">
						<?php if(!empty($data['qtyStockSumArr'])){ ?>
							<div class="panel">
								<div class="panel-body"><h6 class="block-heading">Rooms on the Market<!--<span
										class="pull-right"><span id='earning-number'></span></span>--></h6>

									<div id="earning-chart" style="width: 100%; height:100px"></div>
								</div>
							</div>
						<?php } ?>
							<?php 
							
							if(!empty($data['topSoldRoomArr'])){ ?>
							<div class="panel">
								<div class="panel-body"><h6 class="block-heading">Top 3 Rooms Sold</h6>
									<span class="text-12px"><div id="traffice-sources-chart" style="width: 100%; height:100px"></div></span>
								</div>
							</div>
							<?php } ?>
							
							<div class="panel">
								<div class="panel-body">
									<h6 class="block-heading">Website Conversion Rate</h6>
									<div class="lifetime-sales">
										<div class="row">
											<div class="col-md-4 text-center">
												<div class="ls-chart"><input type="text" rel="<?php echo $data['totalsForAllResults']['ga:goalConversionRateAll'] ?>" value="<?php echo $data['totalsForAllResults']['ga:goalCompletionsAll'] ?>" data-width="75" data-height="75" data-readOnly="true" data-min="0" data-max="100" class="dial"/></div>
											</div>
											<div class="col-md-8 mts">
												<div class="ls-total"><span id='ls-number'><?php echo $data['totalsForAllResults']['ga:goalCompletionsAll'] ?></span></div>
												<div class="ls-title">Goal Completion</div>
											</div>
										</div>
									</div>
								</div>
							</div><!-- end panel -->
							
							<div class="panel">
								<div class="panel-body">
									<!--<h6 class="block-heading">Website Conversion Rate</h6>-->
									<div class="lifetime-sales">
										<div class="row">
											<div class="col-md-4 text-center">
												<div class="ls-chart2"><input type="text" rel="<?php echo $data['room_sales_report_graph']; ?>" value="0" data-width="75" data-height="75" data-readOnly="true" data-min="0" data-max="100" class="dial"/></div>
											</div>
											<div class="col-md-8 mts">
												<!--<div class="ls-total"><span id='ls-number'>0</span></div>-->
												<div class="ls-title">Sold Rooms Per Available Inventory Ratio</div>
											</div>
										</div>
									</div>
								</div>
							</div><!-- end panel -->
							
						</div>
						<div class="col-md-6 col-xs-12">
						<?php if(!empty($data['productOnPromoQtyStockSumArr'])){ ?>
							<div class="panel">
								<div class="panel-body"><h6 class="block-heading"># Rooms on Promotion<!--<span
										class="pull-right"><span id='new-customer-number'></span></span>--></h6>

									<div id="new-customer-chart" style="width: 100%; height:100px"></div>
								</div>
							</div>
						<?php } ?>
							<div class="panel">
								<div class="panel-body"><h6 class="block-heading"># Rooms Types Sold Out<!--<span
										class="pull-right"><span id='new-customer-number'></span></span>--></h6>

									<div id="rooms-types-sold" style="width: 100%; height:100px"></div>
								</div>
							</div>
							<input type="hidden" name="drr" id="drr" value="{{$data['drr']}}" />
							<div class="panel">
								<div class="panel-body">
									<h6 class="block-heading">DRR <span class="text-12px">(Direct Revenue Ratio) <span class="text-danger">(<?php echo $data['settings']['third_party_sale_period']; ?>)</span></span></h6>
									<div class="average-orders">
										<div class="row">
											<div class="col-md-4 text-center">
												<div class="ao-chart"><input type="text" rel="<?php echo $data['drr_percentage']; ?>" value="0" data-width="75" data-height="75" data-readOnly="true" data-min="0" data-max="100" class="dial"/></div>
											</div>
											<div class="col-md-8 mts">
												<div class="ao-total">RM <span id='ao-number'>0</span></div>
												<!--<div class="ao-title">Average Bookings</div>-->
											</div>
										</div>
									</div>
								</div>
							</div><!-- end panel -->
						</div>
					</div>
				</div><!-- end col-md-6-->
				<div class="col-md-12">
					<div class="panel panel-primary ">
						<div class="panel-heading">Sales by Room Type</div>
						<div class="panel-body">
							<div id="bar-chart" style="width: 100%; height:400px;margin-bottom: 60px;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
        <!--END CONTENT-->
        <!--BEGIN FOOTER-->
    <div class="page-footer">
      <div class="copyright"><span class="text-15px">2015 &copy; <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
       <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies Sdn Bhd"></div>
     </div>
   </div>
   <!--END FOOTER-->
	<!--LOADING SCRIPTS FOR PAGE-->
	<script src="{{ asset('/public/admin/vendors/jquery-knob/jquery.knob.js') }}"></script>
	<script src="{{ asset('/public/admin/vendors/jquery-animateNumber/jquery.animateNumber.min.js') }}"></script>
	<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.js') }}"></script>
	<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.categories.js') }}"></script>


	<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.pie.js') }}"></script>
	<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.tooltip.js') }}"></script>
	<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.resize.js') }}"></script>
	<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.fillbetween.js') }}"></script>
	<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.stack.js') }}"></script>
	<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.spline.js') }}"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>

	  <script>
		$(function () {
			
			/***********************************/
			/********* TAB SHOPPING ************/
			
			//BEGIN JQUERY FLOT CHART

			
			
			var d1 = <?php echo $data['ordersArr'] ?>;
			$.plot("#sp-chart-orders", [
				{
					data: d1,
					color: "#5cb85c"
				}
			], {
				series: {
					lines: {
						show: !0,
						fill: true,
						fillColor: {
							colors: [
								{
									opacity: 0.0
								},
								{
									opacity: 0.6
								}
							]
						}
					},
					points: {
						show: !0,
						radius: 4
					}
				},
				grid: {
					borderColor: "#fafafa",
					borderWidth: 1,
					hoverable: !0
				},
				tooltip: !0,
				tooltipOpts: {
					content: "%x : %y",
					defaultTheme: false
				},
				xaxis: {
					tickColor: "#fafafa",
					mode: "categories"
				},
				yaxis: {
					tickColor: "#fafafa"
				},
				shadowSize: 0
			});
			
			// bar chart
			var d3 = <?php echo $data['salesByRoomTypeArr'] ?>;

			// $.plot("#bar-chart", [
			// 	{
			// 		data: d3,
			// 		label: "Revenue",
			// 		color: "#df4782"
			// 	}
			// ], {
			// 	series: {
			// 		bars: {
			// 			align: "center",
			// 			lineWidth: 0,
			// 			show: !0,
			// 			barWidth: .6,
			// 			fill: .9
			// 		}
			// 	},
			// 	grid: {
			// 		borderColor: "#fafafa",
			// 		borderWidth: 1,
			// 		hoverable: !0
			// 	},
			// 	tooltip: !0,
			// 	tooltipOpts: {
			// 		content: "%x : %y",
			// 		defaultTheme: false
			// 	},
			// 	xaxis: {
			// 		tickColor: "#fafafa",
			// 		mode: "categories"
			// 	},
			// 	yaxis: {
			// 		tickColor: "#fafafa"
			// 	},
			// 	shadowSize: 0
			// });
			
			Highcharts.chart('bar-chart', {
				chart: {
					type: 'column'
				},
				title: {
					text: 'Sales by Room Type'
				},
				xAxis: {
					categories: [
						'Room Types'
					],
					crosshair: true
				},
				yAxis: {
					min: 0,
				},
				tooltip: {
					valueSuffix: ''
				},
				plotOptions: {
					column: {
						pointPadding: 0.2,
						borderWidth: 0
					}
				},
				series: [
					{!! $data['charts'] !!}
				]
			});
			
			// bar chart
			
			//BEGIN AREA CHART SPLINE
			
			var d6_1 = <?php echo $data['newCustomersArr'] ?>
			
			var d6_2 = <?php echo $data['returnCustomersArr'] ?>
			
			$.plot("#area-chart-spline", [

					{

					data: d6_1,
							label: "New Visitor",
							color: "#a01518"

							},
					{

					data: d6_2,
							label: "Returning Visitor",
							color: "#01b6ad"

							}

			], {

			series: {

			lines: {

			show: !1

					},
					splines: {

					show: !0,
							tension: .4,
							lineWidth: 2,
							fill: .8

					},
					points: {

					show: !0,
							radius: 4

					}

			},
					grid: {

					borderColor: "#fafafa",
							borderWidth: 1,
							hoverable: !0

					},
					tooltip: !0,
					tooltipOpts: {

					content: "%x : %y",
							defaultTheme: false

					},
					xaxis: {

					tickColor: "#fafafa",
							mode: "categories"

					},
					yaxis: {

					tickColor: "#fafafa"

					},
					shadowSize: 0

					});
			//END AREA CHART SPLINE
			
		});
			//END JQUERY FLOT CHART
			
		
		//BEGIN CHART Top 3 rooms sold

		$.plot('#traffice-sources-chart', <?php echo $data['topSoldRoomArr'] ?>, {
			series: {
				pie: {
					show: true
				}
			},
			grid: {
				hoverable: true,
				clickable: true
			}
		});
		//END CHART Top 3 rooms sold

		
		//BEGIN CHART Rooms on the market
		var d2 = <?php echo $data['qtyStockSumArr'] ?>;
		$.plot("#earning-chart", [
			{
				data: d2,
				color: "#ffce54"
			}
		], {
			series: {
				lines: {
					show: !0,
					fill: .01
				},
				points: {
					show: !0,
					radius: 4
				}
			},
			grid: {
				borderColor: "#fafafa",
				borderWidth: 1,
				hoverable: !0
			},
			tooltip: !0,
			tooltipOpts: {
				content: "%x : %y",
				defaultTheme: false
			},
			xaxis: {
				tickColor: "#fafafa",
				mode: "categories"
			},
			yaxis: {
				tickColor: "#fafafa"
			},
			shadowSize: 0
		});
		//END CHART rooms on the market
		
		
		//BEGIN CHART # rooms on promotion
		<?php if(!empty($data['productOnPromoQtyStockSumArr'])){ ?>
			var d8 = <?php echo $data['productOnPromoQtyStockSumArr'] ?>;
			$.plot("#new-customer-chart", [
				{
					data: d8,
					color: "#01b6ad"
				}
			], {
				series: {
					bars: {
						align: "center",
						lineWidth: 0,
						show: !0,
						barWidth: .6,
						fill: .9
					}
				},
				grid: {
					borderColor: "#fafafa",
					borderWidth: 1,
					hoverable: !0
				},
				tooltip: !0,
				tooltipOpts: {
					content: "%x : %y",
					defaultTheme: false
				},
				xaxis: {
					tickColor: "#fafafa",
					mode: "categories"
				},
				yaxis: {
					tickColor: "#fafafa"
				},
				shadowSize: 0
			});
		<?php } ?>
		//END CHART # rooms on promotion
		
		
		//BEGIN CHART # rooms types sold out
		var d9 = <?php echo $data['roomTypeSoldArr'] ?>;
		$.plot("#rooms-types-sold", [
			{
				data: d9,
				color: "#87318c"
			}
		], {
			series: {
				bars: {
					align: "center",
					lineWidth: 0,
					show: !0,
					barWidth: .6,
					fill: .9
				}
			},
			grid: {
				borderColor: "#fafafa",
				borderWidth: 1,
				hoverable: !0
			},
			tooltip: !0,
			tooltipOpts: {
				content: "%x : %y",
				defaultTheme: false
			},
			xaxis: {
				tickColor: "#fafafa",
				mode: "categories"
			},
			yaxis: {
				tickColor: "#fafafa"
			},
			shadowSize: 0
		});
		//END CHART # rooms types sold out

		function showTooltip(x, y, contents) { 
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fff',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
		
		var previousPoint = null;
		$("#rooms-types-sold").bind("plothover", function (event, pos, item) {
			if (item) {
				previousPoint = item.dataIndex;
				$("#tooltip").remove();
				showTooltip(item.pageX, item.pageY, item.series.data[item.dataIndex][2].roomType.toString());
			}
			else {
				$("#tooltip").remove();
				previousPoint = null;            
			}
			
		});
		
		var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',');

		//BEGIN JQUERY KNOB
	    $(".dial").knob({
	        'draw': function () {
	            $(this.i).val(this.cv + '%')
	        },
	        'fgColor': '#B8BEC8'
	    });
	    $({value: 0}).animate({value: $('.ls-chart input').attr("rel")}, {
	        duration: 5000,
	        easing: 'swing',
	        step: function () {
	            $('.ls-chart input').val(Math.ceil(this.value)).trigger('change');
	        }
	    })
	    $({value: 0}).animate({value: $('.ls-chart2 input').attr("rel")}, {
	        duration: 5000,
	        easing: 'swing',
	        step: function () {
	            $('.ls-chart2 input').val(Math.ceil(this.value)).trigger('change');
	        }
	    })
	    $({value: 0}).animate({value: $('.ao-chart input').attr("rel")}, {
	        duration: 5000,
	        easing: 'swing',
	        step: function () {
	            $('.ao-chart input').val(Math.ceil(this.value)).trigger('change');
	        }
	    })
	    //END JQUERY KNOB



		//BEGIN JQUERY ANIMATE NUMBER
	    /*$('#revenue-number').animateNumber({
	        number: 3579.95,
	        numberStep: comma_separator_number_step
	    }, 5000);
	    $('#tax-number').animateNumber({
	        number: 295.35,
	        numberStep: comma_separator_number_step
	    }, 5000);
	    $('#shipping-number').animateNumber({
	        number: 30.00,
	        numberStep: comma_separator_number_step
	    }, 5000);
	    $('#quantity-number').animateNumber({
	        number: 14,
	        numberStep: comma_separator_number_step
	    }, 5000);
	    $('#ls-number').animateNumber({
	        number: 252983,
	        numberStep: comma_separator_number_step
	    }, 5000);*/

	    var drr = $('#drr').val();
	    $('#ao-number').animateNumber({
	        number: drr,
	        numberStep: comma_separator_number_step
	    }, 5000);
	    //END JQUERY ANIMATE NUMBER

	  </script>
@endsection