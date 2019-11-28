<?php

require('authenticate.php');

$query = "SELECT * FROM user";
$statement = $db->prepare($query);
$statement->execute();  

if(isset($_POST['delete']))
{
$useID = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

$query = "DELETE FROM user WHERE userID = '$_GET[userID]'";  
$statement = $db->prepare($query);
$statement->bindValue(':userID', $userID , PDO::PARAM_INT);

$statement->execute();

?>

<!DOCTYPE html>
<html>
<head>
<?php while($row = $statement->fetch()): ?>
<title>USERS</title>
</head>
<body>
<div>
	<form method="post">
	<h1><?= $row['userName'] ?></h1>
	<p><?= substr($row ['fullName'],0,30)?></p>
	<p><?= substr($row ['email'],0,50)?></p>
	<INPUT id='submit' name='delete' type='submit' value='delete'>
</form>
<?php endwhile ?>
</div>
</body>
</html>
