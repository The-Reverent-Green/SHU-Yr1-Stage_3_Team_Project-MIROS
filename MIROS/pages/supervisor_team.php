<?php 
session_start();  
require_once __DIR__ . '/../database/db_config.php';
require_once __DIR__ . '/../includes/header.php';


$users = myEmp();

function myEmp() {
    $servername = "localhost";
    $dbname = "miros";
    $username = "root";
    $password = "";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $id = $_SESSION['id'];
    $stmt = $conn->prepare("SELECT user.*, MAX(user_scores.Total_Score) as Total_Score FROM user 
        INNER JOIN user_scores ON user.User_ID = user_scores.User_ID 
        WHERE Reports_To = :id 
        GROUP BY user.User_ID 
        ORDER BY MAX(user_scores.Total_Score) DESC");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getUsersWithScoreAboveThreshold($threshold = 42) {
    // Database configuration
    $servername = "localhost";
    $dbname = "miros";
    $username = "root";
    $password = "";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL query to fetch users and their scores
    $id = $_SESSION['id'];
    $stmt = $conn->prepare("
    SELECT DISTINCT user.*, user_scores.Total_Score, user_scores.Cat_A, user_scores.Cat_B, user_scores.Cat_C, user_scores.Cat_D, user_scores.Cat_E, user_scores.Cat_F, user_scores.Cat_G
    FROM user
    INNER JOIN user_scores ON user.User_ID = user_scores.User_ID
    WHERE Reports_To = :id AND user_scores.Total_Score > :threshold
    ORDER BY user_scores.Total_Score DESC
    
    ");
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':threshold', $threshold);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Define the categories
    $categories = ['Cat_A', 'Cat_B', 'Cat_C', 'Cat_D', 'Cat_E', 'Cat_F', 'Cat_G'];
    $eligibleUsers = [];

    // Check each user for the required minimum in each category
    foreach ($users as $user) {
        $hasAllCategoryPoints = true; // Assume user has points in all categories
        foreach ($categories as $category) {
            if (empty($user[$category]) || $user[$category] < 0.1) {
                $hasAllCategoryPoints = false; // Set to false if any category score is missing or less than 0.1
                break;
            }
        }
        if ($hasAllCategoryPoints) {
            $eligibleUsers[] = $user; // Add user to eligible list if they have points in all categories
        }
    }

    return $eligibleUsers;
}


$usersAboveThreshold = getUsersWithScoreAboveThreshold(42);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supervisor Team Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../includes/render_nav.js"></script>
    <script src="get_notifications.js"></script>
    <style>
        body { font: 14px sans-serif; text-align: center; }
        .container { margin-top: 30px; }
        .alert-info { text-align: left; }
        .table thead th { background-color: #f8f9fa; } /* Applying a light background for the table header */
    </style>
</head>

<body>
    <section class="vh-100">
    <nav id="navbar">Loading Navigation bar...</nav>

    <div class="container">
        <h2>End of Year Evaluation Criteria Met</h2>
        <?php if (!empty($usersAboveThreshold)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Total Score</th>
                        <th scope="col">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usersAboveThreshold as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['User_ID']); ?></td>
                            <td><?= htmlspecialchars($user['First_Name'] . ' ' . $user['Last_Name']); ?></td>
                            <td><?= htmlspecialchars($user['Total_Score']); ?></td>
                            <td><?= htmlspecialchars($user['First_Name']) . " has achieved " . htmlspecialchars($user['Total_Score']) . " and has met the criteria for end of year evaluation"; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                No team members have reached the score of 42 yet.
            </div>
        <?php endif; ?>
    </div>

    <div class="container">
        <h2>Team Member Details</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        <th scope="col">Total Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <th scope="row"><?= htmlspecialchars($user['User_ID']); ?></th>
                            <td><?= htmlspecialchars($user['First_Name']); ?></td>
                            <td><?= htmlspecialchars($user['Last_Name']); ?></td>
                            <td><?= htmlspecialchars($user['Date_of_birth']); ?></td>
                            <td><?= htmlspecialchars($user['Email']); ?></td>
                            <td><?= htmlspecialchars($user['ROLE']); ?></td>
                            <td><?= htmlspecialchars($user['account_status']); ?></td>
                            <td><?= htmlspecialchars($user['Total_Score']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
</body>
<?php require("Script.php")?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>
