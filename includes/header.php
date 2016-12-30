<?php
include_once('db_connect.php');
include_once('db_handler.php');

//variables
$db = new DB_CONNECT();
$conn = $db->connect();
$db_handler = new DB_HANDLER();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>MegaColorBoy | Blog</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Bootstrap CSS -->
	<link href="css/bootstrap.min.css" rel='stylesheet'>
	<link href="css/style.css" rel="stylesheet">
	<link href="css/error-page.css" rel="stylesheet">
</head>

<body>
	<div id="main" class="container">
