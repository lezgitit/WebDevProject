<?php

require('authenticate.php');
session_start();

    if($_POST && isset($_POST['submit']) && isset($_POST['userName']) && isset($_POST['password']))
    {
      
      $Username = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $query = "SELECT * FROM user WHERE userName = :Username";
      $statement = $db->prepare($query);
      $statement->bindValue(':Username', $Username);
      $statement->execute();
      $row = $statement->fetch();
      if($statement->RowCount() == 1 && password_verify($_POST['password'], $row['password']))
      {

        echo "<h1>---------------</h1>"; 
        $_SESSION['userID'] =  $row['userID'];
        $_SESSION['userName'] =  $row['userName'];
        $_SESSION['fullName'] =  $row['fullName'];
        $_SESSION['accountType'] = $row['accountType'];
        
        header("refresh:.1; url=index.php");
        echo '<script language ="javascript">';
        echo 'alert("Welcome!")'; 
        echo '</script>';
      }
      else
      {
        echo '<script language ="javascript">';
        echo 'alert("Incorrect username or password")'; 
        echo '</script>';     
      }
    }


?>


<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="Index.css">
</head>
<body>

  <form method="post">
  <div class="container">
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="userName" required>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
    <INPUT name='submit' id='submit' type='submit'>
    <button> <a href ="index.php">Back</a></button>
  </div>
</form>

</body>
</html>