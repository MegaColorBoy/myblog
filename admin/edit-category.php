<?php
//Edit category
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//check if the user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

//variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();
$cat_id = mysqli_real_escape_string($conn, $_GET['id']);
$category = $handler->get_cat_by_cat_id($cat_id);

//Validation checks
if(isset($_POST['submit']))
{
	extract($_POST);
	$cat_title = mysqli_real_escape_string($conn, $cat_title);

	if(!isset($error))
	{
		$cat_slug = $handler->gen_slug($cat_title);
		$result = $handler->update_category($cat_id, $cat_title, $cat_slug);

		if(!$result)
		{
			echo "Error: " . mysqli_error();
		}
		else
		{
			$handler->print_msg("Your changes are saved!", "categories.php");
		}
	}

	if(isset($error))
	{
		foreach($error as $error)
		{
			echo "<p>" . $error . "</p>";
		}
	}
}
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Edit category details</h1>
	<div class="form-group">
		<form action="" method="post">
			<label>Edit category title:</label>
			<input required placeholder="Link title" type="text" name="cat_title" class="form-control" value='<?php echo $category[0]['cat_title'];?>'/><br/>
			<input class="btn btn-primary btn-md" type="submit" name="submit" value="Save changes"
			onclick="return confirm('Are you sure you want to save your changes?');">
			<a class="btn btn-danger btn-md" onclick="return confirm('Are you sure you want to cancel changes?');"
			href="categories.php">Cancel changes</a>
		</form>
	</div>
</div>

<?php
include_once('includes/footer.php');
?>