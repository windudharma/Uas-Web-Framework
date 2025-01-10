@extends('layouts.master')

@section('content')
    @include('layouts.nav')

    <hr class="border border-1 border-dark">

    <div class="container card-search py-5">
        <h3>Menampilkan hasil untuk <b>{{ request()->input('aset') }}</b></h3>

        @if ($assets->isEmpty())
            <h1 class="mt-5">Tidak ada hasil yang ditemukan.</h1>
            <p>Lihat pilihan populer yang sering diunduh oleh pengguna kami.</p>

            @if ($recommendedAssets->isNotEmpty())
                <div class="masonry py-3">
                    @foreach ($recommendedAssets as $asset)
                    <div class="mItem">
                        <img class="clickable-image"
                             src="{{ asset('storage/' . $asset->gambar) }}"
                             alt="{{ $asset->nama_aset }}"
                             data-id="{{ $asset->id }}"
                             data-nama="{{ Str::slug($asset->nama_aset) }}"
                             data-target="#imageModal{{ $asset->id }}">
                    </div>
                    @include('layouts.asetpopup')
                    @endforeach
                </div>
            @else
                <p>Tidak ada rekomendasi aset yang dapat ditampilkan saat ini.</p>
            @endif
        @else
            <div class="masonry py-3">
                @foreach ($assets as $asset)
                    <div class="mItem">
                        <img class="clickable-image"
                             src="{{ asset('storage/' . $asset->gambar) }}"
                             alt="{{ $asset->nama_aset }}"
                             data-id="{{ $asset->id }}"
                             data-nama="{{ Str::slug($asset->nama_aset) }}"
                             data-target="#imageModal{{ $asset->id }}"> <!-- Menambahkan data-target dengan ID modal dinamis -->
                    </div>
                    @include('layouts.asetpopup')
                @endforeach
            </div>
            {{ $assets->links('vendor.pagination.bootstrap-5') }}
        @endif
    </div>
@endsection
