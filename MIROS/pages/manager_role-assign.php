<?php

require_once __DIR__ . '/../database/db_config.php'; 

$officers = [];
$supervisors = [];
$successMessage = "";

$usersWithoutSupervisors = [];

try {
    $getUsersWithoutSupervisors = "SELECT User_ID, username, First_Name, Last_Name FROM user WHERE Reports_To IS NULL";
    $noSupervisorStmt = $mysqli->query($getUsersWithoutSupervisors);
    while ($row = $noSupervisorStmt->fetch_assoc()) {
        $usersWithoutSupervisors[] = $row;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

if(isset($mysqli) && $mysqli instanceof mysqli) {
    try {
        $getOfficers = "SELECT User_ID, username FROM user WHERE role = 'Research Officer'";
        $officerStmt = $mysqli->query($getOfficers);
        while ($row = $officerStmt->fetch_assoc()) {
            $officers[] = $row;
        }
        
        $getSupervisors = "SELECT User_ID, username FROM user WHERE role = 'Supervisor'";
        $supervisorStmt = $mysqli->query($getSupervisors);
        while ($row = $supervisorStmt->fetch_assoc()) {
            $supervisors[] = $row;
        }

        if(isset($_POST['assign'])) {
            $officerUserID = $_POST['officerUsername'];
            $supervisorUserID = $_POST['supervisorUsername']; 

            $assignOfficerToSupervisor = "UPDATE user SET Reports_To = ? WHERE User_ID = ?";
            $assignStmt = $mysqli->prepare($assignOfficerToSupervisor);
            $assignStmt->bind_param("ii", $supervisorUserID, $officerUserID);
            $assignStmt->execute();
            
            $successMessage = "Officer has been assigned to Supervisor successfully!";
        }
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Database connection not established.";
}

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



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Officer to Supervisor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/nav_bar.css"></head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="../includes/render_nav.js"></script>

<body>
<?php require_once __DIR__ . '/../includes/header.php';?>
<nav id="navbar">Loading Navigation bar...</nav>
    <section>
        <div class="container mt-5">
            <?php if(!empty($successMessage)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $successMessage; ?>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-6" style="background-color: white; padding: 20px; ">
                    <h2>Assign Officer to Supervisor</h2>
                    <form method="post" action="">
                        <label>Select Officer:</label><br>
                        <select name="officerUsername" required>
                            <?php foreach($officers as $officer): ?>
                                <option value="<?php echo $officer['User_ID']; ?>"><?php echo $officer['username']; ?></option>
                            <?php endforeach; ?>
                        </select><br><br>

                        <label>Select Supervisor:</label><br>
                        <select name="supervisorUsername" required>
                            <?php foreach($supervisors as $supervisor): ?>
                                <option value="<?php echo $supervisor['User_ID']; ?>"><?php echo $supervisor['username']; ?></option>
                            <?php endforeach; ?>
                        </select><br><br>

                        <input type="submit" value="Assign Officer" name="assign" class="btn btn-primary">
                    </form>
                </div>

                <div class="col-md-6" style="background-color: white; padding: 20px;  ">
                    <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                        <canvas id="officersPerSupervisorChart"></canvas>
                    </div>
                    <script>
                    var supervisorNames = [];
                    var officerCounts = [];
                    <?php foreach ($supervisorCounts as $row): ?>
                        supervisorNames.push("<?php echo htmlspecialchars($row['supervisor_firstname']) . ' ' . htmlspecialchars($row['supervisor_lastname']); ?>");
                        officerCounts.push(<?php echo htmlspecialchars($row['research_officer_count']); ?>);
                    <?php endforeach; ?>

                    var ctx = document.getElementById('officersPerSupervisorChart').getContext('2d');
                    var myPieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: supervisorNames,
                            datasets: [{
                                label: 'Research Officer Count',
                                data: officerCounts,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                            }
                        }
                    });
                    </script>
                </div>
            </div>
        </div>
        <div class="wrapper">
                <h2>Users Without Supervisors</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($usersWithoutSupervisors as $user): ?>
                            <tr>
                                <td><?php echo $user['User_ID']; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo $user['First_Name']; ?></td>
                                <td><?php echo $user['Last_Name']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <?php require("Script.php")?>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
