<?php
//Edit post
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//Check if user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

$post_id_edit = $_GET['id'];
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();
$post = $handler->get_post_by_id($post_id_edit);

//Get categories
$num_cats = "SELECT COUNT(cat_id) FROM categories";
$sql = mysqli_query($conn, $num_cats);
$result = mysqli_fetch_assoc($sql);
$count = $result['COUNT(cat_id)'];
$categories = $handler->get_all_categories();

//Get category id by bp_id
$cat_id = $handler->get_cat_id_by_bp_id($post_id_edit);
//Now get category by cat_id
$bp_category = $handler->get_cat_by_cat_id($cat_id[0]['cat_id']);

//Validation check
if(isset($_POST['submit']))
{
	extract($_POST);
	$post_title = mysqli_real_escape_string($conn, $post_title);
	$post_cat = mysqli_real_escape_string($conn, $post_cat);
	$post_desc = mysqli_real_escape_string($conn, $post_desc);
	$post_cont = mysqli_real_escape_string($conn, $post_cont);

	if(!isset($error))
	{
		$post_slug = $handler->gen_slug($post_title);
		$result = $handler->update_post($post_id_edit, $post_title, $post_slug, $post_desc, $post_cont);

		//TODO: add code to edit category as well

		if(!$result)
		{
			echo "Error: " . mysqli_error();
		}
		else
		{
			$handler->print_msg("Your changes are saved!", "posts.php");
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
	<h1 class="page-header">Edit post</h1>
	<div class="form-group">
		<form action="" method="post">
			<label>Edit post title:</label>
			<input required placeholder="Post title" type="text" name="post_title" class="form-control" value='<?php echo $post[0]['bp_title']; ?>'/>
			<label>Change post category:</label>
			<select class="form-control" name="post_cat">
				<!--insert php code-->
				<?php
					if(!$categories)
					{
						echo '<h2 class="sub-header">There are no categories on this list</h2>';
					}

					$counter = 0;
					while($counter < $count)
					{
						//Display the category it belongs to
						if($bp_category[0]['cat_title'] == $categories[$counter]['cat_title'])
						{
							echo '<option selected="selected">'.$categories[$counter]['cat_title'].'</option>';
						}
						else
						{
							echo '<option>'.$categories[$counter]['cat_title'].'</option>';
						}
						$counter++;
					}
				?>
			</select>
			<label>Edit post description:</label>
			<textarea required class="form-control" name="post_desc" cols="60" rows="10">
				<?php echo $post[0]['bp_desc'];?>
			</textarea>	
			<label>Edit post content:</label>
			<textarea required class="form-control" name="post_cont" cols="60" rows="10">
				<?php echo $post[0]['bp_cont'];?>
			</textarea>	
			<br/>
			<input class="btn btn-primary btn-md" type="submit" name="submit" value="Save changes"
			onclick="return confirm('Are you sure you want to save your changes?');"/>
			<a class="btn btn-danger btn-md" onclick="return confirm('Are you sure you want to cancel changes?');"
			href="posts.php">Cancel changes</a>
		</form>
	</div>
</div>

<?php
include_once('includes/footer.php');
?>