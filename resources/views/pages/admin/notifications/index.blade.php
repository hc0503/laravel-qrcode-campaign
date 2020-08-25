@extends('layouts/contentLayoutMaster')

@section('title', trans('locale.notification.list'))

@section('vendor-style')
	{{-- vendor css files --}}
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.css')) }}">
@endsection

@section('page-style')
	<style>
		.custom-switch .custom-control-label:before {
			background-color: #28C76F !important;
		}
		.switch-text-right {
			color: white !important;
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

	<div class="card">
		<div class="card-header">
			<a href="{{ route('notifications.create') }}" class="btn btn-primary mr-1 mb-1 waves-effect waves-light"><i class="fa fa-plus"></i> @lang('locale.notification.create')</a>
		</div>
		<div class="card-content">
			<div class="card-body">
				<div class="table-responsive">
					<table id="notificationTable" class="table table-striped">
						<thead>
							<tr>
								<th>@lang('locale.id')</th>
								<th>@lang('locale.notification.name')</th>
								<th>@lang('locale.notification.text')</th>
								<th>@lang('locale.notification.status')</th>
								<th>@lang('locale.CreatedAt')</th>
								<th>@lang('locale.UpdatedAt')</th>
								<th>@lang('locale.Actions')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($notifications as $notification)
							<tr>
								<td>{{ $notification->id }}</td>
								<td>{{ $notification->title }}</td>
								<td>{{ $notification->text }}</td>
								<td>
									<div class="custom-control custom-switch custom-switch-danger switch-lg mr-2">
										<input id="locked_{{ $notification->id }}" class="custom-control-input" type="checkbox" {{ $notification->status == 1 ? "checked" : "" }} onchange="setStatus(this.checked, {{ $notification->id }})">
										<label class="custom-control-label" for="locked_{{ $notification->id }}">
											<span class="switch-text-left">Denied</span>
											<span class="switch-text-right">Allowed</span>
										</label>
									</div>
							  	</td>
								<th>{{ $notification->created_at }}</th>
								<th>{{ $notification->updated_at }}</th>
								<td>
									<form id="deleteForm{{ $notification->id }}" action="{{ route('notifications.destroy', $notification->id) }}" method="POST" style="display: none;">
										@csrf
										@method('DELETE')
									</form>
									<a href="{{ route('notifications.edit', $notification->id) }}" class="btn btn-icon rounded-circle btn-flat-success waves-effect waves-light">
										<i class="feather icon-edit"></i>
									</a>
									<a href="javascript:deleteNotification({{ $notification->id }})" class="btn btn-icon rounded-circle btn-flat-danger waves-effect waves-light">
										<i class="feather icon-trash-2"></i>
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
@endsection

@section('vendor-script')
	{{-- vendor files --}}
	<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
	<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
	<script>
		$(document).ready(function() {
			$('#notificationTable').DataTable();

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
		});

		function deleteNotification(notificationId) {
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
					$('#deleteForm'+notificationId).submit();
				}
			})
		}

		function setStatus(state, notificationId) {
			$.ajax({
				url: "{{ url('/admin/notifications/status') }}",
				type: 'POST',
				data: {
					state : state ? 1 : 0,
					notification_id: notificationId
				},
				dataType: "JSON",
				success : function (data, status, jqXhr) {
					if (jqXhr.status === 204) {
						toastr.success('That notification status is changed successfully.', 'Notification', {
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut",
							"closeButton": true,
							"progressBar": true,
							timeOut: 2000
						});
					}
				}
			});
		}
	</script>
@endsection