<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION["id"] ?? null;
    $categoryId = $_POST['category_id'] ?? null;
    $itemId = $_POST['item_id'] ?? null;
    $subItemId = $_POST['sub_item_id'] ?? null;
    $description = $_POST['description'] ?? '';
    $evidenceAttachmentPath = ''; 

    if (isset($_FILES['evidenceAttachment']) && $_FILES['evidenceAttachment']['error'] === UPLOAD_ERR_OK) {
        $uploadDirectory = __DIR__ . "/../database/uploads/";
        $file = $_FILES['evidenceAttachment'];
        $filePath = $uploadDirectory . basename($file['name']);
        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];
        
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $evidenceAttachmentPath = $filePath;
            } else {
                $_SESSION['message'] = "Error uploading file.";
                $_SESSION['message_type'] = 'danger';
            }
        } else {
            $_SESSION['message'] = "Invalid file type.";
            $_SESSION['message_type'] = 'danger';
        }
    }

    if (!isset($_SESSION['message'])) {
        $_SESSION['message'] = "";
    }

    if ($userId && $categoryId && $itemId && $description && $evidenceAttachmentPath !== '') {
        $insertQuery = "INSERT INTO submissions (User_ID, Category_ID, Item_ID, Sub_Item_ID, Description, Evidence_attachment, Date_Of_Submission, Verified) VALUES (?, ?, ?, ?, ?, ?, NOW(), 'no')";
        $insertStmt = $pdo->prepare($insertQuery);
        try {
            $insertStmt->execute([$userId, $categoryId, $itemId, $subItemId, $description, $evidenceAttachmentPath]);
            $_SESSION['message'] .= "Submission added successfully!"; // Appending message
            $_SESSION['message_type'] = 'success';
        } catch (PDOException $e) {
            $_SESSION['message'] .= "Error inserting submission: " . $e->getMessage(); // Appending message
            $_SESSION['message_type'] = 'danger';
        }
    } else {
        $_SESSION['message'] .= " Please make sure all required fields are filled out correctly and an evidence file is uploaded."; // Appending message
        $_SESSION['message_type'] = 'danger';
    }
    
    // Redirect to the same page to avoid form resubmission on refresh
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
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
<?php if (isset($_SESSION['message']) && isset($_SESSION['message_type'])): ?>
    <div class="alert alert-<?= $_SESSION['message_type']; ?>" role="alert">
        <?= $_SESSION['message']; ?>
    </div>
    <?php
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    ?>
<?php endif; ?>

<div class="wrapper">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
        </select>
        <br>
        <label for="sub_item">Sub-Item:</label>
        <br>
        <select name="sub_item_id" id="sub_item" required>
            <option value="">Select a sub-item</option>
        </select>
        <br>
        <label for="description">Description:</label>
        <br>
        <textarea name="description" id="description" required></textarea>
        <br>

        <div class="custom-file">
  <input type="file" class="custom-file-input" id="evidenceAttachment" name="evidenceAttachment">
  <label class="custom-file-label" for="evidenceAttachment">Attach Evidence</label>
</div>

        <input type="submit" value="Submit" style="margin: 10px;">
    </form>
</div>
<script>
// This basically just updates the evidence div when you add something and then puts the file name in the blank space
document.querySelector('.custom-file-input').addEventListener('change', function (e) {
  var fileName = document.getElementById("evidenceAttachment").files[0].name;
  var nextSibling = e.target.nextElementSibling;
  nextSibling.innerText = fileName;
});
</script>

</body>
</html>
