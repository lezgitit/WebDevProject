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
		<header>Beauty Corner</header>
	</div>
	<div id="navbar">
		<?php include('nav.php') ?>
	</div>
	<?php while($row = $statement->fetch()): ?>
	<div>
		<div>
<!-- Not sure -->
			<a href="trunc.php? id=<?= $row['id']?>"><?= $row['title'] ?></a>
		</div>
		<p> <?= date("F d, Y, g:i a", strtotime($row['date'])); ?></p>

		<p><?= substr($row ['content'],0,200) ?></p>
		<div id="edit">
		<a href="update.php?id=<?= $row['id']?>">Edit</a>
	</div>
	</div>
	<?php endwhile ?>
</body>
</html>