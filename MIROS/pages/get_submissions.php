<?php
require_once __DIR__ . '/../database/db_config.php';
echo "success";

try {
  // Create connection
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  
  // Set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // SQL query to fetch submissions for the last 7 days
  $stmt = $conn->prepare("SELECT DATE(Date_Of_Submission) AS SubmissionDate, COUNT(*) AS SubmissionCount
                          FROM submissions
                          WHERE Date_Of_Submission >= CURDATE() - INTERVAL 7 DAY
                          GROUP BY DATE(Date_Of_Submission)
                          ORDER BY DATE(Date_Of_Submission)");
  
  // Execute the query
  $stmt->execute();

  // Set the resulting array to associative
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // You can then pass this result to the front end via JSON
  echo json_encode($result);

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
