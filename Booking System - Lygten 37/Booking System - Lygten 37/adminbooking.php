<?php
session_start();
include "dbconnect.php";

//Check if user is logged in.
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "unsetUsername":
            unset($_SESSION['username']);
            header('Location: index.php');
            break;

        case "bookRoom":
            BookRoom($mysqli);
            break;
    }
}

//Book room, and check if more than one does is at the same time.
function BookRoom($mysqli) {
    $date = $_POST['date'];
    $roomID = $_POST["roomID"];
    $time_start = $_POST["time_start"];
    $time_end = $_POST["time_end"];
    $mysqli->query("start transaction");
    $mysqli->query("INSERT INTO bookedRoom(room_id,start_time,end_time,bookedBy,date) VALUES('$roomID','$time_start','$time_end','" . $_SESSION['id'] . "', '$date')");
    $mysqli->query("commit");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AdminBooking</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/jquery.datetimepicker.css">
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
            <div class="sectionHeader margintop20">
                <button class="btn btn-info allBookings" data-toggle="modal" data-target="#allBookings">All Bookings</button>
            </div>

            <div class="sectionOne">
                <div class="divider"></div>
                <div class="boxLeft">
                    <form action="?action=bookRoom" id="bookingForm" method="POST" class="leftForm">
                        <input name="roomID" type="hidden" value="" id="roomID" required>
                        <div>
                            <span>How Many Persons?</span>
                            <select id="persons" class="form-control inline pull-right" name="rooms" required>
                                <option>Amount</option>
                                <option value='2'>2</option>
                                <option value='3'>3</option>
                                <option value='4'>4</option>
                                <option value='5'>5</option>
                                <option value='6'>6</option>
                                <option value='7'>7</option>
                                <option value='8'>8</option>
                                <option value='9'>9</option>
                                <option value='10'>10</option>
                            </select>
                        </div>
                        <div class="row marginbottom20"></div>
                        <span>Date</span>
                        <input name="date" class="pull-right form-control inline" id="datetimepicker" type="text" required>
                        <div class="row marginbottom20"></div>
                        <span>Time?</span>
                        <input name="time_end" class="pull-right form-control inline" id="datetimepicker2" type="text" required>
                        <span class="pull-right toTekst">To</span>
                        <input name="time_start" class="pull-right form-control inline" id="datetimepicker3" type="text" required>

                    </form>
                </div>
                <div class="boxRight">
                    <div id="txtRoom">
                        <?php
                        $result = $mysqli->query("SELECT * FROM room");
                        echo "<div class=\"roomStyle\">";
                        while ($row = mysqli_fetch_array($result)) {

                            if ($row[3] == 1) {
                                $projector = "<span class=\"glyphicon glyphicon-facetime-video glyph-custom pull-left\"></span >";
                            }
                            if ($row[3] == 0) {
                                $projector = "";
                            }

                            if ($row[5] == 1) {
                                $statusName = 'Status: Under construction';
                            }
                            if ($row[5] == 0) {
                                $statusName = 'Status: Unavailable at the moment';
                            }
                            if ($row[5] == 2) {
                                $statusName = '';
                            }
                            ?>

                            <div class="pull-left black-ops">
                                <div class="pull-left imgClass">
                                    <img src="<?php echo $row[4] ?>"/>
                                </div>
                                <div class="pull-left w50">
                                    <p class="white"><?php echo $row[1] ?> </p>
                                    <span class="white"><?php echo $statusName ?></span>
                                    <span class="abbottom">
                                        <span class="glyphicon glyphicon-user glyph-custom pull-left"></span>
                                        <span class="white pull-left"> <?php echo $row[2] ?></span>
                                        <?php echo $projector; ?>


                                    </span>
                                </div>
                            </div>
                            <?php
                        }
                        echo "</div>";
                        ?>
                    </div>
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
        <div class="modal fade" id="allBookings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Bookings</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover black">
                            <thead>
                                <tr>
                                    <th>User E-mail</th>
                                    <th>Roomname</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="placeAllBookings">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h1>Confirmation</h1>
                        <div class="confirmationClass"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default empty" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script src="js/jquery.datetimepicker.js"></script>
        <script src="js/main.js "></script>
        <script type="text/javascript" >
            $(document).ready(function() {
                $('#submitbtn').click(function() {
                    $("#viewimage").html('');
                    $("#viewimage").html('<img src="images/loader.gif" />');
                    $(".uploadform").ajaxForm({
                        target: '#viewimage'
                    }).submit();
                });
            });
        </script>
    </body>
</html>