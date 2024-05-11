<?php
include("./ini.php");

$userId = isset($_GET["user_id"]) ? intval($_GET["user_id"]) : 0;
$offset = isset($_GET["offset"]) ? intval($_GET["offset"]) : 0;
$limit = isset($_GET["limit"]) ? intval($_GET["limit"]) : 5;

$query = "SELECT post.*, 
          (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id) AS nbLike,
          (SELECT COUNT(*) FROM jaime WHERE jaime.id_post = post.id AND jaime.id_user = :currentUserID) AS hasLiked,
          user.admin AS isAdmin
          FROM post 
          JOIN user ON user.id = post.id_owner
          WHERE post.id_owner = :userId and post.id_parent is null AND post.removed = 0 
          ORDER BY post.date DESC 
          LIMIT :offset, :limit";

$stmt = $dbConn->db->prepare($query);
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->bindParam(':currentUserID', $currentUserID, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();

while ($posts = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $ownerID = $posts['id_owner'];
    $blogOwner = $dbConn->GetBlogINFOFromID($ownerID, $dbConn->loginStatus->userName);
    $ownerName = htmlspecialchars($blogOwner[0]);
    $avatarOwner = htmlspecialchars($blogOwner[1]);
    $isMyBlog = $blogOwner[2];
    $ownerIsAdmin = $posts['isAdmin'];

    $postOBJ = new postStorage($posts);
    $postOBJ->DisplayToHTML($ownerName, $avatarOwner, $ownerID, $isMyBlog, false, $ownerIsAdmin);
}
