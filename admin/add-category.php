<?php
//Add category
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//check if user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

//variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

//Validation checks
if(isset($_POST['submit']))
{
	extract($_POST);

	$cat_title = mysqli_real_escape_string($conn, $cat_title);

	if(!isset($error))
	{
		$cat_slug = $handler->gen_slug($cat_title);
		$result = $handler->add_category($cat_title, $cat_slug);

		if($result)
		{
			$handler->print_msg("Category added successfully.", "categories.php");
		}
		else
		{
			$handler->print_msg("Unknown error occurred. Please try again later.", "add-category.php");
		}
	}

	if(isset($error))
	{
		foreach($error as $error)
		{
			echo '<p>' . $error . '</p>';
		}
	}
}

?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Add a category</h1>
	<div class="form-group">
		<form action="" method="post">
			<label>Add category title:</label>
			<input required placeholder="Category title" type="text" name="cat_title" class="form-control" value='<?php if(isset($error)){echo $_POST['cat_title'];} ?>'/>
			<br/>
			<input class="btn btn-primary btn-block" type="submit" name="submit" value="Submit"/>
		</form>
	</div>
</div>

<?php
include_once('includes/footer.php');
?>