<?php

$servername = "localhost";
$username = "your_username";
$password = "";

try {
    $pdoConnection = new PDO("mysql:host=$servername;charset=utf8", $username, $password);  // Connect to MySQL server without specifying a database
    $pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                // Tells PDO to throw exceptions instead of just reporting errors silently.

    $pdoConnection->exec("CREATE DATABASE IF NOT EXISTS MIROS_performance_tracker_schema"); // create db
    $pdoConnection->exec("USE MIROS_performance_tracker_schema");                           // Select the newly created db
    
    $file_contents = file_get_contents("/Applications/XAMPP/xamppfiles/htdocs/Stage_3/Stage_3_Team_Project/MIROS/dbConfig/DDL.SQL");
    if (!$file_contents) throw new Exception("Failed to load the SQL file.");

    $separatedStatements = explode(";\n", $file_contents);                                  // reads $file_contents and separates the statements
    foreach ($separatedStatements as $statement) {
                                                                                            /*  For each statement trim whitespace, and if not empty execute the sql statment.
                                                                                            In this context this for loop should create the db tables*/
        $statement = trim($statement);
        if (!empty($statement)) {
            $pdoConnection->exec($statement);
        }
    }
    echo "Database created successfully.<br>";
} catch (Exception $e) {
    echo "An error has occurred: " . $e->getMessage();
    $failed = true;
}


