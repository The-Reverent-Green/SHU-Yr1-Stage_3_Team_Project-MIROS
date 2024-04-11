<?php
require_once __DIR__ . '/../database/db_config.php';

if(isset($_POST['item_id'])) {
    $item_id = $db->real_escape_string($_POST['item_id']);
    
    $sub_items = $db->query("SELECT Sub_item_id, Sub_item_name FROM miros_sub_items WHERE Item_ID = '$item_id'");
    
    if($sub_items->num_rows > 0) {
        echo '<option value="">Select a sub-item</option>';
        while($sub_item = $sub_items->fetch_assoc()) {
            echo '<option value="'.$sub_item['Sub_item_id'].'">'.$sub_item['Sub_item_name'].'</option>';
        }
    } else {
        echo '<option value="">No sub-items available</option>';
    }
}

?>
