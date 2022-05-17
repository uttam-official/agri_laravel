<?php
use App\Http\Controllers\admin\ProductController;
if(old('category')!='' && old('subcategory')!='')
$subcategory_list=ProductController::get_subcategory_by_id(old('category'));
?>
@extends('admin.layouts.main')
@push('title')
{{$title}}
@endpush
@push('js')
<script src="{{url('system/dist/js/admin/add_product.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#category').on('change', function() {
            const parameter = {
                _token: '{{csrf_token()}}',
                category: $('#category').val()
            };
            $.ajax({
                url: '{{url("admin/subcategory/get")}}',
                type: 'post',
                dataType: 'json',
                data: parameter,
                success: function(data) {
                    $('#subcategory').empty();
                    $('#subcategory').append('<option selected disabled value>--- Select a Subcategory ----</option>');
                    $.each(data, function(i, item) {
                        $('#subcategory').append('<option value=' + item.id + '>' + item.name + '</option>');
                    })

                },
                error: function(response) {
                    console.log({
                        error: response
                    });
                }

            });
        });
    });
</script>
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
                        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/components/product">Product</a></li>
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
                <form action="{{url('admin/product/add')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$id}}">
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Category <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                @php $_selected_cat=$product->category ?? old('category') ?? '' @endphp
                                <select name="category" id="category" class="form-control text-uppercase @error('category') is-invalid @enderror">
                                    <option value="" disabled selected>---Select a category---</option>
                                    @foreach ($category_list as $l)
                                    <option value="{{$l->id}}" {{$l->id==$_selected_cat?'selected':''}}>{{ $l->name}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Subcategory <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                @php $_selected_subcat=$product->subcategory ?? old('subcategory') ?? '' @endphp
                                <select name="subcategory" id="subcategory" class="form-control text-uppercase @error('subcategory') is-invalid @enderror">
                                    <option value="" disabled selected>---Select a Subcategory---</option>
                                    @isset($subcategory_list)
                                    @foreach($subcategory_list as $sl)
                                    <option value="{{$sl->id}}" {{$sl->id==$_selected_subcat?'selected':''}}>{{$sl->name}}</option>
                                    @endforeach
                                    @endisset
                                </select>
                                @error('subcategory')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Name <span class="text-danger ">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter product name" name="name" value="{{old('name')??$product->name??''}}">
                                @error('name')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Description</label>
                            </div>
                            <div class="col-md-10">
                                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Enter product description">{{old('description') ?? $product->description ?? ''}}</textarea>
                                @error('description')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Price <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('price') is-invalid @enderror" placeholder="Enter product price" name="price" value="{{old('price') ?? $product->price ?? ''}}">
                                @error('price')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-md-3 col-md-2">
                                @isset($product->image_extension)
                                <img src="{{url('upload/product/small').'/'.$id.'.'.$product->image_extension}}" class="d-block mx-auto image-responsive mb-3">
                                @endisset
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Fetured Image <span class="text-danger">{{$id ? '' : "*"}}</span></label>
                            </div>
                            <div class="col-md-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror" name="image" accept="image/jpeg,image/png">
                                    <label class="custom-file-label">Choose file</label>
                                    @error('image')
                                    <span class="invalid-feedback">{{$message}}</span>
                                    @enderror
                                </div>
                                <label class="text-info text-sm">(Image should be &lt;10MB and minimum 1000&times;1000 pixels square sized)</label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Availability <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                @php $_selected_avi=old('availability') ?? $product->availability ?? 1 @endphp
                                <select name="availability" class="form-control">
                                    <option value="1" selected>In Stock</option>
                                    <option value="0" {{$_selected_avi==0?'selected':''}}>Out of Stock</option>
                                </select>
                            </div>
                        </div>
                        <div class="row gallery mb-3">
                            <div class="col-md-2"></div>
                            @isset($product->gallery)
                            @foreach($product->gallery as $g)
                            <div class="col-md-2 mb-1">
                                <img src="{{url('upload/productgallery/small').'/'.$g->extension}}" alt="" class="image-responsive d-block mx-auto">
                            </div>
                            @endforeach
                            @endisset
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>Gallery Image</label>
                            </div>
                            <div class="col-md-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('gallery.*') is-invalid @enderror" multiple="true" name="gallery[]" accept="image/jpeg,image/png">
                                    <label class="custom-file-label">Choose file</label>
                                    @error('gallery.*')
                                    <span class="invalid-feedback">Invalid Gallery Images</span>
                                    @enderror
                                </div>
                                <label class="text-info text-sm">*** You can choose multiple image here for product gallery *** <br />(Image should be &lt;10MB and minimum 1000&times;1000 pixels square sized)</label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="offset-md-2 col-md-10 row">
                                <div class="col-md-3 form-check">
                                    @php $_selected_sp=old('special')??$product->special??'' @endphp
                                    <input type="checkbox" name="special" class="form-check-input @error('special') is-invalid @enderror" {{$_selected_sp==1?'checked':''}}>
                                    <label class="form-check-label">Add to Special Product</label>
                                </div>
                                <div class="col-md-3 form-check">
                                    @php $_selected_fea=old('featured')??$product->featured??'' @endphp
                                    <input type="checkbox" name="featured" class="form-check-input @error('featured') is-invalid @enderror" {{$_selected_fea==1?'checked':''}}>
                                    <label class="form-check-label">Add to Featured Product</label>
                                </div>
                            </div>
                        </div>
                        <div class=" text-center">
                            <button type="submit" class="btn btn-sm btn-success">{{ $btn_text }}</button>&nbsp;&nbsp;<button type="reset" class="btn btn-sm btn-warning text-white">Reset</button>
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