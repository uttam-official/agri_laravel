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
            <li>{{$title }}</li>
        </ul>
    </div>
</div>
<div id="main-container">
    <div class="container">
        <h2 class="text-primary h2">Thank You !</h2>
        <br>
        <p class="h3">Your order number <strong class="text-info"><u>{{$order_id}}</u></strong> has been successfully placed, Please check email for further details. </p>
        <br>
        <a href="index.php" class="btn btn-primary">GO TO HOME</a>
        <br><br>
    </div>
</div>
@endsection