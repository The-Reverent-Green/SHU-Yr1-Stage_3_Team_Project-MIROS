<?php require_once __DIR__ . '/../database/db_config.php'; 

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// If the success message is set in the URL query string, store it in a session variable and then clear it
if (isset($_GET['success'])) {
    // Set a session variable to display the success message
    $_SESSION['post_success_message'] = "Post has been created successfully.";

    // Clear the success query parameter from the URL
    header("Location: create_post.php");
    exit();
}

// Define variables and initialize with empty values
$title = $content = $picture_id = "";
$title_err = $content_err = $picture_err = "";

// Fetch the user ID from the database based on the username
$username = $_SESSION['username'];
$user_id_sql = "SELECT User_ID FROM user WHERE Username = ?";
$stmt = $mysqli->prepare($user_id_sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $user_id = $row['User_ID'];
} else {
    // Handle the case when the user ID cannot be retrieved
    echo "Error: Failed to retrieve user ID.";
    exit();
}
$stmt->close();

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate content
    if (empty(trim($_POST["content"]))) {
        $content_err = "Please enter the content.";
    } else {
        $content = trim($_POST["content"]);
    }

    // Handle picture upload if provided
    if (!empty($_FILES["picture"]["name"])) {
        $targetDirectory = "uploads/";
        $fileName = basename($_FILES["picture"]["name"]);
        $targetFilePath = $targetDirectory . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Specify allowed file types
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            // Attempt to move the uploaded file to its new destination
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFilePath)) {
                // Insert picture info into the database
                $insertPictureQuery = "INSERT INTO pictures (FilePath, Upload_Date) VALUES (?, NOW())";
                if ($stmt = $mysqli->prepare($insertPictureQuery)) {
                    $stmt->bind_param("s", $targetFilePath);
                    if ($stmt->execute()) {
                        // Retrieve the last inserted picture ID
                        $picture_id = $mysqli->insert_id;
                    } else {
                        $picture_err = "Error uploading picture to database.";
                    }
                } else {
                    $picture_err = "Failed to prepare picture insertion statement.";
                }
            } else {
                $picture_err = "Failed to upload file.";
            }
        } else {
            $picture_err = "Sorry, only JPG, JPEG, PNG, & GIF files are allowed.";
        }
    }

    // Insert post info into the database
    $insertPostQuery = "INSERT INTO post (User_ID, Title, Content, Picture_ID, Publish_Date_Time, Last_modified, Visibility_Status) VALUES (?, ?, ?, ?, NOW(), NOW(), 'Visible')";
    if ($stmt = $mysqli->prepare($insertPostQuery)) {
        // Bind parameters
        if (!empty($picture_id)) {
            $stmt->bind_param("isss", $user_id, $title, $content, $picture_id);
        } else {
            $null_picture_id = null;
            $stmt->bind_param("isss", $user_id, $title, $content, $null_picture_id);
        }

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to success page
            header("location: create_post.php?success=1");
            exit();
        } else {
            echo "Error executing INSERT query for post: " . $stmt->error . "<br>"; // Debugging message
            $picture_err = "Error inserting post.";
        }
    } else {
        echo "Failed to prepare post insertion statement: " . $mysqli->error . "<br>"; // Debugging message
        $picture_err = "Failed to prepare post insertion statement.";
    }

    // Close connection
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

    <div class="container">
        <br>
        <h2>Create a Post</h2>
        
        <?php if (isset($_SESSION['post_success_message'])): ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['post_success_message'];
                unset($_SESSION['post_success_message']);
                ?>
            </div>
        <?php endif; ?>
        <p>Please fill in this form to create a post.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="col-md-6">
                <label>Title</label>
                <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                <span class="invalid-feedback"><?php echo $title_err;?></span>
            </div>    
            <br>
            <div class="mb-3">
                <label>Content</label>
                <textarea name="content" class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>"><?php echo $content; ?></textarea>
                <span class="invalid-feedback"><?php echo $content_err;?></span>
            </div>
            <div class="mb-3">
                <label>Evidence</label>
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
</body>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>