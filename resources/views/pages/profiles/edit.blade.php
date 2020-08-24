@extends('layouts/contentLayoutMaster')

@section('title', trans('locale.profile.edit'))

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
  
<!-- account setting page start -->
<section id="page-account-settings">
    <div class="row">
      <!-- left menu section -->
      <div class="col-md-3 mb-2 mb-md-0">
        <ul class="nav nav-pills flex-column mt-md-0 mt-1">
          <li class="nav-item">
            <a class="nav-link d-flex py-75 {{ old('type') != 'password' ? 'active' : '' }}" id="account-pill-general" data-toggle="pill"
              href="#account-vertical-general" aria-expanded="true">
              <i class="feather icon-globe mr-50 font-medium-3"></i>
              @lang('locale.profile.general')
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex py-75 {{ old('type') == 'password' ? 'active' : '' }}" id="account-pill-password" data-toggle="pill"
              href="#account-vertical-password" aria-expanded="false">
              <i class="feather icon-lock mr-50 font-medium-3"></i>
              @lang('locale.profile.changePassword')
            </a>
          </li>
        </ul>
      </div>
      <!-- right content section -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane  {{ old('type') != 'password' ? 'active' : '' }}" id="account-vertical-general"
                  aria-labelledby="account-pill-general" aria-expanded="true">
                  <form action="{{ route('profile-update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="general">
                    <div class="media">
                      @if ($user->photo === null)
                      <img src="{{ asset('images/avatar.png') }}" id="imgPhoto" class="rounded mr-75" alt="photo image" height="80">
                      @else
                      <img src="{{ asset('storage/' . $user->photo) }}" id="imgPhoto" class="rounded mr-75" alt="photo image" height="80">
                      @endif
                      <div class="media-body mt-75">
                        <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                          <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer"
                            for="photo">@lang('locale.profile.upload')</label>
                          <input type="file" id="photo" name="photo" onchange="previewPhoto();" hidden>
                          <input type="number" id="reset" name="reset" value="0" hidden>
                          <a href="javascript:resetPhoto();" class="btn btn-sm btn-outline-warning ml-50 waves-effect waves-light">@lang('locale.campaign.reset')</a>
                        </div>
                        <p class="text-muted ml-75 mt-50"><small>@lang('locale.profile.allow')</small></p>
                      </div>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="name">@lang('locale.Name')</label>
                          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="{{ trans('locale.Name') }}" value="{{ $user->name }}" autofocus>
                          @error('name')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="surname">@lang('locale.Surname')</label>
                          <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" placeholder="{{ trans('locale.Surname') }}" value="{{ $user->surname }}">
                          @error('surname')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label for="email">@lang('locale.Email')</label>
                          <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ trans('locale.Email') }}" value="{{ $user->email }}">
                          @error('email')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                        <button type="submit" class="btn btn-primary mb-1 mb-sm-0">
                          @lang('locale.profile.save')
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="tab-pane {{ old('type') == 'password' ? 'active' : 'fade' }}" id="account-vertical-password" role="tabpanel"
                  aria-labelledby="account-pill-password" aria-expanded="false">
                  <form action="{{ route('profile-reset', $user) }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="password">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="email">@lang('locale.profile.oldPassword')</label>
                          <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" placeholder="{{ trans('locale.profile.oldPassword') }}" value="{{ old('old_password') }}">
                          @error('old_password')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>
                      
                      <div class="col-12">
                        <div class="form-group">
                          <label for="email">@lang('locale.profile.newPassword')</label>
                          <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" placeholder="{{ trans('locale.profile.newPassword') }}" value="{{ old('new_password') }}">
                          @error('new_password')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>
                      
                      <div class="col-12">
                        <div class="form-group">
                          <label for="email">@lang('locale.profile.retypePassword')</label>
                          <input id="retype_password" type="password" class="form-control @error('retype_password') is-invalid @enderror" name="retype_password" placeholder="{{ trans('locale.profile.retypePassword') }}" value="{{ old('retype_password') }}">
                          @error('retype_password')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                          changes</button>
                        <button type="reset" class="btn btn-outline-warning">Cancel</button>
                      </div>
                    </div>
                  </form>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
<!-- account setting page end -->
@endsection

@section('page-script')
	<script>
		var defaultPhoto = "{{ asset('images/avatar.png') }}";
		// photo preview
		function previewPhoto() {
      var file = $('#photo')[0].files[0];
			if (file) {
        $("#imgPhoto").attr("src", URL.createObjectURL(file));
        $("#reset").val(0);
			} else {
				$("#imgPhoto").attr("src", defaultPhoto);
			}
		}

		// photo remove and set default logo
		function resetPhoto() {
      $("#imgPhoto").attr("src", defaultPhoto);
      $("#reset").val(1);
		}
	</script>
@endsection