<?php
include("./ini.php");

if (isset($_SESSION['id']) && isset($_GET['follow_id'])) {
    $userId = $_SESSION['id'];
    $followId = $_GET['follow_id'];

    // 检查是否已经关注
    $stmt = $dbConn->db->prepare("SELECT * FROM follow WHERE id_follower = ? AND id_isfollow = ?");
    $stmt->execute([$userId, $followId]);
    if ($stmt->fetch()) {
        // 取消关注
        $stmt = $dbConn->db->prepare("DELETE FROM follow WHERE id_follower = ? AND id_isfollow = ?");
        $stmt->execute([$userId, $followId]);
        echo "Follow";
    } else {
        // 添加关注
        $stmt = $dbConn->db->prepare("INSERT INTO follow (id_follower, id_isfollow) VALUES (?, ?)");
        $stmt->execute([$userId, $followId]);
        echo "Unfollow";
    }
} else {
    echo "Error: User not logged in or invalid ID";
}
?>
