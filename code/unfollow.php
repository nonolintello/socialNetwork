<?php

include("./ini.php");

if (isset($_SESSION['id']) && isset($_GET['follow_id'])) {
    $userId = $_SESSION['id'];
    $followId = $_GET['follow_id'];

    $stmt = $dbConn->db->prepare("DELETE FROM follow WHERE id_follower = ? AND id_isfollow = ?");
    $stmt->execute([$userId, $followId]);

    if ($stmt->rowCount() > 0) {
        echo "Follow";  
    } else {
        echo "Unfollow"; 
    }
} else {
    echo "Error: User not logged in or invalid ID"; 
}
