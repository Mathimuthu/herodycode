@extends('layouts.app')
@section('title',config('app.name').' | Confirmation')
<?php
    $employerId = Auth::guard('employer')->id();
    $user = DB::table('employers')->find($employerId);
?>
@section('content')

    <!-- Welcome Card -->
    <div class="mb-4">
        <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $user->name }}</h1>
                <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
            </div>
        </div>
    </div>

<div class="card shadow-sm border-0">
    <!-- Header -->
    <div class="card-header bg-white border-bottom">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h3 mb-0 text-dark">Post a New Project</h2>
            <span class="badge badge-success">Completed!</span>
        </div>

        <!-- Progress Steps -->
        <div class="row justify-content-center mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <!-- Step 1: Information (Completed) -->
                    <div class="text-center flex-grow-1">
                        <div class="mx-auto mb-2" style="width: 48px; height: 48px; background-color: #059669; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="small font-weight-bold text-success">Information</span>
                    </div>

                    <!-- Connector Line 1 -->
                    <div class="flex-grow-1" style="height: 2px; background-color: #059669; margin: 0 1rem;"></div>

                    <!-- Step 2: Benefits & Workplace (Completed) -->
                    <div class="text-center flex-grow-1">
                        <div class="mx-auto mb-2" style="width: 48px; height: 48px; background-color: #059669; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="small font-weight-bold text-success">Benefits &<br>Workplace</span>
                    </div>

                    <!-- Connector Line 2 -->
                    <div class="flex-grow-1" style="height: 2px; background-color: #059669; margin: 0 1rem;"></div>

                    <!-- Step 3: Done (Active/Completed) -->
                    <div class="text-center flex-grow-1">
                        <div class="mx-auto mb-2" style="width: 48px; height: 48px; background-color: #059669; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="small font-weight-bold text-success">Done</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Content -->
    <div class="card-body">
        <div class="text-center mx-auto" style="max-width: 600px;">
            <!-- Success Icon -->
            <div class="mx-auto mb-4" style="width: 96px; height: 96px; background-color: #d1fae5; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-check-circle" style="font-size: 48px; color: #059669;"></i>
            </div>

            <!-- Success Message -->
            <h2 class="h2 mb-3 text-dark">
                🎉 Project Submitted Successfully!
            </h2>

            <div class="alert alert-info text-left mb-4">
                <div class="d-flex">
                    <i class="fas fa-info-circle mt-1 mr-3" style="font-size: 1.25rem;"></i>
                    <div>
                        <h3 class="h5 font-weight-bold text-primary mb-2">What happens next?</h3>
                        <ul class="mb-0 pl-3">
                            <li class="mb-2">
                                <i class="far fa-clock mr-2 text-primary"></i>
                                Our admin team will review your project within <strong>24-48 hours</strong>
                            </li>
                            <li class="mb-2">
                                <i class="far fa-envelope mr-2 text-primary"></i>
                                You'll receive an email notification once approved
                            </li>
                            <li>
                                <i class="far fa-eye mr-2 text-primary"></i>
                                Your project will be visible to candidates after approval
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <a href="{{route('employer.dashboard')}}"
                   class="btn btn-primary px-4 py-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    <span>Go to Dashboard</span>
                </a>

                <a href="{{route('employer.job.manage')}}"
                   class="btn btn-light px-4 py-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-briefcase mr-2"></i>
                    <span>Manage Projects</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Add confetti effect (optional)
    $(document).ready(function() {
        // Simple celebration animation
        var successIcon = $('.card-body .mx-auto[style*="width: 96px"]');
        if (successIcon.length) {
            successIcon.css('animation', 'bounce 1s ease-in-out');
        }
    });
</script>

<style>
    @keyframes bounce {
        0%, 20%, 53%, 80%, 100% {
            transform: translate3d(0,0,0);
        }
        40%, 43% {
            transform: translate3d(0, -10px, 0);
        }
        70% {
            transform: translate3d(0, -5px, 0);
        }
        90% {
            transform: translate3d(0, -2px, 0);
        }
    }

    /* Responsive improvements */
    @media (max-width: 576px) {
        .flex-grow-1[style*="height: 2px"] {
            min-width: 20px;
        }
    }
</style>
@endsection
