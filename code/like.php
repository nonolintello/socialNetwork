<?php
include("./ini.php");

if (isset($_POST['post_id']) && isset($_POST['action'])) {
    $postId = (int)$_POST['post_id'];
    $userId = $_SESSION['id'];
    $action = $_POST['action'];

    if ($action === 'like') {
        $query = "INSERT INTO jaime (id_user, id_post) 
                  SELECT :userId, :postId 
                  WHERE NOT EXISTS 
                  (SELECT 1 FROM jaime WHERE id_user = :userId AND id_post = :postId)";
    } elseif ($action === 'unlike') {
        $query = "DELETE FROM jaime WHERE id_user = :userId AND id_post = :postId";
    }

    $stmt = $dbConn->db->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
    $stmt->execute();

    $query = "SELECT COUNT(*) AS like_count FROM jaime WHERE id_post = :postId";
    $stmt = $dbConn->db->prepare($query);
    $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'like_count' => $result['like_count']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide']);
}
?>
