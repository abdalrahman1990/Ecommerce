@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card-panel">
                <br>
                <h4 class="center grey-text text-darken-1">New Product</h4>
                <div>
                    <form action="{{route('admin.products.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="input-field col s12 m10 offset-m1 l6 xl6 login-field">
                                <input type="text" name="title" id="title" value="{{old('title')}}">
                                <label for="title">Name</label>
                                @if($errors->has('title'))
                                    <span class="helper-text red-text">
                                        {{$errors->first('title')}}
                                    </span>
                                @endif
                            </div>
                            <div class="input-field col s12 m10 offset-m1 l6 xl6 login-field">
                                <select name="category">
                                <option value="" disabled selected>Choose a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{ (old('category') == ($category->id)) ? 'selected' : '' }}>{{$category->title}}</option>
                                @endforeach
                                </select>
                                <label>Product Category:</label>
                                @if($errors->has('category'))
                                    <span class="helper-text red-text">
                                        {{$errors->first('category')}}
                                    </span>
                                @endif
                            </div>
                            <div class="input-field col s12 m10 offset-m1 l12 xl12 login-field">
                                <textarea name="description" id="description" class="materialize-textarea">{{old('description')}}</textarea>
                                @if($errors->has('description'))
                                    <span class="helper-text red-text">
                                        {{$errors->first('description')}}
                                    </span>
                                @endif
                            </div>
                            <div class="input-field col s12 m5 offset-m1 l6 xl6 login-field">
                                <input type="number" name="quantity" id="quantity"  value="{{old('quantity')}}">
                                <label for="quantity">Quantity</label>
                                @if($errors->has('quantity'))
                                    <span class="helper-text red-text">
                                        {{$errors->first('quantity')}}
                                    </span>
                                @endif
                            </div>
                            <div class="input-field col s12 m5 l6 xl6 login-field">
                                <input type="number" name="price" id="price" value="{{old('price')}}" min=0 step="0.01">
                                <label for="price">Price</label>
                                @if($errors->has('price'))
                                    <span class="helper-text red-text">
                                        {{$errors->first('price')}}
                                    </span>
                                @endif
                            </div>
                            <div class="file-field input-field col s12 m10 offset-m1 l12 xl12 login-field">
                                <div class="btn waves-effect waves-light bg2">
                                    <span>Picture</span>
                                    <input type="file" name="image">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" value="{{old('image')}}">
                                    @if($errors->has('image'))
                                        <span class="helper-text red-text">
                                            {{$errors->first('image')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row"></div>
                            <button type="submit" class="btn waves-effect waves-light bg col s12 m8 offset-m2 l4 offset-l4 xl4 offset-xl4">Create Product</button>
                        </div>
                    </form>
                    <br>
                    <a href="{{route('admin.products.index')}}" class="btn-flat waves-effect blue-text">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.replace( 'description' );
    </script>
@endsection