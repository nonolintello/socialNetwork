<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $password = $_POST['password'] ?? null;
    $confirm_password = $_POST['confirm_password'] ?? null;
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $adresse = $_POST['adresse'];
    $bio = $_POST['bio'];

    $updateFields = [
        'nom' => $nom,
        'prenom' => $prenom,
        'date_naissance' => $date_naissance,
        'adresse' => $adresse,
        'bio' => $bio
    ];
    if ($password && $confirm_password) {
        if ($password !== $confirm_password) {
            die("Passwords do not match.");
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $updateFields['mdp'] = $hashed_password;
        }
    }
    $sqlParts = [];
    foreach ($updateFields as $field => $value) {
        $sqlParts[] = "$field = :$field";
    }
    $sqlStatement = "UPDATE user SET " . implode(', ', $sqlParts) . " WHERE id = :id";

    $stmt = $dbConn->db->prepare($sqlStatement);
    foreach ($updateFields as $field => $value) {
        $stmt->bindParam(":$field", $updateFields[$field]);
    }
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    $uploader = new ImgFileUploader($dbConn, true); 
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $avatarPath = $uploader->saveFileAsNewAvatar();
        if ($avatarPath !== '') { 
            $stmt = $dbConn->db->prepare("UPDATE user SET url_avatar = ? WHERE id = ?");
            $stmt->execute([$avatarPath, $userId]);
            $_SESSION['avatar'] = $avatarPath;

            echo "Avatar mis à jour avec succès."; 
        } else {
            echo "Échec de la mise à jour de l'avatar."; 
        }
    } else {
        echo "Aucun fichier téléchargé ou erreur lors du téléchargement."; 
    }
    header("Location: profile.php");
} else {
    if ($dbConn->loginStatus->loginAttempted) {
        echo '<br><br><h3 class="errorMessage">' . $dbConn->loginStatus->errorText . '</h3><br><br><br>';
    }
    include(__DIR__ . "/codePart/loginForm.php");
}

include(__ROOT__ . "/codePart/footer.php");
