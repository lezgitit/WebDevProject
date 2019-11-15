<?php
//Calls the authenticate.php file
  require('authenticate.php');

//Creates a username wally
  //define('ADMIN_LOGIN','wally');
//Creates a password mypass
  //define('ADMIN_PASSWORD','mypass');
//If the ussername and/or password input is incorrect
  //if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])
      //|| ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)
      //|| ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD))
//Not sure where these are linked to
  //{
    //header('HTTP/1.1 401 Unauthorized');
    //header('WWW-Authenticate: Basic realm="Our Blog"');
    //exit("Access Denied: Username and password required.");
  //}

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
        header("processing.php");
    }           
  }

?>
<!--this is where the form starts-->
<!DOCTYPE html>
<html>
<head>
  <title>New Post</title>
</head>
<body>
  <div>
    <h1>Blog Post</h1>
  </div>
  <div id="navbar">
    <?php include('nav.php') ?>
  </div>
  <div>
    <form method="post" action="insert.php">
      <h2>Blog Title</h2>
      <INPUT id='title' name='title'>
      <h2>Blog Content</h2>  
      <textarea name='content' COLS='90' ROWS='10'></textarea>
      <INPUT id='submit' type='submit'>
    </form>
  </div>
</body>
</html>