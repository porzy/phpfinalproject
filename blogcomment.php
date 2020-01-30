<?php
//Tyler Porznak
//dec 3, 2018
//web dev 2
//final project
session_start();
$bcommentid = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$bcomment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
?>

<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/project/securimage/securimage.php';

$securimage= new Securimage();
if($securimage->check($_POST['captcha_code'])==false){
	echo"the security code entered was incorrect.<br /><br />";
	echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	exit;
}
if (isset($_SESSION['blog'])) {
	$blogid = $_SESSION['blog'];
	if (isset($_SESSION['userid'])) {
		$userid = $_SESSION['userid']; 
	}
}

?>

<?php
if(isset($_REQUEST['command'])) {
	require 'connect.php';

	if ($_REQUEST['command'] == 'Create') {
		if ((strlen($bcomment)>1)) {

			$query = "INSERT INTO blog_comment(BlogCommentId, BlogId, UserId, Comment) values (:bcommentid, :blogid, :userid, :bcomment)";
			$statement = $db->prepare($query);
			$statement->bindValue(':bcommentid', $bcommentid);
			$statement->bindValue(':blogid', $blogid);
			$statement->bindValue(':bcomment', $bcomment);
			$statement->bindValue(':userid', $userid);

			$statement->execute();

			$insert_id = $db->lastInsertId();
			header("Location: showblog.php?id=$blogid?");
		}
	} else if ($_REQUEST['command'] == 'Update') {

		$query     = "UPDATE blog_comment SET Comment = :bcomment WHERE BlogCommentId = :id";
		$statement = $db->prepare($query);
		$statement->bindValue(':bcomment', $bcomment);
		$statement->bindValue(':id', $bcommentid, PDO::PARAM_INT);

		$statement->execute();
		header("Location: showblog.php?id=$blogid?");

	} else if ($_REQUEST['command'] == 'Delete') {
		$query = "DELETE FROM blog_comment WHERE BlogCommentId = :id";
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $bcommentid, PDO::PARAM_INT);

		$statement->execute();
		header("Location: showblog.php?id=$blogid?");
	}
}
?>