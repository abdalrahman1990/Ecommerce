@if($product->reviews->avg('rating'))
    @for($i = 1; $i <= 5; $i++)
        <i class="material-icons {{($product->reviews->avg('rating') >= $i) ? 'yellow-text text-darken-1' : 'grey-text text-lighten-2'}} star">star</i>
    @endfor
@else
<span class="sm-txt">no reviews!</span>
@endif