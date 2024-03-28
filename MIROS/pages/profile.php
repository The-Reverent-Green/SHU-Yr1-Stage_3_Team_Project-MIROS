<?php
require_once __DIR__ . '/../database/db_config.php';

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Initialize message variable
$updateMessage = "";

// Fetch user details
$user_id = $_SESSION["id"];
$sql = "SELECT * FROM user WHERE User_ID = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        // print_r($user); // Uncomment this line to print the $user array
    }
    $stmt->close();
}

// Process form data for account update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $username = $_POST["username"];
    $date_of_birth = $_POST["date_of_birth"];
    $email = $_POST["email"];

    // Check if email is unique
    $sql_check_email = "SELECT User_ID FROM user WHERE Email = ? AND User_ID != ?";
    if ($stmt_check_email = $mysqli->prepare($sql_check_email)) {
        $stmt_check_email->bind_param("si", $email, $user_id);
        $stmt_check_email->execute();
        $stmt_check_email->store_result();
        if ($stmt_check_email->num_rows > 0) {
            $updateMessage = "Email already exists.";
        } else {
            // Check if username is unique
            $sql_check_username = "SELECT User_ID FROM user WHERE Username = ? AND User_ID != ?";
            if ($stmt_check_username = $mysqli->prepare($sql_check_username)) {
                $stmt_check_username->bind_param("si", $username, $user_id);
                $stmt_check_username->execute();
                $stmt_check_username->store_result();
                if ($stmt_check_username->num_rows > 0) {
                    $updateMessage = "Username already exists.";
                } else {
                    // Update user details in the database
                    $sql_update_user = "UPDATE user SET First_Name=?, Last_Name=?, Username=?, Date_of_birth=?, Email=? WHERE User_ID=?";
                    if ($stmt_update_user = $mysqli->prepare($sql_update_user)) {
                        $stmt_update_user->bind_param("sssssi", $first_name, $last_name, $username, $date_of_birth, $email, $user_id);
                        if ($stmt_update_user->execute()) {
                            $updateMessage = "Changes saved successfully.";

                            // Fetch updated user details
                            $sql_fetch_user = "SELECT * FROM user WHERE User_ID = ?";
                            if ($stmt_fetch_user = $mysqli->prepare($sql_fetch_user)) {
                                $stmt_fetch_user->bind_param("i", $user_id);
                                if ($stmt_fetch_user->execute()) {
                                    $result_fetch_user = $stmt_fetch_user->get_result();
                                    $user = $result_fetch_user->fetch_assoc();
                                }
                                $stmt_fetch_user->close();
                            }
                        } else {
                            $updateMessage = "Error occurred while saving changes.";
                        }
                        $stmt_update_user->close();
                    }
                }
                $stmt_check_username->close();
            }
        }
        $stmt_check_email->close();
    }
}

// Process account deletion request
if (isset($_POST["delete_account"])) {
    // Change account status to "deleted"
    $sql_update_user = "UPDATE user SET Account_Status='Deleted' WHERE User_ID=?";
    if ($stmt_update_user = $mysqli->prepare($sql_update_user)) {
        $stmt_update_user->bind_param("i", $user_id);
        $stmt_update_user->execute();
        $stmt_update_user->close();
    }

    // Log out the user and redirect to login page
    session_unset();
    session_destroy();
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
<?php require_once __DIR__ . '/../includes/nav_bar.php'; ?>
<div class="container">
    <br>
    <h2>Profile</h2>
    <hr>
    <?php if (!empty($updateMessage)) : ?>
        <div class="alert alert-<?php echo strpos($updateMessage, "Error") !== false ? "danger" : "success"; ?>" role="alert">
            <?php echo $updateMessage; ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6">
            <h3>Edit Account Details</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo isset($user['First_Name']) ? $user['First_Name'] : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo isset($user['Last_Name']) ? $user['Last_Name'] : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username (will be changed upon next login)</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($user['Username']) ? $user['Username'] : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo isset($user['Date_of_birth']) ? $user['Date_of_birth'] : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($user['Email']) ? $user['Email'] : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="mb-3">
                    <a href="request_reset.php" class="btn btn-primary">Request Password Reset</a>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
    <hr class="my-4">
    <div class="row">
        <div class="col-md-6">
            <h3>Delete Account</h3>
            <p>Are you sure you want to delete your account? This action cannot be undone.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <button type="submit" name="delete_account" class="btn btn-danger">Delete Account</button>
                <br>
            </form>
        </div>
    </div>
</div>

</body>
</html>