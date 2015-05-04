<?php
session_start();
include "dbconnect.php";

//Check if user or admin is logged in - send them to the correct page.

if (isset($_SESSION['username'])) {
    if (($_SESSION['access'] == 0)) {
        header('Location: loginsuccess.php');
    }
    if (($_SESSION['access'] == 1)) {
        header('Location: adminsuccess.php');
    }
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "LoginUser";
            loginUser($mysqli);
            break;
    }
}

//Check login, and if it is user or admin.
function loginUser($mysqli) {
    $Tempusername = $_POST['username'];
    $Temppassword = $_POST['password'];

    $result = $mysqli->query("select * from users");
    while ($row = $result->fetch_row()) {
        if ($Tempusername == $row[1] && $Temppassword == $row[5] && $row[6] == 0) {
            $_SESSION['username'] = $Tempusername;
            $_SESSION['id'] = $row[0];
            $_SESSION['access'] = $row[6];
            header("location:loginsuccess.php");
            break;
        }
        if ($Tempusername == $row[1] && $Temppassword == $row[5] && $row[6] == 1) {
            $_SESSION['username'] = $Tempusername;
            $_SESSION['id'] = $row[0];
            $_SESSION['access'] = $row[6];
            header("location:adminsuccess.php");
            break;
        }
    }
    echo "<p class='tryagain'>Wrong, try again</p>";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Booking system Lygten 37</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="customContainer">
            <header class="header">
                <nav class="navbar navbar-default navbar-top" role="navigation">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-5">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <p class="navbar-brand">Lygten 37</p>
                        </div>
                        <div class="collapse navbar-collapse">
                            <p class="navbar-text navbar-right"></p>
                        </div>
                    </div>
                </nav>
            </header>
            <div class="sectionOne">
                <form class="shake" action="?action=LoginUser" method="post">
                    <input class="form-control customInput" type="text" placeholder="Username" name="username">
                    <input class="form-control customInput" type="password" placeholder="Password" name="password" password>
                    <input class="btn customBtn" type="submit" value="Login">
                    <a href="createUser.php" class="btn customBtn">Create user</a>
                </form>   
            </div>

            <footer class="footer">
            </footer>
        </div>
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    </body>
</html>
