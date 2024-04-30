<?php
include("./ini.php");
include(__ROOT__. "/codePart/header.php"); 

if (isset($_GET["id"])) {
    $blogOwner = $dbConn->GetBlogOwnerFromID($_GET["id"], $dbConn->loginStatus->userName);
    $blogOwnerName = $blogOwner[0];
    $isMyOwnBlog = $blogOwner[1];

    echo is_object($dbConn->db);
    if ($blogOwnerName != "") {
        if ($isMyOwnBlog) {
            echo "<h1>  Votre blog : " . htmlspecialchars($blogOwnerName) . " </h1>";
        } else {
            echo "<h1>Blog de : " . htmlspecialchars($blogOwnerName) . "</h1>";
        }
        echo is_object($dbConn->db);
        $dbConn->GenerateHTML_forPostsPage($_GET["id"], $blogOwnerName, $isMyOwnBlog);
    } else {
        echo "<h1>error : Cet id ne correspond à aucun utilisateur dans la DB</h1>";
    }
}

?>

