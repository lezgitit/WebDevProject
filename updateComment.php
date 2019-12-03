<?php

require('authenticate.php');

$query = "SELECT * FROM comment WHERE commentID = '$_GET[id]' && userType = 'Anonymous'";
$statement = $db->prepare($query);
$statement->execute();  


?>

<!DOCTYPE html>
<html>
<head>
<?php while($row = $statement->fetch()): ?>
<title><?= $row['userType'] ?></title>
</head>
<body>
<div id="navbar">
	<?php include('nav.php') ?>
</div>
<div>
	<form method="post">
		<h1><?= substr($row ['userType'],0,30)?></h>
		<h2>Content</h2>        
		<textarea name='content' COLS='90' ROWS='10'><?= $row['commentContent']?></textarea>
		<INPUT id='update' type='submit' name='update' value='update'>
		<INPUT id='submit' name='delete' type='submit' value='delete'>
	</form>
<?php endwhile ?>
</div>
</body>
</html>