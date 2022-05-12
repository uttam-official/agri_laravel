@push('title')
Category Management
@endpush
@push('js')
<script src="{{url('system/dist/js/admin/category.js')}}"></script>
@endpush
@extends('admin.layouts.main')
@section('main-section')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Category</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item">Category</li>
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
                <div class="text-right mt-3">
                    <a href="{{url('/admin/category/add/')}}" class="btn btn-sm btn-success mr-3"><i class="fa fa-plus-circle"></i> Add
                        New</a>
                </div>
                <div class="card-body">

                    <div class="rounded-top pt-3" style="border-top: solid 3px #17a2b8;">
                        <table id="category_table" class="table table-hover table-stripped col-md-11 nowrap dataTable">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th class="text-left">Category Name</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Number of Sub-category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection