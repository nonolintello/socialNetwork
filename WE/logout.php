<?php

include("./ini.php");

session_destroy();
session_unset(); 

$dbConn->disconnect();
header("Location: index.php");
exit();