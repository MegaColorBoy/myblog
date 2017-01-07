<?php
include_once('db_connect.php');
include_once('db_handler.php');

$db = new DB_CONNECT();
$conn = $db->connect();
$db_handler = new DB_HANDLER();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <meta name="author" content="Abdush Shakoor">
        <title>Abdush Shakoor | Index</title>
        <!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <div class="container">