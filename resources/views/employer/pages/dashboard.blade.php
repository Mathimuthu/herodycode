@extends('layouts.app')
@section('title', config('app.name') . ' | ' . $employer->name)
@section('content')

<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $employer->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>

<section class="py-5" style="background-color: #f9fafb;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="mb-5">
                    <h4 class="h3 font-weight-bold text-dark">Dashboard</h4>
                </div>

                <div class="row">
                    <!-- Projects Card -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-0" style="background-color: #dbeafe;">
                            <div class="card-body d-flex align-items-center">
                                <div class="p-3 rounded" style="background-color: #bfdbfe;">
                                    <i class="fas fa-arrow-right fa-2x" style="color: #1e40af;"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="h2 font-weight-bold mb-1" style="color: #1e3a8a;">{{ $employer->projects->count() }}</div>
                                    <p class="text-muted mb-0">Projects</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gigs Card -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-0" style="background-color: #cffafe;">
                            <div class="card-body d-flex align-items-center">
                                <div class="p-3 rounded" style="background-color: #a7f3d0;">
                                    <i class="fas fa-sun fa-2x" style="color: #155e75;"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="h2 font-weight-bold mb-1" style="color: #164e63;">{{ $employer->gigs->count() }}</div>
                                    <p class="text-muted mb-0">Gigs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@media (max-width: 768px) {
    .manager-avatar {
        max-width: 150px !important;
        margin-top: 1rem;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        align-items: center;
    }

    .card-body .ml-4 {
        margin-left: 1rem !important;
    }

    .h2 {
        font-size: 1.5rem;
    }
}
</style>

@endsection
