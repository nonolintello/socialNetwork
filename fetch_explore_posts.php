<?php
// Assuming database connection is established

// Fetch explore posts from the database

$sql = "SELECT * FROM explore_posts";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $explorePosts = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $explorePosts[] = array(
            'id' => $row['id'],
            'text' => $row['text'],
            'image' => $row['image'],
            'likes' => $row['likes'],
            'dislikes' => $row['dislikes']
        );
    }
    echo json_encode($explorePosts);
} else {
    echo "No explore posts found";
}

mysqli_close($conn);
?>
