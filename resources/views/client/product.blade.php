@push('title')
{{$product->name}}
@endpush
@push('js')
<script>
  $(function() {
    $('#add_cart_form').on('submit', function(e) {
      e.preventDefault();
      const id = $('#id').val();
      const qty = $('#input-quantity').val();
      const parameter = {
        _token: '{{csrf_token()}}',
        id,
        qty
      };
      $.ajax({
        url: '{{url("add_to_cart")}}',
        method: 'post',
        dataType: 'json',
        data: parameter,
        success: function(data) {
          if(data.status){
            $('#input-quantity').val(1);
            toastr.success('Product added to Cart');
            location.reload();
          }
        },
        error: function(response) {
          console.log({
            error: response
          });
        }
      })
    })
  })
</script>
@endpush
@extends('client.layouts.main')
@section('main-section')
<style>
  #gal1 img {
    border: 2px solid white;
  }

  /*Change the colour*/
  .active img {
    border: 2px solid #333 !important;
  }
</style>
<div class="banner-in">
  <div class="container">
    <h1>{{$product->name}}</h1>
    <ul class="newbreadcrumb">
      <li><a href="index.php">Home</a></li>
      <li><a href="{{url('cat/'.$product->category_slug)}}">{{ $product->category_name; }}</a></li>
      <li><a href="{{url('cat/'.$product->category_slug.'/'.$product->subcategory_slug)}}">{{ $product->subcategory_name; }}</a></li>
      <li>{{$product->name}}</li>
    </ul>
  </div>
