<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>YOUTBM</title>
    <link rel="icon" type="image/ico" href="images/logo_utbm.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Style/footer.css">
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top"> <!-- Navbar fixée en haut -->
            <a class="navbar-brand" href="<?php echo DIR; ?>/index.php">Accueil</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    
                    <li class="nav-item"><a href="./newUser.php" class="nav-link">Nouveau compte</a></li>
                   
                    <?php
                    $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
                    $avatar = isset($_SESSION['avatar']) ? $_SESSION['avatar'] : null;

                    if (isset($_SESSION['id'])) {
                        echo '
                    <li class="nav-item"><a href="' . DIR . '/notifications.php" class="nav-link">Notifications</a></li>
                    <li class="nav-item">
                    <li class="nav-item"><a href="./discover.php" class="nav-link">Découvrir</a></li>
                        <form action="' . DIR . '/logout.php" method="post">
                            <button type="submit" class="nav-link">Se déconnecter</button>
                        </form>
                    </li>
                    ';
                    }
                    ?>
                </ul>
                <form class="d-flex ms-auto" action="./search.php" method="get"> <!-- Champ de recherche -->
                    <input class="form-control me-2" type="search" placeholder="Rechercher" aria-label="Rechercher">
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
                if ($avatar) {
                    echo '<a href="' . DIR . '/blog.php?id=' . urlencode($id) . '" class="nav-link">';
                    echo '<img src="' . htmlspecialchars($avatar) . '" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px;">';
                    echo '</a>';
                }
                ?>



        </nav>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>