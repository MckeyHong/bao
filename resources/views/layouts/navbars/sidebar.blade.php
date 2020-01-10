<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('images/admin/sidebar-1.jpg') }}">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="{{ asset('ctl/home') }}" class="simple-text logo-normal">
      {{ __('custom.websiteName') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('custom.admin.func.dashboard') }}</p>
        </a>
      </li>
      @foreach (config('permission.func') as $funcCate)
      @php
      $sidebarActive = $sidebarAria = $sidebarShow  = '';
      if (in_array($activePage, $funcCate['active'])) {
        $sidebarActive = 'active';
        $sidebarAria = 'true';
        $sidebarShow = 'show';
      }
      @endphp
      <li class="nav-item {{ $sidebarActive }}">
        <a class="nav-link" data-toggle="collapse" href="#sidebar-{{ $funcCate['key'] }}" aria-expanded="{{ $sidebarAria }}">
          <i class="material-icons">{{ $funcCate['icon'] }}</i>
          <p>{{ __('custom.admin.func.'. $funcCate['key']) }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ $sidebarShow }}" id="sidebar-{{ $funcCate['key'] }}">
          <ul class="nav">
            @foreach ($funcCate['menu'] as $funcMenu)
            <li class="nav-item{{ $activePage == $funcMenu['key'] ? ' active' : '' }}">
              <a class="nav-link" href="{{ asset($funcMenu['path']) }}">
                <span class="sidebar-mini"><i class="material-icons">menu</i></span>
                <span class="sidebar-normal">{{ __('custom.admin.func.' . $funcMenu['key']) }} </span>
              </a>
            </li>
            @endforeach
          </ul>
        </div>
      </li>
      @endforeach
    </ul>
  </div>
</div>