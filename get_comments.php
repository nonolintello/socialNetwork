<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // get ID
    $postId = $_GET['postId'];

    // get commits from db
    $sql = "SELECT * FROM comments WHERE post_id = '$postId'";

    // return searched result to frontside
    while ($row = $result->fetch_assoc()) {
         echo '<div>' . $row['comment'] . '</div>';
     }
} else {
    echo "Method not allowed";
}
?>
