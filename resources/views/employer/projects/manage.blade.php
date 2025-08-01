@extends('layouts.app')
@section('title', config('app.name') . ' | Manage Projects')
@section('content')
<?php
    $employerId = Auth::guard('employer')->id();
    $user = DB::table('employers')->find($employerId);
?>
<!-- Header Section -->
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $user->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="card shadow-sm border-0 overflow-hidden">
    <div class="card-header bg-white border-bottom-0 pb-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 font-weight-bold text-dark mb-0">Manage Projects</h2>
            <span class="badge badge-primary badge-pill py-2 px-3">
                Total Projects: {{ $jobs->total() ?? $jobs->count() }}
            </span>
        </div>
    </div>

    @if($jobs->count() == 0)
        <!-- Empty State -->
        <div class="text-center py-5 px-4">
            <div class="mx-auto mb-4 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                <i class="fas fa-briefcase fa-3x text-muted"></i>
            </div>
            <h3 class="h4 font-weight-bold text-dark mb-2">No Projects Found</h3>
            <p class="text-muted mb-4">You haven't created any projects yet. Start by creating your first project.</p>
            <a href="{{ route('employer.job.create') }}" class="btn btn-primary btn-lg px-4">
                <i class="fas fa-plus mr-2"></i> Create Project
            </a>
        </div>
    @else
        <!-- Projects Table -->
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="pl-4" style="width: 55%;">Project Details</th>
                        <th scope="col" class="text-center">Applications</th>
                        <th scope="col" class="text-center pr-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                    <?php
                        $e = DB::table('employers')->find($job->user);
                        $user = $e->cname ?? 'Unknown Company';
                    ?>
                    <tr>
                        <td class="pl-4 py-4">
                            <div class="d-flex flex-column">
                                <!-- Project Title -->
                                <a href="{{ route('job.details', $job->id) }}" class="h5 font-weight-bold text-primary mb-2">
                                    {{ $job->title }}
                                </a>

                                <!-- Company and Dates -->
                                <div class="d-flex flex-wrap align-items-center text-muted mb-3">
                                    <div class="d-flex align-items-center mr-4 mb-1">
                                        <i class="fas fa-building mr-2"></i>
                                        <span>{{ $user }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mr-4 mb-1">
                                        <i class="far fa-calendar-alt mr-2"></i>
                                        <span>Created: {{ \Carbon\Carbon::parse($job->created_at)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="far fa-clock mr-2"></i>
                                        <span>Last Date: {{ \Carbon\Carbon::parse($job->end)->format('M d, Y') }}</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex flex-wrap">
                                    <a href="{{ route('employer.job.shortlisteds', $job->id) }}" class="btn btn-sm btn-outline-primary rounded-pill mr-2 mb-2 px-3">
                                        <i class="fas fa-check-circle mr-1"></i> Shortlisted Users
                                    </a>
                                    <a href="{{ route('employer.job.selecteds', $job->id) }}" class="btn btn-sm btn-outline-success rounded-pill mr-2 mb-2 px-3">
                                        <i class="fas fa-check mr-1"></i> Selected Users
                                    </a>
                                    <a href="{{ route('employer.job.eproof', $job->id) }}" class="btn btn-sm btn-outline-info rounded-pill mb-2 px-3">
                                        <i class="fas fa-file-download mr-1"></i> Download Proofs
                                    </a>
                                </div>
                            </div>
                        </td>

                        <td class="text-center align-middle">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <span class="h4 font-weight-bold text-dark">{{ $job->applications->count() }}</span>
                                <span class="text-muted small">Application(s)</span>
                            </div>
                        </td>

                        <td class="text-center align-middle pr-4">
                            <div class="btn-group btn-group-sm" role="group">
                                <!-- View Applications -->
                                <a href="{{ route('employer.job.applications', $job->id) }}"
                                   class="btn btn-light rounded-circle mx-1"
                                   style="width: 36px; height: 36px;"
                                   data-toggle="tooltip" title="View Applications">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('employer.job.edit', $job->id) }}"
                                   class="btn btn-light rounded-circle mx-1"
                                   style="width: 36px; height: 36px;"
                                   data-toggle="tooltip" title="Edit Project">
                                    <i class="fas fa-edit text-success"></i>
                                </a>

                                <!-- Delete -->
                                <button onclick="dele('{{ $job->id }}')"
                                        class="btn btn-light rounded-circle mx-1"
                                        style="width: 36px; height: 36px;"
                                        data-toggle="tooltip" title="Delete Project">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(method_exists($jobs, 'links'))
            <div class="card-footer bg-white border-top-0 pt-0">
                <div class="d-flex justify-content-center">
                    {{ $jobs->links() }}
                </div>
            </div>
        @endif
    @endif
</div>

@endsection

@section('scripts')
<script>
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    function dele(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                var btn = event.target.closest('button');
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                btn.disabled = true;

                // Redirect to delete URL
                window.location.href = "{{ url('/') }}/employer/project/delete/" + id;
            }
        })
    }

    function delep(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                var btn = event.target.closest('button');
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                btn.disabled = true;

                window.location.href = "/file/employer/project/deletep/" + id;
            }
        })
    }
</script>

<style>
    .card {
        border-radius: 15px;
    }

    .table thead th {
        border-top: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        border-bottom-width: 1px;
    }

    .table td {
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .btn-light {
        background-color: #f8f9fa;
        border-color: #f8f9fa;
    }

    .btn-light:hover {
        background-color: #e9ecef;
        border-color: #e9ecef;
    }

    .rounded-pill {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }
</style>
@endsection
