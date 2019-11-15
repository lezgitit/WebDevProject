<?php
//Required to authenticate to access database
	require('authenticate.php');
	$query = "SELECT * FROM post";
	$statement = $db->prepare($query);
	$statement->execute();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Beauty</title>
</head>
<body>
	<div id="header">
		<header>Beauty Forum</header>
	</div>
	<div id="navbar">
		<?php include('nav.php') ?>
	</div>
	<?php while($row = $statement->fetch()): ?>
	<div>
		<div>
<!-- Not sure -->
<!-- Update to link to show post
 -->			
 			<h1><?= $row['title'] ?></h1>
		</div>
		<p> <?= date("F d, Y, g:i a", strtotime($row['date'])); ?></p>

		<p><?= substr($row ['content'],0,200) ?></p>
		<div id="edit">
		<a href="update.php?commentID=<?= $row['commentID']?>">Edit</a>
	</div>
	</div>
	<?php endwhile ?>
</body>
</html>