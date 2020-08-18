@extends('layouts/contentLayoutMaster')

@section('title', trans('locale.campaign.create'))

@section('content')
	<!-- Start Campaign -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="card">
				<div class="card-header">
				<h4 class="card-title">@lang('locale.campaign.details')</h4>
				</div>
				<div class="card-content">
				<div class="card-body">
					<form action="/campaigns" method="POST">
						@csrf
						<fieldset class="form-group">
							<label for="campaign_name">@lang('locale.campaign.field.name')</label>
							<input name="campaign_name" type="text" class="form-control" id="campaignName" placeholder="@lang('locale.campaign.field.namePlace')" value="{{ old('campaign_name') }}">
							<span class="danger">{{ $errors->first('campaign_name') }}</span>
						</fieldset>

						<fieldset class="form-group">
							<label for="url">@lang('locale.campaign.field.url')</label>
							<input name="url" type="text" class="form-control" id="url" placeholder="@lang('locale.campaign.field.urlPlace')" value="{{ old('url') }}">
							<span class="danger">{{ $errors->first('url') }}</span>
						</fieldset>

						<div class="form-group d-flex justify-content-between align-items-center">
							<div class="text-left">
								<a href="/campaigns" class="card-link">@lang('locale.campaign.previous')</a>
							</div>
							<div class="text-right">
								<button class="btn btn-primary">@lang('locale.campaign.create')</button>
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
