<?php
require_once __DIR__ . '/../database/db_config.php';

header('Content-Type: application/json');

if (isset($_POST['item_id'])) {
    $itemId = $_POST['item_id'];

    $stmt = $pdo->prepare("SELECT Sub_Item_ID, Sub_Item_Name FROM sub_items WHERE Item_ID = :item_id");
    $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
    $stmt->execute();
    $subItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($subItems);
} else {
    echo json_encode([]);
}
?>
