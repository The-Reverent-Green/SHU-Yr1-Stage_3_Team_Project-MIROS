<!doctype html>
<html lang="en">

  <?php
    if (isset($_POST['submit'])){
        header("Location:../php/homeOfficer.php");
    }
  ?>

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/site.css">

  </head>

  <body>

    <nav class="navbar navbar-expand-sm sticky-top navbar-light bg-black">
        <div class="container-fluid justify-content-center">
            <a href="index.php" class="navbar-brand mb-0 h1">
                <img class="d-inline-block align-top" src="../assets/logo.png" height="65"/>
            </a>
        </div>
    </nav>

    <div class="container" style="margin-top: 50px">
        <div class="row">
            <div class="col">
                <img src="../assets/road.jpeg" class="rounded float-left" height="450">
            </div>

    <div class="col" style="font-family: lato; font-weight: bold">
        <h2 style="text-align: center; font-weight: bold; margin-top: 10px">Welcome to the MIROS Employee Management System.</h2><br>
            <div class="row">
                <form method="post" class="form" style="text-align: center; margin-top: 5px">
                    <label class="input"><h4 style="font-weight: bold">Username</h4></label><br>
                    <input class= "form-control-lg" type = "text" id = "user" name = "user"><br>
                    <label class="input"><h4 style="font-weight: bold; margin-top: 10px">Password</h4></label><br>
                    <input class="form-control-lg" type = "password" id = "pass" name = "pass"><br>
                    <button class="btn btn-warning" type="submit" value="login" name="submit" style="font-weight: bold; margin-top: 15px; margin-bottom: 35px">Sign-In</button><br>
                    <a href="../html/passwordReset.html">Forgotten Password?</a><br>
                    <a href="../html/accountCreation.html">Sign-Up</a>
                    <br>
                    <a href="../php/database_test.php">Database George Test</a>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
  </body>
</html>