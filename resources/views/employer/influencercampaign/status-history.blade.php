@extends('layouts.app')
@section('title', 'Status History | '.config('app.name'))

@section('content')
<div class="container mt-4">
    <h3>Campaign: {{ $campaign->title }}</h3>
    <p><strong>Created at:</strong> {{ $campaign->created_at->format('d M Y, h:i A') }}</p>
    <hr>

    @if($statuses->isEmpty())
        <div class="alert alert-info">No status updates found for this campaign.</div>
    @else
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Manager Name</th>
                    <th>Status</th>
                    <th>Updated At</th>
                    <th>Datas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statuses as $status)
                <tr>
                    <td>{{ $status->manager->name ?? 'N/A' }}</td>
                    <td>
                        <span class="badge 
                            {{ $status->status == 'accepted' ? 'bg-success' : ($status->status == 'rejected' ? 'bg-danger' : 'bg-secondary') }}">
                            {{ ucfirst($status->status) }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($status->updated_at)->format('d M Y') }}</td>
                    <td><a href="{{ route('employer.influencercampaign.influencerdata', ['id' => $campaign->id, 'manager' => $status->manager->id]) }}" class="btn btn-primary mt-3">
                            View Influencer Data
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @endif

    <a href="{{ route('employer.influencercampaign.index') }}" class="btn btn-secondary">← Back</a>
</div>
@endsection
