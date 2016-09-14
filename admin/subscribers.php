<?php
//Subscribers
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//Check if the user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

//variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

$num_subscribers = "SELECT COUNT(sub_id) FROM subscribers";
$sql = mysqli_query($conn, $num_subscribers);
$result = mysqli_fetch_assoc($sql);

$count = $result['COUNT(sub_id)'];

//Fetch all subscribers
$subscribers = $handler->get_all_subscribers();

//Validation check for adding subscribers
if(isset($_POST['add_sub_submit']))
{
	extract($_POST);
	$first_name = mysqli_real_escape_string($conn, $first_name);
	$last_name = mysqli_real_escape_string($conn, $last_name);
	$email = mysqli_real_escape_string($conn, $email);

	//check for duplicate entries
	if($handler->check_duplicate_subscriber($email))
	{
		$handler->print_msg("You have already subscribed to us", "subscribers.php");
	}
	else
	{
		if(!isset($error))
		{
			$name = $first_name . " " . $last_name;
			$result = $handler->add_subscriber($name, $email);

			if(!$result)
			{

			}
			else
			{
				//TODO: Add mail functionality to this part

				$handler->print_msg("Thank you for subscribing us! Please check your mail!", "subscribers.php");
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
}

?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Manage subscribers</h1>

    <!-- search bar -->
    <input type="text" id="search_bar" onkeyup="searchTable()" placeholder="Search for subscriber..."/>
    <div class="table-responsive">
    	<table class="table table-striped" id="collapse_table">
    		<thead>
    			<tr>
	    			<th>Subscriber ID</th>
	    			<th>Subscriber name</th>
	    			<th>Subscriber email</th>
	    			<th>Date joined</th>
	    			<th>Action</th>
    			</tr>
    			<tbody>
    				<!--insert php code-->
    				<?php
    					if(!$subscribers || !$result)
    					{
    						echo '<h2 class="sub-header">There are no subscribers on this section';
    						//echo "Error: " . mysqli_error();
    					}

    					$counter = 0;
    					while($counter < $count)
    					{
    						echo '<tr>';
    						echo '<td>'.$subscribers[$counter]['sub_id'].'</td>';
    						echo '<td>'.$subscribers[$counter]['sub_name'].'</td>';
    						echo '<td>'.$subscribers[$counter]['sub_email'].'</td>';
    						echo '<td>'.$subscribers[$counter]['sub_date_joined'].'</td>';
    						?>
    						<td>
    							<a class="btn btn-primary btn-block" href="#send_mail_modal" data-id="<?php echo $subscribers[$counter]['sub_id'];?>" 
    								role="button" data-toggle="modal">Send mail</a>
    							<a class="btn btn-danger btn-block" href="delete-subscriber.php?id=<?php echo $subscribers[$counter]['sub_id'];?>"
    								onclick="return confirm('Are you sure you want to delete this subscriber ?');">Delete</a>
    						</td>
    						<?php
    						echo '</tr>';
    						$counter++;
    					}
    				?>
    			</tbody>
    		</thead>
    	</table>
    	<!--Test only -->
    	<a href="#add_sub_modal" role="button" data-toggle="modal" class="btn btn-primary btn-md">Add subscriber</a>
    	<a href="#send_mail_all_modal" role="button" data-toggle="modal" class="btn btn-primary btn-md">Send mail to all</a>
    </div>
</div>

<!-- Modal for adding a subscriber -->
<div class="modal fade" id="add_sub_modal" tabindex="-1" role="dialog" aria-labelledby="add_sub_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add subscriber</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" action="">
					<div class="form-group">
						<label class="control-label col-md-4">First Name</label>
						<div class="col-md-6">
							<input required type="text" class="form-control" placeholder="First Name" id="first_name" name="first_name" value='<?php if(isset($error)){echo $_POST['first_name'];}?>'/>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-4">Last Name</label>
						<div class="col-md-6">
							<input required type="text" class="form-control" placeholder="Last Name" id="last_name" name="last_name" value='<?php if(isset($error)){echo $_POST['last_name'];}?>'/>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-4">Email Address</label>
						<div class="col-md-6">
							<input required type="email" class="form-control" placeholder="Email Address" id="email" name="email" value='<?php if(isset($error)){echo $_POST['email'];}?>'/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12">
							<button type="submit" value="Submit" name="add_sub_submit" class="btn btn-primary btn-block">Submit</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
<!-- -->

<!-- Modal for sending a mail -->

<!-- -->

<!-- Modal for sending mail to all subscribers -->

<!-- -->


<?php
include_once('includes/footer.php');
?>