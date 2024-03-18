<?php
include '../dbConfig/db_config.php';


if ($mysqli->connect_errno) die("Connection failed: " . $mysqli->connect_error);

$result = $mysqli->query("SHOW TABLES FROM $dbname");

if (!$result) {
    echo "Error listing tables: " . $mysqli->error;
} else {
    echo "List of tables in the database:";
    while ($row = $result->fetch_assoc()) {
        print_r('<li>'.$row["Tables_in_$dbname"].'</li>');
    }
}


$mysqli->close();