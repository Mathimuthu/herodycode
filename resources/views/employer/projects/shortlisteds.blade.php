@extends('layouts.app')
@section('title', config('app.name') . ' | Shortlisted Resumes')
@section('content')

<!-- Header Section -->
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $employer->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="card shadow-lg border-0" style="border-radius: 20px;">
    <!-- Header with Count -->
    <div class="card-header bg-white border-bottom-0" style="border-radius: 20px 20px 0 0;">
        <div class="row align-items-center py-2">
            <div class="col-md-8">
                <h2 class="font-weight-bold text-dark mb-0">
                    <i class="fas fa-star text-warning mr-2"></i>Shortlisted Resumes
                </h2>
            </div>
            <div class="col-md-4 text-right">
                @if($jas->count() > 0)
                    <span class="badge badge-primary rounded-pill px-3 py-2" style="font-size: 0.875rem;">
                        <i class="fas fa-users mr-1"></i>{{ $jas->count() }} Candidates
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="card-body p-4">
        @if($jas->count() == 0)
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <div class="empty-state-icon mx-auto" style="width: 120px; height: 120px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-star text-muted" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
                <h3 class="font-weight-bold text-dark mb-2">No Shortlisted Resumes Found</h3>
                <p class="text-muted mb-4">Start reviewing applications to build your shortlist of candidates.</p>
                <a href="{{ route('employer.dashboard') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
            </div>
        @else
            <!-- Bulk Actions -->
            @if($jas->count() > 1)
                <div class="card bg-light mb-4" style="border-radius: 15px; border: 1px solid #e9ecef;">
                    <div class="card-body p-3">
                        <h6 class="font-weight-bold text-dark mb-3">
                            <i class="fas fa-tasks text-primary mr-2"></i>Bulk Actions
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            <form action="{{ route('employer.job.selectall') }}" method="post" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $jas->first()->jid }}">
                                <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 bulk-btn">
                                    <i class="fas fa-check mr-1"></i>Select All
                                </button>
                            </form>
                            <form action="{{ route('employer.job.rejectall') }}" method="post" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $jas->first()->jid }}">
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 bulk-btn"
                                        onclick="return confirm('Are you sure you want to reject all candidates?')">
                                    <i class="fas fa-times mr-1"></i>Reject All
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Shortlisted Resumes List -->
            <div class="shortlisted-list">
                @foreach($jas as $ja)
                    <?php $user = DB::table('users')->find($ja->uid); ?>
                    @if($user)
                        <div class="card candidate-card mb-3" style="border-radius: 15px; border: 1px solid #e9ecef; transition: all 0.3s ease;">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <!-- Profile Photo and Info -->
                                    <div class="col-lg-8 col-md-7">
                                        <div class="d-flex align-items-center">
                                            <!-- Profile Photo -->
                                            <div class="mr-3">
                                                <div class="candidate-avatar position-relative">
                                                    @if($user->profile_photo != NULL)
                                                        <img src="{{ asset('assets/user/images/user_profile/'.$user->profile_photo) }}"
                                                             alt="{{ $user->name }}"
                                                             class="rounded-circle"
                                                             style="width: 60px; height: 60px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" />
                                                    @else
                                                        <div class="user-avatar-fallback">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- User Info -->
                                            <div class="candidate-info">
                                                <h5 class="font-weight-bold mb-1">
                                                    <a href="{{ route('applicant.view', $ja->uid) }}"
                                                       class="text-dark text-decoration-none candidate-name-link">
                                                        {{ $user->name }}
                                                    </a>
                                                </h5>
                                                @if($user->state)
                                                    <p class="text-muted small mb-0 d-flex align-items-center">
                                                        <i class="fas fa-map-marker-alt text-primary mr-1"></i>
                                                        {{ $user->state }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="col-lg-4 col-md-5">
                                        <div class="candidate-actions text-right">
                                            <div class="btn-group-vertical btn-group-sm d-md-none w-100 mb-2">
                                                <!-- Selection Status -->
                                                @if(\App\Select::where(['uid' => $ja->uid, 'jid' => $ja->jid])->exists())
                                                    <span class="btn btn-success btn-sm rounded-pill mb-1">
                                                        <i class="fas fa-check mr-1"></i>Selected
                                                    </span>
                                                @else
                                                    <a href="{{ route('employer.job.select', [$ja->jid, $ja->uid]) }}"
                                                       class="btn btn-primary btn-sm rounded-pill mb-1">
                                                        <i class="fas fa-plus mr-1"></i>Select
                                                    </a>
                                                @endif

                                                <!-- View Profile -->
                                                <a href="{{ route('applicant.view', $ja->uid) }}" target="_blank"
                                                   class="btn btn-outline-secondary btn-sm rounded-pill mb-1">
                                                    <i class="fas fa-eye mr-1"></i>View Profile
                                                </a>

                                                <!-- Rejection Status -->
                                                @if(\App\Reject::where(['uid' => $ja->uid, 'jid' => $ja->jid])->exists())
                                                    <span class="btn btn-danger btn-sm rounded-pill">
                                                        <i class="fas fa-times mr-1"></i>Rejected
                                                    </span>
                                                @else
                                                    <a href="{{ route('employer.job.reject', [$ja->jid, $ja->uid]) }}"
                                                       class="btn btn-danger btn-sm rounded-pill"
                                                       onclick="return confirm('Are you sure you want to reject this candidate?')">
                                                        <i class="fas fa-minus mr-1"></i>Reject
                                                    </a>
                                                @endif
                                            </div>

                                            <!-- Desktop Actions -->
                                            <div class="d-none d-md-flex flex-wrap justify-content-end">
                                                <!-- Selection Status -->
                                                @if(\App\Select::where(['uid' => $ja->uid, 'jid' => $ja->jid])->exists())
                                                    <span class="badge badge-success rounded-pill px-3 py-2 mr-1 mb-1">
                                                        <i class="fas fa-check mr-1"></i>Selected
                                                    </span>
                                                @else
                                                    <a href="{{ route('employer.job.select', [$ja->jid, $ja->uid]) }}"
                                                       class="badge badge-primary rounded-pill px-3 py-2 mr-1 mb-1 text-decoration-none">
                                                        <i class="fas fa-plus mr-1"></i>Select
                                                    </a>
                                                @endif

                                                <!-- View Profile -->
                                                <a href="{{ route('applicant.view', $ja->uid) }}" target="_blank"
                                                   class="badge badge-secondary rounded-pill px-3 py-2 mr-1 mb-1 text-decoration-none">
                                                    <i class="fas fa-eye mr-1"></i>View Profile
                                                </a>

                                                <!-- Rejection Status -->
                                                @if(\App\Reject::where(['uid' => $ja->uid, 'jid' => $ja->jid])->exists())
                                                    <span class="badge badge-danger rounded-pill px-3 py-2 mb-1">
                                                        <i class="fas fa-times mr-1"></i>Rejected
                                                    </span>
                                                @else
                                                    <a href="{{ route('employer.job.reject', [$ja->jid, $ja->uid]) }}"
                                                       class="badge badge-danger rounded-pill px-3 py-2 mb-1 text-decoration-none"
                                                       onclick="return confirm('Are you sure you want to reject this candidate?')">
                                                        <i class="fas fa-minus mr-1"></i>Reject
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Pagination -->
            {{-- @if($jas->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $jas->links() }}
                </div>
            @endif --}}

            <!-- Quick Actions -->
            @if($jas->count() > 0)
                <div class="card mt-4" style="border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); border: 1px solid #e1bee7;">
                    <div class="card-body p-4">
                        <h6 class="font-weight-bold text-dark mb-3">
                            <i class="fas fa-bolt text-primary mr-2"></i>Quick Actions
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('employer.job.selecteds', $jas->first()->jid) }}"
                               class="btn btn-primary btn-sm rounded-pill px-3">
                                <i class="fas fa-check-circle mr-1"></i>View Selected Users
                            </a>
                            <a href="{{ route('job.details', $jas->first()->jid) }}"
                               class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="fas fa-info-circle mr-1"></i>View Job Details
                            </a>
                            <a href="{{ route('employer.job.exportapps', $jas->first()->jid) }}"
                               class="btn btn-outline-info btn-sm rounded-pill px-3">
                                <i class="fas fa-download mr-1"></i>Export Data
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading states for bulk action buttons
        const bulkButtons = document.querySelectorAll('.bulk-btn');
        bulkButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.disabled = true;
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Processing...';

                // Re-enable after form submission (fallback)
                setTimeout(() => {
                    this.disabled = false;
                    this.innerHTML = originalText;
                }, 5000);
            });
        });

        // Add hover effects for candidate cards
        const candidateCards = document.querySelectorAll('.candidate-card');
        candidateCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.1)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });

        // Add confirmation for reject actions
        const rejectLinks = document.querySelectorAll('a[href*="reject"]');
        rejectLinks.forEach(link => {
            if (!link.hasAttribute('onclick')) {
                link.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to reject this candidate?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    });
</script>
@endsection

@section('styles')
<style>
/* Candidate Card Styles */
.candidate-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef !important;
}

