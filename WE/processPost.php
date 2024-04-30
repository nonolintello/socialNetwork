<?php
include("./ini.php");

include(__ROOT__ . "/classes/imageUpload.php");

$dbConn = new dbConn();

if (isset($_POST["action"])) {
    if ($_POST["action"] == "edit") {
        if (isset($_POST["title"]) && isset($_POST["content"]) && isset($_POST["postID"])) {
            $postID = (int)$_POST["postID"];
            $title = $dbConn->sanitize($_POST["title"]);
            $content = $dbConn->sanitize($_POST["content"]);

            $query = "UPDATE `post` SET `titre` = :title, `texte` = :content WHERE `id` = :postID";
            $stmt = $dbConn->db->prepare($query);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
            $stmt->execute();


            $img = new ImgFileUploader($dbConn); // Crée une instance pour l'upload
            $img->OverrideOldFile($postID); // Écrase l'image existante
        }
    } elseif ($_POST["action"] == "new") {
        if (isset($_POST["title"]) && isset($_POST["content"])) {
            $title = $dbConn->sanitize($_POST["title"]);
            $content = $dbConn->sanitize($_POST["content"]);

            $query = "INSERT INTO `post` (`titre`, `texte`, `id_owner`) VALUES (:title, :content, :ownerID)";
            $stmt = $dbConn->db->prepare($query);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':ownerID', $dbConn->loginStatus->userID, PDO::PARAM_INT);
            $stmt->execute();

           
            $img = new ImgFileUploader($dbConn); 
            $img->SaveFileAsNew($postID ); 
        }
    } elseif ($_POST["action"] == "delete") {
        if (isset($_POST["postID"])) {
            $postID = (int)$_POST["postID"];

            
            $img = new ImgFileUploader($dbConn); // Instance pour la gestion des fichiers
            $img->DeleteFile($postID); // Supprime l'image associée au post
            
            $query = "DELETE FROM `post` WHERE `id` = :postID";
            $stmt = $dbConn->db->prepare($query);
            $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    header("Location: ./blog.php?id=" . urlencode($dbConn->loginStatus->userID));
    exit();
}
?>
