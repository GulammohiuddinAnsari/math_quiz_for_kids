<?php

require_once '../vendor/autoload.php'; 

$databaseConnection = new MongoDB\Client;  

$myDatabase = $databaseConnection->mathsquiz; 

$adminCollection = $myDatabase->admin; 
$messageCollection = $myDatabase->feedback;
$userCollection = $myDatabase->users;
$questionsCollection = $myDatabase->questions;

?>
