@extends('layouts.master')

@section('content')

@include('layouts.nav')

<hr class="border border-1 border-dark" style="margin-bottom: 50px">

<div class="container py-5">
    <div class="d-flex justify-content-center">
        <div class="card shadow-sm" style="width: 90%; max-width: 450px;">
            <div class="card-header bg-primary text-white text-center" style="padding: 20px 0;">
                <h4 class="mb-0" style="font-weight: bold; font-size: 1.5rem;">Konfirmasi Paket Membership</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title text-center mb-4" style="font-size: 1.25rem;">Detail Paket: <strong>{{ $membership->name }}</strong></h5>

                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item d-flex justify-content-between" style="font-size: 0.95rem;">
                        <span>Total Harga</span>
                        <span><strong>Rp. {{ number_format($membership->price, 0, ',', '.') }}</strong></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between" style="font-size: 0.95rem;">
                        <span>Durasi</span>
                        <span><strong>{{ $membership->duration_days }} hari</strong></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between" style="font-size: 0.95rem;">
                        <span>Limit Harian</span>
                        <span><strong>{{ $membership->daily_limit }} download</strong></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between" style="font-size: 0.95rem;">
                        <span>Akses</span>
                        <span><strong> Semua Aset Premium</strong></span>
                    </li>
                </ul>

                @if (session('error'))
                    <div class="alert alert-danger text-center" style="font-size: 0.9rem;">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('membership.processCheckout', $membership->id) }}" method="POST" class="text-center mt-4">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg w-100 text-white" >Lanjutkan ke Pembayaran</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
