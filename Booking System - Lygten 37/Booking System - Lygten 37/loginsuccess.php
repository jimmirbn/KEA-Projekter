<?php
session_start();
include "dbconnect.php";

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "unsetUsername":
            unset($_SESSION['username']);
            header('Location: index.php');
            break;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login Success</title>
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
                            <form action="?action=unsetUsername" method="post">
                                <button class="btn btn-primary customBtn pull-right">Log Out</button>
                            </form>
                            <p class="navbar-text">Welcome <?php echo ($_SESSION['username']); ?></p>
                        </div>
                    </div>
                </nav>

            </header>

            <div class="sectionOne">
            </div>

            <footer class="footer">
                <nav class="navbar navbar-default navbar-fixed-bottom showMe" role="navigation">
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
                                <li class="border-left"><a href="userProfile.php"<span class="glyphicon glyphicon-user"></span>Profile</a></li>
                                <li class="border-left"><a href="booking.php"<span class="glyphicon glyphicon-th-list"></span>Booking</a></li>
                                <li class="border-left"><a href="userRooms.php"<span class="glyphicon glyphicon-th"></span>Rooms</a></li>
                                <li class="border-left"><a href="toptenUser.php"<span class="glyphicon glyphicon-heart"></span>Top 10's</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </footer>
        </div>
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    </body>
</html>