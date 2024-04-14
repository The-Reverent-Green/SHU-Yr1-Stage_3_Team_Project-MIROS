<?php
// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in, if not redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Redirect user to login page
    header("location: login.php");
    exit;
}

require_once __DIR__ . '/../database/db_config.php';

// Using $_SESSION['id'] since the login script uses 'id' to store the user ID
$loggedInSupervisorId = $_SESSION['id'];

$sql = "SELECT s.* FROM submissions s
        JOIN user u ON s.User_ID = u.User_ID
        WHERE u.Reports_To = ?";

// Prepare and bind
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $loggedInSupervisorId, PDO::PARAM_INT);

// Execute the query
$stmt->execute();

// Fetch all rows
$submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get a list of User IDs for the filter dropdown
$filterSql = "SELECT User_ID, Username FROM user WHERE Reports_To = ?";
$filterStmt = $pdo->prepare($filterSql);
$filterStmt->bindParam(1, $loggedInSupervisorId, PDO::PARAM_INT);
$filterStmt->execute();
$userIds = $filterStmt->fetchAll(PDO::FETCH_ASSOC);

// Check if a user ID has been selected from the dropdown
$selectedUserId = $_GET['user_id'] ?? null;
if ($selectedUserId) {
    // Adjust the SQL query to filter by the selected User ID
    $sql .= " AND s.User_ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $loggedInSupervisorId, PDO::PARAM_INT);
    $stmt->bindParam(2, $selectedUserId, PDO::PARAM_INT);
} else {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $loggedInSupervisorId, PDO::PARAM_INT);
}

$stmt->execute();
$submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Officer Submissions</title>
    <!-- Add link to CSS stylesheet if needed -->
</head>
<body>

<div id="filter-container">
    <form action="" method="get">
        <label for="user-filter">Filter by Officer:</label>
        <select name="user_id" id="user-filter" onchange="this.form.submit()">
            <option value="">Select an Officer</option>
            <?php foreach ($userIds as $user): ?>
                <option value="<?= htmlspecialchars($user['User_ID']) ?>" <?= $selectedUserId == $user['User_ID'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($user['Username']) ?> (ID: <?= htmlspecialchars($user['User_ID']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<div id="submissions-container">
    <h2>Submissions by Officers</h2>
    <?php if (!empty($submissions)): ?>
        <table>
            <thead>
                <tr>
                    <th>Submission ID</th>
                    <th>User ID</th>
                    <th>Category ID</th>
                    <th>Item ID</th>
                    <th>Sub Item ID</th>
                    <th>Description</th>
                    <th>Date of Submission</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submissions as $submission): ?>
                    <tr>
                        <td><?= htmlspecialchars($submission['Submission_ID']) ?></td>
                        <td><?= htmlspecialchars($submission['User_ID']) ?></td>
                        <td><?= htmlspecialchars($submission['Category_ID']) ?></td>
                        <td><?= htmlspecialchars($submission['Item_ID']) ?></td>
                        <td><?= htmlspecialchars($submission['Sub_Item_ID']) ?></td>
                        <td><?= htmlspecialchars($submission['Description']) ?></td>
                        <td><?= htmlspecialchars($submission['Date_Of_Submission']) ?></td>
                        <!-- Add more data cells as needed -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No submissions found.</p>
    <?php endif; ?>
</div>

</body>
</html>
