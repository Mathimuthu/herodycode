@extends('layouts.app')
@section('title', config('app.name') . ' | Job Applications')
@section('content')

<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $employer->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card card h-100 shadow-sm border-0" style="border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-icon mb-3">
                            <i class="fas fa-users" style="font-size: 2rem; opacity: 0.9;"></i>
                        </div>
                        <h3 class="font-weight-bold mb-1">{{ $jas->total() }}</h3>
                        <p class="small mb-0 opacity-75">Total Applications</p>
                    </div>
                    <div class="stats-bg-icon">
                        <i class="fas fa-users" style="font-size: 3rem; opacity: 0.1; position: absolute; right: 15px; top: 15px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card card h-100 shadow-sm border-0" style="border-radius: 16px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-icon mb-3">
                            <i class="fas fa-star" style="font-size: 2rem; opacity: 0.9;"></i>
                        </div>
                        <h3 class="font-weight-bold mb-1">{{ \App\Shortlisted::where('jid', $job->id ?? 0)->count() }}</h3>
                        <p class="small mb-0 opacity-75">Shortlisted</p>
                    </div>
                    <div class="stats-bg-icon">
                        <i class="fas fa-star" style="font-size: 3rem; opacity: 0.1; position: absolute; right: 15px; top: 15px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card card h-100 shadow-sm border-0" style="border-radius: 16px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-icon mb-3">
                            <i class="fas fa-check-circle" style="font-size: 2rem; opacity: 0.9;"></i>
                        </div>
                        <h3 class="font-weight-bold mb-1">0</h3>
                        <p class="small mb-0 opacity-75">Selected</p>
                    </div>
                    <div class="stats-bg-icon">
                        <i class="fas fa-check-circle" style="font-size: 3rem; opacity: 0.1; position: absolute; right: 15px; top: 15px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card card h-100 shadow-sm border-0" style="border-radius: 16px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-icon mb-3">
                            <i class="fas fa-times-circle" style="font-size: 2rem; opacity: 0.9;"></i>
                        </div>
                        <h3 class="font-weight-bold mb-1">{{ \App\Reject::where('jid', $job->id ?? 0)->count() }}</h3>
                        <p class="small mb-0 opacity-75">Rejected</p>
                    </div>
                    <div class="stats-bg-icon">
                        <i class="fas fa-times-circle" style="font-size: 3rem; opacity: 0.1; position: absolute; right: 15px; top: 15px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="card shadow-lg border-0" style="border-radius: 20px;">
    <!-- Header with Actions -->
    <div class="card-header bg-white border-bottom" style="border-radius: 20px 20px 0 0;">
        <div class="row align-items-center py-2">
            <div class="col-md-6">
                <h2 class="font-weight-bold text-dark mb-0">
                    <i class="fas fa-briefcase text-primary mr-2"></i>Job Applications
                </h2>
            </div>
            <div class="col-md-6 text-right">
                <div class="btn-group-vertical btn-group-sm d-md-none mb-2">
                    @if(isset($job))
                    <a href="{{ route('employer.payu', ['id' => $job->id]) }}"
                       class="btn btn-primary mb-2 rounded-pill">
                        <i class="fas fa-credit-card mr-2"></i>Make Payment
                    </a>
                    @endif
                    <button type="button"
                            onclick="$('#contactAdminModal').modal('show')"
                            class="btn btn-outline-secondary rounded-pill">
                        <i class="fas fa-comment mr-2"></i>Contact Admin
                    </button>
                </div>
                <div class="d-none d-md-block">
                    @if(isset($job))
                    <a href="{{ route('employer.payu', ['id' => $job->id]) }}"
                       class="btn btn-primary mr-2 rounded-pill px-4">
                        <i class="fas fa-credit-card mr-2"></i>Make Payment
                    </a>
                    @endif
                    <button type="button"
                            onclick="$('#contactAdminModal').modal('show')"
                            class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-comment mr-2"></i>Contact Admin
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-4">
        @if($jas->count() == 0)
            <div class="text-center py-5">
                <div class="mb-4">
                    <div class="empty-state-icon">
                        <i class="fas fa-file-alt text-muted" style="font-size: 5rem; opacity: 0.3;"></i>
                    </div>
                </div>
                <h3 class="font-weight-bold text-dark mb-2">No applications found</h3>
                <p class="text-muted">There are currently no applications for this job posting.</p>
                <a href="#" class="btn btn-primary rounded-pill px-4 mt-3">
                    <i class="fas fa-plus mr-2"></i>Post New Job
                </a>
            </div>
        @else
            <!-- Applications Table -->
            <div class="table-responsive modern-table" style="border-radius: 15px; overflow: hidden;">
                <table class="table table-hover mb-0" id="applicationsTable">
                    <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                        <tr>
                            <th class="border-0 font-weight-bold text-uppercase small text-muted py-3">ID</th>
                            <th class="border-0 font-weight-bold text-uppercase small text-muted py-3">Applicant</th>
                            <th class="border-0 font-weight-bold text-uppercase small text-muted py-3">Location</th>
                            <th class="border-0 font-weight-bold text-uppercase small text-muted py-3">Contact</th>
                            <th class="border-0 font-weight-bold text-uppercase small text-muted py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jas as $ja)
                            <?php $user = DB::table('users')->find($ja->uid); ?>
                            @if($user)
                                <tr class="border-bottom table-row-hover">
                                    <td class="align-middle py-3">
                                        <div class="id-badge">
                                            <span class="badge badge-primary rounded-pill px-3 py-2">
                                                {{$loop->iteration}}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="align-middle py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <div class="user-avatar">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <a href="{{ route('applicant.view', $ja->uid) }}"
                                                   class="font-weight-bold text-dark text-decoration-none user-name-link">
                                                    {{$user->name}}
                                                </a>
                                                <div class="small text-muted">Applied recently</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="align-middle py-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                                            <span class="text-muted">{{$user->state}}</span>
                                        </div>
                                    </td>

                                    <td class="align-middle py-3">
                                        <div>
                                            <div class="d-flex align-items-center mb-1 small">
                                                <i class="fas fa-envelope text-primary mr-2"></i>
                                                @if($jas->currentPage() == 1 && $loop->index < 5 || isset($job) && $job->is_visible == 0)
                                                    <span class="text-muted">{{$user->email}}</span>
                                                @else
                                                    <span class="text-muted">{{ 'xxxx' . strstr($user->email, '@') }}</span>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center small">
                                                <i class="fas fa-phone text-primary mr-2"></i>
                                                @if($jas->currentPage() == 1 && $loop->index < 5 || isset($job) && $job->is_visible == 0)
                                                    <span class="text-muted">{{$user->phone}}</span>
                                                @else
                                                    <span class="text-muted">{{ substr($user->phone, 0, 2) . 'xxxxx' . substr($user->phone, -2) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="align-middle py-3">
                                        <div class="d-flex flex-wrap action-buttons">
                                            @if(\App\Shortlisted::where(['jid' => $ja->jid, 'uid' => $ja->uid])->exists())
                                                <span class="badge badge-warning mr-1 mb-1 rounded-pill px-3 py-2">
                                                    <i class="fas fa-star mr-1"></i>Shortlisted
                                                </span>
                                            @else
                                                <a href="{{ route('employer.job.shortlist', [$ja->jid, $ja->uid]) }}"
                                                   class="badge badge-outline-warning mr-1 mb-1 text-decoration-none rounded-pill px-3 py-2">
                                                    <i class="fas fa-star mr-1"></i>Shortlist
                                                </a>
                                            @endif

                                            <a href="{{ route('applicant.view', $ja->uid) }}" target="_blank"
                                               class="badge badge-primary mr-1 mb-1 text-decoration-none rounded-pill px-3 py-2">
                                                <i class="fas fa-eye mr-1"></i>View Profile
                                            </a>

                                            @if(\App\Reject::where(['uid' => $ja->uid, 'jid' => $ja->jid])->exists())
                                                <span class="badge badge-danger mr-1 mb-1 rounded-pill px-3 py-2">
                                                    <i class="fas fa-times mr-1"></i>Rejected
                                                </span>
                                            @else
                                                <a href="{{ route('employer.job.reject', [$ja->jid, $ja->uid]) }}"
                                                   class="badge badge-outline-danger mr-1 mb-1 text-decoration-none rounded-pill px-3 py-2">
                                                    <i class="fas fa-times mr-1"></i>Reject
                                                </a>
                                            @endif

                                            <a href="{{ route('employer.job.answers', [$ja->jid, $ja->uid]) }}" target="_blank"
                                               class="badge badge-info mr-1 mb-1 text-decoration-none rounded-pill px-3 py-2">
                                                <i class="fas fa-file-alt mr-1"></i>Answers
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $jas->links() }}
            </div> --}}

            <!-- Enhanced Bulk Actions -->
            <div class="card mt-4" style="border-radius: 20px; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); border: 1px solid #e9ecef;">
                <div class="card-body p-4">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-6">
                            <h5 class="font-weight-bold text-dark mb-0">
                                <i class="fas fa-tasks text-primary mr-2"></i>Bulk Actions
                            </h5>
                            <p class="text-muted small mb-0">Perform actions on multiple applications</p>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <div class="btn-group-vertical btn-group-sm d-md-none mt-3">
                                <a href="{{ route('employer.job.shortlisteds', $ja->jid) }}"
                                   class="btn btn-outline-primary btn-sm mb-2 rounded-pill">
                                    <i class="fas fa-check mr-1"></i>View Shortlisted
                                </a>
                                <a href="{{ route('employer.job.selecteds', $ja->jid) }}"
                                   class="btn btn-outline-success btn-sm mb-2 rounded-pill">
                                    <i class="fas fa-user-check mr-1"></i>View Selected
                                </a>
                                <a href="{{ route('employer.job.exportapps', $ja->jid) }}"
                                   class="btn btn-outline-info btn-sm rounded-pill">
                                    <i class="fas fa-download mr-1"></i>Export Data
                                </a>
                            </div>
                            <div class="d-none d-md-block">
                                <a href="{{ route('employer.job.shortlisteds', $ja->jid) }}"
                                   class="btn btn-outline-primary btn-sm mr-2 rounded-pill px-3">
                                    <i class="fas fa-check mr-1"></i>View Shortlisted
                                </a>
                                <a href="{{ route('employer.job.selecteds', $ja->jid) }}"
                                   class="btn btn-outline-success btn-sm mr-2 rounded-pill px-3">
                                    <i class="fas fa-user-check mr-1"></i>View Selected
                                </a>
                                <a href="{{ route('employer.job.exportapps', $ja->jid) }}"
                                   class="btn btn-outline-info btn-sm rounded-pill px-3">
                                    <i class="fas fa-download mr-1"></i>Export Data
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-left gap-3">
                        @if(isset($ja))
                            <div class="bulk-action-item">
                                <form action="{{ route('employer.job.shortlistall') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$ja->jid}}">
                                    <button type="submit" class="btn btn-warning btn-sm rounded-pill px-4 py-2 bulk-btn-compact">
                                        <i class="fas fa-star mr-2"></i>Shortlist All
                                    </button>
                                </form>
                            </div>

                            <div class="bulk-action-item ml-2">
                                <form action="{{ route('employer.job.selectall') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$ja->jid}}">
                                    <button type="submit" class="btn btn-success btn-sm rounded-pill px-4 py-2 bulk-btn-compact">
                                        <i class="fas fa-check mr-2"></i>Select All
                                    </button>
                                </form>
                            </div>

                            <div class="bulk-action-item ml-2">
                                <form action="{{ route('employer.job.rejectall') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$ja->jid}}">
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4 py-2 bulk-btn-compact"
                                            onclick="return confirm('Are you sure you want to reject all applications?')">
                                        <i class="fas fa-times mr-2"></i>Reject All
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Contact Admin Modal -->
<div class="modal fade" id="contactAdminModal" tabindex="-1" role="dialog" aria-labelledby="contactAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title font-weight-bold" id="contactAdminModalLabel">
                    <i class="fas fa-comment-alt text-primary mr-2"></i>Contact Admin
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-2">
                <p class="text-muted mb-0">Please contact the administrator to get the full contact details of the applicants.</p>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
     $(document).ready(function () {
        $('#applicationsTable').DataTable({
            responsive: true
        });
    });
    function dele(id) {
        if (confirm('Are you sure you want to delete this job?')) {
            window.location.href = "{{ route('employer.job.delete', '') }}/" + id;
        }
    }

    // Add loading states to compact buttons
    document.querySelectorAll('.bulk-btn-compact').forEach(button => {
        button.addEventListener('click', function() {
            this.classList.add('loading');
        });
    });
