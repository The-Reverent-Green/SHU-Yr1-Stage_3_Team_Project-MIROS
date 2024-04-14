<?php
require_once __DIR__ . '/../database/db_config.php';

// Start session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in, if not then exit
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    exit('You are not authorized to view this page.');
}

$file = basename(urldecode($_GET['file']));
// Adjust the path to point to the correct directory
$filePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $file;

// Debugging output
echo "Debugging - File path: $filePath<br>";
if (file_exists($filePath)) {
    echo "File exists<br>";
} else {
    echo "File does not exist<br>";
}

// Check if file exists and is readable
if (file_exists($filePath) && is_readable($filePath)) {
    // Set headers for download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath));
    flush(); // Flush system output buffer
    readfile($filePath);
    exit;
} else {
    exit('Requested file does not exist.');
}
?>
