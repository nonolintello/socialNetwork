<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('__ROOT__',dirname(__FILE__) ); 
define('DIR',"/WE");


require(__ROOT__."/classes/dbConn.php");

$dbConn = new dbConn();

?>
