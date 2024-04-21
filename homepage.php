<?php
session_start(); // Start the session at the very beginning

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Database connection setup
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'projet';
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch user information
$stmt = $mysqli->prepare('SELECT url_avatar, nom, prenom, admin FROM user WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No user found. Please check the session and database setup.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="./Styles/homepage_style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><a href="homepage.php">Homepage</a></li>
            <li><a href="explore.php">Explore</a></li>
            <li><a href="notifications.php">Notifications</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="follows.php">Follows</a></li>
            <li><a href="bookmarks.php">Bookmarks</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="more.php">More</a></li>
        </ul>
    </div>
    <div class="content">
        <?php if (isset($_GET['error'])): ?>
            <div class="error"><?= htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <div class="user-info">
            <img src="<?= $user['url_avatar'] ?>" alt="Avatar">
            <h3><?= htmlspecialchars($user['nom']) . ' ' . htmlspecialchars($user['prenom']) ?></h3>
            <p><?= $user['admin'] ? 'Administrator' : 'User' ?></p>
        </div>
        <div class="post-creation">
            <?php if (isset($_GET['error'])): ?>
                <div class="error"><?= htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>
            <form action="post_submit.php" method="post" enctype="multipart/form-data">
                <textarea name="post_text" placeholder="What's on your mind?" required></textarea>
                <input type="file" name="post_image">
                <input type="submit" name="submit_post" value="Post">
            </form>
        </div>
        <div class="post-history">
            <?php
            $stmt = $mysqli->prepare('SELECT texte, url_image, date FROM post WHERE id_owner = ? ORDER BY date DESC');
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($post = $result->fetch_assoc()) {
                echo '<div class="post">';
                if ($post['url_image']) {
                    echo '<img src="'.$post['url_image'].'" alt="Post Image">';
                }
                echo '<p>'.htmlspecialchars($post['texte']).'</p>';
                echo '<span>'.date('F j, Y, g:i a', strtotime($post['date'])).'</span>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>

