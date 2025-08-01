@extends('layouts.app')
@section('title', config('app.name') . ' | Create Influencer Campaign')
@section('content')
<?php
    $employerId = Auth::guard('employer')->id();
    $user = DB::table('employers')->find($employerId);
?>

<!-- Header Section (unchanged as requested) -->
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $user->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h3 class="fw-bold text-primary mb-0">
                        <i class="fas fa-plus-circle mr-2"></i>Create New Influencer Campaign
                    </h3>
                </div>

                <div class="card-body">
                    <form action="{{route('employer.influencercampaign.create')}}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="employer_id" value="{{ $employer->id }}">

                        <!-- Campaign Title -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Campaign Title</label>
                            <input type="text" class="form-control form-control-lg" name="campaign_title"
                                   placeholder="Enter campaign title" required>
                            <div class="invalid-feedback">Please provide a campaign title.</div>
                        </div>

                        <!-- Campaign Description -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Campaign Description</label>
                            <textarea class="form-control" name="description" id="description" rows="5" required></textarea>
                            <div class="invalid-feedback">Please provide a campaign description.</div>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload File</label>
                            <input type="file" class="form-control" name="upload" required>
                            <div class="invalid-feedback">Please upload a file.</div>
                        </div>

                        <!-- Platforms Section -->
                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Select Platforms</label>
                            <div class="d-flex flex-wrap gap-3 platform-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input platform-checkbox" type="checkbox" id="youtubeCheck" value="Youtube">
                                    <label class="form-check-label" for="youtubeCheck">
                                        <i class="fab fa-youtube text-danger me-1"></i> YouTube
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input platform-checkbox" type="checkbox" id="instagramCheck" value="Instagram">
                                    <label class="form-check-label" for="instagramCheck">
                                        <i class="fab fa-instagram text-purple me-1"></i> Instagram
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input platform-checkbox" type="checkbox" id="linkedinCheck" value="Linkedin">
                                    <label class="form-check-label" for="linkedinCheck">
                                        <i class="fab fa-linkedin text-primary me-1"></i> LinkedIn
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input platform-checkbox" type="checkbox" id="twitterCheck" value="Twitter">
                                    <label class="form-check-label" for="twitterCheck">
                                        <i class="fab fa-twitter text-info me-1"></i> Twitter
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Platform URL Inputs -->
                        <div id="YoutubeInput" class="mb-3 platform-input" style="display: none;">
                            <label class="form-label">YouTube URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-youtube text-danger"></i></span>
                                <input type="url" class="form-control" name="youtubeUrl"
                                       placeholder="https://youtube.com/your-channel">
                            </div>
                        </div>

                        <div id="InstagramInput" class="mb-3 platform-input" style="display: none;">
                            <label class="form-label">Instagram URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-instagram text-purple"></i></span>
                                <input type="url" class="form-control" name="instagramUrl"
                                       placeholder="https://instagram.com/your-profile">
                            </div>
                        </div>

                        <div id="LinkedinInput" class="mb-3 platform-input" style="display: none;">
                            <label class="form-label">LinkedIn URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-linkedin text-primary"></i></span>
                                <input type="url" class="form-control" name="linkedinUrl"
                                       placeholder="https://linkedin.com/your-profile">
                            </div>
                        </div>

                        <div id="TwitterInput" class="mb-4 platform-input" style="display: none;">
                            <label class="form-label">Twitter URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-twitter text-info"></i></span>
                                <input type="url" class="form-control" name="twitterUrl"
                                       placeholder="https://twitter.com/your-profile">
                            </div>
                        </div>

                        <!-- Collaboration Type -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Collaboration Type</label>
                            <select class="form-select" name="collab_type" required>
                                <option value="">Choose Collaboration Type</option>
                                <option value="Barter">Barter</option>
                                <option value="paid">Paid</option>
                            </select>
                            <div class="invalid-feedback">Please select a collaboration type.</div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-paper-plane me-1"></i> Create Campaign
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
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    // Initialize CKEditor
    CKEDITOR.replace('description', {
        // Custom configuration if needed
    });

    // Platform checkbox toggles
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.platform-checkbox');
        const platformInputs = {
            Youtube: document.getElementById('YoutubeInput'),
            Instagram: document.getElementById('InstagramInput'),
            Linkedin: document.getElementById('LinkedinInput'),
            Twitter: document.getElementById('TwitterInput'),
        };

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const platform = checkbox.value;
                if (platformInputs[platform]) {
                    platformInputs[platform].style.display = checkbox.checked ? 'block' : 'none';
                }
            });
        });

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
    });
</script>

<style>
    .platform-group .form-check-label {
        display: flex;
        align-items: center;
    }

    .platform-input {
        transition: all 0.3s ease;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 5px 15px;
    }

    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    .btn-primary:hover {
        background-color: #224abe;
        border-color: #224abe;
    }

    .invalid-feedback {
        font-size: 0.85rem;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
    }
</style>
@endsection
