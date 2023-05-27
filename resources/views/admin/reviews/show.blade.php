@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">                
                <ul class="collection with-header">
                    <li class="collection-header">
                        <h4 class="center">Review Details</h4>        
                    </li>
                    <li class="collection-item">
                        <div class="section">
                            <h6 class="grey-text text-darken-3">Customer Name :</h6>
                            <span>{{$review->user->name}}</span>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="section">
                            <h6 class="grey-text text-darken-3">Product Name :</h6>
                            <span>
                                <a href="{{route('admin.products.show',$review->product->id)}}">{{$review->product->title}}</a>
                            </span>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="section">
                            <h6 class="grey-text text-darken-3">Rating :</h6>
                            <span class="star">
                                @component('components.review-count',[
                                    'product' => $review->product
                                ])
                                @endcomponent
                            </span>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="section">
                            <h6 class="grey-text text-darken-3">Review Status :</h6>
                            <span>{{($review->status ? 'Enabled' : 'Disabled')}}</span>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div class="section">
                            <h6 class="grey-text text-darken-3">Reviewed at :</h6>
                            <span>{{$review->created_at->diffForHumans()}}</span>
                        </div>
                    </li>
                    <li class="collection-item">
                        <br>
                        <div class="row">
                            <div class="col s12 m6 l6 xl6 row">
                                <a href="{{route('admin.reviews.edit',$review->id)}}" class="btn pink lighten-1 waves-effect waves-light col s8 offset-s2">
                                    Update
                                </a>
                            </div>
                            @component('components.confirm',[
                                'id'    => 'delete-form',
                                'modal' => 'deleteModal',
                                'title' => 'Review'
                            ])
                            @endcomponent
                            <div class="col s12 m6 l6 xl6 row">
                                <a href="#deleteModal" class="btn red waves-effect waves-light col  s8 offset-s2 modal-trigger">
                                    Delete
                                </a>
                            </div>
                            <form action="{{route('admin.reviews.destroy',$review->id)}}" method="post" class="hide" id="delete-form">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </li>
                </ul>
                <br>
                <a href="{{route('admin.reviews.index')}}" class="btn-flat waves-effect blue-text">Go Back</a>
            </div>
        </div>
    </div>
</div>
@endsection