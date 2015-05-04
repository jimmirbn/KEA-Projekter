<?php

$mysqli = new mysqli("localhost", "root", "Durant35", "Hacking");
if ($mysqli->connect_errno) {
    echo "WARNING DATABASE FAILED: " . $mysqli->connect_error;
}
ob_start();

function generateSalt($length = 64) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVXYZ';
    $charactersLength = strlen($characters);
    $Salt = '';
    for ($i = 0; $i < $length; $i++) {
        $Salt .= $characters[rand(0, $charactersLength - 1)];
    }
    return $Salt;
}
function generateNr($length = 7) {
    $characters = '123456789';
    $charactersLength = strlen($characters);
    $Salt = '';
    for ($i = 0; $i < $length; $i++) {
        $Salt .= $characters[rand(0, $charactersLength - 1)];
    }
    return $Salt;
}

function cleanInput($input) {
    $search = array(
        '@<script[^>]*?>.*?</script>@si', // Strip out javascript
        '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
        '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
    );
    $output = preg_replace($search, '', $input);
    return $output;
}

function encryptThis($input) {
    $MASTERKEY = "Durant35";
    $td = mcrypt_module_open('tripledes', '', 'ecb', '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $MASTERKEY, $iv);
    $crypted_value = mcrypt_generic($td, $input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return base64_encode($crypted_value);
}

function decryptThis($input2) {
    $MASTERKEY = "Durant35";
    $td = mcrypt_module_open('tripledes', '', 'ecb', '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $MASTERKEY, $iv);
    $decrypted_value = mdecrypt_generic($td, base64_decode($input2));
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return $decrypted_value;
}
?>















