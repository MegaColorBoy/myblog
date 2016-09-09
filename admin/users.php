<?php
session_start();
include_once("includes/db_connect.php");
include_once("includes/db_handler.php");
include_once("includes/header.php");

//Check if the user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

//Variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

$num_users = "SELECT COUNT(user_id) FROM users";
$sql = mysqli_query($conn, $num_users);
$result = mysqli_fetch_assoc($sql);
$count = $result['COUNT(user_id)'];

//Fetch all users
$users = $handler->get_all_users();
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Manage users</h1>
    <div class="table-responsive">
    	<table class="table table-striped">
    		<thead>
    			<tr>
	    			<th>User ID</th>
	    			<th>Username</th>
	    			<th>Name</th>
	    			<th>Email</th>
	    			<th>Created At</th>
	    			<th>Action</th>
    			</tr>
    			<tbody>
    				<!--insert php code-->
    				<?php
    					if(!$users)
    					{
    						echo "Error: " . mysqli_error();
    					}

    					$counter = 0;
    					while($counter < $count)
    					{
    						echo '<tr>';
    						echo '<td>'.$users[$counter]['user_id'].'</td>';
    						echo '<td>'.$users[$counter]['username'].'</td>';
    						echo '<td>'.$users[$counter]['name'].'</td>';
    						echo '<td>'.$users[$counter]['email'].'</td>';
    						echo '<td>'.$users[$counter]['created_at'].'</td>';
    						?>
    						<td>
                                <?php if($users[$counter]['user_id'] != 1){?>
    							<a class="btn btn-danger btn-block" href="delete-user.php?id=<?php echo $users[$counter]['user_id'];?>"
    								onclick="return confirm('Are you sure you want to delete this user ?');">Delete</a>
                                <?php }?>   								
    						</td>
    						<?php
    						echo '</tr>';
    						$counter++;
    					}
    				?>
    			</tbody>
    		</thead>
    	</table>
    	<a href="add-user.php" class="btn btn-primary btn-md">Add user</a>
    </div>
</div> 

<?php
include_once("includes/footer.php");
?>