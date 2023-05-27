@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <h4 class="center grey-text text-darken-1">My Profile</h4>
                <br>
                <div class="center-align">
                    <img src="{{Auth::guard('admin')->user()->gravatar}}" alt="{{Auth::guard('admin')->user()->name}}">
                </div>
                <br>
                <form action="{{route('admin.profile')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="name" id="name" class="grey-text text-darken-4" value="{{old('name') ? : Auth::guard('admin')->user()->name}}">
                            <label for="name" class="active">Name</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="email" name="email" id="email" class="grey-text text-darken-4" value="{{old('email') ? : Auth::guard('admin')->user()->email}}">
                            <label for="email" class="active">Email</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="password" name="password" id="password" class="grey-text text-darken-4">
                            <label for="password" class="active">Password</label>
                        </div>
                        <div class="row"></div>
                        <button type="submit" class="btn waves-effect waves-light bg2 col s12 m6 offset-m3 l6 offset-l3 xl6 offset-xl3">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection