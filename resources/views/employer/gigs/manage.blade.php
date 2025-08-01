@extends('layouts.app')
@section('title', config('app.name') . ' | Manage Gigs')
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
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-tasks mr-2 text-primary"></i>Manage Gigs
                        </h4>
                        @if($campaigns->count() > 0)
                        <div class="text-muted small">
                            Showing {{ $campaigns->firstItem() }} to {{ $campaigns->lastItem() }} of {{ $campaigns->total() }} gigs
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    @if($campaigns->count() == 0)
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No gigs found</h4>
                        <p class="text-muted">You haven't created any gigs yet.</p>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="30%">Gig Title</th>
                                    <th class="text-center">Applications</th>
                                    <th class="text-center">Timing</th>
                                    <th class="text-center">Earners</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($campaigns as $campaign)
                                <?php
                                    $e = DB::table('employers')->find($campaign->user_id);
                                    $user = $e->cname;
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <a href="{{route('campaign.details',$campaign->id)}}" class="font-weight-bold text-dark mb-1">
                                                {{$campaign->campaign_title}}
                                            </a>
                                            <div class="d-flex align-items-center">
                                                <small class="text-muted me-2">
                                                    <i class="fas fa-building me-1"></i> {{$user}}
                                                </small>
                                                <small class="text-muted">
                                                    <i class="far fa-calendar-alt me-1"></i>
                                                    {{\Carbon\Carbon::parse($campaign->created_at)->format('M d, Y')}}
                                                </small>
                                            </div>
                                            <div class="mt-2">
                                                <span class="badge bg-{{ $campaign->gigstatus ? 'success' : 'secondary' }}">
                                                    {{ $campaign->gigstatus ? 'Active' : 'Inactive' }}
                                                </span>
                                                <a href="{{route('employer.campaign.eproof',$campaign->id)}}" class="btn btn-sm btn-outline-primary ms-2">
                                                    <i class="fas fa-download me-1"></i> Accepted Proofs
                                                </a>
                                                <a href="{{route('employer.campaign.rejectedproof',$campaign->id)}}" class="btn btn-sm btn-outline-secondary ms-2">
                                                    <i class="fas fa-download me-1"></i> Rejected Proofs
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">{{ $campaign->total_applicants }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{ $campaign->timing ?? 'N/A' }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success text-white">{{ $campaign->approved_applicants }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{route('employer.gig.applications',$campaign->id)}}"
                                               class="btn btn-sm btn-info"
                                               data-bs-toggle="tooltip"
                                               title="View Applications">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{route('employer.gig.edit',$campaign->id)}}"
                                               class="btn btn-sm btn-primary ml-2"
                                               data-bs-toggle="tooltip"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{route('employer.gig.delete')}}" method="post"
                                                  onsubmit="return confirm('Are you sure you want to delete this gig?');">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$campaign->id}}">
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger ml-2"
                                                        data-bs-toggle="tooltip"
                                                        title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
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
@endsection
