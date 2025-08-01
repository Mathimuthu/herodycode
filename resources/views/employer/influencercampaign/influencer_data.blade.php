@extends('layouts.app')
@section('title', 'Influencer Data | '.config('app.name'))
@section('content')
<?php
    $employerId = Auth::guard('employer')->id();
    $user = DB::table('employers')->find($employerId);
?>

<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $user->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="fw-bold text-primary mb-0">
                            <i class="fas fa-users mr-2"></i>Influencer Data - {{ $campaign->title }}
                        </h3>
                        <a href="{{ route('employer.influencercampaign.statushistory', $campaign->id) }}"
                           class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Status History
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if($influencers->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No influencer data found</h4>
                        <p class="text-muted">There are no influencers associated with this campaign yet.</p>
                    </div>
                    @else
                    <form action="{{ route('employer.influencercampaign.bulkUpdateStatus') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="card bg-light border-0 p-3 mb-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-4">
                                    <label class="form-label small text-muted mb-1">Bulk Actions</label>
                                    <select name="bulkstatus" class="form-select" required>
                                        <option value="">-- Select Status --</option>
                                        <option value="pending">Pending</option>
                                        <option value="accepted">Accepted</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary mt-2">
                                        <i class="fas fa-save me-1"></i> Apply to Selected
                                    </button>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <small class="text-muted">{{ $influencers->count() }} influencers found</small>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="40" class="text-center">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th>Influencer Link</th>
                                        <th class="text-center">Platform</th>
                                        <th class="text-center">Followers</th>
                                        <th class="text-center">Engagement</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">City</th>
                                        <th class="text-center">Gender</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Content</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($influencers as $influencer)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="influencer_ids[]" value="{{ $influencer->id }}"
                                                   class="form-check-input influencer-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    @php
                                                        $platformIcon = [
                                                            'instagram' => 'fab fa-instagram text-danger',
                                                            'youtube' => 'fab fa-youtube text-danger',
                                                            'tiktok' => 'fab fa-tiktok text-dark',
                                                            'facebook' => 'fab fa-facebook text-primary',
                                                            'twitter' => 'fab fa-twitter text-info'
                                                        ][strtolower($influencer->platform)] ?? 'fas fa-globe text-secondary';
                                                    @endphp
                                                    <i class="{{ $platformIcon }} fa-lg"></i>
                                                </div>
                                                <div>
                                                    <a href="{{ $influencer->link }}" target="_blank"
                                                       class="text-decoration-none">
                                                        {{ Str::limit($influencer->link, 30) }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark text-uppercase">
                                                {{ $influencer->platform }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($influencer->follower) }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $influencer->engagement > 5 ? 'success' : 'warning' }}">
                                                {{ $influencer->engagement }}%
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{ $influencer->collaboration_type }}
                                        </td>
                                        <td class="text-center">
                                            {{ $influencer->city ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ ucfirst($influencer->gender) }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('employer.influencercampaign.updateStatus', $influencer->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <div class="input-group input-group-sm">
                                                    <select name="status" class="form-select form-select-sm"
                                                            onchange="this.form.submit()">
                                                        <option value="pending" {{ $influencer->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="accepted" {{ $influencer->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                                        <option value="rejected" {{ $influencer->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            @if($influencer->upload_file)
                                                @php
                                                    $filePath = asset($influencer->upload_file);
                                                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                                    $fileTypes = [
                                                        'image' => ['jpg', 'jpeg', 'png', 'webp', 'avif'],
                                                        'pdf' => ['pdf'],
                                                        'video' => ['mp4', 'mov'],
                                                        'document' => ['doc', 'docx']
                                                    ];

                                                    $fileType = 'other';
                                                    foreach ($fileTypes as $type => $exts) {
                                                        if (in_array(strtolower($extension), $exts)) {
                                                            $fileType = $type;
                                                            break;
                                                        }
                                                    }

                                                    $btnClasses = [
                                                        'image' => 'btn-outline-success',
                                                        'pdf' => 'btn-outline-danger',
                                                        'video' => 'btn-outline-info',
                                                        'document' => 'btn-outline-primary',
                                                        'other' => 'btn-outline-secondary'
                                                    ];

                                                    $icons = [
                                                        'image' => 'fa-image',
                                                        'pdf' => 'fa-file-pdf',
                                                        'video' => 'fa-video',
                                                        'document' => 'fa-file-word',
                                                        'other' => 'fa-file'
                                                    ];
                                                @endphp
                                                <div class="d-flex flex-column gap-2">
                                                    <a href="{{ $filePath }}" target="_blank"
                                                       class="btn btn-sm {{ $btnClasses[$fileType] }}">
                                                        <i class="fas {{ $icons[$fileType] }} me-1"></i>
                                                        View {{ ucfirst($fileType) }}
                                                    </a>
                                                    <form action="{{ route('employer.influencercampaign.UploadLiveStatus', $influencer->id) }}"
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-sm w-100 {{ $influencer->upload_file_status === 'live' ? 'btn-success' : 'btn-outline-secondary' }}">
                                                            <i class="fas {{ $influencer->upload_file_status === 'live' ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                                            {{ $influencer->upload_file_status === 'live' ? 'Live' : 'Not Live' }}
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="badge bg-light text-muted">No file</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Select all checkbox functionality
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.influencer-checkbox');

    selectAll.addEventListener('change', function () {
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
    });

    // Auto-submit status dropdowns
    document.querySelectorAll('select[name="status"]').forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script>

<style>
    .card.bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #2c3e50 100%);
        border-radius: 0 0 20px 20px;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(23, 162, 184, 0.05);
    }

    .badge.bg-light {
        color: #495057;
        font-weight: 500;
    }

    .form-select-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection
