<?php 
session_start();  
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav_bar.php'; 

$role = array("Select", "Research Officer", "Supervisor", "Top Manager");
$users = getEmp();

function getEmp(){
    
    $servername = "localhost";
    $dbname = "miros";
    $username = "root";
    $password = "";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(!isset($_POST['filterEmp'])){

        $stmt = $conn->prepare("SELECT * FROM user INNER JOIN user_scores on user.User_ID = user_scores.User_ID");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $users = $result;
    }

    else{
        if($_POST['filterEmp'] != 'Select'){

            $role = $_POST['filterEmp'];
            $stmt = $conn->prepare("SELECT * FROM user INNER JOIN user_scores on user.User_ID = user_scores.User_ID WHERE Role = :role");
            $stmt->bindvalue(':role', $role);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $users = $result;
        }
        else{

            $stmt = $conn->prepare("SELECT * FROM user INNER JOIN user_scores on user.User_ID = user_scores.User_ID");
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $users = $result;
        }
    }
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
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>

<body>
    <section class="vh-100">
<div class="container" style="margin-top: 20px">
        <form class="form" method="post">
            <label class="sub-title">Filter Employee by Role: </label><br>
                <select class="custom-select" type="text" name="filterEmp">
                    <?php for ($i=0; $i<count($role); $i++): ?>
                    <option <?php if (isset($_POST['filterEmp']) && ($role[$i]==$_POST['filterEmp'])) echo "selected"; ?>  ><?php echo $role[$i];?></option>
                    <?php endfor; ?>
                </select>
            <button class="button" type="submit" value="filter" name="submit">Filter</button><br>
        </form>
    </div>
    <div class="container" style="margin-top: 30px; padding-bottom: 75px;">
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
                    <th scope="col">User Score</th>
                    <th scope="col">Targets</th>
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
                    <td><?php echo htmlspecialchars($user['Reports_To']); ?></td>
                    <td><?php echo htmlspecialchars($user['account_status']); ?></td>
                    <td><?php echo htmlspecialchars($user['Total_Score']) . "/" . ($user['Target_Score']); ?></td>
                    <td><a href="set_targets.php?User_ID=<?php echo htmlspecialchars($user['User_ID']); ?>">Set</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
    </section>
</body>
</html>