@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <h4 class="center">Update Ordered Products</h4>
                    <br>
                    <ul class="tabs">
                        <li class="tab col s6">
                            <a href="#update" class="purple-text">Update Products</a>
                        </li>
                        <li class="tab col s6">
                            <a class="purple-text" href="#add">Add Products</a>
                        </li>
                    </ul>
                    <br>
                    <div id="update">
                        @component('admin.orders.components.ordered-products',[
                            'orderedProducts' => $orderedProducts,
                            'id'           => $order->id
                        ])
                        @endcomponent
                    </div>
                    <div id="add">
                        @component('admin.orders.components.add-product',[
                            'products' => $products,
                            'id'       => $order->id
                        ])
                        @endcomponent
                    </div>
                    <br>
                    <a href="{{route('admin.orders.show',$order->id)}}" class="btn-flat waves-effect blue-text">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
