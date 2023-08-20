@extends('layouts.app')
@section('extrahead')
    <title>Simasndan Web Apps - Dashboard Page</title>
    <meta name="description" content="Dashboard Page Sistem Informasi Manajemen Santri Al-Windan" />
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
                <h5 class="card-title text-primary">Selamat datang <strong>{{ $nama_lengkap }}</strong>! 🎉</h5>
                <p class="mb-4">
                Terdapat <span class="fw-bold">3</span> jadwal kelas aktif pada hari ini.
                </p> 
                <a href="#" class="btn btn-sm btn-outline-primary">Cek Jadwal</a>
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
                        <span class="d-block mb-1">Total Materi</span>
                        <h3 class="card-title text-nowrap mb-2">{{ $stats["total_materi"] }}</h3>
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
                    <span class="fw-semibold d-block mb-1">Total Semester</span>
                    <h3 class="card-title mb-2">{{ $stats["total_semester"] }}</h3>
                </div>
                </div>
            </div>
            </div>
        </div>
      <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
        <div class="row row-bordered g-0">
            <div class="col-md-8">
                <h5 class="card-header m-0 me-2 pb-3">Grafik Notifikasi</h5>
                <div id="series-chart" class="px-2"></div>
            </div>
            <div class="col-md-4">
                <h5 class="card-header m-0 me-2 pb-3">Semua Pengguna</h5>
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
                <span class="fw-semibold d-block mb-1">Total Santri</span>
                <h3 class="card-title mb-2">{{ $stats["total_santri"] }}</h3>
                <small class="text-success fw-semibold">
                    ({{ $stats["santri_aktif"] }} santri aktif / 
                    {{ $stats["santri_alumni"] }} santri alumni)  </small>
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
                    <span>Total Berita</span>
                    <h3 class="card-title text-nowrap mb-2">{{ $stats["total_berita"] }}</h3>
                    <small class="text-success fw-semibold">
                        ({{ $stats["berita_pengumuman"] }} Pengumuman / 
                        {{ $stats["berita_artikel"] }} Artikel / {{ $stats["berita_jadwal"] }} Jadwal)
                    </small>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                    <div class="card-title">
                    <h5 class="text-nowrap mb-3">Grafik Absensi Semester</h5>
                    <span class="badge bg-label-warning rounded-pill">{{ $stats["jadwal_years"]["year"] }}</span>
                    </div>
                    <div class="mt-sm-auto">
                    <h3 class="mb-0">{{ $stats["jadwal_years"]["total"] }} absen</h3>
                    </div>
                </div>
                <div id="jadwalReportChart"></div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <h5 class="card-header">Jadwal Kelas per-minggu</h5>
                <div class="card-body" id="column-chart">
                </div>
            </div>
        </div>
        <div class="col-6">
        <div class="card">
                <h5 class="card-header">Total Santri per-kelas</h5>
                <div class="card-body" id="polarbar-chart"></div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('extrascript')
<script type="text/javascript" src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<script type="text/javascript">
    var users = {!! json_encode($stats["all_users"]) !!};
    var notifs = {!! json_encode($stats["all_notifs"]) !!};
    var jadwals = {!! json_encode($stats["all_jadwals"]) !!};
    var kelas = {!! json_encode($stats["all_kelas"]) !!};
    var jadwalYears = {!! json_encode($stats["jadwal_years"]) !!};
    function showPieChart(){
        var options = {
            series: users.jumlah_users,
            labels: users.name_users,
            chart: {
                height:400,
                type: 'donut',
            },
            dataLabels: {
                enabled: false
            },
            responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 400
                },
                legend: {
                    show: true
                }
            }}],
            legend: {
                position: 'bottom',
                showForSingleSeries: false,
                offsetX: 0,
                offsetY: 0
            }};

        var chart = new ApexCharts(document.querySelector("#pie-chart"), options);
        chart.render();
    }
    function showSeriesChart(){
        var options = {
            series: [{
                name: notifs.key1,
                data: notifs.val1
            }, {
                name: notifs.key2,
                data: notifs.val2
            },{
                name: notifs.key3,
                data: notifs.val3
            }],
            chart: {
            height: 350,
            type: 'area'
            },
            dataLabels: {
            enabled: false
            },
            stroke: {
            curve: 'smooth'
            },
            xaxis: {
            type: 'date',
            categories: ["2023-08-01", "2023-08-02", "2023-08-03", "2023-08-04", "2023-08-05", "2023-08-06", "2023-08-07"]
            },
            tooltip: {
            x: {
                format: 'dd/MM/yy'
            },
            },
            };

            var chart = new ApexCharts(document.querySelector("#series-chart"), options);
            chart.render();
    }
    function showColumnChart(){
        var options = {
            series: [{
            name: 'Pagi',
                data: jadwals.pagi
            }, {
            name: 'Siang',
                data: jadwals.siang
            }, {
            name: 'Malam',
                data: jadwals.malam
            }],
            chart: {
            type: 'bar',
            height: 350
            },
            plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
            },
            dataLabels: {
            enabled: false
            },
            stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
            },
            xaxis: {
            categories: jadwals.key
            },
            yaxis: {
            title: {
                text: 'jadwal kelas'
            }
            },
            fill: {
            opacity: 1
            },
            tooltip: {
            y: {
                formatter: function (val) {
                return val + " jadwal"
                }
            }
            }
            };

            var chart = new ApexCharts(document.querySelector("#column-chart"), options);
            chart.render();
    }
    function showPolarChart(){
        var options = {
          series: kelas.jumlah_kelas,
          labels: kelas.name_kelas,
            chart: {
                type: 'polarArea',
                height: 350,
            },
            stroke: {
            colors: ['#fff']
            },
            fill: {
            opacity: 0.8
            },
            responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                position: 'bottom'
                }
            }
            }]};


            var chart = new ApexCharts(document.querySelector("#polarbar-chart"), options);
            chart.render();
    }
    function seriesReport(){
        const jadwalReportChartEl = document.querySelector('#jadwalReportChart'),
            jadwalReportChartConfig = {
            chart: {
                height: 80,
                type: 'line',
                toolbar: {
                show: false
                },
                dropShadow: {
                enabled: true,
                top: 10,
                left: 5,
                blur: 3,
                color: config.colors.warning,
                opacity: 0.15
                },
                sparkline: {
                enabled: true
                }
            },
            grid: {
                show: false,
                padding: {
                right: 8
                }
            },
            colors: [config.colors.warning],
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 5,
                curve: 'smooth'
            },
            series: [
                {
                data: jadwalYears.data
                }
            ],
            xaxis: {
                show: false,
                lines: {
                show: false
                },
                labels: {
                show: false
                },
                axisBorder: {
                show: false
                }
            },
            yaxis: {
                show: false
            }
        };
        const jadwalReportChart = new ApexCharts(jadwalReportChartEl, jadwalReportChartConfig);
        jadwalReportChart.render();
    }
    showPieChart(); 
    showSeriesChart();
    showColumnChart();
    showPolarChart();
    seriesReport();
    </script>
@endsection
