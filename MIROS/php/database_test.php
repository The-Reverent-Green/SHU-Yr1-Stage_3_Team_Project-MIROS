<?php
include 'MIROS/php/db_config.php';

if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo "Connected successfully to the database.";

$query = "SHOW TABLES FROM $dbname";
$result = $mysqli->query($query);

if ($result) {
    echo "\n\nList of tables in the database:\n";
    while ($row = $result->fetch_assoc()) {
        echo $row["Tables_in_$dbname"] . "\n";
    }
} else {
    echo "Error listing tables: " . $mysqli->error;
}

$mysqli->close();
?>
