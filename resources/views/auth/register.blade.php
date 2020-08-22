@extends('layouts/fullLayoutMaster')

@section('title', 'Register Page')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
@endsection

@section('content')
<section class="row flexbox-container">
  <div class="col-xl-8 col-10 d-flex justify-content-center">
      <div class="card bg-authentication rounded-0 mb-0">
          <div class="row m-0">
              <div class="col-lg-6 d-lg-block d-none text-center align-self-center pl-0 pr-3 py-0">
                  <img src="{{ asset('images/pages/register.jpg') }}" alt="branding logo">
              </div>
              <div class="col-lg-6 col-12 p-0">
                  <div class="card rounded-0 mb-0 p-2">
                      <div class="card-header pt-50 pb-1">
                          <div class="card-title">
                              <h4 class="mb-0">Create Account</h4>
                          </div>
                      </div>
                      <p class="px-2">Fill the below form to create a new account.</p>
                      <div class="card-content">
                          <div class="card-body pt-0">
                            <form method="POST" action="{{ route('register') }}">
                              @csrf
                                  <div class="form-label-group">
                                      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="{{ trans('locale.Name') }}" value="{{ old('name') }}" autofocus>
                                      <label for="name">@lang('locale.Name')</label>
                                      @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                  </div>
                                  <div class="form-label-group">
                                      <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" placeholder="{{ trans('locale.Surname') }}" value="{{ old('surname') }}">
                                      <label for="surname">@lang('locale.Surname')</label>
                                      @error('surname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                  </div>
                                  <div class="form-label-group">
                                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ trans('locale.Email') }}" value="{{ old('email') }}">
                                      <label for="email">Email</label>
                                      @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                  </div>
                                  <div class="form-label-group">
                                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ trans('locale.Password') }}" value="{{ old('password') }}">
                                      <label for="password">@lang('locale.Password')</label>
                                      @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                  </div>
                                  <div class="form-label-group">
                                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('locale.ConfirmPassword') }}" value="{{ old('password_confirmation') }}">
                                      <label for="password-confirm">@lang('locale.ConfirmPassword')</label>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-12">
                                          <fieldset class="checkbox">
                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                              <input type="checkbox" checked>
                                              <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                  <i class="vs-icon feather icon-check"></i>
                                                </span>
                                              </span>
                                              <span class="">@lang('locale.acceptCondition')</span>
                                            </div>
                                          </fieldset>
                                      </div>
                                  </div>
                                  <a href="login" class="btn btn-outline-primary float-left btn-inline mb-50">@lang('locale.Login')</a>
                                  <button type="submit" class="btn btn-primary float-right btn-inline mb-50">@lang('locale.Register')</a>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
@endsection
