@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m8 offset-m2 l6 offset-l3 xl12 login-container">
            <div class="card-panel login-card z-depth-3">
                <div class="login-title bg">
                        <h4 class="center grey-text text-lighten-3">Register</h4>
                </div>
                <div class="login-content">
                    <form action="{{route('register')}}" method="post">
                        @csrf()
                        <div class="input-field login-field">
                            <i class="material-icons prefix grey-text text-darken-2">person</i>
                            <input type="text" name="name" id="name" value="{{old('name')}}">
                            <label for="name">Name</label>
                            @if($errors->has('name'))
                                <span class="helper-text red-text">{{$errors->first('name')}}</span>
                            @endif
                        </div>
                        <div class="input-field login-field">
                        <i class="material-icons prefix grey-text text-darken-2">mail</i>
                            <input type="email" name="email" id="email" value="{{old('email')}}">
                            <label for="email">Email</label>
                            @if($errors->has('email'))
                                <span class="helper-text red-text">{{$errors->first('email')}}</span>
                            @endif
                        </div>
                        <div class="input-field login-field">
                        <i class="material-icons prefix grey-text text-darken-2">lock</i>
                            <input type="password" name="password" id="password" value="{{old('password')}}">
                            <label for="password">Password</label>
                            @if($errors->has('password'))
                                <span class="helper-text red-text">{{$errors->first('password')}}</span>
                            @endif
                        </div>
                        <div class="input-field login-field">
                            <i class="material-icons prefix grey-text text-darken-2">lock</i>
                            <input type="password" name="password_confirmation" id="password-confirm" value="{{old('password-confirm')}}">
                            <label for="password-confirm">Confirm Password</label>
                            @if($errors->has('password-confirm'))
                                <span class="helper-text red-text">{{$errors->first('password-confirm')}}</span>
                            @endif
                        </div>
                        <div class="row"></div>
                        <div class="divider"></div>
                        <div class="row"></div>
                        <button type="submit" class="btn bg col s12 m8 offset-m2 l8 offset-l2 xl10 offset-xl1 waves-effect waves-light">register</button>
                        <br><br>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
