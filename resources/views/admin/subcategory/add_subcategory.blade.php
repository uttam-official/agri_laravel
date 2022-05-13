@push('title')
    {{$title}}
@endpush
@push('js')

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
                        <li class="breadcrumb-item"><a href="{{url('admin/subcategory')}}">Subcategory</a></li>
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
                    <h3 class="card-title"> {{$title}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{url('admin/subcategory/add')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$id??0}}">
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Category <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <select name="parent" class="form-control text-uppercase @error('parent') is-invalid @enderror" >
                                    <option value="" disabled selected>---Select a category---</option>
                                    @php $_selected_cat=$data->parent ?? old('parent') ?? '' @endphp
                                    @foreach ($category_list as $l)
                                        <option value="{{ $l->id }}" {{$_selected_cat==$l->id?'selected':''}} >{{$l->name}}</option>
                                    @endforeach
                                </select>
                                @error('name')
                                        <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Subcategory name" name="name" value="{{$data->name??old('name')??''}}" >
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
                                <input type="text" class="form-control @error('categoryorder') is-invalid @enderror" placeholder="Enter Subcategory Order" name="categoryorder" value="{{$data->categoryorder??old('categoryorder')??''}}" >
                                @error('categoryorder')
                                        <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Status <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                @php $_selected=$data->isactive ?? old('isactive') ?? '' @endphp
                                <select name="isactive" class="form-control text-uppercase @error('isactive') is-invalid @enderror" >
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