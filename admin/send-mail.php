<?php
//Send mail to subscriber
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//check if the user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();
$sub_id = mysqli_real_escape_string($conn, $_GET['id']);
$subscriber = $handler->get_subscriber_by_id($sub_id);

//Validation check
if(isset($_POST['submit']))
{
	$message = mysqli_real_escape_string($conn, $message);
	//Complete this after you have made mail.php 
}

?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Send a mail to subscriber</h1>
	<div class="form-group">
		<h3>Subscriber details</h3>
		<table class="table table-striped">
			<tbody>
				<tr>
					<td>Subscriber name:</td>
					<td><?php echo $subscriber[0]['sub_name'];?></td>
				</tr>
				<tr>
					<td>Subscriber email:</td>
					<td><?php echo $subscriber[0]['sub_email'];?></td>
				</tr>
				<tr>
					<td>Date joined:</td>
					<td><?php echo $subscriber[0]['sub_date_joined'];?></td>
				</tr>
			</tbody>
		</table>
		<form action="" method="post" id="contact-form" class="contact-form">
			<textarea class="form-control textarea" rows="5" name="message" id="message" placeholder="Type your message..." required></textarea><br/>
			<input class="btn btn-success btn-block" type="submit" name="submit" value="Send mail"/>
		</form>
	</div>
</div>

<?php
include_once('includes/footer.php');
?>