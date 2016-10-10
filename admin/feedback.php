<?php
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//check if user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

$messages = $handler->get_all_messages();

//Validation check
if(isset($_POST['feedback_submit']))
{
	$_POST = array_map('stripslashes', $_POST);
	extract($_POST);
	$fname = mysqli_real_escape_string($conn, $fname);
	$lname = mysqli_real_escape_string($conn, $lname);
	$email = mysqli_real_escape_string($conn, $email);

	$sender_name = $fname . " " . $lname;

	if(!isset($error))
	{
		$result = $handler->send_message($sender_name, $email, $query);

		if($result)
		{
			$handler->print_msg("Message sent.", "feedback.php");
		}
		else
		{
			$handler->print_msg("Cannot send message. Please try again later.", "feedback.php");
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
    <h1 class="page-header">Manage Feedback/Messages</h1>

    <!-- search bar -->
    <input type="text" id="search_bar" onkeyup="searchTable()" placeholder="Search for message..."/>
    <div class="table-responsive">
    	<table class="table table-striped" id="collapse_table">
    		<thead>
    			<tr>
	    			<th>Message ID</th>
	    			<th>Message</th>
	    			<th>Sender Name</th>
	    			<th>Sender Email</th>
	    			<th>Message date</th>
	    			<th>Message status</th>
	    			<th>Action</th>
    			</tr>
    			<tbody>
    				<!--insert php code-->
    				<?php
    					if(!$messages)
    					{
    						echo '<h2 class="sub-header">There are no messages on this section';
    						//echo "Error: " . mysqli_error();
    					}

    					for($i=0; $i<count($messages); $i++)
    					{
    						echo '<tr>';
    						echo '<td>'.$messages[$i]['msg_id'].'</td>';
    						echo '<td>'.$messages[$i]['sender_msg'].'</td>';
    						echo '<td>'.$messages[$i]['sender_name'].'</td>';
    						echo '<td>'.$messages[$i]['sender_email'].'</td>';
    						echo '<td>'.$messages[$i]['msg_date'].'</td>';
    						echo '<td>'.$handler->check_msg_status($messages[$i]['msg_checked']).'</td>';

    						?>
    						<td>
    							<?php 
    							if ($messages[$i]['msg_checked'] == 1)
    							{?>
    							<a class="btn btn-primary btn-block" href="mark_message.php?id=<?php echo $messages[$i]['msg_id'];?>&mark_id=0">Mark as unread
    								</a>
    							<?php }
    							else {
    								?>
    								<a class="btn btn-primary btn-block" href="mark_message.php?id=<?php echo $messages[$i]['msg_id'];?>&mark_id=1">Mark as read
    								</a>
    							<?php }?>
    							<a class="btn btn-danger btn-block" href="delete-message.php?id=<?php echo $messages[$i]['msg_id'];?>"
    								onclick="return confirm('Are you sure you want to delete this message ?');">Delete</a>

    							<a class="btn btn-success btn-block" href="reply-message.php?id=<?php echo $messages[$i]['msg_id'];?>">Reply</a>

    						</td>
    						<?php
    						echo '</tr>';
    					}
    				?>
    			</tbody>
    		</thead>
    	</table>
    	<!-- for testing only -->
    	<a href="#feedback" role="button" data-toggle="modal" class="btn btn-primary btn-md">Send Message</a>
    </div>
</div> 

<div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="feedback_modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><span class="fa fa-question-circle"></span> Any questions? Feel free to contact me.</h4>	
			</div>
			<div class="modal-body">
				<form id="feedback_form" class="form-horizontal" name="feedback_form" method="post" action="">
					<div class="form-group">
						<div class="col-lg-6 col-sm-6 col-md-6">
							<input required placeholder="First name" type="text" class="form-control" id="fname" name="fname" 
							value='<?php if(isset($error)){$_POST['fname'];}?>'/>
						</div>
						<div class="col-lg-6 col-sm-6 col-md-6">
							<input required placeholder="Last name" type="text" class="form-control" id="lname" name="lname" 
							value='<?php if(isset($error)){$_POST['lname'];}?>'/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12">
						<input required placeholder="Email Address" type="email" class="form-control" id="email" name="email" 
						value='<?php if(isset($error)){$_POST['email'];}?>'/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<textarea required class="form-control" id="query" name="query" placeholder="Type your message..."
							rows="5">
								<?php if(isset($error)){$_POST['query'];}?>
							</textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-6 col-md-6 col-sm-6">
							<button type="submit" name="feedback_submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-send"></span> 
							Send</button>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6">
							<button type="reset" name="clear" class="btn btn-danger btn-block"><span class="glyphicon glyphicon-trash"></span> 
							Clear</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div> 

<?php
include_once('includes/footer.php');
?>