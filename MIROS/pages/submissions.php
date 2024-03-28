<?php 
session_start();
include('../includes/nav_bar.php');

$submissions = getSub();

function getSub(){
    
    $servername = "localhost";
    $dbname = "miros";
    $username = "root";
    $password = "";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(!isset($_POST['search'])){

        $stmt = $conn->prepare("SELECT * FROM submissions");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $submissions = $result;
    }

    else{
        if($_POST['search'] != ''){
            $search = $_POST['search'];
            $stmt = $conn->prepare("SELECT * FROM submissions WHERE Title LIKE :search");
            $stmt->bindvalue(':search', '%' . $search . '%');
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $submissions = $result;
        }
        else{
            $stmt = $conn->prepare("SELECT * FROM submissions");
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $submissions = $result;
        }
    }

    return $submissions;
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
<div class="container" style="margin-top: 20px">
        <form action="submissions.php" method="post">
            <label class="sub-title">Search for submissions: </label><br>
            <input type="text" id="search" name="search">
            <button class="button" type="submit" value="submit" name="submit">Search</button><br>
        </form>
    </div>
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