<?php
require_once __DIR__ . '/../database/db_config.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$title = $content = $category = $subCategory = "";
$title_err = $content_err = $category_err = $subCategory_err = $picture_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    if (empty(trim($_POST["content"]))) {
        $content_err = "Please enter the description.";
    } else {
        $content = trim($_POST["content"]);
    }

    if (empty($_POST["category"])) {
        $category_err = "Please select a category.";
    } else {
        $category = $_POST["category"];
        if (empty($_POST["subCategory"])) {
            $subCategory_err = "Please select a sub-category.";
        } else {
            $subCategory = $_POST["subCategory"];
        }
    }


    if (empty($title_err) && empty($content_err) && empty($category_err) && empty($subCategory_err) && empty($picture_err)) {
        $sql = "INSERT INTO submissions (User_ID, Title, Descripton, Category, Date_Of_Submission, Publication_URL, Evidence_attachment, Approved) VALUES (?, ?, ?, ?, NOW(), ?, ?, 'open')";

        if ($stmt = $mysqli->prepare($sql)) {
            $user_id = $_SESSION['user_id'];
            $publication_url = ''; 
            $evidence = ''; 
            $stmt->bind_param("issssb", $user_id, $title, $content, $category, $publication_url, $evidence);

            if ($stmt->execute()) {
                $_SESSION['post_success_message'] = "Submission successful!";
                header("Location: success_page.php"); 
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
<?php   
    require_once __DIR__ . '/../includes/header.php';
    require_once __DIR__ . '/../includes/nav_bar.php'; ?>
    <section class ="vh-100">

    <div class="container">
        <br>
        <h2>Create a Submission</h2>
        
        <?php if (isset($_SESSION['post_success_message'])): ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['post_success_message'];
                unset($_SESSION['post_success_message']);
                ?>
            </div>
        <?php endif; ?>
        <p>Please fill in this form to create a submission.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="col-md-6">
                <h4>Title</h4>
                <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                <span class="invalid-feedback"><?php echo $title_err;?></span>
            </div>    
            <br>
            <div class="mb-3">
                <h4>Description</h4>
                <textarea name="content" class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>"><?php echo $content; ?></textarea>
                <span class="invalid-feedback"><?php echo $content_err;?></span>
            </div>
            <br>
           
    <h4>Category</h4>
    <input type="radio" id="category1" name="category" value="Category1">
    <label for="category1">Category 1</label><br>

    <input type="radio" id="category2" name="category" value="Category2">
    <label for="category2">Category 2</label><br>

    <input type="radio" id="category3" name="category" value="Category3">
    <label for="category3">Category 3</label><br>
    
</div>
<br>
<div class="container">
    <h6 for="dynamicDropdown">Sub Category</h6>
    <select id="dynamicDropdown">
        <option value="">Please select a category first</option>
    </select>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var radioButtons = document.querySelectorAll('input[type="radio"][name="category"]');
    var dropdown = document.getElementById('dynamicDropdown');

    radioButtons.forEach(function(radio) {
        radio.addEventListener('change', function() {
            updateDropdown(this.value);
        });
    });

    function updateDropdown(selectedCategory) {
        var options = {
            'Category1': ['Option 1-1', 'Option 1-2', 'Option 1-3'],
            'Category2': ['Option 2-1', 'Option 2-2', 'Option 2-3'],
            'Category3': ['Option 3-1', 'Option 3-2', 'Option 3-3'],
        };

        while (dropdown.options.length > 1) {
            dropdown.remove(1);
        }

        options[selectedCategory].forEach(function(optionText) {
            var newOption = new Option(optionText, optionText);
            dropdown.add(newOption);
        });
    }
});
</script>
<div class="container">
            <div class="mb-3">
                <br>
                <h4>Evidence</h4>
                <input type="file" name="picture" class="form-control <?php echo (!empty($picture_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $picture_err;?></span>
            </div>
            <btr>
            <div class="mb-3">
                <br>
                <input type="submit" class="btn btn-primary" value="Submit Post">
            </div>
        </form>
    </div>
    </div>
    </section>
</body>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>