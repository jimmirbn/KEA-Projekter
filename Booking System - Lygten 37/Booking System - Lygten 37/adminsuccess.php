<?php
session_start();
include "dbconnect.php";

$UserID = $_SESSION['id'];

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
}


if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "unsetUsername":
            unset($_SESSION['username']);
            header('Location: index.php');
            break;

        case "deleteBooking";
            $mysqli->query("delete FROM bookedRoom where id=" . $_GET["id"]);
            break;
    }
}

//Show all deleted bookings form all users.
function showDeleted($mysqli) {
    $result = $mysqli->query("select start_time, end_time, bookedBy, orig_date, name from deletedBookings, users where bookedBy = users.id");
    while ($row = $result->fetch_row()) {
        $et = $row[1];
        $st = $row[0];
        $date = $row[3];
        $name = $row[4];
        echo "<div class='marginbottom20'><p class='white inline'>Booked from $st to $et the $date By $name</p></div>";
    }
}

//A procedure that shows the booked rooms from the logged user. - see line 5
function showBookings($mysqli) {
    $UserID = $_SESSION['id'];
    $result = $mysqli->query("CALL getbookedrooms($UserID)");
    $numberOfRows = mysqli_num_rows($result);
    while ($row = $result->fetch_row()) {
        $roomname = $row[0];
        $id = $row[1];
        $et = $row[3];
        $st = $row[2];
        $date = $row[5];

        if ($numberOfRows < 0) {
            echo "";
        }
        if ($numberOfRows > 0) {
            echo "<div class='marginbottom20 bookingsView'><p class='white inline'>$roomname booked from $st to $et the $date</p><a title='Delete booking' class='margintop6 btn btn-danger' href='?action=deleteBooking&id=$id'>X</a></div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Login Success</title>
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
                <div class="boxLeft black-ops overflow">
                    <h4 class="white">All deleted bookings</h4>
                    <?php
                    showDeleted($mysqli);
                    ?>
                </div>
                <div class="boxRight2 black-ops">

                    <h4 class="white">Your bookings</h4>
                    <?php
                    showBookings($mysqli);
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
    </body>
</html>