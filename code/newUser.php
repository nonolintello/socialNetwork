<?php
include("./ini.php");
include(__ROOT__ . "/codePart/header.php");

$newUserStatus = $dbConn->handleAccountCreation();
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="mb-4">Création d'un nouveau compte</h1>

            <?php
            if ($newUserStatus[1]) {
                echo '<div class="alert alert-success">Nouveau compte créé avec succès. Redirection vers votre page '.  $dbConn->loginStatus->userName .'...</div>';
                header("Refresh: 3; url=./blog.php?id=" . $_SESSION['id']);
            } elseif ($newUserStatus[0]) {
                echo '<div class="alert alert-danger">Erreur de création de compte : ' . htmlspecialchars($newUserStatus[2]) . '</div>';
            }
            include(__ROOT__ . "/codePart/newUserForm.php");
            ?>
        </div>
    </div>
</div>

<?php
include(__ROOT__ . "/codePart/footer.php");
?>
