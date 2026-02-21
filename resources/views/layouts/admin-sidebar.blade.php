    <!-- Sidebar -->
    <nav class="admin-sidebar bg-dark text-white">
        <h4 class="text-center mb-4 fw-bold text-white">
            <i class="fas fa-user-shield me-2 text-white"></i> Admin Panel
        </h4>

        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('category.index') }}"
                    class="nav-link {{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group me-2"></i> Product Categories
                </a>
            </li>

              <li class="nav-item">
                <a href="{{ route('product.index') }}"
                    class="nav-link {{ request()->routeIs('admin.product.*') ? 'active' : '' }}">
                    <i class="fas fa-box-open me-2"></i> Products
                </a>
            </li>

              <li class="nav-item">
                <a href="#"
                    class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart me-2"></i> Orders
                </a>
            </li>

             <li class="nav-item">
                <a href="{{ route('coupons.index') }}"
                    class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt me-2"></i> Coupons
                </a>
            </li>

               <li class="nav-item">
                <a href="#"
                    class="nav-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                    <i class="fas fa-blog me-2"></i> Blog
                </a>
            </li>


            <li class="nav-item mt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </li>
            
        </ul>
    </nav>