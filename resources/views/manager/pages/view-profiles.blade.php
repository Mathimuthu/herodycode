@extends('layouts.app')

@section('title', 'Influencer Data | ' . config('app.name'))

<?php
    $managerId = Auth::guard('manager')->id();
    $user = DB::table('managers')->find($managerId);
?>

@section('content')
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $user->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($profiles->isEmpty())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        No uploaded data found for this campaign.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@else
<div class="card shadow-lg border-0">
    <div class="card-header bg-white border-bottom">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-3">
            <h2 class="h3 font-weight-bold text-dark text-center flex-fill text-sm-left mb-2 mb-sm-0 table-title">
                {{ $campaign->title }}
            </h2>

            <a href="{{ route('manager.dashboard') }}" class="btn btn-primary-custom d-inline-flex align-items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 campaign-table">
                <thead style="background-color: #1e3a8a; color: white;">
                    <tr class="text-center">
                        <th class="px-3 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">Link</th>
                        <th class="px-3 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">Followers</th>
                        <th class="px-3 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">Platform</th>
                        <th class="px-3 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">Engagement %</th>
                        <th class="px-3 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">Collab Type</th>
                        <th class="px-3 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">City</th>
                        <th class="px-3 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">Gender</th>
                        <th class="px-3 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">Past Work</th>
                        <th class="px-3 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">Uploaded At</th>
                        <th class="px-3 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">Status</th>
                        <th class="px-3 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">Content Status</th>
                        <th class="px-3 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">Upload File</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($profiles as $profile)
                        <tr class="text-center">
                            <td class="px-3 py-3">
                                <a href="{{ $profile->link }}" class="text-primary" target="_blank">
                                    View Link
                                </a>
                            </td>
                            <td class="px-3 py-3">{{ $profile->follower }}</td>
                            <td class="px-3 py-3">{{ ucfirst($profile->platform) }}</td>
                            <td class="px-3 py-3">{{ $profile->engagement }}%</td>
                            <td class="px-3 py-3">{{ $profile->collaboration_type }}</td>
                            <td class="px-3 py-3">{{ $profile->city }}</td>
                            <td class="px-3 py-3">{{ ucfirst($profile->gender) }}</td>
                            <td class="px-3 py-3">{{ $profile->past_work }}</td>
                            <td class="px-3 py-3">{{ $profile->created_at->format('d M Y') }}</td>
                            <td class="px-3 py-3">
                                @php
                                    $status = ucfirst($profile->status);
                                    $badgeClass = match($status) {
                                        'Accepted' => 'badge-success',
                                        'Rejected' => 'badge-danger',
                                        default => 'badge-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                            </td>
                            <td class="px-3 py-3">
                                @if($profile->status == 'accepted')
                                    <form action="{{ route('manager.updateContentStatus') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $profile->id }}">
                                        <select name="content_status" class="form-control form-control-sm" style="font-size: 0.75rem;" onchange="this.form.submit()">
                                            <option value="In Process" {{ $profile->content_status == 'In Process' ? 'selected' : '' }}>In Process</option>
                                            <option value="Content Created" {{ $profile->content_status == 'Content Created' ? 'selected' : '' }}>Content Created</option>
                                            <option value="Live" {{ $profile->content_status == 'Live' ? 'selected' : '' }}>Live</option>
                                            <option value="Submittion" {{ $profile->content_status == 'Submittion' ? 'selected' : '' }}>Submittion</option>
                                        </select>
                                    </form>
                                @else
                                    <small class="text-muted">N/A</small>
                                @endif
                            </td>
                            <td class="px-3 py-3" style="min-width: 250px;">
                                <div class="d-flex flex-column">
                                    @if($profile->upload_file)
                                        <div class="d-flex flex-column flex-sm-row mb-2" style="gap: 0.5rem;">
                                            <a href="{{ asset($profile->upload_file) }}" target="_blank" class="btn btn-outline-success btn-sm">
                                                View File
                                            </a>
                                            @php
                                                $fileStatusClass = $profile->upload_file_status === 'live' ? 'badge-success' : 'badge-secondary';
                                            @endphp
                                            <span class="badge {{ $fileStatusClass }} align-self-center">
                                                {{ ucfirst($profile->upload_file_status ?? 'Not Live') }}
                                            </span>
                                        </div>
                                    @endif

                                    @if($profile->content_status == 'Submittion')
                                        <form action="{{ route('manager.uploadFile') }}" method="POST" enctype="multipart/form-data" class="upload-form d-flex flex-column flex-sm-row" style="gap: 0.5rem;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $profile->id }}">
                                            <input type="file" name="upload_file" accept=".jpg,.jpeg,.gif,.png,.pdf,.docx,.mp4,.webp,.avif,.mov,.doc" class="form-control form-control-sm file-input" required>
                                            <button type="submit" class="btn btn-primary btn-sm btn-upload">
                                                Upload
                                            </button>
                                        </form>
                                    @elseif(!$profile->upload_file)
                                        <small class="text-muted">N/A</small>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<style>
.btn-primary-custom {
    background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    border: none;
    border-radius: 0.5rem;
    color: white;
    font-weight: 500;
}

.btn-primary-custom:hover {
    background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
    color: white;
}

@media (max-width: 768px) {
    .manager-avatar {
        max-width: 150px !important;
        margin-top: 1rem;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        align-items: center;
    }

    .table-title h2 {
        font-size: 1.1rem;
    }

    .btn-upload {
        width: 100%;
    }

    .upload-form {
        flex-direction: column;
        align-items: stretch;
    }

    .file-input {
        width: 100%;
    }

    .campaign-table td {
        padding: 0.5rem !important;
        font-size: 0.8rem;
    }
}
</style>
@endsection
