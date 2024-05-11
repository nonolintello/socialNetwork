<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

$currentUserID = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';
$type = isset($_GET['type']) ? $_GET['type'] : 'all';

?>
<h2 class="text-center">Résultats de recherche</h2>
<div class="container">
    <div class="btn-group" role="group">
        <a href="?type=user&search=<?php echo urlencode($searchQuery); ?>&sort=<?php echo $sort; ?>" class="btn btn-primary">Recherche par Utilisateur</a>
        <a href="?type=post&search=<?php echo urlencode($searchQuery); ?>&sort=<?php echo $sort; ?>" class="btn btn-primary">Recherche par Post</a>
    </div>

    <div class="d-flex justify-content-end mt-3 mb-3">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Trier par
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="?sort=date&type=<?php echo $type; ?>&search=<?php echo urlencode($searchQuery); ?>">Date</a>
                <a class="dropdown-item" href="?sort=popularity&type=<?php echo $type; ?>&search=<?php echo urlencode($searchQuery); ?>">Popularité</a>
            </div>
        </div>
    </div>

    <div class="posts">
        <?php
        $searchQueryFormatted = '%' . strtolower($searchQuery) . '%';
        displayAllResults($dbConn, $currentUserID, $searchQueryFormatted, $sort, $type);
        ?>
    </div>
</div>

<?php
include(__ROOT__ . "/codePart/footer.php");

function displayAllResults($dbConn, $userID, $searchQuery, $sort, $type) {
    // 显示所有相关的帖子和用户
    if ($type === 'post' || $type === 'all') {
        $postQuery = "SELECT post.*, user.admin AS isAdmin,
                      (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id) AS nbLike,
                      (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id AND jaime.id_user = :currentUserID) AS hasLiked
                      FROM post 
                      JOIN user ON user.id = post.id_owner
                      WHERE post.id_parent is null AND (LOWER(post.texte) LIKE :search OR LOWER(post.titre) LIKE :search) AND post.sensible = 0 AND post.removed = 0 AND post.titre <> 'Banni!!!'
                      ORDER BY " . ($sort === 'popularity' ? "nbLike DESC" : "post.date DESC");

        $stmt = $dbConn->db->prepare($postQuery);
        $stmt->bindParam(':currentUserID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':search', $searchQuery, PDO::PARAM_STR);
        $stmt->execute();

        echo '<div class="postContainer">';
        while ($posts = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $postOBJ = new postStorage($posts);
            $isAdmin = $posts['isAdmin'];
            $ownerInfo = $dbConn->GetBlogINFOFromID($posts['id_owner'], $dbConn->loginStatus->userName);
            $postOBJ->DisplayToHTML($ownerInfo[0], $ownerInfo[1], $posts['id_owner'], $ownerInfo[2], false, $isAdmin);
            $dbConn->GenerateReplies($postOBJ);
        }
        echo '</div>';
    }

    if ($type === 'user' || $type === 'all') {
        $userQuery = "SELECT * FROM user WHERE LOWER(nom) LIKE :search OR LOWER(prenom) LIKE :search";
        $userStmt = $dbConn->db->prepare($userQuery);
        $userStmt->bindParam(':search', $searchQuery, PDO::PARAM_STR);
        $userStmt->execute();

        while ($user = $userStmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<h3>Utilisateur: ' . htmlspecialchars($user['prenom'] . ' ' . $user['nom']) . '</h3>';
            // Display posts for each user found
            displayPostsForUser($dbConn, $user['id'], $sort);
        }
    }
}

function displayPostsForUser($dbConn, $userID, $sort) {
    $query = "SELECT post.*,  user.admin AS isAdmin,
              (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id) AS nbLike,
              (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id AND jaime.id_user = :currentUserID) AS hasLiked
              FROM post
              JOIN user ON user.id = post.id_owner
              WHERE post.id_owner = :userID AND post.id_parent is null AND post.sensible = 0 AND post.removed = 0 AND post.titre <> 'Banni!!!'
              ORDER BY " . ($sort === 'popularity' ? "nbLike DESC" : "post.date DESC");

    $stmt = $dbConn->db->prepare($query);
    $stmt->bindParam(':currentUserID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    echo '<div class="postContainer">';
    while ($posts = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $postOBJ = new postStorage($posts);
        $ownerInfo = $dbConn->GetBlogINFOFromID($posts['id_owner'], $dbConn->loginStatus->userName);
        $isAdmin = $posts['isAdmin'];
        $postOBJ->DisplayToHTML($ownerInfo[0], $ownerInfo[1], $posts['id_owner'], $ownerInfo[2], false, $isAdmin);
        $dbConn->GenerateReplies($postOBJ);
    }
    echo '</div>';
}
?>
