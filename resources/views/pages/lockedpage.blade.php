@extends('layouts/fullLayoutMaster')

@section('title', 'Not Authorized')

@section('content')
<!-- maintenance -->
<section class="row flexbox-container">
  <div class="col-xl-7 col-md-8 col-12 d-flex justify-content-center">
    <div class="card auth-card bg-transparent shadow-none rounded-0 mb-0 w-100">
      <div class="card-content">
        <div class="card-body text-center">
          <img src="{{ asset('images/pages/not-authorized.png') }}" class="img-fluid align-self-center" alt="branding logo">
          <h1 class="font-large-2 my-2">@lang('locale.error.lockTitle')</h1>
          <p class="p-2">
            @lang('locale.error.lockDescription')
          </p>
          <a class="btn btn-primary btn-lg mt-2" href="/">Back to Home</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- maintenance end -->
@endsection
