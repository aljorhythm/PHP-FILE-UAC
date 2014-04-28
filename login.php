<?php
session_start();
//debugging  
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<!DOCTYPE HTML>
<html>
    <head> 
        <meta charset="UTF-8">
        <title>Login</title>
        <script src="./jquery/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
            });
        </script>

    </head>
    <body>
        <?php
        include_once ('./uac/UACService.php');
        include_once ('./utilities.php');
        $uac = UACService ::GetController();
        $requestUri = URI::HTTP_SELF();
        if ($uac->isLoggedIn()) {
            echo "Hi, " . $uac->getUsername();
            if ($uac->isAdmin()) { 
                echo "<br><a href='./uac/UACAdmin.php'>Admin Panel</a>";
            }
            ?>

            <form action="./uac/UACService.php" method="POST">
                <input type="hidden" name="uac" value="logout"/>
                <input type="submit" value="Logout"/>
                <input type="hidden" name="redirectPage" value="<?php echo $requestUri; ?>"/>
            </form>
            <form action="./uac/UACService.php" method="POST">
                <h2>Change Password</h2>
                <?php
                if (URI::QUERY_GET('uac') === 'changePassword') {
                    echo "<span style='color:red'>";
                    if (URI::QUERY_GET('response') === 'success') {
                        echo "Password changed successfully";
                    } else {
                        echo "Password change failed";
                    }
                    echo "</span><br>";
                }
                ?>
                <input type="hidden" name="uac" value="changePassword"/>
                Current Password: <input type="password" name="password"/>    <br>
                New Password: <input type="password" name="newPassword1"/>    <br>
                Reenter Password: <input type="password" name="newPassword2"/>               <br>
                <input type="hidden" name="redirectFailure" value="<?php echo urldecode(URI::QUERY_ANY('redirectFailure', "$requestUri?response=failure&uac=changePassword")); ?>"/>      
                <input type="hidden" name="redirectSuccess" value="<?php echo urldecode(URI::QUERY_ANY('redirectSuccess', "$requestUri?response=success&uac=changePassword")); ?>"/>

                <input type="submit" value="Change"/> 
            </form>
    <?php
} else {
    ?> 
            <form action="./uac/UACService.php" method="POST">
                <input type="hidden" name="uac" value="login"/>
                <input type="hidden" name="redirectFailure" value="<?php echo urldecode(URI::QUERY_ANY('redirectFailure', "$requestUri?response=failure")); ?>"/>      
                <input type="hidden" name="redirectSuccess" value="<?php echo urldecode(URI::QUERY_ANY('redirectSuccess', "$requestUri?response=success")); ?>"/>
                Username: <input type="text" name="username" value=""/> <br>
                Password: <input type="password" name="password" value="login"> <br>
                <input type="submit" value="Login"/>
            </form>
    <?php
}
?>

    </body>
</html>