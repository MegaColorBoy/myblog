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
$msg_id = mysqli_real_escape_string($conn, $_GET['id']);

$result = $handler->delete_message($msg_id);
if(!$result)
{
	echo "Error: " . mysqli_error();
}
else
{
	header('Location: feedback.php');
	exit;
}
?>