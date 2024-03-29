<?php require_once __DIR__ . '/../database/db_config.php'; 

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo "Please log in to access the website.";
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<?php   
    require_once __DIR__ . '/../includes/header.php';
    require_once __DIR__ . '/../includes/nav_bar.php'; ?>
<section class="vh-100">

    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Hello, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
            <p class="lead">It's good to see you again</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <a href="request_reset.php" class="btn btn-secondary btn-block">Reset Password</a>
                </div>
                <div class="mb-3">
                    <a href="logout.php" class="btn btn-danger btn-block">Sign Out</a>
                </div>
            </div>
        </div>
    </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
</body>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>
