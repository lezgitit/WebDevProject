<?php
	require('authenticate.php');

	// If an input is given as well ast title and content
  if($_POST && isset($_POST['fullName']) && isset($_POST['userName']) && isset($_POST['email']) && isset($_POST['password'])) 
  {
//Sanitize the input to prevent injection
    $fullName = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userName = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//If title and content string length is greater than zero
    if((strlen($fullName) > 0) && (strlen($userName) > 0) && (strlen($email) > 0) && (strlen($password) > 0))
    { 

      $query = "INSERT INTO post (fullName, userName, email, password) VALUES (:fullName, :userName, :email, :password)";
      $statement = $db->prepare($query);

      $statement->bindValue(':fullName', $fullName);
      $statement->bindValue(':userName', $userName);
      $statement->bindValue(':email', $email);
      $statement->bindValue(':password', $password);

      $statement->execute();
      
      header("Location:index.php");      
    }
    else
    {
        header("processing.php");
    }           
  	}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Beauty Forum Sign-Up Form</h2>
 <form class="modal-content">
    <div class="container">
      <h1>Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>
      <label for="name"><b>Full Name</b></label>
      <input type="text" placeholder="Enter Full Name" id='fullName' name="fullName" required>

      <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" id= 'userName' name="userName" required>

      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" id= 'email' name="email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" id= 'password' name="psw" required>

      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" class="signupbtn">Sign Up</button>
      </div>
    </div>
 </form>

</body>
</html>