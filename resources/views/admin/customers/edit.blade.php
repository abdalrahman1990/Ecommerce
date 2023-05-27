@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <h4 class="center grey-text text-darken-1">Update Customer</h4>
                <br>
                <div class="center-align">
                    <img src="{{$customer->gravatar}}" alt="{{$customer->name}}">
                </div>
                <br>
                <form action="{{route('admin.customers.update',$customer->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="input-field col s12 m10 offset-m1 login-field">
                            <input type="text" name="name" id="name" class="grey-text text-darken-4" value="{{old('name') ? : $customer->name}}">
                            <label for="name" class="active">Name</label>
                            @if($errors->has('name'))
                                <span class="red-text helper-text">
                                    {{$errors->first('name')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 m10 offset-m1 login-field">
                            <input type="email" name="email" id="email" class="grey-text text-darken-4" value="{{old('email') ? : $customer->email}}">
                            <label for="email" class="active">Email</label>
                            @if($errors->has('email'))
                                <span class="red-text helper-text">
                                    {{$errors->first('email')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 m10 offset-m1 login-field">
                            <input type="password" name="password" id="password" class="grey-text text-darken-4">
                            <label for="password">Password</label>
                            @if($errors->has('password'))
                                <span class="red-text helper-text">
                                    {{$errors->first('password')}}
                                </span>
                            @endif
                        </div>
                        <div class="row"></div>
                        <button type="submit" class="btn waves-effect waves-light bg2 col s12 m4 offset-m4">Update Customer</button>
                    </div>
                </form>
                <br>
                <a href="{{route('admin.customers.index')}}" class="btn-flat waves-effect blue-text">Go Back</a>
            </div>
        </div>
    </div>
</div>
@endsection