<nav class="bg" id="navbar">
    <div class="nav-wrapper">
        <div class="container-fluid">
            <a href="{{route('index')}}" class="brand-logo">LARACART</a>
            <ul class="show-on-med-and-small">
                <li class="waves-effect">
                    <a href="#" data-target="sidenav" class="sidenav-trigger waves-effect"><i class="material-icons">menu</i></a>
                </li>
            </ul>
            <ul class="hide-on-med-and-down right">
                <li class="waves-effect">
                    <a href="{{route('index')}}">Home</a>
                </li>
                <li class="waves-effect">
                    <a href="{{route('products')}}">Products</a>
                </li>
                <li class="waves-effect">
                    <a href="{{route('about')}}">About</a>
                </li>
                @auth
                    <li>
                        <a href="#" class="dropdown-trigger" data-target="user-dropdown">
                            {{Auth::user()->name}}
                            <i class="material-icons right">arrow_drop_down</i>
                        </a>
                    </li>
                    <ul id='user-dropdown' class='dropdown-content no-constrain'>
                        <li>
                            <a href="{{route('profile')}}" class="purple-text text-lighten-2">Profile</a>
                        </li>
                        <li>
                            <a href="{{route('order.index')}}" class="purple-text text-lighten-2">Order History</a>
                        </li>
                        <li>
                            <a href="{{route('wishlist.index')}}" class="purple-text text-lighten-2">My Wishlist</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            {{-- this link submits a hidden form to log users out --}}
                            <a href="#" onclick="this.preventDefault;document.querySelector('#user-logout').submit()" class="purple-text text-lighten-2">Logout</a>
                            <form action="{{route('logout')}}" method="post" class="hide" id="user-logout">
                                @csrf
                            </form>
                        </li>
                    </ul>
                @else
                    <li>
                        <a href="#" class="dropdown-trigger" data-target="auth-dropdown">
                            <i class="material-icons">person</i>
                        </a>
                    </li>
                    <ul id='auth-dropdown' class='dropdown-content'>
                        <li class="waves-effect">
                            <a href="{{route('login')}}" class="purple-text text-lighten-2">Login</a>
                        </li>
                        <li class="waves-effect">
                            <a href="{{route('register')}}" class="purple-text text-lighten-2">Register</a>
                        </li>
                    </ul>
                @endauth
                <li class="waves-effect">
                    <a href="{{route('cart.index')}}" class="val">
                        <i class="material-icons left">shopping_cart</i>
                        <span class="cart-count">({{Cart::count()}})</span>
                    </a>
                </li>
                <li id="search-box">
                    <form action="{{route('search')}}" id="search-form">
                        <div>
                            <a href="#" id="search-icon" class="left">
                                <i class="material-icons grey-text">search</i>
                            </a>
                            <input type="search" name="search" id="search" required class="browser-default" placeholder="Search Products">
                            <a href="#" id="search-close" class="right">
                                <i class="material-icons transparent-text close-icon">close</i>
                            </a>
                        </div>
                        <ul id="search-results" class="collection z-depth-2 grey lighten-4 grey-text text-darken-2"></ul>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
@include('inc.sidenav')