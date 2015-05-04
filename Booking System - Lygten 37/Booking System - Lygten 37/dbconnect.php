<?php

$mysqli = new mysqli("127.0.0.1", "root", "root", "BookingSystem", 8889);
if ($mysqli->connect_errno) {
    echo "WARNING DATABASE FAILED: " . $mysqli->connect_error;
}
ob_start();
?>















