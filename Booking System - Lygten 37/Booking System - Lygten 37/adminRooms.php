<?php
session_start();
include "dbconnect.php";

//Check if a user is logged in.

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
}

//Multiple cases with a CRUD
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "unsetUsername":
            unset($_SESSION['username']);
            header('Location: index.php');
            break;

        case "deleteRoom";
            $mysqli->query("delete FROM room where id=" . $_GET["id"]);
            break;
        case "addComment";
            $username = $_SESSION['username'];
            $comment = $_POST['comment'];
            $roomid = $_POST['roomId'];
            $mysqli->query("INSERT INTO comments(room_id,comment,user_name) VALUES('$roomid','$comment','$username')");
        case "deleteComment";
            $mysqli->query("delete FROM comments where id=" . $_GET["id"]);
            break;
        case "editRoomInfo";
            $roomName = $_POST['editName'];
            $persons = $_POST['editPersons'];
            $projector = $_POST['editProjector'];
            $status = $_POST['editStatus'];
            $id = $_POST['ID'];
            $mysqli->query("update room set roomname='" . $roomName . "', persons='" . $persons . "', projector='" . $projector . "', roomstatus='" . $status . "' where id = '" . $id . "' ");
            break;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Rooms</title>
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
                <button class="btn btn-info" data-toggle="modal" data-target="#CreateRoom">Create Room</button>
            </div>

            <div class="sectionTwo">
                <span class="glyphicon glyphicon-chevron-down arrow-glyph"></span>
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

                        </div>
                        <button id='<?php echo $idDelete ?>' class="btn btn-success btnInfo" data-toggle='modal' data-target='#infoRoom'>Show Info</button>
                        <button id='<?php echo $idDelete ?>' data-toggle='modal' data-target='#DeleteRoom' class="btn btn-danger deleteButton pull-left custom-bookbtn">X</button>
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
                            <li class="border-left"><a href="userView.php"<span class="icon-users"></span>Users</a></li>
                            <li class="border-left"><a href="adminbooking.php"<span class="glyphicon glyphicon-th-list"></span>Booking</a></li>
                            <li class="border-left"><a href="adminRooms.php"<span class="glyphicon glyphicon-calendar"></span>Rooms</a></li>
                            <li class="border-left"><a href="toptenAdmin.php"<span class="glyphicon glyphicon-heart"></span>Top 10's</a></li>
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
                                <option value="2">Ready for takeoff</option>
                            </select>

                            <span>Upload a image of the room</span> 
                            <input class="form-control marginbottom20" type="file" name="imagefile" />
                            <input class="btn btn-success" type="submit" value="Submit" name="submitbtn" id="submitbtn">
                        </form>
                        <!-- The uploaded image will display here -->
                        <div id='viewimage'></div>
                    </div>
                    <div class="modal-footer">
                        <button onclick='location.reload();' type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="DeleteRoom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Delete room</h4>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <p>Are you sure you want to delete the room?</p><br>
                            <a id="btnDelete" href="" class="btn btn-danger">Delete</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="infoRoom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Room</h4>
                    </div>
                    <div class="modal-body">
                        <div class="infoHere"></div>
                        <div class="tableComments">
                            <h4>Comments</h4>
                            <table class="table colorComments">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Comment</th>
                                    </tr>
                                </thead>
                                <tbody id="placeComments">

                                </tbody>
                            </table>
                        </div>
                        <form action="?action=addComment" method="post"> 
                            <input type="text" name="comment" placeholder="Write your comment here.." class="form-control marginbottom20" />
                            <input  type="hidden" name="roomId" id="hiddenID" value="">
                            <input class="btn btn-success" type="submit"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editRoom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Edit Room info</h4>
                    </div>
                    <div class="modal-body">
                        <div class="editInfo"></div>

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

