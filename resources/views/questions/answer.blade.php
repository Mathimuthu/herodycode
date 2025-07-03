@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Campaign Header -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        Campaign Responses: {{ $campaign->task_name }}
                    </h4>
                    <a href="{{ route('employer.campaign-descriptions.index') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Back to Campaigns
                    </a>
                </div>
                
                <div class="card-body">
                    <h5 class="card-title mb-4">Campaign Details</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Task Name:</strong> {{ $campaign->task_name }}</p>
                            <p class="mb-2"><strong>Description:</strong> {{ $campaign->description }}</p>
                        </div>
                    </div>
                    
                    @if($groupedAnswers->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> No answers submitted yet.
                        </div>
                    @else
                        <h5 class="card-title mb-3">Submission Responses</h5>
                        
                        @php
                            // Group submissions by referral code, user ID, and user name, preserving submission times with answers
                            $uniqueSubmissions = [];
                            foreach ($groupedAnswers as $timestamp => $submissionAnswers) {
                                $parts = explode('_', $timestamp);
                                $referralCode = $parts[0];
                                $submissionTime = $parts[1] ?? '';
                                $userInfo = $referralUserMap[$referralCode] ?? ['user_id' => null, 'name' => null,'is_evaluated' => null];
                                $key = $referralCode . '_' . ($userInfo['user_id'] ?? '') . '_' . ($userInfo['name'] ?? '');
                                if (!isset($uniqueSubmissions[$key])) {
                                    $uniqueSubmissions[$key] = [
                                        'referralCode' => $referralCode,
                                        'userId' => $userInfo['user_id'],
                                        'userName' => $userInfo['name'],
                                        'is_evaluated' => $userInfo['is_evaluated'],
                                        'answers' => [],
                                        'times' => []
                                    ];
                                }
                                // Associate each answer with its submission time
                                foreach ($submissionAnswers as $answer) {
                                    $uniqueSubmissions[$key]['answers'][] = [
                                        'time' => $submissionTime,
                                        'answer' => $answer
                                    ];
                                }
                                $uniqueSubmissions[$key]['times'][] = $submissionTime;
                            }
                        @endphp
                        
                        @foreach($uniqueSubmissions as $submission)
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Submissions for {{ $submission['referralCode'] }}</h6>
                                        <span class="badge bg-secondary">{{ $submission['referralCode'] }}</span>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                <!-- Add Balance Form per User -->
                                <form action="{{ route('employer.add-balance') }}" method="POST" class="row mb-3 g-2">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $submission['userId'] }}">
                                    
                                    <div class="col-md-3 col-sm-6">
                                        <input type="number" name="amount" class="form-control form-control-sm" placeholder="Enter amount" required>
                                    </div>
                                    
                                    <div class="col-md-auto col-sm-6">
                                        <button type="submit" class="btn btn-sm btn-success w-100">Add Balance</button>
                                    </div>
                                </form>
                                    <!-- Combined Single Table -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Created at</th>
                                                    <th>Referral Code</th>
                                                    <th>User ID</th>
                                                    <th>User Name</th>
                                                    <th>Evaluate Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ implode(', ', array_map(function ($time) { return date('Y-m-d', strtotime($time)); }, array_unique($submission['times']))) }}</td>
                                                    <td>{{ $submission['referralCode'] }}</td>
                                                    <td>
                                                        @if($submission['userId'])
                                                            {{ $submission['userId'] }}
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($submission['userName'])
                                                            {{ $submission['userName'] }}
                                                        @else
                                                            <span class="text-muted">No user information</span>
                                                        @endif
                                                    </td>
                                                     <td>
                                                        @if($submission['is_evaluated'] == '1')
                                                            <form action="{{ route('employer.referral_evaluate') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="referral_code" value="{{ $submission['referralCode'] }}">
                                                                <input type="hidden" name="is_evaluated" value="0">
                                                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                                                    Evaluated
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('employer.referral_evaluate') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="referral_code" value="{{ $submission['referralCode'] }}">
                                                                <input type="hidden" name="is_evaluated" value="1">
                                                                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">
                                                                    Evaluate
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                    @if(session('success'))
                                                        <div class="alert alert-success mt-2">
                                                            {{ session('success') }}
                                                        </div>
                                                    @endif

                                                </tr>
                                                <tr>
                                                    <th>Submission at</th>
                                                    <th>Question</th>
                                                    <th colspan="2">Answer</th>
                                                </tr>
                                                @php
                                                    $seenQuestions = [];
                                                @endphp
                                                @foreach($questions as $question)
                                                    @php
                                                        $answersForQuestion = array_filter($submission['answers'], function ($item) use ($question) {
                                                            return isset($item['answer']) && $item['answer']->question_id == $question->id;
                                                        });
                                                        
                                                        // Keep the full answer objects in uniqueAnswers
                                                        $uniqueAnswers = [];
                                                        foreach ($answersForQuestion as $item) {
                                                            $uniqueAnswers[$item['time']] = $item['answer'];
                                                        }
                                                    @endphp
                                                    @if (!in_array($question->id, $seenQuestions))
                                                        <tr>
                                                            <td>
                                                                @foreach(array_keys($uniqueAnswers) as $time)
                                                                    {{ date('Y-m-d', strtotime($time)) }}<br>
                                                                @endforeach
                                                                @if (empty($uniqueAnswers))
                                                                      <!-- Empty cell if no answers -->
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $question->text }}
                                                                @if($question->required)
                                                                    <span class="text-danger">*</span>
                                                                @endif
                                                                <div class="text-muted small mt-1">
                                                                    Type: {{ ucfirst($question->type) }}
                                                                </div>
                                                                @php
                                                                    $seenQuestions[] = $question->id;
                                                                @endphp
                                                            </td>
                                                            <td colspan="2">
                                                                @if (!empty($uniqueAnswers))
                                                                   @foreach($uniqueAnswers as $time => $answerObj)
                                                                        @if($question->type == 'file' && $answerObj->response)
                                                                            <a href="{{ asset($answerObj->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                                <i class="fas fa-file-download me-1"></i> View File
                                                                            </a>
                                                                        <br>
                                                                        @elseif($question->type == 'image' && $answerObj->response)
                                                                            <img src="{{ asset($answerObj->file_path) }}" class="img-thumbnail" style="max-height: 100px;"><br>
                                                                        @elseif($question->type == 'checkbox' && $answerObj->response)
                                                                            @php
                                                                                $checkboxValues = json_decode($answerObj->response, true);
                                                                            @endphp
                                                                            @if(is_array($checkboxValues))
                                                                                {{ implode(', ', $checkboxValues) }} (at {{ date('Y-m-d', strtotime($time)) }})<br>
                                                                            @else
                                                                                {{ $answerObj->response }} (at {{ date('Y-m-d', strtotime($time)) }})<br>
                                                                            @endif
                                                                        @else
                                                                            {{ $answerObj->response ?? 'No response found' }} (at {{ date('Y-m-d', strtotime($time)) }})<br>
                                                                        @endif
                                                                        {{-- Approve / Reject Buttons --}}
                                                                        <div class="d-flex gap-2 my-2">
                                                                            <form method="POST" class="update-status-form">
                                                                                @csrf
                                                                                <input type="hidden" name="answer_id" value="{{ $answerObj->id }}">
                                                                                <input type="hidden" name="status" value="1">
                                                                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                                                                    ✅ Approve
                                                                                </button>
                                                                            </form>

                                                                            <form method="POST" class="update-status-form">
                                                                                @csrf
                                                                                <input type="hidden" name="answer_id" value="{{ $answerObj->id }}">
                                                                                <input type="hidden" name="status" value="0">
                                                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">
                                                                                    ❌ Reject
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                        <hr>
                                                                    @endforeach
                                                                @else
                                                                    <span class="text-muted">No answer provided</span>
                                                                @endif
                                                            </td>                                                           
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.update-status-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(form);

            fetch("{{ route('answer.status') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const statusWrapper = form.closest('.d-flex').querySelector('.answer-status');
                    const selectedStatus = form.querySelector('input[name="status"]').value;
                    if (statusWrapper) {
                       if (selectedStatus === "1") {
                            statusWrapper.innerHTML = `Status: <span class="text-success">Accepted</span>`;
                        } else if (selectedStatus === "0") {
                            statusWrapper.innerHTML = `Status: <span class="text-danger">Rejected</span>`;
                        } else if (selectedStatus === "") {
                            statusWrapper.innerHTML = `Status: <span class="text-warning">Pending</span>`;
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error updating status:', error);
            });
        });
    });
});
</script>
@endsection