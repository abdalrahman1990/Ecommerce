<table class="responsive-table centered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Address line 1</th>
            <th>City</th>
            <th>Postal Code</th>
            <th>Created at</th>
            <th>Updated at</th>
        </tr>
    </thead>
    <tbody>
        @forelse($addresses as $address)
            <tr>
                <td>{{$address->id}}</td>
                <td>{{$address->address_1}}</td>
                <td>{{$address->city->name}}</td>
                <td>{{$address->postal_code}}</td>
                <td>{{$address->created_at->diffForHumans()}}</td>
                <td>{{$address->updated_at->diffForHumans()}}</td>
            </tr>
        @empty
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="center">No Addresses Found!</td>
                <td></td>
                <td></td>
            </tr>
        @endforelse
    </tbody>
</table>
<br>
<div class="center-align">
    {{$addresses->appends(request()->query())->links('vendor.pagination.default',['item' => $addresses])}}
</div>