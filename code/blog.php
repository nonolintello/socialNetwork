<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

echo '<div class="container mt-4">';

if (isset($_GET["id"])) {
    $blogOwner = $dbConn->GetBlogINFOFromID($_GET["id"], $dbConn->loginStatus->userName);
    $blogOwnerName = htmlspecialchars($blogOwner[0]);
    $avatarOwner = $blogOwner[1];
    $isMyOwnBlog = $blogOwner[2];
    $biographie = htmlspecialchars($blogOwner[3]);
    $isAdmin = $blogOwner[4];

    $viewedUserId = $_GET['id'];
    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
    $currentUserIsAdmin = $dbConn->isAdmin($userId);
    $stmt = $dbConn->db->prepare("SELECT * FROM follow WHERE id_follower = ? AND id_isfollow = ?");
    $stmt->execute([$userId, $viewedUserId]);
    $isFollowing = $stmt->fetch() ? "Unfollow" : "Follow";

    if ($blogOwnerName != "") {
        echo '<div class="blog-header text-center mb-4">';
        echo '<img src="' . htmlspecialchars($avatarOwner) . '" alt="Avatar" class="rounded-circle img-fluid shadow" style="width: 120px; height: 120px;">';
        echo '<h1 class="display-4">' . $blogOwnerName . '</h1>';
        if ($isAdmin) { // Display admin badge if user is an admin
            echo ' <img src="images/avatar/admin.png" alt="Admin" class="admin-badge" style="width: 60px; height: 60px;">';
        }
        echo '</h1>';
        echo '<p class="lead">' . $biographie . '</p>';

        if ($isMyOwnBlog) {
            echo '<div class="btn-group mt-3">';
            echo '<a href="profile.php" class="btn btn-primary">Modifier le profil</a>';
            echo '<a href="suivis.php" class="btn btn-secondary">Voir les abonnements</a>';
            echo '</div>';
        } else {
            if($currentUserIsAdmin){
                echo "<button id='banButton' class='btn btn-danger mt-3' onclick='openBanForm($viewedUserId)'>Utilisateur banni</button>";
            }
            if ($userId > 0) {
                $stmt = $dbConn->db->prepare("SELECT * FROM follow WHERE id_follower = ? AND id_isfollow = ?");
                $stmt->execute([$userId, $_GET["id"]]);
                $isFollowing = $stmt->fetch() ? "Unfollow" : "Follow";
                echo "<button id='followButton' class='btn btn-info mt-3' onclick='toggleFollow($viewedUserId)'>$isFollowing</button>";
            }
        }

        echo '</div>';

        echo '<div class="blog-posts" id="blogPostsContainer">';
        $dbConn->GenerateHTML_forPostsPage($_GET["id"], $blogOwnerName, $avatarOwner, $isMyOwnBlog);
        echo '</div>';
        echo '<div id="dataId" userId="' . htmlspecialchars($_GET['id']) . '"></div>';
        echo '<div class="text-center mt-3">';
        echo '<button id="loadMoreBtnBlog" class="btn btn-primary">Charger plus de messages</button>';
        echo '</div>';
    } else {
        echo '<div class="alert alert-danger">Cet ID ne correspond à aucun utilisateur dans la base de données.</div>';
    }
} else {
    echo '<div class="alert alert-warning">Aucun ID fourni. Impossible de trouver le blog.</div>';
}

echo '</div>';

include(__ROOT__ . "/codePart/footer.php");
