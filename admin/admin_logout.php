<?php

require_once '../vendor/autoload.php';
$databaseConnection = new MongoDB\Client;
$myDatabase = $databaseConnection->mathsquiz; 
$adminCollection = $myDatabase->admin; 

session_start();
session_unset();
session_destroy();

header('location:admin_login.php');

?>
