<?php
session_start();
include_once("includes/db_handler.php");
include_once("includes/header.php");

//check if the user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

$handler = new DB_HANDLER();
$user = $handler->get_user_by_user_id($_SESSION['user_id']);
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">My Profile</h1>
	<div class="table-responsive">
		<table class="table table-striped">
			<tbody>
				<tr>
					<td>Username:</td>
					<td><?php echo $user[0]['username'];?></td>
				</tr>
				<tr>
					<td>Name:</td>
					<td><?php echo $user[0]['name'];?></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><?php echo $user[0]['email'];?></td>
				</tr>
				<tr>
					<td>Date joined:</td>
					<td><?php echo $user[0]['created_at'];?></td>
				</tr>
			</tbody>
		</table>
		<a href="edit-user.php" class="btn btn-primary btn-md">Edit details</a>
	</div>
</div> 

<?php
include_once("includes/footer.php");
?>