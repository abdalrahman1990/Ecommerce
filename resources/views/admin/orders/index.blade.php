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
                        Manage Orders
                    @endif    
                </h4>
                <br>
                <form action="{{route('admin.orders.index')}}">
                    <div class="row">
                        <div class="input-field col s12 m6 offset-m2 login-field">
                            <input type="text" name="search" id="re-search" value="{{request()->search}}">
                            <label for="re-search">Search By Customer Name</label>
                        </div>
                        <br>
                        <button type="submit" class="btn col s12 m2 bg2">Search</button>
                    </div>
                </form>
                <table class="responsive-table centered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Address ID</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->user->name}}</td>
                                <td>{{$order->address_id}}</td>
                                <td>{{($order->paid) ? 'Paid' : 'Failed'}}</td>
                                <td class="val grey-text text-darken-2">${{number_format($order->total,2)}}</td>
                                <td>{{$order->created_at->diffForHumans()}}</td>
                                <td>{{$order->updated_at->diffForHumans()}}</td>
                                <td>
                                    <div class="center">
                                        <a href="{{route('admin.orders.show',$order->id)}}" class="btn-floating btn-small tooltipped waves-effect waves-light" data-position="left" data-tooltip="Order Details">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                        <a href="#delete-modal-{{$order->id}}" class="modal-trigger btn-floating btn-small red tooltipped red waves-effect waves-light" data-position="left" data-tooltip="Delete Order">
                                            <i class="material-icons">delete</i>
                                        </a>
                                        @component('components.confirm',[
                                            'id'    => 'delete-order-'.$order->id,
                                            'modal' => 'delete-modal-'.$order->id,
                                            'title' => 'Order'
                                        ])
                                        @endcomponent
                                        <form action="{{route('admin.orders.destroy',$order->id)}}" method="post" class="hide" id="delete-order-{{$order->id}}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="center">No Orders to Display!</td>
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
                        <a href="{{route('admin.orders.index')}}" class="btn waves-effect">View All</a>
                        <br>
                    @endif
                    {{$orders->appends(request()->query())->links('vendor.pagination.default',[
                        'items' => $orders
                    ])}}
                </div>
                <br><br>
            </div>
        </div>
    </div>
</div>
@endsection