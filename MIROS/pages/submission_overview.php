<?php 
session_start();
    require_once __DIR__ . '/../includes/header.php';
    require_once __DIR__ . '/../includes/nav_bar.php'; 

$submissions = mySub();

function mySub(){

    $servername = "localhost";
    $dbname = "miros";
    $username = "root";
    $password = "";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(!isset($_POST['search'])){

        $id = $_SESSION['id'];
        $stmt = $conn->prepare("SELECT * FROM submissions INNER JOIN user on submissions.User_ID = user.User_ID WHERE Reports_To = :id AND Verified = 'no'");
        $stmt->bindvalue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $submissions = $result;
    }

    else{
        if($_POST['search'] != ''){

            $id = $_SESSION['id'];
            $search = $_POST['search'];
            $stmt = $conn->prepare("SELECT * FROM submissions INNER JOIN user on submissions.User_ID = user.User_ID WHERE Reports_To = :id AND Verified = 'no' AND Description LIKE :search");
            $stmt->bindvalue(':search', '%' . $search . '%');
            $stmt->bindvalue(':id', $id);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $submissions = $result;
        }
        else{
            $id = $_SESSION['id'];
            $stmt = $conn->prepare("SELECT * FROM submissions INNER JOIN user on submissions.User_ID = user.User_ID WHERE Reports_To = :id AND Verified = 'no'");
            $stmt->bindvalue(':id', $id);
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
    <section class="vh-100">
<div class="container" style="margin-top: 20px">
        <form action="submission_overview.php" method="post">
            <label class="sub-title">Search for submissions: </label><br>
            <input type="text" id="search" name="search">
            <button class="button" type="submit" value="submit" name="submit">Search</button><br>
        </form>
    </div>
    <div class="container" style="margin-top: 50px; padding-bottom: 75px;">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Submission ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date of Submission</th>
                    <th scope="col">Evidence Attachment</th>
                    <th scope="col">Verified</th>
                    <th scope="col">Actions</th>
                    <th scope="col">&#160;</th>
                </tr>
            </thead>
            <?php foreach ($submissions as $submission): ?>
                <tr>
                    <th><?php echo htmlspecialchars($submission['Submission_ID']); ?></th>
                    <td><?php echo htmlspecialchars($submission['User_ID']); ?></td>
                    <td><?php echo htmlspecialchars($submission['Description']); ?></td>
                    <td><?php echo htmlspecialchars($submission['Date_Of_Submission']); ?></td>
                    <td><?php echo htmlspecialchars($submission['Evidence_attachment']); ?></td>
                    <td><?php echo htmlspecialchars($submission['Verified']); ?></td>
                    <td><a href="submission_verification.php?Submission_ID=<?php echo htmlspecialchars($submission['Submission_ID']); ?>">Verify</a></td>
                    <td><a href="delete_submission.php?Submission_ID=<?php echo htmlspecialchars($submission['Submission_ID']); ?>">Delete</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </section>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>