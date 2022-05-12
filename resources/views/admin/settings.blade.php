@extends('admin.layouts.main')
@push('title')
Admin > Settings
@endpush
@push('js')
    <script src="{{asset('system/dist/js/admin/settings.js')}}"></script>
@endpush
@section('main-section')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Settings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- general form elements -->
            <div class="card card-outline card-info">
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">
                    <form action="" method="POST" class="form-group" id="setting_form">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Username/Email Id <span class="text-danger">*</span></label>
                                <input type="text" id="email" class="form-control" name="email" placeholder="Enter your username/email id" value="{{$email}}" >
                            </div>
                            <div class="col-md-6">
                                <label>Password <span class="text-danger">*</span></label>
                                <input id="password" type="password" name="password" class="form-control" placeholder="Enter new password" >
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="d-inline-block ml-auto mr-3">
                                <button class="btn btn-sm btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection