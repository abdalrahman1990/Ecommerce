@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <h4 class="center grey-text text-darken-1">My Order History</h4>
                    <br>
                    <table class="responsive-table centered grey-text text-darken-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>No of Products</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{Auth::user()->name}}</td>
                                    <td>
                                        @foreach($order->products as $product)
                                            @php $qty[] = $product->pivot->qty @endphp
                                        @endforeach
                                        {{array_sum($qty)}}
                                        @php
                                            $qty = []
                                        @endphp
                                    </td>
                                    <td class="val">${{number_format($order->total,2)}} /- </td>
                                    <td>{{($order->paid) ? 'paid' : 'failed' }}</td>
                                    <td>{{$order->created_at->diffForHumans()}}</td>
                                    <td>
                                        <a href="{{route('order.show',$order->id)}}" class="btn-floating btn-small darken-3 tooltipped" data-position="left" data-tooltip="View Details">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="center">No Orders Found!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <br><br>
                    <div class="center-align">
                        {{$orders->links('vendor.pagination.default',['items' => $orders])}}
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
@endsection