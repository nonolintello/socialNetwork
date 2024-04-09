<!-- explore.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
        }
        .post {
            background-color: #fff; /* White background for posts */
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Navigation items -->
        <div class="row">
            <div class="col-3">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">Home</a>
                    <a href="#" class="list-group-item list-group-item-action active">Explore</a>
                    <!-- Add more navigation items here -->
                </div>
            </div>
            <div class="col-9">
                <!-- Posts display area -->
                <div id="posts-container">
                    <!-- Posts from other users will be dynamically added here -->
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        // load and display explore posts when the page is loaded
        document.addEventListener('DOMContentLoaded', function() {
            loadExplorePosts();
        });
        // like function
        function likePost(button) {
            var likeCount = button.nextElementSibling;
            likeCount.textContent = parseInt(likeCount.textContent) + 1;
        }

        // dislike function
        function dislikePost(button) {
            var dislikeCount = button.previousElementSibling;
            dislikeCount.textContent = parseInt(dislikeCount.textContent) + 1;
        }

        // show comment box function
        function showCommentBox(button) {
            var commentBox = button.nextElementSibling;
            commentBox.style.display = 'block';
        }

        // send comment function
        function sendComment(button) {
            var commentTextarea = button.previousElementSibling;
            var commentText = commentTextarea.value;
            var commentsContainer = button.parentElement.nextElementSibling;
            commentsContainer.innerHTML += '<p>' + commentText + '</p>';
            commentTextarea.value = '';
        }
    </script>
</body>
</html>
