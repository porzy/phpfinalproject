<?php
//Tyler Porznak
//dec 3, 2018
//web dev 2
//final project
$username   = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id   = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$usertype   = filter_input(INPUT_POST, 'usertype', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password      = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password2      = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
session_start();



if(isset($_REQUEST['command'])) {
    require 'connect.php';

    if ($_REQUEST['command'] == 'Create') {
        if ((strlen($username)>1) && $password = $password2) {

            $query     = "INSERT INTO users (UserType, UserName, Password) VALUES (1,:username,:password)";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username, PDO::PARAM_STR);
            $statement->bindValue(':password', $password, PDO::PARAM_STR);
            $statement->execute();
            header("Location: login.php");
        }
    } else if ($_REQUEST['command'] == 'Update') {

        $query     = "UPDATE users SET  usertype = :usertype, username = :username WHERE userid = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->bindValue(':usertype', $usertype, PDO::PARAM_INT);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
        $statement->execute();
        header("Location: userspage.php");

    } else if ($_REQUEST['command'] == 'Delete') {
        $query = "DELETE FROM users WHERE userid = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
        $statement->execute();
        if($id = $_SESSION['userid'])
            {
                session_unset();
                header("Location: index.php");
            }
            else{
                header("Location: userspage.php");
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title> Register Errod</title>
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <h1><a href="register.php">register</a></h1>
            </div>
            <?php echo $username.$password.$password2;?>

            <h1>An error occured while processing your post.</h1>
            <?php if ((strlen($username)>1) ):?>

                <p> the username, email, and name must be at least one character.</p>
            <?php endif?>
            <?php if(!$password = $password2):?>
                <p>Passwords must match</p>
            <?php endif?>
            <a href="index.php">Return Home</a>

            <div id="footer">
                Copyright <?php echo date('Y') ?> - All Rights Reserved
            </div> 
        </div> 
    </body>
    </html>