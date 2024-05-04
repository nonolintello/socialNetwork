<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

if (isset($_SESSION['id'])) {
    $viewedUserId = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
    $userId = $_SESSION['id'];

    $stmt = $dbConn->db->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo '<div class="container mt-4 user-profile">';
    echo '<div class="profile-header">';
    echo '<img src="' . htmlspecialchars($user['url_avatar']) . '" alt="User avatar" class="avatar rounded-circle">';
    echo '<h1 class="ml-3">' . htmlspecialchars($user['prenom']) . ' ' . htmlspecialchars($user['nom']) . '</h1>';
    echo '</div>';
    echo '<p class="bio">' . htmlspecialchars($user['bio']) . '</p>';
    echo '<div class="user-details">';
    echo '<ul>';
    echo '<li><strong>Email:</strong> ' . htmlspecialchars($user['email']) . '</li>';
    echo '<li><strong>Birthday:</strong> ' . htmlspecialchars($user['date_naissance']) . '</li>';
    echo '<li><strong>Address:</strong> ' . htmlspecialchars($user['adresse']) . ', ' . htmlspecialchars($user['cp']) . ', ' . htmlspecialchars($user['commune']) . '</li>';
    echo '</ul>';

    if ($userId !== $viewedUserId) {
        $stmt = $dbConn->db->prepare("SELECT * FROM follow WHERE id_follower = ? AND id_isfollow = ?");
        $stmt->execute([$userId, $userId]);
        $isFollowing = $stmt->fetch() ? "Unfollow" : "Follow";
        echo "<button id='followButton' class='btn btn-info mt-3' onclick='toggleFollow($userId)'>$isFollowing</button>";
    }

    echo '</div>'; // Close user-details
    echo '<script>
            function toggleFollow(followId) {
                fetch(`follow.php?follow_id=${followId}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("followButton").innerText = data;
                }).catch(error => console.error("Error:", error));
            }
          </script>';

    echo '<h2>Your Personal Statistics</h2>';
    echo '<div id="statistics"></div>';
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                fetch("fetchStatistics.php")
                .then(response => response.json())
                .then(data => {
                    document.getElementById("statistics").innerHTML =
                    "<ul>" +
                    "<li>Followers: " + data.followers + "</li>" +
                    "<li>Following: " + data.following + "</li>" +
                    "<li>Total Posts: " + data.total_posts + "</li>" +
                    "<li>Likes Given: " + data.likes_given + "</li>" +
                    "<li>Likes Received: " + data.likes_received + "</li>" +
                    "</ul>";
                }).catch(error => console.error("Error loading the statistics:", error));
            });
          </script>';

    if ($userId == $viewedUserId) {
        echo '<form id="updateProfileForm" action="updateProfile.php" method="post" enctype="multipart/form-data" class="form-profile-update mt-4">';
        echo '<h2>Update Your Profile</h2>';
        echo 'Email: <input type="email" name="email" value="' . htmlspecialchars($user['email']) . '" readonly class="form-control"><br>';
        echo 'New Password: <input type="password" name="password" class="form-control"><br>';
        echo 'Confirm New Password: <input type="password" name="confirm_password" class="form-control"><br>';
        echo 'Name: <input type="text" name="nom" value="' . htmlspecialchars($user['nom']) . '" class="form-control"><br>';
        echo 'First Name: <input type="text" name="prenom" value="' . htmlspecialchars($user['prenom']) . '" class="form-control"><br>';
        echo 'Birthday: <input type="date" name="date_naissance" value="' . htmlspecialchars($user['date_naissance']) . '" class="form-control"><br>';
        echo 'Address: <input type="text" name="adresse" value="' . htmlspecialchars($user['adresse']) . '" class="form-control"><br>';
        echo 'Biography: <input type="text" name="bio" value="' . htmlspecialchars($user['bio']) . '" class="form-control"><br>';
        echo 'Change Avatar: <input type="file" name="avatar" class="form-control-file"><br>';
        echo '<button type="submit" class="btn btn-primary">Update Profile</button>';
        echo '</form>';
    }

} else {
    echo "<div class='alert alert-warning'>Vous devez être connecté pour accéder aux informations personnelles. Veuillez cliquer sur l'icône dans le coin supérieur droit pour vous connecter.</div>";
}
include(__ROOT__ . "/codePart/footer.php");
?>

