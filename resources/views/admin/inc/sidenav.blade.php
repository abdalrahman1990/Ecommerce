<ul id="sidenav" class="sidenav sidenav-fixed grey lighten-4">
    <li>
        <div class="user-view">
            <div class="background">
                <img src="{{asset('images/mt-bg.jpg')}}" width="100%" height="100%" alt="">
            </div>
            {{-- Get the picture of authenicated user from gravatar --}}
            <a href="{{route('admin.profile')}}"><img class="circle" src="{{Auth::guard('admin')->user()->gravatar}}"></a>
            {{-- Get the name of authenicated user --}}
            <a href="{{route('admin.profile')}}"><span class="white-text name">{{ Auth::guard('admin')->user()->name }}</span></a>
            {{-- Get the email of authenicated user --}}
            <a href="{{route('admin.profile')}}"><span class="white-text email">{{ Auth::guard('admin')->user()->email }}</span></a>
        </div>
    </li>
    <li>
        <a href="{{route('admin.dashboard')}}" class="waves-effect grey-text text-darken-1" onclick="this.preventDefault;document.querySelector('#admin-logout').submit()">
            <i class="material-icons grey-text text-darken-1">dashboard</i>
            Dashboard
        </a>
    </li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header waves-effect grey-text text-darken-1">
                <i class="material-icons pl-15 grey-text text-darken-1">shop</i>
                <span class="pl-15">Manage Store</span>
            </a>
            <div class="collapsible-body">
              <ul>
                <li>
                    <a href="{{route('admin.products.index')}}" class="grey-text text-darken-1">
                        <i class="material-icons">shopping_basket</i>
                        Manage Products
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.categories.index')}}" class="grey-text text-darken-1">
                        <i class="material-icons">apps</i>
                        Manage Categories
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.customers.index')}}" class="waves-effect waves-light grey-text text-darken-1">
                        <i class="material-icons">supervisor_account</i>
                        Manage Customers
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.cities.index')}}" class="grey-text text-darken-1">
                        <i class="material-icons">location_city</i>
                        Manage Cities
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.reviews.index')}}" class="grey-text text-darken-1">
                        <i class="material-icons">rate_review</i>
                        Product Reviews
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.contacts.index')}}" class="grey-text text-darken-1">
                        <i class="material-icons">message</i>
                        Contact Messages
                    </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
    </li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header waves-effect grey-text text-darken-1">
                <i class="material-icons pl-15 grey-text text-darken-1">local_grocery_store</i>
                <span class="pl-15">Manage Sales</span>
            </a>
            <div class="collapsible-body">
              <ul>
                <li>
                    <a href="{{route('admin.orders.index')}}" class="waves-effect waves-light grey-text text-darken-1">
                        <i class="material-icons">collections_bookmark</i>
                        Manage Orders
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.payments.index')}}" class="waves-effect waves-light grey-text text-darken-1">
                        <i class="material-icons">credit_card</i>
                        Manage Payments
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.addresses.index')}}" class="waves-effect waves-light grey-text text-darken-1">
                        <i class="material-icons">business</i>
                        Manage Addresses
                    </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
    </li>
    <li>
        <a href="{{route('admin.reports.index')}}" class="waves-effect grey-text text-darken-1">
            <i class="material-icons grey-text text-darken-1">chrome_reader_mode</i>
            Reports
        </a>
    </li>
    <li class="show-on-med-and-small hide-on-large-only divider"></li>
    <li class="show-on-med-and-small hide-on-large-only">
        <a href="#" class="waves-effect grey-text text-darken-1" onclick="this.preventDefault;document.querySelector('#admin-logout').submit()">
            <i class="material-icons grey-text text-darken-1">exit_to_app</i>
            Logout
        </a>
        <form action="{{route('admin.logout')}}" class="hide" id="admin-logout" method="post">
            @csrf
        </form>
    </li>
</ul>