<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../database/db_config.php';


$id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $contact_message = $_POST['contact_message'];

    $status = "Opened";

    $stmt = $mysqli->prepare("INSERT INTO contact (User_ID, contact_message, Status) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $id, $contact_message, $status);

    if ($stmt->execute()) {
        $success_message = "Contact information submitted successfully.";
    } else {
        $error_message = "Error: " . $stmt->error;
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
  <link rel="stylesheet" href="../css/bootstrap.css">
  <script src="../includes/render_nav.js"></script>
</head>
<body>
  <?php require_once __DIR__ . '/../includes/header.php';?>
    <nav id="navbar">Loading Navigation bar...</nav>
    <section class ="vh-100">

<div class="container">
  <h2>Contact Form</h2>
  <?php if (isset($success_message)) : ?>
    <div class="alert alert-success" role="alert">
      <?php echo $success_message; ?>
    </div>
  <?php endif; ?>
  <?php if (isset($error_message)) : ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $error_message; ?>
    </div>
  <?php endif; ?>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <div class="form-group">
      <label for="contact_message">Message:</label>
      <textarea class="form-control" id="contact_message" name="contact_message" rows="5" required></textarea>
    </div>
<br>    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  </form>
</div>

</section>
</body>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>
