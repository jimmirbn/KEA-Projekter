<?php

include "dbconnect.php";

$id = $_POST['id'];
$date = $_POST['date'];
$starttime = $_POST['start_time'];
$endtime = $_POST['end_time'];
$date = $_POST['date'];

$result = $mysqli->query("SELECT * FROM room WHERE id = " .$_POST['id']);
$arr = array();
while ($row = $result->fetch_assoc()) {
    $arr[] = $row;
}
echo json_encode($arr);