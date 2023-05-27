@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <h4 class="center grey-text text-darken-1">My Wishlist</h4>
                    <br>
                    <table class="responsive-table centered grey-text text-darken-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Available Stock</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wishlists as $wishlist)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>
                                        <img width="60px" height="50px" src="{{asset('storage/products/'.$wishlist->product->image)}}" alt="">
                                    </td>
                                    <td>
                                        <a href="{{route('product-details',$wishlist->product->slug)}}">{{$wishlist->product->title}}</a>
                                    </td>
                                    <td>{{$wishlist->product->hasCategory->title}}</td>
                                    <td class="val">{{$wishlist->product->quantity}}</td>
                                    <td class="val">${{number_format($wishlist->product->price,2)}} /-</td>
                                    <td>
                                        <a href="#" class="btn-floating waves-effect waves-light btn-small add-cart" data-id="{{$wishlist->product->id}}">
                                            <i class="material-icons">add_shopping_cart</i>
                                        </a>
                                        <a href="#delete-modal-{{$wishlist->id}}" class="btn-floating waves-effect waves-light btn-small red modal-trigger">
                                            <i class="material-icons">delete</i>
                                        </a>
                                        @component('components.confirm',[
                                            'id'    => 'delete-wishlist-'.$wishlist->id,
                                            'modal' => 'delete-modal-'.$wishlist->id,
                                            'title' => 'Wishlist'
                                        ])
                                        @endcomponent
                                        <form action="{{route('wishlist.destroy',$wishlist->id)}}" method="post" class="hide" id="delete-wishlist-{{$wishlist->id}}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="center">
                                    <h5 class="center">Add <a href="{{route('products')}}">Products</a> to Wishlist!</h5>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <br><br>
                    <div class="center-align">
                        {{$wishlists->links('vendor.pagination.default',['items' => $wishlists])}}
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
@endsection