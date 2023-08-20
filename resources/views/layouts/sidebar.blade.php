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
        <a href="{{ route('dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-stats"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>
      <li class="menu-item {{ (request()->is('data-santri')) ? 'active' : '' }}">
        <a href="{{ route('santri') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-face"></i>
          <div data-i18n="Basic">Data Santri</div>
        </a>
      </li>
      <li class="menu-item {{ (request()->is('data-admin')) ? 'active' : '' }}">
        <a href="{{ route('admin') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bxs-face-mask"></i>
          <div data-i18n="Basic">Data Admin</div>
        </a>
      </li>
      <li class="menu-item {{ (request()->is('data-berita')) ? 'active' : '' }}">
        <a href="{{ route('berita') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bxs-news"></i>
          <div data-i18n="Basic">Data Berita</div>
        </a>
      </li>
      <li class="menu-item {{ (request()->is('data-materi')) ? 'active' : '' }}">
        <a href="{{ route('materi') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-notepad"></i>
          <div data-i18n="Basic">Data Materi</div>
        </a>
      </li>
      <li class="menu-item {{ (request()->is('data-guru')) ? 'active' : '' }}">
        <a href="{{ route('guru') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bxs-group"></i>
          <div data-i18n="Basic">Data Guru</div>
        </a>
      </li>
      <li class="menu-item {{ (request()->is('data-semester')) ? 'active' : '' }}">
        <a href="{{ route('semester') }}" class="menu-link">
          <i class='menu-icon tf-icons bx bx-align-justify' ></i>
          <div data-i18n="Basic">Data Semester</div>
        </a>
      </li>
      <li class="menu-item {{ (request()->is('data-notifikasi')) ? 'active' : '' }}">
        <a href="{{ route('notifikasi') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bxs-bell"></i>
          <div data-i18n="Basic">Data Notifikasi</div>
        </a>
      </li>
      

      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Absensi</span>
      </li>
      <li class="menu-item {{ (request()->is('data-jadwal*')) ? 'active' : '' }}">
        <a href="{{ route('jadwal') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bxs-chalkboard"></i>
          <div data-i18n="Basic">Data Jadwal</div>
        </a>
      </li>
      <li class="menu-item {{ (request()->is('data-kelas')) ? 'active' : '' }}">
        <a href="{{ route('kelas') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-grid"></i>          
          <div data-i18n="Basic">Data Kelas</div>
        </a>
      </li>
      <li class="menu-item {{ (request()->is('data-penilaian')) ? 'active' : '' }}">
        <a href="{{ route('penilaian') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bxs-food-menu"></i>
          <div data-i18n="Basic">Data Penilaian</div>
        </a>
      </li>

    </ul>
  </aside>