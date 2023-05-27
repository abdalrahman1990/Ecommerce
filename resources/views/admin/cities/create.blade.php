@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <h4 class="center">Create New City</h4>
                <form action="{{route('admin.cities.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12 m8 offset-m2 login-field">
                            <input type="text" name="name" id="name" value="{{ old('name') }}">
                            <label for="name">City Name</label>
                            @if($errors->has('name'))
                                <span class="helper-text red-text">
                                    {{$errors->first('name')}}
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn col s10 offset-s1 m4 offset-m4 bg2 waves-effect waves-light">Create</button>
                    </div>
                </form>
                <br>
                <a href="{{route('admin.cities.index')}}" class="btn-flat waves-effect blue-text">Go Back</a>
            </div>
        </div>
    </div>
</div>
@endsection