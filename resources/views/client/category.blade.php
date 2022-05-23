@php 
use App\Http\Controllers\client\FunctionController;
@endphp
@extends('client.layouts.main')
@push('title')
Products
@endpush
@push('js')
@endpush
@section('main-section')
<div class="banner-in">
    <div class="container">
        <h1>Products</h1>
        <ul class="newbreadcrumb">
            <li><a href="{{url('/')}}">Home</a></li>
            <li>Products</li>
        </ul>
    </div>
</div>
<div id="main-container">
    <div class="container">

        <div class="row">
            <aside class="col-sm-3 hidden-xs" id="column-left">
                <h4 class="widget-title">CATEGORIES</h4>
                <ul class="category-list">
                    @foreach (FunctionController::get_category() as $l)
                    <li>
                        <a class="sidenav-link" href="{{ url('cat/'.$l->slug_url) }}">{{$l->name}}</a>
                        <ul class="collapse sublist">
                            @foreach (FunctionController::get_subcategory($l->id) as $sl)
                            <li><a href="{{ url('cat/'.$l->slug_url.'/'.$sl->slug_url) }}">{{ $sl->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                </ul>
            </aside>
            <div class="col-sm-9" id="content">
                <div class="search-bar">
                    <div class="row">
                        <div class="col-md-4 col-sm-12"><a id="compare-total" href="#">Product Compare (0)</a></div>
                    </div>
                </div>
                <br>
                <div class="row">
                    @if (count($products) > 0)
                       @foreach ($products as $l) 
                            <div class="product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="product-thumb transition">
                                    <a href="{{url($l->slug_url)}}">
                                        <div class="image" style="display:flex;align-items:center;height: 150px;">
                                            <img src="{{asset('upload/product/large/'.$l->id . '.' . $l->image_extension)}}" alt="" title="" class="img-responsive" />
                                        </div>
                                    </a>
                                    <div class="caption">
                                        <h4><a href="{{url($l->slug_url)}}">{{ $l->name }}</a></h4>
                                        <div class="rating">
                                            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                        </div>
                                        <p class="price">&#8364;  {{$l->price }}</p>
                                    </div>
                                </div>
                            </div>
                   
                        @endforeach
                    @else 
                    <p class="text-danger text-center">No Product Found!</p>
                    @endif
                </div>
                <div class="row">
                    <div class="col-sm-6 text-left"></div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    /*** add active class and stay opened when selected ***/
    var url = window.location;
    var server = window.location.origin;
    var sidelink = document.querySelectorAll('.sidenav-link');
    var sublist = document.querySelectorAll('.sublist');
    sidelink.forEach((element, i) => {
        if (element.href == url || url.href.indexOf(element.href) == 0) {
            sublist[i].classList.remove('collapse');
        }
    })
</script>
@endsection