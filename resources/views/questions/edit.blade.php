<!DOCTYPE html>
<html>
<head>
    <title>Edit Question</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Edit Question</h1>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('employer.questions.update', $question->id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            
            <div class="form-group">
                <label>Question Text:</label>
                <input type="text" name="text" class="form-control" value="{{ old('text', $question->text) }}" required>
            </div>
            
            <div class="form-group">
                <label>Question Type:</label>
                <select name="type" class="form-control" id="questionType" required>
                    @foreach($questionTypes as $value => $label)
                        <option value="{{ $value }}" {{ old('type', $question->type) == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="required" value="1" {{ old('required', $question->required) ? 'checked' : '' }}>
                    Required
                </label>
            </div>
            
            <div id="choicesDiv" style="display: {{ in_array($question->type, ['choice', 'checkbox', 'dropdown']) ? 'block' : 'none' }};">
                <h3>Choices</h3>
                <div id="choiceFields">
                    @if ($question->choices->count() > 0)
                        @foreach ($question->choices as $index => $choice)
                            <div class="form-group">
                                <input type="text" name="choices[]" class="form-control" 
                                    value="{{ $choice->text }}" placeholder="Choice {{ $index + 1 }}">
                            </div>
                        @endforeach
                    @else
                        <div class="form-group">
                            <input type="text" name="choices[]" class="form-control" placeholder="Choice 1">
                        </div>
                        <div class="form-group">
                            <input type="text" name="choices[]" class="form-control" placeholder="Choice 2">
                        </div>
                    @endif
                </div>
                <button type="button" class="btn btn-default" id="addChoice">Add Another Choice</button>
            </div>
            
            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Update Question</button>
                <a href="{{ route('employer.questions.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
    
    <script>
        $(document).ready(function() {
            // Show/hide choices div based on question type
            function toggleChoicesDiv() {
                var questionType = $('#questionType').val();
                if (['choice', 'checkbox', 'dropdown'].includes(questionType)) {
                    $('#choicesDiv').show();
                } else {
                    $('#choicesDiv').hide();
                }
            }
            
            // On change
            $('#questionType').change(function() {
                toggleChoicesDiv();
            });
            
            // Add more choice fields
            $('#addChoice').click(function() {
                var index = $('#choiceFields').children().length + 1;
                $('#choiceFields').append('<div class="form-group"><input type="text" name="choices[]" class="form-control" placeholder="Choice ' + index + '"></div>');
            });
        });
    </script>
</body>
</html>
