<?php
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "unsetUsername":
            setcookie('userInfo', '', time()-60*60*24*365, '/');
            setcookie('loggedIn', '', time()-60*60*24*365, '/');
            header('Location: index.php');
            break;
    }
}

$cookie_name = "loggedIn";
$cookie_user = "userInfo";
if (!isset($_COOKIE[$cookie_name]) || !isset($_COOKIE[$cookie_user])) {
    header('Location: index.php');
    setcookie('userInfo', '', time()-60*60*24*365, '/');
}
if (isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] == 'false') {
    setcookie('userInfo', '', time()-60*60*24*365, '/');
    header('Location: index.php');
}
if (isset($_COOKIE[$cookie_user])) {
    $cookieId = $_COOKIE[$cookie_user];
    $deID = decryptThis($cookieId);
    $int = (int) preg_replace('/[^0-9]/', '', $deID);

    $result10 = $mysqli->query("select id from users where id=" . $int . "");
    $numberOfRows10 = mysqli_num_rows($result10);
    if($numberOfRows10 != 1){
            header('Location: index.php');
    } 
}


