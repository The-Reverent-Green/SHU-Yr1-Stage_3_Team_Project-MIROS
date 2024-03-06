<?php  // db_config.php

$servername = "localhost";
$username = "your_username"; 
$password = ""; 
$database = "databasename"; 
//configure above with database name and password etc

try{
    $dbConnection = new PDO("mysql:host=$servername; dbname=$database; charset=utf8", 
    $username, 
    $password);
    //var_dump($dbConnection);
    echo '$Connection Successful.<br>';
}catch(Exception $e){
    //echo $e->getMessage();
    echo 'An error has occurred:';
}