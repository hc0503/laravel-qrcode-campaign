@extends('layouts/contentLayoutMaster')

@section('title', trans('locale.campaign.create'))

@section('page-style')
	<style>
		.color-picker {
			padding-top: 2px;
			padding-bottom: 2px;
			padding-left: 4px;
			padding-right: 4px;
		}
	</style>
@endsection

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
					<form action="/campaigns" method="POST" enctype="multipart/form-data">
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

						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12">
								<fieldset class="form-group">
									<label for="foreground">@lang('locale.campaign.field.foreground')</label>
									<input type="color" id="foreground" name="foreground" class="form-control color-picker" value="{{ old('foreground') ?? '#000000' }}">
								</fieldset>

								<fieldset class="form-group">
									<label for="background">@lang('locale.campaign.field.background')</label>
									<input type="color" id="background" name="background" class="form-control color-picker" value="{{ old('background') ?? '#ffffff' }}">
								</fieldset>
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="form-group">
									<img src="{{ asset('images/default.png') }}" id="imgLogo" class="rounded mr-75" alt="logo image" height="140">
									<div class="mt-75">
										<div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
											<label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer waves-effect waves-light" for="logo">@lang('locale.campaign.field.uploadLogo')</label>
											<input type="file" id="logo" name="logo" onchange="previewLogo()" hidden="" accept="image/png, image/jpeg">
											<a href="javascript:resetLogo();" class="btn btn-sm btn-outline-warning ml-50 waves-effect waves-light">@lang('locale.campaign.reset')</a>
										</div>
										<p class="text-muted ml-75 mt-50"><small>@lang('locale.campaign.allow')</small></p>
									</div>
								</div>
							</div>
						</div>

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

@section('page-script')
	<script>
		var defaultLogo = "{{ asset('images/default.png') }}";
		// logo preview
		function previewLogo() {
			var file = $('#logo')[0].files[0];
			if (file) {
				$("#imgLogo").attr("src", URL.createObjectURL(file));
			} else {
				$("#imgLogo").attr("src", defaultLogo);
			}
		}

		// logo remove and set default logo
		function resetLogo() {
			$("#imgLogo").attr("src", defaultLogo);
		}
	</script>
@endsection
