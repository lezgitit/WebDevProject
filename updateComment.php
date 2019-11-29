<?php

require('authenticate.php');

$query = "SELECT * FROM comment WHERE id = '$_GET[commentID]";
$statement = $db->prepare($query);
$statement->execute();  

if(isset($_POST['update']))
{
$commentContent = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

if((strlen($commentContent) > 0))
{
	$query = "UPDATE commentContent SET commentContent ='$_POST[commentID]'
	WHERE id = '$_GET[commentID]'  ";  

	$statement = $db->prepare($query);
	$statement->bindValue(':commentContent', $commentContent);
	$statement->bindValue(':id', $id , PDO::PARAM_INT);

	$statement->execute();

	header("Location:viewComments.php");
}
else
{
	header("Location:processing.php");
}
}

if(isset($_POST['delete']))
{
$commentContent = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

$query = "DELETE FROM comment WHERE id = '$_GET[commentID]'";  
$statement = $db->prepare($query);
$statement->bindValue(':commentContent', $commentContent);
$statement->bindValue(':id', $id , PDO::PARAM_INT);

$statement->execute();

header("Location:viewComments.php");
}

function call()
{
header("Location:index.php");
exit;
}

if(!isset($_GET['commentID']) ||   ($_GET['commentID']) < 1 || (!is_numeric($_GET['commentID'])))
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
<div id="navbar">
	<?php include('nav.php') ?>
</div>
<div>
	<form method="post">
		<h1>Edit Comment</h1>        
		<textarea name='content' COLS='90' ROWS='10'><?= $row['commentContent']?></textarea>
		<INPUT id='update' type='submit' name='update' value='update'>
		<INPUT id='submit' name='delete' type='submit' value='delete'>
	</form>
<?php endwhile ?>
</div>
</body>
</html>