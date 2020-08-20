@extends('layouts/contentLayoutMaster')

@section('title', trans('locale.campaign.list'))

@section('vendor-style')
	{{-- vendor css files --}}
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
	<style>
		.custom-select {
			height: auto;
		}

		.color-picker {
			padding-top: 2px;
			padding-bottom: 2px;
			padding-left: 4px;
			padding-right: 4px;
		}
	</style>
@endsection

@section('content')
	@if (session()->get('message'))
	<div class="alert alert-primary alert-dismissible fade show" role="alert">
		<p class="mb-0">
			{{ session()->get('message') }}
		</p>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	@endif

	<!-- Start Campaign -->
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">@lang('locale.campaign.details')</h4>
		</div>
		<div class="card-content">
			<div class="card-body">
				<div class="table-responsive">
					<table id="campaignTable" class="table table-striped">
						<thead>
							<tr>
								<th>@lang('locale.id')</th>
								<th>@lang('locale.campaign.field.name')</th>
								<th>@lang('locale.campaign.field.url')</th>
								<th>@lang('locale.campaign.field.foreground')</th>
								<th>@lang('locale.campaign.field.background')</th>
								<th>@lang('locale.campaign.logo')</th>
								<th>@lang('locale.CreatedAt')</th>
								<th>@lang('locale.Actions')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($campaigns as $campaign)
							<tr>
								<td>{{ $campaign->id }}</td>
								<td>{{ $campaign->campaign_name }}</td>
								<td>{{ $campaign->url }}</td>
								<td>
									<input type="color" class="form-control color-picker" disabled value="{{ $campaign->foreground }}">
								</td>
								<td>
									<input type="color" class="form-control color-picker" disabled value="{{ $campaign->background }}">
								</td>
								<td>
									@if($campaign->logo == null)
									<img src='{{ asset("images/default.png") }}' width="50">
									@else
									<img src='{{ asset("storage/$campaign->logo") }}' width="50">
									@endif
								</td>
								<th>{{ $campaign->created_at }}</th>
								<td>
									<form id="deleteForm{{ $campaign->id }}" action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST" style="display: none;">
										@csrf
										@method('DELETE')
									</form>
									<a href="{{ route('campaigns.show', $campaign->id) }}" class="btn btn-icon rounded-circle btn-flat-success waves-effect waves-light">
										<i class="feather icon-eye"></i>
									</a>
									<a href="javascript:deleteCampaign({{ $campaign->id }})" class="btn btn-icon rounded-circle btn-flat-danger waves-effect waves-light">
										<i class="users-delete-icon feather icon-trash-2"></i>
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
	<!--/ Start Campaign -->
@endsection

@section('vendor-script')
	{{-- vendor files --}}
	<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
	<script>
		$(document).ready(function() {
			$('#campaignTable').DataTable();
		});

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
					$('#deleteForm'+campaignId).submit();
				}
			})
		}
	</script>
@endsection