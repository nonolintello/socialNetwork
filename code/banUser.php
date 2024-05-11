<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];
    $banDate = $_POST['banDate'];
    $banReason = $_POST['banReason'];

    // 封禁用户
    $query = "UPDATE user SET banni = :banDate WHERE id = :userID";
    $stmt = $dbConn->db->prepare($query);
    $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':banDate', $banDate, PDO::PARAM_STR);
    if ($stmt->execute()) {
        // 创建封禁通知帖子，但不更改管理员会话
        $postTitle = "Banni!!!";
        $postContent = $banReason . " Date d'expiration: " . $banDate;
        $stmt = $dbConn->db->prepare(
            "INSERT INTO `post` (`titre`, `texte`, `id_owner`, `id_parent`) VALUES (:title, :content, :ownerID, NULL)"
        );
        $stmt->bindParam(':title', $postTitle);
        $stmt->bindParam(':content', $postContent);
        $stmt->bindParam(':ownerID', $userId);
        $stmt->execute();

        echo "<p style='color: #28a745; background-color: #dff0d8; border-color: #d4edda; padding: 10px; border-radius: 5px; margin: 20px 0;'>L'utilisateur a été banni avec succès et une notification de bannissement a été émise.</p>";

    } else {
        echo "<p style='color: #dc3545; background-color: #f8d7da; border-color: #f5c6cb; padding: 10px; border-radius: 5px; margin: 20px 0;'>L'interdiction a échoué, veuillez réessayer.</p>";

    }
}

include(__ROOT__ . "/codePart/footer.php");
?>
