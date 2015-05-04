<?php
ob_start();
include "dbconnect.php";

// Clean (erase) the output buffer and turn off output buffering - Rune's idea
ob_end_clean(); 
    $xml = new SimpleXMLElement('<xml/>');
    
     $result = $mysqli->query("SELECT * FROM room where id = ".$_POST['id']);
     while ($row = mysqli_fetch_row($result)) {
    
    $id = $row[0];
    $roomname = $row[1];
    $persons = $row[2];
    $projector = $row[3];
    $imgRoom = $row[4];
    $roomstatus = $row[5];
    
    $rooms = $xml->addChild('rooms');
    $rooms->addChild('id', $id);
    $rooms->addChild('roomname', $roomname);
    $rooms->addChild('persons', $persons);
    $rooms->addChild('projector', $projector);
    $rooms->addChild('imgRoom', $imgRoom);
    $rooms->addChild('roomstatus', $roomstatus);
    
     }
     
     Header('Content-type: text/xml');
     echo $xml->asXML();
 
