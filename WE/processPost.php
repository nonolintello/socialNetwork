<?php
include("./ini.php");

require_once(__ROOT__ . "/classes/imageUpload.php");

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


            $img = new ImgFileUploader($dbConn,false); // Crée une instance pour l'upload
           // echo $img->errorText;
           
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

            $lastInsertID = $dbConn->db->lastInsertId();
            $img = new ImgFileUploader($dbConn,false); 
            //echo $img->errorText;
    
            $img->SaveFileAsNew($lastInsertID); 
        }
    } elseif ($_POST["action"] == "delete") {
        if (isset($_POST["postID"])) {
            $postID = (int)$_POST["postID"];

            
            $img = new ImgFileUploader($dbConn,false); 
            $img->DeleteFile($postID); 
            
            $query = "DELETE FROM `post` WHERE `id` = :postID";
            $stmt = $dbConn->db->prepare($query);
            $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    //yangran add the notification function
    //Once a new post is sent, notification is sent to followers
    $postID = isset($_POST["postID"]) ? (int)$_POST["postID"] : null;
    $title = isset($_POST["title"]) ? $dbConn->sanitize($_POST["title"]) : '';
    $content = isset($_POST["content"]) ? $dbConn->sanitize($_POST["content"]) : '';
    if ($_POST["action"] == "new" || $_POST["action"] == "edit") {
        // Send notifications to followers
        $followersStmt = $dbConn->db->prepare("SELECT id_follower FROM follow WHERE id_isfollow = :userId");
        $followersStmt->bindParam(':userId', $dbConn->loginStatus->userID);
        $followersStmt->execute();
        $followers = $followersStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($followers as $follower) {
            $notifStmt = $dbConn->db->prepare("INSERT INTO notification (texte, id_owner, post_id, date, lecture) VALUES (?, ?, ?, NOW(), 0)");
            $notifText = "A new post by someone you follow: {$title}";
            $notifStmt->execute([$notifText, $follower['id_follower'], $postID]);
            /*
                $notifyText = "Votre nouveau post est maintenant en ligne!";
                $insertNotification = $dbConn->db->prepare("INSERT INTO notification (texte, id_owner, post_id, date, lecture) VALUES (?, ?, ?, NOW(), 0)");
                $insertNotification->execute([$notifyText, $userId, $lastInsertID]);
            */
        }
    }

    header("Location: ./blog.php?id=" . urlencode($dbConn->loginStatus->userID));
    exit();
}
?>