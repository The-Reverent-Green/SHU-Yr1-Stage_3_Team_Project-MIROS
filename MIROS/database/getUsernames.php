<?php // getUsernames.php

require_once __DIR__ . '/../database/db_config.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['searchTerm'])){
    $searchTerm = $_GET['searchTerm'] . '%';
    $stmt = $mysqli->prepare("SELECT username FROM user WHERE username LIKE ?");
    $stmt->bind_param('s', $searchTerm);
    $stmt->execute();
    $stmt->bind_result($username);
    
    $usernames = [];
    
    while ($stmt->fetch()) {
        $usernames[] = $username;
    }
    $stmt->close();
    
    header('Content-Type: application/json');
    echo json_encode($usernames);
}