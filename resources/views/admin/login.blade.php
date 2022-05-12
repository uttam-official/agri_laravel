
@push('title')
    Admin > Login
@endpush
@extends('admin.layouts.blank')


@section('main-section')
<div class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Agri Express</b> LOGIN</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form action="" method="post">
                    @csrf
                    @if(session('login_error'))
                    <p class="bg-danger text-center p-2 rounded"> {{session()->get('login_error')}}</p>
                    @endif
                    @if(session('password_update'))
                    <p class="bg-warning text-white text-center p-2 rounded"> {{session('password_update')}}</p>
                    @endif
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-5 mx-auto">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</div>
@endsection