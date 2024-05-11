<?php
include("./ini.php");

require_once(__ROOT__ . "/classes/imageUpload.php");
$ownerID = $_SESSION['id'];
$redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : './blog.php?id=' . urlencode($ownerID);
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


            $img = new ImgFileUploader($dbConn, false); 
            // echo $img->errorText;

            $img->OverrideOldFile($postID);
        }
    } elseif ($_POST["action"] == "new") {
        if (isset($_POST["title"]) && isset($_POST["content"])) {
            $title = $dbConn->sanitize($_POST["title"]);
            $content = $dbConn->sanitize($_POST["content"]);
            $parentID = isset($_POST["parentID"]) ? (int)$_POST["parentID"] : null;

            $stmt = $dbConn->db->prepare(
                "INSERT INTO `post` (`titre`, `texte`, `id_owner`, `id_parent`) 
                 VALUES (:title, :content, :ownerID, :parentID)"
            );

            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':ownerID', $ownerID);
            $stmt->bindParam(':parentID', $parentID);
            $stmt->execute();

            $lastInsertID = $dbConn->db->lastInsertId();
            $img = new ImgFileUploader($dbConn, false);
            //echo $img->errorText;

            $img->SaveFileAsNew($lastInsertID);
        }
    } elseif ($_POST["action"] == "delete") {
        if (isset($_POST["postID"])) {
            $postID = (int)$_POST["postID"];
            $img = new ImgFileUploader($dbConn, false);
            $img->DeleteFile($postID);
            $query = "DELETE FROM `post` WHERE `id` = :postID";
            $stmt = $dbConn->db->prepare($query);
            $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    elseif ($_POST["action"] == "reply") {
        $title = isset($_POST["title"]) ? $dbConn->sanitize($_POST["title"]) : '';
        $content = isset($_POST["content"]) ? $dbConn->sanitize($_POST["content"]) : '';
        $parentID = isset($_POST["parentID"]) ? (int)$_POST["parentID"] : null;

        $stmt = $dbConn->db->prepare(
            "INSERT INTO `post` (`titre`, `texte`, `id_owner`, `id_parent`) 
             VALUES (:title, :content, :ownerID, :parentID)"
        );

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':ownerID', $ownerID);
        $stmt->bindParam(':parentID', $parentID);

        if ($stmt->execute()) {
            // 获取原帖子所有者的ID
            $parentOwnerStmt = $dbConn->db->prepare("SELECT id_owner FROM post WHERE id = :parentID");
            $parentOwnerStmt->bindParam(':parentID', $parentID);
            $parentOwnerStmt->execute();
            $parentOwnerRow = $parentOwnerStmt->fetch(PDO::FETCH_ASSOC);
            $parentOwnerID = $parentOwnerRow['id_owner'];

            // 发送通知给原帖子所有者
            $notifText = "Nouvelles réponses à votre message :" . $title;
            $notifStmt = $dbConn->db->prepare("INSERT INTO notification (texte, id_owner, post_id, date, lecture) VALUES (?, ?, ?, NOW(), 0)");
            $notifStmt->execute([$notifText, $parentOwnerID, $parentID]);
            echo "Réponse ajoutée avec succès.";
        } else {
            echo "Erreur lors de l'ajout de la réponse.";
        }
        $redirect = 1;
    }

    elseif ($_POST["action"] == "warn") {
        if (isset($_POST["ownerID"], $_POST["postID"], $_POST["content"])) {
            $ownerID = (int)$_POST["ownerID"];
            $postID = (int)$_POST["postID"];  // 警告对应的帖子ID作为parentID
            $content = $dbConn->sanitize($_POST["content"]);
    
            $stmt = $dbConn->db->prepare(
                "INSERT INTO `post` (`titre`, `texte`, `id_owner`, `id_parent`) 
                 VALUES ('Avertissement !!!', :content, :ownerID, :postID)"
            );
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':ownerID', $ownerID);
            $stmt->bindParam(':postID', $postID);
            if ($stmt->execute()) {
                echo "Avertissement ajouté avec succès.";
                $lastInsertID = $dbConn->db->lastInsertId();

                // 发送通知给被警告的用户
                $notifText = "Avertir! ! !";
                $notifStmt = $dbConn->db->prepare("INSERT INTO notification (texte, id_owner, post_id, date, lecture) VALUES (?, ?, ?, NOW(), 0)");
                $notifStmt->execute([$notifText, $ownerID, $lastInsertID]);
            } else {
                echo "Erreur lors de l'ajout de l'avertissement.";
            }
        }
    }
    elseif ($_POST["action"] == "sensible") {
        if (isset($_POST["ownerID"], $_POST["postID"], $_POST["content"])) {
            $ownerID = (int)$_POST["ownerID"];
            $postID = (int)$_POST["postID"];
            $content = $dbConn->sanitize($_POST["content"]);
    
            $stmt = $dbConn->db->prepare(
                "INSERT INTO `post` (`titre`, `texte`, `id_owner`, `id_parent`) 
                 VALUES ('Sensible!!!', :content, :ownerID, :postID)"
            );
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':ownerID', $ownerID);
            $stmt->bindParam(':postID', $postID);
            if ($stmt->execute()) {
                echo "Marqué avec succès comme sensible.";
                $lastInsertID = $dbConn->db->lastInsertId();

                // 更新原帖子的sensible状态
                $updateQuery = "UPDATE `post` SET `sensible` = 1 WHERE `id` = :postID";
                $updateStmt = $dbConn->db->prepare($updateQuery);
                $updateStmt->bindParam(':postID', $postID);
                $updateStmt->execute();

                $notifText = "Sensible! ! !";
                $notifStmt = $dbConn->db->prepare("INSERT INTO notification (texte, id_owner, post_id, date, lecture) VALUES (?, ?, ?, NOW(), 0)");
                $notifStmt->execute([$notifText, $ownerID, $lastInsertID]);
            } else {
                echo "Marquer comme échec sensible.";
            }
        }
    }
    
    elseif ($_POST["action"] == "removed") {
        if (isset($_POST["ownerID"], $_POST["postID"], $_POST["content"])) {
            $ownerID = (int)$_POST["ownerID"];
            $postID = (int)$_POST["postID"];
            $content = $dbConn->sanitize($_POST["content"]);
    
            $stmt = $dbConn->db->prepare(
                "INSERT INTO `post` (`titre`, `texte`, `id_owner`, `id_parent`) 
                 VALUES ('Removed!!!', :content, :ownerID, :postID)"
            );
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':ownerID', $ownerID);
            $stmt->bindParam(':postID', $postID);
            if ($stmt->execute()) {
                echo "Le message a été supprimé par l'administrateur.";
                $lastInsertID = $dbConn->db->lastInsertId();

                // 更新原帖子的sensible状态
                $updateQuery = "UPDATE `post` SET `removed` = 1 WHERE `id` = :postID";
                $updateStmt = $dbConn->db->prepare($updateQuery);
                $updateStmt->bindParam(':postID', $postID);
                $updateStmt->execute();

                $notifText = "Removed!!!";
                $notifStmt = $dbConn->db->prepare("INSERT INTO notification (texte, id_owner, post_id, date, lecture) VALUES (?, ?, ?, NOW(), 0)");
                $notifStmt->execute([$notifText, $ownerID, $lastInsertID]);
            } else {
                echo "La suppression de ce message a échoué.";
            }
        }
    }

    

    $postID = isset($_POST["postID"]) ? (int)$_POST["postID"] : null;
    $title = isset($_POST["title"]) ? $dbConn->sanitize($_POST["title"]) : '';
    $content = isset($_POST["content"]) ? $dbConn->sanitize($_POST["content"]) : '';
    if ($_POST["action"] == "new" || $_POST["action"] == "edit" || $_POST["action"] == "reply") {
        // Send notifications to followers
        $followersStmt = $dbConn->db->prepare("SELECT id_follower FROM follow WHERE id_isfollow = :userId");
        $followersStmt->bindParam(':userId', $ownerID);
        $followersStmt->execute();
        $followers = $followersStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($followers as $follower) {
            $notifStmt = $dbConn->db->prepare("INSERT INTO notification (texte, id_owner, post_id, date, lecture) VALUES (?, ?, ?, NOW(), 0)");
            $notifText = "Nouveau post d'un de vos abonnement : {$title}";
            $notifStmt->execute([$notifText, $follower['id_follower'], $lastInsertID]);
        }
    }
    header("Location: " . htmlspecialchars($redirect_url));
    exit();
}
