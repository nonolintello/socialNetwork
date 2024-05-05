<?php
include("./ini.php");

if ($dbConn->loginStatus->loginSuccessful) {
    header("Location: timeline.php");
    //header("Refresh: 3; url=./blog.php?id=" . $dbConn->loginStatus->userID);
}

include(__ROOT__ . "/codePart/header.php");



if (isset($_SESSION['id'])) {
} else {
    if ($dbConn->loginStatus->loginAttempted) {
        echo '<br><br><h3 class="errorMessage">' . $dbConn->loginStatus->errorText . '</h3><br><br><br>';
        header("Refresh: 3; url=./discover.php");
    }
    header("Location: discover.php");
}

include(__ROOT__ . "/codePart/footer.php");
