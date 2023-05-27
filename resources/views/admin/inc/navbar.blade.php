<nav class="nav-wrapper bg">
    <div class="container-fluid">
        <a href="{{route('index')}}" class="brand-logo">LARACART</a>
        <ul class="show-on-med-and-small">
            <li class="waves-effect">
                <a href="#" data-target="sidenav" class="sidenav-trigger waves-effect"><i class="material-icons">menu</i></a>
            </li>
        </ul>
        <ul class="hide-on-med-and-down right">
            <li>
                <a href="#" class="dropdown-trigger" data-target="admin-dropdown">
                    {{Auth::guard('admin')->user()->name}}
                    <i class="material-icons right mt-3">arrow_drop_down</i>
                </a>
            </li>
        </ul>
        {{-- dropdown for admin --}}
        <ul id='admin-dropdown' class='dropdown-content'>
            <li>
                <a href="{{route('admin.profile')}}" class="purple-text text-lighten-2">Profile</a>
            </li>
            <li class="divider"></li>
            <li>
                {{-- this link submits a hidden form to log users out --}}
                <a href="#" onclick="this.preventDefault;document.querySelector('#admin-logout').submit()" class="purple-text text-lighten-2">Logout</a>
                <form action="{{route('admin.logout')}}" method="post" class="hide" id="admin-form">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>

{{-- Include SideNav that's appropriate for admin --}}
    @include('admin.inc.sidenav')