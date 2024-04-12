<?php
require_once __DIR__ . '/../database/db_config.php';
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

$required_role = "admin"; 
if ($_SESSION["role"] !== $required_role) {
    header("Location: access_denied.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shutdown MySQL Server</title>
    <link rel="stylesheet" href="bootstrap.css">
</head>
<body>

<?php   require_once __DIR__ . '/../includes/header.php';
    require_once __DIR__ . '/../includes/nav_bar.php';  ?>

<div class="container">
    <br>
    <h2>Shutdown MySQL Server</h2>

    <form method="post">
        <button type="submit" name="shutdown" class="btn btn-danger">Shutdown MySQL</button>
    </form>

    <?php
    if(isset($_POST['shutdown'])) {
        exec("net stop MySQL", $output, $return);
        if($return == 0) {
            echo '<div class="alert alert-success" role="alert">MySQL server shutdown successfully.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to shutdown MySQL server.</div>';
        }
    }
    ?>
</div>

</body>
</html>
