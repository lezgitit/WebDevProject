<?php
//Calls the authenticate.php file
require('authenticate.php');

session_start();

// If an input is given as well ast title and content
if($_POST && isset($_POST['title']) && isset($_POST['content'])) 
{
//Sanitize the input to prevent injection
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $userID = $_SESSION['userID'];
  $fullName = $_SESSION['fullName'];
  $Image = $_FILES['Image']['name'];

//If title and content string length is greater than zero
  if((strlen($title) > 0) && (strlen($content) > 0))
  { 

    $query = "INSERT INTO post (title, content, userID, fullName, Image) VALUES (:title, :content, :userID, :fullName, :Image)";
    $statement = $db->prepare($query);

    $statement->bindValue(':title', $title);
    $statement->bindValue(':content', $content);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':fullName', $fullName);
    $statement->bindValue(':Image', $Image);

    $statement->execute();
    
    header("Location:index.php");      
  }
  else
  {
      header("Location:processing.php");
  }           
}

///////////////////////////////////////// IMAGE UPLOAD ///////////////////////////////////////////////////////////
  $image_upload_detected = isset($_FILES['Image']) && ($_FILES['Image']['error'] === 0);
  $upload_error_detected = isset($_FILES['Image']) && ($_FILES['Image']['error'] > 0);

  if($image_upload_detected)
  {
    $image_filename = $_FILES['Image']['name'];
    $temp_image_path = $_FILES['Image']['tmp_name'];
    $new_image_path = file_upload_path($image_filename);
    //resize_image($image_filename);

    if (file_is_an_image($temp_image_path, $new_image_path)) 
    {
      if(move_uploaded_file($temp_image_path, $new_image_path))
      {
        // $image = new ImageResize($new_image_path);
        // $image -> resizeToWidth(500);
        // $image -> save($new_image_path . '_medium.' . pathinfo($new_image_path, PATHINFO_EXTENSION));
      }
    }
    else
    {
      header("Location:viewComments.php");
    }
  }

  //build the new file path for the image
  function file_upload_path($original_filename, $upload_subfolder_name = 'Images')
  {
    $current_folder = dirname(__FILE__);

    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

    return join(DIRECTORY_SEPARATOR, $path_segments);
  }

  //check if image has valid file ext
  function file_is_an_image($temporary_path, $new_path)
  {
    $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_file_ext = ['gif', 'jpg', 'jpeg', 'png', 'PNG'];

    $actual_file_ext = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type = getimagesize($temporary_path)['mime'];

    $file_ext_valid = in_array($actual_file_ext, $allowed_file_ext);
    $mime_type_valid = in_array($actual_mime_type, $allowed_mime_types);

    return $file_ext_valid && $mime_type_valid;
  }

?>

<!DOCTYPE html>
<html>
<head>
<title>New Post</title>
</head>
<body>
  <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<div>
  <h1>Beauty Post</h1>
</div>
<div id="navbar">
  <?php include('nav.php') ?>
</div>
<div>
  <form method="post" enctype="multipart/form-data" action="insert.php" >
    <h>Beauty Title</h1>
    <INPUT id='title' name='title'>
    <h1>Beauty Content</h1>  
    <label for="Image">Image Filename:</label>
    <input type="file" name="Image" id="Image">
    <textarea name='content' COLS='90' ROWS='10'></textarea>
    <script type="text/javascript">
      CKEDITOR.replace('content');
    </script>
    <INPUT id='submit' type='submit'>
  </form>
</div>
</body>
</html>