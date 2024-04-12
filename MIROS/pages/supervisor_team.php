<?php 
session_start();  
require_once __DIR__ . '/../includes/header.php';

$users = myEmp();

function myEmp(){
    
    $servername = "localhost";
    $dbname = "miros";
    $username = "root";
    $password = "";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $id = $_SESSION['id'];
    $stmt = $conn->prepare("SELECT * FROM user INNER JOIN user_scores on user.User_ID = user_scores.User_ID WHERE Reports_To = :id ORDER BY Total_Score DESC");
    $stmt->bindvalue(':id', $id);
    $stmt->execute();
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $users = $result;

    return $users;
}

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
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        </style>
</head>

<body>
    <nav id="navbar">Loading Navigation bar...</nav>
    <section class="vh-100">
    <div class="container" style="margin-top: 30px; padding-bottom: 75px;">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                    <th scope="col">User Score</th>
                </tr>
            </thead>
            <?php foreach ($users as $user): ?>
                <tr>
                    <th><?php echo htmlspecialchars($user['User_ID']); ?></th>
                    <td><?php echo htmlspecialchars($user['First_Name']); ?></td>
                    <td><?php echo htmlspecialchars($user['Last_Name']); ?></td>
                    <td><?php echo htmlspecialchars($user['Date_of_birth']); ?></td>
                    <td><?php echo htmlspecialchars($user['Email']); ?></td>
                    <td><?php echo htmlspecialchars($user['ROLE']); ?></td>
                    <td><?php echo htmlspecialchars($user['account_status']); ?></td>
                    <td><?php echo htmlspecialchars($user['Total_Score'] . "/" . $user['Target_Score']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </section>
</body>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>