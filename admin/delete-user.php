<?php
//Delete user
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');

if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

$db = new DB_CONNECT();
$conn = $db->connect();
$user_id = mysqli_real_escape_string($conn, $_GET['id']);
$handler = new DB_HANDLER();

$result = $handler->delete_user($user_id);

if(!$result)
{
	echo "Error: " . mysqli_error();
}
else
{
	header('Location: users.php');
	exit;
}
?>