@extends('layouts.app')
@section('title', config('app.name') . ' | Manage Infulencer Campaigns')
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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-bullhorn mr-2 text-primary"></i>Influencer Campaigns</h4>
                        <a href="{{ route('employer.influencercampaign.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i> Create New
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($campaigns->count()==0)
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h3 class="text-muted">No campaigns found</h3>
                        <p class="text-muted">You haven't created any influencer campaigns yet.</p>
                        <a href="{{ route('employer.influencercampaign.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus mr-1"></i> Create Your First Campaign
                        </a>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 30%">Campaign Title</th>
                                    <th scope="col" style="width: 20%">Brand</th>
                                    <th scope="col" style="width: 15%">Assets</th>
                                    <th scope="col" style="width: 15%">Status</th>
                                    <th scope="col" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($campaigns as $campaign)
                                <?php
                                    $e = DB::table('employers')->find($campaign->employe_id);
                                    $user = $e->cname;
                                ?>
                                <tr>
                                    <td>
                                        <a href="{{route('campaign.details',$campaign->id)}}" class="font-weight-bold text-dark">
                                            {{$campaign->title}}
                                        </a>
                                        <div class="text-muted small mt-1">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            Created: {{\Carbon\Carbon::parse($campaign->created_at)->format('M d, Y')}}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light">{{$user}}</span>
                                    </td>
                                    <td>
                                        @if($campaign->upload)
                                            @php
                                                $isImage = preg_match('/\.(jpg|jpeg|png|gif)$/i', $campaign->upload);
                                            @endphp
                                            @if($isImage)
                                                <button class="btn btn-sm btn-outline-primary"
                                                    onclick="window.open('{{ asset($campaign->upload) }}', '_blank')">
                                                    <i class="far fa-image mr-1"></i> View
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-muted small">No file</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'active' => 'success',
                                                'pending' => 'warning',
                                                'completed' => 'primary',
                                                'rejected' => 'danger'
                                            ][strtolower($campaign->status)] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $statusClass }}">
                                            {{ ucfirst($campaign->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('employer.influencercampaign.statushistory', $campaign->id) }}"
                                               class="btn btn-sm btn-info mr-2"
                                               data-toggle="tooltip"
                                               title="Status History">
                                                <i class="fas fa-history"></i>
                                            </a>

                                            <a href="{{ route('employer.influencercampaign.editer', $campaign->id) }}"
                                                class="btn btn-sm btn-primary mr-2"
                                                data-toggle="tooltip"
                                                title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>

                                            <form action="{{route('employer.influencercampaign.delete')}}" method="post"
                                                  onsubmit="return confirm('Are you sure you want to delete this campaign?');">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $campaign->id }}">
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                        data-toggle="tooltip"
                                                        title="Delete">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $campaigns->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        border-radius: 0 0 20px 20px;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.05);
    }

    .card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
    }

    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    .main-content {
        flex: 1;
        overflow-y: auto;
        padding: 1rem 4.5rem;
    }

</style>

@endsection
