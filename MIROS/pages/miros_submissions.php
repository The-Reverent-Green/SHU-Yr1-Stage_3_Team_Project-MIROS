<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../database/db_config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$categories = [];
try {
    $stmt = $pdo->prepare("SELECT Category_ID, Category_Name FROM categories");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching categories: " . $e->getMessage();
    exit;
}

$items = [];
$subItems = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION["id"] ?? null; 
    $categoryId = $_POST['category_id'] ?? null;
    $itemId = $_POST['item_id'] ?? null;
    $subItemId = $_POST['sub_item_id'] ?? null; 
    $description = $_POST['description'] ?? '';

    if ($userId === null || $categoryId === null || $itemId === null || $description === '') {
        echo "Please make sure all required fields are filled out.";
    } else {
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../includes/render_nav.js"></script>
    <script src="get_notifications.js"></script>
    <script>
        $(document).ready(function() {
            $('#category').change(function() {
                var categoryId = $(this).val();
                $.ajax({
                    url: 'fetch_items.php',
                    type: 'post',
                    data: {
                        category_id: categoryId
                    },
                    dataType: 'json',
                    success: function(response) {
                        var itemsSelect = $('#item');
                        itemsSelect.empty();
                        itemsSelect.append('<option value="">Select an item</option>');
                        response.forEach(function(item) {
                            itemsSelect.append('<option value="' + item.Item_ID + '">' + item.Item_Name + '</option>');
                        });
                    }
                });
                $('#sub_item').empty().append('<option value="">Select a sub-item</option>');
            });
            
            $('#item').change(function() {
                var itemId = $(this).val();
                $.ajax({
                    url: 'fetch_sub_items.php',
                    type: 'post',
                    data: {
                        item_id: itemId
                    },
                    dataType: 'json',
                    success: function(response) {
                        var subItemsSelect = $('#sub_item');
                        subItemsSelect.empty();
                        if (response.length === 0) {
                            subItemsSelect.append('<option value="">No sub-items available</option>');
                            subItemsSelect.prop('disabled', true); 
                            subItemsSelect.append('<option value="">Select a sub-item</option>');
                            response.forEach(function(subItem) {
                                subItemsSelect.append('<option value="' + subItem.Sub_Item_ID + '">' + subItem.Sub_Item_Name + '</option>');
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
    <nav id="navbar">Loading Navigation bar...</nav>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="category">Category:</label>
        <select name="category_id" id="category" required>
            <option value="">Select a category</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?= htmlspecialchars($category['Category_ID']); ?>"><?= htmlspecialchars($category['Category_Name']); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="item">Item:</label>
        <select name="item_id" id="item" required>
            <option value="">Select an item</option>
        </select>

        <label for="sub_item">Sub-Item:</label>
        <select name="sub_item_id" id="sub_item" required>
            <option value="">Select a sub-item</option>
        </select>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>

        <input type="submit" value="Submit">
    </form>
</body>

</html>