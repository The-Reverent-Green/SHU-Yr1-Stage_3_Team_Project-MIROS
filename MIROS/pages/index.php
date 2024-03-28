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
<body>

<?php require_once __DIR__ . '/../includes/nav_bar.php'; ?>

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


</body>
</html>
