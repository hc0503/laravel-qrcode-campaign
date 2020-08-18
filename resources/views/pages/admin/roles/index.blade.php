@extends('layouts/contentLayoutMaster')

@section('title', trans('locale.role.list'))

@section('vendor-style')
	{{-- vendor css files --}}
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
	<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection


@section('page-style')
	<style>
		.custom-select {
			height: auto;
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
			<a href="{{ route('roles.create') }}" class="btn btn-primary mr-1 mb-1 waves-effect waves-light"><i class="fa fa-plus"></i> @lang('locale.role.create')</a>
		</div>
		<div class="card-content">
			<div class="card-body">
				<div class="table-responsive">
					<table id="roleTable" class="table table-striped">
						<thead>
							<tr>
								<th>@lang('locale.id')</th>
								<th>@lang('locale.role.name')</th>
								<th>@lang('locale.role.permissions')</th>
								<th>@lang('locale.CreatedAt')</th>
								<th>@lang('locale.UpdatedAt')</th>
								<th>@lang('locale.Actions')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($roles as $role)
							<tr>
								<td>{{ $role->id }}</td>
								<td>{{ $role->name }}</td>
								<td>
									@foreach ($role->permissions as $permission)
									<div class="badge badge-primary">{{ $permission->name }}</div>
									@endforeach
								</td>
								<th>{{ $role->created_at }}</th>
								<th>{{ $role->updated_at }}</th>
								<td>
									<form id="deleteForm{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: none;">
										@csrf
										@method('DELETE')
									</form>
									<a href="{{ route('roles.edit', $role->id) }}" class="btn btn-icon rounded-circle btn-flat-success waves-effect waves-light">
										<i class="feather icon-edit"></i>
									</a>
									<a href="javascript:deleteRole({{ $role->id }})" class="btn btn-icon rounded-circle btn-flat-danger waves-effect waves-light">
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
@endsection

@section('page-script')
	<script>
		$(document).ready(function() {
			$('#roleTable').DataTable();
		});

		function deleteRole(roleId) {
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
					$('#deleteForm'+roleId).submit();
				}
			})
		}
	</script>
@endsection