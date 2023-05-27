@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="card-panel grey-text text-darken-1">
            <ul class="collection with-header">
                <li class="collection-header">
                    <div class="section">
                        <h4 class="center">Product Details</h4>
                    </div>
                </li>
                <li class="collection-item">
                    <div class="section">
                        <h5 class="center">{{$product->title}}</h5>
                    </div>
                    <div class="center-align">
                        <img src="{{asset('storage/products/'.$product->image)}}" alt="{{$product->title}}" class="show-prod-img materialboxed">
                    </div>
                </li>
                <li class="collection-item">
                    <div class="section">
                        <h4 class="center">Product Description</h4>
                        <p>{!! $product->description !!}</p>
                    </div>
                </li>
                <li class="collection-item">
                    <div class="section">
                        <h6 class="grey-text text-darken-3">Category: </h6>
                        <span>{{$product->hasCategory->title}}</span>
                    </div>
                    <div class="divider"></div>
                    <div class="section">
                        <h6 class="grey-text text-darken-3">Price: </h6>
                        <span class="val">{{'$'.number_format($product->price,2)}}</span>
                    </div>
                    <div class="divider"></div>
                    <div class="section">
                        <h6 class="grey-text text-darken-3">Quantity: </h6>
                        <span class="val">{{$product->quantity}}</span>
                    </div>
                    <div class="divider"></div>
                    <div class="section">
                        <h6 class="grey-text text-darken-3">Rating: </h6>
                        <span>
                        @component('components.review-count',[
                            'product' => $product
                        ])
                        @endcomponent
                        </span>
                    </div>
                </li>
                <li class="collection-item">
                    <div class="section">
                        <div class="row mb-0">
                        <br>
                            <div class="col s12 m6 l6 xl6 row">
                                <a href="{{route('admin.products.edit',$product->id)}}" class="btn pink lighten-1 waves-effect waves-light col s10 offset-s1 m8 offset-m2">
                                    Update
                                </a>
                            </div>
                            @component('components.confirm',[
                                'id'    => 'delete-form',
                                'modal' => 'deleteModal',
                                'title' => 'Product'
                            ])
                            @endcomponent
                            <div class="col s12 m6 l6 xl6 row mb-0">
                                <a href="#deleteModal" class="btn red waves-effect waves-light col s10 offset-s1 m8 offset-m2 modal-trigger">
                                    Delete
                                </a>
                            </div>
                            <form action="{{route('admin.products.destroy',$product->id)}}" method="post" class="hide" id="delete-form">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
            <br>
            <a href="{{route('admin.products.index')}}" class="btn-flat waves-effect blue-text">Go Back</a>
        </div>
    </div>
</div>
@endsection