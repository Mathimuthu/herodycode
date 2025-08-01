@extends('layouts.app')
@section('title', config('app.name').' | Projects')
@section('content')

<?php
    $employerId = Auth::guard('employer')->id();
    $user = DB::table('employers')->find($employerId);
?>

<!-- Header Section -->
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="card-body d-flex justify-content-between align-items-center py-3">
            <div>
                <h1 class="h3 font-weight-bold text-dark mb-1">Hi, {{ $user->name }}</h1>
                <p class="mb-0 text-muted">Your current projects</p>
            </div>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="img-fluid" style="width: 120px; height: auto;"/>
        </div>
    </div>
</div>

<div class="container-fluid px-lg-4 px-md-3 px-2">
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <h2 class="h4 font-weight-bold text-dark mb-3 mb-md-0">
                    <i class="fas fa-project-diagram text-primary mr-2"></i> Active Projects
                </h2>
                <div class="d-flex">
                    <div class="input-group input-group-sm mr-2" style="width: 200px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        </div>
                        <input type="text" class="form-control border-left-0" placeholder="Search projects...">
                    </div>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body px-0 py-3">
            @if($campaigns->count()==0)
            <div class="text-center py-5">
                <img src="{{ asset('assets/images/no-projects.svg') }}" alt="No projects" style="height: 150px;" class="mb-4">
                <h4 class="text-muted">No projects available</h4>
                <p class="text-muted mb-4">There are currently no active projects</p>
                <a href="#" class="btn btn-primary px-4">
                    <i class="fas fa-plus mr-2"></i>Create New Project
                </a>
            </div>
            @else
            <div class="row">
                @foreach($campaigns as $campaign)
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-3">
                                <img src="{{asset('assets/admin/img/camp-brand-logo/'.$campaign->logo)}}"
                                     alt="Company Logo"
                                     class="rounded mr-3"
                                     style="width: 60px; height: 60px; object-fit: contain;">
                                <div>
                                    <h5 class="mb-1 font-weight-bold">
                                        <a href="{{route('mission.details',$campaign->id)}}" class="text-dark">{{$campaign->title}}</a>
                                    </h5>
                                    <p class="mb-0 text-muted small">{{$campaign->brand}}</p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="bg-light rounded p-2 mr-2">
                                        <i class="fas fa-hourglass-half text-warning"></i>
                                    </span>
                                    <div>
                                        <p class="mb-0 small text-muted">Last date to apply</p>
                                        <p class="mb-0 font-weight-bold">{{\Carbon\Carbon::parse($campaign->before)->format('d M Y')}}</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-2">
                                    <span class="bg-light rounded p-2 mr-2">
                                        <i class="fas fa-users text-info"></i>
                                    </span>
                                    <div>
                                        <p class="mb-0 small text-muted">Available positions</p>
                                        <p class="mb-0 font-weight-bold">{{$campaign->ucount}}</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center">
                                    <span class="bg-light rounded p-2 mr-2">
                                        <i class="fas fa-coins text-success"></i>
                                    </span>
                                    <div>
                                        <p class="mb-0 small text-muted">Reward per completion</p>
                                        <p class="mb-0 font-weight-bold">Rs. {{$campaign->reward}}</p>
                                    </div>
                                </div>
                            </div>

                            <a href="{{route('mission.details',$campaign->id)}}" class="btn btn-block btn-outline-primary mt-3">
                                View Details <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{$campaigns->links('pagination::bootstrap-4')}}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .card {
        border-radius: 12px !important;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
    .small {
        font-size: 0.85rem;
    }
</style>

@endsection
