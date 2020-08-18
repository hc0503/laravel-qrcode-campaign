@extends('layouts/contentLayoutMaster')

@section('title', trans('locale.Dashboard'))

@section('vendor-style')
	<!-- vendor css files -->
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/tether-theme-arrows.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/tether.min.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/shepherd-theme-default.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.css')) }}">
@endsection

@section('page-style')
	<!-- Page css files -->
	<link rel="stylesheet" href="{{ asset(mix('css/pages/dashboard-analytics.css')) }}">
@endsection

@section('content')
<section id="dashboard-analytics">
	<div class="row">
		<div class="col-lg-6 col-md-12 col-sm-12">
				<div class="card bg-analytics text-white">
						<div class="card-content">
								<div class="card-body text-center">
									<img src="{{ asset('images/elements/decore-left.png') }}" class="img-left" alt="card-img-left">
									<img src="{{ asset('images/elements/decore-right.png')}}" class="img-right" alt="card-img-right">
									<div class="avatar avatar-xl bg-primary shadow mt-0">
										<div class="avatar-content">
											<i class="feather icon-award white font-large-1"></i>
										</div>
									</div>
									<div class="text-center">
										<h1 class="mb-2 text-white" style="line-height: 37px;">GENERAL NOTIFICATION <br> SEND ALERT TO ALL USERS</h1>
									</div>
								</div>
						</div>
				</div>
		</div>
		<div class="col-lg-3 col-md-6 col-12">
				<div class="card">
						<div class="card-header d-flex flex-column align-items-start pb-0">
								<div class="avatar bg-rgba-primary p-50 m-0">
										<div class="avatar-content">
											<i class="feather icon-sliders text-primary font-medium-5"></i>
										</div>
								</div>
								<h2 class="text-bold-700 mt-1 mb-25">{{ $campaigns->count() }}</h2>
								<p class="mb-0">QR Codes Created</p>
						</div>
						<div class="card-content">
							<div id="subscribe-gain-chart"></div>
						</div>
				</div>
		</div>
		<div class="col-lg-3 col-md-6 col-12">
			<div class="card">
					<div class="card-header d-flex flex-column align-items-start pb-0">
							<div class="avatar bg-rgba-warning p-50 m-0">
								<div class="avatar-content">
									<i class="feather icon-wind text-warning font-medium-5"></i>
								</div>
							</div>
							<h2 class="text-bold-700 mt-1 mb-25">{{ $campaignHits->count() }}</h2>
							<p class="mb-0">QR Codes Scanned</p>
					</div>
					<div class="card-content">
						<div id="orders-received-chart"></div>
					</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 col-12">
			<div class="card">
				<div class="card-content">
					<div class="card-body">
						<div class="row pb-50">
							<div class="col-md-12 d-flex justify-content-between flex-column order-lg-1 order-2 mt-lg-0 mt-2">
								<h2 class="text-bold-700 mb-25">@lang('locale.campaign.management')</h2>
							</div>
						</div>
						<hr />
						<div class="row avg-sessions">
							<div class="col-md-12">
								<div class="table-responsive mt-1">
									<table class="table table-hover-animation mb-0" id="campaignTable">
										<thead>
										<tr>
											<th>@lang('locale.id')</th>
											<th>@lang('locale.campaign.authorName')</th>
											<th>@lang('locale.campaign.authorEmail')</th>
											<th>@lang('locale.campaign.field.name')</th>
											<th>@lang('locale.QRCode')</th>
											<th>@lang('locale.CreatedAt')</th>
											<th>@lang('locale.Actions')</th>
										</tr>
										</thead>
										<tbody>
										@foreach($campaigns as $campaign)
											<tr>
												<td>{{ $campaign->id }}</td>
												<td>{{ $campaign->user->name }} {{ $campaign->user->surname }}</td>
												<td>{{ $campaign->user->email }}</td>
												<td>{{ $campaign->campaign_name }}</td>
												<td>
													<a href="javascript:reviewCampaign({{ $campaign }});">
														<img src="qrcode/generate/{{ $campaign->id }}" width="50">
													</a>
												</td>
												<td>{{ $campaign->created_at }}</td>
												<td>
													<a href="javascript:deleteCampaign({{ $campaign->id }})" id="campaign_delete_{{$campaign->id}}" class="btn btn-icon rounded-circle btn-flat-danger waves-effect waves-light">
														<i class="feather icon-trash-2"></i>
													</a>
												</td>
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
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between pb-0">
					<h4 class="card-title">@lang('locale.qrcodeScanRate')</h4>
				</div>
				<div class="card-content">
					<div class="card-body pt-0">
						<div class="height-450">
							<canvas id="bar-chart"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade text-center" id="backdrop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xs" role="document">
			<div class="modal-content">
				<div class="modal-header">
						<h4 class="modal-title" id="code_title"></h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</button>
				</div>
				<div class="modal-body">
						<p id="code_url">

						</p>
						<img id="code_preview" src="" width="200">
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
    </div>
	</div>
@endsection

@section('vendor-script')
	<!-- vendor files -->
	<script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/extensions/tether.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/extensions/shepherd.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
	
@endsection

