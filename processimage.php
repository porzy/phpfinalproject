<?php
//Tyler Porznak
//dec 3, 2018
//web dev 2
//final project
$title   = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$blob    = file_get_contents($_FILES['image']['tmp_name']);
$id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);




if(isset($_REQUEST['command'])) {
    require 'connect.php';

    if ($_REQUEST['command'] == 'Create') {
        if ((strlen($title)>1)) {

            $query     = "INSERT INTO image_post (title, image) VALUES (:title, :blob)";
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':blob', $blob, PDO::PARAM_LOB);

            
            $statement->execute();
            header("Location: index.php");
        }
    } else if ($_REQUEST['command'] == 'Update') {

        $query     = "UPDATE image_post SET title = :title WHERE ImageId = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
        $statement->execute();
        header("Location: index.php");
    } else if ($_REQUEST['command'] == 'Delete') {
        $query = "DELETE FROM image_post WHERE ImageId = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
        $statement->execute();
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> My Blog - Index</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">My Blog</a></h1>
        </div>
        <h1>An error occured while processing your post.</h1>
        <p>Both the title and content must be at least one character.</p>
        <a href="index.php">Return Home</a>

        <div id="footer">
            Copyright <?php echo date('Y') ?> - All Rights Reserved
        </div> 
    </div> 
</body>
</html>
