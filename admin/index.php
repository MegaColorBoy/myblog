<?php
//Index Dashboard
session_start();
include_once('includes/header.php');

if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}
?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Welcome to MyBlog CMS Dashboard</h1>
</div> 
<?php
include_once('includes/footer.php');
?>