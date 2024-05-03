<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    // 一开始就加载10条帖子
    $stmt = $dbConn->db->prepare("
        SELECT p.texte, p.date, u.prenom, u.nom 
        FROM post p
        JOIN follow f ON p.id_owner = f.id_isfollow
        JOIN user u ON u.id = p.id_owner
        WHERE f.id_follower = ?
        ORDER BY p.date DESC
        LIMIT 10");
    $stmt->execute([$userId]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<h1>Trends to follow</h1>';
    echo '<div class="posts">';
    foreach ($posts as $post) {
        echo '<div class="post">';
        echo '<h3>' . htmlspecialchars($post['prenom']) . ' ' . htmlspecialchars($post['nom']) . '</h3>';
        echo '<p>' . htmlspecialchars($post['texte']) . '</p>';
        echo '<small>Release time: ' . htmlspecialchars($post['date']) . '</small>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button id="loadMore">Chargement de plus de messages</button>';
} else {
    echo '<p>Veuillez vous connecter pour voir cette page.</p>';
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
            postElement.className = 'post';
            postElement.innerHTML = `
                <h3>${post.prenom} ${post.nom}</h3>
                <p>${post.texte}</p>
                <small>发布时间: ${post.date}</small>
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

<?php
// 加载更多帖子的PHP逻辑
if (isset($_GET['offset'])) {
    $offset = intval($_GET['offset']);
    $stmt = $dbConn->db->prepare("
        SELECT p.texte, p.date, u.prenom, u.nom 
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