<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
        }
        .sidebar .nav-link:hover {
            color: #ced4da;
        }
        .sidebar .submenu {
            display: none;
            padding-left: 20px;
        }
        .sidebar .submenu .nav-link {
            padding-left: 20px;
        }
        .fa-chevron-right {
            transition: transform 0.3s ease;
        }
        .fa-chevron-down {
            transform: rotate(90deg);
        }
        .topbar {
            height: 60px;
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            margin-top: 60px;
            overflow-y: auto;
            height: calc(100vh - 60px);
        }
        .icon-container {
            text-align: center;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 10px 0;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .icon-container i {
            font-size: 3rem;
            transition: color 0.3s ease;
        }

        .icon-container:hover {
            box-shadow: 10px 10px 15px #bbff0080;
            transform: scale(1.05);
        }

        .icon-container.pending-gigs i {
            color: #ffc107; /* Yellow for pending gigs */
        }

        .icon-container.in-process-gigs i {
            color: #17a2b8; /* Teal for in-process gigs */
        }

        .icon-container.completed-gigs i {
            color: #28a745; /* Green for completed gigs */
        }

        .icon-container.all-members i {
            color: #dc3545; /* Red for all members */
        }

        .icon-container.withdraw-request i {
            color: #6c757d; /* Gray for withdraw request */
        }

        .icon-container.campaigns i {
            color: #fd7e14; /* Orange for campaigns */
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                box-shadow: none;
            }
            .topbar {
                left: 0;
                right: 0;
            }
            .main-content {
                margin: 0;
                padding-top: 60px;
                margin-top: 0;
                height: auto;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <a href="{{ route('dashbord') }}"><h2>Dashboard</h2></a>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('gigs.index') }}" id="gigs-toggle">
                    <span><i class="fas fa-home"></i> Gigs</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
                <ul class="nav flex-column submenu" id="gigs-submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gigs.create') }}"><i class="fas fa-plus"></i> Add Gig</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gigs.index') }}"><i class="fas fa-edit"></i> Manage Gigs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.gigs.pendings') }}"><i class="fas fa-edit"></i> Pending Gigs</a>
                    </li>
                   
                    <!-- Export Button -->
                        

                </ul>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="" id="internships-toggle">
                    <span><i class="fas fa-home"></i> Internships</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
                <ul class="nav flex-column submenu" id="internships-submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('internships.index') }}"><i class="fas fa-edit"></i> Manage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pending-internships.index') }}"><i class="fas fa-edit"></i> Pending</a>
                    </li>
                    
                    
                </ul>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('employees.index') }}">
                        <span><i class="fas fa-users"></i> Employees</span>
                    </a>
                </li>
            </li>
        </ul>
    </div>

    <div class="topbar">
        <h3>ADMIN</h3>
    </div>

    <main class="main-content container-fluid">
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @stack('scripts')
    <script>
        $(document).ready(function(){
            $('#gigs-toggle').on('click', function(e){
                e.preventDefault();
                var submenu = $('#gigs-submenu');
                submenu.slideToggle();
                $(this).find('.fa-chevron-right').toggleClass('fa-chevron-down');
            });

            $('#internships-toggle').on('click', function(e){
                e.preventDefault();
                var submenu = $('#internships-submenu');
                submenu.slideToggle();
                $(this).find('.fa-chevron-right').toggleClass('fa-chevron-down');
            });
        });
    </script>
</body>
</html>
