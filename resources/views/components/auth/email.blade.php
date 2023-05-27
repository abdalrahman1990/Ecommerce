@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m8 offset-m2 l6 offset-l3 xl6 offset-xl3">
            <div class="card-panel login-card z-depth-3">
                <div class="login-title bg">
                    <h4 class="center grey-text text-lighten-3">Enter Your Email</h4>
                </div>
                <div class="login-content">
                    <form method="post" action="{{route($email_route)}}">
                        @csrf
                        <div class="input-field login-field">
                            <i class="material-icons prefix grey-text text-darken-2">mail</i>
                            <input type="text" name="email" id="email">
                            <label for="email">Email</label>
                            @if($errors->has('email'))
                                <span class="helper-text red-text">{{$errors->first('email')}}</span>
                            @endif
                        </div>
                        <div class="row"></div>
                        <button type="submit" class="btn bg2 waves-effect waves-light col s12 m10 offset-m1">Send Link</button>
                        <br><br><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection