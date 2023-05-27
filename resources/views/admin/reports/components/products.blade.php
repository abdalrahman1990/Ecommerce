<table class="responsive-table centered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Quantity</th>
            <th>Created at</th>
            <th>Updated at</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->title}}</td>
                <td>{{$product->hasCategory->id}}</td>
                <td>{{$product->hasCategory->title}}</td>
                <td>{{$product->quantity}}</td>
                <td>{{$product->created_at->diffForHumans()}}</td>
                <td>{{$product->updated_at->diffForHumans()}}</td>
            </tr>
        @empty
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="center">No Products Found!</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforelse
    </tbody>
</table>
<br>
<div class="center-align">
    {{$products->appends(request()->query())->links('vendor.pagination.default',['item' => $products])}}
</div>