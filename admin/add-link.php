<?php
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//check if the user logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

//Validation check
if(isset($_POST['submit']))
{
	extract($_POST);

	$link_title = mysqli_real_escape_string($conn, $link_title);
	$link_url = mysqli_real_escape_string($conn, $link_url);

	if(!isset($error))
	{
		$result = $handler->add_link($link_title, $link_url);
		if($result)
		{
			$handler->print_msg("Link added successfully.", "links.php");
		}
		else
		{
			$handler->print_msg("Unknown error occurred. Please try again later.", "add-link.php");
		}
	}

	if(isset($error))
	{
		foreach($error as $error)
		{
			echo '<p>'.$error.'</p>';
		}
	}
}
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Add a link</h1>
	<div class="form-group">
		<form action="" method="post">
			<label>Add link title:</label>
			<input required placeholder="Link title" type="text" name="link_title" class="form-control" value='<?php if(isset($error)){echo $_POST['link_title'];} ?>'/>
			<label>Add link URL:</label>
			<input required placeholder="Link URL" type="text" name="link_url" class="form-control" value='<?php if(isset($error)){echo $_POST['link_url'];} ?>'/>		
			<br/>
			<input class="btn btn-primary btn-block" type="submit" name="submit" value="Submit"/>
		</form>
	</div>
</div>

<?php
include_once('includes/footer.php');
?>