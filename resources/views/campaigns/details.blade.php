<?php
    $cities = explode(',',$campaign->city);
    $c = "";
    foreach ($cities as $city) {
        $c = $city." ".$c;
    }
?>
@extends('layouts.app')
@section('title', config('app.name').' | Project Details')
@section('content')
<div class="container-fluid px-lg-4 px-md-3 px-2">
    <div class="card border-0 shadow-sm mb-4">
        <!-- Project Header -->
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start mb-4">
                <div class="d-flex align-items-start mb-3 mb-lg-0 w-100">
                    <img src="{{asset('assets/admin/img/camp-brand-logo/'.$campaign->logo)}}"
                         alt="Company Logo"
                         class="rounded mr-4"
                         style="width: 80px; height: 80px; object-fit: contain;">
                    <div class="flex-grow-1">
                        <h2 class="h3 font-weight-bold text-dark mb-2">{{$campaign->title}}</h2>
                        <h4 class="h5 text-muted mb-3">{{$campaign->brand}}</h4>

                        <div class="d-flex flex-wrap">
                            <div class="mr-4 mb-2">
                                <span class="d-block text-muted small">Reward</span>
                                <span class="font-weight-bold text-success">₹{{$campaign->reward}}</span>
                            </div>
                            <div class="mr-4 mb-2">
                                <span class="d-block text-muted small">Last Date</span>
                                <span class="font-weight-bold">{{\Carbon\Carbon::parse($campaign->before)->format('d M Y')}}</span>
                            </div>
                            <div class="mr-4 mb-2">
                                <span class="d-block text-muted small">Positions</span>
                                <span class="font-weight-bold">{{$campaign->ucount}}</span>
                            </div>
                            <div class="mb-2">
                                <span class="d-block text-muted small">Location</span>
                                <span class="font-weight-bold">{{$c}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-100 w-lg-auto">
                    @if(Auth::check())
                        @if(DB::table('campaign_apps')->where(['uid' => Auth::user()->id,'cid' => $campaign->id,'status'=>0])->exists())
                            <button class="btn btn-success btn-block px-4" disabled>
                                <i class="fas fa-check-circle mr-2"></i>Applied
                            </button>
                        @elseif(DB::table('campaign_apps')->where(['uid' => Auth::user()->id,'cid' => $campaign->id,'status'=>1])->exists())
                            <form action="{{route('campaign.responser')}}" method="post" class="w-100">
                                @csrf
                                <input type="hidden" name="id" value="{{$campaign->id}}">
                                <button type="submit" class="btn btn-primary btn-block px-4">
                                    <i class="fas fa-paper-plane mr-2"></i>Submit Responses
                                </button>
                            </form>
                        @elseif(DB::table('campaign_apps')->where(['uid' => Auth::user()->id,'cid' => $campaign->id,'status'=>3])->exists())
                            <button class="btn btn-info btn-block px-4" disabled>
                                <i class="fas fa-check-double mr-2"></i>Responses Submitted
                            </button>
                        @elseif(DB::table('campaign_apps')->where(['uid' => Auth::user()->id,'cid' => $campaign->id,'status'=>4])->exists())
                            <button class="btn btn-success btn-block px-4" disabled>
                                <i class="fas fa-trophy mr-2"></i>Selected
                            </button>
                        @else
                            <button type="button" class="btn btn-primary btn-block px-4" data-toggle="modal" data-target="#apply">
                                <i class="fas fa-paper-plane mr-2"></i>Apply Now
                            </button>
                        @endif
                    @else
                        <a href="{{route('employer.login')}}" class="btn btn-outline-primary btn-block px-4">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login to Apply
                        </a>
                    @endif
                </div>
            </div>

            <hr class="my-4">

            <!-- Project Details Sections -->
            <div class="project-section mb-5">
                <div class="section-header d-flex align-items-center mb-3">
                    <i class="fas fa-info-circle text-primary mr-2"></i>
                    <h4 class="font-weight-bold mb-0">About Project</h4>
                </div>
                <div class="section-content bg-light rounded p-4">
                    {!!$campaign->des!!}
                </div>
            </div>

            <div class="project-section mb-5">
                <div class="section-header d-flex align-items-center mb-3">
                    <i class="fas fa-gift text-primary mr-2"></i>
                    <h4 class="font-weight-bold mb-0">Benefits</h4>
                </div>
                <div class="section-content bg-light rounded p-4">
                    {!!$campaign->benefits!!}
                </div>
            </div>

            <div class="project-section mb-5">
                <div class="section-header d-flex align-items-center mb-3">
                    <i class="fas fa-clipboard-check text-primary mr-2"></i>
                    <h4 class="font-weight-bold mb-0">Requirements</h4>
                </div>
                <div class="section-content bg-light rounded p-4">
                    {!!$campaign->requirements!!}
                </div>
            </div>

            <div class="project-section mb-5">
                <div class="section-header d-flex align-items-center mb-3">
                    <i class="fas fa-exclamation-triangle text-primary mr-2"></i>
                    <h4 class="font-weight-bold mb-0">Do's & Don'ts</h4>
                </div>
                <div class="section-content bg-light rounded p-4">
                    {!!$campaign->dondont!!}
                </div>
            </div>

            <div class="project-section mb-5">
                <div class="section-header d-flex align-items-center mb-3">
                    <i class="fas fa-list-ol text-primary mr-2"></i>
                    <h4 class="font-weight-bold mb-0">Instructions</h4>
                </div>
                <div class="section-content bg-light rounded p-4">
                    {!!$campaign->instructions!!}
                </div>
            </div>

            <div class="project-section mb-5">
                <div class="section-header d-flex align-items-center mb-3">
                    <i class="fas fa-tasks text-primary mr-2"></i>
                    <h4 class="font-weight-bold mb-0">Methods</h4>
                </div>
                <div class="section-content bg-light rounded p-4">
                    {!!$campaign->methods!!}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Apply Modal -->
<div class="modal fade" id="apply" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="applyModalLabel">Apply for Project</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h5 class="font-weight-bold text-primary mb-3">
                        <i class="fas fa-exclamation-circle mr-2"></i> Important Terms
                    </h5>
                    <div class="bg-light p-3 rounded">
                        {!!$campaign->imp_terms!!}
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="font-weight-bold text-primary mb-3">
                        <i class="fas fa-file-contract mr-2"></i> Terms & Conditions
                    </h5>
                    <div class="bg-light p-3 rounded">
                        {!!$campaign->terms!!}
                    </div>
                </div>

                <form method="post" action="{{route('mission.apply')}}">
                    @csrf
                    <input type="hidden" name="id" value="{{$campaign->id}}">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="terms" name="terms" value="Agree" required>
                            <label class="custom-control-label font-weight-bold" for="terms">
                                I agree to all the terms and conditions
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .project-section {
        border-left: 3px solid #4e73df;
        padding-left: 15px;
    }
    .section-header {
        padding-bottom: 5px;
    }
    .section-content {
        border: 1px solid #e3e6f0;
    }
    .modal-content {
        border-radius: 12px;
    }
    .btn-block {
        white-space: nowrap;
    }
    .bg-light {
        background-color: #f8f9fa!important;
    }
</style>

@endsection
