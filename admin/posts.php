<?php
//Blog posts
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

$num_posts = "SELECT COUNT(bp_id) FROM blog_posts";
$sql = mysqli_query($conn, $num_posts);
$result = mysqli_fetch_assoc($sql);
$count = $result['COUNT(bp_id)'];

//Fetch all posts
$posts = $handler->get_all_posts();

?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Manage blog posts</h1>

    <!-- search bar -->
    <input type="text" id="search_bar" onkeyup="searchTable()" placeholder="Search for category..."/>
    <div class="table-responsive">
    	<table class="table table-striped" id="collapse_table">
    		<thead>
    			<tr>
	    			<th>Post ID</th>
	    			<th>Post title</th>
	    			<th>Post slug</th>
	    			<th>Post Description</th>
	    			<th>Created at</th>
	    			<th>Action</th>
    			</tr>
    			<tbody>
    				<!--insert php code-->
    				<?php
    					if(!$posts || !$result)
    					{
    						echo '<h2 class="sub-header">There are no blog posts on this section';
    						//echo "Error: " . mysqli_error();
    					}

    					$counter = 0;
    					while($counter < $count)
    					{
    						echo '<tr>';
    						echo '<td>'.$posts[$counter]['bp_id'].'</td>';
    						echo '<td>'.$posts[$counter]['bp_title'].'</td>';
    						echo '<td>'.$posts[$counter]['bp_slug'].'</td>';
    						echo '<td>'.$posts[$counter]['bp_desc'].'</td>';
    						echo '<td>'.$posts[$counter]['bp_date'].'</td>';
    						?>
    						<td>
                                <!--
                                    TODO: There's no point of having preview-post.php.
                                    I'll develop the main page and link it to that instead.
                                -->
    							<a class="btn btn-success btn-block" href="../view-post.php?id=<?php echo $posts[$counter]['bp_id'];?>">View Page</a>
    							<a class="btn btn-primary btn-block" href="edit-post.php?id=<?php echo $posts[$counter]['bp_id'];?>">
    								Edit</a>
    							<a class="btn btn-danger btn-block" href="delete-post.php?id=<?php echo $posts[$counter]['bp_id'];?>"
    								onclick="return confirm('Are you sure you want to delete this post ?');">Delete</a>
    						</td>
    						<?php
    						echo '</tr>';
    						$counter++;
    					}
    				?>
    			</tbody>
    		</thead>
    	</table>
    	<a href="add-post.php" class="btn btn-primary btn-md">Add blog post</a>
    </div>
</div> 

<?php
include_once('includes/footer.php');
?>