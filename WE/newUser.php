<?php


include("./ini.php");
include(__ROOT__. "/codePart/header.php");
$newUserStatus = $dbConn->handleAccountCreation();

?>

<h1>Création d'un nouveau compte</h1>
<?php
include(__ROOT__ ."/codePart/newUserForm.php");

if ($newUserStatus[1]) {
    echo 'New user crée';
    header("Location: ./index.php");
} elseif ($newUserStatus[0]) {
    echo 'Erreur création user: . $newUserStatus[2]';
}


include(__ROOT__ ."/codePart/footer.php");
?>

