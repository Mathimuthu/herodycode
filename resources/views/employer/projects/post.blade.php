@extends('layouts.app')
@section('title', config('app.name').' | Post an Project')
<?php
    $employerId = Auth::guard('employer')->id();
    $user = DB::table('employers')->find($employerId);
?>
@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="fa fa-check-circle"></i> {!! session('success') !!}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="fa fa-exclamation-circle"></i> {!! session('error') !!}
        </div>
    @endif

    <!-- Welcome Card -->
    <div class="mb-4">
        <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $user->name }}</h1>
                <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
            </div>
        </div>
    </div>

    <!-- Main Form Panel -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <!-- Panel Header -->
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="panel-title">Post a New Project</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <span class="label label-primary">Step 1 of 3</span>
                        </div>
                    </div>

                    <!-- Progress Steps -->
                    <div class="progress-steps">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="step-item active">
                                    <div class="step-circle">
                                        <i class="fa fa-info-circle"></i>
                                    </div>
                                    <div class="step-label">Information</div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="step-item">
                                    <div class="step-circle">
                                        <i class="fa fa-building"></i>
                                    </div>
                                    <div class="step-label">Benefits & Workplace</div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="step-item">
                                    <div class="step-circle">
                                        <i class="fa fa-check-circle"></i>
                                    </div>
                                    <div class="step-label">Done</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel Body -->
                <div class="panel-body">
                    <form action="{{route('employer.job.post')}}" method="POST" id="projectForm">
                        {!! csrf_field() !!}

                        <!-- Project Basic Information -->
                        <div class="form-section">
                            <div class="section-header">
                                <h4><i class="fa fa-file-text-o text-primary"></i> Project Information</h4>
                            </div>

                            <!-- Project Title -->
                            <div class="form-group">
                                <label for="title" class="control-label">
                                    Project Title <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       id="title"
                                       name="title"
                                       value="{{old('title')}}"
                                       class="form-control"
                                       placeholder="Enter a descriptive project title"
                                       required>
                                <p class="help-block">Choose a clear, specific title that describes your project</p>
                            </div>

                            <!-- Project Description -->
                            <div class="form-group">
                                <label for="des" class="control-label">
                                    Project Description <span class="text-danger">*</span>
                                </label>
                                <textarea name="des"
                                          id="des"
                                          rows="6"
                                          class="form-control"
                                          placeholder="Describe your project in detail - include objectives, requirements, deliverables, and any special instructions"
                                          required>{{old('des')}}</textarea>
                                <p class="help-block">Provide comprehensive details to attract the right candidates</p>
                            </div>

                            <!-- Category -->
                            <div class="form-group">
                                <label for="cat" class="control-label">
                                    Project Category <span class="text-danger">*</span>
                                </label>
                                <select name="cat" id="cat" class="form-control" required>
                                    <option value="">Select a category</option>
                                    @foreach($cats as $cat)
                                        <option value="{{$cat}}" <?php if(old('cat')==$cat){ echo 'selected'; } ?>>{{$cat}}</option>
                                    @endforeach
                                </select>
                                <p class="help-block">Choose the most relevant category for your project</p>
                            </div>
                        </div>

                        <!-- Timeline & Duration -->
                        <div class="form-section">
                            <div class="section-header">
                                <h4><i class="fa fa-clock-o text-success"></i> Timeline & Duration</h4>
                            </div>

                            <div class="row">
                                <!-- Project Start Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start" class="control-label">
                                            Project Start Date <span class="text-danger">*</span>
                                        </label>
                                        <input type="date"
                                               id="start"
                                               name="start"
                                               value="{{old('start')}}"
                                               class="form-control"
                                               required>
                                        <p class="help-block">When do you want the project to begin?</p>
                                    </div>
                                </div>

                                <!-- Apply Before Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end" class="control-label">
                                            Application Deadline <span class="text-danger">*</span>
                                        </label>
                                        <input type="date"
                                               id="end"
                                               name="end"
                                               value="{{old('end')}}"
                                               class="form-control"
                                               required>
                                        <p class="help-block">Last date for receiving applications</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Project Duration -->
                            <div class="form-group">
                                <label for="duration" class="control-label">
                                    Project Duration <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       id="duration"
                                       name="duration"
                                       value="{{old('duration')}}"
                                       class="form-control"
                                       placeholder="e.g., 3 months, 6 weeks, 1 year"
                                       required>
                                <p class="help-block">Expected duration for project completion</p>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <span class="text-danger">*</span> Required fields
                                    </small>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        Continue to Next Step <i class="fa fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('assets/main/js/world.js')}}"></script>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    // Initialize CKEditor for description
    CKEDITOR.replace('des', {
        height: 250,
        toolbar: [
            { name: 'document', items: ['Source'] },
            { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'Undo', 'Redo'] },
            { name: 'editing', items: ['Find', 'Replace'] },
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight'] },
            { name: 'insert', items: ['Link', 'Unlink'] },
            { name: 'styles', items: ['Format', 'FontSize'] }
        ],
        placeholder: 'Describe your project in detail - include objectives, requirements, deliverables, and any special instructions...'
    });

    // Form validation
    document.getElementById('projectForm').addEventListener('submit', function(e) {
        var title = document.getElementById('title').value.trim();
        var category = document.getElementById('cat').value;
        var start = document.getElementById('start').value;
        var end = document.getElementById('end').value;
        var duration = document.getElementById('duration').value.trim();

        if (!title || !category || !start || !end || !duration) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }
    });
</script>

<style>
.panel-default {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 8px;
}

.panel-heading {
    background: #fff;
    border-bottom: 1px solid #e5e5e5;
    border-radius: 8px 8px 0 0;
    padding: 20px;
}

.panel-title {
    font-size: 24px;
    font-weight: bold;
    color: #2c3e50;
    margin: 0;
}

/* Progress Steps */
.progress-steps {
    margin-top: 30px;
    padding: 20px 0;
}

.step-item {
    position: relative;
}

.step-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #bdc3c7;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-size: 18px;
    transition: all 0.3s ease;
}

.step-item.active .step-circle {
    background: #3498db;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
}

.step-label {
    font-size: 12px;
    font-weight: 600;
    color: #7f8c8d;
    text-align: center;
}

.step-item.active .step-label {
    color: #3498db;
}

/* Form Sections */
.form-section {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 25px;
    margin-bottom: 20px;
    border-left: 4px solid #3498db;
}

.section-header h4 {
    margin: 0 0 20px 0;
    color: #2c3e50;
    font-weight: 600;
}

/* Form Controls */
.form-control {
    border-radius: 6px;
    border: 1px solid #bdc3c7;
    padding: 4px 15px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

.help-block {
    color: #7f8c8d;
    font-size: 12px;
    margin-top: 5px;
}

.control-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
}

/* Form Actions */
.form-actions {
    margin-top: 30px;
    padding-top: 20px;
}

.btn-primary {
    background: #3498db;
    border-color: #3498db;
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #2980b9;
    border-color: #2980b9;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
}

/* Alert Styles */
.alert {
    border-radius: 8px;
    border: none;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border-left: 4px solid #dc3545;
}

/* Responsive Design */
@media (max-width: 768px) {
    .manager-avatar {
        display: block;
        margin: 10px auto;
    }

    .step-circle {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }

    .form-section {
        padding: 15px;
    }

    .panel-heading {
        padding: 15px;
    }
}

/* CKEditor Customization */
.cke_chrome {
    border: 1px solid #bdc3c7 !important;
    border-radius: 6px !important;
}

.cke_chrome:focus-within {
    border-color: #3498db !important;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1) !important;
}
</style>
@endsection
