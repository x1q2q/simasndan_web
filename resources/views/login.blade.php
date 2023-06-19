@extends('layouts.auth')
@section('extrahead')
    <title>Simasndan Apps - Login Page</title>
    <meta name="description" content="Login Page Sistem Informasi Manajemen Santri Al-Windan" />
@endsection
@section('content')


<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        
            <div class="bs-toast toast toast-placement-ex top-0 end-0 m-3 sld-down"
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
        
        <div class="authentication-inner">
            <div class="text-center my-3 p-3">
                <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" alt="Logo Pondok Pesantren Almuayyad Windan" width="50%" height="50%">
            </div>
            <div class="card">
                <div class="card-header p-3 bg-primary text-center">
                    <span class="text-white">
                        Selamat datang di login page Simasndan!
                    </span>
                </div>
                <div class="card-body">
                    <form action="/login" class="signbox-body" id="formLogin" method="POST">
                        @csrf
                        <div class="my-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" class="form-control form-select" id="role">
                                <option value="1">Pengurus</option>
                                <option value="2">Guru</option>
                                <option value="3">Admin</option>
                                <option value="4">Pengasuh</option>
                            </select>
                        </div>
                        <div class="my-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" value="{{ old('username') }}"
                            name="username" placeholder="masukkan username" autofocus />
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" placeholder="*********" aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="">Forgot password?</a>
                            <input class="form-checkbox" type="checkbox" name="remember" id="remember"/>
                        </div><!-- form-group -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100" type="submit">
                                Masuk <span class="tf-icons bx bx-log-in-circle"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>

@endsection
@section('extrascript')
@if(session('error'))
<script type="text/javascript">
    var msg = "{!! session('error') !!}";
    showToast('danger','Peringatan',msg,'#toast-alert');
</script>
@endif
@endsection
