<?php
// Include config file
include '../dbConfig/db_config.php';

// Check for a success message in the session and save it to a variable
$success_message = "";
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    
    // Don't forget to clear the message after displaying it
    unset($_SESSION['success_message']);
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT User_ID, Username, PasswordHash, Role, Account_Status FROM user WHERE Username = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = $username;

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $hashed_password, $role, $account_status); 

                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            if ($account_status == 'active') {
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
                                $_SESSION["role"] = $role;
                            
                                // Update the Last_Log_In column with the current timestamp
                                $current_timestamp = date('Y-m-d H:i:s');
                                $update_query = "UPDATE user SET Last_Log_In = ? WHERE User_ID = ?";
                            
                                if ($stmt = $mysqli->prepare($update_query)) {
                                    $stmt->bind_param("si", $current_timestamp, $id);
                                    $stmt->execute();
                                    $stmt->close();
                                }
                            
                                // Redirect user to welcome page
                                header("location: welcome.php");
                            } else {
                                $login_err = "Your account is deactivated. Please contact the administrator.";
                            }
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                // Error executing the statement
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/site.css">
    <link rel="stylesheet" href="../assets/bootstrap.css">

</head>
<body>
<nav class="navbar navbar-expand-sm sticky-top navbar-light bg-black">
        <div class="container-fluid justify-content-center">
            <a href="index.php" class="navbar-brand mb-0 h1">
                <img class="d-inline-block align-top" src="../assets/logo.png" height="65"/>
            </a>
        </div>
    </nav>
<div class="wrapper">
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>
    <?php 
    if (!empty($login_err)) {
        echo '<div class="alert alert-danger">' . $login_err . '</div>';
    }        
    ?>
    <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</div>    
</body>
</html>
