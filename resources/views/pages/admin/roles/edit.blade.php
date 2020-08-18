@extends('layouts/contentLayoutMaster')

@section('title', trans('locale.role.edit'))

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
		<h4 class="card-title">@lang('locale.role.details')</h4>
		</div>
		<div class="card-content">
		<div class="card-body">
			<form action="{{ route('roles.update', $role->id) }}" method="POST">
				@csrf
				@method('PUT')
				<fieldset class="form-group">
					<label for="name">@lang('locale.role.name')*</label>
					<input name="name" type="text" class="form-control" id="name" placeholder="@lang('locale.role.name')" value="{{ $role->name }}">
					<span class="danger">{{ $errors->first('name') }}</span>
				</fieldset>

				<fieldset class="form-group">
					<label for="name">@lang('locale.role.permissions')*</label>
					<select name="permissions[]" class="select2 form-control" multiple="multiple">
						@php
						$arrPermissions = $role->permissions->pluck("name")->toArray();
						@endphp
						@foreach ($permissions as $permission)
						<option value="{{ $permission->name }}" {{ in_array($permission->name, $arrPermissions) ? "selected" : "" }} >{{ $permission->name }}</option>
						@endforeach
					</select>
					<span class="danger">{{ $errors->first('permissions') }}</span>
				</fieldset>

				<div class="text-right">
					<button class="btn btn-primary">@lang('locale.role.update')</button>
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