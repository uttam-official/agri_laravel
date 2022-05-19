@extends('client.layouts.main')
@push('title')
{{$title}}
@endpush
@push('js')

@endpush
@section('main-section')
<div class="banner-in">
    <div class="container">
        <h1>{{$title}}</h1>
        <ul class="newbreadcrumb">
            <li><a href="{{url('/')}}">Home</a></li>
            <li>{{$title}}</li>
        </ul>
    </div>
</div>
<div id="main-container">
    <div class="container">
        <h3>Amount Payable: &dollar;{{$total}}</h3>
        <form action="{{url('/payment')}}" method="post">
            @csrf
            <div class="form-group">
                <h4><u>Please select a payment method</u></h4>
                <br>
                <label class="radio-inline "><input type="radio" value="1" name="payment" class="form-radio" required/> Cash on delivery</label>
            </div>
            <br><br>
            <div>
                <a class="btn btn-danger" href="{{url('cancel_order')}}">Cancel Order</a><button type="submit" class="btn btn-primary">Confirm Order</button>
            </div>

        </form>
    </div>
</div>
@endsection