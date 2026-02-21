@include('layouts.admin-header')

@include('layouts.admin-navbar')

{{-- Sidebar --}}
@include('layouts.admin-sidebar')

{{-- Main Content --}}
<div class="admin-main-content">
    @yield('content')
</div>

@include('layouts.admin-footer')
