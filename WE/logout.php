<?php

include("./ini.php");

session_unset();
session_destroy();

$redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : 'index.php';

$dbConn->disconnect();
header("Location: $redirect_url");
exit();

?>
