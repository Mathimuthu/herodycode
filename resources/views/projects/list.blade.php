@extends('layouts.app')
@section('title', config('app.name').' | Internships')
@section('content')
<?php
    $employerId = Auth::guard('employer')->id();
    $user = DB::table('employers')->find($employerId);
?>

<!-- Header Section -->
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="card-body d-flex justify-content-between align-items-center py-4">
            <div>
                <h1 class="h2 font-weight-bold text-dark mb-1">Hi, {{ $user->name }}</h1>
                <p class="mb-0 text-muted">Manage your internship listings</p>
            </div>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="img-fluid" style="width: 120px; height: auto;"/>
        </div>
    </div>
</div>

<div class="container-fluid px-lg-4 px-md-3 px-2">
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 font-weight-bold text-dark mb-0">
                    <i class="fas fa-briefcase mr-2 text-primary"></i>Internship Opportunities
                </h2>
                <div class="d-flex">
                    <input type="text" class="form-control form-control-sm mr-2" placeholder="Search internships..." style="min-width: 200px;">
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body px-0 py-3">
            @if($jobs->count()==0)
            <div class="text-center py-5">
                <img src="{{ asset('assets/images/empty.svg') }}" alt="No data" style="height: 120px;" class="mb-3">
                <h4 class="text-muted">No internships found</h4>
                <p class="text-muted">You haven't posted any internships yet</p>
                <a href="#" class="btn btn-primary">Post New Internship</a>
            </div>
            @else
            <div class="row">
                @foreach($jobs as $job)
                <?php
                    $e = DB::table('employers')->find($job->user);
                    $user = $e->cname;
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow-lg transition">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{asset('assets/employer/profile_images/'.$e->profile_photo)}}"
                                     alt="Company Logo"
                                     class="rounded-circle mr-3"
                                     style="width: 50px; height: 50px; object-fit: cover;">
                                <div>
                                    <h5 class="mb-0 font-weight-bold">{{$job->title}}</h5>
                                    <small class="text-muted">{{$user}}</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="badge badge-light border px-3 py-1 mb-2 d-inline-block">
                                    <i class="fas fa-hourglass-half text-primary mr-1"></i> {{$job->duration}}
                                </span>
                                <span class="badge badge-light border px-3 py-1 mb-2 d-inline-block">
                                    <i class="fas fa-users text-primary mr-1"></i> {{$job->count}} Positions
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 text-success">
                                    <i class="fas fa-coins mr-1"></i> Rs.{{$job->stipend}}
                                </h5>
                                <a href="{{route('job.details',$job->id)}}" class="btn btn-sm btn-outline-primary">
                                    View Details <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{$jobs->links('pagination::bootstrap-4')}}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .hover-shadow-lg:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }
    .table-title {
        letter-spacing: 0.5px;
    }
</style>
@endsection
