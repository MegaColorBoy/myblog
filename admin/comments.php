<?php
//comments
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//check if the user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

//variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

$comments = $handler->get_all_comments();
$count = count($comments);
$posts = $handler->get_all_posts();
$post_count = count($posts);

//Validation check
if(isset($_POST['comment_submit']))
{
	$_POST = array_map('stripslashes', $_POST);
	extract($_POST);

	$fname = mysqli_real_escape_string($conn, $fname);
	$lname = mysqli_real_escape_string($conn, $lname);
	$email = mysqli_real_escape_string($conn, $email);
	$bp_slug = mysqli_real_escape_string($conn, $bp_slug);

	if(!isset($error))
	{
		//get post id
		$post_id = $handler->get_post_id($bp_slug);
		$cmt_username = $fname." ".$lname;
		$result = $handler->add_comment($post_id[0]['bp_id'], $cmt_username, $email, $cmt_content);

		if($result)
		{
			$handler->print_msg("Comment posted to blog post successfully.", "comments.php");
		}
		else
		{
			$handler->print_msg("Cannot add comment. Please try again later.", "comments.php");
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
    <h1 class="page-header">Manage comments</h1>

    <!-- search bar -->
    <input type="text" id="search_bar" onkeyup="searchTable()" placeholder="Search for comment..."/>
    <div class="table-responsive">
    	<table class="table table-striped" id="collapse_table">
    		<thead>
    			<tr>
	    			<th>Comment ID</th>
	    			<th>Comment</th>
	    			<th>Commenter's Name</th>
	    			<th>Commenter's Email</th>
	    			<th>Post ID</th>
	    			<th>Posted at</th>
	    			<th>Action</th>
    			</tr>
    			<tbody>
    				<!--insert php code-->
    				<?php
    					if(!$comments)
    					{
    						echo '<h2 class="sub-header">There are no comments on this section';
    						//echo "Error: " . mysqli_error();
    					}

    					$counter = 0;
    					while($counter < $count)
    					{
    						echo '<tr>';
    						echo '<td>'.$comments[$counter]['cmt_id'].'</td>';
    						echo '<td>'.$comments[$counter]['cmt_content'].'</td>';
    						echo '<td>'.$comments[$counter]['cmt_username'].'</td>';
    						echo '<td>'.$comments[$counter]['cmt_email'].'</td>';
    						echo '<td>'.$comments[$counter]['bp_id'].'</td>';
    						echo '<td>'.$comments[$counter]['posted_at'].'</td>';
    						?>
    						<td>
    							<a class="btn btn-danger btn-block" href="delete-comment.php?id=<?php echo $comments[$counter]['cmt_id'];?>"
    								onclick="return confirm('Are you sure you want to delete this link ?');">Delete</a>
    						</td>
    						<?php
    						echo '</tr>';
    						$counter++;
    					}
    				?>
    			</tbody>
    		</thead>
    	</table>
    	<!-- commenting from the admin side, can be used as a test function -->
    	<a href="#add_cmt_modal" role="button" data-toggle="modal" class="btn btn-primary btn-md">Post comment</a>
    </div>
</div>

<!-- Modal for posting a comment -->
<div class="modal fade" id="add_cmt_modal" tabindex="-1" role="dialog" aria-labelledby="add_cmt_modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Post a comment</h4>	
			</div>
			<div class="modal-body">
				<form id="comment_form" class="form-horizontal" name="comment_form" method="post" action="">
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
							<!-- gives a list of posts and the user has to select a blogpost
							before posting a comment -->
							<label>Select a blog topic:</label>
							<select class="form-control" name="bp_slug">
								<?php
									for($i=0; $i<$post_count; $i++)
									{
										echo '<option>'. $posts[$i]['bp_slug'].'</option>';
									}	
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<textarea required class="form-control" id="cmt_content" name="cmt_content" placeholder="Type your message..."
							 rows="5">
								<?php if(isset($error)){echo $_POST['cmt_content'];}?>
							 </textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-6 col-md-6 col-sm-6">
							<button type="submit" name="comment_submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-send"></span> 
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