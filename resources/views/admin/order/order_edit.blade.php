<?php

use App\Http\Controllers\admin\CustomerController; ?>
@extends('admin.layouts.main')
@push('title')
Order Edit
@endpush
@push('js')
@if(session()->has('order_edit_success'))
<script>
    toastr.success("{{session()->get('order_edit_success')}}");
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
                    <h1 class="m-0">Edit Order</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/order')}}">Order</a></li>
                        <li class="breadcrumb-item">Edit Order</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="rounded-top" style="border-top: solid 3px #17a2b8;">
                <div class="row mt-1">
                    <p class="h5 col-md-12 text-primary">Product Details</p>
                    <form action="{{url('admin/order/edit')}}" method="POST" class="col-md-12 form-group row">
                        @csrf
                        <input type="hidden" name="id" value="<?= $order->id ?>">
                        @foreach (CustomerController::get_products($order->id) as $key => $sl)
                        <div class="col-md-6">
                            <label>Product <?= $key + 1 ?></label>
                            <input type="text" class="form-control form-control-sm" value="<?= $sl->name ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Quantity</label>
                            <input type="text" class="form-control form-control-sm" value="<?= $sl->quantity ?>" readonly>
                        </div>
                        @endforeach
                        <p class="h5 col-md-12 text-primary mt-3">Address Details</p>
                        <div class="col-md-6">
                            <label>Delivery Address</label>
                            <input type="text" class="form-control form-control-sm" value="<?= CustomerController::get_single_address($order->shipping_id) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Billing Address</label>
                            <input type="text" class="form-control form-control-sm" value="<?= CustomerController::get_single_address($order->billing_id) ?>" readonly>
                        </div>
                        <p class="h5 col-md-12 text-primary mt-3">Billing Details</p>
                        <div class="col-md-6">
                            <label>Subtotal (&dollar;)</label>
                            <input type="text" class="form-control form-control-sm" value="<?= $order->subtotal ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Discount (&dollar;)</label>
                            <input type="text" class="form-control form-control-sm" value="<?= $order->discount ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Ecotax (&dollar;)</label>
                            <input type="text" class="form-control form-control-sm" value="<?= $order->ecotax ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Vat (&dollar;)</label>
                            <input type="text" class="form-control form-control-sm" value="<?= $order->vat ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Total (&dollar;)</label>
                            <input type="text" class="form-control form-control-sm" value="<?= $order->total ?>" readonly>
                        </div>
                        <p class="h5 col-md-12 text-primary mt-3">Payment Details</p>
                        <div class="col-md-6">
                            <label>Payment Mode</label>
                            <input type="text" class="form-control form-control-sm" value="Cash on delivery" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Payment Status</label>
                            <select name="payment_status" class="form-control form-control-sm">
                                <option value="1" <?= $order->payment_status == 1 ? 'selected' : '' ?>>Successful</option>
                                <option value="0" <?= $order->payment_status == 0 ? 'selected' : '' ?>>Unsuccessful</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Transaction Id</label>
                            <input type="text" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Order Status</label>
                            <select name="order_status" id="" class="form-control form-control-sm">
                                <option value="" disbled selected>---Select One---</option>
                                <?php
                                foreach (CustomerController::get_all_orderstatus() as $l) :
                                    $_selected = $l->id == $order->order_status ? "selected" : '';
                                ?>
                                    <option value="<?= $l->id ?>" <?= $_selected ?>><?= $l->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Order Date</label>
                            <input type="date" class="form-control form-control-sm" value="<?= date("Y-m-d", strtotime($order->created_at)) ?>" readonly>
                        </div>
                        <div class="col-md-12 text-center mt-3">
                            <button type="submit" class="btn btn-sm btn-success"> Save</button>&nbsp;&nbsp;
                            <button class="btn btn-sm btn-warning " type="reset">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection