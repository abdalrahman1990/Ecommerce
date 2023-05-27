@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <h3 class="grey-text text-darken-2 center">{{$product->title}}</h3>
        <br><br>
        <div class="col s12 m12 l6 xl6">
            <ul class="collection">
                <li class="collection-item">
                    <div class="center-align">
                        <img src="{{asset('storage/products/'.$product->image)}}" class="materialboxed show-prod-img" alt="{{$product->title}}">
                    </div>
                </li>
                <li class="collection-item">
                    <div class="row">
                        <div class="col s6 m4 l4 xl4">
                            <img src="{{asset('storage/products/'.$product->image)}}" alt="{{$product->title}}" class="materialboxed img-details">
                        </div>
                        <div class="col s6 m4 l4 xl4">
                            <img src="{{asset('storage/products/'.$product->image)}}" alt="{{$product->title}}" class="materialboxed img-details">
                        </div>
                        <div class="hide-on-small-only col s12 m4 l4 xl4">
                            <img src="{{asset('storage/products/'.$product->image)}}" alt="{{$product->title}}" class="materialboxed img-details">
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col s12 m12 l6 xl6 grey-text text-darken-2">
            <div class="card-panel">
                <div class="">
                    <h5>{{$product->title}}</h5>
                </div>
                <div class="collection-item">
                    <br><br>
                    <p>
                        <strong>Price:</strong> 
                        <span class="val grey-text text-darken-1">${{$product->price}}</span>
                    </p>
                    <p>
                        Available Quantity: 
                        <span class="val grey-text text-darken-1">{{$product->quantity}}</span>
                    </p>
                    <p>
                        <strong class="left">Rating: </strong>
                        <span>
                        @component('components.review-count',[
                            'product' => $product
                        ])
                        @endcomponent
                        </span>
                    </p>
                    @if($product->hasLowStock())
                        <span class="chip yellow">Low Stock</span>
                        <br>
                    @endif
                    <br>
                    @if(!$product->outOfStock())
                        <div class="section">
                            <form method="post">
                                @csrf
                                <div class="row"  style="margin-bottom:0 !important">
                                    <div class="col">
                                    </div>
                                    <div class="input-field col">
                                        <select name="qty" id="qty">
                                            @for($i = 0; $i < $product->quantity; $i++)
                                                <option value="{{$i+1}}">{{$i+1}}</option>
                                            @endfor
                                        </select>
                                        <label>Quantity</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="divider"></div>
                        <br>
                        <div class="section center">
                            <a href="#" data-id="{{$product->id}}" class="add-cart btn bg2 waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Add to Cart"><i class="material-icons">add_shopping_cart</i></a>
                            <a href="#" data-id="{{$product->id}}" class="add-wishlist tooltipped btn bg2 waves-effect waves-light" data-position="bottom" data-tooltip="Add to wishlist">
                                <i class="material-icons">favorite_border</i>
                            </a>
                        </div>
                    @else
                        <span class="chip white-text red lighten-1">
                            Out Of Stock
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s6">
                        <a href="#description" class="purple-text">Description</a>
                    </li>
                    <li class="tab col s6">
                        <a class="purple-text" href="#reviews">
                            Reviews 
                            <span class="val">({{$reviews->count()}})</span>
                        </a>
                    </li>
                </ul>
                <div id="description" class="col s12">
                    <div class="row">
                        <div class="col xl12">
                            <br>
                            <h4>{{$product->title}}'s Details</h4>
                            <p>{!! $product->description !!}</p>
                            <br>
                        </div>
                    </div>
                </div>
                @component('home.components.review',[
                    'reviews' => $reviews,
                    'product' => $product
                ])
                @endcomponent
            </div>
        </div>
    </div>
</div>
@endsection