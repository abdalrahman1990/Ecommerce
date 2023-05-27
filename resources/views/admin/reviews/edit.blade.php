@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <h4 class="center">Update Review</h4>
                    <br>
                    <form action="{{route('admin.reviews.update',$review->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="input-field login-field col s12 m6">
                                <select name="user" id="user">
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}" {{($user->id == $review->user_id) ? 'selected' : '' }}>{{$user->id}}- {{$user->name}}</option>
                                    @endforeach
                                </select>
                                <label for="user">Customer Name</label>
                                @if($errors->has('user'))
                                    <span class="helper-text red-text">
                                        {{$errors->first('user')}}
                                    </span>
                                @endif
                            </div>
                            <div class="input-field login-field col s12 m6">
                                <select name="product" id="product">
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}" {{($product->id == $review->product_id) ? 'selected' : ''}}>{{$product->title}}</option>
                                    @endforeach
                                </select>
                                <label for="product">Product Name</label>
                                @if($errors->has('product'))
                                    <span class="helper-text red-text">
                                        {{$errors->first('product')}}
                                    </span>
                                @endif
                            </div>
                            <div class="input-field login-field col s12">
                                <textarea name="description" id="description" class="materialize-textarea">{{old('description') ? : $review->text}}</textarea>
                                <label for="description">Description</label>
                            </div>
                            <div class="input-field col s12 m6 login-field">
                                <select name="status" id="status">
                                    <option value="0" {{(!$review->status) ? 'selected' : ''}}>Disabled</option>
                                    <option value="1" {{($review->status) ? 'selected' : ''}}>Enabled</option>
                                </select>
                                <label>Status</label>
                                @if($errors->has('status'))
                                    <span class="helper-text red-text">
                                        {{$errors->first('status')}}
                                    </span>
                                @endif
                            </div>
                            <div class="input-field col s12 m6 login-field">
                                <select name="rating" id="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{$i}}" {{ ($i == $review->rating) ? 'selected' : '' }}>{{$i}}</option>
                                    @endfor
                                </select>
                                <label>Rating</label>
                                @if($errors->has('rating'))
                                    <span class="helper-text red-text">
                                        {{$errors->first('rating')}}
                                    </span>
                                @endif
                            </div>
                            <div class="row"></div>
                            <button type="submit" class="btn bg col s10 offset-s1 m4 offset-m4 waves-effect waves-light">Update Review</button>
                        </div>
                    </form>
                    <br>
                    <a href="{{route('admin.reviews.show',$review->id)}}" class="btn-flat waves-effect blue-text">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection