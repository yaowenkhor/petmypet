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
                <a class="navbar-brand mb-0 h1 fw-normal" href="#">PetMyPet</a>

                <!-- Right side: Nav links -->
                <div>
                    <ul class="navbar-nav flex-row">
                        <li class="nav-item me-4">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>

                        @if (Auth::guard('adopter')->check() || Auth::guard('organization')->check() || Auth::guard('admin')->check())
                            <li class="nav-item me-4">
                                <a class="nav-link" href="#">Profile</a>
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
            </div>
        </nav>
    </header>



    <main class="py-4">
        @yield('content')
    </main>

</body>

</html>