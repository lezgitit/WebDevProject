<?php require("botdetect.php"); ?>

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

// if your form postbacks to a separate PHP file, first create the instance
    $ExampleCaptcha = new Captcha("ExampleCaptcha");

    // validate the Captcha to check we're not dealing with a bot
    $isHuman = $ExampleCaptcha->Validate();

    if($statement->RowCount() == 1 && password_verify($_POST['password'], $row['password']) && $isHuman)
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
      echo 'alert("Incorrect username/password or captcha")'; 
      echo '</script>';     
    }
  }


?>


<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link type="text/css" rel="Stylesheet" 
    href="<?php echo CaptchaUrls::LayoutStylesheetUrl() ?>" />
</head>
<body>

<form method="post">
<div class="container">
  <label for="username"><b>Username</b></label>
  <input type="text" placeholder="Enter Username" name="userName" required>

  <label for="password"><b>Password</b></label>
  <input type="password" placeholder="Enter Password" name="password" required>

  <?php // Adding BotDetect Captcha to the page 
  $ExampleCaptcha = new Captcha("ExampleCaptcha");
  $ExampleCaptcha->UserInputID = "CaptchaCode";
  echo $ExampleCaptcha->Html(); 
?>

<input name="CaptchaCode" id="CaptchaCode" type="text" />
  <INPUT name='submit' id='submit' type='submit'>
  <button> <a href ="index.php">Back</a></button>
</div>
</form>

</body>
</html>