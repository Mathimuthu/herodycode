<!DOCTYPE html>
<html>
<head>
    <title>Upload Image and Link</title>
</head>
<body>
    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <h1>Upload Image and Link</h1>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="website_link">Website Link:</label>
            <input type="text" id="website_link" name="website_link" required>
        </div>
        <div>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" required>
        </div>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
