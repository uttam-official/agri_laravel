@extends('client.layouts.main')
@push('title')
User Registration
@endpush
@push('js')
<script>
  function validate() {
    var pass = $('#input-password').val();
    var conPass = $('#input-confirm').val();
    var agree = $('#agree');
    console.log(agree);
    if (pass != conPass) {
      $('#input-password').focus();
      Swal.fire({
        icon: 'warning',
        title: 'Oops..',
        text: 'Password and Confirm Password must same !'
      });
      return false;
    }
    if (!agree.is(':checked')) {
      agree.focus();
      Swal.fire({
        icon: 'warning',
        title: 'Oops..',
        text: 'Please check agree button to proced...'
      });
      return false;
    }
    return true;
  }
</script>
@endpush
@section('main-section')
<div class="banner-in">
  <div class="container">
    <h1>Register</h1>
    <ul class="newbreadcrumb">
      <li><a href="{{url('/')}}">Home</a></li>
      <li>Register</li>
    </ul>
  </div>
</div>
<div id="main-container">
  <div class="container">
    <div class="row">
      <div class="col-sm-12" id="content">

        <p>If you already have an account with us, please login at the <a href="{{url('login')}}">login page</a>.</p>
        <form class="form-horizontal form-register" enctype="multipart/form-data" method="post" action="{{url('register')}}" onsubmit="return validate()">
          @csrf
          <fieldset id="account">
            <legend>Your Personal Details</legend>
            <div class="form-group required">
              <label for="input-firstname" class="col-lg-2 col-sm-3 control-label">First Name</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="input-firstname" placeholder="First Name" value="{{old('firstname')}}" name="firstname">
                @error('firstname')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class="form-group required">
              <label for="input-lastname" class="col-lg-2 col-sm-3 control-label">Last Name</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="input-lastname" placeholder="Last Name" value="{{old('lastname')}}" name="lastname">
                @error('lastname')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class="form-group required">
              <label for="input-email" class="col-lg-2 col-sm-3 control-label">E-Mail</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="input-email" placeholder="E-Mail" value="{{old('email')}}" name="email">
                @error('email')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class="form-group required">
              <label for="input-telephone" class="col-lg-2 col-sm-3 control-label">Telephone</label>
              <div class="col-sm-7">
                <input type="tel" class="form-control" id="input-telephone" placeholder="Telephone" value="{{old('phone')}}" name="phone">
                @error('phone')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <label for="input-fax" class="col-lg-2 col-sm-3 control-label">Fax</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="input-fax" placeholder="Fax" value="{{old('fax')}}" name="fax">
                @error('fax')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
          </fieldset>
          <fieldset id="address">
            <legend>Your Address</legend>
            <div class="form-group">
              <label for="input-company" class="col-lg-2 col-sm-3 control-label">Company</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="input-company" placeholder="Company" value="{{old('company')}}" name="company">
                @error('company')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class="form-group required">
              <label for="input-address-1" class="col-lg-2 col-sm-3 control-label">Address 1</label>
              <div class="col-sm-7 required">
                <input type="text" class="form-control" id="input-address-1" placeholder="Address 1" value="{{old('address1')}}" name="address1">
                @error('address1')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <label for="input-address-2" class="col-lg-2 col-sm-3 control-label">Address 2</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="input-address-2" placeholder="Address 2" value="{{old('address2')}}" name="address2">
                @error('address2')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class="form-group required">
              <label for="input-city" class="col-lg-2 col-sm-3 control-label">City</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="input-city" placeholder="City" value="{{old('city')}}" name="city">
                @error('city')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class="form-group required">
              <label for="input-postcode" class="col-lg-2 col-sm-3 control-label">Post Code</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="input-postcode" placeholder="Post Code" value="{{old('postcode')}}" name="postcode">
                @error('postcode')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class="form-group required">
              <label for="input-country" class="col-lg-2 col-sm-3 control-label">Country</label>
              <div class="col-sm-7">
                <select class="form-control" id="input-country" name="country">
                  <option value=""> --- Please Select --- </option>
                  <option value="India">India</option>

                </select>
                @error('country')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class="form-group required">
              <label for="input-zone" class="col-lg-2 col-sm-3 control-label">Region / State</label>
              <div class="col-sm-7">
                <select class="form-control" id="input-zone" name="state">
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
                @error('state')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend>Your Password</legend>
            <div class="form-group required">
              <label for="input-password" class="col-lg-2 col-sm-3 control-label">Password</label>
              <div class="col-sm-7">
                <input type="password" class="form-control" id="input-password" placeholder="Password" value="" name="password">
                @error('password')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class="form-group required">
              <label for="input-confirm" class="col-lg-2 col-sm-3 control-label">Password Confirm</label>
              <div class="col-sm-7">
                <input type="password" class="form-control" id="input-confirm" placeholder="Password Confirm" value="" name="confirm">
                @error('confirm')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend>Newsletter</legend>
            <div class="form-group">
              <label class="col-lg-2 col-sm-3 control-label">Subscribe</label>
              <div class="col-sm-7">
                <label class="radio-inline">
                  <input type="radio" value="1" name="newsletter">
                  Yes</label>
                  <input type="radio" checked="checked" value="0" name="newsletter">
                  No</label>
                  <label class="radio-inline">
                  @error('newsletter')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              </div>
            </div>
          </fieldset>
          <div class="buttons">
            <p>
              <input type="checkbox" name="agree" id="agree"> 
              @error('agree')
                <span class="text-danger text-sm">{{$message}}</span>
                @enderror
              I have read and agree to the <a class="agree" href="#"><b>Privacy Policy</b></a> 
            </p>
            <br>

            <input type="submit" class="btn btn160 btn-default btn-lg" value="Continue">
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection