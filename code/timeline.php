<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

$currentUserID = isset($_SESSION['id']) ? $_SESSION['id'] : 0;


if (isset($_GET['action']) && $_GET['action'] == 'loadFollowDetails') {
    $userId = $_SESSION['id'];
    $stmt = $dbConn->db->prepare("SELECT u.id, u.prenom, u.nom, u.url_avatar FROM user u JOIN follow f ON u.id = f.id_isfollow WHERE f.id_follower = ?");
    $stmt->execute([$userId]);
    $followings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($followings as $following) {
        echo '<div class="follow-item user-details">';
        echo '<img src="' . htmlspecialchars($following['url_avatar']) . '" class="avatar">';
        echo '<p>' . htmlspecialchars($following['prenom']) . ' ' . htmlspecialchars($following['nom']) . '</p>';
        echo "<button class='btn btn-info' onclick='unfollow(" . $following['id'] . ")'>Unfollow</button>";
        echo '</div>';
    }
    exit;
}
?>
<h2 class="text-center">
    <?php if ($currentUserID > 0) { ?>
        Posts de vos abonnements
    <?php } else { ?>
        Connectez-vous pour voir les posts de vos abonnements
    <?php } ?>
</h2>
<div class="container">
    <div class="d-flex justify-content-end mt-3 mb-3">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Trier par
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="?sort=date">Date</a>
                <a class="dropdown-item" href="?sort=popularity">Popularité</a>
            </div>
        </div>
    </div>

    <button id="followButton" class="btn btn-secondary">Voir les abonnements</button>
    <div id="followDetails" class="follow-dropdown" style="display:none;"></div>

    <div class="posts">

        <?php
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';
        if ($sort === 'date') {
            $query = "SELECT post.*, user.admin AS isAdmin,
                      (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id) AS nbLike,
                      (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id AND jaime.id_user = :currentUserID) AS hasLiked
                      FROM post 
                      JOIN user ON user.id = post.id_owner
                      JOIN follow ON follow.id_isfollow = post.id_owner
                      WHERE follow.id_follower = :currentUserID AND post.id_parent is null AND post.sensible = 0 AND post.removed = 0 AND post.titre <> 'Banni!!!'
                      ORDER BY post.date DESC 
                      LIMIT 10";
        } elseif ($sort === 'popularity') {
            $query = "SELECT post.*, user.admin AS isAdmin,
                      (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id) AS nbLike,
                      (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id AND jaime.id_user = :currentUserID) AS hasLiked
                      FROM post 
                      JOIN user ON user.id = post.id_owner
                      JOIN follow ON follow.id_isfollow = post.id_owner
                      WHERE follow.id_follower = :currentUserID AND post.id_parent is null AND post.sensible = 0 AND post.removed = 0 AND post.titre <> 'Banni!!!'
                      ORDER BY nbLike DESC 
                      LIMIT 10";
        }

        $stmt = $dbConn->db->prepare($query);
        $stmt->bindParam(':currentUserID', $currentUserID, PDO::PARAM_INT);
        $stmt->execute();

        echo '<div class="postContainer">';

        while ($posts = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ownerID = $posts['id_owner'];
            $blogOwner = $dbConn->GetBlogINFOFromID($ownerID, $dbConn->loginStatus->userName);
            $ownerName = htmlspecialchars($blogOwner[0]);
            $avatarOwner = $blogOwner[1];
            $isMyBlog = $blogOwner[2];
            $isAdmin = $posts['isAdmin'];
            $postOBJ = new postStorage($posts);
            $postOBJ->DisplayToHTML($ownerName, $avatarOwner, $ownerID, $isMyBlog, false, $isAdmin);
            $dbConn->GenerateReplies($postOBJ);
        }

        echo '</div>';
        ?>
    </div>

    <div id="sortType" sort="<?php echo htmlspecialchars($sort); ?>"></div>
    <div class="text-center mt-3">
        <button id="loadMoreBtnDiscover" class="btn btn-primary">Charger plus de messages</button>
    </div>
</div>

<?php
include(__ROOT__ . "/codePart/footer.php");
?>
<script>
    document.getElementById('followButton').addEventListener('mouseenter', function() {
        fetch('timeline.php?action=loadFollowDetails')
            .then(response => response.text())
            .then(html => {
                document.getElementById('followDetails').innerHTML = html;
                document.getElementById('followDetails').style.display = 'block';
            });
    });

    document.getElementById('followDetails').addEventListener('mouseleave', function() {
        this.style.display = 'none';
    });
</script>