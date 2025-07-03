<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <style>
        .container { max-width: 600px; margin: 50px auto; }
        .form-group { margin-bottom: 15px; }
        .success { color: green; }
        .error { color: red; }
        .uploaded-icon { margin-top: 20px; width: 50px; height: 50px; object-fit: cover; }
        .view-button { margin-left: 10px; padding: 5px 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload an Image</h2>

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
                @if (session('filename'))
                    <a href="{{ route('images.show', session('filename')) }}" target="_blank" class="view-button">View Full Image</a>
                @endif
            </div>
        @endif
        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="image">Select Image:</label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>
            <button type="submit">Upload</button>
        </form>

        <!-- Display the uploaded image as a small icon -->
        @if (session('filename'))
            <div class="uploaded-icon">
                <h3>Uploaded Image:</h3>
                <img src="{{ route('images.show', session('filename')) }}" alt="Uploaded Image" class="uploaded-icon">
            </div>
        @endif
    </div>
</body>
</html>