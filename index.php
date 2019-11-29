<?php
//Required to authenticate to access database
require('authenticate.php');
$query = "SELECT * FROM post ORDER BY ddate DESC";
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
<?php if(isset($_SESSION['userID'])): ?>
	<span><a href="home.php">Home</a></span>
	<span><a href="index.php">View Posts</a></span>
	<span><a href="insert.php">Post</a></span>
	<span><a href="users.php">Users</a></span>
	<span><a href="logout.php">Logout</a></span>

<h1>Hello, <?= $_SESSION['userName'] ?>!</h1>
<?php while($row = $statement->fetch()): ?>
<div>
	<div>
		<h2><a href="linkToPost.php?id=<?= $row['id']?>"><?= $row['title'] ?></a></h2
	</div>
	<p><?= substr($row ['fullName'],0,30)?></p>
	<p> <?= date("F d, Y, g:i a", strtotime($row['ddate'])) ?></p>

	<p><?= html_entity_decode( substr($row ['content'],0,200)) ?></p>
	<div id="edit">
	<a href="update.php?id=<?= $row['id']?>">Edit</a>
	<a href ="comment.php?id=<?=$row['id']?>">Comment</a>
</div>
</div>
<?php endwhile ?>
<?php elseif (!isset($_SESSION['userID'])): ?>
	<span><a href="home.php">Home</a></span>
	<span><a href="index.php">View Posts</a></span>
	<span><a href="signup.php">Sign Up</a></span>
	<span><a href="login.php">Login</a></span>

<?php while($row = $statement->fetch()): ?>
<div>
	<div>
		<h2><a href="linkToPost.php?id=<?= $row['id']?>"><?= $row['title'] ?></a></h2>
	</div>
	<p><?= substr($row ['fullName'],0,30)?></p>
	<p> <?= date("F d, Y, g:i a", strtotime($row['ddate'])) ?></p>

	<p><?= html_entity_decode(substr($row ['content'],0,200)) ?></p>
	<a href ="comment.php?id=<?=$row['id']?>">Comment</a>
</div>
<?php endwhile ?>
<?php endif ?>
</body>
</html>