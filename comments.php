<?php
//Tyler Porznak
//dec 3, 2018
//web dev 2
//final project
$commentid = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$imageid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
?>

<?php
require 'connect.php';
$query = "INSERT INTO comments(CommentId, UserId, Comment) values (:commentid, 1, :comment)";
$statement = $db->prepare($query);
$statement->bindValue(':commentid', $commentid);
$statement->bindValue(':comment', $comment);

$statement->execute();

$insert_id = $db->lastInsertId();

$query2 = "INSERT INTO image_comment(imagecommentid, ImageId, CommentId) values (:imageid, :commentid)";
$statement2 = $db->prepare($query2);
$statement2->bindValue(':imageid', $imageid);
$statement2->bindValue(':commentid', $commentid);


$statement2->execute();

$insert_id = $db->lastInsertId();



header("location: showimage.php?id=");
?>