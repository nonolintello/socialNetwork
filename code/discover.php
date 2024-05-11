<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

$currentUserID = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

?>
<h2 class="text-center"> Découvrez de nouveaux posts </h2>
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


    <div class="posts">

        <?php
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';
        if ($sort === 'date') {
            $query = "SELECT post.*,  user.admin AS isAdmin,
                      (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id) AS nbLike,
                      (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id AND jaime.id_user = :currentUserID) AS hasLiked
                      FROM post 
                      JOIN user ON user.id = post.id_owner
                      where post.id_parent is null  AND post.sensible = 0 AND post.removed = 0 AND post.titre <> 'Banni!!!'
                      ORDER BY post.date DESC 
                      LIMIT 10";
        } elseif ($sort === 'popularity') {
            $query = "SELECT post.*,  user.admin AS isAdmin,
                      (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id) AS nbLike,
                      (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id AND jaime.id_user = :currentUserID) AS hasLiked
                      FROM post 
                      JOIN user ON user.id = post.id_owner
                      where post.id_parent is null AND post.sensible = 0 AND post.removed = 0 AND post.titre <> 'Banni!!!'
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