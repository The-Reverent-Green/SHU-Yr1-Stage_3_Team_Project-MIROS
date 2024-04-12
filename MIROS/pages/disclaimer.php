<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../database/db_config.php'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Disclaimer</title>
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="../css/extra.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="../includes/render_nav.js"></script>
    
    </head>
    <body>
        <?php require_once __DIR__ . '/../includes/header.php';?>
        <nav id="navbar">Loading Navigation bar...</nav>
        <section class="vh-100">
            <div class ="disclaimer">
                <h3>Disclaimer</h3>
                <p>MIROS shall not be liable for any loss or damage caused by the use of the information obtained from this website.</p>
            </div>
        </section>
    </body>

    <?php require_once __DIR__ . '/../includes/footer.php'; ?>

</html>