<?php

include "dbconnect.php";

$persons = $_POST['persons'];
$date = $_POST['date'];
$starttime = $_POST['starttime'];
$endtime = $_POST['endtime'];
$projector = $_POST['projector'];

$result = $mysqli->query("SELECT * FROM room WHERE persons >= '$persons' AND id not in (select room_id from bookedRoom where date = '$date' and (start_time between '$starttime' and '$endtime' OR end_time between '$starttime' and '$endtime'))");
$arr = array();
while ($row = $result->fetch_assoc()) {
    $arr[] = $row;
}
echo json_encode($arr);