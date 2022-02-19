@extends('adminLayout') 
@section('title', 'Google Analytics Report') 
@section('content')
<script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart'],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyDMy1qY4JaJj_HtCiNjXBq0dYhyxWgkDdg'
      });
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable(<?php echo $data['usersByCountryForMap'] ?>);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
    </script>
<div id="page-wrapper">
  <!--BEGIN PAGE HEADER & BREADCRUMB-->
  	<div class="page-header-breadcrumb">
	    <div class="page-heading hidden-xs">
	      <h1 class="page-title">Analytics Report</h1>
	    </div>

	    <!-- InstanceBeginEditable name="EditRegion1" -->
	    <ol class="breadcrumb page-breadcrumb">
	      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('web88cms/dashboard') }}">Dashboard</a>&nbsp; <i class="fa fa-angle-right"></i>&nbsp;</li>
	      <li>Analytics Report </li>
	    </ol>
	    <!-- InstanceEndEditable -->
  	</div>
  <!--END PAGE HEADER & BREADCRUMB-->
  <!--BEGIN CONTENT-->
  <!-- InstanceBeginEditable name="EditRegion2" -->
  
  	<div class="page-content">
  		<!-- <div style="border: 1px solid #ccc; padding: 10px; height: 70px; border-radius: 5px;" class="col-sm-3">
  			<div class="col-sm-3">
  				<div class="ls-users"><input type="text" rel="100" value="100" data-width="40" data-height="75" data-readOnly="true" data-min="0" data-max="100" class="dial"/></div>
  			</div>
  			<div class="col-sm-9">
  				<span>All Users</span>
  			</div>
  		</div> -->
  		<?php
  		$bigGraph = 'users';
  		if(!empty($_GET['bigGraph'])){
  			$bigGraph = $_GET['bigGraph'];
  		}
  		?>
  		<div class="col-sm-3">
  			<select name="graphOptions" class="form-control" id="graphOptions">
  				<option value="avgSessionDuration" <?php echo (!empty($bigGraph) && ($bigGraph=='avgSessionDuration'))?'selected':'' ?> >Avg. Session Duration</option>
  				<option value="bounceRate" <?php echo (!empty($bigGraph) && ($bigGraph=='bounceRate'))?'selected':'' ?> >Bounce Rate</option>
  				<option value="newUsers" <?php echo (!empty($bigGraph) && ($bigGraph=='newUsers'))?'selected':'' ?> >New Users</option>
  				<option value="numberOfSessionsPerUser" <?php echo (!empty($bigGraph) && ($bigGraph=='numberOfSessionsPerUser'))?'selected':'' ?> >Number of Sessions per User</option>
  				<option value="pagesSession" <?php echo (!empty($bigGraph) && ($bigGraph=='pagesSession'))?'selected':'' ?> >Pages / Session</option>
  				<option value="pageviews" <?php echo (!empty($bigGraph) && ($bigGraph=='pageviews'))?'selected':'' ?> >Pageviews</option>
  				<option value="sessions" <?php echo (!empty($bigGraph) && ($bigGraph=='sessions'))?'selected':'' ?> >Sessions</option>
  				<option value="users" <?php echo (empty($bigGraph) || ($bigGraph=='users'))?'selected':'' ?>>Users</option>
  			</select>
  		</div>
  		<div class="col-sm-1 text-center">
  			<b>VS</b>
  		</div>
  		<?php
  		if(!empty($_GET['metricOptions'])){
  			$metricOptions = $_GET['metricOptions'];
  		}
  		?>
  		<div class="col-sm-3">
  			<select name="metricOptions" class="form-control" id="metricOptions">
  				<option value="">-- Select a metric --</option>
  				<?php if($bigGraph!='avgSessionDuration'){ ?>
  				<option value="avgSessionDuration" <?php echo (!empty($metricOptions) && ($metricOptions=='avgSessionDuration'))?'selected':'' ?> >Avg. Session Duration</option>
  				<?php } ?>
  				<?php if($bigGraph!='bounceRate'){ ?>
  				<option value="bounceRate" <?php echo (!empty($metricOptions) && ($metricOptions=='bounceRate'))?'selected':'' ?> >Bounce Rate</option>
  				<?php } ?>
  				<?php if($bigGraph!='newUsers'){ ?>
  				<option value="newUsers" <?php echo (!empty($metricOptions) && ($metricOptions=='newUsers'))?'selected':'' ?> >New Users</option>
  				<?php } ?>
  				<?php if($bigGraph!='numberOfSessionsPerUser'){ ?>
  				<option value="numberOfSessionsPerUser" <?php echo (!empty($metricOptions) && ($metricOptions=='numberOfSessionsPerUser'))?'selected':'' ?> >Number of Sessions per User</option>
  				<?php } ?>
  				<?php if($bigGraph!='pagesSession'){ ?>
  				<option value="pagesSession" <?php echo (!empty($metricOptions) && ($metricOptions=='pagesSession'))?'selected':'' ?> >Pages / Session</option>
  				<?php } ?>
  				<?php if($bigGraph!='pageviews'){ ?>
  				<option value="pageviews" <?php echo (!empty($metricOptions) && ($metricOptions=='pageviews'))?'selected':'' ?> >Pageviews</option>
  				<?php } ?>
  				<?php if($bigGraph!='sessions'){ ?>
  				<option value="sessions" <?php echo (!empty($metricOptions) && ($metricOptions=='sessions'))?'selected':'' ?> >Sessions</option>
  				<?php } ?>
  				<?php if($bigGraph!='users'){ ?>
  				<option value="users" <?php echo (!empty($metricOptions) && ($metricOptions=='users'))?'selected':'' ?> >Users</option>
  				<?php } ?>
  			</select>
  		</div>
  		<br><br>
		<div id="tab-shopping">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
                        <div class="panel-heading">Audience Overview</div>
                        <div class="panel-body">
                            <div id="sp-chart-dateWiseUsers" style="width: 100%; height:300px"></div>
                        </div>
                    </div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<span class="text-primary">Users : <?php echo $data['ga:users'] ?></span>
					<div id="sp-chart-dateWiseUsers2" style="width: 100%; height:100px"></div>
				</div>
				<div class="col-md-6">
					<span class="text-primary">New Users : <?php echo $data['ga:newUsers'] ?></span>
					<div id="sp-chart-dateWiseNewUsers" style="width: 100%; height:100px"></div>
				</div>
			</div>
			<br><br>
			<div class="row">
				<div class="col-md-6">
					<span class="text-primary">Sessions : <?php echo $data['ga:sessions'] ?></span>
					<div id="sp-chart-sessions" style="width: 100%; height:100px"></div>
				</div>
				<div class="col-md-6">
					<span class="text-primary">Number of Sessions per Users : <?php echo $data['ga:sessionsPerUser'] ?></span>
					<div id="sp-chart-dateWiseSessionsPerUser" style="width: 100%; height:100px"></div>
				</div>
			</div>
			<br><br>
			<div class="row">
				<div class="col-md-6">
					<span class="text-primary"><a href="#page_views" onclick="togglePageView();changeTab('page_views')" data-toggle="tab">Pageviews : <?php echo $data['ga:pageviews'] ?></a></span>
					<div id="sp-chart-dateWisePageviewsPerSession" style="width: 100%; height:100px"></div>
				</div>
				<div class="col-md-6">
					<span class="text-primary">Pages/Session : <?php echo number_format($data['ga:pageviewsPerSession'],2) ?></span>
					<div id="sp-chart-dateWisePageViews" style="width: 100%; height:100px"></div>
				</div>
			</div>
			<br><br>
			<div class="row">
				<div class="col-md-6">
					<span class="text-primary">Avg Session Duration : <?php echo $data['ga:avgSessionDuration'] ?></span>
					<div id="sp-chart-dateWiseAvgSessionDuration" style="width: 100%; height:100px"></div>
				</div>
				<div class="col-md-6">
					<span class="text-primary">Bounce Rate : <?php echo number_format($data['ga:bounceRate'],2) ?>%</span>
					<div id="sp-chart-dateWiseBounceRate" style="width: 100%; height:100px"></div>
				</div>
				
			</div>

		</div>
		<hr>
		<div class="col-sm-12" id="analytic_tab">
		 	<ul id="myTab" class="nav nav-tabs">
				<li class="active"><a href="#country" onclick="changeTab('country')" data-toggle="tab">Country</a></li>
                <li class="" ><a href="#city" onclick="changeTab('city')" data-toggle="tab">City</a></li>
                <li class="" ><a href="#continent" onclick="changeTab('continent')" data-toggle="tab">Continent</a></li>
                <li class="" ><a href="#sub_continent" onclick="changeTab('sub_continent')" data-toggle="tab">Sub Continent</a></li>
                <li class="" ><a href="#language" onclick="changeTab('language')" data-toggle="tab">Language</a></li>
                <li class="" ><a href="#page_views" id="page_views_tab" onclick="changeTab('page_views')" data-toggle="tab">Page Views</a></li>
          	</ul>

          	 <div id="myTabContent" class="tab-content" style="overflow:scroll;">
          	 	<div id="country" class="tab-pane fade in active"> 
					<table style="width: 100%">
						<tr>
							<th>Country</th>
							<th>Users</th>
							<th>New Users</th>
							<th>Sessions</th>
							<th>Bounce Rate</th>
							<th>Pages/Session</th>
							<th>Avg. Session Duration</th>
						</tr>
						<?php foreach ($data['answerByCountry']->rows as $key => $value) { ?>
							<tr>
								<td><?php echo $value[0] ?></td>
								<td><?php echo $value[1] ?></td>
								<td><?php echo $value[4] ?></td>
								<td><?php echo $value[6] ?></td>
								<td><?php echo number_format($value[2],2) ?>%</td>
								<td><?php echo number_format($value[7],2) ?></td>
								<td><?php 
								$avgSessionDuration = $value[5];
					            $hr = ($avgSessionDuration/3600);
					            $min = ($avgSessionDuration/60%60);
					            $sec = (ceil($avgSessionDuration)%60);
					            echo sprintf('%02d:%02d:%02d', round($hr),round($min), $sec);
								?></td>
							</tr>
						<?php } ?>
					</table>
				</div>

				<div id="city" class="tab-pane fade"> 
					<table style="width: 100%">
						<tr>
							<th>City</th>
							<th>Users</th>
							<th>New Users</th>
							<th>Sessions</th>
							<th>Bounce Rate</th>
							<th>Pages/Session</th>
							<th>Avg. Session Duration</th>
						</tr>
						<?php foreach ($data['answerByCity']->rows as $key => $value) { ?>
							<tr>
								<td><?php echo $value[0] ?></td>
								<td><?php echo $value[1] ?></td>
								<td><?php echo $value[4] ?></td>
								<td><?php echo $value[6] ?></td>
								<td><?php echo number_format($value[2],2) ?>%</td>
								<td><?php echo number_format($value[7],2) ?></td>
								<td><?php 
								$avgSessionDuration = $value[5];
					            $hr = ($avgSessionDuration/3600);
					            $min = ($avgSessionDuration/60%60);
					            $sec = (ceil($avgSessionDuration)%60);
					            echo sprintf('%02d:%02d:%02d', round($hr),round($min), $sec);
								?></td>
							</tr>
						<?php } ?>
					</table>
				</div>


				<div id="continent" class="tab-pane fade"> 
					<table style="width: 100%">
						<tr>
							<th>Continent</th>
							<th>Users</th>
							<th>New Users</th>
							<th>Sessions</th>
							<th>Bounce Rate</th>
							<th>Pages/Session</th>
							<th>Avg. Session Duration</th>
						</tr>
						<?php foreach ($data['answerByContinent']->rows as $key => $value) { ?>
							<tr>
								<td><?php echo $value[0] ?></td>
								<td><?php echo $value[1] ?></td>
								<td><?php echo $value[4] ?></td>
								<td><?php echo $value[6] ?></td>
								<td><?php echo number_format($value[2],2) ?>%</td>
								<td><?php echo number_format($value[7],2) ?></td>
								<td><?php 
								$avgSessionDuration = $value[5];
					            $hr = ($avgSessionDuration/3600);
					            $min = ($avgSessionDuration/60%60);
					            $sec = (ceil($avgSessionDuration)%60);
					            echo sprintf('%02d:%02d:%02d', round($hr),round($min), $sec);
								?></td>
							</tr>
						<?php } ?>
					</table>
				</div>

				<div id="sub_continent" class="tab-pane fade"> 
					<table style="width: 100%">
						<tr>
							<th>Sub Continent</th>
							<th>Users</th>
							<th>New Users</th>
							<th>Sessions</th>
							<th>Bounce Rate</th>
							<th>Pages/Session</th>
							<th>Avg. Session Duration</th>
						</tr>
						<?php foreach ($data['answerBySubContinent']->rows as $key => $value) { ?>
							<tr>
								<td><?php echo $value[0] ?></td>
								<td><?php echo $value[1] ?></td>
								<td><?php echo $value[4] ?></td>
								<td><?php echo $value[6] ?></td>
								<td><?php echo number_format($value[2],2) ?>%</td>
								<td><?php echo number_format($value[7],2) ?></td>
								<td><?php 
								$avgSessionDuration = $value[5];
					            $hr = ($avgSessionDuration/3600);
					            $min = ($avgSessionDuration/60%60);
					            $sec = (ceil($avgSessionDuration)%60);
					            echo sprintf('%02d:%02d:%02d', round($hr),round($min), $sec);
								?></td>
							</tr>
						<?php } ?>
					</table>
				</div>

				<div id="page_views" class="tab-pane fade">
					<table style="width: 100%">
						<tr>
							<th>Page</th>
							<th>Pageviews</th>
						</tr>
						<?php foreach ($page_view as $page_data) { ?>
							<tr>
								<td>&nbsp;<a href="{{ url($page_data['url']) }}"><?php echo $page_data['url']; ?></a></td>
								<td><?php echo $page_data['pageViews'] ?></td>
							</tr>
						<?php } ?>
					</table>
				</div>

				<div id="language" class="tab-pane fade"> 
					<table style="width: 100%">
						<tr>
							<th>Language</th>
							<th>Users</th>
							<th>New Users</th>
							<th>Sessions</th>
							<th>Bounce Rate</th>
							<th>Pages/Session</th>
							<th>Avg. Session Duration</th>
						</tr>
						<?php foreach ($data['answerByLanguage']->rows as $key => $value) { ?>
							<tr>
								<td><?php echo $value[0] ?></td>
								<td><?php echo $value[1] ?></td>
								<td><?php echo $value[4] ?></td>
								<td><?php echo $value[6] ?></td>
								<td><?php echo number_format($value[2],2) ?>%</td>
								<td><?php echo number_format($value[7],2) ?></td>
								<td><?php 
								$avgSessionDuration = $value[5];
					            $hr = ($avgSessionDuration/3600);
					            $min = ($avgSessionDuration/60%60);
					            $sec = (ceil($avgSessionDuration)%60);
					            echo sprintf('%02d:%02d:%02d', round($hr),round($min), $sec);
								?></td>
							</tr>
						<?php } ?>
					</table>
				</div>

			</div>
		</div>
        <div class="clearfix"></div>
		
        <div class="col-sm-12">
        	<!--<div id="regions_div" style="width: 900px; height: 500px; "></div>-->
            <div id="regions_div" style="width: 100%; height:600px;"></div>
        </div>
        <div class="clearfix"></div>

	</div>
	<!--BEGIN FOOTER-->
    <div class="page-footer">
      <div class="copyright"><span class="text-15px">2015 &copy; <a href="http://www.webqom.com" target="_blank">Webqom Technologies Sdn Bhd.</a> Any queries, please contact <a href="mailto:support@webqom.com">Webqom Support</a>.</span>
       <div class="pull-right"><img src="{{ asset('/public/admin/images/logo_webqom.png') }}" alt="Webqom Technologies Sdn Bhd"></div>
     </div>
   </div>
   <!--END FOOTER-->
