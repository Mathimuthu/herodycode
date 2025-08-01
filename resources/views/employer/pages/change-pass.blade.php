@extends('layouts.app')
@section('title',config('app.name').' | Change Password')

@section('content')
<?php
    $employerId = Auth::guard('employer')->id();
    $user = DB::table('employers')->find($employerId);
?>
<!-- Header Section -->
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $user->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>
<div class="container-fluid px-4">
      <div class="row justify-content-center">
        <div class="col-sm-12 col-lg-8 col-xl-9">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Change Password </h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form method="POST" action="{{route('employer.changepass')}}">
                  @csrf
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <span class="form-control-label" for="opass">Current Password</span>
                    <div class="input-group mb-3">
                      <input type="password" id="password" name="opass" class="form-control" placeholder="Current Password">
                      <span class="input-group-text">
                        <i class="far fa-eye" id="togglePassword"
                       style="cursor: pointer"></i>
                       </span>
                     </div>
                    </div>
                  </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <span class="form-control-label" for="password">New Password</span>
                        <div class="input-group mb-3">
                      <input type="password" id="npassword" name="password" class="form-control" placeholder="New Password">
                      <span class="input-group-text">
                        <i class="far fa-eye" id="togglePasswordn"
                       style="cursor: pointer"></i>
                       </span>
                     </div>
                    </div>
                      </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <span class="form-control-label" for="repass">Repeat New Password</span>
                        <div class="input-group mb-3">
                      <input type="password" id="rpassword" name="repass" class="form-control" placeholder="Repeat New Password">
                      <span class="input-group-text">
                        <i class="far fa-eye" id="togglePasswordr"
                       style="cursor: pointer"></i>
                       </span>
                     </div>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-success">Change Password</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
    </div>
    @endsection
@section('scripts')
<script type="text/javascript">
  const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {

    // toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    // toggle the eye icon
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
    });
    const togglePassword1 = document.querySelector("#togglePasswordn");
    const password1 = document.querySelector("#npassword");

    togglePassword1.addEventListener("click", function () {

    // toggle the type attribute
    const type1 = password1.getAttribute("type") === "password" ? "text" : "password";
    password1.setAttribute("type", type1);
    // toggle the eye icon
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
    });
    const togglePassword2 = document.querySelector("#togglePasswordr");
    const password2 = document.querySelector("#rpassword");

    togglePassword2.addEventListener("click", function () {

    // toggle the type attribute
    const type2 = password2.getAttribute("type") === "password" ? "text" : "password";
    password2.setAttribute("type", type2);
    // toggle the eye icon
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
    });
</script>
@endsection
