<?php  // db_config.php

$servername = "localhost";
$database = "databasename"; 
$username = "your_username"; 
$password = ""; 
//configure above with database name and password etc

try{//                              PLEASE USE $pdoConnection FOR ALL DB CONNECTIONS
    $pdoConnection = new PDO("mysql:host=$servername; dbname=$database; charset=utf8", 
    $username, 
    $password);
    //var_dump($dbConnection);
    echo '$Connection Successful.<br>';
}catch(Exception $e){
    //echo $e->getMessage();
    echo 'An error has occurred:';
}

try{//                              PLEASE DON'T USE $mysqliConnection UNLESS ABSOLUTELY NECESSARY
    $mysqliConnection = new mysqli($servername, $username, $password, $dbname);
}catch(Exception $e){
    //echo $e->getMessage();
    echo 'An error has occurred:';
}
