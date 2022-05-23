@extends('client.layouts.main')
@push('title')
{{$title}}
@endpush
@push('js')
@if(session()->has('billing_error'))
<script>
    toastr.error("{{session()->get('billing_error')}}");
</script>
@endif
@if(session()->has('shipping_error'))
<script>
    toastr.error("{{session()->get('shipping_error')}}");
</script>
@endif
<script>
    $(function(){
        $('#add_address').on('submit',function(e){
            e.preventDefault();
            const form=new FormData(this);
            const parameter={
                _token:"{{csrf_token()}}",
                company:form.get('company'),
                address1:form.get('address1'),
                address2:form.get('address2'),
                city:form.get('city'),
                postcode:form.get('postcode'),
                country:form.get('country'),
                state:form.get('state')
            };
            $.ajax({
                url:"{{url('/add_address')}}",
                type:'post',
                dataType:'json',
                data:parameter,
                success:function(data){
                    if(data.status){
                        location.reload();
                    }
                },error:function(response){
                    console.log({error:response});
                }
            });
        });
    });
</script>
@endpush
@section('main-section')
<style>
    .row-eq-height {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
    }
</style>
<div class="banner-in">
    <div class="container">
        <h1>{{$title}}</h1>
        <ul class="newbreadcrumb">
            <li><a href="{{url('/')}}">Home</a></li>
            <li>{{$title}} </li>
        </ul>
    </div>
</div>
<div id="main-container">
    <div class="container">
        <form action="" method="post">
            @csrf
            <div class="row row-eq-height">
                @foreach ($address as $l)
                    <div class="col-sm-3 " style="padding-bottom:19px;">
                        <div class="panel panel-default " style="height: 100%;">
                            <div class="panel-body" style="height: 84%;">
                                <p>
                                    <strong> Address: </strong>{{ $l->company ? $l->company . ',' : '' }} {{ $l->address1 }}, {{ $l->address2 ? $l->address2 . ',' : '' }} {{ $l->city }} - {{ $l->postcode }}
                                </p>
                                <p>
                                    <strong>Post code :</strong> {{ $l->postcode }}
                                </p>
                                <p>
                                    <strong>State :</strong> {{ $l->State }}
                                </p>
                                <p>
                                    <strong>Country :</strong> {{ $l->country }}
                                </p>
                            </div>
                            <div class="panel-footer text-center">
                                <input type="radio" name="address" value="{{ $l->id }}" required>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-3 " style="padding-bottom:19px;">
                    <div class="panel panel-default" style="height: 100%;">
                        <div class="panel-body" style="HEIGHT:100%;display:flex;align-items:center;justify-content:center;">
                            <div>
                                <button data-toggle="modal" data-target="#flipFlop" class="btn btn-success" type="button"><i class="fa fa-plus-circle"></i> &nbsp;ADD NEW ADDRESS</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit" name="{{ $btn_name }}">NEXT</button>
        </form>
    </div>
</div>

<div class="modal fade" id="flipFlop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close" style="font-size:36px;"></i></button>
            </div>
            <form action="" method="post" id="add_address">
                <div class="modal-body">
                    <fieldset id="address">
                        <legend>Your Address</legend>
                        <div class="form-group">
                            <label for="input-company" class=" col-sm-3 control-label">Company</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="input-company" placeholder="Company" value="" name="company">
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group required">
                            <label for="input-address-1" class="col-sm-3 control-label">Address 1</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="input-address-1" placeholder="Address 1" value="" name="address1" required>
                            </div>
                        </div><br><br>
                        <div class="form-group">
                            <label for="input-address-2" class="col-sm-3 control-label">Address 2</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="input-address-2" placeholder="Address 2" value="" name="address2">
                            </div>
                        </div><br><br>
                        <div class="form-group required">
                            <label for="input-city" class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="input-city" placeholder="City" value="" name="city" required>
                            </div>
                        </div><br><br>
                        <div class="form-group required">
                            <label for="input-postcode" class="col-sm-3 control-label">Post Code</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="input-postcode" placeholder="Post Code" value="" name="postcode" required>
                            </div>
                        </div><br><br>
                        <div class="form-group required">
                            <label for="input-country" class="col-sm-3 control-label">Country</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="input-country" name="country" required>
                                    <option value=""> --- Please Select --- </option>
                                    <option value="India">India</option>
                                </select>
                            </div>
                        </div><br><br>
                        <div class="form-group required">
                            <label for="input-zone" class="col-sm-3 control-label">Region / State</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="input-zone" name="state" required>
                                    <option value=""> --- Please Select --- </option>
                                    <option value="West Bengal">West Bengal</option>
                                    <option value="Delhi">Delhi</option>
                                    <option value="Maharastra">Maharastra</option>
                                    <option value="Tamilnadu">Tamilnadu</option>
                                    <option value="Bihar">Bihar</option>
                                    <option value="Jharkhand">Jharkhand</option>
                                    <option value="UP">UP</option>
                                    <option value="HP">HP</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" name="add_address">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection