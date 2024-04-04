<?php 
include __DIR__ . '/../database/db_config.php';

date_default_timezone_set("Europe/London"); // Get correct timezone

$passwordInput = $confirmationInput = "";
$passwordError = $confirmationError = "";

// Get token
$token = $_POST["token"];

// Get resetError (keeps the inputs disabled if not blank)
$resetError = $_POST["resetError"];

// Check token isnt empty 
if (!empty($token)) {

    $token_hash = hash("sha256", $token);
    $sql = "SELECT User_ID, reset_token_expires_at FROM user WHERE reset_token_hash = ?";
    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();

    $stmt->store_result();

    // Find the user with that token
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $reset_token_expires_at);
        $stmt->fetch();

        // Check token hasn't expired
        if (!strtotime($reset_token_expires_at) <= time()) {
            // Validate password
            if (empty(trim($_POST["password"]))) {
                $passwordError = "Please enter a password.";
            } elseif (strlen(trim($_POST["password"])) < 6) {
                $passwordError = "Password must have at least 6 characters.";
            } else {
                $passwordInput = trim($_POST["password"]);
            }

            // Validate confirm password
            if (empty(trim($_POST["confirmPassword"]))) {
                $confirmationError = "Please confirm the password.";
            } else {
                $confirmationInput = trim($_POST["confirmPassword"]);
                if ($passwordInput != $confirmationInput) {
                    $confirmationError = "Passwords did not match.";
                }
            }
            
            if (empty($confirmationError) && empty($passwordError)) {
                
                $passwordHash = password_hash($passwordInput, PASSWORD_DEFAULT);
                
                // Set new password
                $sql = "UPDATE user SET passwordHash = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE User_ID = ?";
                $stmt = $mysqli->prepare($sql); 
                $stmt->bind_param("ss", $passwordHash, $id); 
                $stmt->execute();

                $_SESSION['success_message'] = "Password successfully changed, You can now login.";
            }
        
        } else {
            $resetError = "Token has expired";
        }
    } else {
        $resetError = "Token does not exist.";
    }
} else {
    
    $resetError = "Error";
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media (max-width: 768px) {
            .wrapper {
                padding: 20px;
            }
        }
    </style>

    <title>Reset Password</title>

    </head>
    <body>
        <?php   
            require_once __DIR__ . '/../includes/header.php';
            require_once __DIR__ . '/../includes/nav_bar.php'; 
        ?>

        <section class="vh-100">                
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="wrapper">
                        <h2>Reset Password</h2>
                        <?php 
                            if(!empty($resetError)){
                                echo '<div class="alert alert-danger">' . $resetError . '</div>';
                            }  
                            if (!empty($_SESSION['success_message'])) {
                                echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                                unset($_SESSION['success_message']); 
                            }      
                        ?>
                        <form action="process-reset-password.php" method="post">

                            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control <?php echo (!empty($passwordError)) ? 'is-invalid' : ''; ?>" <?php echo (!empty($resetError)) ? 'disabled' : ''; ?>>
                                <span class="invalid-feedback"><?php echo $passwordError; ?></span>
                            </div>    
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control <?php echo (!empty($confirmationError)) ? 'is-invalid' : ''; ?>" <?php echo (!empty($resetError)) ? 'disabled' : ''; ?>>
                                <span class="invalid-feedback"><?php echo $confirmationError; ?></span>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </form>
                    </div>                    
                </div>
            </div>
        </section>
    </body>

    <?php require_once __DIR__ . '/../includes/footer.php'; ?>

</html>