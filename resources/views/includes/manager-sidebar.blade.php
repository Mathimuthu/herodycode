<?php
    $managerId = Auth::guard('manager')->id();
    $user = DB::table('managers')->find($managerId);
?>
<div class="sidebar-gradient d-flex flex-column" style="width: 260px;">
    <!-- Logo -->
    <div class="logo-container">
        <a href="{{ url('/') }}" title="">
            <img class="showsticky" src="{{ asset('assets/main/images/Viti.png') }}" width="60px" alt="Logo" />
        </a>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav flex-grow-1">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('manager.dashboard') }}"
                   class="nav-link {{ Request::is('manager/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href=""
                   class="nav-link {{ Request::is('manager/influencer/tasks') ? 'active' : '' }}">
                    <i class="fas fa-paper-plane"></i>
                    <span>Tasks from Employers</span>
                </a>
            </li>

            <li class="nav-item">
                <a href=""
                   class="nav-link {{ Request::is('manager/influencers') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>All Influencers</span>
                </a>
            </li>

            <li class="nav-item">
                <a href=""
                   class="nav-link {{ Request::is('manager/influencer/reports') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Campaign Reports</span>
                </a>
            </li>

            <li class="nav-item">
                <a href=""
                   class="nav-link {{ Request::is('manager/influencer/campaigns') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i>
                    <span>Manage Campaigns</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Logout at bottom -->
    <div class="logout-container">
        <a href="{{ route('manager.logout') }}" class="nav-link text-danger">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>
