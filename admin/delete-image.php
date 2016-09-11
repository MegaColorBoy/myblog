<?php
//Delete image
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');

//Check if user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();
$img_id = mysqli_real_escape_string($conn, $_GET['id']);

$result = $handler->delete_image($img_id);

if(!$result)
{
	echo "Error: " . mysqli_error();
}
else
{
	header('Location: images.php');
	exit;
}
?>