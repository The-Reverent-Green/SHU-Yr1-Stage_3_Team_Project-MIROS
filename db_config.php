<?php
$servername = "localhost";
$username = "your_username"; 
$password = ""; 
$database = "databasename"; 
//configure above with database name and password etc

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to $database successfully"; 
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
