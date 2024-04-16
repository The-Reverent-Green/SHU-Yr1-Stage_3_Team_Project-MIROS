<?php 
session_start();
require_once __DIR__ . '/../database/db_config.php';
require_once __DIR__ . '/../includes/header.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../includes/render_nav.js"></script>
    <script src="get_notifications.js"></script>
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        </style>
</head>

<body>
    <nav id="navbar">Loading Navigation bar...</nav>
    <section class="vh-100">
    <div class="container mt-5">
    <div class="jumbotron">
        <h1 class="display-4">Welcome to your supervisor dashboard, <?php echo htmlspecialchars($_SESSION["firstname"]); ?>!</h1> 
        <p class="lead">From here you can view your assigned research officers, view their performances and verify submissions.</p>
    </div>
    </section>
</body>    
<?php require("Script.php")?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>
