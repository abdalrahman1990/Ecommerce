@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card-panel">
                <h4 class="center grey-text text-darken-1">Update Category</h4>
                <div>
                    <form action="{{route('admin.categories.update',$category->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="input-field col s12 m10 offset-m1 login-field">
                                <input type="text" name="title" id="title" value="{{old('title') ? : $category->title }}">
                                <label for="title">Name</label>
                                @if($errors->has('title'))
                                    <span class="helper-text red-text">
                                        {{$errors->first('title')}}
                                    </span>
                                @endif
                            </div>
                            <div class="row"></div>
                            <button type="submit" class="btn bg waves-effect waves-light col s12 m4 offset-m4">Update</button>
                        </div>
                    </form>
                    <br>
                    <a href="{{route('admin.categories.index')}}" class="btn-flat waves-effect blue-text">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection