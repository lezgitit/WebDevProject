<?php

require('authenticate.php');
session_start();

$query = "SELECT * FROM user WHERE id = '$_GET[id]'";
$statement = $db->prepare($query);
$statement->execute();  


?>

<!DOCTYPE html>
<html>
<head>
<?php while($row = $statement->fetch()): ?>
<title><?= $row['fullName'] ?></title>
</head>
<body>
<div id="navbar">
	<?php include('nav.php') ?>
</div>
<div>
	<h1><?= $row['fullName'] ?></h1>
	<p><?= substr($row ['userName'],0,30)?></p>
	<p><?= substr($row ['email'],0,30)?></p>
<?php endwhile ?>
</div>
</body>
</html>
