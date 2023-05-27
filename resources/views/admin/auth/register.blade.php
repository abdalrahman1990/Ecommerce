@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="card-panel col s12 m8 offset-m2 l6 offset-l3 xl6 offset-xl3">
            <h4 class="center grey-text text-darken-1">Admin Register</h4>
            <form action="{{route('admin.register')}}" method="post">
                @csrf()
                <div class="input-field">
                    <input type="text" name="name" id="name" value="{{old('name')}}">
                    <label for="name">Name</label>
                    @if($errors->has('name'))
                        <span class="helper-text red-text">{{$errors->first('name')}}</span>
                    @endif
                </div>
                <div class="input-field">
                    <input type="email" name="email" id="email" value="{{old('email')}}">
                    <label for="email">Email</label>
                    @if($errors->has('email'))
                        <span class="helper-text red-text">{{$errors->first('email')}}</span>
                    @endif
                </div>
                <div class="input-field">
                    <input type="password" name="password" id="password" value="{{old('password')}}">
                    <label for="password">Password</label>
                    @if($errors->has('password'))
                        <span class="helper-text red-text">{{$errors->first('password')}}</span>
                    @endif
                </div>
                <div class="input-field">
                    <input type="password" name="password_confirmation" id="password-confirm" value="{{old('password-confirm')}}">
                    <label for="password-confirm">Confirm Password</label>
                    @if($errors->has('password-confirm'))
                        <span class="helper-text red-text">{{$errors->first('password-confirm')}}</span>
                    @endif
                </div>
                <button type="submit" class="btn col s12 m8 offset-m2 l6 offset-l3 xl6 offset-xl3">register</button>
                <br><br><br>
            </form>
        </div>
    </div>
</div>
@endsection
