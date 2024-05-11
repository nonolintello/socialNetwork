<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__));
}


if (!defined('DIR')) {
    define('DIR', "/code");
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__ROOT__ . "/classes/dbConn.php");
$dbConn = new dbConn();
