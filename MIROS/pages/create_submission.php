<?php
session_start(); // Start the session at the very beginning
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION["id"] ?? null;
    $categoryId = $_POST['category_id'] ?? null;
    $itemId = $_POST['item_id'] ?? null;
    $subItemId = $_POST['sub_item_id'] ?? null;
    $description = $_POST['description'] ?? '';

    if ($userId === null || $categoryId === null || $itemId === null || $description === '') {
        $_SESSION['message'] = "Please make sure all required fields are filled out.";
        $_SESSION['message_type'] = 'danger'; // Use Bootstrap class for error messages
    } else {
        $insertQuery = "INSERT INTO submissions (User_ID, Category_ID, Item_ID, Sub_Item_ID, Description, Date_Of_Submission, Verified) VALUES (?, ?, ?, ?, ?, NOW(), 'no')";
        $insertStmt = $pdo->prepare($insertQuery);
        try {
            $insertStmt->execute([$userId, $categoryId, $itemId, $subItemId, $description]);
            $_SESSION['message'] = "Submission added successfully!";
            $_SESSION['message_type'] = 'success'; // Use Bootstrap class for success messages
        } catch (PDOException $e) {
            $_SESSION['message'] = "Error inserting submission: " . $e->getMessage();
            $_SESSION['message_type'] = 'danger'; // Use Bootstrap class for error messages
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit to Submissions</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script>
        $(document).ready(function(){
            $('#category').change(function(){
                var categoryId = $(this).val();
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
                $('#sub_item').empty().append('<option value="">Select a sub-item</option>');
            });

            $('#item').change(function(){
                var itemId = $(this).val();
                $.ajax({
                    url: 'fetch_sub_items.php',
                    type: 'post',
                    data: {item_id: itemId},
                    dataType: 'json',
                    success: function(response){
                        var subItemsSelect = $('#sub_item');
                        subItemsSelect.empty();
                        if (response.length === 0) {
                            subItemsSelect.append('<option value="">No sub-items available</option>');
                            subItemsSelect.prop('disabled', true);
                        } else {
                            subItemsSelect.append('<option value="">Select a sub-item</option>');
                            response.forEach(function(subItem){
                                subItemsSelect.append('<option value="'+subItem.Sub_Item_ID+'">'+subItem.Sub_Item_Name+'</option>');
                            });
                            subItemsSelect.prop('disabled', false);
                        }
                    }
                });
            });
        });
    </script>
</head>
<body>
<?php   
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav_bar.php'; 
?>

<div class="wrapper">
    <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['message_type']; ?>" role="alert">
      <?= $_SESSION['message']; ?>
    </div>
    <?php 
      unset($_SESSION['message']);
      unset($_SESSION['message_type']);
    endif; 
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="category">Category:</label>
        <br>
        <select name="category_id" id="category" required>
            <option value="">Select a category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['Category_ID']); ?>"><?= htmlspecialchars($category['Category_Name']); ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="item">Item:</label>
        <br>
        <select name="item_id" id="item" required>
            <option value="">Select an item</option>
            <!-- Items will be dynamically loaded based on the selected category -->
        </select>
        <br>
        <label for="sub_item">Sub-Item:</label>
        <br>
        <select name="sub_item_id" id="sub_item" required>
            <option value="">Select a sub-item</option>
            <!-- Sub-items will be dynamically loaded based on the selected item -->
        </select>
        <br>
        <label for="description">Description:</label>
        <br>
        <textarea name="description" id="description" required></textarea>
        <br>
        <input type="submit" value="Submit">
    </form>
</div>
</body>
</html>
