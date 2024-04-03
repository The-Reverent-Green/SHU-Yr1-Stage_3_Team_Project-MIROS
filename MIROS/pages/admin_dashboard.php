<?php
require_once __DIR__ . '/../database/db_config.php'; 

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['roles'])) {
    foreach ($_POST['roles'] as $userId => $role) {
        if (!empty($role)) { // Only update if a role was selected
            $stmt = $mysqli->prepare("UPDATE user SET role = ? WHERE user_id = ?");
            $stmt->bind_param("si", $role, $userId);
            $stmt->execute();
            $stmt->close();
        }
    }
}

$sql = "SELECT user_id, username, first_name, last_name, last_log_in FROM user WHERE role IS NULL";
$result = $mysqli->query($sql);
$users = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Fetch contact details
$sqlContact = "SELECT Contact_ID, User_ID, contact_message, contact_email, First_Name, Last_Name, Status FROM contact WHERE Status = 'Opened'";
$resultContact = $mysqli->query($sqlContact);
$contactDetails = $resultContact ? $resultContact->fetch_all(MYSQLI_ASSOC) : [];

// Check if the status update form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $contactId = $_POST['Contact_ID'];
    $newStatus = $_POST['Status'];

    // Prepare the update statement
    $stmt = $mysqli->prepare("UPDATE contact SET Status = ? WHERE Contact_ID = ?");
    $stmt->bind_param("si", $newStatus, $contactId);
    $stmt->execute();
    $stmt->close();
    
    // Refresh the contact details to reflect the update
    $sqlContact = "SELECT Contact_ID, User_ID, contact_message, contact_email, First_Name, Last_Name, Status FROM contact WHERE Status != 'Closed'";
    $resultContact = $mysqli->query($sqlContact);
    $contactDetails = $resultContact ? $resultContact->fetch_all(MYSQLI_ASSOC) : [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage User Roles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">    
</head>
<body>
    <?php   
        require_once __DIR__ . '/../includes/header.php';
        require_once __DIR__ . '/../includes/nav_bar.php'; 
    ?>
    <section class ="vh-100">
        <div class="container">
            <h2>Manage User Roles</h2>
            <form method="POST">
                <?php if (!empty($users)): ?>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Last Login</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['last_log_in']); ?></td>
                                        <td>
                                            <select class="form-select" name="roles[<?php echo $user['user_id']; ?>]">
                                                <option value="">Select Role</option>
                                                <option value="Research Officer">Research Officer</option>
                                                <option value="Supervisor">Supervisor</option>
                                                <option value="Top Manager">Top Manager</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Update Roles</button>
                    </div>
                <?php else: ?>
                    <p class="text-center">No users with missing roles found.</p>
                <?php endif; ?>
            </form>
        </div>

        <!-- Contact Details Section -->
        <div class="container">
            <h2>Contact Messages</h2>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Contact ID</th>
                            <th>User ID</th>
                            <th>Contact Message</th>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Status</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contactDetails as $contact): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($contact['Contact_ID']); ?></td>
                                <td><?php echo htmlspecialchars($contact['User_ID']); ?></td>
                                <td><?php echo htmlspecialchars($contact['contact_message']); ?></td>
                                <td><?php echo htmlspecialchars($contact['contact_email']); ?></td>
                                <td><?php echo htmlspecialchars($contact['First_Name']); ?></td>
                                <td><?php echo htmlspecialchars($contact['Last_Name']); ?></td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="Contact_ID" value="<?php echo $contact['Contact_ID']; ?>">
                                        <select class="form-select" name="Status" style="width: 200px;">
                                            <option value="Opened" <?php echo $contact['Status'] == 'Opened' ? 'selected' : ''; ?>>Opened</option>
                                            <option value="In Progress" <?php echo $contact['Status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                            <option value="Closed" <?php echo $contact['Status'] == 'Closed' ? 'selected' : ''; ?>>Closed</option>
                                        </select>
                                </td>
                                <td>
                                    <button type="submit" name="update_status" class="btn btn-secondary btn-sm">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>
