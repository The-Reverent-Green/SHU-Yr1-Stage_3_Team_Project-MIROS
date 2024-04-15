<?php
//search_for_all_submissions.php
function debug() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
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

function submissions($pdo) {
    $stmt = $pdo->prepare("SELECT Description, Date_Of_Submission, Verified, Evidence_attachment FROM submissions WHERE Description LIKE :search");
    $stmt->bindValue(':search', '%' . $_GET['searchTerm'] . '%');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['searchTerm'])) {
    header('Content-Type: application/json');  // Set Content-Type to application/json
    echo json_encode(submissions($pdo));       // Echo the JSON encoded data
}
?>
