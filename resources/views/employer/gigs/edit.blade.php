@extends('layouts.app')

@section('title', config('app.name').' | Edit Gig')

@section('content')
<?php
    $employerId = Auth::guard('employer')->id();
    $user = DB::table('employers')->find($employerId);
    $cats = explode(',', $gig->cats);
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

<!-- Main Content -->
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h3 class="fw-bold text-primary mb-0">
                        <i class="fas fa-edit me-2"></i>Edit {{ $gig->campaign_title }}
                    </h3>
                </div>

                <div class="card-body">
                    <form action="{{route('employer.gig.editp',$gig->id)}}" method="post" class="needs-validation" novalidate>
                        @csrf

                        <!-- Gig Title -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Gig Title</label>
                            <input type="text" class="form-control form-control-lg" name="campaign_title"
                                   placeholder="Enter gig name" value="{{ $gig->campaign_title }}" required>
                            <div class="invalid-feedback">Please provide a gig title.</div>
                        </div>

                        <!-- Gig Description -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Gig Description</label>
                            <textarea class="form-control" name="description" id="description" rows="5" required>{{ $gig->description }}</textarea>
                            <div class="invalid-feedback">Please provide a gig description.</div>
                        </div>

                        <!-- Amount Per Person -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Amount Per Person</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" name="per_cost"
                                       placeholder="Enter amount per person" value="{{ $gig->per_cost }}" required>
                            </div>
                            <div class="invalid-feedback">Please specify the amount.</div>
                        </div>

                        <!-- Task Categories -->
                        <div class="mb-4">
                            <label class="form-label fw-bold d-block mb-3">Select Task Categories</label>
                            <div class="row">
                                @foreach($campaignCategory as $cat)
                                <div class="col-md-6 mb-3">
                                    <div class="card task-category-card">
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       id="customCheck{{$cat->id}}" name="cat[]"
                                                       value="{{$cat->id}}"
                                                       @if(in_array($cat->id,$cats)) checked @endif
                                                       onchange="newtask(this)">
                                                <label class="form-check-label fw-bold" for="customCheck{{$cat->id}}">
                                                    {{$cat->name}}
                                                </label>
                                            </div>

                                            @if(in_array($cat->id,$cats))
                                            <div class="mt-3 task-input-group">
                                                <input type="text" class="form-control mb-2" name="tasks[]"
                                                       placeholder="Task description" required>
                                                <input type="text" class="form-control" name="filess[]"
                                                       placeholder="File link to be shared" required>
                                            </div>
                                            @else
                                            <div id="{{$cat->id}}"></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i> Update Gig
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script id="taskhtml">
    <div class="mt-3 task-input-group">
        <input type="text" class="form-control mb-2" name="tasks[]" placeholder="Task description" required>
        <input type="text" class="form-control" name="filess[]" placeholder="File link to be shared" required>
    </div>
</script>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    // Initialize CKEditor
    CKEDITOR.replace('description', {
        // Custom configuration if needed
    });

    // Task checkbox functionality
    function newtask(obj){
        var a = $("#taskhtml").html();
        if($(obj).is(":checked")){
            $("#"+$(obj).attr('id').split('customCheck')[1]).append(a);
        }
        else{
            $('#'+$(obj).attr('id').split('customCheck')[1]+' .task-input-group').remove()
        }
    }

    // Form validation
    (function () {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })();
</script>

<style>
    .card {
        border-radius: 12px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
    }

    .task-category-card {
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .task-category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
    }

    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #224abe;
        border-color: #224abe;
    }

    .invalid-feedback {
        font-size: 0.85rem;
    }

    .task-input-group input {
        margin-bottom: 8px;
    }

    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.2em;
    }
</style>
@endsection
