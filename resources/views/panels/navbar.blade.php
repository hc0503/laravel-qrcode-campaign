@if($configData["mainLayoutType"] == 'horizontal' && isset($configData["mainLayoutType"]))
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu {{ $configData['navbarColor'] }} navbar-fixed">
  <div class="navbar-header d-xl-block d-none">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item">
        <a class="navbar-brand" href="dashboard-analytics">
          <div class="brand-logo"></div>
        </a>
      </li>
    </ul>
  </div>
  @else
  <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }}">
@endif
  <div class="navbar-wrapper">
    <div class="navbar-container content">
      <div class="navbar-collapse" id="navbar-mobile">
        <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
          <ul class="nav navbar-nav">
            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
          </ul>
        </div>
        <ul class="nav navbar-nav float-right">
          <li class="dropdown dropdown-language nav-item">
            <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="flag-icon flag-icon-us"></i>
              <span class="selected-language">English</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdown-flag">
              <a class="dropdown-item" href="{{url('lang/en')}}" data-language="en">
                <i class="flag-icon flag-icon-us"></i> English
              </a>
              <a class="dropdown-item" href="{{url('lang/fr')}}" data-language="fr">
                <i class="flag-icon flag-icon-fr"></i> French
              </a>
              <a class="dropdown-item" href="{{url('lang/de')}}" data-language="de">
                <i class="flag-icon flag-icon-de"></i> German
              </a>
              <a class="dropdown-item" href="{{url('lang/pt')}}" data-language="pt">
                <i class="flag-icon flag-icon-pt"></i> Portuguese
              </a>
            </div>
          </li>
          <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                class="ficon feather icon-maximize"></i></a></li>
          <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
            <div class="user-nav d-sm-flex d-none">
              <span class="user-name text-bold-600">
                {{ Auth::user()->name }} {{ Auth::user()->surname }}
              </span><span class="user-status">Available</span></div><span><img class="round" src="{{asset('images/portrait/small/avatar-s-11.jpg') }}" alt="avatar" height="40" width="40" /></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              @can('user_manage')
              @if (Request::route()->getPrefix() == '/admin')
              <a class="dropdown-item" href="/"><i class="feather icon-log-in"></i> User panel</a>
              @else
              <a class="dropdown-item" href="/admin"><i class="feather icon-log-in"></i> Admin panel</a>
              @endif
              <div class="dropdown-divider"></div>
              @endcan
              <a class="dropdown-item" href="#logout" onclick="$('#logout').submit();"><i class="feather icon-power"></i> Logout</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<form id="logout" action="{{ route('logout') }}" method="POST" style="display: none;">
  @csrf
</form>