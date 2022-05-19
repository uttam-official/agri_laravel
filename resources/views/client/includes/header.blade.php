<?php

use App\Http\Controllers\client\FunctionController;

$page_data = FunctionController::get_cart();
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@stack('title')</title>
  <meta name="description" content="My Store" />
  <script src="{{asset('client/jquery/jquery-2.1.1.min.js')}}" type="text/javascript"></script>
  <link href="{{asset('client/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" media="screen" />
  <script src="{{asset('client/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
  <link href="{{asset('client/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('client/stylesheet/stylesheet.css')}}" rel="stylesheet">
  <link href="{{asset('client/stylesheet/responsive.css')}}" rel="stylesheet">
  <link href="{{asset('client/stylesheet/menu.css')}}" rel="stylesheet">
  <link href="{{asset('client/toastr/toastr.min.css')}}" rel="stylesheet">
  <link href="{{asset('client/jquery/owl-carousel/owl.carousel.css')}}" type="text/css" rel="stylesheet" media="screen" />
  <script src="{{asset('client/common.js')}}" type="text/javascript"></script>
  <link href="{{asset('client/images/favicon.png')}}" rel="icon" />
  <script src="{{asset('client/jquery/owl-carousel/owl.carousel.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('client/jquery/elevatezoom/jquery.elevatezoom.js')}}" type="text/javascript"></script>
  <script src="{{asset('client/jquery/sweetalert/sweetalert2.all.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('client/toastr/toastr.min.js')}}" type="text/javascript"></script>
</head>

<body class="common-home">
  <a class="house-heaven" href="#">&nbsp;</a>
  <nav id="top">
    <div class="container">
      <div id="top-links">
        <ul class="list-inline">
          <li><a href="tel:0906430244"><i class="fa fa-phone"></i></a>&nbsp; <span>(090)6430244</span></li>
        </ul>
      </div>
      <?php
      session_status() == 1 ? session_start() : '';
      $cart = session()->has('cart') ? count(session()->get('cart')) : 0;
      if (session()->has('user_id') && session()->get('user_id') != null) {
        $log_text = "Logout";
        $log_url = url('logout');
      } else {
        $log_text = "Login";
        $log_url = url('login');
      }
      ?>
      <div id="top-links2">
        <ul class="list-inline">
          <li><a href="{{ $log_url }}"><i class="fa fa-user"></i> <span><?= $log_text ?></span></a></li>
          <li><a href="#" id="wishlist-total" title="Wish List (0)"><i class="fa fa-heart"></i> <span>Wishlist (0)</span></a></li>
          <li><a href="#" class="checkout_mini"><i class="fa fa-shopping-bag"></i> <span>Checkout</span></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <header class="header">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-4">
          <div id="logo"><a href="{{url('/')}}"><img src="{{asset('client/images/logo.png')}}" title="Agriculture" alt="Agriculture" class="img-responsive" /></a></div>
        </div>
        <div class="col-md-9 col-sm-8">
          <div class="header-right">
            <form class="input-group" action="" method="GET" id="search">
              <input type="text" class="form-control input-lg" placeholder="Search" value="" name="search">
              <span class="input-group-btn">
                <button class="btn btn-default btn-lg" type="submit"><i class="fa fa-search"></i></button>
              </span>
            </form>
            <div class="btn-group btn-block" id="cart">
              <button class="btn btn-viewcart dropdown-toggle" data-loading-text="Loading..." data-toggle="dropdown" type="button" aria-expanded="false"><span class="lg">My Cart</span><span id="cart-total"><i class="fa fa-shopping-basket"></i> (<?= $cart ?>) items</span></button>
              <ul class="dropdown-menu pull-right">
                <li>
                  <table class="table table-striped">
                    <tbody>
                      <?php $subtotal = 0;
                      $ecotax = 0;
                      foreach ($page_data as $id => $value) : $ecotax += 2;
                        $subtotal += $value->qty * $value->price; ?>
                        <tr>
                          <td class="text-center"> <a href="{{url($value->slug_url)}}"><img class="img-thumbnail" title="" alt="" style="width:50px;" src="{{asset('upload/product/small/'.$value->id . '.' . $value->image_extension)}}"></a>
                          </td>
                          <td class="text-left" style="width:200px"><a href="{{url($value->slug_url)}}">{{$value->name}}</a>
                          </td>
                          <td class="text-right">x <span id="qty_mini">{{ $value->qty }}</span></td>
                          <td class="text-right">{{ $value->qty * $value->price }}</td>
                          <td class="text-center"><a data-id="{{$id}}" class="remove-cart btn btn-danger btn-xs" title="Remove" onclick=""><i class="fa fa-times"></i></a></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </li>
                <li>
                  <div>
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <td class="text-right"><strong>Sub-Total</strong></td>
                          <td class="text-right">$<span id="subtotal_mini">{{ $subtotal }}</span></td>
                        </tr>
                        <tr>
                          <td class="text-right"><strong>Eco Tax (-2.00)</strong></td>
                          <td class="text-right">$<span id="eco_mini">{{ $ecotax }}</span></td>
                        </tr>
                        <tr>
                          <td class="text-right"><strong>VAT (20%)</strong></td>
                          <td class="text-right">$<span id="vat_mini">{{ $vat = $subtotal * 20 / 100; }}</span></td>
                        </tr>
                        <tr>
                          <td class="text-right"><strong>Total</strong></td>
                          <td class="text-right">$<span id="total_mini">{{ $subtotal + $ecotax + $vat }}</span></td>
                        </tr>
                      </tbody>
                    </table>
                    <p class="text-right"><a href="{{url('cart')}}"><strong><i class="fa fa-shopping-cart"></i> View Cart</strong></a>&nbsp;&nbsp;&nbsp;<a href="#" class="checkout_mini"><strong><i class="fa fa-share"></i> Checkout</strong></a></p>
                  </div>
                </li>

                <script>
                  $('.checkout_mini').on('click', function() {
                    if (Number($('#total_mini').html()) <= 0) {
                      Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Your cart is empty !'
                      });
                    } else {
                      var subtotal = Number($('#subtotal_mini').html());
                      var vat = Number($('#vat_min').html());
                      var ecotax = Number($('#ecotax_mini').html());
                      var total = Number($('#total_mini').html());
                      var discount = 0;
      
                      var parameter = {
                        _token: "{{csrf_token()}}",
                        subtotal,
                        discount,
                        vat,
                        ecotax,
                        total
                      };
                      $.ajax({
                        url: "{{url('checkout')}}",
                        type: 'post',
                        data: parameter,
                        dataType: 'json',
                        success: function(data) {
                          if (data.status) {
                            window.location = "{{url('login')}}";
                          }
                        },
                        error: function(response) {
                          console.log({
                            'error': response
                          });
                        }
                      });
                    }
                  })
                </script>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>