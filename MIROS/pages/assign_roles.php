<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../database/db_config.php'; 

if(isset($mysqli) && $mysqli instanceof mysqli) {
    try {
        $usernames = [];
        $getUsername = "SELECT username FROM user";
        $stmt = $mysqli->query($getUsername);
        while ($row = $stmt->fetch_assoc()) {
            $usernames[] = $row['username'];
        }

        if(isset($_POST['submit'])) {
            $selectedUsername = $_POST['username'];
            $newRole = $_POST['role']; 
            $updateUsersRole = "UPDATE user SET role = ? WHERE username = ?";
            $updateStmt = $mysqli->prepare($updateUsersRole);
            $updateStmt->bind_param("ss", $newRole, $selectedUsername);
            $updateStmt->execute();
            
            $successMessage = "User role updated successfully!";
        }
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Database connection not established.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change User Role</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../includes/render_nav.js"></script>

</head>
<body>
<?php   require_once __DIR__ . '/../includes/header.php';?>
<nav id="navbar">Loading Navigation bar...</nav>
<body>
    <section class="vh-100">
        <div class="container mt-5">
            <?php if(isset($successMessage)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $successMessage; ?>
                </div>
            <?php endif; ?>
            
            <div class="wrapper">
                <h2>Change User Role</h2>
                <form method="post" action="">
                    <input type="text" id="searchBar" placeholder="Search usernames...">
                    <div id="results"></div>
                    <label>Select User:</label><br>
                    <select id="usernameSelect" name="username" required></select><br><br>
                    <script src="../database/getUsernames.js"></script>

                    
                    <label>Select New Role:</label><br>
                    <input type="radio" id="role1" name="role" value="Research Officer" required>
                    <label for="role1">Research Officer</label><br>
                    
                    <input type="radio" id="role2" name="role" value="Supervisor" required>
                    <label for="role2">Supervisor</label><br>
                    
                    <input type="radio" id="role3" name="role" value="Top Manager" required>
                    <label for="role3">Top Manager</label><br>
                    
                    
                    <br>
                    <input type="submit" value="Change Role" name="submit" class="btn btn-primary">
                </form>
            </div>
        </div>
    </section>
</body>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>