<?php
include("./ini.php");

// 检查用户是否被封禁
function isBanned($userId) {
    global $dbConn;
    $stmt = $dbConn->db->prepare("SELECT banni FROM user WHERE id = ?");
    $stmt->execute([$userId]);
    $banDate = $stmt->fetchColumn();
    return $banDate && $banDate >= date('Y-m-d');
}

// 获取当前页面
$current_page = basename($_SERVER['PHP_SELF']);

// 如果用户已登录，检查封禁状态
if (isset($_SESSION['id']) && isBanned($_SESSION['id'])) {
    // 允许的页面列表
    $allowed_pages = ['blog.php', 'notifications.php'];

    // 检查当前页面是否在允许列表中
    if (!in_array($current_page, $allowed_pages)) {
        // 如果不在允许的页面列表中，重定向到个人页面
        header('Location: blog.php?id=' . urlencode($_SESSION['id']));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>YOUTBM</title>
    <link rel="icon" type="image/ico" href="<?php echo DIR; ?>/images/logo_utbm.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Style/style1.css">
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <a class="navbar-brand" href="<?php echo DIR; ?>/index.php">Accueil</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php
                    $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
                    $avatar = isset($_SESSION['avatar']) ? $_SESSION['avatar'] : null;

                    if (isset($_SESSION['id'])) {
                        echo '
                        <li class="nav-item"><a href="' . DIR . '/notifications.php" class="nav-link">Notifications</a></li>';
                        $userId = $_SESSION['id'];
                        $stmt = $dbConn->db->prepare("SELECT COUNT(*) FROM notification WHERE id_owner = ? AND lecture = 0");
                        $stmt->execute([$userId]);
                        $unreadCount = $stmt->fetchColumn();
                        if ($unreadCount > 0) {
                            echo ' <span class="badge bg-danger">' . $unreadCount . '</span>';
                        }
                        echo '</a></li>';
                        echo '<li class="nav-item"><a href="./discover.php" class="nav-link">Découvrir</a></li>
                        <li class="nav-item">
                            <form action="' . DIR . '/logout.php" method="post">
                                <input type="hidden" name="redirect_url" value="' . htmlspecialchars($_SERVER['REQUEST_URI']) . '"> 
                                <button type="submit" class="nav-link">Se déconnecter</button>
                            </form>
                        </li>
                        ';
                    } else {
                        echo ' <li class="nav-item"><a href="./newUser.php" class="nav-link">Nouveau compte</a></li>';
                    }

                    ?>
                </ul>
                <form class="d-flex ms-auto" action="./search.php" method="get">
                    <input class="form-control me-2" type="search" name="search" placeholder="Rechercher" aria-label="Rechercher">
                    <button class="btn btn-success" type="submit">Rechercher</button>
                </form>

                <?php if (!isset($_SESSION['id'])) : ?>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarLogin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Connexion
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarLogin">
                                <form class="px-4 py-3" action="./index.php" method="post">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Mot de passe</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">Se connecter</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                <?php endif; ?>

                <?php
                if ($dbConn->loginStatus->loginAttempted) {
                    $errorText = $dbConn->loginStatus->errorText;
                    echo "<script type='text/javascript'>alert('$errorText');</script>";
                }
                if ($avatar) {
                    echo '<a href="' . DIR . '/blog.php?id=' . urlencode($id) . '" class="nav-link">';
                    echo '<img src="' . htmlspecialchars($avatar) . '" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px;">';
                    echo '</a>';
                }
                ?>
        </nav>
    </div>