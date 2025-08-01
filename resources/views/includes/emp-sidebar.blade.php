<?php
    $ee = Auth::guard('employer')->id();
    $user = DB::table('employers')->find($ee);
?>
<div class="sidebar-gradient d-flex flex-column" style="min-height: 100vh;">
    <!-- Logo -->
    <div class="logo-container p-3">
        <a href="{{ url('/') }}">
            <img class="showsticky" src="{{ asset('assets/main/images/Viti.png') }}" width="60px" alt="Logo" />
        </a>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav flex-grow-1">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('employer.dashboard') }}" class="nav-link {{ Request::is('employer/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('employer.profile') }}" class="nav-link {{ Request::is('employer/profile') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i>
                    <span>Company Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('employer.job.post') }}" class="nav-link {{ Request::is('employer/projects/post') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i>
                    <span>Post New Internship</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('employer.job.manage') }}" class="nav-link {{ Request::is('employer/projects') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i>
                    <span>Manage Internships</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('employer.influencercampaign.index') }}" class="nav-link {{ Request::is('employer/influencercampaign') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i>
                    <span>Manage Influencer Campaign</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('employer.influencercampaign.create') }}" class="nav-link {{ Request::is('employer/influencercampaign/post') ? 'active' : '' }}">
                    <i class="fas fa-plus-square"></i>
                    <span>Create Influencer Campaign</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('employer.campaign.create') }}" class="nav-link {{ Request::is('employer/gigs/post') ? 'active' : '' }}">
                    <i class="fas fa-plus"></i>
                    <span>Post New Gig</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('employer.campaign.manage') }}" class="nav-link {{ Request::is('employer/gigs') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i>
                    <span>Manage Gigs</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('employer.missions') }}" class="nav-link {{ Request::is('employer/campaigns') ? 'active' : '' }}">
                    <i class="fas fa-bullseye"></i>
                    <span>Manage Campaigns</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('employer.changepass') }}" class="nav-link {{ Request::is('employer/change-pass') ? 'active' : '' }}">
                    <i class="fas fa-lock"></i>
                    <span>Change Password</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('projects') }}" class="nav-link {{ Request::is('projects') ? 'active' : '' }}">
                    <i class="fas fa-briefcase"></i>
                    <span>All Internships</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('gigss') }}" class="nav-link {{ Request::is('gigs') ? 'active' : '' }}">
                    <i class="fas fa-bolt"></i>
                    <span>All Gigs</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('campaigns') }}" class="nav-link {{ Request::is('campaigns') ? 'active' : '' }}">
                    <i class="fas fa-project-diagram"></i>
                    <span>All Projects</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('employer.campaign-descriptions.index') }}" class="nav-link {{ Request::is('employer/campaign-descriptions') ? 'active' : '' }}">
                    <i class="fas fa-question-circle"></i>
                    <span>CamQuestion</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Logout at bottom -->
    <div class="logout-container p-3 mt-auto">
        <a href="{{ route('employer.logout') }}" class="nav-link text-danger">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>
