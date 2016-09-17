<?php
//Add a post
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//Check if user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

//variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

//Get categories
$num_cats = "SELECT COUNT(cat_id) FROM categories";
$sql = mysqli_query($conn, $num_cats);
$result = mysqli_fetch_assoc($sql);
$count = $result['COUNT(cat_id)'];
$categories = $handler->get_all_categories();

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
		$result = $handler->add_post($post_title, $post_slug, $post_desc,$post_cont);

		if($result)
		{
			//Now add it to the relevant posts table on the db
			$bp_id = $handler->get_post_id($post_slug);
			$cat_id = $handler->get_cat_id($post_cat);
			$res = $handler->add_related_post($bp_id[0]['bp_id'], $cat_id[0]['cat_id']);
			
			if($res)
			{
			$handler->print_msg("Post added successfully", "posts.php");
			}
			else
			{
			$handler->print_msg("Unknown error. Please try again later.", "add-post.php");

			}
			//$handler->print_msg("BP: " . $bp_id[0]['bp_id'] . " CAT: " . $cat_id[0]['cat_id'], "posts.php");
		}
		else
		{
			$handler->print_msg("Cannot add post. Please try again later.", "add-post.php");
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
	<h1 class="page-header">Add a post</h1>
	<div class="form-group">
		<form action="" method="post">
			<label>Add post title:</label>
			<input required placeholder="Post title" type="text" name="post_title" class="form-control" value='<?php if(isset($error)){echo $_POST['post_title'];} ?>'/>
			<label>Select post category:</label>
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
						echo '<option>'.$categories[$counter]['cat_title'].'</option>';
						$counter++;
					}
				?>
			</select>
			<label>Add post description:</label>
			<textarea required class="form-control" name="post_desc" cols="60" rows="10">
				<?php if(isset($error)){echo $_POST['post_desc'];}?>
			</textarea>	
			<label>Add post content:</label>
			<textarea required class="form-control" name="post_cont" cols="60" rows="10">
				<?php if(isset($error)){echo $_POST['post_cont'];}?>
			</textarea>	
			<br/>
			<input class="btn btn-primary btn-block" type="submit" name="submit" value="Submit"/>
		</form>
	</div>
</div>

<?php
include_once('includes/footer.php');
?>