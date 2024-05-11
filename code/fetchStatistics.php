<?php
include("./ini.php");

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $stmt = $dbConn->db->prepare("SELECT COUNT(*) AS followers FROM follow WHERE id_isfollow = ?");
    $stmt->execute([$userId]);
    $followers = $stmt->fetch(PDO::FETCH_ASSOC)['followers'];

    $stmt = $dbConn->db->prepare("SELECT COUNT(*) AS following FROM follow WHERE id_follower = ?");
    $stmt->execute([$userId]);
    $following = $stmt->fetch(PDO::FETCH_ASSOC)['following'];

    $stmt = $dbConn->db->prepare("SELECT COUNT(*) AS total_posts FROM post WHERE id_owner = ?");
    $stmt->execute([$userId]);
    $total_posts = $stmt->fetch(PDO::FETCH_ASSOC)['total_posts'];

    $stmt = $dbConn->db->prepare("SELECT COUNT(*) AS likes_given FROM jaime WHERE id_user = ?");
    $stmt->execute([$userId]);
    $likes_given = $stmt->fetch(PDO::FETCH_ASSOC)['likes_given'];

    $stmt = $dbConn->db->prepare("SELECT COUNT(*) AS likes_received FROM jaime JOIN post ON jaime.id_post = post.id WHERE post.id_owner = ?");
    $stmt->execute([$userId]);
    $likes_received = $stmt->fetch(PDO::FETCH_ASSOC)['likes_received'];
    $response = [
        'followers' => $followers,
        'following' => $following,
        'total_posts' => $total_posts,
        'likes_given' => $likes_given,
        'likes_received' => $likes_received
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo json_encode(['error' => 'User not logged in']);
}
