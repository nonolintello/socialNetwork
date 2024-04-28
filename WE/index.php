<?php
include("./ini.php");
include(__ROOT__. "/codePart/header.php");
if ($dbConn->loginStatus->loginAttempted){
    echo '<br><br><h3 class="errorMessage">'.$dbConn->loginStatus->errorText.'</h3><br><br><br>';
}
include(__ROOT__."/codePart/loginForm.php");
?>

<p><a href="./newUser.php" class="endlink">Créer un nouveau compte </a><br><br></p>

<?php 
include(__ROOT__ ."/codePart/footer.php");
$dbConn->disconnect();
?>