<?php
//Edit user - for admin only
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//Check if the user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header("Location: login.php");
}

$user_id = $_SESSION['user_id'];
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();
$user = $handler->get_user_by_user_id($_SESSION['user_id']);

//Validation checks
if(isset($_POST['submit']))
{
	extract($_POST);

	$username = mysqli_real_escape_string($conn, $username);
	$name = mysqli_real_escape_string($conn, $name);
	$password = mysqli_real_escape_string($conn, $password);
	$confirmpassword = mysqli_real_escape_string($conn, $confirmpassword);
	$email = mysqli_real_escape_string($conn, $email);

	if($password != $confirmpassword)
	{
		$error[] = 'Passwords do not match !';
	}

	if(!isset($error))
	{
		//If you don't want to change your password
		if($password == "" && $confirmpassword == "")
		{
			$result = $handler->update_user2($user_id, $username, $name, $email);

			if(!$result)
			{
				echo 'Error: ' . mysqli_error();
			}
			else
			{
				$handler->print_msg("Your changes are saved(2)!", "me.php");
			}
		}
		else
		{
			$result = $handler->update_user($user_id, $username, $password, $name, $email);

			if(!$result)
			{
				echo 'Error: ' . mysqli_error();
			}
			else
			{
				$handler->print_msg("Your changes are saved!", "me.php");
			}
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
	<h1 class="page-header">Edit your details</h1>
	<div class="form-group">
		<form action="" method="post">
			<label>Edit username:</label>
			<input required placeholder="Username" type="text" name="username" class="form-control" value='<?php echo $user[0]['username'];?>'/><br/>
			<label>Edit name:</label>
			<input required placeholder="Name" type="text" name="name" class="form-control" value='<?php echo $user[0]['name'];?>'/><br/>
			<label>Enter new password:</label>
			<input placeholder="Password" type="password" name="password" class="form-control" value=''/><br/>
			<label>Confirm new password:</label>
			<input placeholder="Confirm password" type="password" name="confirmpassword" class="form-control" value=''/><br/>
			<label>Edit email:</label>
			<input required placeholder="Email" type="email" name="email" class="form-control" value='<?php echo $user[0]['email'];?>'/><br/>

			<input class="btn btn-primary btn-md" type="submit" name="submit" value="Save changes"
			onclick="return confirm('Are you sure you want to save your change?');">
			<a class="btn btn-danger btn-md" onclick="return confirm('Are you sure you want to cancel changes?');"
			href="me.php">Cancel changes</a>
		</form>
	</div>
</div>

<?php
include_once('includes/footer.php');
?>