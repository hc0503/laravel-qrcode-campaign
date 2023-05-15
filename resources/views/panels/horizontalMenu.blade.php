{{-- Horizontal Menu --}}
<div class="horizontal-menu-wrapper">
  <div
    class="header-navbar navbar-expand-sm navbar navbar-horizontal {{$configData['horizontalMenuClass']}} {{($configData['theme'] === 'light') ? "navbar-light" : "navbar-dark" }} navbar-light navbar-without-dd-arrow navbar-shadow navbar-brand-center"
    role="navigation" data-menu="menu-wrapper" data-nav="brand-center">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('user-dashboard') }}">
            <div class="brand-logo"></div>
            <h2 class="brand-text mb-0">Vusax</h2>
          </a></li>
        <li class="nav-item nav-toggle">
          <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
            <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
            <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
              data-ticon="icon-disc"></i>
          </a>
        </li>
      </ul>
    </div>
    <!-- Horizontal menu content-->
    <div class="navbar-container main-menu-content" data-menu="menu-container">
      <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
        {{-- Foreach menu item starts --}}
        @if(isset($menuData[1]))
        @foreach($menuData[1]->menu as $menu)
        @php
        $custom_classes = "";
        if(isset($menu->classlist)) {
        $custom_classes = $menu->classlist;
        }
        $translation = "";
        if(isset($menu->i18n)){
        $translation = $menu->i18n;
        }
        @endphp
        @if(isset($menu->dropdown))
        <li class="@if(isset($menu->submenu)){{'dropdown'}}@endif nav-item {{ (request()->is($menu->url)) ? 'active' : '' }} {{ $custom_classes }}"
          @if(isset($menu->submenu)){{'data-menu=dropdown'}}@endif>
          <a href="{{ $menu->url }}" class="@if(isset($menu->submenu)){{'dropdown-toggle'}}@endif nav-link" @if(isset($menu->submenu)){{'data-toggle=dropdown'}}@endif>
            @else
        <li class="nav-item {{ (request()->is($menu->url)) ? 'active' : '' }} {{ $custom_classes }}">
          <a href="{{ $menu->url === '/' ? '' : '/' }}{{ $menu->url }}" class="nav-link">
            @endif
            <i class="{{ $menu->icon }}"></i>
            <span data-i18n="{{ $translation }}">{{ __('locale.'.$menu->name) }}</span>
          </a>
          @if(isset($menu->submenu))
          @include('panels/horizontalSubmenu', ['menu' => $menu->submenu])
          @endif
        </li>
        @endforeach
        @endif
        {{-- Foreach menu item ends --}}
      </ul>
    </div>
  </div>
</div>