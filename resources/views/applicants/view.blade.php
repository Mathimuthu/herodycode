<?php
    $score = 0;
    if($user->profile_photo != NULL){
        $score = $score + 10;
    }
    if($user->state != NULL){
        $score = $score + 10;
    }
    if($user->about != NULL){
        $score = $score + 10;
    }
    if($exps->count() != 0){
        $score = $score + 10;
    }
    if($user->achievements != NULL){
        $score = $score + 10;
    }
    if($user->hobbies != NULL){
        $score = $score + 10;
    }
    if($edus->count() != 0){
        $score = $score + 10;
    }
    if($projs->count() != 0){
        $score = $score + 10;
    }
    if($skills->count() != 0){
        $score = $score + 10;
    }
    if($user->address != NULL){
        $score = $score + 10;
    }
    if($user->hobbies != NULL){
        $hobbies = explode(',', $user->hobbies);
    }
    if($user->achievements != NULL){
        $achievements = explode(',', $user->achievements);
    }
?>
<?php
    $employerId = Auth::guard('employer')->id();
    $emp = DB::table('employers')->find($employerId);
?>
@extends('layouts.app')
@section('title', config('app.name') . ' | ' . $user->user_name . ' profile')
@section("heads")
<link rel="stylesheet" href="{{asset('assets/applicant/css/style.css')}}">
<style>
    .profile-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 20px;
    }

    .profile-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .profile-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 5px solid #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        margin-bottom: 15px;
    }

    .profile-name {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
    }

    .section-header i {
        margin-right: 10px;
        color: #007bff;
        font-size: 18px;
    }

    .section-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }

    .info-block {
        margin-bottom: 30px;
    }

    .info-item {
        background: #f8f9fa;
        border-left: 4px solid #007bff;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .info-item strong {
        color: #333;
        font-size: 16px;
    }

    .info-item p {
        margin-bottom: 5px;
        color: #666;
    }

    .skill-badge, .hobby-badge, .achievement-badge {
        display: inline-block;
        background: #007bff;
        color: white;
        padding: 8px 12px;
        margin: 5px;
        border-radius: 20px;
        font-size: 14px;
    }

    .social-link {
        display: block;
        padding: 12px 15px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 10px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: #e9ecef;
        text-decoration: none;
        color: #007bff;
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .social-link i {
        margin-right: 10px;
        width: 30px;
    }

    .progress-container {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .progress-title {
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    .btn-generate-pdf {
        width: 100%;
        margin-bottom: 20px;
        padding: 10px;
        font-weight: bold;
    }

    .no-data {
        text-align: center;
        color: #6c757d;
        font-style: italic;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 5px;
    }

    @media (max-width: 768px) {
        .profile-card {
            padding: 15px;
        }

        .profile-img {
            width: 100px;
            height: 100px;
        }

        .profile-name {
            font-size: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $emp->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>
<div class="container py-4" id="pdf">
    <div class="row">
        <!-- Left Sidebar -->
        <div class="col-lg-4 col-md-5">
            <div class="profile-card">
                <!-- Profile Header -->
                <div class="profile-header">
                    @if(is_null($user->profile_photo))
                        <img src="{{asset('assets/user/images/frontEnd/demo.png')}}"
                             class="profile-img" alt="Profile Photo">
                    @else
                        <img src="{{asset('assets/user/images/user_profile/'.$user->profile_photo)}}"
                             class="profile-img" alt="Profile Photo">
                    @endif
                    <div class="profile-name">{{$user->name}}</div>
                </div>

                <!-- Resume Score -->
                <div class="progress-container">
                    <div class="progress-title">Resume Completion Score</div>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-success progress-bar-striped"
                             role="progressbar"
                             style="width: {{$score}}%;"
                             aria-valuenow="{{$score}}"
                             aria-valuemin="0"
                             aria-valuemax="100">
                            {{$score}}%
                        </div>
                    </div>
                </div>

                <!-- Generate PDF Button -->
                <a href="{{route('print.view', $user->id)}}" class="btn btn-primary btn-generate-pdf">
                    <i class="fas fa-file-pdf mr-2"></i>Generate PDF Resume
                </a>

                <!-- About Section -->
                @if(!is_null($user->about))
                <div class="info-block">
                    <div class="section-header">
                        <i class="fas fa-user"></i>
                        <h5 class="section-title">About Me</h5>
                    </div>
                    <div style="word-wrap: break-word; line-height: 1.6;">
                        {!! $user->about !!}
                    </div>
                </div>
                @endif

                <!-- Contact Information -->
                @if(!is_null($user->address) || !is_null($user->state))
                <div class="info-block">
                    <div class="section-header">
                        <i class="fas fa-map-marker-alt"></i>
                        <h5 class="section-title">Contact Info</h5>
                    </div>
                    @if(!is_null($user->address))
                        <p><strong>Address:</strong> {{$user->address}}</p>
                    @endif
                    @if(!is_null($user->state))
                        <p><strong>State:</strong> {{$user->state}}</p>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8 col-md-7">
            <!-- Education Section -->
            <div class="profile-card">
                <div class="section-header">
                    <i class="fas fa-graduation-cap"></i>
                    <h5 class="section-title">Education</h5>
                </div>
                @if($edus->count() == 0)
                    <div class="no-data">@lang("No education data found")</div>
                @else
                    @foreach($edus as $edu)
                        <div class="info-item">
                            <strong>{{$edu->type}}</strong>
                            <p><strong>Institution:</strong> {{$edu->name}}</p>
                            <p><strong>Course:</strong> {{$edu->course}}</p>
                            <p><strong>Duration:</strong> {{$edu->start}} - {{$edu->end}}</p>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Work Experience Section -->
            <div class="profile-card">
                <div class="section-header">
                    <i class="fas fa-briefcase"></i>
                    <h5 class="section-title">Work Experience</h5>
                </div>
                @if($exps->count() == 0)
                    <div class="no-data">@lang("No work experience found")</div>
                @else
                    @foreach($exps as $exp)
                        <div class="info-item">
                            <strong>{{$exp->company}}</strong>
                            <p><strong>Position:</strong> {{$exp->designation}}</p>
                            <p><strong>Duration:</strong> {{$exp->start}} - {{$exp->end}}</p>
                            <div>{!! $exp->des !!}</div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Projects Section -->
            <div class="profile-card">
                <div class="section-header">
                    <i class="fas fa-project-diagram"></i>
                    <h5 class="section-title">Projects</h5>
                </div>
                @if($projs->count() == 0)
                    <div class="no-data">@lang("No projects found")</div>
                @else
                    @foreach($projs as $proj)
                        <div class="info-item">
                            <strong>{{$proj->title}}</strong>
                            <div>{!! $proj->des !!}</div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Skills Section -->
            <div class="profile-card">
                <div class="section-header">
                    <i class="fas fa-cogs"></i>
                    <h5 class="section-title">Skills</h5>
                </div>
                @if($skills->count() == 0)
                    <div class="no-data">@lang("No skills found")</div>
                @else
                    <div class="d-flex flex-wrap">
                        @foreach($skills as $skill)
                            <span class="skill-badge">
                                {{$skill->name}}
                                @for($i = 0; $i < $skill->rating; $i++)
                                    <i class="fas fa-star" style="color: #FFD119; font-size: 12px;"></i>
                                @endfor
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Achievements Section -->
            <div class="profile-card">
                <div class="section-header">
                    <i class="fas fa-trophy"></i>
                    <h5 class="section-title">Achievements</h5>
                </div>
                @if($user->achievements == NULL)
                    <div class="no-data">@lang("No achievements found")</div>
                @else
                    <div class="d-flex flex-wrap">
                        @foreach($achievements as $ach)
                            <span class="achievement-badge">{{trim($ach)}}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Hobbies Section -->
            <div class="profile-card">
                <div class="section-header">
                    <i class="fas fa-heart"></i>
                    <h5 class="section-title">Interests & Hobbies</h5>
                </div>
                @if($user->hobbies == NULL)
                    <div class="no-data">@lang("No hobbies found")</div>
                @else
                    <div class="d-flex flex-wrap">
                        @foreach($hobbies as $hobby)
                            <span class="hobby-badge">{{trim($hobby)}}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Social Media Section -->
            <div class="profile-card">
                <div class="section-header">
                    <i class="fas fa-share-alt"></i>
                    <h5 class="section-title">Social Media</h5>
                </div>

                @if($user->fb == NULL && $user->twitter == NULL && $user->linkedin == NULL && $user->github == NULL && $user->insta == NULL)
                    <div class="no-data">@lang("No social media profiles found")</div>
                @else
                    <div class="row">
                        @if($user->fb != NULL)
                            <div class="col-md-6 mb-2">
                                <a href="{{$user->fb}}" class="social-link" target="_blank">
                                    <i class="fab fa-facebook text-primary"></i>Facebook
                                </a>
                            </div>
                        @endif

                        @if($user->twitter != NULL)
                            <div class="col-md-6 mb-2">
                                <a href="{{$user->twitter}}" class="social-link" target="_blank">
                                    <i class="fab fa-twitter text-info"></i>Twitter
                                </a>
                            </div>
                        @endif

                        @if($user->linkedin != NULL)
                            <div class="col-md-6 mb-2">
                                <a href="{{$user->linkedin}}" class="social-link" target="_blank">
                                    <i class="fab fa-linkedin text-primary"></i>LinkedIn
                                </a>
                            </div>
                        @endif

                        @if($user->github != NULL)
                            <div class="col-md-6 mb-2">
                                <a href="{{$user->github}}" class="social-link" target="_blank">
                                    <i class="fab fa-github text-dark"></i>GitHub
                                </a>
                            </div>
                        @endif

                        @if($user->insta != NULL)
                            <div class="col-md-6 mb-2">
                                <a href="{{$user->insta}}" class="social-link" target="_blank">
                                    <i class="fab fa-instagram text-danger"></i>Instagram
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
