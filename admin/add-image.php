<?php
//Add image
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//check if the user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

//Variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

//Validation check
if(isset($_POST['upload_img']))
{
	$file_temp = $_FILES['raw_image']['tmp_name'];
	$file_name = $_FILES['raw_image']['name'];
	$file_type = $_FILES['raw_image']['type'];
	$file_path = "../images/".$file_name;

	move_uploaded_file($file_temp, $file_path);

	$result = $handler->add_image($file_name, $file_type, $file_path);

	if(!$result)
	{
		echo "Error: " . mysqli_error();
	}
	else
	{
		$handler->print_msg("Image has been added successfully.", "images.php");
	}
}
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Add an image</h1>
	<div class="form-group">
		<form action="" method="post" enctype="multipart/form-data">
			<input id="upload_file" name="raw_image" type="file"/>
			<div id="img_preview" class="img-thumbnail"></div><br/>
			<input class="btn btn-primary btn-md" type="submit" name="upload_img" value="Upload image"/>
		</form>
	</div>
</div>

<?php
include_once('includes/footer.php');
?>