<?php
//Edit link
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//Check if user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

$link_id_edit = $_GET['id'];
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();
$link = $handler->get_link_by_link_id($link_id_edit);

//validation check
if(isset($_POST['submit']))
{
	extract($_POST);

	$link_title = mysqli_real_escape_string($conn, $link_title);
	$link_url = mysqli_real_escape_string($conn, $link_url);

	if(!isset($error))
	{
		$result = $handler->update_link($link_id_edit, $link_title, $link_url);

		if(!$result)
		{
			echo "Error: " . mysqli_error();
		}
		else
		{
			$handler->print_msg("Your changes are saved!", "links.php");
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
	<h1 class="page-header">Edit your details</h1>
	<div class="form-group">
		<form action="" method="post">
			<label>Edit link title:</label>
			<input required placeholder="Link title" type="text" name="link_title" class="form-control" value='<?php echo $link[0]['link_title'];?>'/><br/>
			<label>Edit link URL:</label>
			<input required placeholder="Link URL" type="text" name="link_url" class="form-control" value='<?php echo $link[0]['link_url'];?>'/><br/>
			<input class="btn btn-primary btn-md" type="submit" name="submit" value="Save changes"
			onclick="return confirm('Are you sure you want to save your changes?');">
			<a class="btn btn-danger btn-md" onclick="return confirm('Are you sure you want to cancel changes?');"
			href="links.php">Cancel changes</a>
		</form>
	</div>
</div>

<?php
?>