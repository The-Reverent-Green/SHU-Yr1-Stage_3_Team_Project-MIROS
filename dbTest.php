<?php //dbTest.php
include "db_config.php";
echo 'Testing: $dbConnection->query("CREATE DATABASE myDB");.';
try{
    $dbConnection->query("CREATE DATABASE myDB");
    echo "Database created successfully";
    $dbConnection->close();
}catch(Exception $e){
    echo "PDO ".$e->getMessage();
}
echo 'Testing: $query = file_get_contents("DDL.SQL");';
try{
    $query = file_get_contents("DDL.SQL");
    if (!$query) die("Failed to read SQL file");
    $mysqliConnection->multi_query($query);
    $mysqliConnection->close();
} catch(Exception $e){
    echo "MySQLi ".$e->getMessage();
}