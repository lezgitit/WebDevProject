<?php

require('authenticate.php');

$query = "SELECT * FROM post WHERE id = '$_GET[id]'";
$statement = $db->prepare($query);
$statement->execute();  


?>

<!DOCTYPE html>
<html>
<head>
<?php while($row = $statement->fetch()): ?>
<title><?= $row['title'] ?></title>
</head>
<body>
<div id="navbar">
	<?php include('nav.php') ?>
</div>
<div>
	<h1><?= $row['title'] ?></h1>
	<p><?= substr($row ['fullName'],0,30)?></p>
	<p> <?= date("F d, Y, g:i a", strtotime($row['ddate'])) ?></p>
	<p><?= html_entity_decode($row['content'])?></p>	
	<a href ="viewComments.php">View Comments</a>
<?php endwhile ?>
</div>
</body>
</html>
