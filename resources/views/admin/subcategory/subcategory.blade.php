@push('title')
Subcategory Management
@endpush
@push('js')
    <script src="{{url('system/dist/js/admin/subcategory.js')}}"></script>
    @if(session()->has('subcategory_success'))
    <script>
        toastr.success("{{session()->get('subcategory_success')}}");
    </script>
    @endif
    @if(session()->has('subcategory_error'))
    <script>
        toastr.error("{{session()->get('subcategory_error')}}");
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
                    <h1 class="m-0">Subcategory</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item">Subcategory</li>
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
                    <a href="{{url('/admin/subcategory/add/')}}" class="btn btn-sm btn-success mr-3"><i class="fa fa-plus-circle"></i> Add
                        New</a>
                </div>
                <div class="card-body">

                    <div class="rounded-top pt-3" style="border-top: solid 3px #17a2b8;">
                        <table id="subcategory_table" class="table table-hover table-striped col-md-11 nowrap dataTable">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th class="text-left ml-3">Subcategory Name</th>
                                    <th>Order</th>
                                    <th class="text-left ml-3">Parent Category</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($page_data)>0)
                                    @foreach($page_data as $k=>$l)
                                        <tr class="text-center">
                                            <td>{{$k+1}}</td>
                                            <td class="text-left ml-3">{{$l->name}}</td>
                                            <td>{{$l->categoryorder}}</td>
                                            <td class="text-left ml-3">{{$l->parent_name}}</td>
                                            <td>{!!$l->isactive==1?'<span class="badge badge-primary">Active</span>':'<span class="badge badge-secondary">Inactive</span>'!!}</td>
                                            <td>
                                                <a href="{{url('admin/subcategory/add').'/'.$l->id}}" class="btn btn-sm btn-outline-info"><i class="fa fa-edit"></i></a>
                                                <a href="{{url('admin/subcategory/delete').'/'.$l->id}}" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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