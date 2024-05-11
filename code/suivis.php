<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    echo '<div class="container user-profile">';
    echo '<h1 class="blog-owner-title">Les gens que vous suivez</h1>';
    echo '<div class="follow-list">';

    $stmt = $dbConn->db->prepare("SELECT u.id, u.prenom, u.nom, u.url_avatar FROM user u JOIN follow f ON u.id = f.id_isfollow WHERE f.id_follower = ?");
    $stmt->execute([$userId]);
    $followings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($followings as $following) {
        echo '<div class="follow-item user-details">';
        echo '<a href="blog.php?id=' . $following['id'] . '"><img src="'.htmlspecialchars($following['url_avatar']).'" class="avatar"></a>'; // 添加链接到用户的头像
        echo '<p><a href="blog.php?id=' . $following['id'] . '">' . htmlspecialchars($following['prenom']) . ' ' . htmlspecialchars($following['nom']) . '</a></p>'; // 添加链接到用户名
        echo "<button class='btn btn-info' onclick='unfollow(" . $following['id'] . ")'>Unfollow</button>";
        echo '</div>';
    }
    echo '<h1 class="blog-owner-title">Vous êtes suivi par</h1>';
    $stmt = $dbConn->db->prepare("SELECT u.id, u.prenom, u.nom, u.url_avatar FROM user u JOIN follow f ON u.id = f.id_follower WHERE f.id_isfollow = ?");
    $stmt->execute([$userId]);
    $followers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($followers as $follower) {
        echo '<div class="follow-item user-details">';
        echo '<a href="blog.php?id=' . $follower['id'] . '"><img src="'.htmlspecialchars($follower['url_avatar']).'" class="avatar"></a>'; // 添加链接到用户的头像
        echo '<p><a href="blog.php?id=' . $follower['id'] . '">' . htmlspecialchars($follower['prenom']) . ' ' . htmlspecialchars($follower['nom']) . '</a></p>'; // 添加链接到用户名
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
} else {
    echo '<p class="alert alert-warning">Veuillez vous connecter pour voir cette page.</p>';
}

include(__ROOT__ . "/codePart/footer.php");
?>

