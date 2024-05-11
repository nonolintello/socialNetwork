<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

$userId = $_SESSION['id'] ?? null;
if (!$userId) {
    header("Location: index.php");
    exit();
}
$dbConn->db->exec("DELETE FROM notification WHERE lecture = 1 AND date < DATE_SUB(NOW(), INTERVAL 2 WEEK)");

if (isset($_GET['markRead'])) {
    $notifId = $_GET['markRead'];
    $markReadStmt = $dbConn->db->prepare("UPDATE notification SET lecture = 1 WHERE id = ?");
    $markReadStmt->execute([$notifId]);
    echo "Notification marked as read";
    exit();
}
if (isset($_GET['delete'])) {
    $notifId = $_GET['delete'];
    $deleteStmt = $dbConn->db->prepare("DELETE FROM notification WHERE id = ?");
    $deleteStmt->execute([$notifId]);
    echo "Notification deleted";
    exit();
}
$countStmt = $dbConn->db->prepare("SELECT COUNT(*) FROM notification WHERE id_owner = ? AND lecture = 0");
$countStmt->execute([$userId]);
$unreadCount = $countStmt->fetchColumn();
?>
<div class="container">
    <h2 class="text-center"> Vos notifications </h2>
    <div id="notifications">
        <?php
        $stmt = $dbConn->db->prepare("SELECT n.*, p.texte AS post_text, p.id_owner FROM notification n LEFT JOIN post p ON n.post_id = p.id WHERE n.id_owner = ? ORDER BY n.date DESC");
        $stmt->execute([$userId]);
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($notifications as $notification) {
            $style = $notification['lecture'] ? "read" : "unread";
            echo "<div id='notif-{$notification['id']}' class='notification {$style}'>";
            echo "<p>{$notification['texte']}</p>"; 
            if (!empty($notification['post_text'])) {
                echo "<p>Contenu du post : <a href='blog.php?id={$notification['id_owner']}'>{$notification['post_text']}</a></p>";
            }
            echo "<button class='button mark-read' data-id='{$notification['id']}'>Marquer comme lu</button>";
            echo "<button class='button delete-notif' data-id='{$notification['id']}'>Supprimer</button>";
            echo "</div>";
        }
        ?>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.mark-read').click(function(e) {
            e.preventDefault();
            var notifId = $(this).data('id');
            $.get('?markRead=' + notifId, function(data) {
                $('#notif-' + notifId).removeClass('unread').addClass('read');
            }).fail(function(error) {
                console.error('Error:', error);
                alert('Failed to mark as read.');
            });
        });
        $('.delete-notif').click(function(e) {
            e.preventDefault();
            var notifId = $(this).data('id');
            if (confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')) {
                $.get('?delete=' + notifId, function(data) {
                    alert("Supprimé avec succès");
                    $('#notif-' + notifId).remove();
                }).fail(function(error) {
                    console.error('Error:', error);
                    alert('Failed to delete the notification.');
                });
            }
        });
    });
</script>