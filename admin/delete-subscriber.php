<?php
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');

//check if the user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();
$sub_id = mysqli_real_escape_string($conn, $_GET['id']);

$result = $handler->delete_subscriber($sub_id);
if(!$result)
{
	echo "Error: " . mysqli_error();
}
else
{
	header('Location: subscribers.php');
	exit;
}
?>