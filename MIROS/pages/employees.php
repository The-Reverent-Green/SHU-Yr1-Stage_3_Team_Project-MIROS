<?php 
session_start();
include('../includes/nav_bar.php');
include __DIR__ . '/../database/db_config.php';

$sql = "SELECT * FROM user";
$result = $mysqli->query($sql);
$users = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

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
    <div class="container" style="margin-top: 30px">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">User_ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Reports To</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <?php foreach ($users as $user): ?>
                <tr>
                    <th><?php echo htmlspecialchars($user['User_ID']); ?></th>
                    <td><?php echo htmlspecialchars($user['First_Name']); ?></td>
                    <td><?php echo htmlspecialchars($user['Last_Name']); ?></td>
                    <td><?php echo htmlspecialchars($user['Date_of_birth']); ?></td>
                    <td><?php echo htmlspecialchars($user['Email']); ?></td>
                    <td><?php echo htmlspecialchars($user['Role']); ?></td>
                    <td><?php echo htmlspecialchars($user['Reports_To']); ?></td>
                    <td><?php echo htmlspecialchars($user['Status']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>