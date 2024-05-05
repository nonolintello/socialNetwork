<?php
include("./ini.php");

if (isset($_SESSION['id']) && isset($_GET['follow_id'])) {
    $userId = $_SESSION['id'];
    $followId = $_GET['follow_id'];

    // 删除关注记录
    $stmt = $dbConn->db->prepare("DELETE FROM follow WHERE id_follower = ? AND id_isfollow = ?");
    $stmt->execute([$userId, $followId]);
    if ($stmt->rowCount() > 0) {
        echo "Se désabonner avec succès";
    } else {
        echo "l'opération a échoué";
    }
} else {
    echo "L'utilisateur n'est pas connecté ou les paramètres sont erronés";
}
?>