</div>
<div id="main-container">
  <div class="container">

    <div class="row">
      <div class="col-sm-12" id="content">

        <div class="row">
          <div class="col-sm-4">
            <img id="zoom_01" src="{{asset('upload/product/medium/'.$product->id . '.' . $product->image_extension)}}" data-zoom-image="{{asset('upload/product/large/'.$product->id . '.' . $product->image_extension)}}" />
            <br><br>
            <div id="gal1">
              <a href="#" data-image="{{asset('upload/product/medium/'.$product->id . '.' . $product->image_extension)}}" data-zoom-image="{{asset('upload/product/large/'.$product->id . '.' . $product->image_extension)}}" class="active">
                <img id="zoom_01" src="{{asset('upload/product/small/'.$product->id . '.' . $product->image_extension)}}">
              </a>
              @isset($product->gallery)
              @foreach (explode(',', $product->gallery) as $l)
              <a href="#" data-image="{{asset('upload/productgallery/medium/'.$l)}}" data-zoom-image="{{asset('upload/productgallery/large/'.$l)}}">
                <img id="zoom_01" src="{{asset('upload/productgallery/small/'.$l)}}" />
              </a>
              @endforeach
              @endisset
            </div>

          </div>
          <div class="col-sm-1"></div>
          <div class=" col-sm-7">
            <div class="pdoduct-details">
              <div class="pdoduct-header">
                <h1>{{$product->name}}</h1>

                <h2>€<?= $product->price ?></h2>
                <button title="" class="btn btn-wishlist" data-toggle="tooltip" type="button" data-original-title="Add to Wish List"><i class="fa fa-heart"></i></button>
              </div>
              <hr>
              <ul class="list-unstyled">
                <li>Availability: <?= $product->availability == 1 ? "In Stock" : "Out of Stock" ?></li>
              </ul>
              <hr>
              <h4>Description</h4>
              <p><?= $product->description ?></p>

              <div id="product">
                <form action="" method="POST" id="add_cart_form" class="form-group clearfix">
                  <label for="input-quantity" class="control-label">Qty</label>
                  <input type="number" min="1" ; class="form-control" id="input-quantity" size="2" value="1" name="quantity" vk_106cf="subscribed" required>
                  <input type="hidden" value="<?= $product->id ?>" name="product_id" id="id">
                  <button class="btn btn-default btn-lg" id="button-cart" type="submit" name="add_to_cart" value="add_to_cart" <?= $product->availability == 0 ? "disabled" : ""; ?>>Add to Cart</button>
                </form>
              </div>
              <hr>
              <div class="rating">
                <div class="row">
                  <div class="col-lg-6">
                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                    <a onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;" href="">0 reviews</a> / <a onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;" href="">Write a review</a>
                  </div>
                  <div class="col-lg-6">
                    <div class="pull-right">
                      <img src="{{asset('client/images/addthis.jpg')}}" alt="">
                    </div>
                  </div>
                </div>
                <hr>
              </div>
            </div>
          </div>
        </div>

        <br>

        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#tab-description">Description</a></li>
          <li><a data-toggle="tab" href="#tab-review">Reviews (0)</a></li>
        </ul>
        <div class="tab-content">
          <div id="tab-description" class="tab-pane active">
            <p class="intro"><?= $product->description ?></p>
          </div>
          <div id="tab-review" class="tab-pane">
            <form id="form-review" class="form-horizontal">
              <div id="review">
                <p>There are no reviews for this product.</p>
              </div>
              <h2>Write a review</h2>
              <div class="form-group required">
                <div class="col-sm-12">
                  <label for="input-name" class="control-label">Your Name</label>
                  <input type="text" class="form-control" id="input-name" value="" name="name" vk_106cf="subscribed">
                </div>
              </div>
              <div class="form-group required">
                <div class="col-sm-12">
                  <label for="input-review" class="control-label">Your Review</label>
                  <textarea class="form-control" id="input-review" rows="5" name="text"></textarea>
                  <div class="help-block"><span class="text-danger">Note:</span> HTML is not translated!</div>
                </div>
              </div>
              <div class="form-group required">
                <div class="col-sm-12">
                  <label class="control-label">Rating</label>
                  &nbsp;&nbsp;&nbsp; Bad&nbsp;
                  <input type="radio" value="1" name="rating">
                  &nbsp;
                  <input type="radio" value="2" name="rating">
                  &nbsp;
                  <input type="radio" value="3" name="rating">
                  &nbsp;
                  <input type="radio" value="4" name="rating">
                  &nbsp;
                  <input type="radio" value="5" name="rating">
                  &nbsp;Good
                </div>
              </div>
              <div class="buttons clearfix">
                <div class="pull-right">
                  <button class="btn btn-primary" data-loading-text="Loading..." id="button-review" type="button">Continue</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="product-carousel relater-product">
          <h3>Related Products</h3>
          <div class="row">
            <div id="carouse21" class="owl-carousel">
              @foreach ($related as $l)
              <div class="item">
                <div class="product-layout">
                  <div class="product-thumb transition">
                    <a href="{{url($l->slug_url)}}">
                      <div class="image" style="display:flex;align-items:center;height: 150px;">
                        <img src="{{asset('upload/product/medium/'.$l->id . '.' . $l->image_extension)}}" alt="" title="" class="img-responsive" />
                      </div>
                    </a>
                    <div class="caption">
                      <h4><a href="#">{{$l->name }}</a></h4>
                      <div class="rating">
                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                      </div>
                      <p class="price">&#8364; {{ $l->price }}</p>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        <script type="text/javascript">
          $('#carouse21').owlCarousel({
            items: 4,
            autoPlay: 3000,
            navigation: true,
            navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            pagination: false,
            autoPlay: false,
            itemsDesktopSmall: [1199, 3],
            itemsTablet: [991, 3],
            itemsTabletSmall: [767, 2],
          });
        </script>

      </div>
    </div>

    <!-- <script type="text/javascript">
      $(document).ready(function() {
        $('.thumbnails').magnificPopup({
          type: 'image',
          delegate: 'a',
          gallery: {
            enabled: true
          }
        });
      });
    </script> -->
    <script>
      //initiate the plugin and pass the id of the div containing gallery images
      $("#zoom_01").elevateZoom({
        gallery: 'gal1',
        cursor: 'pointer',
        galleryActiveClass: 'active',
        imageCrossfade: true,
        loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'
      });

      //pass the images to Fancybox
      $("#zoom_01").bind("click", function(e) {
        var ez = $('#zoom_01').data('elevateZoom');
        $.fancybox(ez.getGalleryList());
        return false;
      });
    </script>
  </div>
</div>
@endsection