<?php 

require_once __DIR__ . '/../database/db_config.php';
require_once __DIR__ . '/../includes/header.php';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Management Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../includes/render_nav.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<body>
    <nav id="navbar">Loading Navigation bar...</nav>
    <section >
  


<div class="container">

        <div class="mt-4">
            <h1>Search Submissions</h1>
            <input type="text" id="searchBar" placeholder="Search usernames...">
            <script src="search_for_all_submissions.js"></script>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date Of Submission</th>
                        <th>Description</th>
                        <th>Verified</th>
                        <th>Evidence attachment</th>
                    </tr>
                </thead>
                <tbody id="submissions-tbody">
                    
                </tbody>
            </table>
        </div>
        <br><br><br><br><br><br>
        </div>
    </section>
</body>
<?php require("Script.php")?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</html>
