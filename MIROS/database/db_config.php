<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$dbname = "miros";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // other attributes and settings as needed
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}


// Establish a new connection to the database
$mysqli = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    // Consider logging this error and then displaying a generic error message to the user
    error_log("Connection failed: " . $mysqli->connect_error);
    // Display a user-friendly message
    echo "Sorry, we're experiencing some technical difficulties. Please try again later.";
    exit; // Stop script execution if connection fails
}