.candidate-card:hover {
    border-color: #667eea !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
}

/* User Avatar Fallback */
.user-avatar-fallback {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 1.5rem;
    border: 3px solid #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Candidate Avatar */
.candidate-avatar {
    position: relative;
}

/* Candidate Name Link */
.candidate-name-link:hover {
    color: #667eea !important;
    transition: color 0.3s ease;
}

/* Enhanced Badge Styles */
.badge {
    font-size: 0.75rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.badge-danger {
    color: #fff;
    background-color: #dc3545;
}

.badge-danger:hover {
    color: #fff;
    background-color: #c82333;
    text-decoration: none;
}

/* Button Enhancements */
.btn {
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

/* Bulk Action Buttons */
.bulk-btn {
    min-width: 100px;
    font-weight: 600;
}

.bulk-btn:disabled {
    opacity: 0.6;
    pointer-events: none;
}

/* Empty State Animation */
.empty-state-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

/* Gap utility for flexbox (Bootstrap 4 compatible) */
.gap-2 > * {
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
}

.gap-2 > *:last-child {
    margin-right: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .candidate-card .card-body {
        padding: 1rem;
    }

    .candidate-avatar img,
    .user-avatar-fallback {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }

    .candidate-info h5 {
        font-size: 1rem;
    }

    .badge {
        font-size: 0.675rem;
        padding: 0.375rem 0.75rem;
    }
}

/* Custom Scrollbar */
.shortlisted-list::-webkit-scrollbar {
    width: 8px;
}

.shortlisted-list::-webkit-scrollbar-track {
    background: #f8f9fa;
    border-radius: 4px;
}

.shortlisted-list::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 4px;
}

.shortlisted-list::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
}

/* Animation for card appearance */
.candidate-card {
    animation: fadeInUp 0.5s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Loading spinner animation */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.fa-spin {
    animation: spin 1s linear infinite;
}
</style>
@endsection
