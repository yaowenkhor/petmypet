<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1">
    <title>@yield('title', 'PetMyPet')</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Your custom CSS should come after Bootstrap -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<body>

    <header class="header">
        <div class="wrapper">

            <h1>PetMyPet</h1>

            <nav class="menu">
                <a href="{{ route('home') }}">Home</a>

                @if(Auth::guard('adopter')->check() || Auth::guard('organization')->check() || Auth::guard('admin')->check())
                    <a href="#">Profile</a>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        Logout
                    </a>
                @else
                    <a href="{{ url('/login') }}">Login</a>
                @endif
            </nav>

        </div>

    </header>

    <div class="content">
        @yield('content')
    </div>

</body>

</html>
