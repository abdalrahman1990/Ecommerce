@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <h4 class="center grey-text text-darken-2">Create new Address</h4>
                <br>
                <form action="{{route('admin.addresses.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12 login-field">
                            <textarea name="address_1" id="address_1" class="materialize-textarea">{{old('address_1')}}</textarea>
                            <label for="address_1">Address Line 1</label>
                            @if($errors->has('address_1'))
                                <span class="helper-text red-text">
                                    {{$errors->first('address_1')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 login-field">
                            <textarea name="address_2" id="address_2" class="materialize-textarea">{{old('address_2')}}</textarea>
                            <label for="address_2">Address Line 2</label>
                            @if($errors->has('address_2'))
                                <span class="helper-text red-text">
                                    {{$errors->first('address_2')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 m6 login-field">
                            <select name="city" id="city">
                                <option value="">Select a city</option>
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}" {{(old('city') == $city->id) ? 'selected' : '' }}>{{$city->name}}</option>
                                @endforeach
                            </select>
                            <label for="city">City</label>
                            @if($errors->has('city'))
                                <span class="helper-text red-text">
                                    {{$errors->first('city')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 m6 login-field">
                            <input type="text" name="postal_code" id="postal_code" value="{{old('postal_code')}}">
                            <label for="postal_code">Postal Code</label>
                            @if($errors->has('postal_code'))
                                <span class="helper-text red-text">
                                    {{$errors->first('postal_code')}}
                                </span>
                            @endif
                        </div>
                        <div class="row"></div>
                        <button type="submit" class="btn bg2 waves-effect waves-light col s8 offset-s2 m4 offset-m4">Create Address</button>
                    </div>
                </form>
                <br>
                <a href="{{route('admin.addresses.index')}}" class="btn-flat waves-effect blue-text">Go Back</a>
            </div>
        </div>
    </div>
</div>
@endsection