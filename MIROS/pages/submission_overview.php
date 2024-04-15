<?php
require_once __DIR__ . '/../database/db_config.php';

// Start session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: login.php');
    exit;
}
function updateUnseenSubmissionsAsSeen(){
    global $pdo;
    try {
        $update_unseen_submissions_as_seen = $pdo->prepare("UPDATE submissions SET seen = 1 WHERE seen = 0 AND User_ID IN (SELECT User_ID FROM user WHERE Reports_To = :id)");
        $update_unseen_submissions_as_seen->bindValue(':id', $_SESSION['id']);
        $update_unseen_submissions_as_seen->execute();
    } catch (Exception $e) {
        echo 'error trying to update unseen submissions: ' . $e->getMessage();
    }
}
function fetchSubmissions() {
    global $pdo; // Ensure you use the PDO instance from the global scope
    
    if(!isset($_POST['search'])){
        $id = $_SESSION['id'];
        $stmt = $pdo->prepare("SELECT * FROM submissions INNER JOIN user on submissions.User_ID = user.User_ID WHERE Reports_To = :id AND Verified = 'no'");
        $stmt->bindValue(':id', $id);
    } else {
        $id = $_SESSION['id'];
        $search = $_POST['search'];
        $stmt = $pdo->prepare("SELECT * FROM submissions INNER JOIN user on submissions.User_ID = user.User_ID WHERE Reports_To = :id AND Verified = 'no' AND Description LIKE :search");
        $stmt->bindValue(':search', '%' . $search . '%');
        $stmt->bindValue(':id', $id);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

updateUnseenSubmissionsAsSeen();
$submissions = fetchSubmissions();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../includes/render_nav.js"></script>
    <script src="get_notifications.js"></script>
    <style>
        body { font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../includes/header.php'; ?>

    <nav id="navbar">Loading Navigation bar...</nav>
    <section class="vh-100">
        <div class="wrapper" style="margin-top: 20px">
            <form action="submission_overview.php" method="post">
                <label class="sub-title">Search for submissions: </label><br>
                <input type="text" id="search" name="search">
                <button class="button" type="submit" value="submit" name="submit">Search</button><br>
            </form>
        </div>
        <div class="wrapper">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Submission ID</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date of Submission</th>
                        <th scope="col">Evidence Attachment</th>
                        <th scope="col">Verified</th>
                        <th scope="col">Actions</th>
                        <th scope="col">&#160;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $submission): ?>
                        <tr>
                            <td><?= htmlspecialchars($submission['Submission_ID']); ?></td>
                            <td><?= htmlspecialchars($submission['User_ID']); ?></td>
                            <td><?= htmlspecialchars($submission['Description']); ?></td>
                            <td><?= htmlspecialchars($submission['Date_Of_Submission']); ?></td>
                            <td>
                                <?php if ($submission['Evidence_attachment']): ?>
                                    <a href="download_evidence.php?file=<?= urlencode($submission['Evidence_attachment']); ?>" class="btn btn-primary">Download Evidence</a>
                                <?php else: ?>
                                    No Attachment
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($submission['Verified']); ?></td>
                            <td><a href="submission_verification.php?Submission_ID=<?= htmlspecialchars($submission['Submission_ID']); ?>">Verify</a></td>
                            <td><a href="delete_submission.php?Submission_ID=<?= htmlspecialchars($submission['Submission_ID']); ?>">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
