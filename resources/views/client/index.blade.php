@push('title')
Welcome to Agri Express
@endpush
@extends('client.layouts.main')
@section('main-section')
<div class="home-banner"><a href="#"><img src="{{asset('client/images/banner1.jpg')}}" alt=""></a></div>

<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">

                <div class="product-carousel">
                    <div class="sec-title">
                        <h3>Special products</h3>
                    </div>
                    <div class="row">
                        <div id="carouse21" class="owl-carousel">
                            @foreach ($special as $l)
                                <div class="item">
                                    <div class="product-layout">
                                        <div class="product-thumb transition">
                                            <a href="{{url('/').'/'.$l->slug_url}}">
                                                <div class="image" style="display:flex;align-items:center;height: 150px;">
                                                    <img src="{{asset('upload/product/small'.'/'.$l->id.'.'.$l->image_extension)}}" alt="" title="" class="img-responsive" />
                                                </div>
                                            </a>
                                            <div class="caption">
                                                <h4><a href="{{url('/').'/'.$l->slug_url}}">{{$l->name}}</a></h4>
                                                <div class="rating">
                                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                </div>
                                                <p class="price">&#8364; {{$l->price}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="category-carousel">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="product-carousel type2">
                        <div class="sec-title">
                            <h3>BROWSE OUR CATEGORIES</h3>
                        </div>
                        <div id="carouse23" class="owl-carousel">
                            @foreach ($category as $l)
                                <div class="item">
                                    <div class="product-layout">
                                        <div class="cat-thumb">
                                            <div class="image"><a href="{{url('/cat/').'/'.$l->slug_url}}"><img src="{{asset('upload/category').'/'. $l->id . '.' . $l->extension }}" alt="" title="" class="img-responsive" /></a></div>
                                            <h4><a href="">{{ $l->name }}</a></h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#carouse23').owlCarousel({
            items: 5,
            autoPlay: 3000,
            navigation: true,
            navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            pagination: false,
            autoPlay: false,
            itemsDesktopSmall: [1199, 4],
            itemsTablet: [991, 3],
            itemsTabletSmall: [639, 2]
        });
    </script>


    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="product-carousel">
                    <div class="sec-title">
                        <h3>Featured products</h3>
                    </div>
                    <div class="row">
                        <div id="carouse22" class="owl-carousel">
                            @foreach ($featured as $l)
                                <div class="item">
                                    <div class="product-layout">
                                        <div class="product-thumb transition">
                                            <a href="{{url('/').'/'.$l->slug_url}}">
                                            <div class="image" style="display:flex;align-items:center;height: 150px;">
                                                <img src="{{asset('upload/product/small'.'/'.$l->id.'.'.$l->image_extension)}}" alt="" title="" class="img-responsive" />

                                            </div>
                                            </a>
                                            <div class="caption">
                                                <h4><a href="{{url('/').'/'.$l->slug_url}}">{{$l->name}}</a></h4>
                                                <div class="rating">
                                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                </div>
                                                <p class="price">&#8364; {{$l->price}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <script type="text/javascript">
                    $('#carouse21, #carouse22').owlCarousel({
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
    </div>

</div>


<div class="free-shipping">
    <div class="container">
        <img src="{{asset('client/images/delivery-icon.png')}}" alt="">
        <span>Free shipping on orders over €60</span>
        <a href="#" class="btn btn-default btn-lg">Shop Now</a>
    </div>
</div>

<div class="email-signup">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 text-center">
                <div class="sec-title">
                    <h3>Newsletter</h3>
                </div>
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.</p>
                <div class="form-signup">
                    <input type="text" placeholder="Type Your Email" class="form-control">
                    <input type="submit" class="btn btn-send" value="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection