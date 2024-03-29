<?php
require_once __DIR__ . '/../database/db_config.php';

// Define variables and initialize with empty values
$name = $email = $message = $first_name = $last_name = "";
$name_err = $email_err = $message_err = $first_name_err = $last_name_err = "";

// Check if the user is logged in and set name and email
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if (isset($_SESSION["first_name"]) && isset($_SESSION["last_name"])) {
        $name = $_SESSION["first_name"] . " " . $_SESSION["last_name"];
        $first_name = $_SESSION["first_name"];
        $last_name = $_SESSION["last_name"];
    }
    if (isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
    }
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name if user is not logged in
    if (!isset($_SESSION["loggedin"])) {
        if (!isset($_POST["name"]) || empty(trim($_POST["name"]))) {
            $name_err = "Please enter your name.";
        } else {
            $name = trim($_POST["name"]);
        }
    }

    // Validate email if user is not logged in
    if (!isset($_SESSION["loggedin"])) {
        if (!isset($_POST["email"]) || empty(trim($_POST["email"]))) {
            $email_err = "Please enter your email.";
        } else {
            $email = trim($_POST["email"]);
        }
    }

    // Validate message
    if (!isset($_POST["message"]) || empty(trim($_POST["message"]))) {
        $message_err = "Please enter a message.";
    } else {
        $message = trim($_POST["message"]);
    }

    // Validate first name and last name if user is not logged in
    if (!isset($_SESSION["loggedin"])) {
        if (!isset($_POST["first_name"]) || empty(trim($_POST["first_name"]))) {
            $first_name_err = "Please enter your first name.";
        } else {
            $first_name = trim($_POST["first_name"]);
        }

        if (!isset($_POST["last_name"]) || empty(trim($_POST["last_name"]))) {
            $last_name_err = "Please enter your last name.";
        } else {
            $last_name = trim($_POST["last_name"]);
        }
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($email_err) && empty($message_err) && empty($first_name_err) && empty($last_name_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO contact (User_ID, Is_guest, First_Name, Last_Name, Contact_details, Contact_Email, Status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            if (isset($_SESSION["loggedin"])) {
                $user_id = $_SESSION["id"];
                $is_guest = 0;
                $first_name = $_SESSION["first_name"];
                $last_name = $_SESSION["last_name"];
                $user_contact_email = $_SESSION["email"];
            } else {
                $user_id = -1; // Consider a strategy to ensure uniqueness for guests.
                $is_guest = 1;
                $user_contact_email = $email;
            }

            // Set default status as 'Opened'
            $status = 'Opened';

            // Bind parameters
            $stmt->bind_param("iisssss", $user_id, $is_guest, $first_name, $last_name, $message, $user_contact_email, $status);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to success page or display success message
                $successMessage = "Message sent successfully!";
            } else {
                echo "Something went wrong. Please try again later.";
            }
        } else {
            echo "Error: " . $mysqli->error; // Error handling if the prepared statement fails
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
<?php   
    require_once __DIR__ . '/../includes/header.php';
    require_once __DIR__ . '/../includes/nav_bar.php'; ?>
    <section class ="vh-100">

<?php if (isset($successMessage)): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $successMessage; ?>
    </div>
<?php endif; ?>

<div class="custom-box">
    <div class="wrapper">
        <h2>Contact</h2>
        <p>Please fill out this form to send us a message.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php if (!isset($_SESSION["loggedin"])): ?>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                    <span class="invalid-feedback"><?php echo $name_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
            <?php else: ?>
                <p>Contacting as <b><?php echo htmlspecialchars($name); ?></b></p>
            <?php endif; ?>
            <?php if (!isset($_SESSION["loggedin"])): ?>
                <!-- Add first name and last name fields only if user is not logged in -->
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                    <span class="invalid-feedback"><?php echo $first_name_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                    <span class="invalid-feedback"><?php echo $last_name_err; ?></span>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" class="form-control <?php echo (!empty($message_err)) ? 'is-invalid' : ''; ?>"><?php echo $message; ?></textarea>
                <span class="invalid-feedback"><?php echo $message_err; ?></span>
            </div>
            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="form-group">
                <a href="request_reset.php" class="btn btn-secondary">Reset Password</a>
            </div>
        </form>
    </div>
</div>
</section>
</body>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>