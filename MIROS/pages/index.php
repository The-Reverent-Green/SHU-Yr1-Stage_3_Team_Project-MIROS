<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../database/db_config.php'; 

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo "Please log in to access the website.";
    header("location: login.php");
    exit;
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font: 14px sans-serif; text-align: center; }
        .wrapper { margin-top: 40px; }
        .newsletter { margin-top: 20px; }
        .my-5 { margin-top: 3rem!important; margin-bottom: 3rem!important; }
    </style>
</head>
<body>
<?php require_once __DIR__ . '/../includes/header.php';?>
<nav id="navbar">Loading Navigation bar...</nav>
<section>
    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Hello, <?= htmlspecialchars($_SESSION["username"]); ?>!</h1>
            <p class="lead">It's good to see you again.</p>
        </div>

        <div class="newsletter">
            <h2>New This Week at MIROS</h2>
            <div class="card">
                <div class="card-body">
                    <p class="card-text">
                        Stay updated with the latest initiatives and research at the Malaysian Institute of Road Safety. This week, we're excited to announce several new projects aimed at enhancing road safety nationwide. Key highlights include:
                    </p>
                    <ul>
                        <li><strong>Advanced Driver Assistance Systems (ADAS):</strong> We're rolling out a pilot program to test new technologies that help prevent accidents.</li>
                        <li><strong>Community Outreach:</strong> Join us for a series of workshops and talks across various communities to raise awareness about road safety practices.</li>
                        <li><strong>New Research Publication:</strong> Our latest research on urban road safety measures has been published. Check out our website to download the full report.</li>
                    </ul>
                    <p>For more information and to stay engaged with our efforts, visit our website or follow us on social media.</p>
                </div>
            </div>
        </div>
        
<div class="container mt-5">
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Submissions Over the Last 7 Days</h5>
          <canvas id="submissionsChart" width="400" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// This data should come from your database
const submissionsData = [
    { date: '2024-04-06', count: 10 },
    { date: '2024-04-07', count: 7 },
    { date: '2024-04-08', count: 14 },
    { date: '2024-04-09', count: 5 },
    { date: '2024-04-10', count: 8 },
    { date: '2024-04-11', count: 15 },
    { date: '2024-04-12', count: 11 }
];

const labels = submissionsData.map(entry => entry.date);
const data = submissionsData.map(entry => entry.count);

const chartData = {
    labels: labels,
    datasets: [{
        label: 'Submissions Over the Last 7 Days',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: data,
    }]
};

const config = {
    type: 'line',
    data: chartData,
    options: {}
};

const submissionsChart = new Chart(
    document.getElementById('submissionsChart'),
    config
);
</script>
</div>

        <div class="row justify-content-center my-5">
            <div class="col-md-6">
                <div class="mb-3">
                    <a href="request_reset.php" class="btn btn-secondary btn-block">Reset Password</a>
                </div>
                <div class="mb-3">
                    <a href="logout.php" class="btn btn-danger btn-block">Sign Out</a>
                </div>
            </div>
        </div>
    </div>
</section>








<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
