@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <div class="card-panel grey-text text-darken-2">
                <h4 class="center">Address Details</h4>
                <br>
                <h6>Address Line 1 :</h6>
                <p>{{$address->address_1}}</p>
                <div class="divider"></div>
                <br>
                <h6>Address Line 2 :</h6>
                <p>{{$address->address_2}}</p>
                <div class="divider"></div>
                <br>
                <h6>City :</h6>
                <p>{{$address->city->name}}</p>
                <div class="divider"></div>
                <br>
                <h6>Postal Code:</h6>
                <p>{{$address->postal_code}}</p>
                <div class="divider"></div>
                <br><br>
                <div class="row">
                    <div class="col s12 m6 l6 xl6 row">
                        <a href="{{route('admin.addresses.edit',$address->id)}}" class="btn pink waves-effect waves-light col s8 offset-s2">
                            Update
                        </a>
                    </div>
                    @component('components.confirm',[
                        'id'    => 'delete-address',
                        'modal' => 'deleteModal',
                        'title' => 'Address'
                    ])
                    @endcomponent
                    <div class="col s12 m6 l6 xl6 row">
                        <a href="#deleteModal" class="{{($address->orders->count()) ? 'disabled' : '' }} btn red waves-effect waves-light col s8 offset-s2 modal-trigger">
                            Delete
                        </a>
                        <form action="{{route('admin.addresses.destroy',$address->id)}}" method="post" class="hide" id="delete-address">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
                <br>
                <a href="{{route('admin.addresses.index')}}" class="btn-flat waves-effect blue-text">Go Back</a>
            </div>
        </div>
    </div>
</div>
@endsection