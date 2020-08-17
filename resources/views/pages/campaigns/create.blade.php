@extends('layouts/contentLayoutMaster')

@section('title', "Create Campaign")

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
					<form action="/campaigns" method="POST">
						@csrf
						<fieldset class="form-group">
							<label for="campaign_name">@lang('locale.CampaignName')</label>
							<input name="campaign_name" type="text" class="form-control" id="campaignName" placeholder="@lang('locale.EnterCampaignName')" value="{{ old('campaign_name') }}">
							<span class="danger">{{ $errors->first('campaign_name') }}</span>
						</fieldset>

						<fieldset class="form-group">
							<label for="url">@lang('locale.URL')</label>
							<input name="url" type="text" class="form-control" id="url" placeholder="@lang('locale.EnterURL')" value="{{ old('url') }}">
							<span class="danger">{{ $errors->first('url') }}</span>
						</fieldset>

						<div class="form-group d-flex justify-content-between align-items-center">
							<div class="text-left">
								<a href="/campaigns" class="card-link">@lang('locale.PreviousCampaigns')</a>
							</div>
							<div class="text-right">
								<button class="btn btn-primary">@lang('locale.CreateCampaign')</button>
							</div>
						</div>
					</form>
				</div>
				</div>
			</div>
		</div>
	</div>
	<!--/ Start Campaign -->
@endsection
