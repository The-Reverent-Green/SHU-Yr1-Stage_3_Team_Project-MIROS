<?php // connection.php

try{
    $dbConnection = new PDO('mysql:host=localhost; dbname=; charset=utf8', 'root', '');
    //var_dump($dbConnection);
    echo '$dbConnection is running.<br>';
}
catch(Exception $e){
    //echo $e->getMessage();
    echo 'An error has occurred:';
}
