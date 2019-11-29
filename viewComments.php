<?php

require('authenticate.php');

$query = "SELECT * FROM comment ORDER BY commentDate DESC";
$statement = $db->prepare($query);
$statement->execute();  


?>

<!DOCTYPE html>
<html>
<head>
<title>Comment Page</title>
<span><a href="home.php">Home</a></span>
  <span><a href="index.php">Back to Posts</a></span>
<?php while($row = $statement->fetch()): ?>
<title><?= $row['title'] ?></title>
</head>
<body>
<div>
	<h1><?= $row['userType'] ?></h1>
	<p><?= $row['commentDate'] ?></p>
	<p><?= $row['commentContent'] ?></p>
<?php endwhile ?>
</div>
</body>
</html>
