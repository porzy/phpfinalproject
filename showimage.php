<?php
//Tyler Porznak
//dec 3, 2018
//web dev 2
//final project
require 'connect.php';
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);


$query = "SELECT * FROM image_post WHERE imageid = :id";
$statement = $db->prepare($query);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch();
?>

<?php
session_start();
$_SESSION['remember'] = $id;
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

    <div id="images">
      <p>
        <h1><?= $post['Title'] ?></h1>
        <?php echo date("F d, Y, h:i a", strtotime($post['Date'])); ?>
        <?php
        if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == 2):?>
          <a href="editimage.php?id=<?= $post['ImageId'] ?>&<?= urlencode($post['Title'])?>">edit</a>
        <?php endif?>
      </p>
      <div class='image_content'>

        <?php echo '<image src="data:image/jpeg;base64,'.base64_encode($post['Image']).'"width="800"/>';?>
      </div>
    </div>

    <body>
      <div id="imputcomment">
        <h1>Comments</h1>
        <?php
        if(isset($_SESSION['usertype'])):?>
          <form method="post" action="imagecomments.php">
            <input type="textbox" name="comment" >
            <br>
            <br>
            <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image"/>
            <br>
            <input type="text" name="captcha_code" size="10" maxlength="6"/>
            <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[Different Image]</a>
            <br>
            <input type="submit" name="command" value="Create"></input>
          <?php endif?>
        </form>
      </div>
      <ul>
        <?php 
        $query2 = "SELECT * FROM image_comment WHERE ImageId = :id";
        $statement2 = $db->prepare($query2);
        $statement2->bindValue(':id', $post['ImageId'], PDO::PARAM_INT);
        $statement2->execute();
        $posts= $statement2->fetchAll(); 
        ?>
        <?php foreach($posts as $comments): ?>
          <?php 
          $query3 = "SELECT * FROM users WHERE UserId = :id";
          $statement3 = $db->prepare($query3);
          $statement3->bindValue(':id', $comments['UserId'], PDO::PARAM_INT);
          $statement3->execute();
          $user= $statement3->fetch(); 
          ?>
          <div id="comments">
          <li id="usercomment"><?php echo $user['UserName']?></li>
          <li><?php echo $comments['Comment']?> </li>
          <li><?php echo date("F d, Y, h:i a", strtotime($comments['Date'])); ?></li>
          <?php
          if(isset($_SESSION['usertype']) && $_SESSION['userid'] == $comments['UserId']):?>
            <br>
            <a href="editimagecomment.php?id=<?= $comments['ImageCommentId'] ?>&<?= urlencode($user['UserName'])?>">edit</a>
          <?php endif?>
          <p>------------------------------------------------------------------</p>
        </div>
        <?php endforeach?>
      </ul>
    </body>
    </html>
    <div id="footer">
      Copyright <?php echo date('Y') ?> - All Rights Reserved
    </div> 
  </div> 
</body>
</html>
