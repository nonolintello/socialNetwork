<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

if (isset($_SESSION['id'])) {
    $viewedUserId = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
    $userId = $_SESSION['id'];

    $stmt = $dbConn->db->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo '<div class="container mt-4">';

    // Section du profil utilisateur
    echo '<div class="card mb-4">';
    echo '<div class="card-body d-flex align-items-center">';
    echo '<img src="' . htmlspecialchars($user['url_avatar']) . '" alt="Avatar de l\'utilisateur" class="avatar rounded-circle" style="width: 100px; height: 100px;">';
    echo '<div class="ml-3">';
    echo '<h1>' . htmlspecialchars($user['prenom']) . ' ' . htmlspecialchars($user['nom']) . '</h1>';
    echo '<p class="text-muted">' . htmlspecialchars($user['bio']) . '</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    // Section des détails de l'utilisateur
    echo '<div class="card">';
    echo '<div class="card-header">Informations de contact</div>';
    echo '<div class="card-body">';
    echo '<ul class="list-unstyled">';
    echo '<li><strong>Email:</strong> ' . htmlspecialchars($user['email']) . '</li>';
    echo '<li><strong>Anniversaire:</strong> ' . htmlspecialchars($user['date_naissance']) . '</li>';
    echo '<li><strong>Adresse:</strong> ' . htmlspecialchars($user['adresse']) . ', ' . htmlspecialchars($user['cp']) . ', ' . htmlspecialchars($user['commune']) . '</li>';
    echo '</ul>';

    if ($userId !== $viewedUserId) {
        $stmt = $dbConn->db->prepare("SELECT * FROM follow WHERE id_follower = ? AND id_isfollow = ?");
        $stmt->execute([$userId, $viewedUserId]);
        $isFollowing = $stmt->fetch() ? "Unfollow" : "Follow";
        echo "<button id='followButton' class='btn btn-info mt-3' onclick='toggleFollow($viewedUserId)'>$isFollowing</button>";
    }

    echo '</div>'; 
    echo '</div>';
    echo '<script>
            function toggleFollow(followId) {
                fetch(`follow.php?follow_id=${followId}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("followButton").innerText = data;
                }).catch(error => console.error("Error:", error));
            }
          </script>';
    echo '<div class="card mt-4">';
    echo '<div class="card-header">Vos statistiques personnelles</div>';
    echo '<div class="card-body" id="statistics"></div>';
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                fetch("fetchStatistics.php")
                .then(response => response.json())
                .then(data => {
                    document.getElementById("statistics").innerHTML =
                    "<ul class=\'list-unstyled\'>" +
                    "<li>Suiveurs: " + data.followers + "</li>" +
                    "<li>Suivi: " + data.following + "</li>" +
                    "<li>Total des posts: " + data.total_posts + "</li>" +
                    "<li>Likes donnés: " + data.likes_given + "</li>" +
                    "<li>Likes reçus: " + data.likes_received + "</li>" +
                    "</ul>";
                }).catch(error => console.error("Erreur de chargement des statistiques:", error));
            });
          </script>';

    if ($userId == $viewedUserId) {
        echo '<div class="card mt-4">';
        echo '<div class="card-header">Modifier votre profil</div>';
        echo '<div class="card-body">';
        echo '<form id="updateProfileForm" action="updateProfile.php" method="post" enctype="multipart/form-data">';
        echo 'Email: <input type="email" name="email" value="' . htmlspecialchars($user['email']) . '" readonly class="form-control mb-2">';
        echo 'Nouveau mot de passe: <input type="password" name="password" class="form-control mb-2">';
        echo 'Confirmer le nouveau mot de passe: <input type="password" name="confirm_password" class="form-control mb-2">';
        echo 'Nom: <input type="text" name="nom" value="' . htmlspecialchars($user['nom']) . '" class="form-control mb-2">';
        echo 'Prénom: <input type="text" name="prenom" value="' . htmlspecialchars($user['prenom']) . '" class="form-control mb-2">';
        echo 'Date de naissance: <input type="date" name="date_naissance" value="' . htmlspecialchars($user['date_naissance']) . '" class="form-control mb-2">';
        echo 'Adresse: <input type="text" name="adresse" value="' . htmlspecialchars($user['adresse']) . '" class="form-control mb-2">';
        echo 'Biographie: <textarea name="bio" class="form-control mb-2">' . htmlspecialchars($user['bio']) . '</textarea>';
        echo 'Changer d\'avatar: <input type="file" name="avatar" class="form-control-file mb-2">';
        echo '<button type="submit" class="btn btn-primary">Mettre à jour le profil</button>';
        echo '</form>';
        echo '</div>'; 
        echo '</div>';
    }

    echo '</div>'; 

} else {
    echo "<div class='alert alert-warning'>Vous devez être connecté pour accéder aux informations personnelles. Veuillez vous connecter.</div>";
}

include(__ROOT__ . "/codePart/footer.php");
