<h4 class="center grey-text text-darken-1">Order Information</h4>
<br>
<ul class="collection with-header">
    <li class="collection-header">
        <div class="section">
            <h5 class="grey-text text-darken-2">Customer Order Details:</h5>
        </div>
    </li>
    <li class="collection-item">
        <div class="section">
            <h6 class="grey-text text-darken-4">Order Date: </h6>
            <span class="grey-text text-darken-2">{{$order->created_at->diffForHumans()}}</span>
        </div>
    </li>
    <li class="collection-item">
        <div class="section">
            <h6 class="grey-text text-darken-4">Payment Status: </h6>
            <span class="grey-text text-darken-2">{{($order->paid) ? 'Paid' : 'failed'}}</span>
        </div>
    </li>
    <li class="collection-item">
        <div class="section">
            <h6 class="grey-text text-darken-4">Sub Total (without tax) :</h6>
            <span class="val grey-text text-darken-2"> ${{number_format($order->total,2)}}</span>
        </div>
    </li>
    <li class="collection-item">
        <div class="section">
            <h6 class="grey-text text-darken-4">Tax :</h6>
            <span class="val grey-text text-darken-2">${{($order->total * 5 / 100)}}</span>
        </div>
    </li>
    <li class="collection-item">
        <div class="section">
            <h6 class="grey-text text-darken-4">Total :</h6>
            <span class="val grey-text text-darken-2">${{number_format((($order->total) + ($order->total * 5 /100)),2)}}</span>
        </div>
    </li>
</ul>
<br>
<ul class="collection with-header">
    <li class="collection-header">
        <div class="section">
            <h5 class="grey-text text-darken-2">Address Details:</h5>
        </div>
    </li>
    <li class="collection-item">
        <div class="section">
            <h6 class="grey-text text-darken-4">Address Line 1: </h6>
            <span class="grey-text text-darken-2">{{$order->address->address_1}}</span>
        </div>
    </li>
    <li class="collection-item">
        <div class="section">
            <h6 class="grey-text text-darken-4">Address Line 2: </h6>
            @if($order->address->address_2)
                <span class="grey-text text-darken-2">{{$order->address->address_2}}</span>
            @else
                <span class="grey-text text-darken-2">No Second Address</span>
            @endif
        </div>
    </li>
    <li class="collection-item">
        <div class="section">
            <h6 class="grey-text text-darken-4">City:</h6>
            <span>{{$order->address->city->name}}</span>
        </div>
    </li>
    <li class="collection-item">
        <div class="section">
            <h6 class="grey-text text-darken-4">Postal Code:</h6>
            <span>{{$order->address->postal_code}}</span>
        </div>
    </li>
</ul>
<br><br>
<h5 class="center grey-text text-darken-2">Ordered Products</h5>
<br>
<table class="responsive-table centered grey-text text-darken-3">
    <thead>
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{$loop->index + 1}}</td>
                <td>
                    <img width="60px" height="50px" src="{{asset('storage/products/'.$product->image)}}" alt="">
                </td>
                <td>
                    <a href="{{route('product-details',$product->slug)}}">{{$product->title}}</a>
                </td>
                <td>{{$product->hasCategory->title}}</td>
                <td class="val">{{$product->pivot->qty}}</td>
                <td class="val">${{number_format($product->price,2)}} /-</td>
            </tr>
        @endforeach
    </tbody>
</table>
<br>
<div class="center-align">
    {{$products->links('vendor.pagination.default',['items' => $products])}}
</div>
<br><br>