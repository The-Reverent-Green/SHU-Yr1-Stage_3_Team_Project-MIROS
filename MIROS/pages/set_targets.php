<?php   

session_start();
require_once __DIR__ . '/../includes/header.php';

$servername = "localhost";
$dbname = "miros";
$username = "root";
$password = "";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$any_users_rithout_roles = "SELECT * FROM user_scores WHERE User_ID = :user_id";
$stmt = $conn->prepare($any_users_rithout_roles);
$stmt->bindParam(':user_id', $_GET['User_ID']);
$stmt->execute();
$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
$targets = $result;

if (isset($_POST['submit'])){

    $servername = "localhost";
    $dbname = "miros";
    $username = "root";
    $password = "";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $any_users_rithout_roles = "UPDATE user_scores SET Target_Score = :target WHERE User_ID = :user_id";
    $stmt = $conn->prepare($any_users_rithout_roles);
    $stmt->bindParam(':user_id',$_GET['User_ID']);
    $stmt->bindParam(':target',$_POST['post']);
    $stmt->execute();

    header('Location: employees.php');
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
        <div class="container mt-5">
            <?php foreach ($targets as $target): ?>
                <h2>Set Target</h2>
                    <form method="post" class="form">

                        <label class="input">Set a new target for User No. <?php echo htmlspecialchars($target['User_ID']); ?></label><br>
                        <input type = "text" id = "post" name = "post" value="<?php echo htmlspecialchars($target['Target_Score']); ?>"><br><br>
                        <button class="button" type="submit" value="Update" name="submit">Set Target</button><br>
                        <br><a href="employees.php">Back</a>

                    </form>
            <?php endforeach; ?>
        </div>
    </section>
</body>
<?php require("Script.php")?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>
