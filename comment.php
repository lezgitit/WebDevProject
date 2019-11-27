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
<title>Comment Page</title>
</head>
<body>
<div>
  <h1>Leave A Comment</h1>
</div>
<?php if(isset($_SESSION['userID'])): ?>
<div id="navbar">
  <span><a href="home.php">Home</a></span>
  <span><a href="index.php">View Posts</a></span>
  <span><a href="insert.php">Post</a></span>
  <span><a href="logout.php">Logout</a></span>
</div>
  <?php while($row = $statement->fetch()): ?>
<div>
  <form method="post" action="comment.php">
    <INPUT type = 'hidden' value = '<?php $row ['username'] ?>' id='userType' name='userType'>
    <textarea name='commentContent' COLS='90' ROWS='10'></textarea>
    <INPUT id='submit' type='submit'>
  </form>
</div>
<?php endwhile ?>
<?php elseif (!isset($_SESSION['userID'])): ?>
  <div id="navbar">
  <span><a href="home.php">Home</a></span>
  <span><a href="index.php">View Posts</a></span>
  <span><a href="signup.php">Sign Up</a></span>
  <span><a href="login.php">Login</a></span>
</div>
<div>
  <form method="post" action="comment.php">
    <INPUT type = 'hidden' value = "Anonymous" id='userType' name='userType'>
    <textarea name='commentContent' COLS='90' ROWS='10'></textarea>
    <INPUT id='submit' type='submit'>
  </form>
</div>
<?php endif ?>
</body>
</html>