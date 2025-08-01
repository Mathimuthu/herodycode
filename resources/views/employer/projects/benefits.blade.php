@extends('layouts.app')
@section('title', config('app.name').' | Post a Project - Benefits & Workplace')
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
                            <span class="label label-primary">Step 2 of 3</span>
                        </div>
                    </div>

                    <!-- Progress Steps -->
                    <div class="progress-steps">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="step-item completed">
                                    <div class="step-circle">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <div class="step-label">Information</div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="step-item active">
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
                        <!-- Progress Line -->
                        <div class="progress-line">
                            <div class="progress-line-fill" style="width: 50%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Panel Body -->
                <div class="panel-body">
                    <form action="{{route('employer.job.benefits')}}" method="POST" id="benefitsForm">
                        {!! csrf_field() !!}
                        <input type="hidden" name="pending" value="{{$pending}}">

                        <!-- Project Requirements -->
                        <div class="form-section">
                            <div class="section-header">
                                <h4><i class="fa fa-users text-primary"></i> Project Requirements</h4>
                            </div>

                            <div class="row">
                                <!-- Number of Positions -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="count" class="control-label">
                                            Number of Positions <span class="text-danger">*</span>
                                        </label>
                                        <input type="number"
                                               id="count"
                                               name="count"
                                               value="{{old('count')}}"
                                               class="form-control"
                                               placeholder="How many people do you need?"
                                               min="1"
                                               required>
                                        <p class="help-block">Number of people you want to hire for this project</p>
                                    </div>
                                </div>

                                <!-- Workplace Type -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="place" class="control-label">
                                            Work Location <span class="text-danger">*</span>
                                        </label>
                                        <select name="place" id="place" class="form-control" required>
                                            <option value="">Select work location</option>
                                            <option value="Work From Home" {{old('place') == 'Work From Home' ? 'selected' : ''}}>
                                                🏠 Work From Home
                                            </option>
                                            <option value="In-Office" {{old('place') == 'In-Office' ? 'selected' : ''}}>
                                                🏢 In-Office
                                            </option>
                                            <option value="Hybrid" {{old('place') == 'Hybrid' ? 'selected' : ''}}>
                                                🔄 Hybrid (Remote + Office)
                                            </option>
                                        </select>
                                        <p class="help-block">Where will the work be performed?</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Stipend -->
                            <div class="form-group">
                                <label for="stipend" class="control-label">
                                    Stipend/Budget <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-addon">₹</div>
                                    <input type="number"
                                           id="stipend"
                                           name="stipend"
                                           value="{{old('stipend')}}"
                                           class="form-control"
                                           placeholder="e.g., 10000"
                                           min="0"
                                           required>
                                </div>
                                <p class="help-block">Total budget or monthly stipend for this project</p>
                            </div>
                        </div>

                        <!-- Skills & Benefits -->
                        <div class="form-section">
                            <div class="section-header">
                                <h4><i class="fa fa-lightbulb-o text-success"></i> Skills & Benefits</h4>
                            </div>

                            <!-- Skills Required -->
                            <div class="form-group">
                                <label for="skills" class="control-label">
                                    Skills Required <span class="text-danger">*</span>
                                </label>
                                <textarea name="skills"
                                          id="skills"
                                          rows="4"
                                          class="form-control"
                                          placeholder="List the key skills and technologies required for this project..."
                                          required>{{old('skills')}}</textarea>
                                <p class="help-block">Specify technical skills, tools, and expertise needed</p>
                            </div>

                            <!-- Additional Benefits -->
                            <div class="form-group">
                                <label for="benefits" class="control-label">
                                    Additional Benefits
                                </label>
                                <textarea name="benefits"
                                          id="benefits"
                                          rows="4"
                                          class="form-control"
                                          placeholder="Describe any additional benefits, perks, or learning opportunities...">{{old('benefits')}}</textarea>
                                <p class="help-block">Mention certificates, recommendations, networking opportunities, etc.</p>
                            </div>
                        </div>

                        <!-- Submission Requirements -->
                        <div class="form-section">
                            <div class="section-header">
                                <h4><i class="fa fa-file-text text-purple"></i> Submission Requirements</h4>
                            </div>

                            <!-- Proof Types -->
                            <div class="form-group">
                                <label class="control-label">
                                    What proof of work do you need from applicants?
                                </label>
                                <div class="checkbox-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="proofs[]" value="File" id="file">
                                            <i class="fa fa-file-text-o"></i> File uploads (PDF, DOC, etc.)
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="proofs[]" value="Image" id="image">
                                            <i class="fa fa-image"></i> Image uploads (screenshots, designs, etc.)
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="proofs[]" value="Link" id="link">
                                            <i class="fa fa-link"></i> Links (portfolio, GitHub, websites, etc.)
                                        </label>
                                    </div>
                                </div>
                                <p class="help-block">Select what type of work samples or proofs you want to see from applicants</p>
                            </div>

                            <!-- Custom Questions -->
                            <div class="form-group">
                                <label class="control-label">
                                    Custom Questions for Applicants
                                </label>
                                <div id="qus" class="questions-container">
                                    <div class="question-item">
                                        <div class="input-group">
                                            <input type="text"
                                                   name="question[]"
                                                   class="form-control"
                                                   placeholder="Enter a question for applicants...">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" onclick="removeQuestion(this)" style="display: none;">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button"
                                        onclick="addQuestion()"
                                        class="btn btn-default btn-sm add-question-btn">
                                    <i class="fa fa-plus"></i> Add Another Question
                                </button>
                                <p class="help-block">Ask specific questions to help you evaluate applicants better</p>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button"
                                            onclick="history.back()"
                                            class="btn btn-default">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-default">
                                        Save as Draft
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        Continue to Final Step <i class="fa fa-arrow-right"></i>
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
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    // Initialize CKEditor for textareas
    CKEDITOR.replace('benefits', {
        height: 150,
        toolbar: [
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
            { name: 'insert', items: ['Link'] }
        ]
    });

    CKEDITOR.replace('skills', {
        height: 150,
        toolbar: [
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
            { name: 'insert', items: ['Link'] }
        ]
    });

    // Add question functionality
    function addQuestion() {
        var questionContainer = document.getElementById('qus');
        var newQuestion = document.createElement('div');
        newQuestion.className = 'question-item question-slide-in';
        newQuestion.innerHTML =
            '<div class="input-group">' +
                '<input type="text" name="question[]" class="form-control" placeholder="Enter a question for applicants...">' +
                '<span class="input-group-btn">' +
                    '<button type="button" class="btn btn-default" onclick="removeQuestion(this)">' +
                        '<i class="fa fa-trash text-danger"></i>' +
                    '</button>' +
                '</span>' +
            '</div>';
        questionContainer.appendChild(newQuestion);

        // Show remove button for all questions when there are multiple
        updateRemoveButtons();
    }

    function removeQuestion(button) {
        var questionItem = button.closest('.question-item');
        questionItem.classList.add('question-slide-out');
        setTimeout(function() {
            questionItem.remove();
            updateRemoveButtons();
        }, 300);
    }

    function updateRemoveButtons() {
        var questions = document.querySelectorAll('.question-item');
        questions.forEach(function(question, index) {
            var removeBtn = question.querySelector('button');
            if (questions.length > 1) {
                removeBtn.style.display = 'block';
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }

    // Form validation
    document.getElementById('benefitsForm').addEventListener('submit', function(e) {
        var count = document.getElementById('count').value;
        var place = document.getElementById('place').value;
        var stipend = document.getElementById('stipend').value;
        var skills = CKEDITOR.instances.skills.getData().trim();

        if (!count || !place || !stipend || !skills) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }

        if (parseInt(count) < 1) {
            e.preventDefault();
            alert('Number of positions must be at least 1.');
            return false;
        }

        if (parseInt(stipend) < 0) {
            e.preventDefault();
            alert('Stipend cannot be negative.');
            return false;
        }
    });

    // Initialize remove buttons visibility
    document.addEventListener('DOMContentLoaded', function() {
        updateRemoveButtons();
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
    position: relative;
}

.progress-line {
    position: absolute;
    top: 50%;
    left: 20%;
    right: 20%;
    height: 3px;
    background: #e0e0e0;
    z-index: 0;
}

.progress-line-fill {
    height: 100%;
    background: #28a745;
    transition: width 0.3s ease;
}

.step-item {
    position: relative;
    z-index: 1;
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

.step-item.completed .step-circle {
    background: #28a745;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
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

.step-item.completed .step-label {
    color: #28a745;
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

/* Input Group */
.input-group-addon {
    background: #f8f9fa;
    border-color: #bdc3c7;
    color: #495057;
}

/* Checkbox Group */
.checkbox-group {
    margin-top: 10px;
}

.checkbox {
    margin-bottom: 10px;
}

.checkbox label {
    font-weight: normal;
    color: #495057;
    display: flex;
    align-items: center;
}

.checkbox input[type="checkbox"] {
    margin-right: 8px;
}

.checkbox i {
    margin-right: 8px;
    color: #6c757d;
}

/* Questions Container */
.questions-container {
    margin-bottom: 15px;
}

.question-item {
    margin-bottom: 10px;
}

.question-slide-in {
    animation: slideIn 0.3s ease-out;
}

.question-slide-out {
    animation: slideOut 0.3s ease-in;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideOut {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-10px);
    }
}

.add-question-btn {
    margin-top: 10px;
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

.btn-default {
    border-color: #bdc3c7;
    color: #495057;
    transition: all 0.3s ease;
}

.btn-default:hover {
    background: #f8f9fa;
    border-color: #adb5bd;
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

.text-purple {
    color: #8e44ad;
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

    .progress-line {
        left: 15%;
        right: 15%;
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
