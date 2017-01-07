<?php
include_once('includes/header.php');

//Get all posts
$posts = $db_handler->get_all_posts();
?>
<h2>Abdush Shakoor / MegaColorBoy - Blog</h2>
<p>Topics like graphics, security, math, algorithms, programming, etc...</p>

<h3>Blog posts:</h3>
<hr/>
<!-- insert code to generate all posts -->
<table>
<?php
	for($i=0;$i<count($posts);$i++)
	{?>
		<tr>
			<td>
				<?php echo date("d-M-Y", strtotime($posts[$i]['bp_date']));?>
			</td>
			<td>
				<a href="view-post.php?id=<?php echo $posts[$i]['bp_id'];?>"><?php echo $posts[$i]['bp_title'];?></a>
			</td>
		</tr>
	<?php }
?>
</table>
<p>&#8594; [<a href="index.php">Back to main page</a>]</p>
<?php
include_once('includes/footer.php');
?>