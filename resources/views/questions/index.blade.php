<!DOCTYPE html>
<html>
<head>
    <title>Questions</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Form Builder</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="btn-group" role="group" style="margin-bottom: 20px;">
            <a href="{{ route('employer.questions.create') }}" class="btn btn-primary">Create New Question</a>
        </div>
        @foreach($groupedQuestions as $referral_code => $questions)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Referral Code: {{ $referral_code }}
                    <div class="pull-right">
                        <a href="{{ route('employer.questions.answers', $referral_code) }}" class="btn btn-sm btn-info">
                            <i class="fa fa-eye"></i> View Answers
                        </a>
                        <a href="{{ url('/form?ref=' . $referral_code) }}" target="_blank" class="btn btn-sm btn-success">
                            <i class="fa fa-link"></i> Form Link
                        </a>
                    </div>
                </h3>
            </div>
            <div class="panel-body">
                <!-- Your existing code for displaying questions -->
            </div>
        </div>
    @endforeach
        @forelse ($groupedQuestions as $referral_code => $questions)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Referral Code:</strong> {{ $referral_code }}
                    <span class="pull-right">
                        <a href="{{ url('/form?ref=' . $referral_code) }}" target="_blank" class="btn btn-xs btn-success">Share Form Link</a>
                    </span>
                </div>

                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Type</th>
                                <th>Required</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $question)
                                <tr>
                                    <td>{{ $question->id }}</td>
                                    <td>{{ $question->text }}</td>
                                    <td>{{ ucfirst($question->type) }}</td>
                                    <td>{{ $question->required ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <a href="{{ route('employer.questions.edit', $question->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('employer.questions.destroy', $question->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                No questions created yet. <a href="{{ route('employer.questions.create') }}">Create your first question</a>.
            </div>
        @endforelse
    </div>
</body>
</html>
