<?php

use App\Http\Controllers\admin\CustomerController; ?>
@extends('admin.layouts.main')
@push('title')
Order Management
@endpush
@push('js')
<script src="{{url('system/dist/js/admin/order.js')}}"></script>
<script>
    $(function() {
        $('.cancel_order').on('click', function() {
            const id = $(this).attr('data-id');
            const data = {
                _token: "{{csrf_token()}}",
                id,
                go:true
            };
            $.ajax({
                url: "{{url('admin/order/cancel')}}",
                type: 'post',
                dataType: 'json',
                data,
                success: function(data) {
                    if(data.status){
                        toastr.error('Order id: ' +id+ ' canceled successfully!');
                        location.reload();
                    }
                },
                error: function(response) {
                    console.log({
                        error: response
                    });
                }
            })
        })
    })
</script>
@if(session()->has('order_error'))
<script>
    toastr.error("{{session()->get('order_error')}}");
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
                    <h1 class="m-0">Order</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                        <li class="breadcrumb-item">Order</li>
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
                    <table class="table table-bordered table-striped table-hover dataTables" id="order_table">
                        <thead>
                            <tr class="text-center table-secondary">
                                <th>#</th>
                                <th>Order ID</th>
                                <th class="text-left col-md-3">Deliver to</th>
                                <th>Date</th>
                                <th>Price (&dollar;)</th>
                                <th>Status</th>
                                <th class="text-left">Who Ordered</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order as $key => $l)
                            <tr class="text-center">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $l->id }}</td>
                                <td class="text-left ">{{ CustomerController::get_single_address($l->shipping_id) }}</td>
                                <td>{{ date("d-m-Y", strtotime($l->created_at)) }}</td>
                                <td>{{ $l->total }}</td>
                                <td><span class="badge badge-info">{{ $l->status }}</span></td>
                                <td class="text-left">{{ $l->firstname . ' ' . $l->lastname }}</td>
                                <td>
                                    <a href="{{ url('admin/order/edit/'.$l->id) }}" class="btn btn-sm btn-primary {{ $l->order_status < 0 ? 'disabled' : '' }}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="#cancel" data-id="{{ $l->id }}" class="btn btn-sm btn-warning cancel_order {{ $l->order_status < 0 ? 'disabled' : '' }}" data-toggle="tooltip" title="Cancel"><i class="fa fa-times"></i></a>
                                    <a href="{{ url('admin/order/delete/'.$l->id) }}" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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