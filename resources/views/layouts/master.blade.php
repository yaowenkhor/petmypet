<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1">
    <title>@yield('title', 'PetMyPet')</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Your custom CSS should come after Bootstrap -->
    @yield('page-specific-css')
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #6a0dad;">
            <div class="container-fluid d-flex justify-content-between align-items-center px-5">
                <!-- Left side: Brand -->
                <div class="d-flex align-items-center">
                    <a class="navbar-brand mb-0 h1 fw-normal d-flex align-items-center" href="{{ route('pet.index') }}"
                        style="font-family: 'Quicksand', 'Verdana', sans-serif;">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="logo" class="me-2"
                            style="height: 30px; width: auto; border-radius: 10px;">
                        PetMyPet
                    </a>
                </div>

                <!-- Right side: Nav links -->
                <div>
                    <ul class="navbar-nav flex-row">
                        <li class="nav-item me-4">
                            <a class="nav-link" href="{{ route('pet.index') }}">Home</a>
                        </li>

                        @if (Auth::guard('adopter')->check() || Auth::guard('organization')->check() || Auth::guard('admin')->check())
                            <li class="nav-item me-4">
                                @if (Auth::guard('adopter')->check())
                                    <a class="nav-link" href="{{ route('adopter.home') }}">Profile</a>
                                @elseif (Auth::guard('organization')->check())
                                    <a class="nav-link" href="{{ route('organization.home') }}">Profile</a>
                                @elseif (Auth::guard('admin')->check())
                                    <a class="nav-link" href="{{ route('admin.home') }}">Dashboard</a>
                                @endif
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/login') }}">Login</a>
                            </li>
                        @endif
                    </ul>
                </div>
                </img>
        </nav>
    </header>



    <main class="py-4">
        @yield('content')
    </main>

</body>

</html>