</div>

<!--LOADING SCRIPTS FOR PAGE-->
<script src="{{ asset('/public/admin/vendors/jquery-knob/jquery.knob.js') }}"></script>
<script type="text/javascript">
	function togglePageView() {
		$("#myTab li.active").removeClass("active");
		$("#myTab li #page_views_tab").parent().addClass("active");
		
		$('html, body').stop().animate({
			scrollTop: $('#analytic_tab').offset().top - 100
		}, 'normal');
	}
</script>
<script src="{{ asset('/public/admin/vendors/jquery-animateNumber/jquery.animateNumber.min.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.categories.js') }}"></script>

<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.tooltip.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.fillbetween.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.stack.js') }}"></script>
<script src="{{ asset('/public/admin/vendors/flot-chart/jquery.flot.spline.js') }}"></script>

<script type="text/javascript">
$(function () {


	$( "#graphOptions" ).change(function() {
		var graphOptionVal = $( "#graphOptions" ).val();
		var url = window.location.href.split("?")[0]; 
		window.location.href = url+'?bigGraph='+graphOptionVal;
	});

	$( "#metricOptions" ).change(function() {
		var graphOptionVal = $( "#graphOptions" ).val();
		var metricOptionsVal = $( "#metricOptions" ).val();
		var url = window.location.href.split("?")[0]; 
		window.location.href = url+'?bigGraph='+graphOptionVal+'&metricOptions='+metricOptionsVal;
	});

	/***********************************/
	/********* TAB SHOPPING ************/
	
	//BEGIN JQUERY FLOT CHART
	
	var d1 = <?php echo $data['dateWiseUsers'] ?>;

	$.plot("#sp-chart-dateWiseUsers2", [
		{
			data: d1,
			color: "#058dc7"
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


	var d2 = <?php echo $data['dateWiseBounceRate'] ?>;
	$.plot("#sp-chart-dateWiseBounceRate", [
		{
			data: d2,
			color: "#058dc7"
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

	var d3 = <?php echo $data['dateWiseSessions'] ?>;
	$.plot("#sp-chart-sessions", [
		{
			data: d3,
			color: "#058dc7"
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

	var d4 = <?php echo $data['dateWiseSessionsPerUser'] ?>;
	$.plot("#sp-chart-dateWiseSessionsPerUser", [
		{
			data: d4,
			color: "#058dc7"
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

	var d5 = <?php echo $data['dateWisePageviewsPerSession'] ?>; 
	$.plot("#sp-chart-dateWisePageViews", [
		{
			data: d5,
			color: "#058dc7"
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


	var d6 = <?php echo $data['dateWisePageViews'] ?>;
	$.plot("#sp-chart-dateWisePageviewsPerSession", [
		{
			data: d6,
			color: "#058dc7"
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



	var d7 = <?php echo $data['dateWiseNewUsers'] ?>;
	$.plot("#sp-chart-dateWiseNewUsers", [
		{
			data: d7,
			color: "#058dc7"
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

	var d8 = <?php echo $data['dateWiseAvgSessionDuration'] ?>;
	$.plot("#sp-chart-dateWiseAvgSessionDuration", [
		{
			data: d8,
			color: "#058dc7"
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

	var bigGraph = d1;
	var label = 'Users';
	<?php if($bigGraph=='avgSessionDuration'){ ?>
		bigGraph = d8;
		label = 'Avg Session Duration';
	<?php } ?>

	<?php if($bigGraph=='bounceRate'){ ?>
		bigGraph = d2;
		label = 'Bounce Rate';
	<?php } ?>

	<?php if($bigGraph=='newUsers'){ ?>
		bigGraph = d7;
		label = 'New Users';
	<?php } ?>

	<?php if($bigGraph=='numberOfSessionsPerUser'){ ?>
		bigGraph = d4;
		label = 'Number of Sessions per Users';
	<?php } ?>

	<?php if($bigGraph=='pagesSession'){ ?>
		bigGraph = d5;
		label = 'Pages / Session';
	<?php } ?>

	<?php if($bigGraph=='pageviews'){ ?>
		bigGraph = d6;
		label = 'Pageviews';
	<?php } ?>

	<?php if($bigGraph=='sessions'){ ?>
		bigGraph = d3;
		label = 'Sessions';
	<?php } ?>

	<?php if($bigGraph=='users'){ ?>
		bigGraph = d1;
		label = 'Users';
	<?php } ?>


	var metricGraph = '';
	var metricLabel = '';

	<?php if(!empty($metricOptions) && ($metricOptions=='avgSessionDuration')){ ?>
		metricGraph = d8;
		metricLabel = 'Avg Session Duration';
	<?php } ?>

	<?php if(!empty($metricOptions) && ($metricOptions=='bounceRate')){ ?>
		metricGraph = d2;
		metricLabel = 'Bounce Rate';
	<?php } ?>

	<?php if(!empty($metricOptions) && ($metricOptions=='newUsers')){ ?>
		metricGraph = d7;
		metricLabel = 'New Users';
	<?php } ?>

	<?php if(!empty($metricOptions) && ($metricOptions=='numberOfSessionsPerUser')){ ?>
		metricGraph = d4;
		metricLabel = 'Number of Sessions per Users';
	<?php } ?>

	<?php if(!empty($metricOptions) && ($metricOptions=='pagesSession')){ ?>
		metricGraph = d5;
		metricLabel = 'Pages / Session';
	<?php } ?>

	<?php if(!empty($metricOptions) && ($metricOptions=='pageviews')){ ?>
		metricGraph = d6;
		metricLabel = 'Pageviews';
	<?php } ?>

	<?php if(!empty($metricOptions) && ($metricOptions=='sessions')){ ?>
		metricGraph = d3;
		metricLabel = 'Sessions';
	<?php } ?>

	<?php if(!empty($metricOptions) && ($metricOptions=='users')){ ?>
		metricGraph = d1;
		metricLabel = 'Users';
	<?php } ?>

	var graphDataObj = [{
	    	data: bigGraph,
	        label: label,
	        color: "#058dc7"
	    }];

	if(metricLabel!=''){
		var metricObj = {
	    	data: metricGraph,
	        label: metricLabel,
	        color: "#cccccc"
	    };

		graphDataObj.push(metricObj);   

	}


		
/*
	    {
    	data: bigGraph,
        label: "New Visitor",
        color: "#058dc7"
    },
    {

        data: d4,
        label: "New Visitor",
        color: "#cccccc"
    }*/


	/////// Big Graph
	$.plot("#sp-chart-dateWiseUsers", graphDataObj, {
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




	$({value: 0}).animate({value: $('.ls-users input').attr("rel")}, {
        duration: 5000,
        easing: 'swing',
        step: function () {
            $('.ls-chart2 input').val(Math.ceil(this.value)).trigger('change');
        }
    });

    //BEGIN JQUERY KNOB
    $(".dial").knob({
        'draw': function () {
            $(this.i).val(this.cv + '%')
        },
        'fgColor': '#0078D7'
    });

});

</script>
@endsection
