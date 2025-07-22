@extends('layouts.app')

@section('title', config('app.name').' | Campaign')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-0">Edit Campaign Description</h1>
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

                    <form action="{{ route('employer.campaign-descriptions.update', $description->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" name="task_name" class="form-control @error('task_name') is-invalid @enderror"
                                           id="task_name" placeholder="Task Name" value="{{ old('task_name', $description->task_name) }}" required>
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
                                              rows="5" required>{{ old('description', $description->description) }}</textarea>
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
                                               value="{{ old('upload_link', $description->upload_link) }}"
                                               placeholder="https://example.com/upload">
                                    </div>
                                    @if ($description->upload_link)
                                        <div class="mt-2">
                                            <a href="{{ $description->upload_link }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                Click to View Link
                                            </a>
                                        </div>
                                    @endif
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

                                    @if ($description->sample_screenshot)
                                        <div class="mt-3">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-info me-2">Current Screenshot</span>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ asset($description->sample_screenshot) }}"
                                                       class="btn btn-outline-primary"
                                                       target="_blank">
                                                        <i class="fas fa-eye me-1"></i> View
                                                    </a>
                                                    <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#screenshotPreviewModal">
                                                        <i class="fas fa-expand me-1"></i> Preview
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-text">Upload new image to replace the current one.</div>
                                        </div>

                                        <!-- Screenshot Preview Modal -->
                                        <div class="modal fade" id="screenshotPreviewModal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Current Screenshot Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset($description->sample_screenshot) }}" class="img-fluid" alt="Screenshot Preview">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-text">No screenshot currently uploaded. Max size: 2MB.</div>
                                    @endif

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
                                               value="{{ old('youtube_link', $description->youtube_link) }}"
                                               placeholder="https://youtube.com/watch?v=...">
                                    </div>

                                    @if ($description->youtube_link)
                                        <div class="mt-2">
                                            <a href="{{ $description->youtube_link }}" class="btn btn-sm btn-outline-danger" target="_blank">
                                                <i class="fab fa-youtube me-1"></i> Watch Current Video
                                            </a>
                                        </div>
                                    @endif

                                    <div class="form-text">Optional: Add a tutorial video link to help users.</div>
                                    @error('youtube_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="gig_id" class="form-label">Gig ID</label>
                                    <input type="number" name="gig_id" id="gig_id"
                                           class="form-control @error('gig_id') is-invalid @enderror"
                                           value="{{ old('gig_id', $description->gig_id) }}" placeholder="Optional">
                                    <div class="form-text">Optional: Associate this with an existing gig.</div>
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
                            <div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Update Campaign Description
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4">
                <div class="card bg-light border-0">
                    <div class="card-body p-3">
                        <h5 class="card-title"><i class="fas fa-history me-2"></i>Edit History</h5>
                        <p class="card-text text-muted mb-0">
                            Created: {{ $description->created_at->format('M d, Y h:i A') }}
                            @if($description->updated_at && $description->updated_at != $description->created_at)
                                <br>Last Updated: {{ $description->updated_at->format('M d, Y h:i A') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
