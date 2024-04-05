<?php
require_once __DIR__ . '/../database/db_config.php';

// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch categories for the dropdown
$categories = [];
try {
    $stmt = $pdo->prepare("SELECT Category_ID, Category_Name FROM categories");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching categories: " . $e->getMessage();
    exit;
}

// Placeholder for items and sub_items arrays
$items = [];
$subItems = [];

// If the form is submitted, process the input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract submitted data, using null coalescing to avoid warnings
    $userId = $_SESSION["id"] ?? null; // Use the correct session key
    $categoryId = $_POST['category_id'] ?? null;
    $itemId = $_POST['item_id'] ?? null;
    $subItemId = $_POST['sub_item_id'] ?? null; // It's okay if this is null, provided your database allows it
    $description = $_POST['description'] ?? '';

    // Check if all required values are present
    if ($userId === null || $categoryId === null || $itemId === null || $description === '') {
        // Handle error, e.g., show a message to the user
        echo "Please make sure all required fields are filled out.";
    } else {
        // Insert data into submissions table, allowing Sub_Item_ID to be null
        $insertQuery = "INSERT INTO submissions (User_ID, Category_ID, Item_ID, Sub_Item_ID, Description, Date_Of_Submission, Verified) VALUES (?, ?, ?, ?, ?, NOW(), 'no')";
        $insertStmt = $pdo->prepare($insertQuery);
        try {
            $insertStmt->execute([$userId, $categoryId, $itemId, $subItemId, $description]);
            echo "Submission added successfully!";
        } catch (PDOException $e) {
            echo "Error inserting submission: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit to Submissions</title>
    <!-- Include JQuery for AJAX calls -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
 $(document).ready(function(){
    // When the category is changed, fetch the items related to the selected category
    $('#category').change(function(){
        var categoryId = $(this).val();
        // Make an AJAX call to fetch_items.php
        $.ajax({
            url: 'fetch_items.php',
            type: 'post',
            data: {category_id: categoryId},
            dataType: 'json',
            success: function(response){
                var itemsSelect = $('#item');
                itemsSelect.empty();
                itemsSelect.append('<option value="">Select an item</option>');
                response.forEach(function(item){
                    itemsSelect.append('<option value="'+item.Item_ID+'">'+item.Item_Name+'</option>');
                });
            }
        });
        // Clear sub-items when category changes
        $('#sub_item').empty().append('<option value="">Select a sub-item</option>');
    });

    // When the item is changed, fetch the sub-items related to the selected item
    $('#item').change(function(){
        var itemId = $(this).val();
        // Make an AJAX call to fetch_sub_items.php
        $.ajax({
            url: 'fetch_sub_items.php',
            type: 'post',
            data: {item_id: itemId},
            dataType: 'json',
            success: function(response){
                var subItemsSelect = $('#sub_item');
                subItemsSelect.empty();
                if (response.length === 0) {
                    // If there are no sub-items, add a disabled option informing the user
                    subItemsSelect.append('<option value="">No sub-items available</option>');
                    subItemsSelect.prop('disabled', true); // Disable the select if no sub-items
                } else {
                    subItemsSelect.append('<option value="">Select a sub-item</option>');
                    response.forEach(function(subItem){
                        subItemsSelect.append('<option value="'+subItem.Sub_Item_ID+'">'+subItem.Sub_Item_Name+'</option>');
                    });
                    subItemsSelect.prop('disabled', false); // Ensure select is enabled
                }
            }
        });
    });
});

    </script>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="category">Category:</label>
        <select name="category_id" id="category" required>
            <option value="">Select a category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['Category_ID']); ?>"><?= htmlspecialchars($category['Category_Name']); ?></option>
            <?php endforeach; ?>
        </select>
        
        <label for="item">Item:</label>
        <select name="item_id" id="item" required>
            <option value="">Select an item</option>
            <!-- Items will be dynamically loaded based on the selected category -->
        </select>

        <label for="sub_item">Sub-Item:</label>
        <select name="sub_item_id" id="sub_item" required>
            <option value="">Select a sub-item</option>
            <!-- Sub-items will be dynamically loaded based on the selected item -->
        </select>
        
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
