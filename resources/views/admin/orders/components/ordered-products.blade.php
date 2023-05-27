<h5 class="center">Update ordered products</h5>
<br>
<table class="responsive-table grey-text text-darken-3">
    <thead>
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orderedProducts as $product)
            <tr>
                <td>{{$loop->index + 1}}</td>
                <td>
                    <img width="60px" height="50px" src="{{asset('storage/products/'.$product->image)}}" alt="">
                </td>
                <td>
                    <a href="{{route('product-details',$product->slug)}}">{{$product->title}}</a>
                </td>
                <td>{{$product->hasCategory->title}}</td>
                {{--<td class="val">{{$product->pivot->qty}}</td>--}}
                <td class="val">${{number_format($product->price,2)}} /-</td>
                <td>
                    <div>
                        <form action="{{route('admin.orders.products',$id)}}" method="post">
                            @csrf
                            <input type="hidden" name="p_id" value="{{$product->id}}">
                            <div class="row" style="margin-bottom:0 !important">
                                <div class="input-field login-field col s9 xl5">
                                    <select name="qty" id="qty">
                                        <option value="0">None</option>
                                        @for($i = 1; $i <= $product->quantity;$i++)
                                            <option class="val" value="{{$i}}" {{($i == $product->pivot->qty) ? 'selected' : '' }}>{{$i}}</option>
                                        @endfor
                                    </select>
                                    <label>Quantity</label>
                                </div>
                                <br>
                                <div class="col">
                                    <button type="submit" class="btn-floating btn-small waves-effect tooltipped" data-position="bottom" data-tooltip="Update quantity">
                                        <i class="material-icons">sync</i>
                                    </button>
                                </div>
                            </div>
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
                    <h6>No products found!</h6>
                </td>
                <td></td>
                <td></td>
            </tr>
        @endforelse
    </tbody>
</table>
<br>
<div class="center-align">
    {{$orderedProducts->links('vendor.pagination.default',[
        'items' => $orderedProducts
    ])}}
</div>
<br>