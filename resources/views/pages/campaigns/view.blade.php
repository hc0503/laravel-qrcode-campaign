@extends('layouts/contentLayoutMaster')

@section('title', trans('locale.campaign.view'))

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
	<div class="row">
		<div class="col-lg-8 col-md-12 col-sm-12">
			<div class="card">
				<div class="card-header">
				<h4 class="card-title">@lang('locale.campaign.details')</h4>
				</div>
				<div class="card-content">
				<div class="card-body">
					<fieldset class="form-group">
						<label for="campaign_name">@lang('locale.campaign.field.name')</label>
						<input name="campaign_name" type="text" class="form-control" id="campaignName" readonly="readonly" value="{{ $campaign->campaign_name }}">
					</fieldset>

					<fieldset class="form-group">
						<label for="url">@lang('locale.campaign.field.url')</label>
						<input name="url" type="text" class="form-control" id="url" readonly="readonly" value="{{ $campaign->url }}">
					</fieldset>

					<fieldset class="form-group">
						<label for="foreground">@lang('locale.campaign.field.foreground')</label>
						<input type="color" id="foreground" name="foreground" class="form-control color-picker" disabled value="{{ $campaign->foreground }}">
					</fieldset>

					<fieldset class="form-group">
						<label for="background">@lang('locale.campaign.field.background')</label>
						<input type="color" id="background" name="background" class="form-control color-picker" disabled value="{{ $campaign->background }}">
					</fieldset>

					<div class="form-group d-flex justify-content-between align-items-center">
						<div class="text-left">
							<a href="/campaigns" class="card-link">@lang('locale.campaign.previous')</a>
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
							<div class="col-md-12 text-center">
								<img src="{!! url('/qrcode/generate', $campaign->id) !!}" id="qrcode" width="100%" />
							</div>
						</div>
					</div>
				</div>
				<div class="text-center">
					<a href="{!! url('/qrcode/generate', $campaign->id) !!}" class="btn btn-primary" download>Download QRCode</a>
				</div>
			</div>
		</div>
	</div>
	<!--/ Start Campaign -->
@endsection

@section('page-script')
  <script>
    $(document).ready(function() {
      {{--$.ajax({--}}
      {{--  url: "{{ url('/qrcode/generate', $campaign->id) }}",--}}
      {{--  type: 'GET',--}}
      {{--  data: {--}}
      {{--  },--}}
      {{--  dataType: "text",--}}
      {{--  success : function (data, status, jqXhr) {--}}
      {{--    console.log(data);--}}
      {{--    $("#qrcode").attr("src", data);--}}
      {{--  }--}}
      {{--});--}}
    });
  </script>
@endsection