@section('page-script')
	<script>
		var $primary = '#7367F0';
		var $danger = '#EA5455';
		var $warning = '#FF9F43';
		var $info = '#0DCCE1';
		var $primary_light = '#8F80F9';
		var $warning_light = '#FFC085';
		var $danger_light = '#f29292';
		var $info_light = '#1edec5';
		var $strok_color = '#b9c3cd';
		var $label_color = '#e7eef7';
		var $white = '#fff';

		var compaigns_values = {!! $compaigns_values !!};
		var compaignhits_values = {!! $compaignhits_values !!};

		var campaigns = {!! $campaigns->pluck('campaign_name') !!};
		var scanned_values = {!! $scanned_values !!};
						
		var campaignTable;

		$(document).ready(function() {
			campaignTable = $('#campaignTable').DataTable();

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
		});

		// Subscribers Gained Chart starts //
		// ----------------------------------
		var gainedChartoptions = {
			chart: {
				height: 100,
				type: 'area',
				toolbar: {
					show: false,
				},
				sparkline: {
					enabled: true
				},
				grid: {
					show: false,
					padding: {
						left: 0,
						right: 0
					}
				},
			},
			colors: [$primary],
			dataLabels: {
				enabled: false
			},
			stroke: {
				curve: 'smooth',
				width: 2.5
			},
			fill: {
				type: 'gradient',
				gradient: {
					shadeIntensity: 0.9,
					opacityFrom: 0.7,
					opacityTo: 0.5,
					stops: [0, 80, 100]
				}
			},
			series: [{
				name: 'Created Count',
				data: compaigns_values
			}],

			xaxis: {
				labels: {
					show: false,
				},
				axisBorder: {
					show: false,
				}
			},
			yaxis: [{
				y: 0,
				offsetX: 0,
				offsetY: 0,
				padding: { left: 0, right: 0 },
			}],
			tooltip: {
				x: { show: false }
			},
		}

		var gainedChart = new ApexCharts(
			document.querySelector("#subscribe-gain-chart"),
			gainedChartoptions
		);

		gainedChart.render();
		// Subscribers Gained Chart ends //


		// Orders Received Chart starts //
		// ----------------------------------

		var orderChartoptions = {
			chart: {
				height: 100,
				type: 'area',
				toolbar: {
					show: false,
				},
				sparkline: {
					enabled: true
				},
				grid: {
					show: false,
					padding: {
						left: 0,
						right: 0
					}
				},
			},
			colors: [$warning],
			dataLabels: {
				enabled: false
			},
			stroke: {
				curve: 'smooth',
				width: 2.5
			},
			fill: {
				type: 'gradient',
				gradient: {
					shadeIntensity: 0.9,
					opacityFrom: 0.7,
					opacityTo: 0.5,
					stops: [0, 80, 100]
				}
			},
			series: [{
				name: 'Scanned Count',
				data: compaignhits_values
			}],

			xaxis: {
				labels: {
					show: false,
				},
				axisBorder: {
					show: false,
				}
			},
			yaxis: [{
				y: 0,
				offsetX: 0,
				offsetY: 0,
				padding: { left: 0, right: 0 },
			}],
			tooltip: {
				x: { show: false }
			},
		}

		var orderChart = new ApexCharts(
			document.querySelector("#orders-received-chart"),
			orderChartoptions
		);

		orderChart.render();
		// Orders Received Chart ends //

		/**
		* Campaign preview with QR code
		* @param {Array}  campaign
		*/
		function reviewCampaign(campaign) {
			$("#code_url").text(campaign.url);
			$("#code_title").text(campaign.campaign_name);
			$("#code_preview").attr("src", "/qrcode/generate/" + campaign.id);
			$("#backdrop").modal();
		}

		function deleteCampaign(campaignId) {
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!',
				confirmButtonClass: 'btn btn-primary',
				cancelButtonClass: 'btn btn-danger ml-1',
				buttonsStyling: false,
			}).then(function (result) {
				if (result.value) {
					$.ajax({
						url: "{{ url('/admin/campaigns/delete') }}",
						type: 'POST',
						data: {
							campaign_id: campaignId
						},
						dataType: "JSON",
						success : function (data, status, jqXhr) {
							if (jqXhr.status === 204) {
								toastr.success('That QR Code was deleted successfully.', 'Notification', {
									"showMethod": "fadeIn",
									"hideMethod": "fadeOut",
									"closeButton": true,
									"progressBar": true,
									timeOut: 2000
								});
								campaignTable.row($("#campaign_delete_" + campaignId).parents("tr")).remove().draw();
							}
						}
					});
				}
			})
		}

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
						color: $primary,
					},
					scaleLabel: {
						display: true,
					}
				}],
				yAxes: [{
					display: true,
					gridLines: {
						color: $primary,
					},
					scaleLabel: {
						display: true,
					},
					ticks: {
						stepSize: 10
					},
				}],
			},
			title: {
				display: true,
				text: ''
			}
		};
		// Chart Data
		var barchartData = {
			labels: campaigns,
			datasets: [{
				label: "{{ trans('locale.ScannedCount') }}",
				data: scanned_values,
				backgroundColor: $primary,
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
	</script>
@endsection