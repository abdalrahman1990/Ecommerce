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
                        Manage Customers
                    @endif    
                </h4>
                <br>
                <form action="{{route('admin.customers.index')}}">
                    <div class="row">
                        <div class="input-field col s12 m6 login-field">
                            <input type="text" name="search" id="re-search" value="{{request()->search}}">
                            <label for="re-search">Search</label>
                        </div>
                        <div class="input-field col s12 m4 login-field">
                            <select name="option" id="option">
                                <option value="name" {{(request()->option == "name") ? 'selected' : ''}}>Name</option>
                                <option value="email" {{(request()->option == "email") ? 'selected' : ''}}>Email</option>
                            </select>
                            <label for="option">Option</label>
                        </div>
                        <br>
                        <button type="submit" class="col s12 m2 bg2 btn waves-effect">Search</button>
                    </div>
                </form>
                <br>
                <table class="responsive-table centered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{$customer->id}}</td>
                            <td>
                                <img src="{{$customer->gravatar}}" alt="{{$customer->name}}" width="50" height="50" class="circle">
                            </td>
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->email}}</td>
                            <td>{{$customer->created_at->diffForHumans()}}</td>
                            <td>{{$customer->updated_at->diffForHumans()}}</td>
                            <td>
                                <div class="center">
                                    <a href="{{route('admin.customers.edit',$customer->id)}}" class="btn-floating btn-small tooltipped" data-position="left" data-tooltip="Update Customer!">
                                        <i class="material-icons">refresh</i>
                                    </a>
                                </div>
                            </td>
                        </tr>    
                    @empty
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="center">No Customers to Display!</td>
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
                        <a href="{{route('admin.customers.index')}}" class="btn waves-effect">View All</a>
                        <br>
                    @endif
                    {{$customers->appends(request()->query())->links('vendor.pagination.default',[
                        'items' => $customers
                    ])}}
                </div>
                <br><br>
            </div>
        </div>
    </div>
    <div class="fixed-action-btn">
        <a href="{{route('admin.customers.create')}}" class="btn-floating btn-large red waves-effect waves-light">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
@endsection