</script>
@endsection

@section('styles')
<style>
/* Enhanced Statistics Cards */
.stats-card {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.stats-card .card-body {
    position: relative;
    z-index: 2;
}

.stats-bg-icon {
    position: relative;
}

/* Modern Table Styling */
.modern-table {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
}

.table-row-hover:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    transform: translateX(5px);
    transition: all 0.3s ease;
}

/* User Avatar */
.user-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 1.2rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.user-name-link:hover {
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
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.badge-outline-warning {
    color: #856404;
    background-color: transparent;
    border: 1px solid #ffc107;
}

.badge-outline-warning:hover {
    color: #fff;
    background-color: #ffc107;
    text-decoration: none;
}

.badge-outline-danger {
    color: #721c24;
    background-color: transparent;
    border: 1px solid #dc3545;
}

.badge-outline-danger:hover {
    color: #fff;
    background-color: #dc3545;
    text-decoration: none;
}

/* Compact Bulk Action Buttons */
.bulk-action-item {
    transition: all 0.3s ease;
}

.bulk-btn-compact {
    border: none;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    min-width: 130px;
}

.bulk-btn-compact:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.bulk-btn-compact:active {
    transform: translateY(0);
}

/* Compact button loading state */
.bulk-btn-compact.loading {
    pointer-events: none;
    opacity: 0.7;
}

.bulk-btn-compact.loading::after {
    content: "";
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    width: 12px;
    height: 12px;
    border: 2px solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

/* Gap utility for flexbox */
.gap-3 {
    gap: 1rem;
}

/* Button Enhancements */
.btn {
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
}

/* Modal Enhancements */
.modal-content {
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    border: none;
}

/* Empty State */
.empty-state-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

/* ID Badge */
.id-badge .badge {
    font-size: 0.875rem;
    font-weight: 600;
}

/* Action Buttons */
.action-buttons .badge {
    transition: all 0.2s ease;
}

.action-buttons .badge:hover {
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    .stats-card .card-body {
        text-align: center;
    }

    .table-responsive {
        font-size: 0.875rem;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    .bulk-btn {
        padding: 1rem;
    }
}

/* Animation for Statistics */
@keyframes countUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stats-card h3 {
    animation: countUp 0.6s ease-out;
}

/* Spin Animation */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Custom Scrollbar */
.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f8f9fa;
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
}
</style>
@endsection
