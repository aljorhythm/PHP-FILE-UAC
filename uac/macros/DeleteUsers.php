<?php

include_once '../UAC.php';
//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
$macroEnabled = false;
if (!$macroEnabled) {
    exit();
}
$pass = "pass1";  //DEFINE PASSWORD HERE url: ../uac/macros/DeleteUsers.php?pass=pass1
if (!(isset($_GET['pass']) && $_GET['pass'] === $pass)) {
    echo "error";
    exit();
}
echo "clear all<br>";
echo var_dump(UAC::DeleteAllUsers());
