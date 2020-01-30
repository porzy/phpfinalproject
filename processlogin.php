<?php
//Tyler Porznak
//dec 3, 2018
//web dev 2
//final project
require 'connect.php';
$username   = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password      = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$query = "SELECT * FROM users WHERE username = :username && password = :password";
$statement = $db->prepare($query);
$statement->bindValue(':username', $username);
$statement->bindValue(':password', $password);
$statement->execute();
$post = $statement->fetch();

if (isset($post)){
session_start();
$_SESSION['userid'] = $post['UserId'];
$_SESSION['username'] = $post['UserName'];
$_SESSION['usertype'] = $post['UserType'];


header("Location: index.php");
}
if (!isset($post['UserName']))
{
    session_start();
    $_SESSION['loginerror'] = "Username or password is wrong";

    header("Location: login.php");
}
?>