<?php
include "dbconnect.php";
include "cookie.php";
$commentNr = $_GET['comment'];
$resultcomment = $mysqli->query("select randomnr from content where randomnr ='" . $commentNr . "'");
$numberOfRowscomment = mysqli_num_rows($resultcomment);
if ($numberOfRowscomment == 0) {
    header('Location: 404.html');
}
if (!$commentNr) {
    header('Location: 404.html');
}
$sLength = strlen($commentNr);
if ($sLength != 7) {
    header('Location: 404.html');
}
if (!is_numeric($commentNr)) {
    header('Location: 404.html');
}
$cookieId = $_COOKIE[$cookie_user];
$newCookieId = decryptThis($cookieId);
$test = preg_replace("/[^0-9]/","",$newCookieId);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Web security</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body class="main comment">
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
                            <li id="Info"><a href="admin.php">(Admin)</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
            <!--NAV-->
            <div class="content">
                <button class="btn btn-warning backBtn">Back</button>

                <div class="row">
                    <div class="col-md-12">
                        <div class="content_news">
                            <div id="appendNews2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="bs-docs-example">

                            <?php
                            $result = $mysqli->query("select comment, date, user_id, first_name from comments, users where contentNr =" . $commentNr . " and user_id =users.id");
                            $numberOfRows = mysqli_num_rows($result);
                            if ($numberOfRows == 0) {
                                echo "<h4>No comments yet</h4>";
                            } else {
                                while ($row = $result->fetch_row()) {
                                    $comment = $row[0];
                                    $date = $row[1];
                                    $name = $row[3];
                                    $userID = $row[2];
                                    $deName = decryptThis($name);
                                    $deComment = decryptThis($comment);
                                  
                                    
                                    ?>
                                    <div class="media">
                                        <p class="media-left"><?php echo $deName ?></p>
                                        <div class="media-body">
                                            <h4 class="media-heading"><?php echo $date ?></h4>
                                            <?php echo $deComment ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white">
                            <textarea class="form-control commentArea" name="<?php echo $cookieId ?>" cols="50" id="<?php echo $commentNr ?>">
                            </textarea>
                        </div>
                        <button id="addComment" class="btn btn-success pull-right" type="button">Add comment</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/nice.js" type="text/javascript"></script>
        <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
        <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/jquery.cookie.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>