@extends('layouts.app')
@section('title', config('app.name').' | For Register New Manager')
@section('content')

<section>
    <div class="block no-padding gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner2 text-center py-4">
                        <div class="inner-title2">
                            <h3>Register New Manager</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-md-8 col-lg-6">
                    <form action="{{ route('manager.create') }}" method="POST" class="p-4 border rounded bg-white shadow-sm">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Manager Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Manager Name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Manager Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Manager Email" required>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Manager Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter Manager Username" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Manager Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
                                <span class="input-group-text">
                                    <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Manager Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" required>
                        </div>

                        <!--<div class="mb-3">-->
                        <!--    <label for="team_id" class="form-label">Team ID</label>-->
                        <!--    <input type="text" name="team_id" class="form-control" placeholder="Enter Team ID" required>-->
                        <!--</div>-->

                        <div class="text-end">
                            <button type="submit" class="btn btn-success w-100">Create Manager</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    // Toggle Password Visibility
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        this.classList.toggle("fa-eye-slash");
    });
</script>

@endsection
