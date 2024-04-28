<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>YOUTBM</title>

    <link rel="icon" type="image/ico" href= "images/logo_utbm.ico"; >
</head>
<body> 

    <div class="header">
    <?php
    echo '
        <nav>
            <ul>
                <li><a href="' . DIR . '/discover.php">Découvrir</a></li>
                <li><a href="' . DIR . '/myBlog.php">Ma Page</a></li>
                <li><a href="' . DIR . '/index.php">Accueil</a></li>
                <li><a href="' . DIR . '/notifications.php">Notifications</a></li>
                <li><button onclick="window.location.href=\'' . DIR . '/post.php\'">Post</button></li>
            </ul>
        </nav>';
    ?>

    </div>