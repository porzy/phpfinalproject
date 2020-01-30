<?php
//Tyler Porznak
//dec 3, 2018
//web dev 2
//final project
session_start();
$commentid = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
?>

<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/project/securimage/securimage.php';

$securimage= new Securimage();
if($securimage->check($_POST['captcha_code'])==false){
	echo"the security code entered was incorrect.<br /><br />";
	echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	exit;
}
if (isset($_SESSION['remember'])) {
	$imageid = $_SESSION['remember'];

	if (isset($_SESSION['userid'])) {
		$userid = $_SESSION['userid']; 
	}
}
?>


<?php
if(isset($_REQUEST['command'])) {
	require 'connect.php';

	if ($_REQUEST['command'] == 'Create') {
		if ((strlen($comment)>1)) {

			$query = "INSERT INTO image_comment(ImageCommentId, ImageId, UserId, Comment) values (:commentid, :imageid, :userid, :comment)";
			$statement = $db->prepare($query);
			$statement->bindValue(':commentid', $commentid);
			$statement->bindValue(':imageid', $imageid);
			$statement->bindValue(':comment', $comment);
			$statement->bindValue(':userid', $userid);

			$statement->execute();

			$insert_id = $db->lastInsertId();
			header("Location: showimage.php?id=$imageid?");
		}
	} else if ($_REQUEST['command'] == 'Update') {

		$query     = "UPDATE image_comment SET Comment = :comment WHERE imagecommentId = :id";
		$statement = $db->prepare($query);
		$statement->bindValue(':comment', $comment);
		$statement->bindValue(':id', $commentid, PDO::PARAM_INT);

		$statement->execute();
		header("Location: showimage.php?id=$imageid?");

	} else if ($_REQUEST['command'] == 'Delete') {
		$query = "DELETE FROM image_comment WHERE imagecommentId = :id";
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $commentid, PDO::PARAM_INT);

		$statement->execute();
		header("Location: showimage.php?id=$imageid?");
	}
}
?>