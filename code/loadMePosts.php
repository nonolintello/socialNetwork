<?php
include("./ini.php");

$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';
$currentUserID = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

if ($sort === 'date') {
    $query = "SELECT post.*, 
              (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id) AS nbLike,
              (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id AND jaime.id_user = :currentUserID) AS hasLiked,
              user.admin AS isAdmin
              FROM post 
              JOIN user ON user.id = post.id_owner
              where post.id_parent is null AND post.sensible = 0 AND post.removed = 0 AND post.titre <> 'Banni!!!'
              ORDER BY post.date DESC 
              LIMIT :offset, :limit";
} else if ($sort === 'popularity') {
    $query = "SELECT post.*, 
              (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id) AS nbLike,
              (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id AND jaime.id_user = :currentUserID) AS hasLiked,
              user.admin AS isAdmin
              FROM post 
              JOIN user ON user.id = post.id_owner
              where post.id_parent is null AND post.sensible = 0 AND post.removed = 0 AND post.titre <> 'Banni!!!'
              ORDER BY nbLike DESC 
              LIMIT :offset, :limit";
}

$stmt = $dbConn->db->prepare($query);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':currentUserID', $currentUserID, PDO::PARAM_INT);
$stmt->execute();

while ($posts = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $ownerID = $posts['id_owner'];
    $blogOwner = $dbConn->GetBlogINFOFromID($ownerID, $dbConn->loginStatus->userName);
    $ownerName = htmlspecialchars($blogOwner[0]);
    $avatarOwner = $blogOwner[1];
    $isMyBlog = $blogOwner[2];
    $ownerIsAdmin = $posts['isAdmin'];

    $postOBJ = new postStorage($posts);
    $postOBJ->DisplayToHTML($ownerName, $avatarOwner, $ownerID, $isMyBlog,false, $ownerIsAdmin); 
    $dbConn->GenerateReplies($postOBJ);
}
