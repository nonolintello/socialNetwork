<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

$query = "SELECT p.*, u.prenom, u.nom, u.url_avatar, u.id as user_id FROM post p JOIN user u ON p.id_owner = u.id ORDER BY p.date DESC LIMIT 10";
$stmt = $dbConn->db->prepare($query);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="d-flex justify-content-end mt-3 mb-3">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Trier par
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="?sort=date">Date</a>
                <a class="dropdown-item" href="?sort=popularity">Popularité</a>
            </div>
        </div>
    </div>

    <div class="posts">
        <?php
        foreach ($posts as $post) {
            $userId = $_SESSION['id'];
            $ownerId = $post['user_id'];
            $stmt = $dbConn->db->prepare("SELECT * FROM follow WHERE id_follower = ? AND id_isfollow = ?");
            $stmt->execute([$userId, $ownerId]);
            $isFollowing = $stmt->fetch() ? "Unfollow" : "Follow";

            echo "<div class='post'>";
            echo "<a href='userProfile.php?user_id=" . $ownerId . "'><img src='" . htmlspecialchars($post['url_avatar']) . "' alt='User Avatar' class='avatar'></a>";
            echo "<h3><a href='userProfile.php?user_id=" . $ownerId . "'>" . htmlspecialchars($post['prenom']) . " " . htmlspecialchars($post['nom']) . "</a></h3>";
            echo "<p>" . htmlspecialchars($post['texte']) . "</p>";
            echo "<small>Posted on: " . htmlspecialchars($post['date']) . "</small>";
            echo "<button onclick='toggleFollow(" . $ownerId . ")' class='btn btn-info'>" . $isFollowing . "</button>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<script>
function toggleFollow(ownerId) {
    const button = document.querySelector(`button[onclick='toggleFollow(${ownerId})']`);
    const action = button.innerText === "Follow" ? "follow.php" : "unfollow.php";
    fetch(`${action}?follow_id=${ownerId}`)
    .then(response => response.text())
    .then(data => {
        button.innerText = data.includes("Unfollow") ? "Follow" : "Unfollow";
    })
    .catch(error => console.error('Error toggling follow:', error));
}
</script>

<?php
include(__ROOT__ . "/codePart/footer.php");
?>
