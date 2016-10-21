<?php
include_once('db_handler.php');
$handler = new DB_HANDLER();
extract($_POST);
if($_POST['action'] == "send_msg")
{
	$name = htmlentities($name);
	$email = htmlentities($email);
	$message = htmlentities($message);

	$result = $handler->send_message($name, $email, $message);
}
?>