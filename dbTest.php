<?php //dbTest.php
include "db_config.php";

try{
    $dbConnection->query("CREATE DATABASE myDB");
    echo "Database created successfully";
    $dbConnection->close();
}catch(Exception $e){
    echo "PDO ".$e->getMessage();
}

try{
    $query = file_get_contents("DDL.SQL");
    if (!$query) die("Failed to read SQL file");
    $mysqliConnection->multi_query($query);
    $mysqliConnection->close();
} catch(Exception $e){
    echo "MySQLi ".$e->getMessage();
}