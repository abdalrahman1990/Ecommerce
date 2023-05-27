@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <h4 class="center grey-text text-darken-2">Manage Payments</h4>
                <br>
                <table class="responsive-table centered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Status</th>
                            <th>Transaction ID</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$payment->order_id}}</td>
                                <td>{{($payment->failed) ? 'Failed' : 'Success' }}</td>
                                <td>{{$payment->transaction_id}}</td>
                                <td>{{$payment->created_at->diffForHumans()}}</td>
                                <td>{{$payment->updated_at->diffForHumans()}}</td>
                                <td>
                                    <div class="center">
                                        <a href="#delete-modal-{{$payment->id}}" class="tooltipped btn-floating btn-small red waves-effect waves-light modal-trigger" data-position="left" data-tooltip="Delete Payment!">
                                            <i class="material-icons">delete</i>
                                        </a>
                                        @component('components.confirm',[
                                            'id'    => 'delete-payment-'.$payment->id,
                                            'modal' => 'delete-modal-'.$payment->id,
                                            'title' => 'Order'
                                        ])
                                        @endcomponent
                                        <form action="{{route('admin.payments.destroy',$payment->id)}}" method="post" class="hide" id="delete-payment-{{$payment->id}}">
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
                                <td>
                                    <h6 class="center grey-text text-darken-2">No Payments to Display!</h6>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <br><br>
                <div class="center-align">
                    {{$payments->links('vendor.pagination.default',[ 'item' => $payments ])}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection