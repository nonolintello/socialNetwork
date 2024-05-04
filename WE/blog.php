<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

if (isset($_GET["id"])) {
    $blogOwner = $dbConn->GetBlogOwnerFromID($_GET["id"], $dbConn->loginStatus->userName);
    $blogOwnerName = htmlspecialchars($blogOwner[0]);
    $avatarOwner = $blogOwner[1];
    $isMyOwnBlog = $blogOwner[2];

    echo '<div class="container mt-4">';

    if ($blogOwnerName != "") {
        if ($isMyOwnBlog) {
            echo '<h1 class="blog-owner-title">Votre blog : ' . $blogOwnerName . '</h1>';
        } else {
            echo '<h1 class="blog-owner-title">Blog de  ' . $blogOwnerName . '</h1>';
        }

        $dbConn->GenerateHTML_forPostsPage($_GET["id"], $blogOwnerName, $avatarOwner, $isMyOwnBlog); 
    } else {
        echo '<div class="alert alert-danger" role="alert">Cet ID ne correspond à aucun utilisateur dans la base de données.</div>';
    }

    echo '</div>';
} else {
    echo '<div class="container mt-4"><div class="alert alert-warning" role="alert">Aucun ID fourni. Impossible de trouver le blog.</div></div>';
}

include(__ROOT__ . "/codePart/footer.php");
