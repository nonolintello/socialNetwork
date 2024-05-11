<?php
include("./ini.php");

if ($dbConn->loginStatus->loginSuccessful) {
    header("Location: timeline.php");
    exit();
}

include(__ROOT__ . "/codePart/header.php");

if (isset($_SESSION['id'])) {
    header("Location: timeline.php");
    exit();
} else {
    header("Location: discover.php");
    exit();
}


include(__ROOT__ . "/codePart/footer.php");
