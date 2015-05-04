<?php
include "dbconnect.php";
include "cookie.php";

$cookie_userAdmin = "userInfo";
$cookieId = $_COOKIE[$cookie_userAdmin];
$deID = decryptThis($cookieId);
$int = (int) preg_replace('/[^0-9]/', '', $deID);

$resultAdmin = $mysqli->query("select role_id from user_roles where user_id=" . $int . "");
while ($rowadmin = $resultAdmin->fetch_row()) {
    $roleID = $rowadmin[0];
}
if ($roleID != 1) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Web security</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container">
            <div class="navbar navbar-default navbar-fixed-top" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="main_page.php">The Company</a>
                    </div>
                    <div class="navbar-collapse collapse navbar-right">
                        <ul class="nav navbar-nav">
                            <li><a id="pName" href="">Profile</a></li>
                            <li>
                                <form class="logOut" action="?action=unsetUsername" method="post">
                                    <a id="logOut" href="">Log Out</a>
                                </form>
                            </li>
                            <li><a href="admin.php">(Admin)</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
            <!--NAV-->
            <div class="uploadForm">
                <form role="form" class="createNews" action="admin.php" id="submitFormNews">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-12">
                            <div class="form-group">
                                <textarea type="text" name="text_input" id="text_input_test" class="form-control input-sm" placeholder="Info Here"></textarea>
                            </div>
                        </div>
                    </div>

                    <span class="btn btn-default btn-file">
                        Browse for file                   <input type="file" name="attachment" class="attachment" multiple /> 

                    </span>
                    <input id="adminBtn" class="btn btn-success" type="submit" value="Upload" />
                </form>
                <div class="alert alert-success" id="createNewsSuccess" role="alert">News posted!</div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>