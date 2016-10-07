<?php
//The comment box for view-post.php. Makes use of AJAX for a more "live-comment"
//system

//Get the blog post id from view-post.php's $get_post_slug 
$get_bp_id = $handler->get_post_id($get_post_slug);
//the blog post id
$bp_id = $get_bp_id[0]['bp_id'];
$comments = $handler->get_all_comments_by_bp_id($bp_id);
$com_count = count($comments);
?>

<div class="comments">

	<?php 
	if($com_count == 0)
	{?>
		<p>No comments to this post yet !</p>
		<?php
	}
	else
	{
		//insert code to get comments based on post id
		for($i=0; $i<$com_count; $i++)
		{
			$username = $comments[$i]['cmt_username'];
			$email = $comments[$i]['cmt_email'];
			$comment = $comments[$i]['cmt_content'];
			$date = $comments[$i]['posted_at'];

			//Get gravatar
			$default = "mm";
			$size = 35;
			$grav_url = "http://www.gravatar.com/avatar/"
			.md5(strtolower(trim($email)))."?d=".$default."&s=".$size;
		?>
		<div class="user_cmt">
			<img src="<?php echo $grav_url;?>"/>
			<div class="the_cmt">
				<h5><?php echo $username;?></h5>
				<span class="cmt_dt"> 
				<?php
				echo date("d M Y", strtotime($date));
				?>
				</span>
				<br/>
				<p><?php echo $comment; ?></p>
			</div>
		</div>
		<?php 
		} 
	}?>

	<div class="new_cmt_btn">
		<span>Write a comment...</span>
	</div>

	<!-- add new comment box -->
	<div class="new_cmt_box">
		<input type="text" id="cmt_user" name="cmt_user" value="" placeholder="Your name - (optional)"/>
		<input required type="email" id="cmt_email" name="cmt_email" value="" placeholder="Email Address (required)"/>
		<textarea placeholder="Write a comment..." class="cmt_content"></textarea>
		<button id="add_cmt_btn" class="btn btn-primary btn-sm">Post comment</button>
		<button id="cancel_btn" class="btn btn-danger btn-sm">Cancel</button>
		<!--<div class="add_cmt_btn">Post comment</div>
		<div class="cancel_btn">Cancel</div>-->
	</div>
	<div class="clear"></div>
</div>