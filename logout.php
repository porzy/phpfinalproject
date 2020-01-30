<?php
//Tyler Porznak
//dec 3, 2018
//web dev 2
//final project
require 'connect.php';


session_start();
unset($_SESSION['userid']);
unset($_SESSION['username']);
unset($_SESSION['usertype']);
unset($_SESSION['username']);
unset($_SESSION['email']);


header("Location: index.php");
?>