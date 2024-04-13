<?php
require_once __DIR__ . '/../database/db_config.php';

// Function to get categories for the form dropdown
function getCategories($pdo) {
    // Replace with the actual query to fetch categories
    $stmt = $pdo->query('SELECT Category_ID, Category_Name FROM categories');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get verified submissions per category
function getVerifiedSubmissionsPerCategory($pdo, $categoryId = null) {
    // Replace with the actual query to fetch submissions per category
    // This placeholder query assumes you have a 'verified' column that can be filtered
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

// This checks if the form was submitted with a specific category selected
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category'])) {
    header('Content-Type: application/json');
    echo json_encode(getVerifiedSubmissionsPerCategory($pdo, $_POST['category']));
    exit; // Stop further PHP execution since we only want to return the JSON data
}

$categories = getCategories($pdo);
$defaultChartData = getVerifiedSubmissionsPerCategory($pdo); // Get default chart data for initial load
$encodedData = json_encode($defaultChartData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interactive Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
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

        // Handle the form submission
        document.getElementById('categoryForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const category = document.getElementById('categorySelect').value;
            // The URL to which we send the POST request
            const url = ''; // You might need to adjust this URL depending on your setup

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
</body>
</html>
