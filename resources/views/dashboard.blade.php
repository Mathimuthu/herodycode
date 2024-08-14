@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="icon-container pending-gigs">
                <div class="pending-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Pending Gig</h3>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="icon-container in-process-gigs">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <h3>In-Process Gigs</h3>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="icon-container completed-gigs">
                <div class="complete-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>Completed Gigs</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="icon-container all-members">
                <i class="fas fa-users"></i>
                <h3>All Members</h3>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="icon-container withdraw-request">
                <i class="fas fa-file-alt"></i>
                <h3>Withdraw Request</h3>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="icon-container campaigns">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <h3>Campaigns</h3>
            </div>
        </div>
    </div>
@endsection
