<?php
require_once __DIR__ . '/../database/db_config.php';

if(isset($_POST['category_id'])) {
    $category_id = $db->real_escape_string($_POST['category_id']);
    
    $items = $db->query("SELECT Item_ID, Item_Name FROM miros_items WHERE Category_ID = '$category_id'");
    
    if($items->num_rows > 0) {
        echo '<option value="">Select an item</option>';
        while($item = $items->fetch_assoc()) {
            echo '<option value="'.$item['Item_ID'].'">'.$item['Item_Name'].'</option>';
        }
    } else {
        echo '<option value="">No items available</option>';
    }
}

?>
