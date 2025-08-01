<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Business Login</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/main/images/Viti.png')}}">
    <link rel="stylesheet" href="{{asset('assets/viti_new/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/viti_new/css/style.css')}}">
    <!-- Responsive stylesheet -->
    <link rel="stylesheet" href="{{asset('assets/viti_new/css/responsive.css')}}">
    <script>
        window.__INITIAL_STATE__ = "{{url('/')}}";
    </script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/viti2/css/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/viti2/css/responsive.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/viti2/css/chosen.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/viti2/css/colors/colors.css')}}" />
    <!-- fontawesome css -->
    <script src="https://kit.fontawesome.com/9bfb9a77dd.js" crossorigin="anonymous"></script>
    <link href="{{asset('assets/toastr/toastr.min.css')}}" rel="stylesheet"/>
</head>
<body class="bg-gray-50 h-screen overflow-hidden">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <img src="{{ asset('assets/main/images/Viti.png') }}" alt="Logo" width="70" height="70" class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav mr-5">
                    <li class="nav-item ml-5">
                        <a class="nav-link text-dark" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item ml-5">
                        <a class="nav-link text-dark" href="{{ route('admin.job.all') }}">Internship</a>
                    </li>
                    <li class="nav-item ml-5">
                        <a class="nav-link text-dark" href="{{ route('employer.campaign.manage') }}">Employer Gigs Dashboard</a>
                    </li>
                    <li class="nav-item ml-5">
                        <a class="nav-link text-dark" href="{{ route('admin.missions') }}">Project</a>
                    </li>
                    <li class="nav-item ml-5">
                        <a href="{{route('employer.login')}}" class="post-job-btn"><i class="fa fa-plus"></i>For Business</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="account-popup-area signup-popup-box static">
                    <div class="account-popup">
                        <h3>Sign In</h3>
                        <form action="{{route('employer.login')}}" method="POST">
                            @csrf
                            <div class="cfield">
                                <input name="email" type="text" placeholder="Email" />
                                <i class="la la-envelope-o"></i>
                            </div>
                            <div class="cfield">
                                <input name="password" type="password" placeholder="Password" />
                                <i class="la la-key"></i>
                            </div>
                            <button type="submit">Sign In</button>
                        </form>
                        <div class="extra-login">
                            <span>Or</span>
                            <div class="sign-info">
                                <span class="dark-color d-inline-block line-height-2">Do not Have Account ? <a href="{{ route('employer.for-businesses') }}">Sign Up</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

