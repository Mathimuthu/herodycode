<!DOCTYPE html>
<html>
<head>
    <title>Image Links</title>
</head>
<body>
    <h1>Images</h1>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <div>
        @foreach ($images as $image)
            <a href="{{ $image->website_link }}" target="_blank">
                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image" style="width: 200px; height: auto;">
            </a>
        @endforeach
    </div>
</body>
</html>
