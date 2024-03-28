<?php 
session_start();
include('../includes/nav_bar.php');
include __DIR__ . '/../database/db_config.php';

$sql = "SELECT * FROM submissions";
$result = $mysqli->query($sql);
$submissions = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

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
    <div class="container" style="margin-top: 50px">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Submission ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Date of Submission</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Publication URL</th>
                    <th scope="col">Evidence Attachment</th>
                </tr>
            </thead>
            <?php foreach ($submissions as $submission): ?>
                <tr>
                    <th><?php echo htmlspecialchars($submission['Submission_ID']); ?></th>
                    <td><?php echo htmlspecialchars($submission['User_ID']); ?></td>
                    <td><?php echo htmlspecialchars($submission['Title']); ?></td>
                    <td><?php echo htmlspecialchars($submission['Date_Of_Submission']); ?></td>
                    <td><?php echo htmlspecialchars($submission['Deadline']); ?></td>
                    <td><?php echo htmlspecialchars($submission['Publication_URL']); ?></td>
                    <td><?php echo htmlspecialchars($submission['Evidence_attachment']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>