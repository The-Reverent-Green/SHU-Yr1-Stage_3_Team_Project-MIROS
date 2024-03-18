<?php
include 'db_config.php';

if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo "Connected successfully to the database.<br>";

$query = "SHOW TABLES FROM $dbname";
$result = $mysqli->query($query);

if ($result) {
    echo "<br>List of tables in the database:<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row["Tables_in_$dbname"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Error listing tables: " . $mysqli->error;
}

$mysqli->close();
?>
