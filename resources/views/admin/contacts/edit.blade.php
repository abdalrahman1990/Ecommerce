@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <h4 class="center">Update contact message</h4>
                <form action="{{route('admin.contacts.update',$contact->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="input-field col s12 login-field">
                            <input type="text" name="first_name" id="first-name" value="{{ old('first_name') ? : $contact->first_name }}">
                            <label for="first-name">First Name</label>
                            @if($errors->has('first_name'))
                                <span class="helper-text red-text">
                                    {{$errors->first('first_name')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 login-field">
                            <input type="text" name="last_name" id="last-name" value="{{ old('last_name') ? : $contact->last_name }}">
                            <label for="last-name">Last Name</label>
                            @if($errors->has('last_name'))
                                <span class="helper-text red-text">
                                    {{$errors->first('last_name')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 login-field">
                            <input type="email" name="email" id="email" value="{{ old('email') ? : $contact->email}}">
                            <label for="email">Email</label>
                            @if($errors->has('email'))
                                <span class="helper-text red-text">
                                    {{$errors->first('email')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 login-field">
                            <textarea name="message" id="message" class="materialize-textarea">{{old('message') ? : $contact->message }}</textarea>
                            <label for="message">Message</label>
                            @if($errors->has('message'))
                                <span class="helper-text red-text">
                                    {{$errors->first('message')}}
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn col s10 offset-s1 m4 offset-m4 bg2 waves-effect waves-light">Update</button>
                    </div>
                </form>
                <br>
                <a href="{{route('admin.contacts.show',$contact->id)}}" class="btn-flat waves-effect blue-text">Go Back</a>
            </div>
        </div>
    </div>
</div>
@endsection