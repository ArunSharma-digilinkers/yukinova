<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container-fluid">

            <!-- Logo -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="img-fluid logo-img" width="150">
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ms-auto align-items-lg-center">

                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('about-us') }}">About Us</a>
                    </li>

                    <!-- Products Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            Products
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Two Wheeler Battery</a></li>
                            <li><a class="dropdown-item" href="#">Three Wheeler Battery</a></li>
                            <li><a class="dropdown-item" href="#">Traction Battery</a></li>
                            <li><a class="dropdown-item" href="#">Portable Power Solution</a></li>
                            <li><a class="dropdown-item" href="#">Solar Battery</a></li>
                            <li><a class="dropdown-item" href="#">Cycle Battery</a></li>
                            <li><a class="dropdown-item" href="#">Energy Solution System</a></li>
                            <li><a class="dropdown-item" href="#">ESS for Commercial Industry</a></li>
                        </ul>
                    </li>

                    <!-- Industry Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            Industry Serve
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Automotive Battery</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('contact-us') }}">Contact Us</a>
                    </li>

                    <!-- CART ICON -->
                    <li class="nav-item position-relative ms-lg-3">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="cart-count">
                                {{ session('cart') ? count(session('cart')) : 0 }}
                            </span>
                        </a>
                    </li>

                    <!-- AUTH SECTION -->
                    @guest
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fa-regular fa-user"></i> Login
                            </a>
                        </li>

                        <li class="nav-item ms-lg-2">
                            <a class="nav-link btn-register" href="{{ route('register') }}">
                                Register
                            </a>
                        </li>
                    @endguest

                    @auth
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fa-regular fa-user"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Dashboard</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth

                </ul>

            </div>
        </div>
    </nav>
</header>
