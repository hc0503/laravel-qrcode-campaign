@if($configData["mainLayoutType"] == 'horizontal' && isset($configData["mainLayoutType"]))
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu {{ $configData['navbarColor'] }} navbar-fixed">
  <div class="navbar-header d-xl-block d-none">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item">
        <a class="navbar-brand" href="{{ route('user-dashboard') }}">
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
          <li class="nav-item d-none d-lg-block">
            <div class="custom-control custom-switch custom-switch mr-2 mb-1">
              <p class="mb-0"></br></p>
              <input type="checkbox" onclick='theme()' class="custom-control-input" id="themeSwitch">
              <label class="custom-control-label" for="themeSwitch">
                <span class="switch-icon-left"><i class="feather icon-moon"></i></span>
                <span class="switch-icon-right"><i class="feather icon-sun"></i></span>
              </label>
            </div>
          </li>
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
              <a class="dropdown-item" href="{{url('lang/es')}}" data-language="es">
                <i class="flag-icon flag-icon-es"></i> Spanish
              </a>
              <a class="dropdown-item" href="{{url('lang/cn')}}" data-language="cn">
                <i class="flag-icon flag-icon-cn"></i> Chinese
              </a>
            </div>
          </li>
          <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                class="ficon feather icon-maximize"></i></a></li>
          <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
            <div class="user-nav d-sm-flex d-none">
              <span class="user-name text-bold-600">
                {{ Auth::user()->name }} {{ Auth::user()->surname }}
              </span>
              @if (Auth::user()->photo === null)
              <span class="user-status">Available</span></div><span><img class="round" src="{{asset('images/avatar.png') }}" alt="avatar" height="40" width="40" /></span>
              @else
              <span class="user-status">Available</span></div><span><img class="round" src="{{asset('storage/' . Auth::user()->photo) }}" alt="avatar" height="40" width="40" /></span>
              @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="{{ route('profile-edit', Auth::user()) }}"><i class="feather icon-user"></i> @lang('locale.profile.edit')</a>
              @can('user_manage')
              @if (Request::route()->getPrefix() == '/admin')
              <a class="dropdown-item" href="/"><i class="feather icon-log-in"></i> @lang('locale.userPanel')</a>
              @else
              <a class="dropdown-item" href="/admin"><i class="feather icon-log-in"></i> @lang('locale.adminPanel')</a>
              @endif
              <div class="dropdown-divider"></div>
              @endcan
              <a class="dropdown-item" href="#logout" onclick="$('#logout').submit();"><i class="feather icon-power"></i> @lang('locale.Logout')</a>
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function() {
    $.ajax({
      type: 'GET',
      url: "{{ route('theme.gget') }}",
      success: function(response) {
        @if (env('APP_DEBUG', "false") == 'true')
            console.log("THEME: " + response);
        @endif
        if(response == 'light') {
          $('#themeSwitch').prop("checked", 0);
        }
        else {
          $('#themeSwitch').prop("checked", 1);
        }
      }
    });

  });
  function theme() {
    $.ajax({
      type: 'GET',
      url: "{{ route('theme.gchange') }}",
      success: function(response) {
        @if (env('APP_DEBUG', "false") == 'true')
            console.log("SETTED THEME: " + response);
        @endif
        location.reload();
      }
    });  
  }
</script>
