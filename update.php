<?php

require('authenticate.php');

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT * FROM post WHERE commentID = :id";
$statement = $db->prepare($query);
$statement->execute();  

if(isset($_POST['update']))
{
	$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

	if((strlen($title) > 0) && (strlen($content) > 0))
	{
		$query = "UPDATE post SET title ='$_POST[title]', content = '$_POST[content]'
		WHERE commentID = '$_GET[id]' ";  

		$statement = $db->prepare($query);
		$statement->bindValue(':title', $title);
		$statement->bindValue(':content', $content);
		$statement->bindValue(':commentID', $id , PDO::PARAM_INT);

		$statement->execute();

		header("Location:index.php");
	}
	else
	{
		header("Location:processing.php");
	}
}

if(isset($_POST['delete']))
{
	$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

	$query = "DELETE FROM post WHERE commentID = '$_GET[id]'";  
	$statement = $db->prepare($query);
	$statement->bindValue(':title', $title);
	$statement->bindValue(':content', $content);
	$statement->bindValue(':commentID', $id , PDO::PARAM_INT);

	$statement->execute();

	header("Location:index.php");
}

function call()
{
	header("Location:index.php");
	exit;
}

if(!isset($_GET['id']) ||   ($_GET['id']) < 1 || (!is_numeric($_GET['id'])))
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
			<h2>Title</h2>
			<INPUT value= '<?= $row['title']?>' id='title' name='title'>
			<h2>Content</h2>        
			<textarea name='content' COLS='90' ROWS='10'><?= $row['content']?></textarea>
			<INPUT id='update' type='submit' name='update' value='update'>
			<INPUT id='submit' name='delete' type='submit' value='delete'>
		</form>
	<?php endwhile ?>
	</div>
</body>
</html>