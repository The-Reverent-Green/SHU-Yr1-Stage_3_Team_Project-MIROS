<?php
include __DIR__ . '/../database/db_config.php'; // Include db_config.php file

// Check if the database connection object is set and not null
if(isset($mysqli) && $mysqli instanceof mysqli) {
    try {
        // Fetch usernames from the database
        $usernames = [];
        $stmt = $mysqli->query("SELECT username FROM user");
        while ($row = $stmt->fetch_assoc()) {
            $usernames[] = $row['username'];
        }

        // Handle form submission
        if(isset($_POST['submit'])) {
            // Get the selected username and new role from the form submission
            $selectedUsername = $_POST['username'];
            $newRole = $_POST['role']; // Assuming you have a form field named 'role' for selecting the new role
            
            // Update the user's role in the database
            $updateStmt = $mysqli->prepare("UPDATE user SET role = ? WHERE username = ?");
            $updateStmt->bind_param("ss", $newRole, $selectedUsername);
            $updateStmt->execute();
            
            // Display a success message
            $successMessage = "User role updated successfully!";
        }
    } catch(Exception $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle case where $mysqli is not set or not an instance of mysqli
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
   
</head>
<body>
<?php   
    require_once __DIR__ . '/../includes/header.php';
    require_once __DIR__ . '/../includes/nav_bar.php'; ?>
    <section class ="vh-100">
    <div class="container mt-5">
        <?php if(isset($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        
        <div class="wrapper">
            <h2>Change User Role</h2>
            <form method="post" action="">
                <label>Select User:</label><br>
                <!-- Dropdown menu for selecting the username -->
                <select name="username" required>
                    <?php foreach($usernames as $username): ?>
                        <option value="<?php echo $username; ?>"><?php echo $username; ?></option>
                    <?php endforeach; ?>
                </select><br><br>
                
                <label>Select New Role:</label><br>
                <!-- Radio buttons for selecting the new role -->
                <input type="radio" id="role1" name="role" value="Research Officer" required>
                <label for="role1">Research Officer</label><br>
                
                <input type="radio" id="role2" name="role" value="Supervisor" required>
                <label for="role2">Supervisor</label><br>
                
                <input type="radio" id="role3" name="role" value="Top Manager" required>
                <label for="role3">Top Manager</label><br>
                
                <!-- Add more radio buttons for other roles as needed -->
                
                <br>
                <input type="submit" value="Change Role" name="submit" class="btn btn-primary">
            </form>
        </div>
    </div>
    </section>
</body>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>
