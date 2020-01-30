<?php
/*
Tyler Porznak
connect.php - connects to database
*/
// connect to the database server by creating an PDO object
	define('DB_DSN','mysql:host=localhost;dbname=project;charset=utf8');
	define('DB_USER','serveruser');
	define('DB_PASS','password');

// add error handing to the previous connection script
	try {
		$db = new PDO(DB_DSN, DB_USER, DB_PASS);
	} catch (PDOException $e) {
		print "Connection Error: " . $e->getMessage();
		// Force execution to stop on errors.
		die();
  }
?>