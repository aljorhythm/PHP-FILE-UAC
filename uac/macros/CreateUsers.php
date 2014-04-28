<?php

include_once '../UAC.php';
//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
$macroEnabled = false;
if (!$macroEnabled) {
    exit();
}
$pass = "pass1"; //DEFINE PASSWORD HERE url: ../uac/macros/CreateUsers.php?pass=pass1
if (!(isset($_GET['pass']) && $_GET['pass'] === $pass)) {
    echo "error";
    exit();
}


//edit here!!
$users = array();
array_push($users, array("username", "password"));
array_push($users, array("admin1", "pass1234"));
array_push($users, array("joellim", "pass1234"));

// CREATE USERS
foreach ($users as $user) {
    echo "create " . UAC::CreateUser($user[0], $user[1]) . "<br>";
}


// CHECK USERS
echo intval(UAC::IsValidUser("Admin1", "pass1234")) . "<br>";
echo intval(UAC::IsValidUser("admin", "pass1234")) . "<br>";
echo intval(UAC::IsValidUser("joellim", "pass1234")) . "<br>";
echo intval(UAC::IsValidUser("username", "password")) . "<br>";
