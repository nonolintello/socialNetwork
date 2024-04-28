<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>YOUTBM</title>
    <link rel="icon" type="image/ico" href="images/logo_utbm.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Style/loginForm.css">
</head>
<body> 

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">

                        <?php
                        echo '
                        <li class="nav-item"><a href="' . DIR . '/discover.php" class="nav-link active">Découvrir</a></li>
                        <li class="nav-item"><a href="' . DIR . '/myBlog.php" class="nav-link">Ma Page</a></li>
                        <li class="nav-item"><a href="' . DIR . '/index.php" class="nav-link">Accueil</a></li>
                        <li class="nav-item"><a href="' . DIR . '/notifications.php" class="nav-link">Notifications</a></li>
                        <li class="nav-item"><a href="' . DIR . '/post.php" class="nav-link">Post</a></li>
                        ';
                        ?>
                    </ul>
                </div>
            </nav>


            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
