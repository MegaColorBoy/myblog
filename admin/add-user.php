<?php
//Add user page
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');
include_once('includes/pass_hash.php');

//check if the user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

//Validation check
if(isset($_POST['submit']))
{
	extract($_POST);

	//variables
	$username = mysqli_real_escape_string($conn, $username);
	$password = mysqli_real_escape_string($conn, $password);
	$confirmpassword = mysqli_real_escape_string($conn, $confirmpassword);
	$name = mysqli_real_escape_string($conn, $name);
	$email = mysqli_real_escape_string($conn, $email);

	//Check passwords
	if($password != $confirmpassword)
	{
		$error[] = 'Passwords do not match.';
	}

	//If there are no errors
	if(!isset($error))
	{
		$res = $handler->add_user($username, $password, $name, $email);

		if($res == USER_CREATED_SUCCESSFULLY)
		{
			$handler->print_msg("User successfully registered!", "users.php");
		}
		else if($res == USER_CREATE_FAILED)
		{
			$handler->print_msg("User creation failed. Please try again !", "add-user.php");
		}
		else
		{
			$handler->print_msg("This user exists !", "add-user.php");
		}
	}

	if(isset($error))
	{
		foreach($error as $error)
		{
			echo '<p>' .$error. '</p>';
		}
	}
}

?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Add a user</h1>
	<div class="form-group">
		<form action="" method="post">
			<label>Create username:</label>
			<input required placeholder="Username" type="text" name="username" class="form-control" value='<?php if(isset($error)){echo $_POST['username'];} ?>'/>
			<label>Create password:</label>
			<input required placeholder="Password" type="password" name="password" class="form-control" value='<?php if(isset($error)){echo $_POST['password'];} ?>'/>
			<label>Confirm password:</label>
			<input required placeholder="Confirm password" type="password" name="confirmpassword" class="form-control" value='<?php if(isset($error)){echo $_POST['confirmpassword'];}?>'/>
			<label>Enter your name:</label>
			<input required placeholder="Name" type="text" name="name" class="form-control" value='<?php if(isset($error)){echo $_POST['name'];}?>'/>			
			<label>Enter your email address:</label>
			<input required placeholder="Email address" type="email" name="email" class="form-control" value='<?php if(isset($error)){echo $_POST['email'];}?>'/>			
			<br/>
			<input class="btn btn-primary btn-block" type="submit" name="submit" value="Submit"/>
		</form>
	</div>
</div>

<?php
include_once('includes/footer.php');
?>