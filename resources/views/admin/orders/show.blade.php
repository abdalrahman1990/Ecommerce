@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                @component('components.order-details',[
                    'order' => $order,
                    'products' => $products
                ])
                @endcomponent
                <br>
                <div class="row">
                    <div class="col s12 m6 l6 xl6 row">
                        <a href="{{route('admin.orders.edit',$order->id)}}" class="btn pink waves-effect waves-light col s8 offset-s2">
                            Update Order
                        </a>
                    </div>
                    <div class="col s12 m6 l6 xl6 row">
                        <a href="{{route('admin.orders.products',$order->id)}}" class="btn red waves-effect waves-light col s8 offset-s2 modal-trigger">
                            Update Products
                        </a>
                    </div>
                </div>
                <br>
                <a href="{{route('admin.orders.index')}}" class="btn-flat waves-effect blue-text">Go Back</a>
            </div>
        </div>
    </div>
</div>

@endsection