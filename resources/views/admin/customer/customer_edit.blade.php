@extends('admin.layouts.main')
@push('title')
Edit Customer
@endpush
@push('js')
<script>
    $(document).ready(function() {
        $('#customer_details').on('submit', function(e) {
            e.preventDefault();
            const form = new FormData(e.target);
            const data = {
                '_token':"{{csrf_token()}}",
                'customer_edit': 'customer_edit',
                'id': form.get('id'),
                'fname': form.get('fname'),
                'lname': form.get('lname'),
                'email': form.get('email'),
                'phone': form.get('phone'),
                'fax': form.get('fax'),
                'isactive': form.get('isactive')
            }
            $.ajax({
                url: "{{url('admin/customer/edit')}}",
                type: 'post',
                dataType: 'json',
                data: data,
                success: function(data) {
                    if (data.status) {
                        toastr.success('Customer updated successfully!');
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            })
        })


        $('.address').on('submit', function(e) {
            e.preventDefault();
            var form = new FormData(e.target);
            var data = {
                '_token':"{{csrf_token()}}",
                'address': 'address',
                'id': form.get('id'),
                'company': form.get('company'),
                'address_1': form.get('address_1'),
                'address_2': form.get('address_2'),
                'city': form.get('city'),
                'postcode': form.get('postcode'),
                'country': form.get('country'),
                'state': form.get('state')
            };

            $.ajax({
                url: "{{url('admin/customer/edit_address')}}",
                type: 'post',
                dataType: 'json',
                data: data,
                success: function(data) {
                    if (data.status) {
                        toastr.success(form.get('address') + ' updated successfully !');
                    }
                },
                error: function(response) {
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
                    <h1 class="m-0">Edit Customer</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/customer')}}">Customer</a></li>
                        <li class="breadcrumb-item">Edit Customer</li>
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
                <div class="row mt-2 ml-2">
                    <div class="col-md-12">
                        <p class="h5">Personal Details</p>
                        <form action="" method="post" class="form-group row" id="customer_details">
                            <input type="hidden" name="id" value="{{ $id }}">
                            <div class="col-md-6">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="fname" placeholder="Enter first name" value="{{ $customer->firstname }}">
                            </div>
                            <div class="col-md-6">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lname" placeholder="Enter last name" value="{{ $customer->lastname }}">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter email" value="{{ $customer->email }}">
                            </div>
                            <div class="col-md-6">
                                <label>Telephone</label>
                                <input type="text" class="form-control" name="phone" placeholder="Enter telephone number" value="{{ $customer->phone }}">
                            </div>
                            <div class="col-md-6">
                                <label>Fax</label>
                                <input type="text" class="form-control" name="fax" placeholder="Enter fax" value="{{ $customer->fax }}">
                            </div>
                            <div class="col-md-6">
                                <label>Status</label>
                                <select name="isactive" class="form-control">
                                    <option value="1" {{ $customer->isactive ? "selected" : '' }}>Active</option>
                                    <option value="0" {{ $customer->isactive ? "" : 'selected' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-3 text-center">
                                <button class="btn btn-sm btn-success" type="submit">Save</button>&nbsp;&nbsp;
                                <button class="btn btn-sm btn-warning" type="reset">Reset</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <p class="h4">Addresses</p>
                        @foreach ($address as $key => $l)
                            <div class="pl-3 nav-item bg-warning  rounded">
                                <a class="h6 text-info nav-link" data-toggle="collapse" href="#address{{ $key + 1 }}"><i class="fa fa-caret-down"></i> &nbsp; Address {{ $key + 1 }}</a>
                            </div>
                            <form action="" method="post" class="form-group row address collapse {{$key == 0 ? 'show' : ''}}" id="address{{ $key + 1 }}">
                                <input type="hidden" name="id" value="{{ $l->id }}">
                                <input type="hidden" name="address" value="Address {{ $key + 1 }}">
                                <div class="col-md-6">
                                    <label>Company</label>
                                    <input type="text" class="form-control" name="company" value="{{$l->company}} ">
                                </div>
                                <div class="col-md-6">
                                    <label>Address 1</label>
                                    <input type="text" class="form-control" name="address_1" value="{{$l->address1 }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Address 2</label>
                                    <input type="text" class="form-control" name="address_2" value="{{$l->address2}}">
                                </div>
                                <div class="col-md-6">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" value="{{$l->city }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Postcode</label>
                                    <input type="text" class="form-control" name="postcode" value=" {{$l->postcode}} ">
                                </div>
                                <div class="col-md-6">
                                    <label>Country</label>
                                    <select class="form-control" id="input-country" name="country" required>
                                        <option value=""> --- Please Select --- </option>
                                        <option value="India" selected>India</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>State/Region</label>
                                    <select class="form-control" id="input-zone" name="state" required>
                                        <option value=""> --- Please Select --- </option>
                                        <option value="West Bengal" {{ $l->State == "West Bengal" ? 'selected' : '' }}>West Bengal</option>
                                        <option value="Delhi" {{ $l->State == "Delhi" ? 'selected' : '' }}>Delhi</option>
                                        <option value="Maharastra" {{ $l->State == "Maharastra" ? 'selected' : '' }}>Maharastra</option>
                                        <option value="Tamilnadu" {{ $l->State == "Tamilnadu" ? 'selected' : '' }}>Tamilnadu</option>
                                        <option value="Bihar" {{ $l->State == "Bihar" ? 'selected' : '' }}>Bihar</option>
                                        <option value="Jharkhand" {{ $l->State == "Jharkhand" ? 'selected' : '' }}>Jharkhand</option>
                                        <option value="UP" {{ $l->State == "UP" ? 'selected' : '' }}>UP</option>
                                        <option value="HP" {{ $l->State == "HP" ? 'selected' : '' }}>HP</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3 text-center">
                                    <button class="btn btn-sm btn-success" type="submit">Save</button>&nbsp;&nbsp;
                                    <button class="btn btn-sm btn-warning" type="reset">Reset</button>
                                </div>
                            </form>
                        @endforeach

                    </div>
                </div>
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