<?php

	require('authenticate.php');

	$query = "SELECT * FROM blog WHERE id = '$_GET[id]'";
	$statement = $db->prepare($query);
	$statement->execute();

	function call()
	{
		header("Location:index.php");
		exit;
	}

	if(!isset($_GET['id'] || isset($_GET['id']) < 1 || (!is_numeric($_GET['id']))))
	{
		call();
	}

?>

<!DOCTYPE html>
<html>
<head>
	<?php while($row = $statement->fetch()): ?>
	<title><?= $row['title'] ?></title>
</head>
<body>

	<div id="header">
		<h1>Welcome to Blogster!</h1>
	</div>
	<div id="navbar">
		<?php include('nav.php') ?>
	</div>
	<div id="edit">
		<a href="update.php?commentID=<?= $row['commentID']?>">Edit</a>
	</div>
	<div>
		<div>
			<a href=""><?= $row['title'] ?></a>
		</div>

		<p><?= date("F d, Y, g:i a", strtotime($row['date'])); ?></p>
		<p><?=$row ['content']?></p>		
	</div>

	<?php - ?>

</body>
</html>