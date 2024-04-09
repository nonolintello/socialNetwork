<!-- mainpage.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Dashboard - Main Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('background_image.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body>
    <div id="main-page" class="container-fluid">
        <!-- mainpage ui -->
        <div class="row">
            <!-- Sidebar -->
            <div class="col-3">
                <div class="list-group">
                    <!-- Navigation items -->
                    <a href="#" class="list-group-item list-group-item-action active">Home</a>
                    <a href="#" class="list-group-item list-group-item-action">Explore</a>
                    <a href="#" class="list-group-item list-group-item-action">Notifications</a>
                    <a href="#" class="list-group-item list-group-item-action">Messages</a>
                    <a href="#" class="list-group-item list-group-item-action">Bookmarks</a>
                    <a href="#" class="list-group-item list-group-item-action">Lists</a>
                    <a href="#" class="list-group-item list-group-item-action">Profile</a>
                    <a href="#" class="list-group-item list-group-item-action">More</a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-6">
                <!-- Search Bar -->
                <div class="search-bar-container">
                    <input type="text" class="form-control search-input" placeholder="Search" aria-label="Search">
                </div>

                <!-- Post creation area -->
                <div class="mb-3">
                    <textarea class="form-control mb-2" id="post-text" rows="3" placeholder="What's happening?"></textarea>
                    <input type="file" id="post-image" accept="image/*"> <!-- submit image -->
                    <button type="button" class="btn btn-primary" onclick="createPost()">Post</button>
                    <button type="button" class="btn btn-secondary" onclick="insertImage()">Insert Image</button> <!-- image submit button -->
                </div>

                <!-- Posts display area -->
                <div id="posts-container">
                    <!-- Posts are added here -->
                </div>
            </div>

            <!-- Right Sidebar for Trends/Who to follow -->
            <div class="col-3">
                <!-- Trends and suggestions area... -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
