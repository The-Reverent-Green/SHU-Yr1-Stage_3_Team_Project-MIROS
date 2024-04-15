<?php
require_once __DIR__ . '/../database/db_config.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category'])) {
    header('Content-Type: application/json');
    echo json_encode(getVerifiedSubmissionsPerCategory($pdo, $_POST['category']));
    exit; 
}

$categories = getCategories($pdo);
$defaultChartData = getVerifiedSubmissionsPerCategory($pdo); 
$encodedData = json_encode($defaultChartData);
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
    <script src="get_notifications.js"></script>
</head>
<body>
    <div class="wrapper">
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

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const initialChartData = <?php echo $encodedData; ?>;
        
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: initialChartData.map(item => item.Category_Name),
                datasets: [{
                    label: 'Verified Submissions',
                    data: initialChartData.map(item => item.VerifiedCount),
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        document.getElementById('categoryForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const category = document.getElementById('categorySelect').value;
            const url = '';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'category=' + encodeURIComponent(category)
            })
            .then(response => response.json())
            .then(data => {
                myChart.data.labels = data.map(item => item.Category_Name);
                myChart.data.datasets[0].data = data.map(item => item.VerifiedCount);
                myChart.update();
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
    </div>
</body>
</html>
