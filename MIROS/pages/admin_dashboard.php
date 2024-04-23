<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../database/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_status'])) {
        $contactId = $_POST['Contact_ID'];
        $newStatus = $_POST['Status'];
        $updateContactMsg = "UPDATE contact SET Status = ? WHERE Contact_ID = ?";
        $stmt = $mysqli->prepare($updateContactMsg);
        $stmt->bind_param("si", $newStatus, $contactId);
        $stmt->execute();
        $stmt->close();
    }
}

$sql = "SELECT Contact_ID, User_ID, First_Name, Last_Name, Contact_details, Email, Status
        FROM contact";
$result = $mysqli->query($sql);
$contactDetails = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../includes/render_nav.js"></script>
</head>
<body>
    <div class="container">
        <h2>Contact Messages</h2>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Contact ID</th>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Contact Details</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contactDetails as $contact): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contact['Contact_ID']); ?></td>
                            <td><?php echo htmlspecialchars($contact['User_ID']); ?></td>
                            <td><?php echo htmlspecialchars($contact['First_Name']); ?></td>
                            <td><?php echo htmlspecialchars($contact['Last_Name']); ?></td>
                            <td><?php echo htmlspecialchars($contact['Contact_details']); ?></td>
                            <td><?php echo htmlspecialchars($contact['Email']); ?></td>
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
    <script src="../js/interaction.js"></script>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
<?php require("Script.php") ?>
</html>
