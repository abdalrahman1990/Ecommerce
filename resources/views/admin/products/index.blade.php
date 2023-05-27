@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="card-panel">
            <h4 class="center">
                @if($title)
                    {{$title}}
                @else
                    Products List
                @endif
            </h4>
            <br>
            <form action="{{route('admin.products.index')}}">
                <div class="row">
                    <div class="input-field col s12 m6 login-field">
                        <input type="text" name="search" id="re-search" value="{{request()->search}}">
                        <label for="re-search">Search</label>
                    </div>
                    <div class="input-field col s12 m4 login-field">
                        <select name="option" id="option">
                            <option value="title" {{(request()->option == "title") ? 'selected' : ''}}>Name</option>
                            <option value="quantity" {{(request()->option == "quantity") ? 'selected' : ''}}>quantity</option>
                            <option value="price" {{(request()->option == "price") ? 'selected' : ''}}>Price</option>
                        </select>
                        <label for="option">Option</label>
                    </div>
                    <br>
                    <button type="submit" class="col bg s8 offset-s2 m2 btn waves-effect">Search</button>
                </div>
            </form>
            <br>
            <table class="responsive-table centered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Rating</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>
                                <img width="50px" height="50px" src="{{asset('storage/products/'.$product->image)}}" alt="">
                            </td>
                            <td>{{$product->title}}</td>
                            <td>{{($product->reviews->avg('rating')) ? : 'None'}}</td>
                            <td>{{$product->hasCategory->title}}</td>
                            <td class="center">{{$product->quantity}}</td>
                            <td>{{$product->created_at->diffForHumans()}}</td>
                            @if($product->updated_at)
                                <td>{{$product->updated_at->diffForHumans()}}</td>
                            @else
                                <td>Not updated</td>
                            @endif
                            <td>
                                <div class="center">
                                    <a href="{{route('admin.products.show',$product->id)}}" class="btn-floating btn-small waves-effect waves-light tooltipped" data-position="left" data-tooltip="Show Product Details">
                                        <i class="material-icons">visibility</i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="center">No Products to Display!</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <br><br>
            <div class="center-align">
                @if($title)
                    <a href="{{route('admin.products.index')}}" class="btn waves-effect">View All</a>
                    <br>
                @endif
                {{$products->appends(request()->query())->links('vendor.pagination.default',[
                    'items' => $products
                ])}}
            </div>
        </div>
    </div>
    <div class="fixed-action-btn">
        <a href="{{route('admin.products.create')}}" class="btn-floating btn-large waves-effect waves-light red">
            <i class="large material-icons">add</i>
        </a>
    </div>
</div>
@endsection