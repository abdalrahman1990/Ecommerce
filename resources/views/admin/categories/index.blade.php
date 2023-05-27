@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card-panel">
                <h4 class="center">
                    @if($title)
                        {{$title}}
                    @else
                        Category List
                    @endif
                </h4>
                <br>
                <form action="{{route('admin.categories.index')}}">
                    <div class="row">
                        <div class="input-field col s12 m6 offset-m2 login-field">
                            <input type="text" name="search" id="re-search">
                            <label for="re-search">Category Name</label>
                        </div>
                        <br>
                        <button type="submit" class="btn col s12 m2 bg2">Search</button>
                    </div>
                </form>
                <br>
                <table class="responsive-table centered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$category->id}}</td>
                                <td>{{$category->title}}</td>
                                <td>{{$category->created_at->diffForHumans()}}</td>
                                @if($category->updated_at)
                                    <td>{{$category->updated_at->diffForHumans()}}</td>
                                @else
                                    <td>Not updated</td>
                                @endif
                                <td>
                                    <a href="{{route('admin.categories.edit',$category->id)}}" class="btn-floating btn-small waves-effect waves-light tooltipped" data-position="right" data-tooltip="Update Category!">
                                        <i class="material-icons">refresh</i>
                                    </a>
                                    @if($category->products->count())
                                        <a href="#delete-modal-{{$category->id}}" class="disabled btn-floating btn-small waves-effect red modal-trigger waves-light">
                                            <i class="material-icons">delete</i>
                                        </a>
                                    @else
                                        <a href="#delete-modal-{{$category->id}}" class="btn-floating btn-small waves-effect red modal-trigger waves-light tooltipped" data-position="left" data-tooltip="Delete Category!">
                                            <i class="material-icons">delete</i>
                                        </a>
                                        @component('components.confirm',[
                                            'id' => 'delete-form-'.$category->id,
                                            'modal' => 'delete-modal-'.$category->id,
                                            'title' => 'Category'
                                        ])
                                        @endcomponent
                                        <form action="{{route('admin.categories.destroy',$category->id)}}" method="post" class="hide" id="delete-form-{{$category->id}}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="center">No Categories to Display!</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <br><br>
                <div class="center-align">
                    @if($title)
                        <a href="{{route('admin.categories.index')}}" class="btn waves-effect">View All</a>
                        <br>
                    @endif
                    {{$categories->appends(request()->query())->links('vendor.pagination.default',[
                        'items' => $categories
                    ])}}
                </div>
                <br>
            </div>
            <div class="fixed-action-btn">
                <a href="{{route('admin.categories.create')}}" class="btn-floating btn-large waves-effect waves-light red">
                    <i class="large material-icons">add</i>
                </a>
            </div>
        </div>
    </div>
@endsection