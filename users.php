<?php
//Required to authenticate to access database
require('authenticate.php');
$query = "SELECT * FROM user ORDER BY userName ASC";
$statement = $db->prepare($query);
$statement->execute();

session_start();

?>

<!DOCTYPE html>
<html>
<head>
<title>Beauty</title>
</head>
<body>
<div id="header">
	<header>Beauty Corner</header>
</div>
	<span><a href="home.php">Home</a></span>
	<span><a href="index.php">View Posts</a></span>
	<span><a href="insert.php">Post</a></span>
	<span><a href="users.php">Users</a></span>
	<span><a href="logout.php">Logout</a></span>

<h1>Hello, ADMINISTRATOR!</h1>
<?php while($row = $statement->fetch()): ?>
<div>
	<h2><?= substr($row ['fullName'],0,30)?></h2>
	<p><?= substr($row ['userName'],0,30)?></p>
	<p><?= substr($row ['email'],0,30)?></p>
	<div id="edit">
	<a href="updateUser.php?id=<?= $row['userID']?> && user=<?= $row['userType']?>">Edit User</a>
</div>
</div>
<?php endwhile ?>
</body>
</html>