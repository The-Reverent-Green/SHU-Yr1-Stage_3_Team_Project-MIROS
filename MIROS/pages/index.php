<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../database/db_config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /path/to/login.php');
    exit;
}

$loggedInUserId = $_SESSION['id'] ?? null;
$userScores = [];
$reportsToData = [];

if ($loggedInUserId) {
    $sqlScores = "SELECT * FROM user_scores WHERE User_ID = ?";
    
    if ($stmt = $mysqli->prepare($sqlScores)) {
        $stmt->bind_param("i", $loggedInUserId);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $userScores = $result->fetch_assoc();
        } else {
            error_log("Error executing user scores statement: " . $stmt->error, 3, "/path/to/your/error.log");
        }
        $stmt->close();
    } else {
        error_log("Error preparing user scores statement: " . $mysqli->error, 3, "/path/to/your/error.log");
    }

    $minimumRequiredScore = 42;
    $maximumScore = 55;
    $totalScore = $userScores['Total_Score'] ?? 0; 
    $scoreToMin = $minimumRequiredScore - $totalScore;
    $scoreToMax = $maximumScore - $totalScore;
    $scoreToMinText = $scoreToMin > 0 ? "You need at least {$scoreToMin} more to reach the minimum of {$minimumRequiredScore}." : "You have reached the minimum score.";
    $scoreToMaxText = $scoreToMax > 0 ? "You need {$scoreToMax} more to reach the maximum of {$maximumScore}." : "You have reached the maximum score.";
}

if ($loggedInUserId) {
    $sqlReportsTo = "SELECT 
    u1.Username AS OfficerUsername, 
    u2.Username AS ReportsToUsername,
    u2.First_Name AS SupervisorFirstName
FROM 
    user u1
LEFT JOIN 
    user u2 ON u1.Reports_To = u2.User_ID
WHERE 
    u1.User_ID = ?";


$role = $_SESSION['role'] ?? null;  

if ($role === 'research officer') {
}

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/nav_bar.css">

    <script src="../includes/render_nav.js"></script>
    <script src="get_notifications.js"></script>
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
<section>
<?php if ($role === 'Research Officer'): ?>
<div class="container mt-5">
    <?php if ($totalScore >= 42 && $hasMinimumInEachCategory): ?>
    <div class="alert alert-success" role="alert" style="text-align: center;">
        CONGRATULATIONS! You've achieved the minimum score requirement and have points in every category for an end-of-year review.
    </div>
    <?php elseif ($totalScore >= 42): ?>
    <div class="alert alert-warning" role="alert" style="text-align: center;">
        You've reached the minimum score of 42 but are missing points in some categories.
    </div>
    <?php else: ?>
    <div class="alert alert-warning" role="alert" style="text-align: center;">
        WARNING: You need <?= 42 - $totalScore ?> more points to reach the minimum score of 42 required for an end-of-year review. Additionally, ensure you have at least one point in each category.
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>



    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Hello, <?= htmlspecialchars($_SESSION["username"]); ?>!</h1>
            <p class="lead">It's good to see you again.</p>
        </div>

        <div class="newsletter">
            <h2>New This Week at MIROS</h2>
            <div class="card">
                <div class="card-body">
                    <p class="card-text">
                        Stay updated with the latest initiatives and research at the Malaysian Institute of Road Safety. This week, we're excited to announce several new projects aimed at enhancing road safety nationwide. Key highlights include:
                    </p>
                    <ul>
                        <li><strong>Advanced Driver Assistance Systems (ADAS):</strong> We're rolling out a pilot program to test new technologies that help prevent accidents.</li>
                        <li><strong>Community Outreach:</strong> Join us for a series of workshops and talks across various communities to raise awareness about road safety practices.</li>
                        <li><strong>New Research Publication:</strong> Our latest research on urban road safety measures has been published. Check out our website to download the full report.</li>
                    </ul>
                    <p>For more information and to stay engaged with our efforts, visit our website or follow us on social media.</p>
                </div>
            </div>
        </div>
        

        <div class="row justify-content-center my-5">
            <div class="col-md-6">
                <div class="mb-3">
                    <a href="request_reset.php" class="btn btn-secondary btn-block">Reset Password</a>
                </div>
                <div class="mb-3">
                    <a href="logout.php" class="btn btn-danger btn-block">Sign Out</a>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
<?php require("Script.php")?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
