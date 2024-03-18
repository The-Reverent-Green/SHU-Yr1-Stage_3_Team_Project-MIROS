<?php  // connect_MIROS_Performance_Tracker.php

$servername = "root";
$database = "miros"; 
$username = "your_username"; 
$password = ""; 
//configure above with database name and password etc

try{//                  PLEASE USE $pdoConnection FOR ALL DB CONNECTIONS
    $pdoConnection = new PDO("mysql:host=$servername; dbname=$database; charset=utf8", 
    $username, 
    $password);
    var_dump($dbConnection);
    echo '$Connection Successful.<br>';
}catch(Exception $e){
    echo $e->getMessage();//comment out before submission
    //echo 'An error has occurred:';
}