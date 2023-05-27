@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <h4 class="center">
                    @if($title)
                        {{$title}}
                    @else
                        Manage Cities
                    @endif
                </h4>
                <br>
                <form action="{{route('admin.cities.index')}}">
                    <div class="row">
                        <div class="input-field col s12 m6 offset-m2 login-field">
                            <input type="text" name="search" id="re-search">
                            <label for="re-search">Search Cities</label>
                        </div>
                        <br>
                        <button class="btn col s10 offset-s1 m2 bg2">Search</button>
                    </div>
                </form>
                <br>
                <table class="responsive-table centered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>City Name</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cities as $city)
                        <tr>
                            <td>{{$city->id}}</td>
                            <td>{{$city->name}}</td>
                            <td>{{$city->created_at->diffForHumans()}}</td>
                            <td>{{$city->updated_at->diffForHumans()}}</td>
                            <td>
                                <a href="{{route('admin.cities.edit',$city->id)}}" class="btn-floating btn-small waves-effect waves-light tooltipped" data-position="left" data-tooltip="Update city">
                                    <i class="material-icons">refresh</i>
                                </a>
                                <a href="#delete-modal-{{$city->id}}" class="btn-floating btn-small red waves-effect waves-light modal-trigger tooltipped" data-position="left" data-tooltip="Delete Message!">
                                    <i class="material-icons">delete</i>
                                </a>
                                @component('components.confirm',[
                                    'id' => 'delete-city-'.$city->id,
                                    'modal' => 'delete-modal-'.$city->id,
                                    'title' => 'Message'
                                ])
                                @endcomponent
                                <form action="{{route('admin.cities.destroy',$city->id)}}" method="post" class="hide" id="delete-city-{{$city->id}}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <h6 class="center">No Cities Yet!</h6>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <br>
                <div class="center-align">
                    @if($title)
                        <a href="{{route('admin.cities.index')}}}" class="btn btn-small waves-effect waves-light">View all</a>
                        <br>
                    @endif
                    {{$cities->appends(request()->query())->links('vendor.pagination.default',[
                        'items' => $cities
                    ])}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="fixed-action-btn">
    <a href="{{route('admin.cities.create')}}" class="btn-floating btn-large red waves-effect waves-light">
        <i class="material-icons">add</i>
    </a>
</div>
@endsection