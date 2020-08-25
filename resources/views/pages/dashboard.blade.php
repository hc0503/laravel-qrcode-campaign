@extends('layouts/contentLayoutMaster')

@section('title', trans('locale.Dashboard'))

@section('vendor-style')
	{{-- vendor css files --}}
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
@endsection

@section('page-style')
	<style>
		.custom-select {
			height: auto;
		}
	</style>
@endsection

@section('content')

	@foreach($notReadNotifications as $notReadNotification)
		<div class="alert alert-primary alert-dismissible fade show" role="alert">
			<p class="mb-0">
				{{ $notReadNotification->text }}
			</p>
			<button type="button" onclick="readNotification({{ $notReadNotification->id }});" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
	</div>
	@endforeach
	<div class="row">
		<!-- Usage Statistics -->
		<div class="col-lg-6 col-md-12 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">@lang('locale.UsageStatistics')</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<div class="height-400">
							<canvas id="bar-chart"></canvas>
					  	</div>
					</div>
				</div>
			</div>
		</div>
		<!--/ Usage Statistics -->

		<!-- Maps -->
		<div class="col-lg-6 col-md-12 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">@lang('locale.Maps')</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<div class="height-400">
							<!-- Radio box -->
							<ul class="list-unstyled">
								<li class="d-inline-block mr-2">
								  <fieldset>
									<div class="vs-radio-con">
										<input type="radio" name="mapRadio" checked value="today">
										<span class="vs-radio">
										  <span class="vs-radio--border"></span>
										  <span class="vs-radio--circle"></span>
										</span>
										<span class="">@lang('locale.ScannedToday')</span>
									 </div>
								  </fieldset>
								</li>
								<li class="d-inline-block mr-2">
								  <fieldset>
									 <div class="vs-radio-con">
										<input type="radio" name="mapRadio" value="week">
										<span class="vs-radio">
										  <span class="vs-radio--border"></span>
										  <span class="vs-radio--circle"></span>
										</span>
										<span class="">@lang('locale.ScannedThisWeek')</span>
									 </div>
								  </fieldset>
								</li>
								<li class="d-inline-block mr-2">
								  <fieldset>
									 <div class="vs-radio-con">
										<input type="radio" name="mapRadio" value="month">
										<span class="vs-radio">
										  <span class="vs-radio--border"></span>
										  <span class="vs-radio--circle"></span>
										</span>
										<span class="">@lang('locale.ScannedThisMonth')</span>
									 </div>
								  </fieldset>
								</li>
								<li class="d-inline-block mr-2">
								  <fieldset>
									 <div class="vs-radio-con">
										<input type="radio" name="mapRadio" value="all">
										<span class="vs-radio">
										  <span class="vs-radio--border"></span>
										  <span class="vs-radio--circle"></span>
										</span>
										<span class="">@lang('locale.AllScans')</span>
									 </div>
								  </fieldset>
								</li>
							</ul>
							<!--/ Radio box -->

							<div id="googleMap" class="height-300">

							</div>
					  	</div>
					</div>
				</div>
			</div>
		</div>
		<!--/ Maps -->
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">@lang('locale.QRCodeAccessHits')</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<div class="table-responsive">
							<table id="campaignHitTable" class="table table-striped">
								<thead>
									<tr>
										<th>@lang('locale.id')</th>
										<th>@lang('locale.campaign.field.name')</th>
										<th>@lang('locale.Location')</th>
										<th>@lang('locale.Browser')</th>
										<th>@lang('locale.CreatedAt')</th>
									</tr>
								</thead>
								<tbody>
									@foreach($campaignHits as $campaignHit)
									<tr>
										<td>{{ $campaignHit->id }}</td>
										<td>{{ $campaignHit->campaign->campaign_name }}</td>
										<td>{{ $campaignHit->location }}</td>
										<td>{{ $campaignHit->browser }}</td>
										<td>{{ $campaignHit->created_at }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('vendor-script')
	<!-- vendor files -->
	<script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
	<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBgjNW0WA93qphgZW-joXVR6VC3IiYFjfo"></script>
	<script src="{{ asset(mix('vendors/js/charts/gmaps.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
@endsection

@section('page-script')
	<script>
		var primary = '#7367F0';
		var grid_line_color = '#dae1e7';
		var success = '#28C76F';
		var danger = '#EA5455';
		var warning = '#FF9F43';
		var label_color = '#1E1E1E';
		var campaignNames = {!! $campaignNames !!};
		var campaignHitCounts = {!! $campaignHitCounts !!};
		var initLat = 40.730610;
		var InitLng = -73.935242;
		var initZoom = 3;
		var initType = 'today';
		var googleMap = new GMaps({
			div: '#googleMap',
			lat: initLat,
			lng: InitLng,
			zoom: initZoom
		});

		$(document).ready(function () {
			$('#campaignHitTable').DataTable();
			initMap(initType);

			$('input[type=radio][name=mapRadio]').change(function(e) {
				initMap(this.value);
		  });

		  $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		});

		/**
		* Init map from ajax data per type {today, week, month, all}
		*
		* @param {string}  type
		*/
		function initMap(type) {
			$.ajax({
				url: "{{ url('/coordinates') }}",
				data: {
					type: type
				},
				dataType: "JSON",
				success : function (data, status, jqXhr) {
					if (jqXhr.status === 200) {
						addMarker(data, googleMap);
					}
				}
			});
		}

		/**
		* Clear old markers and add new markers
		*
		* @param {json}  data
		* @param {GMaps}  googleMap
		*/
		function addMarker(data, googleMap) {
			$.each(googleMap.markers, function(index, marker) {
				marker.setMap(null);
			  });

			data.forEach(function(item, index) {
				googleMap.addMarker({
					lat: item['latitude'],
					lng: item['longitude'],
					title: item['location'],
					infoWindow: {
						content: item['location'] + '<p class="mb-0">Latitude: '+ item['latitude'] + ', Longitude: ' + item['longitude'] + '</p>'
				  }
			  });
			});
		}

		// Bar Chart
		// ------------------------------------------
		//Get the context of the Chart canvas element we want to select
		var barChartctx = $("#bar-chart");
		// Chart Options
		var barchartOptions = {
			// Elements options apply to all of the options unless overridden in a dataset
			// In this case, we are setting the border of each bar to be 2px wide
			elements: {
				rectangle: {
				borderWidth: 2,
				borderSkipped: 'left'
				}
			},
			responsive: true,
			maintainAspectRatio: false,
			responsiveAnimationDuration: 500,
			legend: { display: false },
			scales: {
				xAxes: [{
				 	display: true,
				 	gridLines: {
						color: grid_line_color,
				 	},
				 	scaleLabel: {
						display: true,
				 	}
				}],
				yAxes: [{
				 	display: true,
				 	gridLines: {
						color: grid_line_color,
				 	},
				 	scaleLabel: {
						display: true,
				 	},
				 	ticks: {
						stepSize: 1000
				 	},
				}],
			},
		};
		// Chart Data
		var barchartData = {
			labels: campaignNames,
			datasets: [{
			  	label: "{{ trans('locale.ScannedCount') }}",
			  	data: campaignHitCounts,
			  	backgroundColor: primary,
			  	borderColor: "transparent"
			}]
		};
		var barChartconfig = {
			type: 'bar',
	  
			// Chart Options
			options: barchartOptions,
	  
			data: barchartData
		};
		// Create the chart
		var barChart = new Chart(barChartctx, barChartconfig);

		function readNotification(notificationId) {
			$.ajax({
				url: "{{ url('/notifications/read') }}",
				type: "POST",
				data: {
					notification_id: notificationId
				},
				dataType: "text",
				success : function (data, status, jqXhr) {
					if (jqXhr.status === 200) {
						console.log('success');
					}
				}
			});
		}
	</script>
@endsection