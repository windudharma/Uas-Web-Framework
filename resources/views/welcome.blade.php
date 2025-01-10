@extends('layouts.master')


@section('content')

   <!-- Navbar -->
<nav class="navbar navbar-expand-md navbar-light bg-transparent" style="position: absolute; width: 100%;">
    <div class="container-fluid">
        <!-- Logo -->
        <a href="/" class="navbar-brand px-4">
            <img src="/storage/uploads/logo/white.png" alt="LOGO" style="height: 40px;">
        </a>

        <!-- Navbar Items -->
        <div class="d-flex align-items-center ms-auto">
            <!-- Harga Link -->
            <a class="nav-link text-white me-4" href="/#price" style="text-decoration: none;">Harga</a>

            <!-- Login/Dropdown -->
            @if (Route::has('login'))
                <div>
                    @auth
                        <!-- Dropdown Menu -->
                        <div class="dropdown">
                            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->profile_photo_url }}"alt="Avatar" class="rounded-circle"
                                style="width: 48px; height: 48px;" />

                            </button>

                            <!-- Dropdown Content -->
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 300px;">
                                <!-- User Info -->
                                <li class="px-4 py-3 d-flex align-items-center border-bottom">
                                    <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://via.placeholder.com/60' }}"
                                         alt="Avatar"
                                         class="rounded-circle"
                                         style="width: 48px; height: 48px;">
                                    <div class="ms-3">
                                        <p class="mb-0 fw-bold text-dark">{{ Auth::user()->name }}</p>
                                        <p class="mb-0 text-muted small">{{ Auth::user()->email }}</p>
                                    </div>
                                </li>

                                <!-- Menu Items -->
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">{{ __('Download') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('subscription') }}">{{ __('Subscription') }}</a></li>
                                @if (auth()->user() && auth()->user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('assets.index') }}">{{ __('Assets') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('transaksi') }}">{{ __('Transaksi') }}</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>

                                <!-- Divider -->
                                <li><hr class="dropdown-divider"></li>

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
                        <a href="{{ url('/login') }}" class="btn btn-outline-light btn-sm px-4 ">
                            {{ __('Log in') }}
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </div>
</nav>



    <!-- Header -->
    <div class="header">
        <h1>Tingkatkan Kreativitas Anda</h1>

        <p>tersedia semua yang anda butuhkan, mulai dari asset hingga template grafis</p>
        <form action="{{ route('search') }}" method="GET">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="aset" placeholder="Search all assets" class="search-input"
                    value="{{ request()->input('aset') }}">
            </div>
            <button type="submit" style="display: none;">Cari</button> <!-- Button disembunyikan -->
        </form>
    </div>

    <!-- Cards Section -->
    <div class="container card-container">
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-3">
                <div class="card">
                    <img src="/storage/uploads/images/card1.jpg"
                        alt="Asset Gambar Alam">
                    <div class="card-body">
                        <h5 class="card-title">Ice Lake</h5>
                        <p class="card-text">A serene icy lake reflects a pink and purple sunset, framed by snow-capped mountains, nature's  breathtaking masterpiece</p>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-3">
                <div class="card">
                    <img src="/storage/uploads/images/card2.jpg"
                        alt="Asset Gambar Alam">
                    <div class="card-body">
                        <h5 class="card-title">Eye Illustration</h5>
                        <p class="card-text">A bold black-and-white close-up of an eye, with dramatic lashes and a reflective iris, radiating mystery and allure</p>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-3">
                <div class="card">
                    <img src="/storage/uploads/images/card3.jpg"
                        alt="Asset Gambar Alam">
                    <div class="card-body">
                        <h5 class="card-title">Abstract Cats</h5>
                        <p class="card-text">Two abstract cats in bold shades of green, white, and black. The minimalist design create a sleek, modern vibe.</p>
                    </div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="col-md-3">
                <div class="card">
                    <img src="/storage/uploads/images/card4.jpg"
                        alt="Asset Gambar Alam">
                    <div class="card-body">
                        <h5 class="card-title">Bird's Eye</h5>
                        <p class="card-text">An intense close-up of a bird's eye reveals sharp detail and vibrant color, capturing the essence of wild beauty and focus.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container container-asset">
        <h1>Favorit Desainer</h1>
        <p class="description"> Lihat Yang Paling Banyak diunduh pengguna</p>

        @if ($assets->isEmpty())
            <p>Tidak ada hasil yang ditemukan.</p>
        @else
            <div class="masonry py-3">
                @foreach ($assets as $asset)
                    <div class="mItem">
                        <img class="clickable-image" src="{{ asset('storage/' . $asset->gambar) }}"
                            alt="{{ $asset->nama_aset }}" data-id="{{ $asset->id }}"
                            data-nama="{{ Str::slug($asset->nama_aset) }}" data-target="#imageModal{{ $asset->id }}">
                    </div>
                    @include('layouts.asetpopup')
                @endforeach
            </div>
        @endif
    </div>



    <div class="container container-asset" id="price">

        <h1>Pricing</h1>
        <p class="description">
            Dapatkan akses alat desain yang mudah digunakan, dan konten stok Premium.<br>
            Semua dengan satu langganan.
        </p>


        <div class="pricing-container">
            @foreach ($memberships as $membership)
                <div class="pricing-card">
                    @if ($membership->is_popular)
                        <div class="popular">POPULAR</div>
                    @endif
                    <h2>{{ $membership->name }}</h2>
                    <div class="price">Rp. {{ number_format($membership->price, 0, ',', '.') }}</div>

                    @if (!$activeMembership)
                        <!-- Belum membeli paket -->
                        <form action="{{ route('membership.checkout', $membership->id) }}" method="GET">

                            <button type="submit" class="button">Pesan Sekarang</button>
                        </form>
                    @elseif ($activeMembership->membership_id == $membership->id)
                        <!-- Paket saat ini -->
                        <form action="{{ route('membership.checkout', $membership->id) }}" method="GET">
                            <button type="submit" class="button">Perpanjang</button>
                        </form>
                    @elseif ($activeMembership->membership_id < $membership->id)
                        <!-- Paket upgrade -->
                        <form action="{{ route('membership.checkout', $membership->id) }}" method="GET">
                            <button type="submit" class="button">Upgrade Paket</button>
                        </form>
                    @else
                        <!-- Paket lebih rendah atau tidak bisa di klik -->
                        <button class="button disabled" disabled>Pesan Sekarang</button>
                    @endif

                    <ul class="features">
                        <li>Akses Semua Aset Premium</li>
                        <li>{{ $membership->daily_limit }} Download / Hari</li>
                        <li>Aktif {{ $membership->duration_days }} Hari</li>
                    </ul>
                </div>
            @endforeach


        </div>
    </div>

    <!-- Modal Login -->
    <div id="customModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeModal">&times;</span>
            <div id="modalBody"> <!-- Konten akan dimuat di sini -->
                <!-- Konten login akan dimuat secara dinamis -->
            </div>
        </div>
    </div>


@endsection
