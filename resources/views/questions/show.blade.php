<!DOCTYPE html>
<html>
<head>
    <title>Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Form</h1>
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            
            @if(isset($referral_code))
                <input type="hidden" name="referral_code" value="{{ $referral_code }}">
            @endif
                        {{ csrf_field() }}
            
            @foreach ($questions as $index => $question)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {{ $index + 1 }}. {{ $question->text }}
                            @if ($question->required)
                                <span class="text-danger">*</span>
                            @endif
                        </h3>
                    </div>
                    <div class="panel-body">
                        @switch($question->type)
                            @case('text')
                                <div class="form-group">
                                    <input type="text" name="q_{{ $question->id }}" class="form-control" 
                                        {{ $question->required ? 'required' : '' }}>
                                </div>
                                @break
                                
                            @case('paragraph')
                                <div class="form-group">
                                    <textarea name="q_{{ $question->id }}" class="form-control" rows="4"
                                        {{ $question->required ? 'required' : '' }}></textarea>
                                </div>
                                @break
                                
                            @case('choice')
                                <div class="form-group">
                                    @foreach ($question->choices as $choice)
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="q_{{ $question->id }}" 
                                                    value="{{ $choice->text }}" {{ $question->required ? 'required' : '' }}>
                                                {{ $choice->text }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @break
                                
                            @case('checkbox')
                                <div class="form-group">
                                    @foreach ($question->choices as $choice)
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="q_{{ $question->id }}[]" 
                                                    value="{{ $choice->text }}">
                                                {{ $choice->text }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @break
                                
                            @case('dropdown')
                                <div class="form-group">
                                    <select name="q_{{ $question->id }}" class="form-control" 
                                        {{ $question->required ? 'required' : '' }}>
                                        <option value="">-- Select an option --</option>
                                        @foreach ($question->choices as $choice)
                                            <option value="{{ $choice->text }}">{{ $choice->text }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @break
                                
                            @case('file')
                                <div class="form-group">
                                    <input type="file" name="q_{{ $question->id }}" class="form-control" 
                                        {{ $question->required ? 'required' : '' }}>
                                    <p class="help-block">Max file size: 10MB</p>
                                </div>
                                @break
                                
                            @case('date')
                                <div class="form-group">
                                    <input type="date" name="q_{{ $question->id }}" class="form-control" 
                                        {{ $question->required ? 'required' : '' }}>
                                </div>
                                @break
                                
                            @case('time')
                                <div class="form-group">
                                    <input type="time" name="q_{{ $question->id }}" class="form-control" 
                                        {{ $question->required ? 'required' : '' }}>
                                </div>
                                @break
                                
                            @default
                                <div class="form-group">
                                    <input type="text" name="q_{{ $question->id }}" class="form-control" 
                                        {{ $question->required ? 'required' : '' }}>
                                </div>
                        @endswitch
                    </div>
                </div>
            @endforeach
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('employer.questions.index') }}" class="btn btn-default">Back to Questions</a>
            </div>
        </form>
    </div>
</body>
</html>