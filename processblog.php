<?php
//Tyler Porznak
//dec 3, 2018
//web dev 2
//final project
$title   = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

if(isset($_REQUEST['command'])) {
    require 'connect.php';

    if ($_REQUEST['command'] == 'Create') {
        if ((strlen($title)>1) && (strlen($content)>1)) {

            $query     = "INSERT INTO blog (title, content) VALUES (:title, :content)";
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            
            $statement->execute();
            header("Location: index.php");
        }
    } else if ($_REQUEST['command'] == 'Update') {

        $query     = "UPDATE blog SET title = :title, content = :content WHERE blogid = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
        $statement->execute();
        header("Location: index.php");

    } else if ($_REQUEST['command'] == 'Delete') {
        $query = "DELETE FROM blog WHERE BlogId = :id";
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
    <title> Tyler Porznak Photography - Index</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">TPP Blog</a></h1>
        </div>
        <h1>An error occured while processing your post.</h1>
        <p>Both the title and content must have at least one character.</p>
        <a href="index.php">Return Home</a>

        <div id="footer">
            Copyright <?php echo date('Y') ?> - All Rights Reserved
        </div> 
    </div> 
</body>
</html>
