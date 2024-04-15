<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); 

require_once __DIR__ . '/../database/db_config.php';

if (!isset($_SESSION['id'])) {
    echo "Please log in to view this page.";
    exit; 
}

$submission = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['edit_id'])) {
    $editId = $_GET['edit_id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM submissions WHERE Submission_ID = :editId AND User_ID = :userId");
        $stmt->bindParam(':editId', $editId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
        $submission = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$submission) {
            echo "No submission found or you do not have permission to edit this submission.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error fetching submission: " . $e->getMessage();
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submission_id'], $_POST['description'])) {
    $submissionId = $_POST['submission_id'];
    $description = $_POST['description'];  

    try {
        $updateStmt = $pdo->prepare("UPDATE submissions SET Description = :description WHERE Submission_ID = :submissionId AND User_ID = :userId");
        $updateStmt->bindParam(':description', $description, PDO::PARAM_STR);
        $updateStmt->bindParam(':submissionId', $submissionId, PDO::PARAM_INT);
        $updateStmt->bindParam(':userId', $_SESSION['id'], PDO::PARAM_INT);
        $updateStmt->execute();

        $_SESSION['message'] = "Submission updated successfully!";

        header("Location: officer_view_submissions.php");  
        exit();
    } catch (PDOException $e) {
        echo "Error updating submission: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Submissions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/nav_bar.css">
    <script src="get_notifications.js"></script>
    <script src="../includes/render_nav.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font: 14px sans-serif; text-align: center; }
        .wrapper { margin-top: 40px; }
        .newsletter { margin-top: 20px; }
        .my-5 { margin-top: 3rem!important; margin-bottom: 3rem!important; }
    </style>
</head>
<body>
<?php require_once __DIR__ . '/../includes/header.php';?>
<nav id="navbar">Loading Navigation bar...</nav>
<body>
<?php require_once __DIR__ . '/../includes/header.php'; ?>
<section class="wrapper">
    <?php if ($submission): ?>
    <h2>Edit Submission</h2>
    <form action="edit_submission.php" method="POST">
        <input type="hidden" name="submission_id" value="<?= htmlspecialchars($submission['Submission_ID']) ?>">
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($submission['Description']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Changes</button>
    </form>
    <?php else: ?>
    <p>Submission not found or not accessible.</p>
    <?php endif; ?>
</section>
<?php require("Script.php")?>
</body>
</html>
