<?php
//Calls the authenticate.php file
require('authenticate.php');

session_start();

// If an input is given as well ast title and content
if($_POST && isset($_POST['title']) && isset($_POST['content'])) 
{
//Sanitize the input to prevent injection
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $userID = $_SESSION['userID'];
  $fullName = $_SESSION['fullName'];

//If title and content string length is greater than zero
  if((strlen($title) > 0) && (strlen($content) > 0))
  { 

    $query = "INSERT INTO post (title, content, userID, fullName) VALUES (:title, :content, :userID, :fullName)";
    $statement = $db->prepare($query);

    $statement->bindValue(':title', $title);
    $statement->bindValue(':content', $content);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':fullName', $fullName);

    $statement->execute();
    
    header("Location:index.php");      
  }
  else
  {
      header("Location:processing.php");
  }           
}

?>

<!DOCTYPE html>
<html>
<head>
<title>New Post</title>
</head>
<body>
  <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<div>
  <h1>Beauty Post</h1>
</div>
<div id="navbar">
  <?php include('nav.php') ?>
</div>
<div>
  <form method="post" action="insert.php">
    <h>Beauty Title</h1>
    <INPUT id='title' name='title'>
    <h1>Beauty Content</h1>  
    <textarea name='content' COLS='90' ROWS='10'></textarea>
    <script type="text/javascript">
      CKEDITOR.replace('content');
    </script>
    <INPUT id='submit' type='submit'>
  </form>
</div>
</body>
</html>