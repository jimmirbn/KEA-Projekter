<?php
session_start();
include "dbconnect.php";

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "addUser";
            AddUser($mysqli);
            break;
    }
}

//Create user, only if username is not taken.
function AddUser($mysqli) {
    $Tempusername = $_POST['username'];
    $Tempname = $_POST['name'];
    $Templastname = $_POST['lastname'];
    $Tempmail = $_POST['email'];
    $Temppassword = $_POST['password'];

    $result = $mysqli->query("SELECT * FROM users WHERE username='" . $_POST['username'] . "'");
    $numberOfRows = mysqli_num_rows($result);
    if ($numberOfRows > 0) {
        echo "<p class='userError'>The username is already taken, please choose different</p>";
    } else {
        $mysqli->query("INSERT INTO users(username,name,lastname,email,password) VALUES('$Tempusername','$Tempname','$Templastname','$Tempmail', '$Temppassword')");
        header('Location: index.php');
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Create User</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <!--Send the string 'q' to checkUser.php-->
        <script>
            function showHint(str)
            {
                if (str.length == 0)
                {
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                }
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "checkUser.php?q=" + str, true);
                xmlhttp.send();
            }
        </script>
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
                            <a href="index.php"><p class="navbar-brand">Lygten 37</p></a>
                        </div>
                        <div class="collapse navbar-collapse">
                            <p class="navbar-text navbar-right"></p>
                        </div>
                    </div>
                </nav>
            </header>

            <div class="sectionOne">
                <form action="?action=addUser" method="post" class="createForm">
                    <input class="form-control customInput usernameInput" type="text" placeholder="Username" name="username" onblur="showHint(this.value)" required="">
                    <span id="txtHint"></span>
                    <div class="row"></div>
                    <input class="form-control customInput" type="text" placeholder="Name" name="name" required>
                    <div class="row"></div>
                    <input class="form-control customInput" type="text" placeholder="Lastname" name="lastname" required>
                    <div class="row"></div>
                    <input class="form-control customInput" type="text" placeholder="E-mail" name="email" required>
                    <div class="row"></div>
                    <input class="form-control customInput" type="text" placeholder="Password" name="password" required="">
                    <div class="row"></div>
                    <input class="btn btn-success" type="submit" value="Done"> 
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </form>
            </div>

            <footer class="footer">
                <nav class="navbar navbar-default navbar-bottom doNotshowMe" role="navigation">
                    <div class="">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-bottom">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="navbar-collapse collapse" id="nav-bottom" style="height: 1px;">
                            <ul class="nav navbar-nav">
                                <li><a href="index.php" <span class="glyphicon glyphicon-home"></span>Home</a></li>
                                <li class="border-left"><a href="booking.php"<span class="glyphicon glyphicon-user"></span>Profile</a></li>
                                <li class="border-left"><a href="#"<span class="glyphicon glyphicon-th-list"></span>Booking</a></li>
                                <li class="border-left"><a href="#"<span class="glyphicon glyphicon-calendar"></span>Calendar</a></li>
                                <li class="border-left"><a href="topten.php"<span class="glyphicon glyphicon-heart"></span>Top 10's</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </footer>
        </div>
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
