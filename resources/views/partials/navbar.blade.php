<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <!-- Brand/Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <i class="fas fa-camera text-primary"></i>
            <span class="fw-bold">Foto</span><span class="text-primary fw-bold">Rental</span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Left Side -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}" href="{{ route('catalog.index') }}">
                        <i class="fas fa-camera"></i> Katalog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="fas fa-info-circle"></i> Tentang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                        <i class="fas fa-envelope"></i> Kontak
                    </a>
                </li>
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav align-items-lg-center gap-lg-2">
                @auth
                    {{-- Admin dropdown (opsional, tetap ada kalau admin) --}}
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-crown text-warning"></i> Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.equipment.index') }}">
                                        <i class="fas fa-camera me-2"></i> Kelola Peralatan
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.rentals.index') }}">
                                        <i class="fas fa-list me-2"></i> Kelola Penyewaan
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                        <i class="fas fa-users me-2"></i> Kelola User
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.reports') }}">
                                        <i class="fas fa-chart-bar me-2"></i> Laporan
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- User dropdown (INI yang kamu minta kembali) --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2"
                                 style="width: 32px; height: 32px;">
                                <span class="text-white small fw-bold">
                                    {{ method_exists(auth()->user(), 'getInitials') ? auth()->user()->getInitials() : strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li class="px-3 py-2">
                                <div class="fw-bold">{{ auth()->user()->name }}</div>
                                <div class="text-muted small">{{ auth()->user()->email }}</div>
                                @if(isset(auth()->user()->role))
                                    <div class="mt-1">
                                        <span class="badge bg-warning text-dark">
                                            {{ auth()->user()->role }}
                                        </span>
                                    </div>
                                @endif
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-home me-2"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('rentals.my') }}">
                                    <i class="fas fa-history me-2"></i> Penyewaan Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit me-2"></i> Edit Profil
                                </a>
                            </li>

                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2 text-warning"></i> Admin Dashboard
                                    </a>
                                </li>
                            @endif

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    </li>
                @endauth
            </ul>

            <!-- Search Form -->
            <form class="d-flex ms-lg-3 mt-3 mt-lg-0" action="{{ route('catalog.index') }}" method="GET">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" name="search" placeholder="Cari peralatan..." value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

        </div>
    </div>
</nav>

<style>
    .navbar { padding: 0.75rem 0; }
    .nav-link { border-radius: .25rem; transition: all .2s; }
    .nav-link:hover { background-color: rgba(0, 123, 255, 0.08); }
    .nav-link.active { color: #0d6efd !important; font-weight: 600; background-color: rgba(13, 110, 253, 0.08); }

    .dropdown-menu {
        border: 1px solid #e9ecef;
        box-shadow: 0 .15rem 1.25rem rgba(0,0,0,.08);
        border-radius: .5rem;
    }
</style>
