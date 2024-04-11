<?php 
session_start();
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav_bar.php'; 
include __DIR__ . '/../database/db_config.php';

$sql = "SELECT * FROM targets";
$result = $mysqli->query($sql);
$targets = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

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
    <section class="vh-100">
    <div class="container" style="margin-top: 50px">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Target ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Date of Submission</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Publication URL</th>
                    <th scope="col">Evidence Attachment</th>
                </tr>
            </thead>
            <?php foreach ($targets as $target): ?>
                <tr>
                    <th><?php echo htmlspecialchars($target['Target_ID']); ?></th>
                    <td><?php echo htmlspecialchars($target['User_ID']); ?></td>
                    <td><?php echo htmlspecialchars($target['Title']); ?></td>
                    <td><?php echo htmlspecialchars($target['Date_Of_Submission']); ?></td>
                    <td><?php echo htmlspecialchars($target['Deadline']); ?></td>
                    <td><?php echo htmlspecialchars($target['Publication_URL']); ?></td>
                    <td><?php echo htmlspecialchars($target['Evidence_attachment']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </section>
</body>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>