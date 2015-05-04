<?php

include "dbconnect.php";

$resultAllbookings = $mysqli->query("SELECT * from allbookingsbyuser");


$arr = array();
while ($row = $resultAllbookings->fetch_assoc()) {
    $arr[] = $row;
}
echo json_encode($arr);

