<?php

@session_start();
//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once dirname(__FILE__) . '/UAC.php';
include_once dirname(__FILE__) . '/../utilities.php';

/*
  $username = "Admin1";
  $password = "joel1993";
  $uac->isLoggedIn("login.php");
  echo intval($uac->login($username, $password));
 */
if (isset($_GET["uac"])) {
    $uac = UACService::GetController();
    $request = $_GET["uac"];
    if ($request === 'logout') {
        echo intval($uac->logOut());
    } else if ($request === 'isLoggedIn') {
        echo intval($uac->isLoggedIn());
    }
} else if (isset($_POST["uac"])) {
    $uac = UACService::GetController();
    $request = $_POST["uac"];
    if ($request === 'login') {
        echo intval($uac->logIn());
    } else if ($request === 'logout') {
        echo intval($uac->logOut());
    } else if ($request === 'isLoggedIn') {
        echo intval($uac->isLoggedIn());
    } else if ($request === 'changePassword') {
        echo intval($uac->changePassword());
    } else if ($request === 'addUser') {
        echo intval($uac->toAdmin()->addUser());
    } else if ($request === 'deleteUser') {
        echo intval($uac->toAdmin()->deleteUser());
    }
}

class UACService {

    public static function GetController() {
        if (!SESSION::SESSION_IS_ACTIVE()) {
//for developers remember session_start();
            echo "session not started!";
        }
        $uac = new UACService();
        return $uac;
    }

    function toAdmin() {
        return new UACServiceAdmin($this);
    }

    function isLoggedIn($redirectPage = null) {
        if (isset($_SESSION["username"])) {
            return true;
        } else {
            if ($redirectPage === null) {
                $redirectPage = URI::QUERY_ANY('redirectPage');
            }
            self::redirect($redirectPage);
            return false;
        }
    }

    function isAdmin($redirectPage = null) {
        if ($this->isLoggedIn() && UAC::isAdmin($this->getUsername())) {
            return true;
        } else {
            if ($redirectPage === null) {
                $redirectPage = URI::QUERY_ANY('redirectPage');
            }
            self::redirect($redirectPage);
            return false;
        }
    }

    function getUsername() {
        return isset($_SESSION["username"]) ? $_SESSION["username"] : null;
    }

    function logOut($redirectPage = null) {
        session_destroy();
        if ($redirectPage === null) {
            self::redirect(URI::QUERY_ANY('redirectPage'));
        }
        return 'logged out';
    }

//Must use POST. username and password cannot be exposed in the URI in browser history
    function login() {
        $username = URI::QUERY_POST('username');
        $password = URI::QUERY_POST('password');
        $redirectFailure = URI::QUERY_POST('redirectFailure');
        $redirectSuccess = URI::QUERY_POST('redirectSuccess');

        if ($username === null || $password === null) {
            self::redirect($redirectFailure);
            return false;
        }

        $user = UAC::IsValidUser($username, $password);
        if ($user === false) {
            self::redirect($redirectFailure);
            return false;
        } else {
            $_SESSION["username"] = $username;
            self::redirect($redirectSuccess);
            return true;
        }
    }

    function changePassword() {
        $username = $this->getUsername();
        $password = URI::QUERY_POST('password');
        $newPassword = URI::QUERY_POST('newPassword1');
        $newPasswordReentry = URI::QUERY_POST('newPassword2');
        $redirectFailure = URI::QUERY_POST('redirectFailure');
        $redirectSuccess = URI::QUERY_POST('redirectSuccess');
        $user = UAC::IsValidUser($username, $password);

        $success = false;
        if ($this->isLoggedIn() && $newPassword === $newPasswordReentry && $user !== null) {
            $success = UAC::ChangePassword($username, $password, $newPassword);
        } else {
            self::redirect($redirectFailure);
            return false;
        }
        if ($success) {
            self::redirect($redirectSuccess);
            return true;
        } else {
            self::redirect($redirectFailure);
            return false;
        }
    }

    public static function redirect($redirectPage = null) {
        if (isset($redirectPage)) {
            header("Location: http://" . URI::HTTP_HOST() . "$redirectPage");
            exit();
        }
    }

}

class UACServiceAdmin extends UACService {

    public function __construct(UACService $uac) {
        if (!($uac->isAdmin() && $uac->isLoggedIn())) {
            throw new Exception("Not admin or not logged in");
        }
    }

    public function addUser() {
        $username = URI::QUERY_POST('username');
        $password = URI::QUERY_POST('password1');
        $passwordReentry = URI::QUERY_POST('password2');
        $redirectFailure = URI::QUERY_POST('redirectFailure');
        $redirectSuccess = URI::QUERY_POST('redirectSuccess');
        if (in_array($username, UAC::GetAllUsernames())) {
            self::redirect(URI::ADD_PARAM_TO_URL_STRING($redirectFailure, "error=exists"));
            return false;
        }
        if ($password === $passwordReentry) {
            $ret = UAC::CreateUser($username, $password);
            if ($ret !== null) {
                self::redirect($redirectSuccess);
                return true;
            } else {
                self::redirect($redirectFailure);
                return false;
            }
        } else {
            self::redirect($redirectFailure);
            return false;
        }
    }

    public function deleteUser() {
        $username = URI::QUERY_POST('username');
        $password = URI::QUERY_POST('password');
        $redirectFailure = URI::QUERY_POST('redirectFailure');
        $redirectSuccess = URI::QUERY_POST('redirectSuccess'); 
        $ret = UAC::DeleteUser($this->getUsername(), $password, $username);
        if ($ret !== null) {
            self::redirect($redirectSuccess);
            return true;
        } else {
            self::redirect($redirectFailure);
            return false;
        }
    }

}
