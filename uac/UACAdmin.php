<!DOCTYPE HTML>
<html>
    <head> 
        <meta charset="UTF-8">
        <title>User Access Control Administrator Control Panel</title>
        <script src="../jquery/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
            });
        </script>

    </head>
    <body>
        <?php
        include_once (dirname(__FILE__) . '/UACService.php');
        include_once (dirname(__FILE__) . '/../utilities.php');
        $uac = UACService ::GetController();
        $requestUri = URI::HTTP_SELF();

        if ($uac->isAdmin()) {
            echo "Hi, " . $uac->getUsername();
            ?>
            <form action="./UACService.php" method="GET">
                <input type="hidden" name="uac" value="logout"/>
                <input type="submit" value="Logout"/>
                <input type="hidden" name="redirectPage" value="<?php echo $requestUri; ?>"/>
            </form>
            <form action="./UACService.php" method="POST">
                <h3>Add User</h3>
                <?php
                if (URI::QUERY_GET('uac') === 'addUser') {
                    echo "<span style='color:red'>";
                    if (URI::QUERY_GET('response') === 'success') {
                        echo "User added successfully";
                    } else {
                        echo "User added unsuccessfully<br>Must start with letter, 6-32 characters, Letters and numbers only";
                        if (URI::QUERY_GET('error') === 'exists') {
                            echo "<br>User exists";
                        }
                    }
                    echo "</span><br>";
                }
                ?>
                <input type="hidden" name="uac" value="addUser"/>
                Username: <input type="text" name="username"/><br>
                Password: <input type="password" name="password1"/><br>
                Reenter Password: <input type="password" name="password2"/><br>
                <input type="hidden" name="redirectFailure" value="<?php echo urldecode(URI::QUERY_ANY('redirectFailure', "$requestUri?response=failure&uac=addUser")); ?>"/>      
                <input type="hidden" name="redirectSuccess" value="<?php echo urldecode(URI::QUERY_ANY('redirectSuccess', "$requestUri?response=success&uac=addUser")); ?>"/>

                <input type="submit" value="Add"/>
            </form>
            <form action="./UACService.php" method="POST">
                <h3>Delete User</h3>
                <?php
                if (URI::QUERY_GET('uac') === 'delete') {
                    echo "<span style='color:red'>";
                    if (URI::QUERY_GET('response') === 'success') {
                        echo "User deleted successfully";
                    } else {
                        echo "User deleted unsuccessfully";
                    }
                    echo "</span><br>";
                }
                ?>
                <input type="hidden" name="uac" value="deleteUser"/>
                User to delete: <input type="text" name="username"/><br>
                Admin password: <input type="password" name="password"/><br> 
                <input type="hidden" name="redirectFailure" value="<?php echo urldecode(URI::QUERY_ANY('redirectFailure', "$requestUri?response=failure&uac=deleteUser")); ?>"/>      
                <input type="hidden" name="redirectSuccess" value="<?php echo urldecode(URI::QUERY_ANY('redirectSuccess', "$requestUri?response=success&uac=deleteUser")); ?>"/>

                <input type="submit" value="Delete"/>
            </form>
            <h3>Users</h3>
            <?php
            foreach (UAC::GetAllUsernames() as $username) {
                echo $username . "<br>";
            }
            ?>
            <?php
        } else {
            if ($uac->isLoggedIn()) {
                echo "Sorry " . $uac->getUsername() . ", you are not an administrator.<br>Please login as administrator ";
            }
            ?>
            <form action="./UACService.php" method="POST">
                <input type="hidden" name="uac" value="login"/>
                <input type="hidden" name="redirectFailure" value="<?php echo urldecode(URI::QUERY_ANY('redirectFailure', URI::HTTP_SELF())); ?>"/>      
                <input type="hidden" name="redirectSuccess" value="<?php echo urldecode(URI::QUERY_ANY('redirectSuccess', URI::HTTP_SELF())); ?>"/>
                Username: <input type="text" name="username" value=""/> <br>
                Password: <input type="password" name="password" value="login"> <br>
                <input type="submit" value="Login"/>
            </form>
            <?php
        }
        ?>

    </body>
</html>