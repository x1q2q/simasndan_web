<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo bg-primary mt-0">
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
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Umum</span>
      </li>
      <li class="menu-item {{ (request()->is('dashboard')) ? 'active' : '' }}">
        <a href="/dashboard" class="menu-link">
          <i class="menu-icon tf-icons bx bx-stats"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>
      <li class="menu-item {{ (request()->is('data-santri')) ? 'active' : '' }}">
        <a href="/data-santri" class="menu-link">
          <i class="menu-icon tf-icons bx bx-face"></i>
          <div data-i18n="Basic">Data Santri</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{ asset('admin/lab-category') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bxs-news"></i>
          <div data-i18n="Basic">Data Berita</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{ asset('admin/list-labrooms') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-notepad"></i>
          <div data-i18n="Basic">Data Materi</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{ asset('admin/list-members') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bxs-group"></i>
          <div data-i18n="Basic">Data Guru</div>
        </a>
      </li>

    </ul>
  </aside>