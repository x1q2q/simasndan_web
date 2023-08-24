@extends('layouts.auth')
@section('extrahead')
    <title>Request Gagal!</title>
    <meta name="description" content="Sistem Informasi Manajemen Santri Al-Windan" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card p-5">
        <h3>Restricted area!</h3>
        <p>Status login anda adalah <strong>{{ $from }}</strong>, anda tidak bisa mengakses fitur menu ini!</p>
        <div>
            <a href="{{ route('login') }}" class="btn btn-danger">Login Kembali</a>
        </div>
    </div>

</div>
@endsection
@section('extrascript')
<script type="text/javascript" src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection
