<?php

include "dbconnect.php";

$ip = $_SERVER['REMOTE_ADDR'];
//$nyip = preg_replace('/[^0-9]+/', '', $ip);

if ($_POST['type'] == checkLog) {

    $result5 = $mysqli->query("select ip from log where ip=" . $ip . "");
    $numberOfRows2 = mysqli_num_rows($result5);
    if ($numberOfRows2 > 0) {
        $result = $mysqli->query("select date from log where ip=" . $ip . " order by date DESC limit 1");
        while ($row = $result->fetch_row()) {
            $DBdate = $row[0];
            $date = date("Y-m-d H:i:s");
            $to_time = strtotime($date);
            $from_time = strtotime($DBdate);
            $tid = round(abs($to_time - $from_time) / 60, 2);
            if ($numberOfRows2 > 0 && $numberOfRows2 < 3) {
                echo json_encode('safe');
            }
            if ($numberOfRows2 >= 3) {
                if ($tid <= 5) {
                    $tid2 = (5 - $tid);
                    echo json_encode($tid2);
                } else {
                    $mysqli->query("delete FROM log where ip=" . $ip . "");
                }
            }
        }
    } else {
        echo json_encode('noData');
    }
}



if ($_POST['type'] == login) {

    $Tempemail = $_POST['email'];
    $Temppassword = $_POST['password'];
    $tempemail = cleanInput($Tempemail);
    $temppass = cleanInput($Temppassword);

    $checkEmail = encryptThis($tempemail);

    $resultNy = $mysqli->query("select password, salt, email, first_name, id from users where email ='" . $checkEmail . "'");
    $numberOfRows = mysqli_num_rows($resultNy);
    if ($numberOfRows > 0) {
        while ($row2 = $resultNy->fetch_row()) {
            $password = $row2[0];
            $salt = $row2[1];
            $email = $row2[2];
            $f_name = $row2[3];
            $id = $row2[4];

            $saltedpassword = ($temppass . $salt);
            $hashed = hash('sha256', $saltedpassword);

            if ($checkEmail == $email && $hashed == $password) {
                $dID = encryptThis($id);

                $cookie_name = "userInfo";
                $cookie_value = $dID;
                $cookie_name2 = "loggedIn";
                $cookie_value2 = "true";
                setcookie($cookie_name, $cookie_value, time() + (86400 * 1), "/"); // 86400 = 1 day
                setcookie($cookie_name2, $cookie_value2, time() + (86400 * 1), "/"); // 86400 = 1 day

                $mysqli->query("delete FROM log where ip=" . $ip . "");
                echo json_encode($dName);
                break;
            }
        }
    } else {
        $mysqli->query("INSERT INTO log(ip) VALUES('" . $ip . "')");
        echo json_encode('error');
    }
}

if ($_POST['type'] == createNews) {

    $TextInput = $_POST['text_input'];
    $cleanInput = cleanInput($TextInput);
    $data = $_POST['data'];
    $data_name = $_POST['filename'];
    $randomNr = generateNr();

    $mysqli->query("INSERT INTO content(text_input, image, image_name, randomnr) VALUES('$cleanInput','$data','$data_name', '$randomNr')");

    if ($mysqli) { // will return true if succefull else it will return false
        echo json_encode('success');
    } else {
        echo json_encode('error');
    }
}
if ($_POST['type'] == typeGetNews) {
    $resultContent = $mysqli->query("SELECT * from content");
    $arr = array();
    while ($row = $resultContent->fetch_assoc()) {
        $arr[] = $row;
    }
    echo json_encode($arr);
}
if ($_POST['type'] == typeGetNewsComment) {
    $contentnr = $_POST['contentnr'];
    $resultContent = $mysqli->query("SELECT * from content where randomnr ='" . $contentnr . "'");
    $arr = array();
    while ($row = $resultContent->fetch_assoc()) {
        $arr[] = $row;
    }
    echo json_encode($arr);
}

if ($_POST['type'] == comment) {
    $comment = $_POST['comment'];
    $contentnr = $_POST['contentnr'];
    $userID = $_POST['userID'];
    $deUserId = decryptThis($userID);
    $deComment = encryptThis($comment);
    
    $result = $mysqli->query("select users.id, randomnr from users, content where users.id ='" . $deUserId . "'");
       while ($row = $result->fetch_row()) {
       $roleID = $row[0];
       $name = $row[1];
       if ($name == $contentnr) {
         $mysqli->query("INSERT INTO comments(comment, contentNr, user_id) VALUES('$deComment','$contentnr','$deUserId')");
   
       }
       
       }
}

if ($_POST['type'] == getInfo) {
    $cookie = $_POST['cookie'];
    $deCookie = decryptThis($cookie);
    $int = (int) preg_replace('/[^0-9]/', '', $deCookie);
    
    $result = $mysqli->query("select role_id, first_name from user_roles, users where user_roles.user_id ='" . $int . "' and users.id ='" . $int . "'");
    $arr = array();
    while ($row = $result->fetch_row()) {
        $roleID = $row[0];
        $name = $row[1];
        $deName = decryptThis($name);
        if ($roleID == 1) {
            array_push($arr, $roleID);
            array_push($arr, $deName);
            echo json_encode($arr);
        }
        if($roleID == 2){
            array_push($arr, $roleID);
            array_push($arr, $deName);
            echo json_encode($arr);
        }
    }
}

if ($_POST['type'] == getInfoProfile) {
    $cookie = $_POST['cookie'];
    $deCookie = decryptThis($cookie);
    $int = (int) preg_replace('/[^0-9]/', '', $deCookie);
    $resultProfile = $mysqli->query("SELECT * from users where id ='" . $int . "'");
    $arr = array();
    while ($row = $resultProfile->fetch_row()) {
        $first_name = $row[1];
        $last_name = $row[2];
        $email = $row[5];
        $imgData = $row[6];
        $deImgData = decryptThis($imgData);
        $deF = decryptThis($first_name);
        $deL = decryptThis($last_name);
        $dE = decryptThis($email);
        array_push($arr, $deF);
        array_push($arr, $deL);
        array_push($arr, $dE);
        array_push($arr, $deImgData);
    }
    echo json_encode($arr);
}

?>