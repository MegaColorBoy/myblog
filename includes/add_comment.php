<?php
include_once('db_handler.php');
$handler = new DB_HANDLER();
extract($_POST);
if($_POST['action'] == "add_cmt"):
	$username = htmlentities($username);
	$email = htmlentities($email);
	$comment = htmlentities($comment);

	//Get gravatar
	$default = "mm";
	$size = 35;
	$grav_url = "http://www.gravatar.com/avatar/"
	.md5(strtolower(trim($email)))."?d=".$default."&s=".$size;

	$result = $handler->add_comment($bp_id, $username, $email, $comment);

	if(strlen($username) <= '1'){$username = "guest";}
	if($result){?>

	<div class="user_cmt">
		<img src="<?php echo $grav_url;?>"/>
		<div class="the_cmt">
			<h5><?php echo $username;?></h5>
			<span class="cmt_dt">
				<?php
				$date = date("d-M-Y");
				echo date("d M Y", strtotime($date));
				?>
			</span>
			<br/>
			<p><?php echo $comment; ?></p>
		</div>
	</div>

	<?php }?>
<?php endif; ?>