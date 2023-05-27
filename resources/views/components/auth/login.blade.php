@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if (session('confirmation'))
            <div class="confirm-alert grey lighten-4" role="alert">
                {!! session('confirmation') !!}
            </div>
            <br>
        @endif
        @if ($errors->has('confirmation'))
            <div class="confirm-alert grey lighten-3">
                {!! $errors->first('confirmation') !!}
            </div>
            <br>
        @endif
        <div class="col s12 m8 offset-m2 l6 offset-l3 xl12 login-container">
            <div class="card-panel login-card z-depth-3">
                <div class="login-title bg">
                    <h4 class="center grey-text text-lighten-3">{{$title}}</h4>
                </div>
                <div class="login-content">
                    <form action="{{route($login_route)}}" method="post">
                        @csrf()
                        <div class="input-field login-field">
                            <i class="material-icons prefix grey-text text-darken-1">person</i>
                            <input type="email" name="email" id="email" value="{{old('email')}}">
                            <label for="email">Email</label>
                            @if($errors->has('email'))
                                <span class="helper-text red-text">{{$errors->first('email')}}</span>
                            @endif
                        </div>
                        <div class="input-field login-field">
                            <i class="material-icons prefix grey-text text-darken-1">lock</i>
                            <input type="password" name="password" id="password">
                            <label for="password">Password</label>
                            @if($errors->has('password'))
                                <span class="helper-text red-text">{{$errors->first('password')}}</span>
                            @endif
                        </div>
                        <p>
                            <label for="remember">
                                <input type="checkbox" name="remember" class="checkbox-indigo" id="remember">
                                <span class="checkbox-text">Remember Me</span>
                            </label>
                        </p>
                        <div class="row"></div>
                        <div class="divider"></div>
                        <div class="row"></div>
                        <button type="submit" class="btn mb-5 bg left waves-effect waves-light">Login</button>
                        <a href="{{route($reset_route)}}" class="btn bg right waves-effect waves-light">Forgot Password</a>
                        <br><br><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
