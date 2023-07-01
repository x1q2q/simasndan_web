<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-primary" 
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <span class="text-capitalize text-white app-brand-text demo menu-text fw-light">
                {{  config('app.name') }}
            </span>
        </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
                <img src="{{ asset('assets/img/avatars/admin1.png') }}" alt="user-avatar" 
                        class="d-block rounded-circle img-fluid">
            </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="#">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-md">
                        <img src="{{ asset('assets/img/avatars/admin1.png') }}" alt="user-avatar" 
                        class="d-block rounded-circle img-fluid">
                    </div>
                    </div>
                    <div class="flex-grow-1">
                    <span class="fw-semibold d-block">{{ $nama }}</span>
                    <small class="text-muted">{{ $role }}</small>
                    </div>
                </div>
                </a>
            </li>
            <li>
                <div class="dropdown-divider"></div>
            </li>
            <li>
                <form action="/logout" method="POST">
                    @csrf
                    <button class="dropdown-item" type="submit">
                        <i class="bx bx-log-out me-2"></i>
                        <span class="align-middle">Log Out</span>
                    </button>
                </form>
            </li>
            </ul>
        </li>
        <!--/ User -->
        </ul>
    </div>
</nav>