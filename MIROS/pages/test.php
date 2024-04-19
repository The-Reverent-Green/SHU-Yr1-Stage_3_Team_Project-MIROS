<?php
require_once __DIR__ . '/../database/db_config.php'; // Adjust this path to your actual db_config path

function getCategories($pdo) {
    $stmt = $pdo->query('SELECT Category_ID, Category_Name FROM categories');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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

$categories = getCategories($pdo);
$defaultChartData = getVerifiedSubmissionsPerCategory($pdo);
$encodedData = json_encode($defaultChartData);
$submissionsPerUser = getSubmissionsPerUser($pdo);
$encodedSubmissionsData = json_encode($submissionsPerUser);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interactive Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css"> 
</head>
<body>
    <div class="container">
        <form id="categoryForm">
            <label for="categorySelect">Select a category:</label>
            <select id="categorySelect" name="category">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category['Category_ID']); ?>">
                        <?php echo htmlspecialchars($category['Category_Name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Show Data</button>
        </form>

        <canvas id="myChart" width="400" height="400"></canvas>
        <canvas id="submissionsChart" width="400" height="400"></canvas>

    <script>
    
    const ctxSubmissions = document.getElementById('submissionsChart').getContext('2d');
    const submissionsData = <?php echo $encodedSubmissionsData; ?>;

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
            indexAxis: 'y',

            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true
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
            backgroundColor: 'white'
        }
    });

</script>

    </div>
</body>
<?php require("Script.php")?> <!-- Adjust this path to your actual script file -->
</html>
