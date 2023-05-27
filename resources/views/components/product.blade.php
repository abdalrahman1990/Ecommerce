<a href="{{route('product-details',$product->slug)}}">
    <div class="card-panel product-card no-padding hoverable">
        <div class="prod-card-img">
            @if($product->outOfStock())
                <span class="chip red lighten-1 white-text prod-chip">out of stock!</span>
            @endif
            @if($product->hasLowStock())
                <span class="chip yellow prod-chip">Low Stock!</span>
            @endif
            <span class="chip blue lighten-5 blue-text val prod-qty">{{$product->quantity}}</span>
            <img src="{{asset('storage/products/'.$product->image)}}" alt="{{$product->title}}">
        </div>
        <div class="prod-details">
            <div class="prod-title">
                
                <a href="#" class="grey-text text-darken-2 truncate">{{$product->title}}</a>
            </div>
            <br>
            <span class="sm-txt">Price:</span> <span class="sm-txt val">${{$product->price}}</span>
            <div class="d-flex">
                <span class="sm-txt">Rating : </span>
                @component('components.review-count',[
                    'product' => $product
                ])
                @endcomponent
            </div>
            <div class="center prod-options">
                <a href="{{route('product-details',$product->slug)}}" data-id="{{$product->id}}" class="add-cart tooltipped btn bg2 waves-effect waves-light {{($product->outOfStock()) ? 'disabled white-text' : ''}}" data-position="bottom" data-tooltip="Add to Cart">
                    <i class="material-icons">add_shopping_cart</i>
                </a>
                <a href="#" data-id="{{$product->id}}" class="add-wishlist tooltipped btn bg2 waves-effect waves-light" data-position="bottom" data-tooltip="Add to wishlist">
                    <i class="material-icons">favorite_border</i>
                </a>
            </div>
        </div>
    </div>
</a>