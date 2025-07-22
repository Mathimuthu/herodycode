@extends('layouts.app')

@section('title', config('app.name').' | Campaign')

@section('content')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.1.0/ckeditor5.css">
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-0">Create Campaign Description</h1>
                        <a href="{{ route('employer.campaign-descriptions.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Please correct the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('employer.campaign-descriptions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" name="task_name" class="form-control @error('task_name') is-invalid @enderror"
                                           id="task_name" placeholder="Task Name" value="{{ old('task_name') }}" required>
                                    <label for="task_name">Task Name</label>
                                    @error('task_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="5" required>{{ old('description') }}</textarea>
                                    <div class="form-text">Provide clear instructions for completing this campaign task.</div>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                             <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="upload_link" class="form-label">Upload Link</label>
                                    <div class="input-group">
                                        <input type="url" name="upload_link" id="upload_link"
                                               class="form-control @error('upload_link') is-invalid @enderror"
                                               value="{{ old('upload_link') }}"
                                               placeholder="https://example.com/upload">
                                    </div>
                                    @error('upload_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="sample_screenshot" class="form-label">Sample Screenshot</label>
                                    <input type="file" name="sample_screenshot" id="sample_screenshot"
                                           class="form-control @error('sample_screenshot') is-invalid @enderror"
                                           accept="image/*">
                                    <div class="form-text">Upload a sample image showing what users should expect (Max: 2MB).</div>
                                    @error('sample_screenshot')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="youtube_link" class="form-label">YouTube Tutorial Link</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                        <input type="url" name="youtube_link" id="youtube_link"
                                               class="form-control @error('youtube_link') is-invalid @enderror"
                                               value="{{ old('youtube_link') }}"
                                               placeholder="https://youtube.com/watch?v=...">
                                    </div>
                                    <div class="form-text">Optional: Add a tutorial video link to help users.</div>
                                    @error('youtube_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="gig_id" class="form-label">Cost</label>
                                    <input type="number" name="gig_id" id="gig_id"
                                           class="form-control @error('gig_id') is-invalid @enderror"
                                           value="{{ old('gig_id') }}" placeholder="Amount">
                                    <!--<div class="form-text">Optional: Associate this with an existing gig.</div>-->
                                    @error('gig_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('employer.campaign-descriptions.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Campaign Description
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 text-center">
                <p class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Campaign descriptions help workers understand what needs to be done for your tasks.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>
@endsection
