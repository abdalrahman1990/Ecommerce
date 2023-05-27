@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <div class="row dashboard">
                <div class="col s12 m6 l6 xl6">
                    <div class="card-panel product-card card-bg z-depth-2">
                        <span class="grey-text text-lighten-3 text-uppercase">total orders</span>
                        <div class="divider"></div>
                        <p>
                            <i class="material-icons medium grey-text text-lighten-3">shopping_cart</i>
                            <span class="grey-text text-lighten-3 right card-val val">{{$orders_ct}}</span>
                        </p>
                        <a href="{{route('admin.orders.index')}}" class="grey-text text-lighten-3 link-line">Show More</a>
                    </div>
                </div>
                <div class="col s12 m6 l6 xl6">
                    <div class="card-panel product-card card-bg2 z-depth-2">
                        <span class="grey-text text-lighten-3 text-uppercase">total customers</span>
                        <div class="divider"></div>
                        <p>
                            <i class="material-icons medium grey-text text-lighten-3">people</i>
                            <span class="grey-text text-lighten-3 right card-val val">{{$customers_ct}}</span>
                        </p>
                        <a href="{{route('admin.customers.index')}}" class="grey-text text-lighten-3 link-line">Show More</a>
                    </div>
                </div>
                <div class="col s12 m6 l6 xl6">
                    <div class="card-panel product-card card-bg3 z-depth-2">
                        <span class="grey-text text-lighten-3 text-uppercase">total sales</span>
                        <div class="divider"></div>
                        <p>
                            <i class="material-icons medium grey-text text-lighten-3">credit_card</i>
                            <span class="grey-text text-lighten-3 right card-val val">{{$total_payments}}</span>
                        </p>
                        <a href="{{route('admin.payments.index')}}" class="grey-text text-lighten-3 link-line">Show More</a>
                    </div>
                </div>
                <div class="col s12 m6 l6 xl6">
                    <div class="card-panel product-card card-bg4 z-depth-2">
                        <span class="grey-text text-lighten-3 text-uppercase">total products</span>
                        <div class="divider"></div>
                        <p>
                            <i class="material-icons medium grey-text text-lighten-3">shop_two</i>
                            <span class="grey-text text-lighten-3 right card-val val">{{$products_ct}}</span>
                        </p>
                        <a href="{{route('admin.products.index')}}" class="grey-text text-lighten-3 link-line">Show More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <h5 class="center grey-text text-darken-2">Order Analytics</h5>
                <canvas id="orderChart"></canvas>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
            <h5 class="center grey-text text-darken-2">Latest Orders</h5>
                <table class="responsive-table centered grey-text text-darken-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Address ID</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$order->user->name}}</td>
                                <td>{{$order->address->address_1}}</td>
                                <td>{{($order->paid) ? 'paid' : 'failed'}}</td>
                                <td class="val grey-text text-darken-2">${{$order->total}}</td>
                                <td>{{$order->created_at->diffForHumans()}}</td>
                                <td>
                                    <div class="center">
                                        <a href="{{route('admin.orders.show',$order->id)}}" class="btn-floating btn-small waves-effect waves-light tooltipped" data-position="left" data-tooltip="View Details">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="center">No Latest Orders!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <br>
                <div class="center-align section">
                    <a href="{{route('admin.orders.index')}}" class="btn waves-effect waves-light">View All</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{asset('js/chart.min.js')}}"></script>
    <script>
        let orderChart = document.querySelector('#orderChart').getContext('2d');
        var chart = new Chart(orderChart, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels:[
                    /*
                        this is blade templating.
                        Get the date of specified the submonth
                     */
                    '{{Carbon\Carbon::now()->subMonths(5)->toFormattedDateString()}}',
                    '{{Carbon\Carbon::now()->subMonths(4)->toFormattedDateString()}}',
                    '{{Carbon\Carbon::now()->subMonths(3)->toFormattedDateString()}}',
                    '{{Carbon\Carbon::now()->subMonths(2)->toFormattedDateString()}}',
                    '{{Carbon\Carbon::now()->subMonths(1)->toFormattedDateString()}}'
                    ],
                datasets: [{
                    label: "Orders",
                    backgroundColor: 'rgba(77,208,225 ,1)',
                    borderColor: 'rgba(0,188,212 ,1)',
                    data: [
                        '{{$order_ct_5}}',
                        '{{$order_ct_4}}',
                        '{{$order_ct_3}}',
                        '{{$order_ct_2}}',
                        '{{$order_ct_1}}',
                    ],
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
@endsection