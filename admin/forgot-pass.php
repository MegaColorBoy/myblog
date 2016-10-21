<?php
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header2.php');

//Variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

//Validation check
if(isset($_POST['submit']))
{
	$username = mysqli_real_escape_string($conn, trim($_POST['username']));

	//First, check if the user exists
	if(!$handler->is_user_exists($username))
	{
		$handler->print_msg("Sorry, This user does not exist!", "forgot-pass.php");
	}
	//Else, send the new password
	else
	{
		include_once('includes/mail.php');
		$result = $handler->get_email_by_username($username);
		$to_user = $result[0]['email'];
		//Generate random 8 char password
		$password = $handler->rand_pass_gen(8);
		
		//Calling mail.php instance
		$mail = new MAIL();
		$mail->set_to_user($to_user);
		$mail->set_subject("Reset Password - MegaColorBoy");
		$mail->send_mail_v2("reset_password", $username, $password);

		//Update user's password in the db
		$res = $handler->reset_password($username, $password);

		if($res)
		{
			$handler->print_msg("Please check your email for new password!", "login.php");
		}
		else
		{
			$handler->print_msg("Unknown error. Please try again.", "login.php");
		}
	}
}
?>

<style>
	.wrapper {    
	margin-top: 80px;
	margin-bottom: 20px;
	}

	.form-signin {
	  max-width: 420px;
	  padding: 30px 38px 66px;
	  margin: 0 auto;
	  background-color: #eee;
	  border: 3px dotted rgba(0,0,0,0.1);  
	  }

	.form-signin-heading {
	  text-align:center;
	  margin-bottom: 30px;
	}

	.form-control {
	  position: relative;
	  font-size: 16px;
	  height: auto;
	  padding: 10px;
	}

	input[type="text"] {
	  margin-bottom: 0px;
	  border-bottom-left-radius: 0;
	  border-bottom-right-radius: 0;
	}

	input[type="password"] {
	  margin-bottom: 20px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}

	.colorgraph {
	  height: 7px;
	  border-top: 0;
	  background: #c4e17f;
	  border-radius: 5px;
	  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	}
</style>

<div class="container">
	<div class="wrapper">
		<form action="" method="post" name="forgot_pass_form" class="form-signin">
			<h3 class="form-signin-heading">Forgot your password?</h3>
			<hr class="colorgraph"><br/>

			<input type="text" class="form-control" name="username" placeholder="Enter your username" required autofocus=""/><br>
			<input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Reset Password"/>
		</form>
	</div>
</div>

<?php
include_once('includes/footer2.php');
?>