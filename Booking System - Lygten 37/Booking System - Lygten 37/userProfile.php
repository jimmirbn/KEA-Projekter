<?php
session_start();
include "dbconnect.php";

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
}

$result = $mysqli->query("select * from users where id=" . $_SESSION['id']);
while ($row = $result->fetch_row()) {
    $name = $row[2];
    $lastname = $row[3];
    $email = $row[4];
    $password = $row[5];
    $id = $row[0];
}

//Multiple cases

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "unsetUsername":
            unset($_SESSION['username']);
            header('Location: index.php');
            break;

        case "deleteBooking";
            $mysqli->query("delete FROM bookedRoom where id=" . $_GET["id"]);
            break;

        case "updateUser";
            $str = "update users set name='" . $_POST['name'] . "', lastname='" . $_POST['lastname'] . "', email='" . $_POST['email'] . "', password='" . $_POST['password'] . "' where id='" . $_POST['id'] . "'";
            $mysqli->query($str);
            header('Location: userProfile.php');
            break;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Profile</title>
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
                <div class="boxLeft">
                    <form action="?action=updateUser" method="post">
                        <input class="form-control marginbottom20" name="name" value="<?php echo $name ?>">
                        <input class="form-control marginbottom20" name="lastname" value="<?php echo $lastname ?>">
                        <input class="form-control marginbottom20" name="email" value="<?php echo $email ?>">
                        <input class="form-control marginbottom20" name="password" value="<?php echo $password ?>">
                        <input class="form-control marginbottom20" type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>">
                        <input class="btn btn-primary customBtn" value="Edit" type="submit">
                    </form>
                </div>
                <div class="boxRight">
                    <h4 class="white">Bookings</h4>
                    <?php
                    $result2 = $mysqli->query("select room.roomname, bookedRoom.id, start_time, end_time, bookedBy, date from room, bookedRoom where bookedBy = '" . $_SESSION['id'] . "' and bookedRoom.room_id = room.id group by bookedRoom.id");

                    $numberOfRows = mysqli_num_rows($result2);
                    while ($row = $result2->fetch_row()) {
                        $roomname = $row[0];
                        $id = $row[1];
                        $et = $row[3];
                        $st = $row[2];
                        $date = $row[5];
                        if ($numberOfRows < 0) {
                            echo "";
                        }
                        if ($numberOfRows > 0) {
                            echo "<div class='black-ops marginbottom20'><p class='white inline'>$roomname booked from $st to $et the $date</p><a title='Delete booking' class='margintop6 btn btn-danger' href='?action=deleteBooking&id=$id'>X</a></div>";
                        }
                    }
                    ?>
                </div>
            </div>

            <footer class="footer">
                <nav class="navbar navbar-default navbar-fixed-bottom showMe" role="navigation">
                    <div class="">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-bottom">
                                <span class = "sr-only">Toggle navigation</span>
                                <span class = "icon-bar"></span>
                                <span class = "icon-bar"></span>
                                <span class = "icon-bar"></span>
                            </button>
                        </div>

                        <div class = "navbar-collapse collapse" id = "nav-bottom" style = "height: 1px;">
                            <ul class = "nav navbar-nav">
                                <li><a href = "index.php" <span class = "glyphicon glyphicon-home"></span>Home</a></li>
                                <li class = "border-left"><a href = "userProfile.php"<span class = "glyphicon glyphicon-user"></span>Profile</a></li>
                                <li class = "border-left"><a href = "booking.php"<span class = "glyphicon glyphicon-th-list"></span>Booking</a></li>
                                <li class = "border-left"><a href = "userRooms.php"<span class = "glyphicon glyphicon-th"></span>Rooms</a></li>
                                <li class = "border-left"><a href = "toptenUser.php"<span class = "glyphicon glyphicon-heart"></span>Top 10's</a></li>
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