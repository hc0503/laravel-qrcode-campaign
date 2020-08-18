@extends('layouts/contentLayoutMaster')

@section('title', trans('locale.user.create'))

@section('vendor-style')
	<!-- vendor css files -->
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('page-style')
	<style>
		.select2-selection__choice {
			background-color: #7567F1 !important;
			color: white !important;
			border-color: #7567F1 !important;
		}
	</style>
@endsection

@section('content')
	<div class="card">
		<div class="card-header">
		<h4 class="card-title">@lang('locale.user.details')</h4>
		</div>
		<div class="card-content">
		<div class="card-body">
			<form action="{{ route('users.store') }}" method="POST">
				@csrf
				<fieldset class="form-group">
					<label for="name">@lang('locale.Name')*</label>
					<input name="name" type="text" class="form-control" id="name" placeholder="@lang('locale.Name')" value="{{ old('name') }}">
					<span class="danger">{{ $errors->first('name') }}</span>
				</fieldset>

				<fieldset class="form-group">
					<label for="surname">@lang('locale.Surname')*</label>
					<input name="surname" type="text" class="form-control" id="surname" placeholder="@lang('locale.Surname')" value="{{ old('surname') }}">
					<span class="danger">{{ $errors->first('surname') }}</span>
				</fieldset>

				<fieldset class="form-group">
					<label for="email">@lang('locale.Email')*</label>
					<input name="email" type="email" class="form-control" id="email" placeholder="@lang('locale.Email')" value="{{ old('email') }}">
					<span class="danger">{{ $errors->first('email') }}</span>
				</fieldset>

				<fieldset class="form-group">
					<label for="password">@lang('locale.Password')*</label>
					<input name="password" type="password" class="form-control" id="password" placeholder="@lang('locale.Password')" value="{{ old('password') }}">
					<span class="danger">{{ $errors->first('password') }}</span>
				</fieldset>

				<fieldset class="form-group">
					<label for="roles">@lang('locale.role.title')*</label>
					<select name="roles[]" class="select2 form-control" multiple="multiple">
						@foreach ($roles as $role)
						<option value="{{ $role->name }}">{{ $role->name }}</option>
						@endforeach
					</select>
					<span class="danger">{{ $errors->first('roles') }}</span>
				</fieldset>

				<div class="text-right">
					<button class="btn btn-primary">@lang('locale.user.create')</button>
				</div>
			</form>
		</div>
		</div>
	</div>
@endsection

@section('vendor-script')
	<!-- vendor files -->
	<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
	<script>
		$(document).ready(function() {
			$(".select2").select2({
				// the following code is used to disable x-scrollbar when click in select input and
				// take 100% width in responsive also
				dropdownAutoWidth: true,
				width: '100%'
			 });
		});
	</script>
@endsection