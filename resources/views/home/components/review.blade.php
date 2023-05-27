<div id="reviews" class="col s12">
    <br>
    @auth
        @if(!$product->reviews->where('user_id',Auth::id())->first())
            <h5 class="col">Leave a review.</h5>
            <form action="{{route('reviews.store')}}" method="post">
                @csrf
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <div class="input-field col s12 l10 login-field">
                    <textarea name="description" id="description" class="materialize-textarea">{{old('description')}}</textarea>
                    <label for="description">My Review</label>
                    @if($errors->has('description'))
                        <span class="helper-text red-text">
                            {{$errors->first('description')}}
                        </span>
                    @endif
                </div>
                <div class="input-field col s12 m4 offset-m4 l2 login-field">
                    <select name="rating" id="rating">
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{$i}}" {{ ($i == old('rating')) ? 'selected' : '' }}>{{$i}}</option>
                        @endfor
                    </select>
                    <label>Rating</label>
                    @if($errors->has('rating'))
                        <span class="helper-text red-text">
                            {{$errors->first('rating')}}
                        </span>
                    @endif
                </div>
                <div class="row mb-0"></div>
                <button type="submit" class="btn bg waves-effect waves-light col s10 offset-s1 m4 offset-m4 l2 offset-l5">Submit</button>
            </form>
            <br><br>
        @endif
    @else
        <br>
        <h6 class="center">Please <a href="{{route('login')}}">login</a> or <a href="{{route('register')}}">register</a> to write a review!</h6>
        <br>
    @endauth
    @forelse($reviews as $review)
        <ul class="collection review">
            <li class="collection-item avatar review-item">
                <img src="{{$review->user->gravatar}}" alt="{{$review->user->name}}" class="circle">
                <span class="title grey-text text-darken-1">{{$review->user->name}} &nbsp;</span>
                <span> {{$review->created_at->diffForHumans()}}</span>
                <br>
                <span>
                    @for($i = 0; $i < 5; $i++)
                        <i class="material-icons {{($i < $review->rating) ? 'yellow-text text-darken-1' : 'grey-text text-lighten-2'}}">star</i>
                    @endfor
                </span>
            </li>
            <li class="collection-item">
                <p>{{$review->text}}</p>
            </li>
        </ul>
        <br>
    @empty
        <br>
        <h5 class="center">No Reviews yet!</h5>
    @endforelse
    <div class="center-align">
        {{$reviews->links('vendor.pagination.default',[
            'items' => $reviews
        ])}}
    </div>
</div>