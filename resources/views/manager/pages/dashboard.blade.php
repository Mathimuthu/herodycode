@extends('layouts.app')

@section('title', config('app.name') . ' | Manager Dashboard')

@section('custom_header')
    @include('includes.header-manager')
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<!-- Our Dashboard -->
<section class="our-dashbord dashbord">
    <div class="container">
        <div class="row">
            @include('includes.manager-sidebar')

            <div class="col-sm-12 col-lg-8 col-xl-8">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="mb30">Dashboard</h4>
                    </div>

<div class="col-sm-12">
    <h4 class="mb30">Influencer Campaigns</h4>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Upload</th>
                    <th>Social Links</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Uploads</th>
                </tr>
            </thead>
            <tbody>
                @forelse($campaigns as $campaign)
                    <tr>
                        <td class="text-center">{{ $campaign->id }}</td>
                        <td>
                            <strong>{{ $campaign->title }}</strong>
                            <br>
                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($campaign->description, 50) }}</small>
                        </td>
                        <td>
                            @if($campaign->upload)
                                <a href="{{ asset($campaign->upload) }}" class="btn btn-sm btn-outline-primary" target="_blank">View</a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($campaign->youtube)
                                <a href="{{ $campaign->youtube }}" target="_blank" class="badge bg-danger d-block mb-1">YouTube</a>
                            @endif
                            @if($campaign->instagram)
                                <a href="{{ $campaign->instagram }}" target="_blank" class="badge bg-pink d-block mb-1">Instagram</a>
                            @endif
                            @if($campaign->twitter)
                                <a href="{{ $campaign->twitter }}" target="_blank" class="badge bg-info d-block mb-1">Twitter</a>
                            @endif
                            @if($campaign->linkedin)
                                <a href="{{ $campaign->linkedin }}" target="_blank" class="badge bg-secondary d-block">LinkedIn</a>
                            @endif
                        </td>
                        <td><span class="badge bg-warning text-dark">{{ ucfirst($campaign->collab_type) }}</span></td>
                        <td>
                           <!-- Status Dropdown -->
                            @php
                                $currentStatus = $statuses[$campaign->id] ?? 'pending'; // Default to pending
                            @endphp
                            
                            <form class="status-update-form" data-id="{{ $campaign->id }}">
                                @csrf
                                <select name="status" class="form-control form-control-sm status-select" style="width:auto;">
                                    <option value="pending" {{ $currentStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ $currentStatus == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $currentStatus == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </form>
                        </td>
                        <td>{{ $campaign->created_at ? $campaign->created_at->format('d M Y') : 'N/A' }}</td>
                      <td>
                   @php
    $firstProfile = $campaign->profiles->where('manager_id', auth('manager')->id())->first();
@endphp

{{-- Always show Upload button --}}
<form action="{{ route('manager.influencercampaign.uploadExcel') }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 8px;">
    {{ csrf_field() }}
    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
    <input type="file" name="excel_file" accept=".xlsx,.xls" required>
    <button type="submit" class="btn btn-sm btn-primary mt-1">Upload Excel</button>
</form>
@if($firstProfile)
    <a href="{{ route('manager.influencercampaign.viewProfiles', $campaign->id) }}" class="btn btn-sm btn-outline-info">View</a>
@else
    <span class="badge bg-warning text-dark">Waiting for Upload</span>
@endif



                    </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No influencer campaigns found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


                </div>
            </div>

        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
document.querySelectorAll('.status-select').forEach(select => {
    select.addEventListener('change', function() {
        const form = this.closest('.status-update-form');
        const campaignId = form.dataset.id;
        const status = this.value;

        fetch("{{ route('manager.influencercampaign.updateStatus') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ id: campaignId, status: status })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                alert('Status updated to "' + status + '" successfully.');
                window.location.reload();
            } else {
                alert('Failed to update status.');
            }
        })
        .catch(() => alert('Error updating status.'));
    });
});
</script>
@endsection
