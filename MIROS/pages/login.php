<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../database/db_config.php';



$success_message = "";
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    
    unset($_SESSION['success_message']);
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT User_ID, Username, PasswordHash, Role, Account_Status, First_name FROM user WHERE Username = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = $username;

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $hashed_password, $role, $account_status, $first_name);

                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            if ($account_status == 'active') {
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username; 
                                $_SESSION["role"] = $role;
                                $_SESSION["firstname"] = $first_name; 

                                $current_timestamp = date('Y-m-d H:i:s');
                                $update_query = "UPDATE user SET Last_Log_In = ? WHERE User_ID = ?";
                                
                                if ($update_stmt = $mysqli->prepare($update_query)) {
                                    $update_stmt->bind_param("si", $current_timestamp, $id);
                                    if (!$update_stmt->execute()) {
                                    }
                                    $update_stmt->close();
                                }

                                header("location: index.php");
                                exit;
                            } else {
                                $login_err = "Your account is deactivated. Please contact the administrator.";
                            }
                        } else {
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    $login_err = "Invalid username or password.";
                }
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
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="../includes/render_nav.js"></script>

    <style>
@media (max-width: 768px) {
    .wrapper {
        padding: 20px;
    }
}
</style>
</head>
<body>
<?php require_once __DIR__ . '/../includes/header.php';?>
<nav id="navbar">Loading Navigation bar...</nav>
<section class="vh-100">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 mb-4 mb-md-0">
                <div class="text-center">
                <img src="../images/logo_circle.jpg" alt="Logo Image" class="img-fluid" style="border-radius: 50%;">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="wrapper">
                    <h2>Login</h2>
                    <p>Please fill in your credentials to login.</p>
                    <?php 
                    if(!empty($login_err)){
                        echo '<div class="alert alert-danger">' . $login_err . '</div>';
                    }        
                    ?>
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
                        <p>Can't login? <a href="register_user.php">Sign up now</a> or <a href="request_reset.php"> reset password. </a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>
