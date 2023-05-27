<table class="responsive-table centered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created at</th>
            <th>Updated at</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at->diffForHumans()}}</td>
                <td>{{$user->updated_at->diffForHumans()}}</td>
            </tr>
        @empty
            <tr>
                <td></td>
                <td></td>
                <td class="center">No Customers Found!</td>
                <td></td>
                <td></td>
            </tr>
        @endforelse
    </tbody>
</table>
<br>
<div class="center-align">
    {{$users->appends(request()->query())->links('vendor.pagination.default',['item' => $users])}}
</div>