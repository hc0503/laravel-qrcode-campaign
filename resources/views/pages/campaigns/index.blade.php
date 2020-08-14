@extends('layouts/contentLayoutMaster')

@section('title', "View Campaign")

@section('vendor-style')
	<!-- vendor css files -->
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/ui/prism.min.css')) }}">
@endsection

@section('content')
<!-- Start Campaign -->
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="card">
			<div class="card-header">
			  <h4 class="card-title">@lang('locale.CampaignDetails')</h4>
			</div>
			<div class="card-content">
			  <div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped dataex-html5-selectors">
						<thead>
							<tr>
								<th>ID</th>
								<th>Campaign Name</th>
								<th>URL</th>
								<th>CreatedAt</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($campaigns as $campaign)
								<tr>
									<td>{{ $campaign->id }}</td>
									<td>{{ $campaign->campaign_name }}</td>
									<td>{{ $campaign->url }}</td>
									<td></td>
								</tr>
							@endforeach
						</tbody>
			  </div>
			</div>
		</div>
	</div>
</div>
<!--/ Start Campaign -->
@endsection

@section('vendor-script')
	<!-- vendor files -->
	<script src="{{ asset(mix('vendors/js/ui/prism.min.js')) }}"></script>
@endsection

