@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12 m12 xl8">
            <div class="card-panel cart-panel">
                @if(!Cart::count())
                    <h5 class="grey-text text-darken-2 center">Your cart is empty! <a href="{{route('products')}}">&nbsp;Start Shopping</a></h5>
                @else
                    <h4 class="center">My Cart</h4>
                    <br>
                    <table class="responsive-table centered cart-items">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Cart::content() as $product)
                                <tr data-id="{{$product->model->slug}}">
                                    <td>{{$loop->index + 1}}</td>
                                    <td>
                                        <div>
                                            <img src="{{('storage/products/'.$product->model->image)}}" width="50px"  height="50px"  alt="{{$product->model->slug}}">
                                        </div>
                                    </td>
                                    <td>
                                        @if(!$product->model->hasStock($product->qty))
                                            <a class="tooltipped red-text" data-position="bottom" data-tooltip="This item has insufficient stock!" href="{{route('product-details',$product->model->slug)}}">{{$product->name}}</a>
                                        @else
                                            <a href="{{route('product-details',$product->model->slug)}}">{{$product->name}}</a>
                                        @endif
                                    </td>
                                    <td class="val">${{$product->price}}</td>
                                    <td>
                                        <div class="row mb-0">
                                            <input type="hidden" id="rowId-{{$product->model->slug}}" value="{{$product->rowId}}">
                                            <div class="input-field login-field col offset-s2 s6 offset-l4 l4">
                                                <input min="0" type="number" id="qty-{{$product->model->slug}}" value="{{$product->qty}}">
                                            </div>
                                            <br>
                                            <div class="col">
                                            <button type="submit" data-id="{{$product->model->slug}}" class="btn-floating btn-small waves-effect bg2 tooltipped update-cart" data-position="bottom" data-tooltip="Update quantity">
                                                <i class="material-icons">sync</i>
                                            </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                @endif
            </div>
            <br><br>
        </div>
        <div class="col s12 m12 xl4">
            <div class="card-panel">
                @component('components.cart-summary')
                @endcomponent
                <br>
                <a class="btn waves-effect waves-light green lighten-1 checkout-btn {{!Cart::count() ? 'disabled': ''}}" href="{{route('checkout')}}">check out</a>
            </div>
        </div>
    </div>
</div>
@endsection