<?php
//Tyler Porznak
//dec 3, 2018
//web dev 2
//final project
require 'connect.php';

$query = "SELECT * FROM blog ORDER BY blogid DESC LIMIT 5";
$statement = $db->prepare($query); 
$statement->execute(); 
$posts= $statement->fetchAll();

$query = "SELECT * FROM image_post ORDER BY imageid DESC LIMIT 5";
$statement2 = $db->prepare($query); 
$statement2->execute(); 
$images= $statement2->fetchAll();

session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>TPP</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Tyler Porznak Photography</a></h1>
            <h2>PhotoStream and Blog</h2>
            <div id="loginbar">
                <?php 
                if (isset($_SESSION['username'])):?>
                    <p><?php echo $_SESSION['username']?></p>
                    <a href="logout.php">Log Out</a>
                <?php endif?>
                <?php if(!isset($_SESSION['username'])):?>
                    <a href="login.php" >Login</a>
                    <a href="register.php" >Register</a>
                <?php endif?>
            </div>
            <div id="searchbar">
                <form method="post" action="search.php">
                    <input type="text" name="search" id="search">
                    <br>
                    <label for="blograd">blogs</label>
                    <input type="radio" name="searchrad" id="blograd" value="blogs">
                    
                    <label for="imagerad">images</label>
                    <input type="radio" name="searchrad" id="imagerad" value="images">
                    
                    <label for="bothrad">both</label>
                    <input type="radio" name="searchrad" id="bothrad" value="both">
                    <br>
                    <input type="submit" name="searchbuttom" value="search">
                </form>
            </div>
        </div> 
        <ul id="menu">
            <li><a href="index.php" class='active'>Home</a></li>
            <li><a href="fullBlog.php" >View All Blog Posts</a></li>
            <li><a href="fullimage.php" >View all Images</a></li>
            <?php
            if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == 2):?>
                <li><a href="createimage.php" >New Image</a></li>
                <li><a href="createblog.php" >New Blog Post</a></li>
                <li><a href="userspage.php" >Users</a></li>
            <?php endif ?>
        </ul> 
        <div id="all_blogs">
            <li><a href="fullBlog.php" >View All Blog Posts</a></li>
            <?php foreach($posts as $post): ?>
                <?php ?>
                <div class="blog_post">
                    <h2><a href="showblog.php?id=<?= $post['BlogId'] ?>&<?= urlencode($post['Title'])?>"><?= $post['Title'] ?></a></h2>
                    <p>
                        <small>
                            <?php echo date("F d, Y, h:i a", strtotime($post['Date'])); ?>
                            <?php
                            if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == 2):?>
                                <a href="editblog.php?id=<?= $post['BlogId'] ?>&<?= urlencode($post['Title'])?>">edit</a>
                            <?php endif?>
                        </small>
                    </p>
                    <div class='blog_content'>
                        <?php if (strlen($post['Content']) > 200) : ?>
                            <?php echo substr($post['Content'], 0, 200); ?>
                            ... <a href="showblog.php?id=<?= $post['BlogId'] ?>&<?= urlencode($post['Title'])?>">Read Full Post</a>
                            <?php else: ?>
                                <?= $post['Content'] ?>
                               
                            <?php endif ?>
                        </div>
                    </div>
                    <p>-----------------------------------------------------------------------------------------</p>
                <?php endforeach ?>
                <li><a href="fullBlog.php" >View All Blog Posts</a></li>
            </div>
            <div id="all_images">
                <li><a href="fullimage.php" >View all Images</a></li>
                <?php foreach($images as $image): ?>
                    <div class="images">
                        <h2><a href="showimage.php?id=<?= $image['ImageId'] ?>&<?= urlencode($image['Title'])?>"><?= $image['Title'] ?></a></h2>
                        <p>
                            <small>
                                <?php echo date("F d, Y, h:i a", strtotime($image['Date'])); ?>
                                <?php
                                if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == 2):?>
                                    <a href="editimage.php?id=<?= $image['ImageId'] ?>&<?= urlencode($image['Title'])?>">edit</a>
                                <?php endif?>
                            </small>
                        </p>
                        <div class='image_content'>
                            <?php echo '<image src="data:image/jpeg;base64,'.base64_encode($image['Image']).'"width="200"/>';?>
                            <br>
                            <a href="showimage.php?id=<?= $image['ImageId'] ?>&<?= urlencode($image['Title'])?>">View Full Image</a>
                        </div>
                    </div>
                    <p>-----------------------------------------------------</p>
                <?php endforeach ?>
                <li><a href="fullimage.php" >View all Images</a></li>
            </div> 
            <div id="footer">
                Copyright <?php echo date('Y') ?> - All Rights Reserved
            </div> 
        </div> 
    </body>
    </html>
