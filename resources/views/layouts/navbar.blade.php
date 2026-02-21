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
                            <li><a class="dropdown-item" href="{{ url('two-wheeler-battery') }}">Two Wheeler Battery</a></li>
                            <li><a class="dropdown-item" href="{{ url('three-wheeler-battery') }}">Three Wheeler Battery</a></li>
                            <li><a class="dropdown-item" href="{{ url('traction-battery') }}">Traction Battery</a></li>
                            <li><a class="dropdown-item" href="{{ url('portable-power-solution') }}">Portable Power Solution</a></li>
                            <li><a class="dropdown-item" href="{{ url('solar-battery') }}">Solar Battery</a></li>
                            <li><a class="dropdown-item" href="{{ url('cycle-battery') }}">Cycle Battery</a></li>
                            <li><a class="dropdown-item" href="{{ url('energy-solution-system') }}">Energy Solution System</a></li>
                            <li><a class="dropdown-item" href="{{ url('ess-commercial-industrial') }}">ESS for Commercial Industry</a></li>
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
                    {{-- AUTH SECTION --}}

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
                    {{-- User Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->avatar_url ?? asset('img/default-avatar.png') }}"
                                class="rounded-circle me-1" style="width: 24px; height: 24px; object-fit: cover;">
                            {{ auth()->user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @if(auth()->user()->role === 'admin')
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Admin Panel
                                </a>
                            </li>
                            @else
                            <li>
                                <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                    <i class="fas fa-box me-2"></i>My Orders
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('user.addresses.index') }}">
                                    <i class="fas fa-map-marker-alt me-2"></i>Addresses
                                </a>
                            </li>
                            @endif

                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit me-2"></i>Profile
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
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