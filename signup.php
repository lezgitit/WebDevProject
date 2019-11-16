<?php

require('authenticate.php');


if($_POST && isset($_POST['userName']) && isset($_POST['fullName']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']))
{
$userName = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$fullName = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$accountType = filter_input(INPUT_POST, 'accountType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = $_POST['password'];
$password2 = $_POST['password2'];

if((strlen($userName) > 0) && (strlen($fullName) > 0) && (strlen($email) > 0) && (strlen($password == $password2) > 0))
{
$password = password_hash($password, PASSWORD_DEFAULT);
$query = "INSERT INTO user (userName, fullname, email, accountType, password) VALUES (:userName, :fullName, :email, :accountType, :password)";

$statement = $db->prepare($query);

$statement->bindValue(':userName', $userName);
$statement->bindValue(':fullName', $fullName);
$statement->bindValue(':email', $email);
$statement->bindValue(':accountType', $accountType);
$statement->bindValue(':password', $password);

$statement->execute();
header("refresh:.5; url=index.php");
echo '<script language ="javascript">';
echo 'alert("You are now registered")';
echo '</script>';
}
else
{
echo '<script language ="javascript">';
echo 'alert("Error in registration")';
echo '</script>';
}


}



?>

<!DOCTYPE html>
<html>
<head>
<title></title>
</head>
<body>
<header>Beauty Corner</header>
<form method="post">
<div class="container">
<hr>

<label><b>Full Name:</b></label>
<input placeholder= 'Full name' id='fullName' name='fullName' required>

<label><b>Username</b></label>
<input placeholder="Username" name="userName" id="userName" required>

<label><b>Email</b></label>
<input type="email" placeholder="Email" name="email" id="email" required>

<label><b>Password</b></label>
<input type="password" placeholder="Enter Password" name="password" id="password" required>

<label><b>Repeat Password</b></label>
<input type="password" placeholder="Repeat Password" name="password2" id="password2" required>

<input type ='hidden' value='Customer' id ='accountType' name='accountType'>

<hr>
<p>By creating an account you agree to our <a href="https://www.sephora.com/beauty/terms-of-use">Terms & Privacy</a>.</p>
<input id='submit' type='submit'>
<button> <a href ="index.php">Back</a></button>
</div>

<div class="container signin">
<p>Already have an account? <a href="login.php">Sign in</a>.</p>
</div>
</form>

</body>
</html