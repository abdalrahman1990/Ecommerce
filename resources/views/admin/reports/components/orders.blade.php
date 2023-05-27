<table class="responsive-table centered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Total</th>
            <th>Address ID</th>
            <th>Postal Code</th>
            <th>City</th>
            <th>Transaction ID</th>
            <th>Status</th>
            <th>Customer ID</th>
            <th>Created at</th>
            <th>Updated at</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{'$'.number_format($order->total,2)}}</td>
                <td>{{$order->address_id}}</td>
                <td>{{$order->address->postal_code}}</td>
                <td>{{$order->address->city->name}}</td>
                @if($order->payment)
                    <td>{{$order->payment->transaction_id}}</td>
                @else
                    <td></td>
                @endif
                <td>{{($order->paid) ? 'Paid' : 'Failed'}}</td>
                <td>{{$order->user_id}}</td>
                <td>{{$order->created_at->diffForHumans()}}</td>
                <td>{{$order->updated_at->diffForHumans()}}</td>
            </tr>
        @empty
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="center">No Orders Found!</td>
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
    {{$orders->appends(request()->query())->links('vendor.pagination.default',['item' => $orders])}}
</div>