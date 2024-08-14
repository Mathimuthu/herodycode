<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Locator</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function openLink() {
            // Get the value from the link text bar
            var link = document.getElementById("linkTextBar").value;
            
            // Check if the link starts with "http://" or "https://"
            if (link && !link.startsWith("http://") && !link.startsWith("https://")) {
                link = "http://" + link;
            }

            // Open the link in a new tab
            if (link) {
                window.location.replace(link, '_self');
            } else {
                alert("Please enter a link.");
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">You can review it from Chorme:</h2>
        <div class="form-group">
            <input type="text" class="form-control"  placeholder="Enter about the link">
        </div>
        <h2 class="mb-4">Link</h2>
        <div class="form-group">
            <input type="text" class="form-control" id="linkTextBar" name="linkTextBar" placeholder="Enter a link">
        </div>
        <button class="btn btn-primary" onclick="openLink()">Open Link</button>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
