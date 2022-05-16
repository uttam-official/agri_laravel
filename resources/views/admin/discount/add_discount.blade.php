@extends('admin.layouts.main')
@push('title')
{{$title}}
@endpush
@push('js')
<script src="{{asset('system/dist/js/admin/add_discount.js')}}"></script>
@if($errors->all()))
<script>
    toastr.error("Please Enter Valid Input");
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
                    <h1 class="m-0">{{$title}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/discount')}}">Discount</a></li>
                        <li class="breadcrumb-item active">{{$title}}</li>
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
                <div class="card-header">
                    <h3 class="card-title">{{$title}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{url('admin/discount/add')}}" method="POST" onsubmit="return validation()">
                    @csrf
                    <input type="hidden" name="id" value="{{$id}}">
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter discount coupon name" name="name" value="{{$name??old('name')??''}}">
                                @error('name')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Valid From</label>
                            </div>
                            <div class="col-md-10">
                                <input type="date" class="form-control @error('validfrom') is-invalid @enderror" name="validfrom" id="valid_from" value="{{$validfrom??old('validfrom')??''}}">
                                @error('validfrom')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Valid Till</label>
                            </div>
                            <div class="col-md-10">
                                <input type="date" class="form-control @error('validtill') is-invalid @enderror" name="validtill" id="valid_till" value="{{$validtill??old('validtill')??''}}">
                                @error('validtill')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Type <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                @php $_selected_type=$type ?? old('type') ??''; @endphp
                                <select name="type" class="form-control text-uppercase @error('type') is-invalid @enderror">
                                    <option value="1">Fixed</option>
                                    <option value="2" {{$_selected_type==2?'selected':''}}>Percentage</option>
                                </select>
                                @error('type')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Amount <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter discount coupon amount" name="amount" value="{{$amount??old('amount')??''}}">
                                @error('amount')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Status <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                @php $_selected=$isactive ?? old('isactive') ??''; @endphp
                                <select name="isactive" class="form-control text-uppercase @error('isactive') is-invalid @enderror">
                                    <option value="1" >Active</option>
                                    <option value="0" {{$_selected==0?'selected':''}}>Deactive</option>
                                </select>
                                @error('isactive')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class=" text-center">
                            <button type="submit" class="btn btn-sm btn-success"><?= $btn_text ?></button>&nbsp;&nbsp;<button type="reset" class="btn btn-sm btn-warning text-white">Reset</button>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </form>
            </div>
            <!-- /.card -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection