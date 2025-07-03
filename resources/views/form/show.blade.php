<!DOCTYPE html>
<html>
<head>
    <title>Company Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#1e40af',
                            hover: '#1e3a8a'
                        },
                        secondary: '#f8fafc',
                        textColor: '#1e293b',
                        textMuted: '#64748b',
                        borderColor: '#e2e8f0',
                        errorColor: '#ef4444',
                        successColor: '#10b981'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
@if(session('success'))
    <div id="success-alert" class="p-6 mb-6 rounded-lg bg-green-50 text-green-800 border border-green-200 font-medium">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="font-bold text-lg mb-2">Form submitted successfully!</h3>
                <p class="mb-3">Thank you for your submission. We've received your information.</p>
            </div>
        </div>
    </div>
@else
    <div id="success-alert" class="hidden p-6 mb-6 rounded-lg bg-green-50 text-green-800 border border-green-200 font-medium">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="font-bold text-lg mb-2">Form submitted successfully!</h3>
                <p class="mb-3">Thank you for your submission. We've received your information.</p>
            </div>
        </div>
    </div>
@endif
<body class="font-sans bg-gradient-to-br from-gray-50 to-gray-200 text-textColor">
    <div class="max-w-3xl mx-auto my-8 px-4 sm:px-6 relative z-10">
        <div class="flex items-center mb-8 ml-0">
            <div class="w-48 h-16 mr-4 flex items-center justify-start text-white font-bold text-lg rounded-md">
                <img src="assets/digital/assets/img/logo.png" alt="Company Name" class="max-w-full max-h-full">
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 mb-6 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-primary"></div>
            <h1 class="text-xl font-semibold text-textColor m-0">Information Request Form</h1>
            <p class="mt-3 text-sm text-textMuted">Please complete the form below. Fields marked with an asterisk (*) are required.</p>
        </div>
        
        <div class="flex items-center gap-4 mb-4">
            <div class="w-full bg-gray-200 rounded-xl h-1 overflow-hidden">
                <div class="h-full bg-primary rounded-xl w-0 transition-all duration-300" id="formProgress"></div>
            </div>
            <span id="progress-text" class="text-xs text-textMuted">0% complete</span>
        </div>
        
        <div id="success-alert" class="hidden p-6 mb-6 rounded-lg bg-green-50 text-green-800 border border-green-200 font-medium">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="font-bold text-lg mb-2">Form submitted successfully!</h3>
                    <p class="mb-3">Thank you for your submission. We've received your information.</p>
                   
                </div>
            </div>
        </div>
        
        <div id="error-alert" class="hidden p-4 mb-6 rounded-lg bg-red-50 text-errorColor border border-red-200 font-medium">
            <ul id="error-list">
            </ul>
        </div>
        
        <form action="{{ route('form.submit') }}" method="POST" enctype="multipart/form-data" id="companyForm">
            @csrf
            
            @if(isset($referral_code))
                <input type="hidden" name="referral_code" value="{{ $referral_code }}">
            @endif
            {{ csrf_field() }}
            
            <div class="bg-white rounded-xl p-8 shadow-sm mb-8">
                @foreach ($questions as $index => $question)
                    <div class="py-6 data-question-index-{{ $index }} {{ $index > 0 ? 'border-t border-borderColor' : '' }}">
                        @switch($question->type)
                            @case('text')
                                <div class="mb-4">
                                    <label for="q_{{ $question->id }}" class="block text-base font-semibold text-textColor mb-2">
                                        {{ $question->text }} @if ($question->required)<span class="text-errorColor ml-1">*</span>@endif
                                    </label>
                                    <input type="text" id="q_{{ $question->id }}" name="q_{{ $question->id }}" 
                                        class="w-full py-3 px-4 border border-borderColor rounded-lg mt-2 transition-all focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 text-sm form-input" 
                                        placeholder="Enter your answer" {{ $question->required ? 'required' : '' }}>
                                </div>
                                @break
                            
                            @case('paragraph')
                                <div class="mb-4">
                                    <label for="q_{{ $question->id }}" class="block text-base font-semibold text-textColor mb-2">
                                        {{ $question->text }} @if ($question->required)<span class="text-errorColor ml-1">*</span>@endif
                                    </label>
                                    <textarea id="q_{{ $question->id }}" name="q_{{ $question->id }}" rows="4"
                                        class="w-full py-3 px-4 border border-borderColor rounded-lg mt-2 min-h-[100px] resize-y transition-all focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 text-sm form-input"
                                        placeholder="Enter your answer" {{ $question->required ? 'required' : '' }}></textarea>
                                </div>
                                @break
                            
                            @case('choice')
                                <div class="mb-4">
                                    <fieldset>
                                        <legend class="block text-base font-semibold text-textColor mb-2">
                                            {{ $question->text }} @if ($question->required)<span class="text-errorColor ml-1">*</span>@endif
                                        </legend>
                                        <div class="space-y-2 mt-3">
                                            @foreach ($question->choices as $choice)
                                                <label class="flex items-center">
                                                    <input type="radio" name="q_{{ $question->id }}" class="form-input"
                                                        value="{{ $choice->text }}" {{ $question->required ? 'required' : '' }}
                                                        class="h-4 w-4 text-primary focus:ring-primary border-borderColor">
                                                    <span class="ml-2 text-sm text-textColor">{{ $choice->text }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </fieldset>
                                </div>
                                @break
                            
                            @case('checkbox')
                                <div class="mb-4">
                                    <fieldset>
                                        <legend class="block text-base font-semibold text-textColor mb-2">
                                            {{ $question->text }} @if ($question->required)<span class="text-errorColor ml-1">*</span>@endif
                                        </legend>
                                        <div class="space-y-2 mt-3">
                                            @foreach ($question->choices as $choice)
                                                <label class="flex items-center">
                                                    <input type="checkbox" name="q_{{ $question->id }}[]" class="form-input"
                                                        value="{{ $choice->text }}"
                                                        class="h-4 w-4 text-primary focus:ring-primary rounded border-borderColor">
                                                    <span class="ml-2 text-sm text-textColor">{{ $choice->text }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </fieldset>
                                </div>
                                @break
                            
                            @case('dropdown')
                                <div class="mb-4">
                                    <label for="q_{{ $question->id }}" class="block text-base font-semibold text-textColor mb-2">
                                        {{ $question->text }} @if ($question->required)<span class="text-errorColor ml-1">*</span>@endif
                                    </label>
                                    <select id="q_{{ $question->id }}" name="q_{{ $question->id }}" class="form-input w-full h-10 py-2 px-4 border border-borderColor rounded-lg mt-2 bg-white appearance-none transition-all focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 text-sm" 
                                        {{ $question->required ? 'required' : '' }}>
                                        <option value="">-- Select an option --</option>
                                        @foreach ($question->choices as $choice)
                                            <option value="{{ $choice->text }}">{{ $choice->text }}</option>
                                        @endforeach
                                    </select>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <svg class="w-4 h-4 text-textMuted" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                @break
                            
                            @case('file')
                                <div class="mb-4">
                                    <label for="q_{{ $question->id }}" class="block text-base font-semibold text-textColor mb-2">
                                        {{ $question->text }} @if ($question->required)<span class="text-errorColor ml-1">*</span>@endif
                                    </label>
                                    <div class="mt-3 relative">
                                        <label class="inline-block px-5 py-3 bg-primary text-white rounded-lg cursor-pointer hover:bg-primary-hover transition-colors duration-200 text-sm font-medium">
                                            Choose file
                                            <input type="file" id="q_{{ $question->id }}" name="q_{{ $question->id }}" class="sr-only form-input"
                                                {{ $question->required ? 'required' : '' }}>
                                        </label>
                                        <span class="ml-3 text-sm text-textMuted file-name">No file chosen</span>
                                    </div>
                                    <p class="text-xs text-textMuted mt-2">Max file size: 10MB</p>
                                </div>
                                @break
                            
                            @case('date')
                                <div class="mb-4">
                                    <label for="q_{{ $question->id }}" class="block text-base font-semibold text-textColor mb-2">
                                        {{ $question->text }} @if ($question->required)<span class="text-errorColor ml-1">*</span>@endif
                                    </label>
                                    <input type="date" id="q_{{ $question->id }}" name="q_{{ $question->id }}" 
                                        class="w-full py-3 px-4 border border-borderColor rounded-lg mt-2 transition-all focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 text-sm form-input" 
                                        {{ $question->required ? 'required' : '' }}>
                                </div>
                                @break
                            
                            @case('time')
                                <div class="mb-4">
                                    <label for="q_{{ $question->id }}" class="block text-base font-semibold text-textColor mb-2">
                                        {{ $question->text }} @if ($question->required)<span class="text-errorColor ml-1">*</span>@endif
                                    </label>
                                    <input type="time" id="q_{{ $question->id }}" name="q_{{ $question->id }}" 
                                        class="w-full py-3 px-4 border border-borderColor rounded-lg mt-2 transition-all focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 text-sm form-input" 
                                        {{ $question->required ? 'required' : '' }}>
                                </div>
                                @break
                            
                            @default
                                <div class="mb-4">
                                    <label for="q_{{ $question->id }}" class="block text-base font-semibold text-textColor mb-2">
                                        {{ $question->text }} @if ($question->required)<span class="text-errorColor ml-1">*</span>@endif
                                    </label>
                                    <input type="text" id="q_{{ $question->id }}" name="q_{{ $question->id }}" 
                                        class="w-full py-3 px-4 border border-borderColor rounded-lg mt-2 transition-all focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 text-sm form-input" 
                                        placeholder="Enter your answer" {{ $question->required ? 'required' : '' }}>
                                </div>
                        @endswitch
                    </div>
                @endforeach
            </div>
            
            <div class="flex justify-between mt-8 mb-12 flex-wrap gap-4">
                <div>
                    <!-- <a href="{{ route('employer.questions.index') }}" class="text-textMuted hover:text-textColor">Back</a> -->
                </div>
                <div>
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-primary to-primary-hover text-white rounded-lg font-medium shadow-sm hover:shadow-md transition-all duration-200 text-base">Submit Form</button>
                </div>
            </div>
            
            <div class="text-center mt-8 pt-4 border-t border-borderColor text-sm text-textMuted">
                <div class="flex flex-col items-center justify-center mb-6">
                    <p class="mb-3 text-base font-medium text-gray-700">
                        Download Herody from the Play Store and start earning money!
                    </p>
                    <a href="https://play.google.com/store/apps/details?id=com.jaketa.herody" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <img src="assets/digital/assets/img/logo.png" alt="Herody Logo" class="w-8 h-8 mr-3">
                        <span class="font-medium">Get it on Play Store</span>
                    </a>
                </div>

                <p><a href="https://herody.in">© 2025 Jaketa Media & Entertainment. All rights reserved.</a> | <a href="https://herody.in" class="text-textMuted hover:text-primary">Privacy Policy</a> | <a href="https://herody.in" class="text-textMuted hover:text-primary">Terms of Service</a></p>
            </div>
        </form>
    </div>

    <script>
      // Modified form submission handling
document.addEventListener('DOMContentLoaded', function() {
    // File input handler to show selected filename
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
            const fileNameElement = this.closest('div').querySelector('.file-name');
            if (fileNameElement) {
                fileNameElement.textContent = fileName;
            }
        });

    });
    
    // Form progress tracking
    const formInputs = document.querySelectorAll('.form-input');
    const totalQuestions = document.querySelectorAll('[class*="data-question-index"]').length;
    const progressBar = document.getElementById('formProgress');
    const progressText = document.getElementById('progress-text');
    
    function updateProgress() {
        let filledInputs = 0;
        const questionAnswered = {};
        
        formInputs.forEach(input => {
            const questionCard = input.closest('[class*="data-question-index"]');
            if (!questionCard) return;
            
            const classes = questionCard.className.split(' ');
            const indexClass = classes.find(cls => cls.startsWith('data-question-index-'));
            if (!indexClass) return;
            
            const questionIndex = indexClass.replace('data-question-index-', '');
            
            if (!questionAnswered[questionIndex]) {
                if ((input.type === 'text' || input.type === 'textarea' || input.type === 'date' || input.type === 'time') && input.value !== '') {
                    questionAnswered[questionIndex] = true;
                    filledInputs++;
                } else if (input.type === 'radio' && input.checked) {
                    questionAnswered[questionIndex] = true;
                    filledInputs++;
                } else if (input.type === 'checkbox' && input.checked) {
                    questionAnswered[questionIndex] = true;
                    filledInputs++;
                } else if (input.type === 'select-one' && input.value !== '') {
                    questionAnswered[questionIndex] = true;
                    filledInputs++;
                } else if (input.type === 'file' && input.files.length > 0) {
                    questionAnswered[questionIndex] = true;
                    filledInputs++;
                }
            }
        });
        
        const progress = (Object.keys(questionAnswered).length / totalQuestions) * 100;
        progressBar.style.width = progress + '%';
        progressText.textContent = Math.round(progress) + '% complete';
    }
    
    // Add event listeners to all form inputs
    formInputs.forEach(input => {
        input.addEventListener('change', updateProgress);
        input.addEventListener('input', updateProgress);
    });
    
    // Initialize progress bar
    updateProgress();

    // Form submission handling
    const form = document.getElementById('companyForm');
    const successAlert = document.getElementById('success-alert');
    const errorAlert = document.getElementById('error-alert');
    const errorList = document.getElementById('error-list');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Display diagnostic info
        console.log('Form submission triggered');
        console.log('Form action URL:', form.action);
        
        // Create FormData object and log its content
        const formData = new FormData(form);
        console.log('Form data entries:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + (pair[1] instanceof File ? pair[1].name : pair[1]));
        }
        
        // Check if we need to use traditional form submission
        // This is a fallback approach if AJAX is causing issues
        const useTraditionalSubmission = true;
        
        if (useTraditionalSubmission) {
            console.log('Using traditional form submission');
            // Remove the event listener to allow the form to submit normally
            form.removeEventListener('submit', arguments.callee);
            // Submit the form
            form.submit();
            return;
        }
        
        // Show loading message
        const loadingMessage = document.createElement('div');
        loadingMessage.innerHTML = '<p class="text-blue-700 font-medium">Submitting form data, please wait...</p>';
        loadingMessage.className = 'p-4 mb-6 rounded-lg bg-blue-50 border border-blue-200';
        form.parentNode.insertBefore(loadingMessage, form);
        
        // AJAX submission approach
        try {
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', [...response.headers].join(', '));
                
                // Try to get the response text regardless of content type
                return response.text().then(text => {
                    console.log('Raw response:', text);
                    
                    // If not OK status, throw the text as an error
                    if (!response.ok) {
                        throw new Error('Server returned error: ' + response.status + ' ' + text);
                    }
                    
                    // Try to parse as JSON if possible
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.log('Response is not JSON, using as text');
                        return { success: true, message: text };
                    }
                });
            })
            .then(data => {
                console.log('Parsed response data:', data);
                // Handle successful response
                successAlert.classList.remove('hidden');
                loadingMessage.remove();
                
                // Scroll to success message
                successAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
            })
            .catch(error => {
                console.error('Fetch error:', error);
                
                // Handle and display errors
                errorAlert.classList.remove('hidden');
                errorList.innerHTML = '';
                
                const li = document.createElement('li');
                li.textContent = 'Error: ' + error.message;
                li.className = 'mb-1';
                errorList.appendChild(li);
                
                // Scroll to error message
                errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                loadingMessage.remove();
            });
        } catch (error) {
            console.error('Error setting up fetch:', error);
            
            // Display critical error
            errorAlert.classList.remove('hidden');
            errorList.innerHTML = '';
            
            const li = document.createElement('li');
            li.textContent = 'Critical error: ' + error.message;
            li.className = 'mb-1';
            errorList.appendChild(li);
            
            errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
            loadingMessage.remove();
        }
    });
});
    </script>
</body>
</html>