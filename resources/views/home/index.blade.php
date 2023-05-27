@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
@endsection
@section('content')
<div class="container-fluid">
    <div class="carousel carousel-slider center">
        <div class="carousel-fixed-item center">
            <a class="btn waves-effect waves-light bg2" href="{{route('products')}}">
                Shop Now
                <i class="material-icons right">chevron_right</i>
            </a>
        </div>
        <div class="carousel-item white-text" href="#one!">
            <img src="{{asset('images/slider/img1.jpg')}}" alt="" class="slider-img">
        </div>
        <div class="carousel-item white-text" href="#two!">
            <img src="{{asset('images/slider/img2.jpeg')}}" alt="" class="slider-img">
        </div>
        <div class="carousel-item white-text" href="#three!">
            <img src="{{asset('images/slider/img3.jpeg')}}" alt="" class="slider-img">
        </div>
        <div class="carousel-item white-text" href="#four!">
            <img src="{{asset('images/slider/img4.jpeg')}}" alt="" class="slider-img">
        </div>
    </div>
    <br><br>
    <div class="row">
        <h4 class="center grey-text text-darken-2">Featured Products</h4>
        <br><br>
        <!-- Set up your HTML -->
        <div class="owl-carousel row">
            @foreach($products as $product)
                <div class="product-card no-padding featured-product">
                    @component('components.product',['product' => $product])
                    @endcomponent
                </div>
            @endforeach
        </div>
    </div>
    <br><br>
</div>
@endsection

@section('script')
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $(".owl-carousel").owlCarousel({
                loop:true,
                margin:15,
                nav:true,
                navText:['<i class="material-icons">chevron_left</i>','<i class="material-icons">chevron_right</i>'],
                autoplay:true,
                dotsEach:true,
                autoplayTimeout:5000,
                autoplayHoverPause:false,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:2
                    },
                    992:{
                        items:4
                    },
                    1250:{
                        items:5
                    }
                }
            }
            );
        });
    </script>
@endsection