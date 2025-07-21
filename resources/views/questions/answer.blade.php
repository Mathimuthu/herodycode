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
                            $uniqueSubmissions = [];
                            foreach ($groupedAnswers as $timestamp => $submissionAnswers) {
                                $parts = explode('_', $timestamp);
                                $referralCode = $parts[0];
                                $submissionTime = $parts[1] ?? '';
                                $userInfo = $referralUserMap[$referralCode] ?? ['user_id' => null, 'name' => null, 'is_evaluated' => null];
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

                                <form action="{{ route('employer.add-balance') }}" method="POST" class="row mb-3 g-2">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $submission['userId'] ?? '' }}">
                                    <input type="hidden" name="task_id" value="{{ $campaign->id }}"> 
                                    
                                    <div class="col-md-3 col-sm-6">
                                        <input type="number" name="amount" class="form-control form-control-sm" placeholder="Enter amount" required>
                                    </div>
                                    <div class="col-md-auto col-sm-6">
                                        <button type="submit" class="btn btn-sm btn-success w-100">Add Balance</button>
                                    </div>
                                </form>



                                    <!-- Added Referral Info Table -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-4">
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
                                                    <td>{{ implode(', ', array_map(fn($time) => date('Y-m-d', strtotime($time)), array_unique($submission['times']))) }}</td>
                                                    <td>{{ $submission['referralCode'] }}</td>
                                                    <td>{{ $submission['userId'] ?? 'N/A' }}</td>
                                                    <td>{{ $submission['userName'] ?? 'No user information' }}</td>
                                                    <td>
                                                        @if($submission['is_evaluated'] == '1')
                                                            <form action="{{ route('employer.referral_evaluate') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="referral_code" value="{{ $submission['referralCode'] }}">
                                                                <input type="hidden" name="is_evaluated" value="0">
                                                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">Evaluated</button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('employer.referral_evaluate') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="referral_code" value="{{ $submission['referralCode'] }}">
                                                                <input type="hidden" name="is_evaluated" value="1">
                                                                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Evaluate</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Answer Table -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Submission at</th>
                                                    @foreach($questions as $question)
                                                        <th>
                                                            {{ $question->text }}
                                                            @if($question->required)
                                                                <span class="text-danger">*</span>
                                                            @endif
                                                            <div class="text-muted small">Type: {{ ucfirst($question->type) }}</div>
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $groupedByTime = [];
                                                    foreach ($submission['answers'] as $entry) {
                                                        $groupedByTime[$entry['time']][] = $entry['answer'];
                                                    }
                                                @endphp
                                                @foreach($groupedByTime as $submissionTime => $answersSet)
                                                    <tr>
                                                        <td>{{ date('Y-m-d', strtotime($submissionTime)) }}</td>
                                                        @foreach($questions as $question)
                                                            @php
                                                                $answer = collect($answersSet)->firstWhere('question_id', $question->id);
                                                            @endphp
                                                            <td>
                                                                @if($answer)
                                                                    @if($question->type == 'file' && $answer->response)
                                                                        <a href="{{ asset($answer->file_path) }}" target="_blank">View File</a>
                                                                    @elseif($question->type == 'image' && $answer->response)
                                                                        <a href="{{ asset($answer->file_path) }}" target="_blank">
                                                                            <img src="{{ asset($answer->file_path) }}" class="img-thumbnail" style="max-height: 100px;">
                                                                        </a>
                                                                    @elseif($question->type == 'checkbox')
                                                                        @php $vals = json_decode($answer->response, true); @endphp
                                                                        {{ is_array($vals) ? implode(', ', $vals) : $answer->response }}
                                                                    @else
                                                                        {{ $answer->response }}
                                                                    @endif
                                                                    <div class="mt-2">
                                                                        <form method="POST" class="update-status-form d-inline-block me-1">
                                                                            @csrf
                                                                            <input type="hidden" name="answer_id" value="{{ $answer->id }}">
                                                                            <input type="hidden" name="status" value="1">
                                                                            <button class="btn btn-sm btn-success">Accept</button>
                                                                        </form>
                                                                        <form method="POST" class="update-status-form d-inline-block me-1">
                                                                            @csrf
                                                                            <input type="hidden" name="answer_id" value="{{ $answer->id }}">
                                                                            <input type="hidden" name="status" value="0">
                                                                            <button class="btn btn-sm btn-danger">Reject</button>
                                                                        </form>
                                                                        <form method="POST" class="update-status-form d-inline-block">
                                                                            @csrf
                                                                            <input type="hidden" name="answer_id" value="{{ $answer->id }}">
                                                                            <input type="hidden" name="status" value="">
                                                                            <button class="btn btn-sm btn-primary">Pending</button>
                                                                        </form>
                                                                        <div class="text-muted small mt-1">
                                                                            Status:
                                                                            @if($answer->status === 1)
                                                                                <span class="text-success">Accepted</span>
                                                                            @elseif($answer->status === 0)
                                                                                <span class="text-danger">Rejected</span>
                                                                            @else
                                                                                <span class="text-muted">Pending</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">—</span>
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                    </tr>
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

            fetch("{{ route('employer.answer.update-status') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const statusWrapper = form.closest('td')?.querySelector('.text-muted') ?? form.closest('div').querySelector('.text-muted');
                    const selectedStatus = form.querySelector('input[name="status"]').value;
                    if (statusWrapper) {
                        if (selectedStatus === "1") {
                            statusWrapper.innerHTML = 'Status: <span class="text-success">Accepted</span>';
                        } else if (selectedStatus === "0") {
                            statusWrapper.innerHTML = 'Status: <span class="text-danger">Rejected</span>';
                        } else {
                            statusWrapper.innerHTML = 'Status: <span class="text-muted">Pending</span>';
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
