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

//function ShowAllUsers($mysqli) {
//}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "unsetUsername":
            unset($_SESSION['username']);
            header('Location: index.php');
            break;

        case "updateUser";
            $Newaccess = $_POST['NewaccessOption'];
            $str = "update users set name='" . $_POST['name'] . "', lastname='" . $_POST['lastname'] . "', email='" . $_POST['email'] . "', password='" . $_POST['password'] . "', admin='" . $Newaccess . "', blocked ='" . $_POST['blocked'] . "' where id='" . $_POST['id'] . "'";
            $mysqli->query($str);
            header('Location: userView.php');
            break;

        case "deleteUser";
            $mysqli->query("delete FROM users where id=" . $_GET["id"]);
            break;

        case "addUser";
            $Tempusername = $_POST['username'];
            $Tempname = $_POST['name'];
            $Templastname = $_POST['lastname'];
            $Tempmail = $_POST['email'];
            $Temppassword = $_POST['password'];
            $Tempaccess = $_POST['accessOption'];

            $mysqli->query("INSERT INTO users(username,name,lastname,email,password,admin,blocked) VALUES('$Tempusername','$Tempname','$Templastname','$Tempmail', '$Temppassword', '$Tempaccess', '0')");
            header('Location: userView.php');
            break;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User overview</title>
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
                <?php
//                If action then show edit user with multiple inputs and a submit button. Get info from users table with correct ID.
                if ($_GET["action"] == "editUser") {
                    if ($_GET["action"] == "editUser") {
                        $result = $mysqli->query("select * from users where id=" . $_GET["id"]);
                        while ($row = $result->fetch_row()) {
                            $username = $row[1];
                            $name = $row[2];
                            $lastname = $row[3];
                            $email = $row[4];
                            $password = $row[5];
                            $id = $row[0];
                            $blocked = $row[7];
                        }
                        ?>
                        <table class="table"><thead><tr><th>Username</th><th>Name</th><th>Lastname</th><th>E-Mail</th><th>Password</th><th>Access</th><th>Blocked</th></tr></thead>
                            <form action="?action=updateUser" method="post">
                                <tr>
                                    <td><input class="form-control" name="username" value="<?php echo $username ?>"></td>
                                    <td><input class="form-control" name="name" value="<?php echo $name ?>"></td> 
                                    <td><input class="form-control" name="lastname" value="<?php echo $lastname ?>"></td>
                                    <td><input class="form-control" name="email" value="<?php echo $email ?>"></td>
                                    <td><input class="form-control" name="password" value="<?php echo $password ?>"></td>
                                    <td><select class="form-control" name="NewaccessOption"><option value="1">Admin</option><option value="0">User</option></select></td>
                                    <td><select class="form-control" name="blocked"><option value="1">Block</option><option value="0">Free</option></select></td>

                                <input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">
                                <td><input class="btn btn-info" type="submit"></td>
                                </tr>
                            </form>
                        </table>
                        <?php
                    }
                    
//                    Else just show all users and their info.
                } else {
                    echo "<button class=\"showCreateUser btn btn-info\" data-toggle=\"modal\" data-target=\"#myModal\">Create User</button>";
                    echo "<div class=\"tableBg\"><table class='table table-hover'><thead><tr><th>#</th><th>Username</th><th>Name</th><th>Lastname</th><th>E-mail</th><th>Password</th><th>Access</th><th>Blocked</th><th>Delete</th><th>Edit</th></tr></thead>";
                    $result2 = $mysqli->query("select * from users");
                    while ($row = $result2->fetch_row()) {
                        if ($row[6] == 1) {
                            $accessName = 'Admin';
                            $deleteUser = 'NO!';
                        }
                        if ($row[6] == 0) {
                            $accessName = 'User';
                            $deleteUser = "<a href='?action=deleteUser&id=$row[0]'>Delete</a>";
                        }
                        if ($row[7] == 1) {
                            $blocked = "Blocked";
                        }
                        if ($row[7] == 0) {
                            $blocked = "Free";
                        }
                        echo "<tr class=\"userTd\"><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$accessName</td><td>$blocked</td><td>$deleteUser</td><td><a href='?action=editUser&id=$row[0]'>Edit</a></td></tr>";
                    }
                    echo "</table></div>";
                }
                ?>

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

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Create user</h4>
                    </div>
                    <div class="modal-body">
                        <form action="?action=addUser" method="post">
                            <input class="form-control marginbottom20" type="text" placeholder="Username" name="username">
                            <input class="form-control marginbottom20" type="text" placeholder="Name" name="name">
                            <input class="form-control marginbottom20" type="text" placeholder="Lastname" name="lastname">
                            <input class="form-control marginbottom20" type="text" placeholder="E-mail" name="email">
                            <input class="form-control marginbottom20" type="text" placeholder="Password" name="password">
                            <select name="accessOption" class="form-control marginbottom20"><option value="1">Admin</option><option value="0">User</option></select>
                            <input class="btn btn-success" type="submit" value="Create User">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>