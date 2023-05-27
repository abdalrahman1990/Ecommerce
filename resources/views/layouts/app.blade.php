<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{asset('css/materialize.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @yield('css')
    @if(auth::guard('admin')->check())
        <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    @endif
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <title>Laracart | The Best Online Store Like Ever...</title>
</head>
<body>

    {{-- Include the Navbar --}}
    <header>

        @if(Auth::guard('admin')->check())
            {{-- Admin Navbar --}}
            @include('admin.inc.navbar')
        @else
            {{-- Normal user Navbar --}}
            @include('inc.navbar')
        @endif
    </header>

    <main>
        <br><br>
        {{-- Page content here --}}
        @yield('content')
        <br><br>
    </main>

    {{-- Footer here --}}
    @include('inc.footer')

    {{-- Javascript --}}
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/materialize.min.js')}}"></script>
    <script src="{{asset('js/app.min.js')}}"></script>

    {{-- Show toasts, if there are any --}}
    @include('inc.message')

    {{-- javascript from a view that's extending this layout --}}
    @yield('script')

</body>
</html>