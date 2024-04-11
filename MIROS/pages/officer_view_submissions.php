<?php
session_start();
require_once __DIR__ . '/../database/db_config.php';

// Check if the user is logged in, and there's a user id in the session
if (!isset($_SESSION['id'])) {
    echo "Please log in to view your submissions.";
    exit; // or redirect to login page
}

$userId = $_SESSION['id'];

// Fetch submissions from the database
try {
    $stmt = $pdo->prepare("SELECT * FROM submissions WHERE User_ID = :userId");
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching submissions: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Submissions</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php   
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav_bar.php'; 
?>
<div class="wrapper">
    <h1>Your Submissions</h1>
    <?php if (empty($submissions)): ?>
        <p>You have no submissions.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Date of Submission</th>
                    <th>Verified Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submissions as $submission): ?>
                    <tr>
                        <td><?= htmlspecialchars($submission['Description']); ?></td>
                        <td><?= htmlspecialchars($submission['Date_Of_Submission']); ?></td>
                        <td><?= htmlspecialchars($submission['Verified']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
