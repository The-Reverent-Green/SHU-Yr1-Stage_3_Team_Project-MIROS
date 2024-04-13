<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../database/db_config.php';



if (!isset($_SESSION['id'])) {
    echo "Please log in to view your submissions.";
    exit; 
}

$userId = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    try {
        $deleteStmt = $pdo->prepare("DELETE FROM submissions WHERE Submission_ID = :deleteId AND User_ID = :userId");
        $deleteStmt->bindParam(':deleteId', $deleteId, PDO::PARAM_INT);
        $deleteStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $deleteStmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        echo "Error deleting submission: " . $e->getMessage();
    }
}



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
    <script src="../includes/render_nav.js"></script>
</head>
<body>
    
<?php require_once __DIR__ . '/../includes/header.php';?>
<nav id="navbar">Loading Navigation bar...</nav>
<?php if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']); // Clear the message so it doesn't reappear on refresh
}
?>
<section class="vh-100">
    <div class="wrapper">
        <br>
        <h1>Your Submissions</h1>
        <?php if (empty($submissions)): ?>
            <p>You have no submissions.</p>
        <?php else: ?>
            <table class="table table-striped table-hover">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Description</th>
            <th scope="col">Date of Submission</th>
            <th scope="col">Verified Status</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($submissions as $submission): ?>
            <tr>
                <td><?= htmlspecialchars($submission['Description']); ?></td>
                <td><?= htmlspecialchars($submission['Date_Of_Submission']); ?></td>
                <td><?= htmlspecialchars($submission['Verified']); ?></td>
                <td>
    <?php if (isset($submission['Submission_ID'])): ?>
        <form action="edit_submission.php" method="GET" style="display: inline;">
            <input type="hidden" name="edit_id" value="<?= htmlspecialchars($submission['Submission_ID']); ?>">
            <button type="submit" class="btn btn-primary btn-sm">Edit</button>
        </form>
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this submission?');" style="display: inline;">
            <input type="hidden" name="delete_id" value="<?= htmlspecialchars($submission['Submission_ID']); ?>">
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
    <?php else: ?>
        <span>Error: Submission ID missing</span>
    <?php endif; ?>
</td>

                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        <?php endif; ?>
    </div>
</section>
</body>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>
