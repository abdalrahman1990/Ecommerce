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
            <a href="{{route('order.index')}}" class="btn-flat waves-effect blue-text">Go Back</a>
            </div>
        </div>
    </div>
</div>

@endsection