<?php

//debugging  
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once (dirname(__FILE__) . '/../utilities.php');

class UAC {

    private static function GetFilename() {
        return dirname(__FILE__) . "/uac";
    }

//null if unsuccessful
//username if successful
    static function CreateUser($username, $passwordPlain) {
//todo check user exists
        if (!(self::CommonUsernameValidation($username) && self::CommonPasswordValidation($passwordPlain))) {
            return null;
        }
        $line = self::UserToLine($username, $passwordPlain);

        File::AppendNewLineToFile(self::GetFilename(), $line);
        return $username;
    }

    protected static function UserToLine($username, $passwordPlain) {
        $hash = Password::HASH($passwordPlain);
        return "$username$hash";
    }

    private static function GetUser($username) {
        $ret = File::SearchLine(self::GetFilename(), $username, "$", true);

        if ($ret === false) {
            return false;
        } else {
            return self::LineToUser($ret);
        }
    }

    protected static function LineToUser($line) {
        $passwordHashIndex = strpos($line, "$");
        $username = substr($line, 0, $passwordHashIndex);
        $passwordHash = substr($line, $passwordHashIndex);
        return array("username" => $username, "passwordHash" => $passwordHash);
    }

    static function IsValidUser($username, $passwordPlain) {

        $user = self::GetUser($username);
        if ($user !== false) {
            return Password::VERIFY($passwordPlain, $user["passwordHash"]);
        } else {
//doesn't exist in database    
            return false;
        }
    }

    static function isAdmin($username) {
        return strpos(strtolower($username), 'admin') !== false;
    }

//username if successful
    //null if not
    static function DeleteUser($adminUsername, $adminPassword, $username) {
        if (self::IsValidUser($adminUsername, $adminPassword) && self::isAdmin($adminUsername)) {
            File::RemoveLineMeetsCriteria(self::GetFilename(), new UAC_CheckLineUsername($username));
            return $username;
        } else {
            return null;
        }
    }

    static function ChangePassword($username, $passwordPlain, $newPassword) {
        if (self::IsValidUser($username, $passwordPlain)) {
            File::EditLine(self::GetFilename(), new UAC_EditLineUsername($username, $newPassword), true);
            return true;
        } else {
            return false;
        }
    }

    static function GetAllUsernames() {
        $retArr = File::LinesExcludeEmptyAsArray(self::GetFilename());
        foreach ($retArr as $key => $line) {
            $retArr[$key] = self::LineToUser($line);
            $retArr[$key] = $retArr[$key]['username'];
        }
        return $retArr;
    }

    static function DeleteAllUsers() {
        return file_put_contents(self::GetFilename(), "");
    }

//http://stackoverflow.com/questions/13392842/using-php-regex-to-validate-username
//Must start with letter
//6-32 characters
//Letters and numbers only
    private static function CommonUsernameValidation($username) {
        return preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $username);
    }

    private static function CommonPasswordValidation($password) {
        return true;
    }

}

class UAC_CheckLineUsername extends UAC implements Callback {

    protected $username;

    public function __construct($username) {
        $this->username = $username;
    }

    protected static function LINE_CHECK_USERNAME($line, $username) {
        $user = self::LineToUser($line);
        return $user['username'] === $username;
    }

    public function callback($line) {
        return self::LINE_CHECK_USERNAME($line, $this->username);
    }

}

class UAC_EditLineUsername extends UAC_CheckLineUsername {

    protected $passwordPlain;

    public function __construct($username, $passwordPlain) {
        parent::__construct($username);
        $this->passwordPlain = $passwordPlain;
    }

    public function callback($line) {
        if (self::LINE_CHECK_USERNAME($line, $this->username)) {
            $user = self::LineToUser($line);
            return self::UserToLine($user['username'], $this->passwordPlain);
        }
        return null;
    }

}

class Password {
    /*
     * https://github.com/ircmaxell/password_compat
     * http://www.openwall.com/phpass/
     */

    static $BackwardCompatiblePHP_5_2 = true;

    static function HASH($passwordPlain) {
        if (self::$BackwardCompatiblePHP_5_2) {
            include_once dirname(__FILE__) . '/phpass/PasswordHash.php';
            $hasher = new PasswordHash(8, false);
            return $hasher->HashPassword($passwordPlain);
        }
        if (version_compare(phpversion(), '5.3.7', '>=')) {
            if (!version_compare(phpversion(), '5.5.0', '>=')) {
                include_once dirname(__FILE__) . '/password_compat/lib/password.php';
            }
            return password_hash($passwordPlain, PASSWORD_BCRYPT);
        } else {
            include_once dirname(__FILE__) . '/phpass/PasswordHash.php';
            $hasher = new PasswordHash(8, false);
            return $hasher->HashPassword($passwordPlain);
        }
    }

    static function VERIFY($password, $hash) {
        if (self::$BackwardCompatiblePHP_5_2) {
            include_once dirname(__FILE__) . '/phpass/PasswordHash.php';
            $hasher = new PasswordHash(8, false);
            return $hasher->CheckPassword($password, $hash);
        }
        if (version_compare(phpversion(), '5.3.7', '>=')) {
            if (!version_compare(phpversion(), '5.5.0', '>=')) {
                include_once dirname(__FILE__) . '/password_compat/lib/password.php';
            }
            return password_verify($password, $hash);
        } else {
            include_once dirname(__FILE__) . '/phpass/PasswordHash.php';
            $hasher = new PasswordHash(8, false);
            return $hasher->CheckPassword($password, $hash);
        }
    }

}
