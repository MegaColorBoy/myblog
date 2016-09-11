<?php
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//check if the user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

//Variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

$num_cats = "SELECT COUNT(cat_id) FROM categories";
$sql = mysqli_query($conn, $num_cats);
$result = mysqli_fetch_assoc($sql);
$count = $result['COUNT(cat_id)'];

//Fetch all categories
$categories = $handler->get_all_categories();
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Manage categories</h1>

    <!-- search bar -->
    <input type="text" id="search_bar" onkeyup="searchTable()" placeholder="Search for category..."/>
    <div class="table-responsive">
    	<table class="table table-striped" id="collapse_table">
    		<thead>
    			<tr>
	    			<th>Category ID</th>
	    			<th>Category title</th>
	    			<th>Category slug</th>
	    			<th>Created at</th>
	    			<th>Action</th>
    			</tr>
    			<tbody>
    				<!--insert php code-->
    				<?php
    					if(!$categories || !$result)
    					{
    						echo '<h2 class="sub-header">There are no categories on this section';
    						//echo "Error: " . mysqli_error();
    					}

    					$counter = 0;
    					while($counter < $count)
    					{
    						echo '<tr>';
    						echo '<td>'.$categories[$counter]['cat_id'].'</td>';
    						echo '<td>'.$categories[$counter]['cat_title'].'</td>';
    						echo '<td>'.$categories[$counter]['cat_slug'].'</td>';
    						echo '<td>'.$categories[$counter]['cat_date'].'</td>';
    						?>
    						<td>
    							<a class="btn btn-primary btn-block" href="edit-category.php?id=<?php echo $categories[$counter]['cat_id'];?>">
    								Edit</a>
    							<a class="btn btn-danger btn-block" href="delete-category.php?id=<?php echo $categories[$counter]['cat_id'];?>"
    								onclick="return confirm('Are you sure you want to delete this category ?');">Delete</a>

    						</td>
    						<?php
    						echo '</tr>';
    						$counter++;
    					}
    				?>
    			</tbody>
    		</thead>
    	</table>
    	<a href="add-category.php" class="btn btn-primary btn-md">Add category</a>
    </div>
</div> 

<?php
include_once('includes/footer.php');
?>