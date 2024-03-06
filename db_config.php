<?php
$servername = "localhost"; // or your MySQL server address
$username = "your_username"; // your MySQL username
$password = "your_password"; // your MySQL password
$database = "databasename"; // your MySQL database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

//configure above with database name and password etc