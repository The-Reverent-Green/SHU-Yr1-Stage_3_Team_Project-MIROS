<?php
require_once __DIR__ . '/../database/db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $mysqli->prepare("INSERT INTO contact (First_Name, Last_Name, contact_email, contact_message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Contact information submitted successfully.');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Form</title>
  <link rel="stylesheet" href="bootstrap.css">
</head>
<body>
<?php   
    require_once __DIR__ . '/../includes/header.php';
    require_once __DIR__ . '/../includes/nav_bar.php'; ?>
    <section class ="vh-100">

<div class="container">
  <h2>Contact Form</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <div class="form-group">
      <label for="first_name">First Name:</label>
      <input type="text" class="form-control" id="first_name" name="first_name" required>
    </div>
    <div class="form-group">
      <label for="last_name">Last Name:</label>
      <input type="text" class="form-control" id="last_name" name="last_name" required>
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="message">Message:</label>
      <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
    </div>
    <br>
    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  </form>
</div>



</section>
</body>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>
