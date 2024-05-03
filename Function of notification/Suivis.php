<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    // 查询当前用户关注的人
    $stmt = $dbConn->db->prepare("SELECT u.id, u.prenom, u.nom FROM user u JOIN follow f ON u.id = f.id_isfollow WHERE f.id_follower = ?");
    $stmt->execute([$userId]);
    $followings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<h1>Les gens que vous suivez</h1>';
    echo '<div class="follow-list">';

    foreach ($followings as $following) {
        echo '<div class="follow-item">';
        echo '<p>' . htmlspecialchars($following['prenom']) . ' ' . htmlspecialchars($following['nom']) . '</p>';
        echo "<button onclick='unfollow(" . $following['id'] . ")'>Unfollow</button>";
        echo '</div>';
    }

    echo '</div>';
} else {
    echo '<p>Veuillez vous connecter pour voir cette page.</p>';
}

include(__ROOT__ . "/codePart/footer.php");
?>

<script>
function unfollow(followId) {
    fetch(`unfollow.php?follow_id=${followId}`)
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload(); // 刷新页面以更新列表
    })
    .catch(error => console.error('Error:', error));
}
</script>