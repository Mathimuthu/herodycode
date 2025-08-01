@extends('layouts.app')

@section('title', config('app.name').' | Gig Applications')

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
<div class="container-fluid px-4">
    <!-- Header Card -->
  <div class="card-header bg-white border-bottom">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-3">
            <h2 class="h3 font-weight-bold text-dark text-center flex-fill text-sm-left mb-2 mb-sm-0 table-title">
                Gig Applications
            </h2>
        </div>
  </div>

    @if(isset($campaigns) && count($campaigns) > 0)
        <?php
            $firstCampaign = $campaigns->first();
            $gig = $firstCampaign->gig ?? null;
        ?>

        <!-- Bulk Actions Card -->
        @if($gig)
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3 text-primary">
                    <i class="fas fa-tasks me-2"></i>Bulk Actions
                </h5>
                <div class="d-flex flex-wrap gap-2">
                    <form action="{{route('employer.campaign.approveall')}}" method="post" class="me-2">
                        @csrf
                        <input type="hidden" name="id" value="{{$firstCampaign->cid}},{{$firstCampaign->uid}}">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle me-1"></i> Approve All
                        </button>
                    </form>

                    <form action="{{route('employer.campaign.rejectall')}}" method="post" class="me-2">
                        @csrf
                        <input type="hidden" name="id" value="{{$firstCampaign->cid}},{{$firstCampaign->uid}}">
                        <button type="submit" class="btn btn-danger ml-2">
                            <i class="fas fa-times-circle me-1"></i> Reject All
                        </button>
                    </form>

                    <form action="{{route('employer.campaign.approveallforrejected')}}" method="post" class="me-2">
                        @csrf
                        <input type="hidden" name="id" value="{{$firstCampaign->cid}},{{$firstCampaign->uid}}">
                        <button type="submit" class="btn btn-outline-success ml-2">
                            <i class="fas fa-redo me-1"></i> Approve Rejected
                        </button>
                    </form>

                    <form action="{{route('employer.campaign.rejectallforapproved')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$firstCampaign->cid}},{{$firstCampaign->uid}}">
                        <button type="submit" class="btn btn-outline-danger ml-2">
                            <i class="fas fa-undo me-1"></i> Reject Approved
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- Gig Info Card -->
        @if($gig)
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="fas fa-bullhorn text-primary me-2"></i>{{$gig->campaign_title}}
                    </h3>
                    <a href="{{route('employer.gig.exportapps',$gig->id)}}" class="btn btn-primary">
                        <i class="fas fa-file-export me-1"></i> Export Applications
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Applications Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-0">
                <!-- Search and Pagination -->
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="liveSearch" placeholder="Search applications...">
                    </div>

                    @if($campaigns->total() > 0)
                    <div class="d-flex align-items-center">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                <li class="page-item @if($campaigns->onFirstPage()) disabled @endif">
                                    <a class="page-link" href="{{ $campaigns->previousPageUrl() }}">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        Page {{ $campaigns->currentPage() }} of {{ $campaigns->lastPage() }}
                                    </span>
                                </li>
                                <li class="page-item @if(!$campaigns->hasMorePages()) disabled @endif">
                                    <a class="page-link" href="{{ $campaigns->nextPageUrl() }}">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    @endif
                </div>

                <!-- Applications Table -->
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Applied Date</th>
                                <th width="20%">User</th>
                                <th width="15%">Contact</th>
                                <th width="15%">Status</th>
                                <th width="30%">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="campaignTableBody">
                            @foreach($campaigns as $campaign)
                                <?php $user = DB::table('users')->find($campaign->uid); ?>
                                @if($user)
                                <tr class="campaignRow align-middle">
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <span class="d-block">{{ \Carbon\Carbon::parse($campaign->created_at)->format('M d, Y') }}</span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($campaign->created_at)->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title bg-light rounded-circle text-primary">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $user->name }}</h6>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->phone)
                                        <a href="tel:{{$user->phone}}" class="text-decoration-none">
                                            <i class="fas fa-phone me-1 text-muted"></i> {{ $user->phone }}
                                        </a>
                                        @else
                                        <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($campaign->status==0)
                                            <span class="badge bg-info">Applied</span>
                                        @elseif($campaign->status==1)
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($campaign->status==2)
                                            <span class="badge bg-danger">Rejected</span>
                                        @elseif($campaign->status==3)
                                            <span class="badge bg-primary">Proof Submitted</span>
                                        @elseif($campaign->status==4)
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($campaign->status==5)
                                            <span class="badge bg-danger">Proof Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if ($campaign->status==0)
                                                <a href="{{route('employer.campaign.approve',[$campaign->cid,$campaign->uid])}}"
                                                   class="btn btn-sm btn-success" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="{{route('employer.campaign.reject',[$campaign->cid,$campaign->uid])}}"
                                                   class="btn btn-sm btn-danger" title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @elseif($campaign->status==3)
                                                <a href="{{route('employer.campaign.viewproof',[$campaign->cid,$campaign->uid])}}"
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye me-1"></i> View Proof
                                                </a>
                                            @elseif($campaign->status==1)
                                                <a href="{{route('employer.campaign.reject',[$campaign->cid,$campaign->uid])}}"
                                                   class="btn btn-sm btn-danger" title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @elseif($campaign->status==2)
                                                <a href="{{route('employer.campaign.approve',[$campaign->cid,$campaign->uid])}}"
                                                   class="btn btn-sm btn-success" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            @elseif(in_array($campaign->status, [4,5]))
                                                <a href="{{route('employer.campaign.viewedproof',[$campaign->cid,$campaign->uid])}}"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i> View Proof
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Bottom Pagination -->
                @if($campaigns->total() > 0)
                <div class="d-flex justify-content-between align-items-center p-4 border-top">
                    <div class="text-muted">
                        Showing {{ $campaigns->firstItem() }} to {{ $campaigns->lastItem() }} of {{ $campaigns->total() }} entries
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            <li class="page-item @if($campaigns->onFirstPage()) disabled @endif">
                                <a class="page-link" href="{{ $campaigns->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $campaigns->lastPage(); $i++)
                                <li class="page-item @if($i == $campaigns->currentPage()) active @endif">
                                    <a class="page-link" href="{{ $campaigns->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item @if(!$campaigns->hasMorePages()) disabled @endif">
                                <a class="page-link" href="{{ $campaigns->nextPageUrl() }}">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                @endif
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-4"></i>
                <h3 class="text-muted">No Applications Found</h3>
                <p class="text-muted">There are no applications for this gig yet.</p>
                <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">
                    <i class="fas fa-arrow-left me-1"></i> Go Back
                </a>
            </div>
        </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Search functionality
        $('#liveSearch').on('keyup', function () {
            var searchText = $(this).val().toLowerCase();
            $('.campaignRow').hide();
            $('.campaignRow').filter(function () {
                return $(this).text().toLowerCase().includes(searchText);
            }).show();
        });
    });
</script>

<style>
    .card {
        border-radius: 12px;
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #2c3e50 100%);
    }

    .avatar-sm {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }

    .page-item.active .page-link {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    .page-link {
        color: #4e73df;
    }
</style>
@endsection
