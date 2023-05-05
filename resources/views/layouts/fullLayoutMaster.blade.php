@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
<html lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{"en"}}@endif"
    data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - QR Code generator</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/logo/favicon.ico">

    {{-- Include core + vendor Styles --}}
    @include('panels/styles')

</head>

{{-- {!! Helper::applClasses() !!} --}}
@php
$configData = Helper::applClasses();
@endphp

<body
    class="vertical-layout vertical-menu-modern 1-column {{ $configData['blankPageClass']}} {{ $configData['bodyClass']}} {{ $configData['footerType'] }}"
    data-menu="vertical-menu-modern" data-col="1-column">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $.ajax({
            type: "GET",
            url: "{{ route('theme.gget') }}",
            success: function(response) {
                $("body").addClass(response);
                @if (env('APP_DEBUG', "false") == 'true')
                    console.log("flm: " + response);
                @endif
            }
        })
    </script>
    <!-- BEGIN: Header-->
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">

            <div class="content-body">
                {{-- Include Page Content --}}
                @yield('content')
            </div>
        </div>
    </div>
    <!-- End: Content-->

    {{-- include default scripts --}}
    @include('panels/scripts')

</body>

</html>