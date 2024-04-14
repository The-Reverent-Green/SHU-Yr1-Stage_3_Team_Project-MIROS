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
            error_log("Error executing user scores statement: " . $stmt->error, 3,);
        }
        $stmt->close();
    } else {
        error_log("Error preparing user scores statement: " . $mysqli->error, 3,);
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


    
    if ($stmt = $mysqli->prepare($sqlReportsTo)) {
        $stmt->bind_param("i", $loggedInUserId);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $reportsToData = $result->fetch_assoc();
        } else {
            error_log("Error executing reports to statement: " . $stmt->error, 3,);
        }
        $stmt->close();
    } else {
        error_log("Error preparing reports to statement: " . $mysqli->error, 3,);
    }
}

$categories = ['Cat_A', 'Cat_B', 'Cat_C', 'Cat_D', 'Cat_E', 'Cat_F', 'Cat_G'];
$hasMinimumInEachCategory = true; // Assume the user has minimum points in each category

foreach ($categories as $category) {
    if (empty($userScores[$category]) || $userScores[$category] < 0.1) {
        $hasMinimumInEachCategory = false;
        break; // Exit the loop as soon as one category doesn't meet the criteria
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Officer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../includes/render_nav.js"></script>
    <style>
        body { font: 14px sans-serif; text-align: center; }
        </style>
</head>
<body>
    <?php require_once __DIR__ . '/../includes/header.php';?>
        <nav id="navbar">Loading Navigation bar...</nav>
    <section>
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

       
        <div class="container mt-5">
            <div class="jumbotron">
                <h1 class="display-4" style="text-align: center;">Dashboard for <?= htmlspecialchars($_SESSION["username"]); ?></h1>
            </div>
        </div>
        
        <div class="container">
            <div class="wrapper">
            <h1>Your Scores</h1>
            <?php if (!$userScores): ?>
                <p>You have no scores to display.</p>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Category A</th>
                            <th>Category B</th>
                            <th>Category C</th>
                            <th>Category D</th>
                            <th>Category E</th>
                            <th>Category F</th>
                            <th>Category G</th>
                            <th>Total Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= htmlspecialchars($userScores['Cat_A']); ?></td>
                            <td><?= htmlspecialchars($userScores['Cat_B']); ?></td>
                            <td><?= htmlspecialchars($userScores['Cat_C']); ?></td>
                            <td><?= htmlspecialchars($userScores['Cat_D']); ?></td>
                            <td><?= htmlspecialchars($userScores['Cat_E']); ?></td>
                            <td><?= htmlspecialchars($userScores['Cat_F']); ?></td>
                            <td><?= htmlspecialchars($userScores['Cat_G']); ?></td>
                            <td><?= htmlspecialchars($userScores['Total_Score']); ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
            </div>
            <div class="wrapper">
    <h1>Your Score Summary</h1>
    <?php if ($totalScore > 0): ?>
        <?php
            $endOfYear = new DateTime('December 31');
            $today = new DateTime();
            $daysUntilEndOfYear = $today->diff($endOfYear)->days;

            $categories = ['Cat_A', 'Cat_B', 'Cat_C', 'Cat_D', 'Cat_E', 'Cat_F', 'Cat_G'];
            $missingCategories = [];

            foreach ($categories as $category) {
                if (empty($userScores[$category]) || $userScores[$category] <0.1) {
                    $missingCategories[] = $category;
                }
            }

            $missingCategoriesList = implode(', ', $missingCategories);
        ?>
        <div class="card">
            <div class="card-body">
            <h5 class="card-title" style="text-decoration: underline;">Score Details</h5>
                <p class="card-text">
                    Total score: <strong><?= htmlspecialchars($totalScore) ?></strong><br>
                    <?= htmlspecialchars($scoreToMinText) ?><br>
                    <?= htmlspecialchars($scoreToMaxText) ?><br>
                    Time remaining this year to reach goals: <strong><?= $daysUntilEndOfYear ?> days</strong>.<br>
                    <?php if (!empty($missingCategories)): ?>
                        <br>
                        Missing a verified submission in the following categories: <strong><?= htmlspecialchars($missingCategoriesList) ?></strong>.
                    <?php else: ?>
                        You have scored at least one point in every category.
                    <?php endif; ?>
                </p>
            </div>
        </div>
    <?php else: ?>
        <p>Your total score is not available. Ensure all required activities are completed to reflect your score here.</p>
    <?php endif; ?>
</div>



<?php if ($reportsToData): ?>
    <div class="wrapper">
        <h2>Reporting Information</h2>
        <p>Hello <strong><?= htmlspecialchars($_SESSION['firstname']); ?></strong>, you currently report to <strong><?= htmlspecialchars($reportsToData['SupervisorFirstName'] ?? 'N/A'); ?></strong></p>
    </div>
<?php endif; ?>

        </div>
        <br>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
