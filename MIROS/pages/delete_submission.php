<?php 
session_start();
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav_bar.php'; 

$submissions = Delete();

function Delete(){
    
    $servername = "localhost";
    $dbname = "miros";
    $username = "root";
    $password = "";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn->prepare("SELECT * FROM submissions WHERE Submission_ID = :sub_id");
    $stmt->bindParam(':sub_id', $_GET['Submission_ID'], SQLITE3_TEXT);
    $stmt->execute();
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $submissions = $result;

    return $submissions;
}

if (isset($_POST['delete'])){

    $servername = "localhost";
    $dbname = "miros";
    $username = "root";
    $password = "";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = "DELETE FROM submissions WHERE Submission_ID = :sub_id";
    $sql = $conn->prepare($stmt);
    $sql->bindParam(':sub_id', $_GET['Submission_ID'], SQLITE3_TEXT);

    $sql->execute();
    header("Location:submission_overview.php");
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
        <div class="container mt-5">
            <?php foreach ($submissions as $submission): ?>
                    <h2>Submission Deletion</h2>
                        <div class="input">
                            <label style="font-weight:bold">Submission ID: </label>
                            <?php echo htmlspecialchars($submission['Submission_ID']); ?><br>

                            <label style="font-weight:bold">User ID: </label>
                            <?php echo htmlspecialchars($submission['User_ID']); ?></td><br>

                            <label style="font-weight:bold">Description: </label>
                            <?php echo htmlspecialchars($submission['Description']); ?></td><br>

                            <label style="font-weight:bold">Date of Submission: </label>
                            <?php echo htmlspecialchars($submission['Date_Of_Submission']); ?><br>

                            <label style="font-weight:bold">Evidence Attachment: </label>
                            <?php echo htmlspecialchars($submission['Evidence_attachment']); ?><br>

                            <label style="font-weight:bold">Verification: </label>
                            <?php echo htmlspecialchars($submission['Verified']); ?><br>
                        </div>
            <?php endforeach; ?>
        </div>
        <div>
            <form method="post" class="form">
                <input type="hidden" name="pat_id" value="<?php echo $_GET['Submission_ID']?>"><br>
                <p class="sub-title" style="color:red">Would you like delete this submission?</p>
                <button class="button" type="submit" value="delete" name="delete">Delete</button><br>
            </form>
        </div>
    </section>
</body>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>