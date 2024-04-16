<?php
    require_once __DIR__ . '/../database/db_config.php';

    $usernameInput = $emailInput = "";
    $usernameError = $emailError = $resetError = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty(trim($_POST["username"]))) {
            $usernameError = "Please enter your username.";
        }
        else {
            $usernameInput = trim($_POST["username"]);
        }

        if (empty(trim($_POST["email"]))) {
            $emailError = "Please enter your email.";
        }
        else {
            $emailInput = trim($_POST["email"]);
        }

        if (empty($usernameError) && empty($emailError)) {

            $any_users_rithout_roles = "SELECT * FROM user WHERE username = ? AND email = ?";
            
            if ($stmt = $mysqli->prepare($any_users_rithout_roles)) {
                $stmt->bind_param("ss", $usernameInput, $emailInput); 
    
                if ($stmt->execute()) {
                    $stmt->store_result();
                    
                    if ($stmt->num_rows == 1) {

                        $token = bin2hex(random_bytes(16));
                        $token_hash = hash("sha256", $token);
                        date_default_timezone_set("Europe/London");
                        $expiry = date("Y-m-d H:i:s", time()+ 60 * 30);

                        $any_users_rithout_roles = "UPDATE user SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?";

                        $stmt = $mysqli->prepare($any_users_rithout_roles);
                        $stmt->bind_param("sss", $token_hash, $expiry, $emailInput); 
                        $stmt->execute();

                        require_once __DIR__ . '/../PHPMailer/src/Exception.php';
                        require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
                        require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

                        $mail = new PHPMailer\PHPMailer\PHPMailer(true);                        
                        $mail -> isSMTP();
                        $mail -> Host = 'smtp.gmail.com';
                        $mail -> SMTPAuth = true;
                        $mail -> Username = 'mirostest24@gmail.com';
                        $mail -> Password = 'aeir nyuj xehm xwod';
                        $mail -> SMTPSecure = 'ssl';
                        $mail -> Port = 465;

                        $mail->setFrom('mirostest24@gmail.com', 'MIROS');

                        $mail -> addAddress($emailInput);

                        $mail -> isHTML(true);
                        $mail -> Subject = "Password Reset";
                        $mail->Body = "Click <a href='http://localhost/MIROS/pages/reset_password.php?token=$token'>here</a> to reset your password.";
                                                
                        $mail -> send();

                        $_SESSION['success_message'] = "Email sent!";
                    }
                    else {
                    $resetError = 'Account not found. You can create an account <a href="register_user.php">here</a>';
                    }
                }
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
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

<title>Reset Password</title>

</head>
<body>
    <?php require_once __DIR__ . '/../includes/header.php';?>
            <nav id="navbar">Loading Navigation bar...</nav>

        <section class="vh-100">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="wrapper">
                       <h2>Reset Password</h2>
                        <p>Please fill in your credentials.</p>
                        <?php 
                            if(!empty($resetError)){
                                echo '<div class="alert alert-danger">' . $resetError . '</div>';
                            }  
                            if (!empty($_SESSION['success_message'])) {
                                echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                                unset($_SESSION['success_message']); 
                            }      
                        ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control <?php echo (!empty($usernameError)) ? 'is-invalid' : ''; ?>" value="<?php echo $usernameInput; ?>">
                                <span class="invalid-feedback"><?php echo $usernameError; ?></span>
                            </div>    
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control <?php echo (!empty($emailError)) ? 'is-invalid' : ''; ?>" value="<?php echo $emailInput; ?>">
                                <span class="invalid-feedback"><?php echo $emailError; ?></span>
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
    <?php require("Script.php")?>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>

</html>
