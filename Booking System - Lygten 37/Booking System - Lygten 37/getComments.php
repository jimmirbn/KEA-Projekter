<?php

include "dbconnect.php";

$resultComment = $mysqli->query("SELECT * from comments where room_id =" . $_POST['id']);


$arr = array();
while ($row = $resultComment->fetch_assoc()) {
    $arr[] = $row;
}
echo json_encode($arr);



