<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../database/db_config.php';

header('Content-Type: application/json');

if (isset($_POST['category_id'])) {
    $categoryId = $_POST['category_id'];

    $stmt = $pdo->prepare("SELECT Item_ID, Item_Name FROM items WHERE Category_ID = :category_id");
    $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($items);
} else {
    echo json_encode([]);
}
?>
