<?php

include "dbconnect.php";
$file_formats = array("jpg", "png", "gif", "bmp"); // Set File format
$filepath = "upload/";

$TempRoomName = $_POST["roomname"];
$TempPersons = $_POST["persons"];
$TempProjector = $_POST["projector"];
$TempRoomstatus = $_POST["roomstatus"];


if ($_POST['submitbtn'] == "Submit") {
    $name = $_FILES['imagefile']['name'];
    $size = $_FILES['imagefile']['size'];
    if (strlen($name)) {
        $extension = substr($name, strrpos($name, '.') + 1);
        if (in_array($extension, $file_formats)) {
            if ($size < (5000000)) {
                $imagename = md5(uniqid() . time()) . "." . $extension;
                $tmp = $_FILES['imagefile']['tmp_name'];
                $imgRoot = "$filepath$imagename";
                if (move_uploaded_file($tmp, $filepath . $imagename)) {
                    $mysqli->query("INSERT INTO room(roomname,persons,projector,imgRoom,roomstatus) VALUES('$TempRoomName','$TempPersons','$TempProjector','$imgRoot', '$TempRoomstatus')");
                    if ($TempProjector = 1) {
                        $projectorName = 'Yes';
                    }
                    if ($TempProjector = 0) {
                        $projectorName = 'No';
                    }

                    if ($TempRoomstatus == 1) {
                        $statusName = 'Under construction';
                    }
                    if ($TempRoomstatus == 0) {
                        $statusName = 'Unavailable at the moment';
                    }
                    if ($TempRoomstatus == 2) {
                        $statusName = 'Ready for takeoff';
                    }
                    echo '<img class="preview" alt="" src="' . $filepath . '/' .
                    $imagename . '" />';
                    echo "<div class=\"previewTekst\">";
                    echo "<h3> <span class='label label-success'>You have now created a room!</span></h3>";
                    echo "<p>Room name " . $TempRoomName . "</p>";
                    echo "<p>Room status: " . $statusName . "</p>";
                    echo "<p>Persons:" . $TempPersons . "</p>";
                    echo "<p>Is there projector:" . $projectorName . "</p>";
                    echo "</div>";
                    echo "<div class=\"row\"></div>";
                } else {
                    echo "Could not move the file.";
                }
            } else {
                echo "Your image size is bigger than 2MB.";
            }
        } else {
            echo "Invalid file format.";
        }
    } else {
        echo "Please select image..!";
    }
    
    exit();
}
?>