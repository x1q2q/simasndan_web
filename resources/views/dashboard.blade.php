@extends('layouts.app')
@section('extrahead')

@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="bs-toast toast toast-placement-ex top-0 start-50 m-3 sld-down"
      role="alert"
      aria-live="assertive"
      aria-atomic="true"
      data-delay="2000"
      id="toast-alert">
      <div class="toast-header">
          <i class="bx bx-bell me-2"></i>
          <div class="me-auto fw-semibold toast-title"></div>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body"></div>
    </div>
    <div class="row">
    <div class="col-lg-8 mb-4 order-0">
        <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-7">
            <div class="card-body">
                <h5 class="card-title text-primary">Selamat datang Rizkimmi! 🎉</h5>
                <p class="mb-4">
                Terdapat <span class="fw-bold">56</span> reservasi yang belum diverifikasi. 
                Silakan check daftar reservasi di halaman semua reservasi.
                </p> 
                <a href="#" class="btn btn-sm btn-outline-primary">Cek Reservasi</a>
            </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
                <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}"
                height="140">
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 order-1">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('assets/img/icons/unicons/chart.png') }}" alt="Credit Card" class="rounded" />
                        </div>
                        </div>
                        <span class="d-block mb-1">Total Labroom</span>
                        <h3 class="card-title text-nowrap mb-2">12</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('assets/img/icons/unicons/cc-primary.png') }}" alt="Credit Card" class="rounded" />
                        </div>                
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Fasilitas</span>
                    <h3 class="card-title mb-2">12</h3>
                </div>
                </div>
            </div>
            </div>
        </div>
      <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
        <div class="row row-bordered g-0">
            <div class="col-md-8">
                <h5 class="card-header m-0 me-2 pb-3">Reservasi (civitas/non-civitas)</h5>
                <div id="series-chart" class="px-2"></div>
            </div>
            <div class="col-md-4">
                <h5 class="card-header m-0 me-2 pb-3">Kategori Labroom</h5>
                <div id="pie-chart"></div>
            </div>
        </div>
        </div>
    </div>
    <!--/ Total Revenue -->
     <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
        <div class="row">
        <div class="col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                    <img
                    src="{{ asset('assets/img/icons/unicons/chart-success.png') }}"
                    alt="chart success"
                    class="rounded"
                    />
                </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total Member</span>
                <h3 class="card-title mb-2">12</h3>
                <small class="text-success fw-semibold">
                    (9 activated / 
                    3 not-activated)  </small>
                </div>
            </div>
        </div>
        <div class="col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img
                        src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}"
                        alt="Credit Card"
                        class="rounded"
                        />
                    </div>
                    </div>
                    <span>Total Reservasi</span>
                    <h3 class="card-title text-nowrap mb-2">99</h3>
                    <small class="text-success fw-semibold">
                        (90 civitas / 
                        70 non-civitas)
                    </small>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>

</div>
@endsection
@section('extrascript')
<script type="text/javascript" src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection
