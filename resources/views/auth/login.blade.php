@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
@endsection

@section('content')
<section class="row flexbox-container">
  <div class="col-xl-8 col-11 d-flex justify-content-center">
    <div class="card bg-authentication rounded-0 mb-0">
      <div class="row m-0">
        <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
          <img src="{{ asset('images/pages/login.png') }}" alt="branding logo">
        </div>
        <div class="col-lg-6 col-12 p-0">
          <div class="card rounded-0 mb-0 px-2">
            <div class="card-header pb-1">
              <div class="card-title">
                <h4 class="mb-0">Login</h4>
              </div>
            </div>
            <p class="px-2">Welcome back, please login to your account.</p>
            <div class="card-content">
              <div class="card-body pt-1">
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <fieldset class="form-label-group form-group position-relative">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ trans('locale.enterEmail') }}" value="{{ old('email') }}" autofocus>
                    <label for="email">@lang('locale.Email')</label>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                    @enderror
                  </fieldset>

                  <fieldset class="form-label-group position-relative">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ trans('locale.enterPassword') }}" value="{{ old('password') }}">
                    <label for="password">@lang('locale.Password')</label>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                    @enderror
                  </fieldset>
                  <div class="form-group d-flex justify-content-between align-items-center">
                    <div class="text-left">
                        <fieldset class="checkbox">
                          <div class="vs-checkbox-con vs-checkbox-primary">
                            <input type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                            <span class="vs-checkbox">
                              <span class="vs-checkbox--check">
                                <i class="vs-icon feather icon-check"></i>
                              </span>
                            </span>
                            <span class="">@lang('locale.RememberMe')</span>
                          </div>
                        </fieldset>
                    </div>
                    <div class="text-right"><a href="{{ route('password.request') }}" class="card-link">Forgot Password?</a></div>
                  </div>
                  @if (env('APP_REGISTRATION', 'False') == 'True')
                  <a href="register" class="btn btn-outline-primary float-left btn-inline">Register</a>
                  @endif
                  <button type="submit" class="btn btn-primary float-right btn-inline">Login</button>
              </form>
              </div>
            </div>
            <div class="login-footer">
              <div class="divider">
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection