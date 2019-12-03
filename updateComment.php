<?php

require('authenticate.php');

$query = "SELECT * FROM comment WHERE userType = 'Anonymous' ORDER BY commentDate DESC";
$statement = $db->prepare($query);
$statement->execute();  

if(isset($_POST['delete']))
{
$commentID = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

$query = "DELETE FROM post WHERE commentID = '$_GET[id]'";  
$statement = $db->prepare($query);
$statement->bindValue(':commentID', $commentID , PDO::PARAM_INT);

$statement->execute();

header("Location:updateComment.php");
}


?>

<!DOCTYPE html>
<html>
<head>
	<div id="navbar">
	<?php include('nav.php') ?>
</div>
<?php while($row = $statement->fetch()): ?>
<title><?= $row['userType'] ?></title>
</head>
<body>
<div>
	<form method="post">
		<h1><?= substr($row ['userType'],0,30)?></h1>
		<p><?=($row ['commentDate'])?></p>
		<p><?=($row ['commentContent'])?></p>
		<INPUT id='submit' name='delete' type='submit' value='delete'>
	</form>
<?php endwhile ?>
</div>
</body>
</html>