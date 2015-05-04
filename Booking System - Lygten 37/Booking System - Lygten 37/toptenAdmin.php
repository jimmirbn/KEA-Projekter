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
        <title>Top 10</title>
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
                            <a href="index.php"><p class="navbar-brand">Lygten 37</p></a>
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
                <div class="divider"></div>
                <div class="boxLeft black-ops">
                    <h4 class="white">Most booked rooms</h4>
                    <?php
                    $result2 = $mysqli->query("SELECT * FROM alltop10asc");
                    echo "<div><table class='table table-hover'><thead><tr><th>Room name</th><th>Bookings</th></tr></thead>";

                    while ($row = $result2->fetch_row()) {
                        echo "<tr class=\"userTd\"><td>$row[0]</td><td>$row[1]</td></tr>";
                    }
                    echo "</table></div>";
                    ?>
                </div>
                <div class="boxRight3 black-ops">
                    <h4 class="white">Least booked rooms</h4>
                    <?php
                    $result3 = $mysqli->query("SELECT * FROM alltop10desc");
                    echo "<div><table class='table table-hover'><thead><tr><th>Room name</th><th>Bookings</th></tr></thead>";

                    while ($row = $result3->fetch_row()) {
                        echo "<tr class=\"userTd\"><td>$row[0]</td><td>$row[1]</td></tr>";
                    }
                    echo "</table></div>";
                    ?>
                </div>
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
                                <li class="border-left"><a href="userView.php"<span class="icon-users"></span>Users</a></li>
                                <li class="border-left"><a href="adminbooking.php"<span class="glyphicon glyphicon-th-list"></span>Booking</a></li>
                                <li class="border-left"><a href="adminRooms.php"<span class="glyphicon glyphicon-th"></span>Rooms</a></li>
                                <li class="border-left"><a href="toptenAdmin.php"<span class="glyphicon glyphicon-heart"></span>Top 10's</a></li>
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