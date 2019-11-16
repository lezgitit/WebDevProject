<?php
//Calls the authenticate.php file
require('authenticate.php');

session_start();

// If an input is given as well ast title and content
if($_POST && isset($_POST['commentTitle']) && isset($_POST['commentContent']) && isset($_POST['userType'])) 
{
  //Sanitize the input to prevent injection
  $commentTitle = filter_input(INPUT_POST, 'commentTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $commentContent = filter_input(INPUT_POST, 'commentContent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "INSERT INTO comment (commentTitle, commentContent, userType) VALUES (:commentTitle, :commentContent, :userType)";
    $statement = $db->prepare($query);

    $statement->bindValue(':commentTitle', $commentTitle);
    $statement->bindValue(':commentContent', $commentContent);
    $statement->bindValue(':userType', $userType);

    $statement->execute();
    
    header("Location:index.php");      
            
}

?>

<!DOCTYPE html>
<html>
<head>
<title>New Post</title>
</head>
<body>
<div>
  <h1>Beauty Post</h1>
</div>
<div id="navbar">
  <?php include('nav.php') ?>
</div>
<div>
  <form method="post" action="comment.php">
    <h1>Beauty Title</h1>
    <INPUT id='commentTitle' name='commentTitle'>
    <h1>Username</h1>
    <INPUT id='userType' name='userType'>
    <h1>Beauty Content</h1>  
    <textarea name='commentContent' COLS='90' ROWS='10'></textarea>
    <INPUT id='submit' type='submit'>
  </form>
</div>
</body>
</html>