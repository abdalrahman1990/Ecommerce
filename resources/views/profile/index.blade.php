@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12 m10 offset-m1 l8 offset-l2 xl6 offset-xl3">
            <div class="card-panel">
                <h4 class="center grey-text text-darken-1">My Profile</h4>
                <br>
                <div class="center-align">
                    <img src="{{Auth::user()->gravatar}}" alt="{{Auth::user()->name}}">
                </div>
                <br>
                <form action="{{route('profile')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12 login-field">
                            <input type="text" name="name" id="name" class="grey-text text-darken-4" value="{{old('name') ? : Auth::user()->name}}">
                            <label for="name" class="active">Name</label>
                            @if($errors->has('name'))
                                <span class="red-text helper-text">
                                    {{$errors->first('name')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 login-field">
                            <input type="email" name="email" id="email" class="grey-text text-darken-4" value="{{old('email') ? : Auth::user()->email}}">
                            <label for="email" class="active">Email</label>
                            @if($errors->has('email'))
                                <span class="red-text helper-text">
                                    {{$errors->first('email')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 login-field">
                            <input type="password" name="password" id="password" class="grey-text text-darken-4">
                            <label for="password" class="active">Password</label>
                        </div>
                        <div class="row"></div>
                        <button type="submit" class="btn waves-effect waves-light bg2 col s12 m6 offset-m3 l6 offset-l3 xl6 offset-xl3">Update Profile</button>
                    </div>
                </form>
                <br>
                <div class="divider"></div>
                <br>
                <div class="center-align">
                    <a href="#delete-account" class="btn red lighten-1 waves-effect waves-light modal-trigger">Delete Account!</a>
                    <p class="red-text text-lighten-1 mt-1">Note! <span class="grey-text text-darken-1">Everything will be removed when you delete your account, like your wishlist, etc.</span></p>
                </div>
                @component('components.confirm',[
                    'id'    => 'delete-account-form',
                    'modal' => 'delete-account',
                    'title' => 'Account'
                ])
                @endcomponent
                <form action="{{route('profile.destroy',Auth::id())}}" class="hide" id="delete-account-form" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                <br>
            </div>
        </div>
    </div>
</div>
@endsection