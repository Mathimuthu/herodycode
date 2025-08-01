@extends('layouts.app')
@section('title', config('app.name') . ' | Job Details')
@section('content')

<?php
$proofs = explode(',', $job->proofs);
?>
<!-- Header Section -->
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $emp->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Job Header Card -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                        <h2 class="h3 font-weight-bold text-dark mb-3 mb-md-0">{{ $job->title }}</h2>
                        <div>
                            @if(Auth::check())
                                @if(DB::table('selects')->where(['uid' => Auth::user()->id,'jid' => $job->id])->exists())
                                    <button class="btn btn-warning btn-lg" data-toggle="modal" data-target="#proofs">
                                        <i class="fas fa-file-upload mr-2"></i> Submit Proofs
                                    </button>
                                @elseif(DB::table('project_apps')->where(['uid' => Auth::user()->id,'jid' => $job->id])->exists())
                                    <a href="{{ route('user.projects.show') }}" class="btn btn-success btn-lg">
                                        <i class="fas fa-check mr-2"></i> Already Applied
                                    </a>
                                @else
                                    <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#apply">
                                        <i class="fas fa-paper-plane mr-2"></i> Apply Now
                                    </button>
                                @endif
                            @else
                                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#apply">
                                    <i class="fas fa-paper-plane mr-2"></i> Apply Now
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <!-- Company Info -->
                        <div class="col-md-8">
                            <div class="media">
                                <img src="{{ asset('assets/employer/profile_images/'.$emp['profile_photo']) }}"
                                     alt="Company Logo"
                                     class="mr-4 rounded border" width="80" height="80">
                                <div class="media-body">
                                    <h3 class="h4 font-weight-bold text-dark mb-2">{{ $emp['cname'] }}</h3>
                                    <div class="d-flex flex-wrap align-items-center mb-3">
                                        <span class="text-muted mr-3">
                                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $emp['city'] }}, {{ $emp['country'] }}
                                        </span>
                                        <span class="badge badge-primary">{{ $job->cat }}</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-users mr-2"></i> {{ $job->count }} Positions
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-calendar-alt mr-2"></i> {{ $job->duration }}
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="text-danger mb-1">
                                                <i class="fas fa-clock mr-2"></i> Apply by: {{ \Carbon\Carbon::parse($job->end)->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- About Internship -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-white">
                            <h3 class="h5 font-weight-bold text-dark mb-0">About Internship</h3>
                        </div>
                        <div class="card-body">
                            {!! $job->des !!}
                        </div>
                    </div>

                    <!-- About Company -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-white">
                            <h3 class="h5 font-weight-bold text-dark mb-0">About Company</h3>
                        </div>
                        <div class="card-body">
                            {!! $emp['description'] !!}
                        </div>
                    </div>

                    <!-- Skills Required -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-white">
                            <h3 class="h5 font-weight-bold text-dark mb-0">Skills Required</h3>
                        </div>
                        <div class="card-body">
                            {!! $job->skills !!}
                        </div>
                    </div>

                    <!-- Benefits -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-white">
                            <h3 class="h5 font-weight-bold text-dark mb-0">Internship Benefits</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <div class="bg-light rounded p-3">
                                        <i class="fas fa-certificate text-success mr-2"></i> Certificate
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="bg-light rounded p-3">
                                        <i class="fas fa-money-bill-wave text-primary mr-2"></i> Stipend: {{ $job->stipend }}
                                    </div>
                                </div>
                            </div>
                            {!! $job->benefits !!}
                        </div>
                    </div>

                    <!-- Proofs Required -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-white">
                            <h3 class="h5 font-weight-bold text-dark mb-0">Proofs Required</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($proofs as $proof)
                                    @if($proof != "")
                                        <div class="col-md-4 mb-3">
                                            <div class="bg-light rounded p-3">
                                                <i class="fas fa-check-circle text-muted mr-2"></i> {{ $proof }}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Internship Overview -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-white">
                            <h3 class="h5 font-weight-bold text-dark mb-0">Internship Overview</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="media mb-4">
                                    <div class="bg-success-light rounded-circle p-2 mr-3">
                                        <i class="fas fa-money-bill-wave text-success"></i>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="mt-0 mb-1 font-weight-bold">Offered Stipend</h5>
                                        <p class="mb-0">{{ $job->stipend }}</p>
                                    </div>
                                </li>
                                <li class="media mb-4">
                                    <div class="bg-primary-light rounded-circle p-2 mr-3">
                                        <i class="fas fa-briefcase text-primary"></i>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="mt-0 mb-1 font-weight-bold">Industry</h5>
                                        <p class="mb-0">{{ $job->cat }}</p>
                                    </div>
                                </li>
                                <li class="media mb-4">
                                    <div class="bg-purple-light rounded-circle p-2 mr-3">
                                        <i class="fas fa-map-marker-alt text-purple"></i>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="mt-0 mb-1 font-weight-bold">Work Place</h5>
                                        <p class="mb-0">{{ $job->place }}</p>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="bg-warning-light rounded-circle p-2 mr-3">
                                        <i class="fas fa-calendar-alt text-warning"></i>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="mt-0 mb-1 font-weight-bold">Start Date</h5>
                                        <p class="mb-0">{{ \Carbon\Carbon::parse($job->start)->format('d M Y') }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="card shadow">
                        <div class="card-header bg-white">
                            <h3 class="h5 font-weight-bold text-dark mb-0">Connect with Company</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                @if($emp['facebook'] != NULL)
                                    <li class="mb-2">
                                        <a href="{{ $emp['facebook'] }}" target="_blank" class="d-flex align-items-center p-2 bg-light rounded">
                                            <i class="fab fa-facebook-f text-primary mr-3"></i>
                                            <span>Facebook</span>
                                        </a>
                                    </li>
                                @endif
                                @if($emp['twitter'] != NULL)
                                    <li class="mb-2">
                                        <a href="{{ $emp['twitter'] }}" target="_blank" class="d-flex align-items-center p-2 bg-light rounded">
                                            <i class="fab fa-twitter text-info mr-3"></i>
                                            <span>Twitter</span>
                                        </a>
                                    </li>
                                @endif
                                @if($emp['linkedin'] != NULL)
                                    <li class="mb-2">
                                        <a href="{{ $emp['linkedin'] }}" target="_blank" class="d-flex align-items-center p-2 bg-light rounded">
                                            <i class="fab fa-linkedin-in text-primary mr-3"></i>
                                            <span>LinkedIn</span>
                                        </a>
                                    </li>
                                @endif
                                @if($emp['youtube'] != NULL)
                                    <li class="mb-2">
                                        <a href="{{ $emp['youtube'] }}" target="_blank" class="d-flex align-items-center p-2 bg-light rounded">
                                            <i class="fab fa-youtube text-danger mr-3"></i>
                                            <span>YouTube</span>
                                        </a>
                                    </li>
                                @endif
                                @if($emp['gplus'] != NULL)
                                    <li>
                                        <a href="{{ $emp['gplus'] }}" target="_blank" class="d-flex align-items-center p-2 bg-light rounded">
                                            <i class="fab fa-google-plus-g text-danger mr-3"></i>
                                            <span>Google+</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Apply Modal -->
<div class="modal fade" id="apply" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyModalLabel">Apply for the Internship</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('job.apply') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $job->id }}">
                <div class="modal-body">
                    @foreach($questions as $qus)
                        <div class="form-group">
                            <label>{{ $qus->question }}</label>
                            <input type="text"
                                   name="answer[]"
                                   class="form-control"
                                   placeholder="Your answer..."
                                   required>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Application</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Proof Submission Modal -->
<div class="modal fade" id="proofs" tabindex="-1" role="dialog" aria-labelledby="proofsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="proofsModalLabel">Submit Proof</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('job.proof') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $job->id }}">
                <div class="modal-body">
                    @if(in_array('Link', $proofs))
                        <div class="form-group">
                            <label><i class="fas fa-link mr-1"></i> Link</label>
                            <input type="url"
                                   name="link"
                                   class="form-control"
                                   placeholder="https://example.com">
                        </div>
                    @endif

                    @if(in_array('File', $proofs))
                        <div class="form-group">
                            <label><i class="fas fa-file mr-1"></i> File Upload</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="file" id="file" accept=".pdf,.doc,.docx,.txt">
                                <label class="custom-file-label" for="file">Choose file...</label>
                            </div>
                            <small class="form-text text-muted">PDF, DOC, DOCX, TXT files only</small>
                        </div>
                    @endif

                    @if(in_array('Image', $proofs))
                        <div class="form-group">
                            <label><i class="fas fa-image mr-1"></i> Image Upload</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" id="image" accept="image/*">
                                <label class="custom-file-label" for="image">Choose image...</label>
                            </div>
                            <small class="form-text text-muted">JPG, PNG, GIF files only</small>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Proof</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // File upload label update
    $('#file').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });

    $('#image').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });

    // Form submission loading states
    $('form').submit(function() {
        var submitButton = $(this).find('button[type="submit"]');
        submitButton.prop('disabled', true);
        submitButton.html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Processing...');
    });
</script>
@endsection
