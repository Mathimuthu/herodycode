@extends('layouts.app')

@section('title', 'Influencer Data | ' . config('app.name'))

@section('custom_header')
    @include('includes.header-manager')
@endsection

@section('content')
<div class="container mt-4">
    <h3>Uploaded Influencer Data for Campaign: {{ $campaign->title }}</h3>
    <a href="{{ route('manager.dashboard') }}" class="btn btn-secondary mb-3">← Back to Dashboard</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($profiles->isEmpty())
        <div class="alert alert-warning">No uploaded data found for this campaign.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Link</th>
                        <th>Followers</th>
                        <th>Platform</th>
                        <th>Engagement %</th>
                        <th>Collab Type</th>
                        <th>City</th>
                        <th>Gender</th>
                        <th>Past Work</th>
                        <th>Uploaded At</th>
                        <th>Status</th>
                        <th>Content Status</th>
                        <th>Upload File</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($profiles as $profile)
                        <tr>
                            <td><a href="{{ $profile->link }}" target="_blank">{{ $profile->link }}</a></td>
                            <td>{{ $profile->follower }}</td>
                            <td>{{ ucfirst($profile->platform) }}</td>
                            <td>{{ $profile->engagement }}%</td>
                            <td>{{ $profile->collaboration_type }}</td>
                            <td>{{ $profile->city }}</td>
                            <td>{{ ucfirst($profile->gender) }}</td>
                            <td>{{ $profile->past_work }}</td>
                            <td>{{ $profile->created_at->format('d M Y') }}</td>
                           <td>
                                @php
                                    $status = $profile->status;
                                    if ($status == 'accepted') {
                                        $badge = 'success';
                                    } elseif ($status == 'rejected') {
                                        $badge = 'danger';
                                    } else {
                                        $badge = 'secondary';
                                    }
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ ucfirst($status) }}</span>
                            </td>
                            <td>
                                @if($profile->status == 'accepted')
                                    <form action="{{ route('manager.updateContentStatus') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $profile->id }}">
                                        <select name="content_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="In Process" {{ $profile->content_status == 'In Process' ? 'selected' : '' }}>In Process</option>
                                            <option value="Content Created" {{ $profile->content_status == 'Content Created' ? 'selected' : '' }}>Content Created</option>
                                            <option value="Live" {{ $profile->content_status == 'Live' ? 'selected' : '' }}>Live</option>
                                            <option value="Submittion" {{ $profile->content_status == 'Submittion' ? 'selected' : '' }}>Submittion</option>
                                        </select>
                                    </form>
                                @else
                                    N/A
                                @endif
                            </td>
                           <td class="text-center" style="min-width: 260px;">
                                @if($profile->upload_file)
                                    <div class="d-flex gap-2 mb-1">
                                        <a href="{{ asset($profile->upload_file) }}" target="_blank" class="btn btn-outline-success btn-sm w-100">
                                            <i class="bi bi-eye"></i> View File
                                        </a>
                                        <button type="button" class="btn btn-sm w-100 {{ $profile->upload_file_status === 'live' ? 'btn-outline-success' : 'btn-outline-secondary' }}">
                                            {{ $profile->upload_file_status === 'live' ? 'Live' : 'Not Live' }}
                                        </button>
                                    </div>
                                @endif
                            
                                @if($profile->content_status == 'Submittion')
                                    <form action="{{ route('manager.uploadFile') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $profile->id }}">
                                        
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="file" name="upload_file" class="form-control form-control-sm" accept=".jpg,.jpeg,.gif,.png,.pdf,.docx,.mp4,.webp,.avif,.mov,.doc" required>
                                            <button class="btn btn-sm btn-primary d-flex align-items-center" type="submit">
                                                <i class="bi bi-upload me-1"></i> Upload
                                            </button>
                                        </div>
                                    </form>
                                @elseif(!$profile->upload_file)
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
