<?php
require_once __DIR__ . '/../database/db_config.php';

if (isset($_SESSION['id']) && $_SESSION['loggedin']) {
    $loggedInUserId = $_SESSION['id'];

    $userScores = [];
    $sql = "SELECT * FROM user_scores WHERE User_ID = ?";
    
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $loggedInUserId);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $userScores = $result->fetch_assoc(); 
        } else {
            error_log("Error executing statement: " . $stmt->error . "\n", 3, "/path/to/your/error.log");
            echo "Oops! Something went wrong. Please try again later.";
        }

        $stmt->close();
    } else {
        error_log("Error preparing statement: " . $mysqli->error . "\n", 3, "/path/to/your/error.log");
        echo "Oops! Something went wrong. Please try again later.";
    }
}

if (!empty($userScores)) {
    $minimumRequiredScore = 42;
    $maximumScore = 55;

    $totalScore = $userScores['Total_Score']; 
    $scoreToMin = $minimumRequiredScore - $totalScore;
    $scoreToMax = $maximumScore - $totalScore;

    $scoreToMinText = $scoreToMin > 0 ? "You need at least {$scoreToMin} more to reach the minimum of {$minimumRequiredScore}." : "You have reached the minimum score.";
    $scoreToMaxText = $scoreToMax > 0 ? "You need {$scoreToMax} more to reach the maximum of {$maximumScore}." : "You have reached the maximum score.";
} else {
    echo "No user scores found or user is not logged in.";
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Officer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<?php   
    require_once __DIR__ . '/../includes/header.php';
    require_once __DIR__ . '/../includes/nav_bar.php'; ?>
<section class="vh-100">

    <div class="container mt-5">
        <div class="jumbotron">
        <h1 class="display-4" style="text-align: center;">Dashboard for <?php echo htmlspecialchars($_SESSION["username"]); ?></h1>        </div>
        
       
    </div>
    
<div class="container">
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
        <p>You have a total score of <?= $totalScore ?>.</p>
        <p><?= $scoreToMinText ?></p>
        <p><?= $scoreToMaxText ?></p>
    <?php else: ?>
        <p>Your total score is not available. Please ensure you have completed all required activities.</p>
    <?php endif; ?>
</div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>