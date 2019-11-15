<?php
//Calls the authenticate.php file
  require('authenticate.php');

// If an input is given as well ast title and content
  if($_POST && isset($_POST['title']) && isset($_POST['content'])) 
  {
//Sanitize the input to prevent injection
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//If title and content string length is greater than zero
    if((strlen($title) > 0) && (strlen($content) > 0))
    { 

      $query = "INSERT INTO post (title, content) VALUES (:title, :content)";
      $statement = $db->prepare($query);

      $statement->bindValue(':title', $title);
      $statement->bindValue(':content', $content);

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
  <div>
    <h1>Beauty Post</h1>
  </div>
  <div id="navbar">
    <?php include('nav.php') ?>
  </div>
  <div>
    <form method="post" action="insert.php">
      <h2>Beauty Title</h2>
      <INPUT id='title' name='title'>
      <h2>Beauty Content</h2>  
      <textarea name='content' COLS='90' ROWS='10'></textarea>
      <INPUT id='submit' type='submit'>
    </form>
  </div>
</body>
</html>