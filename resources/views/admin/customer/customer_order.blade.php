<?php use App\Http\Controllers\admin\CustomerController; ?>

@extends('admin.layouts.main')
@push('title')
Customer Order
@endpush
@push('js')
<script>
    $(document).ready(function(){
        $('.cancel').on('click',function(e){
            const id=$(this).attr('data-name');
            $(this).attr('disabled',true);
            var data={_token:"{{csrf_token()}}",id:id,go:false};
            $.ajax({
                url:"{{url('/admin/order/cancel')}}",
                type:'post',
                dataType:'json',
                data:data,
                success:function(data){
                    if(data.status){
                        toastr.error(`Order id: ${id} cancelled successfully`);
                        $('#i'+id).val('Canceled  By Seller');
                        $('#e'+id).addClass('disabled');
                    }
                },
                error:function(response){
                    console.log(response);
                }
            })
        })
    })
</script>
@endpush

@section('main-section')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/customer')}}">Customer</a></li>
                        <li class="breadcrumb-item">Order Details</li>
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
                <div class="row mt-3">
                    <?php foreach ($order as $k => $l) : ?>
                        <div class="col-md-12 ">
                            <div class="nav-item bg-primary rounded col-md-12">
                                <a href="#order<?= $k?>" data-toggle="collapse" class="nav-link h5"><i class="fa fa-caret-down"> &nbsp; Order <?= $k + 1 ?></i></a>
                            </div>
                            <div id="order<?= $k ?>" class="collapse form-group row <?= $k == 0 ? 'show' : '' ?>">
                                <?php foreach (CustomerController::get_products($l->id) as $key => $sl) : ?>
                                    <div class="col-md-6">
                                        <label>Product <?= $key + 1 ?></label>
                                        <input type="text" class="form-control form-control-sm" value="<?= $sl->name ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Quantity</label>
                                        <input type="text" class="form-control form-control-sm" value="<?= $sl->quantity ?>" readonly>
                                    </div>
                                <?php endforeach; ?>
                                <div class="col-md-6">
                                    <label>Delivery Address</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= CustomerController::get_single_address($l->shipping_id) ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Billing Address</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= CustomerController::get_single_address($l->billing_id) ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Subtotal (&dollar;)</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= $l->subtotal ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Discount (&dollar;)</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= $l->discount ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Ecotax (&dollar;)</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= $l->ecotax ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Vat (&dollar;)</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= $l->vat ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Total (&dollar;)</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= $l->total ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Payment Mode</label>
                                    <input type="text" class="form-control form-control-sm" value="Cash on delivery" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Payment Status</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= $l->payment_status ? "Paid" : "Unpaid" ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Transaction Id</label>
                                    <input type="text" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Order Status</label>
                                    <input type="text" class="form-control form-control-sm" id="i<?=$l->id?>" value="<?= CustomerController::get_order_status($l->order_status) ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Order Date</label>
                                    <input type="text" class="form-control form-control-sm" value="<?= date("d-m-Y", strtotime($l->created_at)) ?>" readonly>
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <a href="/components/order/edit.php?id=<?=$l->id?>"id="e<?=$l->id?>"class="btn btn-sm btn-info <?=$l->order_status<0?'disabled':''?>"><i class="fa fa-edit"> Edit</i></a>&nbsp;&nbsp;
                                    <button data-name="<?=$l->id?>" class="btn btn-sm btn-danger cancel " type="button" <?=$l->order_status<0?'disabled':''?>><i class="fa fa-times"> Cancel</i></button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection