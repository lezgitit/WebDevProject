<?php
//Calls the authenticate.php file
require('authenticate.php');

session_start();
// If an input is given as well ast title and content
if($_POST && isset($_POST['commentContent'])) 
{
  //Sanitize the input to prevent injection
  $commentContent = filter_input(INPUT_POST, 'commentContent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $userID = $_SESSION['userID'];
  $postID = $_POST['postID'];

  $query = "INSERT INTO comment (commentContent, userType, userID, id) VALUES (:commentContent, :userType, :userID, :postID)";
  $statement = $db->prepare($query);

  $statement->bindValue(':commentContent', $commentContent);
  $statement->bindValue(':userType', $userType);
  $statement->bindValue(':userID', $userID);
  $statement->bindValue(':postID', $postID);

  $statement->execute();
  
  header("Location:index.php");      
            
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Post A Comment</title>
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
<div>
  <form method="post" action="comment.php">
    <INPUT type = 'hidden' value = '<?=$_SESSION['userName']?>' id='userType' name='userType'>
    <input type="hidden" name="postID" value="<?=$_GET['id']?>">
    <textarea name='commentContent' COLS='90' ROWS='10'></textarea>
    <INPUT id='submit' type='submit'>
  </form>
</div>
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
    <input type="hidden" name="postID" value="<?=$_GET['id']?>">
    <textarea name='commentContent' COLS='90' ROWS='10'></textarea>
    <INPUT id='submit' type='submit'>
  </form>
</div>
<?php endif ?>
</body>
</html>