@extends('layouts/contentLayoutMaster')

@section('title', "View Campaign")

@section('content')
<!-- Start Campaign -->
<div class="row">
	<div class="col-lg-8 col-md-12 col-sm-12">
		<div class="card">
			<div class="card-header">
			  <h4 class="card-title">@lang('locale.CampaignDetails')</h4>
			</div>
			<div class="card-content">
			  <div class="card-body">
					<fieldset class="form-group">
						<label for="campaign_name">@lang('locale.CampaignName')</label>
						<input name="campaign_name" type="text" class="form-control" id="campaignName" readonly="readonly" value="{{ $campaign->campaign_name }}">
					</fieldset>

					<fieldset class="form-group">
						<label for="url">@lang('locale.URL')</label>
						<input name="url" type="text" class="form-control" id="url" readonly="readonly" value="{{ $campaign->url }}">
					</fieldset>

					<div class="form-group d-flex justify-content-between align-items-center">
						<div class="text-left">
							<a href="/campaigns" class="card-link">@lang('locale.PreviousCampaigns')</a>
						</div>
					</div>
			  </div>
			</div>
		</div>
	</div>
	
	<div class="col-lg-4 col-md-12 col-sm-12">
		<div class="card">
			<div class="card-header">
			  <h4 class="card-title">@lang('locale.QRCode')</h4>
			</div>
			<div class="card-content">
			  	<div class="card-body">
				  	<div class="row">
						<img src="/qrcode/{{ $campaign->id }}" height="197px;">
				  	</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--/ Start Campaign -->
@endsection