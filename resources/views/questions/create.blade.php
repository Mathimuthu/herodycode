<!DOCTYPE html>
<html>
<head>
    <title>Create Questions</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            color: #202124;
        }
        .container {
            max-width: 768px;
            margin: 0 auto;
        }
        .form-header {
            background-color: #fff;
            border-top: 8px solid #673AB7;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 16px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        .form-header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 400;
        }
        .panel {
            background-color: #fff;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 16px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        .panel-title {
            margin-top: 0;
            margin-bottom: 16px;
            font-size: 16px;
            font-weight: 500;
        }
        .question-block {
            background-color: #fff;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 16px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            position: relative;
        }
        .question-title {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }
        .question-number {
            color: #5f6368;
            margin-right: 8px;
            font-size: 16px;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #dadce0;
            border-radius: 4px;
            margin-bottom: 16px;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
        }
        .form-control:focus {
            outline: none;
            border-color: #673AB7;
        }
        select.form-control {
            height: 38px;
        }
        .btn {
            display: inline-block;
            font-weight: 500;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: none;
            padding: 10px 24px;
            font-size: 14px;
            line-height: 1.5;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 8px;
            transition: all 0.2s ease-in-out;
        }
        .btn-primary {
            color: white;
            background-color: #673AB7;
        }
        .btn-primary:hover {
            background-color: #5e35b1;
        }
        .btn-success {
            color: white;
            background-color: #4CAF50;
        }
        .btn-success:hover {
            background-color: #43A047;
        }
        .alert {
            padding: 16px;
            margin-bottom: 16px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .choiceFields input {
            margin-bottom: 8px;
        }
        .required-asterisk {
            color: #d93025;
            margin-left: 4px;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .radio-option {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }
        .radio-option input[type="radio"] {
            margin-right: 8px;
        }
        .footer-buttons {
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
        }
        .btn-outline {
            background-color: transparent;
            color: #673AB7;
            border: 1px solid #673AB7;
        }
        .btn-outline:hover {
            background-color: rgba(103, 58, 183, 0.04);
        }
        .choices-container {
            margin-top: 16px;
        }
        .choices-header {
            font-size: 14px;
            color: #5f6368;
            margin-bottom: 8px;
        }
        .required-toggle {
            display: flex;
            align-items: center;
            color: #5f6368;
        }
        .required-toggle input {
            margin-right: 8px;
        }
        .divider {
            height: 1px;
            background-color: #dadce0;
            margin: 24px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-header">
        <h1>Create Questions</h1>
    </div>

    <!--<div class="panel">-->
    <!--    <div class="form-group">-->
    <!--        <select name="campaign_id" class="form-control">-->
    <!--            <option value="">Select a Campaign (Optional)</option>-->
    <!--            @foreach($campaigns as $campaign)-->
    <!--                <option value="{{ $campaign->id }}" {{ $campaign_id == $campaign->id ? 'selected' : '' }}>-->
    <!--                    {{ $campaign->task_name }} (Referral: {{ $campaign->referral_code }})-->
    <!--                </option>-->
    <!--            @endforeach-->
    <!--        </select>-->
    <!--    </div>-->
    <!--</div>-->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        Questions created successfully! Your referral link: 
        <a href="{{ session('success') }}" target="_blank">{{ session('success') }}</a>
    </div>
    @endif

    <form action="{{ route('employer.questions.store') }}" method="POST">
        {{ csrf_field() }}
        @if(isset($campaign_id))
            <input type="hidden" name="campaign_id" value="{{ $campaign_id }}">
        @endif
        
        <!-- Referral Code Panel -->
        <div class="panel">
            
            <h3 class="panel-title">Referral Code Options</h3>
            
            <div class="radio-option">
                <input type="radio" name="referral_option" id="new_referral" value="new" {{ old('referral_option', 'new') == 'new' ? 'checked' : '' }}>
                <label for="new_referral">Create new referral code</label>
            </div>
            
            <!--<div class="radio-option">-->
            <!--    <input type="radio" name="referral_option" id="existing_referral" value="existing" {{ old('referral_option') == 'existing' ? 'checked' : '' }}>-->
            <!--    <label for="existing_referral">Use existing referral code</label>-->
            <!--</div>-->

            <div class="form-group" id="existing_referral_group" style="display: {{ old('referral_option') == 'existing' ? 'block' : 'none' }}; margin-top: 16px;">
                <select class="form-control" name="existing_referral" id="existing_referral">
                    <option value="">Select a referral code</option>
                    @foreach($existingReferrals as $referral)
                        <option value="{{ $referral }}" {{ old('existing_referral') == $referral ? 'selected' : '' }}>
                            {{ $referral }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="questionsWrapper">
            <div class="question-block">
                <div class="question-title">
                    <span class="question-number">Question 1</span>
                </div>
                
                <div class="form-group">
                    <input type="text" name="text[]" class="form-control" placeholder="Question text" required>
                </div>

                <div class="form-group">
                    <select name="type[]" class="form-control questionType" required>
                        @foreach($questionTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="required-toggle">
                    <input type="checkbox" name="required[0]" id="required-0" value="1" checked>
                    <label for="required-0">Required question</label>
                </div>

                <div class="choicesDiv choices-container" style="display: none;">
                    <div class="choices-header">Options</div>
                    <div class="choiceFields">
                        <input type="text" name="choices[0][]" class="form-control" placeholder="Option 1">
                        <input type="text" name="choices[0][]" class="form-control" placeholder="Option 2">
                    </div>
                    <button type="button" class="btn btn-outline addChoice">Add option</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-outline" id="addQuestion">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add question
        </button>

        <div class="footer-buttons">
            <div></div> <!-- Empty div for flex spacing -->
            <button type="submit" class="btn btn-primary">Create Form</button>
        </div>
    </form>
     <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('employer.campaign-descriptions.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to Campaign Descriptions
                        </a>
                    </div>
                </div>
</div>

<script>
    let questionIndex = 1;

    function toggleChoices(section) {
        let type = section.find('.questionType').val();
        section.find('.choicesDiv').toggle(['choice', 'checkbox', 'dropdown'].includes(type));
    }

    $(document).on('change', '.questionType', function () {
        toggleChoices($(this).closest('.question-block'));
    });

    // Toggle existing referral dropdown based on radio selection
    $(document).ready(function() {
        $('input[name="referral_option"]').change(function() {
            if ($(this).val() === 'existing') {
                $('#existing_referral_group').show();
            } else {
                $('#existing_referral_group').hide();
            }
        });
    });

    $('#addQuestion').click(function () {
        const block = $('.question-block').first().clone();
        block.find('input, select').each(function () {
            if ($(this).attr('type') === 'checkbox') {
                $(this).attr('name', `required[${questionIndex}]`);
                $(this).attr('id', `required-${questionIndex}`);
                $(this).next('label').attr('for', `required-${questionIndex}`);
                $(this).prop('checked', true);
            } else {
                $(this).val('');
            }
        });
        
        block.find('.choicesDiv').hide();
        block.find('.choiceFields').html(`
            <input type="text" name="choices[${questionIndex}][]" class="form-control" placeholder="Option 1">
            <input type="text" name="choices[${questionIndex}][]" class="form-control" placeholder="Option 2">
        `);
        block.find('.addChoice').data('index', questionIndex);
        block.find('.question-number').text('Question ' + (questionIndex + 1));
        $('#questionsWrapper').append(block);
        questionIndex++;
    });

    $(document).on('click', '.addChoice', function () {
        const container = $(this).siblings('.choiceFields');
        const idx = $(this).closest('.question-block').index();
        const count = container.children('input').length + 1;
        container.append(`<input type="text" name="choices[${idx}][]" class="form-control" placeholder="Option ${count}">`);
    });

    $('.questionType').each(function () {
        toggleChoices($(this).closest('.question-block'));
    });
</script>
</body>
</html>