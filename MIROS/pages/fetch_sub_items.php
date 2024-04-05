<?php
require_once __DIR__ . '/../database/db_config.php';

header('Content-Type: application/json');

if (isset($_POST['item_id'])) {
    $itemId = $_POST['item_id'];

    // Prepare the statement to avoid SQL injection
    $stmt = $pdo->prepare("SELECT Sub_Item_ID, Sub_Item_Name FROM sub_items WHERE Item_ID = :item_id");
    $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
    $stmt->execute();
    $subItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Echo the data back as a JSON response
    echo json_encode($subItems);
} else {
    // If item_id is not set, return an empty array
    echo json_encode([]);
}
?>
