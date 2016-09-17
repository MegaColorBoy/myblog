<?php
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');

//check if user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();
$post_id = mysqli_real_escape_string($conn, $_GET['id']);

$result = $handler->delete_post($post_id);
if(!$result)
{
	echo "Error: " . mysqli_error();
}
else
{
	//Delete it from the related posts (bp_cats) table from the DB
	$res = $handler->delete_related_post($post_id);
	if(!$result)
	{
		echo "Error: " . mysqli_error();
	}
	else
	{
		header('Location: posts.php');
	}
}
?>