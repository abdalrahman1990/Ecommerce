@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h4 class="center">
        @isset($title)
            {{$title}}
        @else
            Our Latest Products
        @endisset
    </h4>
    <br>
    @component('home.components.product-options')
    @endcomponent
    <div class="row">
        <div class="col s12 m12 l9">
            <div class="row">
                @forelse($products as $product)
                <div class="col s10 offset-s1 m4 l4 xl3">
                    @component('components.product',['product' => $product])
                    @endcomponent
                </div>
                @empty
                    <h4 class="center grey-text text-darken-2">No Products to Display!</h4>
                @endforelse
            </div>
            <br><br>
            <div class="center-align">
                {{$products->appends(request()->query())->links('vendor.pagination.default',['items' => $products])}}
            </div>
        </div>
        <div class="col s12 m6 offset-m3 l3">
            <ul class="collection with-header">
                <li class="collection-header">
                    <h5 class="center">Categories</h5>
                </li>
                @forelse($categories as $category)
                    <a href="{{route('products',
                            [
                                'category' => $category->slug,
                                'sort_by' => request()->sort_by,
                                'items_per_page' => request()->items_per_page
                            ]
                        )}}" class="collection-item grey-text text-uppercase">
                        {{$category->title}}
                    </a>
                @empty
                    <a href="#" class="collection-item">No Categories yet!</a>
                @endforelse
                <a href="{{route('products',
                        [
                            'category' => 'all',
                            'sort_by' => request()->sort_by,
                            'items_per_page' => request()->items_per_page
                        ]
                    )}}" class="collection-item grey-text text-uppercase">
                    All
                </a>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $('#sort-option').on('property change',function(){
            $('#sort-form').submit();
        });
        $('#items-option').on('property change',function(){
            $('#items-form').submit();
        });
    </script>
@endsection