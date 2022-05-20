@extends('admin.layouts.main')
@push('title')
Customer Management
@endpush
@push('js')
<script src="{{url('system/dist/js/admin/customer.js')}}"></script>
@if(session()->has('customer_error'))
<script>
    toastr.error("{{session()->get('customer_error')}}")
</script>
@endif
@endpush
@section('main-section')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Customer</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item">Customer</li>
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
                <div class="card-body">
                        <table class="table table-bordered table-striped table-hover dataTables" id="customer_table">
                            <thead>
                                <tr class="text-center table-secondary">
                                    <th>#</th>
                                    <th class="text-left ">Name</th>
                                    <th class="text-left">Mail</th>
                                    <th class="text-left">Telephone</th>
                                    <th>Status</th>
                                    <th>No. of order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer as $key => $l)
                                <tr class="text-center">
                                    <td>{{ $key + 1 }}</td>
                                    <td class="text-left ">{{ $l->firstname . ' ' . $l->lastname }}</td>
                                    <td class="text-left">{{ $l->email }}</td>
                                    <td class="text-left">{{ $l->phone }}</td>
                                    <td>{!! $l->isactive ? '<span class="badge badge-primary">Active</span>' : '<span class="badge badge-secondary">Inactive</span>' !!}</td>
                                    <td>{{ $l->no_of_order }}</td>
                                    <td>
                                        <a href="{{url('admin/customer/edit/'.$l->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a href="{{url('admin/customer/order/'.$l->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Orders"><i class="fa fa-shopping-cart"></i></a>
                                        <a href="{{url('/admin/customer/delete/'.$l->id)  }}" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
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