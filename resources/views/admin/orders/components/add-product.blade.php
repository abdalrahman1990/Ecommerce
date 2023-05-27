<h5 class="center">Add products to order</h5>
<br>
<form action="{{route('admin.orders.products.add',$id)}}" method="post">
    <div class="row">
        @csrf
        <div class="input-field col s12 m8 login-field">
            <select name="product" id="product">
                <option value="">Select a product</option>
                @foreach($products as $product)
                <option value="{{$product->id}}" {{(old('product') == $product->id) ? 'selected' : '' }}>{{$product->title}} | quantity: {{$product->quantity}}</option>
                @endforeach
            </select>
            <label for="product">Product</label>
            @if($errors->has('product'))
                <span class="helper-text red-text">
                    {{$errors->first('product')}}
                </span>
            @endif
        </div>
        <div class="input-field col s12 m2 login-field">
            <input type="number" name="qty" id="qty" min=0 value="{{old('qty')}}">
            <label for="qty">Quantity</label>
            @if($errors->has('qty'))
                <span class="helper-text red-text">
                    {{$errors->first('qty')}}
                </span>
            @endif
        </div>
        <br>
        <button type="submit" class="btn bg2 col s8 offset-s2 m2 waves-effect waves-light">add</button>
    </div>
</form>