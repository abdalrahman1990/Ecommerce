@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m8 offset-m2 l6 offset-l3 xl12 login-container">
            <div class="card-panel login-card z-depth-3">
                <div class="login-title bg">
                    <h4 class="center grey-text text-lighten-3">Reset Password</h4>
                </div>
                <div class="login-content">
                    <form method="POST" action="{{ route($password_request_route) }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
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
                        <button type="submit" class="btn col s12 m10 offset-m1 l10 offset-l1 xl10 offset-xl1 waves-effect waves-light bg2">Reset Password</button>
                        <br><br><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection