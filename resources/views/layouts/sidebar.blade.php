<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo bg-{{ ($role == 'admin' || $role == 'pengasuh') ? 'danger':'primary'  }} mt-0">
      <a href="{{ asset('/admin') }}" class="app-brand-link">
        <span class="app-brand-logo demo">
            <i class='bx bxs-building-house text-white bx-md'></i>
        </span>
        <span class="app-brand-text demo menu-text fw-bolder text-white ms-2">
          {{ $role }}
        </span>
      </a>
  
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>
  
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
      @foreach($navs as $val)
        @if($val['type'] == 'header')
          <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ $val['val'] }}</span>
          </li>
        @elseif($val['type'] == 'navs')
          <li class="menu-item {{ $val['is_active'] }}">
            <a href="{{ $val['route'] }}" class="menu-link">
              <i class="menu-icon tf-icons bx {{ $val['menu_icons'] }}"></i>
              <div data-i18n="Basic">{{ $val['val'] }}</div>
            </a>
          </li>
        @endif
      @endforeach      
    </ul>
  </aside>