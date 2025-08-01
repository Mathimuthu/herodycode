<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manager Register</title>
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
                        <a class="nav-link text-dark" href="">Internship</a>
                    </li>
                    <li class="nav-item ml-5">
                        <a class="nav-link text-dark" href="">Project</a>
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
                        <h3>Manager Register</h3>
                        <form action="{{ route('manager.create') }}" method="POST" class="p-4 border rounded bg-white shadow-sm">
                        @csrf
                            <div class="cfield">
                                <input type="text" name="name" class="form-control" placeholder="Enter Manager Name" required>
                            </div>
                            <div class="cfield">
                                <input type="email" name="email" class="form-control" placeholder="Enter Manager Email" required>
                            </div>
                            <div class="cfield">
                                <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" required>
                            </div>
                            <div class="cfield">
                                <input type="text" name="username" class="form-control" placeholder="Enter Manager Username" required>
                            </div>
                            <div class="cfield">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
                                    <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                            </div>
                            <button type="submit">Create Manager</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            this.classList.toggle("fa-eye-slash");
        });
    </script>
</body>
</html>
