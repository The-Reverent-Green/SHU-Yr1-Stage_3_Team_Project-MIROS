<?php

require_once __DIR__ . '/../database/db_config.php'; 

$officers = [];
$supervisors = [];
$successMessage = "";

$usersWithoutSupervisors = [];

try {
    $getUsersWithoutSupervisors = "SELECT User_ID, username, First_Name, Last_Name FROM user WHERE Reports_To IS NULL";
    $noSupervisorStmt = $mysqli->query($getUsersWithoutSupervisors);
    while ($row = $noSupervisorStmt->fetch_assoc()) {
        $usersWithoutSupervisors[] = $row;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

if(isset($mysqli) && $mysqli instanceof mysqli) {
    try {
        $getOfficers = "SELECT User_ID, username FROM user WHERE role = 'Research Officer'";
        $officerStmt = $mysqli->query($getOfficers);
        while ($row = $officerStmt->fetch_assoc()) {
            $officers[] = $row;
        }
        
        $getSupervisors = "SELECT User_ID, username FROM user WHERE role = 'Supervisor'";
        $supervisorStmt = $mysqli->query($getSupervisors);
        while ($row = $supervisorStmt->fetch_assoc()) {
            $supervisors[] = $row;
        }

        if(isset($_POST['assign'])) {
            $officerUserID = $_POST['officerUsername'];
            $supervisorUserID = $_POST['supervisorUsername']; 

            $assignOfficerToSupervisor = "UPDATE user SET Reports_To = ? WHERE User_ID = ?";
            $assignStmt = $mysqli->prepare($assignOfficerToSupervisor);
            $assignStmt->bind_param("ii", $supervisorUserID, $officerUserID);
            $assignStmt->execute();
            
            $successMessage = "Officer has been assigned to Supervisor successfully!";
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
    <title>Assign Officer to Supervisor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/nav_bar.css"></head>
    <script src="../includes/render_nav.js"></script>

<body>
<?php require_once __DIR__ . '/../includes/header.php';?>
<nav id="navbar">Loading Navigation bar...</nav>
    <section class="vh-100">
        <div class="container mt-5">
            <?php if(!empty($successMessage)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $successMessage; ?>
                </div>
            <?php endif; ?>
            
            <div class="wrapper">
                <h2>Assign Officer to Supervisor</h2>
                <form method="post" action="">
                    <label>Select Officer:</label><br>
                    <select name="officerUsername" required>
                        <?php foreach($officers as $officer): ?>
                            <option value="<?php echo $officer['User_ID']; ?>"><?php echo $officer['username']; ?></option>
                        <?php endforeach; ?>
                    </select><br><br>

                    <label>Select Supervisor:</label><br>
                    <select name="supervisorUsername" required>
                        <?php foreach($supervisors as $supervisor): ?>
                            <option value="<?php echo $supervisor['User_ID']; ?>"><?php echo $supervisor['username']; ?></option>
                        <?php endforeach; ?>
                    </select><br><br>

                    <input type="submit" value="Assign Officer" name="assign" class="btn btn-primary">
                </form>
            </div>
        </div>

        <div class="wrapper">
                <h2>Users Without Supervisors</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($usersWithoutSupervisors as $user): ?>
                            <tr>
                                <td><?php echo $user['User_ID']; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo $user['First_Name']; ?></td>
                                <td><?php echo $user['Last_Name']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <?php require("Script.php")?>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
