<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    echo '<div class="container mt-4">';
    echo '<h1 class="blog-owner-title">Trends to follow</h1>';
    echo '<div class="posts content">';
    // 一开始就加载10条帖子
    $stmt = $dbConn->db->prepare("
    SELECT p.id, p.texte, p.titre, p.url_image, p.date, u.prenom, u.nom, u.url_avatar, u.id AS author_id
        FROM post p
        JOIN follow f ON p.id_owner = f.id_isfollow
        JOIN user u ON u.id = p.id_owner
        WHERE f.id_follower = ?
        ORDER BY p.date DESC
        LIMIT 10");
    $stmt->execute([$userId]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<div class="posts">';
    foreach ($posts as $post) {
        echo '<div class="post user-profile">';
        echo '<div class="profile-header">';
        echo '<img src="' . htmlspecialchars($post['url_avatar']) . '" alt="User avatar" class="avatar rounded-circle">';
        echo '<h3>' . htmlspecialchars($post['prenom']) . ' ' . htmlspecialchars($post['nom']) . '</h3>';
        // Check follow status
        $followCheckStmt = $dbConn->db->prepare("SELECT * FROM follow WHERE id_follower = ? AND id_isfollow = ?");
        $followCheckStmt->execute([$userId, $post['author_id']]);
        $isFollowing = $followCheckStmt->fetch() ? "Unfollow" : "Follow";
        echo "<button onclick='toggleFollow(" . $post['author_id'] . ")' class='btn btn-info'>" . $isFollowing . "</button>";
        
        echo '</div>';
        echo '<h4>' . htmlspecialchars($post['titre']) . '</h4>';
        echo '<p>' . htmlspecialchars($post['texte']) . '</p>';
        if ($post['url_image']) {
            echo '<img src="' . htmlspecialchars($post['url_image']) . '" alt="Post image" class="img-fluid">';
        }
        echo '</div>';
        echo '<small>Release time: ' . htmlspecialchars($post['date']) . '</small>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button id="loadMore" class="btn btn-info">Chargement de plus de messages</button>';
    echo '</div>';
} else {
    echo '<p class="alert alert-warning">Veuillez vous connecter pour voir cette page.</p>';
}

include(__ROOT__ . "/codePart/footer.php");
?>

<script>
let offset = 10; // 初始偏移量为10，因为已经加载了10条

document.getElementById('loadMore').addEventListener('click', function() {
    fetch(`timeline.php?offset=${offset}`)
    .then(response => response.json())
    .then(data => {
        const postsContainer = document.querySelector('.posts');
        data.forEach(post => {
            const postElement = document.createElement('div');
            postElement.className = 'post user-profile';
            postElement.innerHTML = `
                <div class="profile-header">
                    <img src="${post.url_avatar}" alt="User avatar" class="avatar rounded-circle">
                    <h3>${post.prenom} ${post.nom}</h3>
                    <button onclick='toggleFollow(${post.author_id})' class='btn btn-info'>${post.isFollowing ? "Unfollow" : "Follow"}</button>
                </div>
                <h4>${post.titre}</h4>
                <p>${post.texte}</p>
                ${post.url_image ? `<img src="${post.url_image}" alt="Post image" class="img-fluid">` : ''}
                <small>Release time: ${post.date}</small>
            `;
            postsContainer.appendChild(postElement);
        });
        offset += data.length; // 更新已加载的帖子数
        if (data.length < 10) {
            document.getElementById('loadMore').style.display = 'none'; // 如果加载的帖子少于10条，隐藏按钮
        }
    })
    .catch(error => console.error('Error loading more posts:', error));
});
</script>

<script>
function toggleFollow(followId) {
    const buttonText = document.querySelector(`button[onclick='toggleFollow(${followId})']`).innerText;
    const action = (buttonText === "Follow") ? "follow.php" : "unfollow.php";
    fetch(`${action}?follow_id=${followId}`)
    .then(response => response.text())
    .then(data => {
        document.querySelector(`button[onclick='toggleFollow(${followId})']`).innerText = data.includes("Follow") ? "Unfollow" : "Follow";
    })
    .catch(error => console.error('Error toggling follow:', error));
}
</script>

<?php
// 加载更多帖子的PHP逻辑
if (isset($_GET['offset'])) {
    $offset = intval($_GET['offset']);
    $stmt = $dbConn->db->prepare("
        SELECT p.id, p.texte, p.titre, p.url_image, p.date, u.prenom, u.nom, u.url_avatar 
        FROM post p
        JOIN follow f ON p.id_owner = f.id_isfollow
        JOIN user u ON u.id = p.id_owner
        WHERE f.id_follower = ?
        ORDER BY p.date DESC
        LIMIT 10 OFFSET ?");
    $stmt->execute([$userId, $offset]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($posts);
    exit;
}
?>