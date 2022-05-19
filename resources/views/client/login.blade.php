@extends('client.layouts.main')
@push('title')
User Login
@endpush
@push('js')
@if(session()->has('register_success'))
<script>
  toastr.success("{{session()->get('register_success')}}");
</script>
@endif
@if(session()->has('login_error'))
<script>
  toastr.error("{{session()->get('login_error')}}");
</script>
@endif
@endpush
@section('main-section')
<div class="banner-in">
  <div class="container">
    <h1>Login</h1>
    <ul class="newbreadcrumb">
      <li><a href="#">Home</a></li>
      <li>Login</li>
    </ul>
  </div>
</div>
<div id="main-container">
  <div class="container">

    <div class="row">
      <div class="col-sm-12 login-page" id="content">
        <div class="row">
          <div class="col-sm-4">
            <div class="well">
              <h4>NEW CUSTOMER</h4>
              <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
              <a class="btn btn-default btn-lg" href="{{url('register')}}">Register</a>
            </div>
          </div>
          <div class="col-sm-8">
            <h4>RETURNING CUSTOMER</h4>
            <form enctype="multipart/form-data" method="post" action="">
              @csrf
              <div class="form-group">
                <label for="email" class="control-label">Enter your Email Address</label>
                <input type="text" class="form-control" id="email" value="" name="email">
                @error('email')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="password" class="control-label">Enter your Password</label>
                <input type="password" class="form-control" id="password" value="" name="password">
                @error('password')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
              <div class="clearfix">
                <input type="submit" class="btn btn-default btn-lg pull-left" value="Login">
                <a class="pull-right" href="#">Forgotten Password</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection