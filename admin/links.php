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

//variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

$num_links = "SELECT COUNT(link_id) FROM links";
$sql = mysqli_query($conn, $num_links);
$result = mysqli_fetch_assoc($sql);
$count = $result['COUNT(link_id)'];

//Fetch all links
$links = $handler->get_all_links();
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Manage links</h1>

    <!-- search bar -->
    <input type="text" id="search_bar" onkeyup="searchTable()" placeholder="Search for link..."/>
    <div class="table-responsive">
    	<table class="table table-striped" id="collapse_table">
    		<thead>
    			<tr>
	    			<th>Link ID</th>
	    			<th>Link title</th>
	    			<th>Link URL</th>
	    			<th>Created at</th>
	    			<th>Action</th>
    			</tr>
    			<tbody>
    				<!--insert php code-->
    				<?php
    					if(!$links || !$result)
    					{
    						echo '<h2 class="sub-header">There are no links on this section';
    						//echo "Error: " . mysqli_error();
    					}

    					$counter = 0;
    					while($counter < $count)
    					{
    						echo '<tr>';
    						echo '<td>'.$links[$counter]['link_id'].'</td>';
    						echo '<td>'.$links[$counter]['link_title'].'</td>';
    						echo '<td>'.$links[$counter]['link_url'].'</td>';
    						echo '<td>'.$links[$counter]['created_at'].'</td>';
    						?>
    						<td>
    							<a class="btn btn-primary btn-block" href="edit-link.php?id=<?php echo $links[$counter]['link_id'];?>">
    								Edit</a>
    							<a class="btn btn-danger btn-block" href="delete-link.php?id=<?php echo $links[$counter]['link_id'];?>"
    								onclick="return confirm('Are you sure you want to delete this link ?');">Delete</a>

    						</td>
    						<?php
    						echo '</tr>';
    						$counter++;
    					}
    				?>
    			</tbody>
    		</thead>
    	</table>
    	<a href="add-link.php" class="btn btn-primary btn-md">Add link</a>
    </div>
</div> 
 
<?php
include_once('includes/footer.php');
?>