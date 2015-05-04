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
        
             case "addComment";
            $username = $_SESSION['username'];
            $comment = $_POST['comment'];
            $roomid = $_POST['roomId'];
            $mysqli->query("INSERT INTO comments(room_id,comment,user_name) VALUES('$roomid','$comment','$username')");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Rooms</title>
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
            <div class="sectionTwo">
                <?php
                $result = $mysqli->query("SELECT * FROM room");
                while ($row = mysqli_fetch_array($result)) {
                    $idDelete = $row[0];
                    ?>
                    <div class="pull-left showRoomStyle"  >
                        <div class="pull-left imgRoomClass">
                            <img src="<?php echo $row[4] ?>"/>
                        </div>

                        <div class="pull-left">
                            <p class="white description" ><?php echo $row[1] ?> </p>
                            <p class="white">Rummet fuld</p>
                        </div>
                        <button id='<?php echo $idDelete ?>' class="btn btn-success btnInfoUser" data-toggle='modal' data-target='#infoRoom'>Show Info</button>
                    </div>

                    <?php
                }
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
                            <li class="border-left"><a href="userProfile.php"<span class="glyphicon glyphicon-user"></span>User</a></li>
                            <li class="border-left"><a href="booking.php"<span class="glyphicon glyphicon-th-list"></span>Booking</a></li>
                            <li class="border-left"><a href="userRooms.php"<span class="glyphicon glyphicon-calendar"></span>Rooms</a></li>
                            <li class="border-left"><a href="toptenUser.php"<span class="glyphicon glyphicon-heart"></span>Top 10's</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </footer>
        <!-- Modal -->
        <div class="modal fade" id="CreateRoom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Create new room</h4>
                    </div>
                    <div class="modal-body">
                        <form class="uploadform" method="post" enctype="multipart/form-data" action='upload_file.php'>
                            <span>Room Name:</span>
                            <input class="form-control marginbottom20" type="text" placeholder="Room Name" name="roomname">
                            <span>How many persons?</span>
                            <select class="form-control marginbottom20" name="persons"> 
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                            <span>Is there a projector?</span>
                            <select class="form-control marginbottom20" name="projector"> 
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <span>Room status:</span>
                            <select class="form-control marginbottom20" name="roomstatus"> 
                                <option value="1">Under construction</option>
                                <option value="0">Unavailable at the moment</option>
                            </select>

                            <span>Upload a image of the room</span> 
                            <input class="form-control marginbottom20" type="file" name="imagefile" />
                            <input class="btn btn-success" type="submit" value="Submit" name="submitbtn" id="submitbtn">
                        </form>
                        <!-- The uploaded image will display here -->
                        <div id='viewimage'></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="infoRoom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Room info</h4>
                    </div>
                    <div class="modal-body">
                        <div class="infoHereUser"></div>
                        <h4>Comments</h4>
                        <div id="placeCommentsUser"></div>
                        <form action="?action=addComment" method="post"> 
                            <input type="text" name="comment" class="form-control" />
                            <input  type="hidden" name="roomId" id="hiddenID" value="">
                            <input class="btn btn-success margintop20" type="submit"/>
                        </form>
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