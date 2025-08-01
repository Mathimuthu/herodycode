<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/main/images/Viti.png') }}">

    <!-- Bootstrap 4 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/toastr/toastr.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        body, html {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
            /* width: 256px; */
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
        }

        .main-wrapper {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 1.5rem;
        }

        .sidebar-nav {
            padding: 0 1.5rem;
            margin-top: 2rem;
        }

        .sidebar-nav .nav-link {
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            margin: 0.125rem -1.5rem;
            border-radius: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            border: none;
            background: transparent;
        }

        .sidebar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            text-decoration: none;
        }

        .sidebar-nav .nav-link.active {
            background-color: #f8f9fa;
            color: #1f2937;
            font-weight: 500;
            border-top-left-radius: 2rem;
            border-bottom-left-radius: 2rem;
            margin-left: -1.5rem;
            padding-left: 3rem;
        }

        .sidebar-nav .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
        }

        .logo-container {
            padding: 1.5rem;
            text-align: center;
        }

        .logout-container {
            margin-top: auto;
            padding: 2rem 1.5rem 1.5rem;
        }

        .header-nav {
            background: transparent;
            padding: 2rem 1.5rem;
            border-bottom: none;
        }

        .header-nav .navbar-nav {
            margin-left: auto;
        }

        .header-nav .nav-link {
            color: #1f2937;
            font-weight: 500;
            margin: 0 0.75rem;
            padding: 0.5rem 0;
            transition: color 0.3s ease;
        }

        .header-nav .nav-link:hover {
            color: #2563eb;
            text-decoration: none;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        }

      @media (max-width: 768px) {
        .sidebar-gradient {
            width: 100%;
            height: auto;
            position: relative;
            z-index: 999;
        }

        .main-wrapper {
            margin-left: 0 !important;
            padding-top: 0; /* Optional */
        }

        .main-content {
            padding: 1rem 1rem;
        }

        .sidebar-nav .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .sidebar-nav .nav-link.active {
            border-radius: 0.5rem;
            margin-left: 0;
            padding-left: 1.25rem;
        }

        .header-nav {
            padding: 1rem 1rem;
        }

        .welcome-card {
            text-align: center;
            padding: 1.5rem;
        }

        .upload-form {
            flex-direction: column;
            align-items: stretch;
        }

        .file-input {
            width: 100%;
        }

        .campaign-table td {
            padding: 0.5rem !important;
            font-size: 0.8rem;
        }

        .table-title h2 {
            font-size: 1.1rem;
        }

        .btn-upload {
            width: 100%;
        }

        .manager-avatar {
            max-width: 150px;
            margin-top: 1rem;
        }

        .d-flex.justify-content-between {
            flex-direction: column;
            align-items: center;
        }

        .table-responsive {
            overflow-x: auto;
        }
    }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @if(Auth::guard('employer')->check())
            @include('includes.emp-sidebar')
        @else
            @include('includes.manager-sidebar')
        @endif

        <!-- Main Content Wrapper -->
        <div class="main-wrapper">
            <!-- Header -->
            @if(Auth::guard('employer')->check())
                @include('includes.header-employer')
            @else
                @include('includes.header-manager')
            @endif

            <!-- Page Content -->
            <main class="main-content">
                @yield('content')
            </main>
        </div>
    </div>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Local Assets -->
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/jquery-3.3.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/jquery-migrate-3.0.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/jquery.mmenu.all.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/ace-responsive-menu.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/snackbar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/simplebar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/tagsinput.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/parallax.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/scrollto.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/jquery-scrolltofixed-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/jquery.counterup.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/progressbar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/slider.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/timepicker.js') }}"></script>
    <!-- Custom script for all pages -->
    <script type="text/javascript" src="{{ asset('assets/viti_new/js/script.js') }}"></script>

    <script src="{{ asset('assets/viti2/js/modernizr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/viti2/js/script.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/user/js/mnav.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/toastr/toastr.min.js') }}"></script>

    <script>
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}")
        @endif

        @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}")
        @endif

        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}")
            @endforeach
        @endif
    </script>

    @stack('scripts')
    @yield('scripts')
</body>
</html>
