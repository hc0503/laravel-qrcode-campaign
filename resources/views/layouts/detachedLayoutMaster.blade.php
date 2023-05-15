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
    class="vertical-layout vertical-menu-modern 2-columns {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{ $configData['verticalMenuNavbarType'] }} {{ $configData['sidebarClass'] }} {{ $configData['footerType'] }}  footer-light"
    data-menu="vertical-menu-modern" data-col="2-columns">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $.ajax({
            type: "GET",
            url: "{{ route('theme.gget') }}",
            success: function(response) {
                $("body").addClass(response);
                @if (env('APP_DEBUG', "false") == 'true')
                    console.log("dlm: " + response);
                @endif
            }
        })
    </script>
    {{-- Include Sidebar --}}
    @include('panels.sidebar')

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <!-- BEGIN: Header-->
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        {{-- Include Navbar --}}
        @include('panels.navbar')

        <div class="content-wrapper">
            {{-- Include Breadcrumb --}}
            @if($configData['pageHeader'] == true)
            @include('panels.breadcrumb')
            @endif
            <div class="{{ $configData['sidebarPositionClass'] }}">
                <div class="sidebar">
                    {{-- Include Sidebar Content --}}
                    @yield('content-sidebar')
                </div>
            </div>
            <div class="{{ $configData['contentsidebarClass'] }}">
                <div class="content-body">
                    {{-- Include Page Content --}}
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <!-- End: Content-->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    {{-- include footer --}}
    @include('panels/footer')

    {{-- include default scripts --}}
    @include('panels/scripts')

</body>

</html>
