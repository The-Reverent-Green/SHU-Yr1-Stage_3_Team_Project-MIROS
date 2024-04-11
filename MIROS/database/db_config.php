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
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}


$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    error_log("Connection failed: " . $mysqli->connect_error);
    echo "Sorry, we're experiencing some technical difficulties. Please try again later.";
    exit; 
    
}