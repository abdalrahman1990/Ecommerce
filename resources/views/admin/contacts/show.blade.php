@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <ul class="collection with-header">
                    <li class="collection-header">
                        <h4 class="center">Message Details</h4>
                    </li>
                    <li class="collection-item">
                        <div class="section">
                            <h6 class="grey-text text-darken-3">First Name: </h6>
                            @if($contact->first_name)
                                <span>{{$contact->first_name}}</span>
                            @else
                                <span>Not Available</span>
                            @endif
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="section">
                            <h6 class="grey-text text-darken-3">Last Name: </h6>
                            @if($contact->last_name)
                                <span>{{$contact->last_name}}</span>
                            @else
                                <span>Not Available</span>
                            @endif
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="section">
                            <h6 class="grey-text text-darken-3">Email: </h6>
                            <span>{{$contact->email}}</span>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="section">
                            <h6 class="grey-text text-darken-3">Message: </h6>
                            <span>{{$contact->message}}</span>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="section">
                            <h6 class="grey-text text-darken-3">Messaged at: </h6>
                            <span>{{$contact->created_at->diffForHumans()}}</span>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="section">
                            <h6 class="grey-text text-darken-3">Message updated at: </h6>
                            <span>{{$contact->updated_at->diffForHumans()}}</span>
                        </div>
                    </li>
                    <li class="collection-item">
                        <br>
                        <div class="row">
                            <div class="col s12 m6 l6 xl6 row">
                                <a href="{{route('admin.contacts.edit',$contact->id)}}" class="btn pink lighten-1 waves-effect waves-light col s8 offset-s2">
                                    Update
                                </a>
                            </div>
                            @component('components.confirm',[
                                'id'    => 'delete-contact',
                                'modal' => 'deleteModal',
                                'title' => 'Contact'
                            ])
                            @endcomponent
                            <div class="col s12 m6 l6 xl6 row">
                                <a href="#deleteModal" class="btn red waves-effect waves-light col s8 offset-s2 modal-trigger">
                                    <i class="material-icons left">delete</i>
                                    Delete
                                </a>
                                <form action="{{route('admin.contacts.destroy',$contact->id)}}" method="post" class="hide" id="delete-contact">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
                <br>
                <a href="{{route('admin.contacts.index')}}" class="btn-flat waves-effect blue-text">Go Back</a>
            </div>
        </div>
    </div>
</div>
@endsection