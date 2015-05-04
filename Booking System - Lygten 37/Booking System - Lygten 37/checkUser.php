<?php

$con = mysqli_connect('localhost', 'root', 'root', 'BookingSystem');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con, "BookingSystem");


$q = $_REQUEST["q"];
$sql = "SELECT username FROM users WHERE username LIKE '$q'";

$result = mysqli_query($con, $sql);


while ($row = mysqli_fetch_array($result)) {
    if ($q = $sql) {
        echo "<span class=\"glyphicon glyphicon-remove\"></span>";
    }
}
if ($q != $sql) {
    echo "<span class=\"glyphicon glyphicon-ok\"></span>";
}
mysqli_close($con);
