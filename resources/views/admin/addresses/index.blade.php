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
                        Manage Customer Addresses
                    @endif    
                </h4>
                <br>
                <form action="{{route('admin.addresses.index')}}">
                    <div class="row">
                        <div class="input-field col s12 m6 login-field">
                            <input type="text" name="search" id="re-search" value="{{request()->search}}">
                            <label for="re-search">Search</label>
                        </div>
                        <div class="input-field col s12 m4 login-field">
                            <select name="option" id="option">
                                <option value="address_1" {{(request()->option == "address_1") ? 'selected' : ''}}>Address line 1</option>
                                <option value="address_2" {{(request()->option == "address_2") ? 'selected' : ''}}>Address line 2</option>
                                <option value="city" {{(request()->option == "city") ? 'selected' : ''}}>City</option>
                                <option value="postal_code" {{(request()->option == "postal_code") ? 'selected' : ''}}>Postal Code</option>
                            </select>
                            <label for="option">Option</label>
                        </div>
                        <br>
                        <button type="submit" class="col s12 m2 btn bg2 waves-effect">Search</button>
                    </div>
                </form>
                <br>
                <table class="responsive-table centered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Address line 1</th>
                            <th>Address line 2</th>
                            <th>City</th>
                            <th>Postal Code</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($addresses as $address)
                            <tr>
                                <td>{{$address->id}}</td>
                                <td>{{str_limit($address->address_1,15)}}</td>
                                <td>{{str_limit($address->address_2,15)}}</td>
                                <td>{{$address->city->name}}</td>
                                <td>{{$address->postal_code}}</td>
                                <td>{{$address->created_at->diffForHumans()}}</td>
                                <td>{{$address->updated_at->diffForHumans()}}</td>
                                <td>
                                    <a href="{{route('admin.addresses.show',$address->id)}}" class="btn-floating btn-small tooltipped" data-position="right" data-tooltip="Address Details!">
                                        <i class="material-icons">visibility</i>
                                    </a>
                                    @if($address->orders->count())
                                        <a href="#delete-modal-{{$address->id}}" class="disabled btn-floating btn-small red modal-trigger tooltipped" data-position="right" data-tooltip="Delete Address!">
                                            <i class="material-icons">delete</i>
                                        </a>
                                    @else
                                        <a href="#delete-modal-{{$address->id}}" class="btn-floating btn-small red modal-trigger tooltipped" data-position="left" data-tooltip="Delete Address!">
                                            <i class="material-icons">delete</i>
                                        </a>
                                        @component('components.confirm',[
                                            'id'    => 'delete-address-'.$address->id,
                                            'modal' => 'delete-modal-'.$address->id,
                                            'title' => 'Address'
                                        ])
                                        @endcomponent
                                        <form action="{{route('admin.addresses.destroy',$address->id)}}" method="post" class="hide" id="delete-address-{{$address->id}}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="center">No Addresses to Display!</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <br>
                <div class="center-align">
                    @if($title)
                        <a href="{{route('admin.addresses.index')}}" class="btn waves-effect">View All</a>
                        <br>
                    @endif
                    {{$addresses->appends(request()->query())->links('vendor.pagination.default',[
                        'items' => $addresses
                    ])}}
                </div>
                <br><br>
            </div>
        </div>
    </div>
    <div class="fixed-action-btn">
        <a href="{{route('admin.addresses.create')}}" class="red waves-effect waves-light btn-floating btn-large">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
@endsection