@push('title')
{{$title??'Add Category'}}
@endpush
@push('js')
<script src="{{url('system/dist/js/admin/add_category.js')}}"></script>
@if($errors->all()))
<script>
    toastr.error("Please Enter Valid Input");
</script>
@endif
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
                    <h1 class="m-0"> {{$title}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/category')}}">Category</a></li>
                        <li class="breadcrumb-item active"> {{$title}}</li>
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
                    <h3 class="card-title">{{$title}} </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{url('/admin/category/add')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$id}}">
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter category name" name="name" value="{{$name??old('name')??''}}" >
                                @error('name')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Order <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control @error('categoryorder') is-invalid @enderror" placeholder="Enter category Order" name="categoryorder" value="{{$categoryorder??old('categoryorder')??''}}" >
                                @error('categoryorder')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        @isset ( $extension)
                        <div class="row mb-3">
                            <div class="col-md-3"></div>
                            <div class="col-md-2">
                                <img style="background-color:rgb(180 217 129)" class="image image-responsive d-block mx-auto" src="{{asset('upload/category/').'/'.$id.'.'.$extension}}" />
                            </div>
                        </div>                        
                        @endisset
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Image @if($id==0)<span class="text-danger">*</span>@endif</label>
                            </div>
                            <div class="col-md-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('categoryorder') is-invalid @enderror" name="image" accept="image/jpeg,image/png">
                                    <label class="custom-file-label">Choose file</label>
                                    @error('image')
                                    <span class="invalid-feedback">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Status <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <select name="isactive" class="form-control" >
                                    <option value="1">Active</option>
                                    <option value="0" {{$isactive==0?'selected':''}}>Deactive</option>
                                </select>
                            </div>
                        </div>
                        <div class=" text-center">
                            <button type="submit" class="btn btn-sm btn-success">{{$btn_text ?? 'Add'}}</button>&nbsp;&nbsp;<button type="reset" class="btn btn-sm btn-warning text-white">Reset</button>
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