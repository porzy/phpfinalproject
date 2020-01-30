<?php
//Tyler Porznak
//dec 3, 2018
//web dev 2
//final project
require 'connect.php';
$query = "SELECT Image FROM image_post WHERE ImageId = :id" ;
$statement = $db->prepare($query); 
$statement->execute(array(':id'=>$_GET['id']));
$data = $query->fetch();


	echo $_GET['id'];

?>