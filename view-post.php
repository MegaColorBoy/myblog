<?php
//View post
include_once('includes/header.php');

//Get post by id
$get_post_id = $_GET['id'];
$post = $db_handler->get_post_by_id($get_post_id);

//$get_post_slug = $_GET['url'];
//$post = $db_handler->get_post_by_slug($get_post_slug);

?>
<h2><?php echo date("d-M-Y", strtotime($post[0]['bp_date'])).": ".$post[0]['bp_title'];?></h2>
<hr/>
<?php echo $post[0]['bp_cont'];?>
<hr/>
<p>Interested in articles like this ? Follow me on twitter: <a href="https://twitter.com/MegaColorBoy">@megacolorboy</a> and/or <a href="https://www.facebook.com/MegaColorBoy">facebook</a></p>
<p>&#8594; [<a href="blog.php">List of blog posts</a>]</p>
<?php
include_once('includes/footer.php');
?>