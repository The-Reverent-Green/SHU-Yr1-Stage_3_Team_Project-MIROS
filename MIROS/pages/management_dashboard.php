<?php 

require_once __DIR__ . '/../database/db_config.php';
require_once __DIR__ . '/../includes/header.php';

function getResearchOfficerCountPerSupervisorWithSubmissions($pdo) {
    $supervisorCounts = [];
    try {
        $sql = "SELECT supervisor.User_ID AS supervisor_id, 
                       supervisor.First_Name AS supervisor_firstname, 
                       supervisor.Last_Name AS supervisor_lastname, 
                       COUNT(DISTINCT research_officer.User_ID) AS research_officer_count,
                       SUM(CASE WHEN submissions.Verified = 'yes' THEN 1 ELSE 0 END) AS verified_submissions_count,
                       CASE WHEN COUNT(DISTINCT research_officer.User_ID) > 0 THEN
                            SUM(CASE WHEN submissions.Verified = 'yes' THEN 1 ELSE 0 END) / NULLIF(COUNT(DISTINCT research_officer.User_ID), 0)
                            ELSE 0 END AS avg_submissions_per_officer
                FROM user AS supervisor
                LEFT JOIN user AS research_officer ON supervisor.User_ID = research_officer.Reports_To
                LEFT JOIN submissions ON research_officer.User_ID = submissions.User_ID
                WHERE supervisor.ROLE = 'Supervisor'
                GROUP BY supervisor.User_ID, supervisor.First_Name, supervisor.Last_Name";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $supervisorCounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('PDOException - ' . $e->getMessage(), 0);
    }
    return $supervisorCounts;
}

$supervisorCounts = getResearchOfficerCountPerSupervisorWithSubmissions($pdo);

function getTopPerformingOfficersWithScores($pdo) {
    $topOfficers = [];
    try {
        $sql = "SELECT officer.First_Name AS officer_firstname,
                       officer.Last_Name AS officer_lastname,
                       CONCAT(supervisor.First_Name, ' ', supervisor.Last_Name) AS supervisor_fullname,
                       COUNT(submissions.Submission_ID) AS submission_count,
                       user_scores.Total_Score AS total_score
                FROM user AS officer
                LEFT JOIN user AS supervisor ON officer.Reports_To = supervisor.User_ID
                LEFT JOIN submissions ON officer.User_ID = submissions.User_ID
                LEFT JOIN user_scores ON officer.User_ID = user_scores.User_ID
                WHERE officer.ROLE = 'Research Officer'
                GROUP BY officer.User_ID, officer.First_Name, officer.Last_Name, supervisor_fullname, user_scores.Total_Score
                ORDER BY submission_count DESC, total_score DESC
                LIMIT 5";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $topOfficers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('PDOException - ' . $e->getMessage(), 0);
    }
    return $topOfficers;
}

$topOfficers = getTopPerformingOfficersWithScores($pdo);

function getVerifiedSubmissionsPerCategory($pdo, $categoryId = null) {
    $params = [];
    $query = "SELECT c.Category_Name, COUNT(*) AS VerifiedCount
              FROM submissions s
              JOIN items i ON s.Item_ID = i.Item_ID
              JOIN categories c ON i.Category_ID = c.Category_ID
              WHERE s.Verified = 'yes'";
    if ($categoryId) {
        $query .= " AND c.Category_ID = :categoryId";
        $params[':categoryId'] = $categoryId;
    }
    $query .= " GROUP BY c.Category_Name";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSubmissionsPerUser($pdo) {
    $query = "SELECT u.Username, COUNT(s.Submission_ID) AS SubmissionCount
              FROM user u
              LEFT JOIN submissions s ON u.User_ID = s.User_ID
              WHERE u.ROLE != 'admin'
              GROUP BY u.Username
              HAVING COUNT(s.Submission_ID) > 0";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category'])) {
    header('Content-Type: application/json');
    echo json_encode(getVerifiedSubmissionsPerCategory($pdo, $_POST['category']));
    exit;
}

$defaultChartData = getVerifiedSubmissionsPerCategory($pdo);
$encodedData = json_encode($defaultChartData);
$submissionsPerUser = getSubmissionsPerUser($pdo);
$encodedSubmissionsData = json_encode($submissionsPerUser);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Management dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../includes/render_nav.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<body>
    <nav id="navbar">Loading Navigation bar...</nav>
    <section >
    <div class="container mt-5">
    <div class="jumbotron">
        <h1 class="display-4">Welcome to your management dashboard, <?php echo htmlspecialchars($_SESSION["firstname"]); ?>!</h1> 
        <p class="lead">From here you can view employees, search for submissions and see KPI's/targets.</p>
    </div>
   

    <div class="wrapper">
        <div class="mt-4">
            <h2>Research Officer Count per Supervisor</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Supervisor ID</th>
                        <th>Supervisor Name</th>
                        <th>Research Officer Count</th>
                        <th>Verified Submissions Count</th>
                        <th>Average Submissions per Officer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($supervisorCounts)): ?>
                        <tr>
                            <td colspan="5">No data available.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($supervisorCounts as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['supervisor_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['supervisor_firstname']) . ' ' . htmlspecialchars($row['supervisor_lastname']); ?></td>
                                <td><?php echo htmlspecialchars($row['research_officer_count']); ?></td>
                                <td><?php echo htmlspecialchars($row['verified_submissions_count']); ?></td>
                                <td><?php echo htmlspecialchars(number_format($row['avg_submissions_per_officer'], 2)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
        </div>

        

        <div class="mt-4">
            <h2>Top Performing Officers</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Officer Name</th>
                        <th>Submission Count</th>
                        <th>Total Score</th>
                        <th>Supervisor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($topOfficers)): ?>
                        <tr>
                            <td colspan="4">No data available.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($topOfficers as $officer): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($officer['officer_firstname']) . ' ' . htmlspecialchars($officer['officer_lastname']); ?></td>
                                <td><?php echo htmlspecialchars($officer['submission_count']); ?></td>
                                <td><?php echo htmlspecialchars($officer['total_score']); ?></td>
                                <td><?php echo htmlspecialchars($officer['supervisor_fullname']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

        <div class="container chart-container">
        <h1>User Submissions</h1>

    <canvas id="submissionsChart" width="400" height="400"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctxSubmissions = document.getElementById('submissionsChart').getContext('2d');
        const submissionsData = <?php echo $encodedSubmissionsData; ?>;

        // Sort the data array from smallest to largest number of submissions
        submissionsData.sort((a, b) => a.SubmissionCount - b.SubmissionCount);

        const barColors = submissionsData.map(() => `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.5)`);

        const submissionsChart = new Chart(ctxSubmissions, {
            type: 'bar',
            data: {
                labels: submissionsData.map(item => item.Username),
                datasets: [{
                    label: 'Submissions per User',
                    data: submissionsData.map(item => item.SubmissionCount),
                    backgroundColor: barColors, 
                    borderColor: barColors.map(color => color.replace('0.5', '1')), 
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'x',
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false // Set to false to hide the legend
                    }
                },
                layout: {
                    padding: {
                        left: 10,
                        right: 10,
                        top: 10,
                        bottom: 10
                    }
                },
                backgroundColor: 'white' // Note: This does not affect the canvas directly; it's better managed via CSS.
            }
        });
    </script>
</div>


    </section>
</body>
<?php require("Script.php")?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>
