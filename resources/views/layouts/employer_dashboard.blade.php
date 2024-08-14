<!-- resources/views/layouts/employer_dashboard.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Employer Dashboard - @yield('title')</title>
    <!-- Include any required styles and scripts -->
</head>
<body>
    @include('partials.employer_navbar')
    <div class="container mt-5">
        @yield('content')
    </div>
</body>
</html>
