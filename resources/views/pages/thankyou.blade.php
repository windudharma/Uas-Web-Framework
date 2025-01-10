@extends('layouts.master')

@section('content')
    @include('layouts.nav')

    <hr class="border border-1 border-dark" style="margin-bottom: 50px">

    <div class="container py-5">
        <div class="d-flex justify-content-center">
            <div class="card shadow-sm text-center"
                style="max-width: 650px; border-radius: 10px; border: 1px solid #ccc; background-color: #fff; padding: 20px 40px 20px 40px;">
                <div class="card-body">
                    <div class="mb-4 d-flex justify-content-center">

                        <div style="width: 88px;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-6 h-6 text-success mx-auto">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <h5 class="mb-4" style="font-weight: bold; font-size: 1.25rem;">Your order has been confirmed.</h5>
                    <p style="font-size: 1rem; color: #333; line-height: 2;">
                        Thank you for visiting and purchasing photos from our website, we hope you love what you've found and look forward to welcoming you back for more amazing discoveries soon!.</p>
                    <a href="/" class="btn btn-primary mt-4"
                        style="font-size: 1rem; font-weight: bold; color: white; padding: 10px 20px; border-radius: 20px;">Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection
