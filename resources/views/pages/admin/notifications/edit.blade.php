@extends('layouts/contentLayoutMaster')

@section('title', trans('locale.notification.edit'))

@section('content')
	<div class="card">
		<div class="card-header">
		<h4 class="card-title">@lang('locale.notification.details')</h4>
		</div>
		<div class="card-content">
		<div class="card-body">
			<form action="{{ route('notifications.update', $notification) }}" method="POST">
				@csrf
				@method('PUT')
				<fieldset class="form-group">
					<label for="title">@lang('locale.notification.name')*</label>
					<input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="@lang('locale.notification.name')" value="{{ $notification->title }}">
					@error('title')
						<span class="invalid-feedback danger" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</fieldset>
				
				<fieldset class="form-group">
					<label for="text">@lang('locale.notification.text')*</label>
					<input name="text" type="text" class="form-control @error('text') is-invalid @enderror" id="text" placeholder="@lang('locale.notification.text')" value="{{ $notification->text }}">
					@error('text')
					<span class="invalid-feedback danger" role="alert">
						<strong>{{ $message }}</strong>
						</span>
					@enderror
				</fieldset>

				<fieldset class="form-group">
					<label for="title">@lang('locale.notification.status')</label>
					<select name="status" class="custom-select" id="status">
						<option value="0" {{ $notification->status === 0 ? 'selected' : '' }}>Allowed</option>
						<option value="1" {{ $notification->status === 1 ? 'selected' : '' }}>Denied</option>
					</select>
			  </fieldset>
				
				<div class="text-right">
					<button class="btn btn-primary">@lang('locale.notification.save')</button>
				</div>
			</form>
		</div>
		</div>
	</div>
@endsection