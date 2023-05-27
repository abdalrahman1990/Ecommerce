@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <h4 class="center">
                        @if($title)
                            {{$title}}
                        @else
                            Product Reviews
                        @endif    
                    </h4>
                    <br>
                    <form action="{{route('admin.reviews.index')}}">
                        <div class="row">
                            <div class="input-field col s12 m6 login-field">
                                <input type="text" name="search" id="re-search" value="{{request()->search}}">
                                <label for="re-search">Search</label>
                            </div>
                            <div class="input-field col s12 m4 login-field">
                                <select name="option" id="option">
                                    <option value="customer_name" {{(request()->option == "customer_name") ? 'selected' : ''}}>Customer Name</option>
                                    <option value="product_name" {{(request()->option == "product_name") ? 'selected' : ''}}>Product Name</option>
                                    <option value="rating" {{(request()->option == "rating") ? 'selected' : ''}}>Rating</option>
                                </select>
                            </div>
                            <br>
                            <button type="submit" class="btn col s12 m2 bg2">Search</button>
                        </div>
                    </form>
                    <table class="responsive-table centered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Product Name</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $review)
                                <tr>
                                    <td class="val">{{$review->id}}</td>
                                    <td class="val">{{$review->user->name}}</td>
                                    <td class="val">{{$review->product->title}}</td>
                                    <td class="val">{{$review->rating}}</td>
                                    <td>{{($review->status) ? 'Enabled' : 'Disabled' }}</td>
                                    <td>{{$review->created_at->diffForHumans()}}</td>
                                    <td>{{$review->updated_at->diffForHumans()}}</td>
                                    <td>
                                        <div class="center">
                                            <a href="{{route('admin.reviews.show',$review->id)}}" class="btn-floating btn-small tooltipped waves-effect waves-light" data-position="left" data-tooltip="Review Details">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <a href="#delete-modal-{{$review->id}}" class="modal-trigger btn-floating btn-small red tooltipped red waves-effect waves-light" data-position="left" data-tooltip="Delete Review">
                                                <i class="material-icons">delete</i>
                                            </a>
                                            @component('components.confirm',[
                                                'id'    => 'delete-review-'.$review->id,
                                                'modal' => 'delete-modal-'.$review->id,
                                                'title' => 'Review'
                                            ])
                                            @endcomponent
                                            <form action="{{route('admin.reviews.destroy',$review->id)}}" method="post" class="hide" id="delete-review-{{$review->id}}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="center">No Reviews Found!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <br>
                    <div class="center-align">
                        @if($title)
                            <a href="{{route('admin.reviews.index')}}" class="btn waves-effect">View All</a>
                            <br>
                        @endif
                        {{$reviews->appends(request()->query())->links('vendor.pagination.default',[
                            'items' => $reviews
                        ])}}
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
@endsection