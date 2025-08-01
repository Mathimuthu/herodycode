@extends('layouts.app')

@section('title', 'Manager Dashboard')
<?php
    $managerId = Auth::guard('manager')->id();
    $user = DB::table('managers')->find($managerId);
?>

@section('content')
<!-- Custom Styles for this page -->
<style>
    .welcome-card {
        background: linear-gradient(135deg, #d1fae5 0%, #dbeafe 100%);
        border-radius: 30px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .campaign-table {
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .table-header {
        background-color: #1e3a8a !important;
        color: white !important;
    }

    .table-header th {
        padding: 0.75rem 1rem !important;
        text-transform: uppercase;
        font-size: 0.875rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        border: none !important;
        color: white !important;
        background-color: #1e3a8a !important;
    }

    .campaign-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .campaign-table td {
        padding: 0.75rem 1rem !important;
        border-top: 1px solid #e5e7eb;
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .social-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 4px;
        color: white;
        text-decoration: none;
        margin: 2px;
        font-weight: 500;
    }

    .social-badge:hover {
        text-decoration: none;
        color: white;
        opacity: 0.9;
    }

    .youtube-badge { background-color: #ef4444; }
    .instagram-badge { background-color: #8b5cf6; }
    .twitter-badge { background-color: #60a5fa; }
    .linkedin-badge { background-color: #6b7280; }

    .status-badge {
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        border-radius: 12px;
        background-color: #fef3c7;
        color: #92400e;
        font-weight: 500;
    }

    .status-select {
        font-size: 0.8rem;
        padding: 0.375rem 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        width: 100px;
        background-color: white;
    }

    .status-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25);
        outline: none;
    }

    .upload-section {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .upload-form {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: nowrap;
    }

    .file-input {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        width: 120px;
    }

    .btn-upload {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        background-color: #6366f1;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s;
        white-space: nowrap;
        font-weight: 500;
    }

    .btn-upload:hover {
        background-color: #4f46e5;
        color: white;
    }

    .status-link {
        display: block;
        text-align: center;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
    }

    .status-view {
        background-color: #dbeafe;
        color: #1d4ed8;
    }

    .status-view:hover {
        background-color: #c7d2fe;
        color: #1d4ed8;
        text-decoration: none;
    }

    .status-waiting {
        background-color: #fef3c7;
        color: #92400e;
    }

    .manager-avatar {
        max-width: 180px;
        height: auto;
        object-fit: contain;
    }

    .table-title {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background-color: #f8f9fa;
    }

    .campaign-id {
        font-weight: 600;
        color: #374151;
    }

    .campaign-title {
        font-weight: 600;
        color: #111827;
        font-size: 0.9rem;
    }

    .campaign-description {
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .view-link {
        color: #3b82f6;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .view-link:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .welcome-card {
            text-align: center;
            padding: 1.5rem;
        }

        .welcome-card h1 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .upload-form {
            flex-direction: column;
            align-items: stretch;
        }

        .file-input {
            width: 100%;
        }

        .manager-avatar {
            max-width: 150px;
        }

        .campaign-table td {
            padding: 0.5rem !important;
            font-size: 0.8rem;
        }
    }
</style>

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {!! Session::get('success') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {!! Session::get('error') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Welcome Card -->
<div class="welcome-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $user->name }}</h1>
        <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" />
    </div>
</div>

<!-- Campaigns Table -->
<div class="campaign-table">
    <div class="table-title">
        <h2 class="h3 font-weight-bold text-dark text-center mb-0">
            Influencers Campaign
        </h2>
    </div>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-header">
                <tr>
                    <th class="text-center">ID</th>
                    <th>TITLE</th>
                    <th>UPLOAD</th>
                    <th>SOCIAL LINKS</th>
                    <th>TYPE</th>
                    <th>STATUS</th>
                    <th>CREATED</th>
                    <th>UPLOADS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($campaigns as $campaign)
                    <tr>
                        <td class="text-center campaign-id">{{ $campaign->id }}</td>
                        <td>
                            <div class="campaign-title">{{ $campaign->title }}</div>
                            <div class="campaign-description">{!! strip_tags($campaign->description, '<br><strong><em>') !!}</div>
                        </td>
                        <td>
                            @if($campaign->upload)
                                <a href="{{ asset($campaign->upload) }}" class="view-link" target="_blank">View</a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap align-items-center">
                                @if($campaign->youtube)
                                    <a href="{{ $campaign->youtube }}" target="_blank" class="social-badge youtube-badge">YouTube</a>
                                @endif
                                @if($campaign->instagram)
                                    <a href="{{ $campaign->instagram }}" target="_blank" class="social-badge instagram-badge">Instagram</a>
                                @endif
                                @if($campaign->twitter)
                                    <a href="{{ $campaign->twitter }}" target="_blank" class="social-badge twitter-badge">Twitter</a>
                                @endif
                                @if($campaign->linkedin)
                                    <a href="{{ $campaign->linkedin }}" target="_blank" class="social-badge linkedin-badge">LinkedIn</a>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="status-badge">{{ ucfirst($campaign->collab_type ?? 'BARTER') }}</span>
                        </td>
                        <td>
                            @php
                                $currentStatus = isset($statuses[$campaign->id]) ? $statuses[$campaign->id] : 'pending';
                            @endphp
                            <form class="status-update-form" data-id="{{ $campaign->id }}">
                                {{ csrf_field() }}
                                <select name="status" class="status-select">
                                    <option value="pending" {{ $currentStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ $currentStatus == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $currentStatus == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </form>
                        </td>
                        <td class="text-muted">{{ $campaign->created_at ? $campaign->created_at->format('d M Y') : 'N/A' }}</td>
                        <td>
                            <div class="upload-section">
                                <div class="upload-form">
                                    <form action="{{ route('manager.influencercampaign.uploadExcel') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center" style="gap: 0.25rem;">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                                        <input type="file" name="excel_file" class="file-input" accept=".xlsx,.xls" required>
                                        <button type="submit" class="btn-upload">Upload Excel</button>
                                    </form>
                                </div>

                                @if($campaign->profiles->where('manager_id', auth('manager')->id())->first())
                                    <a href="{{ route('manager.influencercampaign.viewProfiles', $campaign->id) }}" class="status-link status-view">View</a>
                                @else
                                    <span class="status-link status-waiting">Waiting for Upload</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No influencer campaigns found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.status-select').forEach(select => {
    select.addEventListener('change', function() {
        const form = this.closest('.status-update-form');
        const campaignId = form.dataset.id;
        const status = this.value;

        // Create AJAX request compatible with older browsers
        var xhr = new XMLHttpRequest();
        xhr.open('POST', "{{ route('manager.influencercampaign.updateStatus') }}", true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        var data = JSON.parse(xhr.responseText);
                        if(data.success) {
                            alert('Status updated to "' + status + '" successfully.');
                            window.location.reload();
                        } else {
                            alert('Failed to update status.');
                        }
                    } catch(e) {
                        alert('Error parsing response.');
                    }
                } else {
                    alert('Error updating status.');
                }
            }
        };

        xhr.send(JSON.stringify({ id: campaignId, status: status }));
    });
});
</script>
@endsection
