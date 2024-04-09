<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get post id
    $postId = $_POST['postId'];
    $comment = $_POST['comment'];
    // write db
    $sql = "INSERT INTO comments (post_id, comment) VALUES ('$postId', '$comment')";
    echo "Comment submitted successfully.";
} else {
    echo "Method not allowed";
}
?>
