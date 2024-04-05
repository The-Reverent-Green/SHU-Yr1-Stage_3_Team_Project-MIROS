<?php
require_once __DIR__ . '/../database/db_config.php';

header('Content-Type: application/json');

if (isset($_POST['category_id'])) {
    $categoryId = $_POST['category_id'];

    // Prepare the statement to avoid SQL injection
    $stmt = $pdo->prepare("SELECT Item_ID, Item_Name FROM items WHERE Category_ID = :category_id");
    $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Echo the data back as a JSON response
    echo json_encode($items);
} else {
    // If category_id is not set, return an empty array
    echo json_encode([]);
}
?>
