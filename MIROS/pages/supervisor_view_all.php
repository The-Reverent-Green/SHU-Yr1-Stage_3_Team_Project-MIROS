<?php 
require_once __DIR__ . '/../database/db_config.php';
require_once __DIR__ . '/../includes/header.php';

// Function to retrieve submissions
function getSubmissions($supervisorId, $filterUserId = null) {
    global $mysqli;  // Ensure $mysqli is the correct database connection variable from db_config.php
    
    $sql = "SELECT submissions.Submission_ID, submissions.User_ID, submissions.Description, user.First_Name, user.Last_Name 
            FROM submissions
            INNER JOIN user ON submissions.User_ID = user.User_ID
            WHERE user.Reports_To = ?";
    
    if ($filterUserId) {
        $sql .= " AND submissions.User_ID = ?";
    }

    if ($filterUserId) {
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ii", $supervisorId, $filterUserId);
    } else {
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $supervisorId);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $submissions = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    return $submissions;
}




$supervisorId = $_SESSION['id']; // Assumes supervisor ID is stored in session
$filterUserId = $_GET['filter_user_id'] ?? null; // Get filter from query parameter
$submissions = getSubmissions($supervisorId, $filterUserId);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supervisor Team Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../includes/render_nav.js"></script>
    <style>
        body { font: 14px sans-serif; text-align: center; }
        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <nav id="navbar">Loading Navigation bar...</nav>

    <div class="container mt-4 mb-4">
        <h2 class="mb-3">Officer Submissions</h2>
        <div class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <form method="get" action="" class="row g-3 align-items-center">
                    <div class="col-auto">
                        <input type="text" class="form-control" placeholder="Filter by User ID" name="filter_user_id" aria-label="Filter by User ID">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Submission ID</th>
                        <th scope="col">Officer ID</th>
                        <th scope="col">Officer Name</th>
                        <th scope="col">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $submission): ?>
                    <tr>
                        <td><?= htmlspecialchars($submission['Submission_ID']); ?></td>
                        <td><?= htmlspecialchars($submission['User_ID']); ?></td>
                        <td><?= htmlspecialchars($submission['First_Name'] . ' ' . $submission['Last_Name']); ?></td>
                        <td><?= htmlspecialchars($submission['Description']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
