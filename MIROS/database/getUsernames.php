<?php // getUsernames.php

require_once 'db_config.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['searchTerm'])){
    // Use the search term from the query parameters
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
    
    // Set the content-type to application/json
    header('Content-Type: application/json');
    // Encode and return the usernames as a JSON array
    echo json_encode($usernames);
}