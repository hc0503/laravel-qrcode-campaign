@php
$configData = Helper::applClasses();
@endphp

<body
    class="horizontal-layout horizontal-menu {{$configData['horizontalMenuType']}} {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{ $configData['sidebarClass'] }} {{ $configData['footerType'] }}  footer-light"
    data-menu="horizontal-menu" data-col="2-columns" data-open="hover">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $.ajax({
            type: "GET",
            url: "{{ route('theme.gget') }}",
            success: function(response) {
                $("body").addClass(response);
                @if (env('APP_DEBUG', "false") == 'true')
                    console.log("hl: " + response);
                @endif
            }
        })
    </script>
    {{-- Include Sidebar --}}
    @include('panels.sidebar')

    <!-- BEGIN: Header-->
    {{-- Include Navbar --}}
    @include('panels.navbar')

    {{-- Include Sidebar --}}
    @include('panels.horizontalMenu')

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        @if(($configData['contentLayout']!=='default') && isset($configData['contentLayout']))
        <div class="content-area-wrapper">
            <div class="{{ $configData['sidebarPositionClass'] }}">
                <div class="sidebar">
                    {{-- Include Sidebar Content --}}
                    @yield('content-sidebar')
                </div>
            </div>
            <div class="{{ $configData['contentsidebarClass'] }}">
                <div class="content-wrapper">
                    <div class="content-body">
                        {{-- Include Page Content --}}
                        @yield('content')

                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="content-wrapper">
            {{-- Include Breadcrumb --}}
            @if($configData['pageHeader'] == true)
            @include('panels.breadcrumb')
            @endif
            <div class="content-body">
                {{-- Include Page Content --}}
                @yield('content')

            </div>
        </div>
        @endif

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