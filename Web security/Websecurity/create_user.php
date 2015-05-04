<?php

include "dbconnect.php";
if ($_POST['type'] == createUser) {

    $data = $_POST['data'];
    $data_name = $_POST['filename'];
    $mail = $_POST['new_mail'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['new_password'];

    $cMail = cleanInput($mail);
    $cFirstName = cleanInput($first_name);
    $cLastName = cleanInput($last_name);
    $cPassword = cleanInput($password);

    $newFirst_name = encryptThis($cFirstName);
    $newEmail = encryptThis($cMail);
    $newLast_name = encryptThis($cLastName);
    $dedata = encryptThis($data);
    $dedata_name = encryptThis($data_name);

    $result = $mysqli->query("select email from users where email ='" . $newEmail . "'");
    $numberOfRows = mysqli_num_rows($result);
    if ($numberOfRows > 0) {
                echo json_encode('error');
    } 
      if($newFirst_name == null || $newEmail == null || $newLast_name == null ){
        echo json_encode('noscripts');
    }
    else {
        $newSalt = generateSalt();
        $saltedpassword = $cPassword . $newSalt;
        $passwordHashed = hash('sha256', $saltedpassword);
        $mysqli->query("INSERT INTO users(first_name,last_name,email,salt,password, image, image_name) VALUES('$newFirst_name','$newLast_name','$newEmail','$newSalt','$passwordHashed', '$dedata', '$dedata_name')");

        if ($mysqli) { // will return true if succefull else it will return false
            echo json_encode('success');
            $result = $mysqli->query("select id from users where first_name ='" . $newFirst_name . "'");
            while ($row = $result->fetch_row()) {
                $id = $row[0];
                 $mysqli->query("INSERT INTO user_roles(user_id,role_id) VALUES('$id','2')");
            }
        } else {
            echo json_encode('error');
        }
    }
}

if ($_POST['type'] == updateUser) {
    $cookie = $_POST['cookie'];
    $deCookie = decryptThis($cookie);

    $int = (int) preg_replace('/[^0-9]/', '', $deCookie);

    $mail = $_POST['new_mail'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $cMail = cleanInput($mail);
    $cFirstName2 = cleanInput($first_name);
    $cLastName2 = cleanInput($last_name);

    $newFirst_name = encryptThis($cFirstName2);
    $newEmail = encryptThis($cMail);
    $newLast_name = encryptThis($cLastName2);
    
     if($newFirst_name == null || $newEmail == null || $newLast_name == null ){
        echo json_encode('noscripts');
    }
    else{

    $mysqli->query("update users set first_name='" . $newFirst_name . "', last_name='" . $newLast_name . "', email='" . $newEmail . "' where id='" . $int . "'");
    if ($mysqli) { // will return true if succefull else it will return false
        echo json_encode('success');
    } else {
        echo json_encode('error');
    }
}
}

if ($_POST['type'] == changePassword) {
    $cookie = $_POST['cookie'];
    $deCookie = decryptThis($cookie);
    $int = (int) preg_replace('/[^0-9]/', '', $deCookie);

    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $new_password2 = $_POST['new_password2'];
    
    $cOldPassword = cleanInput($old_password);
    $cNewPassword = cleanInput($new_password);
    $cNewPassword2 = cleanInput($new_password2);
    
    if($cOldPassword == null || $cNewPassword == null || $cNewPassword2 == null ){
        echo json_encode('noscripts');
    }
    else{
    $result = $mysqli->query("select salt, password from users where id ='" . $int . "'");
    while ($row = $result->fetch_row()) {
        $saltFromDatabase = $row[0];
        $oldPasswordFromDatabase = $row[1];
        $salted_check_old_password = $cOldPassword . $saltFromDatabase;
        $salted_hashed_check_old_password = hash('sha256', $salted_check_old_password);
        if ($oldPasswordFromDatabase === $salted_hashed_check_old_password && $cNewPassword == $cNewPassword2) {


            $newSalt2 = generateSalt();
            $salted_new_password = $cNewPassword . $newSalt2;
            $new_password_salted_hashed = hash('sha256', $salted_new_password);
            $mysqli->query("update users set password='" . $new_password_salted_hashed . "', salt='" . $newSalt2 . "' where id='" . $int . "'");
            
            if ($mysqli) { // will return true if succefull else it will return false
                echo json_encode('success');
            } else {
                echo json_encode('error');
            }
        }
        else {
                echo json_encode('error');
            }
    }
    }
}

?>