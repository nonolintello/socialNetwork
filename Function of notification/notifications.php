<?php
include("./ini.php");
include(__ROOT__. "/codePart/header.php"); 

$userId = $_SESSION['id'] ?? null;
if (!$userId) {
    header("Location: index.php"); // 未登录则跳转到登录页面
    exit();
}


// 删除超过两周的已读通知
$dbConn->db->exec("DELETE FROM notification WHERE lecture = 1 AND date < DATE_SUB(NOW(), INTERVAL 2 WEEK)");

// 处理标记为已读的请求
if (isset($_GET['markRead'])) {
    $notifId = $_GET['markRead'];
    $markReadStmt = $dbConn->db->prepare("UPDATE notification SET lecture = 1 WHERE id = ?");
    $markReadStmt->execute([$notifId]);
    exit("Notification marked as read");
}
// 处理删除请求
if (isset($_GET['delete'])) {
    $notifId = $_GET['delete'];
    $deleteStmt = $dbConn->db->prepare("DELETE FROM notification WHERE id = ?");
    $deleteStmt->execute([$notifId]);
    exit("Notification deleted");
}

// 获取未读通知数量
$countStmt = $dbConn->db->prepare("SELECT COUNT(*) FROM notification WHERE id_owner = ? AND lecture = 0");
$countStmt->execute([$userId]);
$unreadCount = $countStmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de notification</title>
    <style>
        .unread {
            font-weight: bold;
            color: red;
        }
        .read {
            font-weight: normal;
            color: black;
        }
        .notification {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .button {
            display: inline-block;
            padding: 5px 10px;
            margin: 5px;
            background-color: #f8f8f8;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-decoration: none;
            color: black;
            cursor: pointer;
        }
        .button:hover {
            background-color: #e8e8e8;
        }
        .notification {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #f9f9f9;
        }
        .notification.unread {
            background: #e8f0fe;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        //readed
        $('.mark-read').click(function(e){
            e.preventDefault();
            var notifId = $(this).data('id');
            $.get('notification.php?markRead=' + notifId, function(){
                $('#notif-' + notifId).removeClass('unread').addClass('read');
                alert(data);
            });
        });

        //delete
        $('.delete-notif').click(function(e){
            e.preventDefault();
            var notifId = $(this).data('id');
            if(confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')) {
                $.get('?delete=' + notifId, function(data){
                    alert(response);
                    $('#notif-' + notifId).remove(); // 删除元素
                });
            }
        });
    });
    </script>
</head>
<body>
    <h1>votre notification</h1>
    <div id="notifications">
        <?php
        // 获取所有通知
        $stmt = $dbConn->db->prepare("SELECT n.*, p.texte AS post_text FROM notification n LEFT JOIN post p ON n.post_id = p.id WHERE n.id_owner = ? ORDER BY n.date DESC");
        $stmt->execute([$userId]);
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($notifications as $notification) {
            $style = $notification['lecture'] ? "read" : "unread";
            echo "<div id='notif-{$notification['id']}' class='notification {$style}'>";
            echo "<p>{$notification['texte']}</p>";
            if ($notification['post_text']) {
                echo "<p>Articles Similaires: {$notification['post_text']}</p>"; // 显示关联帖子的文本
            }
            echo "<button class='button mark-read' data-id='{$notification['id']}'>Marquer comme lu</button>";
            echo "<button class='button delete-notif' data-id='{$notification['id']}'>Delete</button>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>



