<?php
    $managerId = Auth::guard('manager')->id();
    $user = DB::table('managers')->find($managerId);
?>

<div class="col-sm-12 col-lg-4 col-xl-4 dn-smd" style="background-color: #001f3f; color: white; min-height: 100vh;">
    {{-- User Profile --}}
    <div class="user_profile text-center py-4" style="background-color: transparent;">
        <div class="media d-block">
            <i class="fas fa-user-circle" style="font-size: 80px; color: white;"></i>
        </div>
        <h5 class="mt-3" style="color: white;">Hi, {{ $user->name }}</h5>
    </div>

    {{-- Navigation --}}
    <div class="dashbord_nav_list">
        <ul>
            <li class="{{ Request::is('manager/dashboard') ? 'active' : '' }}">
                <a href="{{ route('manager.dashboard') }}" style="color: white;">
                    <span class="flaticon-dashboard"></span> Dashboard
                </a>
            </li>

            <li class="{{ Request::is('manager/influencer/tasks') ? 'active' : '' }}">
                <a href="#" style="color: white;">
                    <span class="flaticon-paper-plane"></span> Tasks from Employers
                </a>
            </li>

            <li class="{{ Request::is('manager/influencers') ? 'active' : '' }}">
                <a href="#" style="color: white;">
                    <span class="flaticon-user"></span> All Influencers
                </a>
            </li>

            <li class="{{ Request::is('manager/influencer/reports') ? 'active' : '' }}">
                <a href="#" style="color: white;">
                    <i class="fas fa-chart-line"></i> Campaign Reports
                </a>
            </li>

            <li class="{{ Request::is('manager/influencer/campaigns') ? 'active' : '' }}">
                <a href="#" style="color: white;">
                    <i class="fas fa-bullhorn"></i> Manage Campaigns
                </a>
            </li>

            <li>
                <a href="{{ route('manager.logout') }}" style="color: white;">
                    <span class="flaticon-logout"></span> Logout
                </a>
            </li>
        </ul>
    </div>
</div>
