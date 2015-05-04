<?php
include "dbconnect.php";

$cookie_name = "loggedIn";
$cookie_user = "userInfo";
$cookie_name2 = "loggedIn";
$cookie_value2 = "false";
if (!isset($_COOKIE[$cookie_name]) || !isset($_COOKIE[$cookie_user])) {
    setcookie($cookie_name2, $cookie_value2, time() + (86400 * 1), "/"); // 86400 = 1 day
    setcookie('userInfo', '', time() - 60 * 60 * 24 * 365, '/');
}
if (isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] == 'false') {
    setcookie($cookie_name2, $cookie_value2, time() + (86400 * 1), "/"); // 86400 = 1 day
    setcookie('userInfo', '', time() - 60 * 60 * 24 * 365, '/');
}
if (isset($_COOKIE[$cookie_user])) {
    $cookieId = $_COOKIE[$cookie_user];
    $deID = decryptThis($cookieId);
    $int = (int) preg_replace('/[^0-9]/', '', $deID);

    $result10 = $mysqli->query("select id from users where id=" . $int . "");
    $numberOfRows10 = mysqli_num_rows($result10);
    if ($numberOfRows10 != 1) {
        setcookie($cookie_name2, $cookie_value2, time() + (86400 * 1), "/"); // 86400 = 1 day
    }
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
    <body class="index">
        <div id="fullscreen_bg" class="fullscreen_bg">
            <!--        <header class="header">
                        <nav class="navbar navbar-default navbar-top" role="navigation">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-5">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <p class="navbar-brand">Login check</p>
                                </div>
                                <div class="collapse navbar-collapse">
                                    <p class="navbar-text navbar-right"></p>
                                </div>
                            </div>
                        </nav>
                    </header>-->
            <div class="container">
                <div id="loginForm">
                </div>

                    <form class="form-signin loginForm" method="post">
                        <h1 class="form-signin-heading text-muted">Sign In</h1>
                        <input class="form-control" id="email" type="email" placeholder="Email" name="email">
                        <input class="form-control" id="password" type="password" placeholder="Password" name="password" password>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">
                            Sign In
                        </button>
                        <p class="text-center text-muted">or</p>
                        <a class="btn btn-lg btn-success btn-block" data-toggle="modal" data-target="#myModal">
                            Create user
                        </a>
                    </form>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="centered-form">
                        <div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Please sign up <small>It's free!</small></h3>
                                </div>
                                <div class="panel-body">
                                    <form role="form" class="createUserForm" id="submitFormUser" method="post">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <input type="email" name="new_email" id="new_email" class="form-control input-sm" placeholder="Email Address">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <input type="password" name="new_password" id="new_password" class="form-control input-sm" placeholder="Password">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <span class="btn btn-default btn-file">
                                                        Profile picture<input type="file" name="attachmentUser" class="attachmentUser" multiple /> 
                                                    </span>
                                                    <small class="text-muted"></small>
                                                </div>
                                            </div>
                                        </div>


                                        <input type="submit" value="Register" class="btn btn-info btn-block">
                                        <div class="alert alert-success" id="createUserSuccess" role="alert">Success. Please login</div>
                                        <button type="button" class="btn btn-default closeBtn" data-dismiss="modal">Close</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <!--<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/jquery.cookie.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
