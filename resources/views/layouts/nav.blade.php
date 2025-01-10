    <!-- Navbar -->
    <nav class="navbar navbar-expand-md py-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <h2>
                    <a href="/">
                        <img src="/storage/uploads/logo/black.png" alt="LOGO" class="navbar-brand px-4">
                    </a>
                </h2>
                <form action="{{ route('search') }}" method="GET">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="aset" placeholder="Search all assets" class="search-input"
                            value="{{ request()->input('aset') }}">
                    </div>
                    <button type="submit" style="display: none;">Cari</button> <!-- Button disembunyikan -->
                </form>

            </div>
            <!-- Navbar Items -->
            <div class="d-flex align-items-center ms-auto">
                <!-- Harga Link -->
                <a class="nav-link me-4" href="/#price" style="text-decoration: none;">Harga</a>

                <!-- Login/Dropdown -->
                @if (Route::has('login'))
                    <div>
                        @auth
                            <!-- Dropdown Menu -->
                            <div class="dropdown">
                                <button class="btn btn-link p-0" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ Auth::user()->profile_photo_url }}"alt="Avatar" class="rounded-circle"
                                        style="width: 48px; height: 48px;" />

                                </button>

                                <!-- Dropdown Content -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                    style="min-width: 300px;">
                                    <!-- User Info -->
                                    <li class="px-4 py-3 d-flex align-items-center border-bottom">
                                        <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://via.placeholder.com/60' }}"
                                            alt="Avatar" class="rounded-circle" style="width: 48px; height: 48px;">
                                        <div class="ms-3">
                                            <p class="mb-0 fw-bold text-dark">{{ Auth::user()->name }}</p>
                                            <p class="mb-0 text-muted small">{{ Auth::user()->email }}</p>
                                        </div>
                                    </li>

                                    <!-- Menu Items -->
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">{{ __('Download') }}</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('subscription') }}">{{ __('Subscription') }}</a></li>
                                    @if (auth()->user() && auth()->user()->role === 'admin')
                                        <li><a class="dropdown-item"
                                                href="{{ route('assets.index') }}">{{ __('Assets') }}</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('transaksi') }}">{{ __('Transaksi') }}</a></li>
                                    @endif
                                    <li><a class="dropdown-item"
                                            href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>

                                    <!-- Divider -->
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <!-- Log Out -->
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <!-- Login Button -->
                            <a href="{{ url('/login') }}" class="btn btn-outline-dark btn-sm px-4 ">
                                {{ __('Log in') }}
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>
