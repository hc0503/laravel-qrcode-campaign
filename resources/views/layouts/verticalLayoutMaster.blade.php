@php
$configData = Helper::applClasses();
@endphp

<body
  class="vertical-layout vertical-menu-modern 2-columns {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{ $configData['verticalMenuNavbarType'] }} {{ $configData['sidebarClass'] }} {{ $configData['footerType'] }} "
  data-menu="vertical-menu-modern" data-col="2-columns">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    $.ajax({
        type: "GET",
        url: "{{ route('theme.gget') }}",
        success: function(response) {
            $("body").addClass(response);
            @if (env('APP_DEBUG', "false") == 'true')
                console.log("vL : " + response);
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
      @if($configData['pageHeader'] === true && isset($configData['pageHeader']))
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