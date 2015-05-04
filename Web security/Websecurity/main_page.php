<?php
include "dbconnect.php";
include "cookie.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Web security</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body class="main">
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
                            <li><a data-toggle="modal" data-target=".profile" id="pName" href="">Profile</a></li>
                            <li>
                                <form class="logOut" action="?action=unsetUsername" method="post">
                                    <a id="logOut" href="">Log Out</a>
                                </form>
                            </li>
                            <li id="Info"><a href="admin.php">(Admin)</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
            <!--NAV-->
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="content_news">
                            <div id="appendNews">


                            </div>
                        </div>
                    </div>
                    <!--                    <div class="col-md-4"> <div class="right_content pull-right">
                                                <div class="right_content_div">
                                                    <h3>Events</h3>
                                                    <p>Bla bla blas</p>
                                                </div>
                                                <div>
                                                    <h3>News</h3>
                                                    <p>Indsæt nyheder her dynamisk</p> 
                                                </div>
                                                <div>
                                                    <h3>Social</h3>
                                                    <p>Sociale medier knapper</p> 
                                                </div>
                                            </div>
                                        </div>-->
                </div>
            </div>
        </div>
        
        <div class="modal fade profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="centered-form">
                        <div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title" id="profileName">Hello</h3>
                                </div>
                                <div class="panel-body">
                                    <form role="form" class="updateUserForm">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-12">
                                                <div class="form-group">
                                                    <img class="profileImg">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="update_first_name" id="update_first_name" class="form-control input-sm" placeholder="First Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="update_last_name" id="update_last_name" class="form-control input-sm" placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <input type="email" name="update_email" id="update_email" class="form-control input-sm" placeholder="Email Address">
                                                </div>
                                            </div>
                                        </div>

<!--                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <input type="password" name="new_password" id="new_password" class="form-control input-sm" placeholder="Password">
                                                </div>
                                            </div>
                                        </div>-->
                                        <input type="submit" value="Update Profile" class="btn btn-info btn-block">

                                        <div class="alert alert-success" id="createUserSuccess" role="alert">Success</div>
                                        </form>
                                          <h5>Change password</h5>
                                        <form role="form" class="changePassword">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-12">
                                                <div class="form-group">
                                                    <input type="password" name="old_password" id="old_password" class="form-control input-sm"  placeholder="Write current password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <input type="password" name="new_password" id="new_password" class="form-control input-sm"  placeholder="Write new password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <input type="password" name="new_password2" id="new_password2" class="form-control input-sm"  placeholder="Confirm new password">
                                                </div>
                                            </div>
                                        </div>
                         
                                        <input type="submit" value="Change Password" id="updatePasswordBtn" class="btn btn-info btn-block">
                                        <div class="alert alert-success" id="updatePasswordSuccess" role="alert">Password Updated</div>
                                        <div class="alert alert-warning" id="updatePasswordError" role="alert">Failed to update password</div>
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
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/jquery.cookie.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>