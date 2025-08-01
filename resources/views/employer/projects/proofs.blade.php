@extends('layouts.app')
@section('title', config('app.name') . ' | Project Proof')
@section('content')

<!-- Header Section -->
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $em->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Project Proof</h3>
                        @if($proofs)
                            <span class="badge badge-primary">Submitted</span>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    @if(!$proofs)
                        <div class="text-center py-5">
                            <div class="empty-state-icon">
                                <i class="fas fa-file-alt fa-4x text-muted"></i>
                            </div>
                            <h3 class="mt-4">No Proof Submitted Yet</h3>
                            <p class="text-muted">The candidate hasn't submitted any project proof yet.</p>
                        </div>
                    @else
                        <div class="proof-content p-4 border rounded bg-light">
                            {!! $proofs->proof !!}
                        </div>
                    @endif
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-end">
                                <a href="{{ URL::previous() }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .proof-content {
        min-height: 300px;
    }
    .proof-content img {
        max-width: 100%;
        height: auto;
    }
    .empty-state-icon {
        opacity: 0.5;
    }
</style>

@endsection
