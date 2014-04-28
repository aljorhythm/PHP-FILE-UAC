<?php

include_once '../UAC.php';
//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
$pass = "pass"; //DEFINE PASSWORD HERE

foreach (UAC::GetAllUsernames() as $username) {
    echo "' $username '<br>";
}
if (!(isset($_GET['pass']) && $_GET['pass'] === $pass)) {
    echo "error";
    exit();
}
/*
  $admin = "admin1";
  $passwordPlain = "pass1234";
  $user = "username";
  echo "deleting user $user " . intval(UAC::DeleteUser($admin, $passwordPlain, $user)) . "<br>";
  echo intval(UAC::IsValidUser($username, $passwordPlain)) . "<br>";
 */

$username = "joellim";
$password = "pass1234";
$newPassword = "newPass";

echo intval(UAC::IsValidUser($username, $password));
echo intval(UAC::ChangePassword($username, $password, $newPassword));
echo intval(UAC::IsValidUser($username, $password));
echo intval(UAC::IsValidUser($username, $newPassword));
