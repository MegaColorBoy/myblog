<?php
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//Variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();
?>

<!-- main  remove from here-->
<div class="column col-sm-9" id="main">
  <div class="padding">
    <div class="full col-sm-9">

    <!-- Page heading -->
    <div style="margin-top:-60px;" class="col-sm-12" id="featured">   
      <div class="page-header text-muted">
        <h3>Categories</h3>
      </div> 
    </div>
    
    <!-- anything from here -->
    <div class="col-sm-12">   
    <?php
	    //1. get all categories
	    $categories = $handler->get_all_categories();
		for($i=0; $i<count($categories); $i++)
		{
			//2. get all posts by category
			$posts = $handler->get_all_posts_by_category($categories[$i]['cat_id']);
			if(count($posts) !=0)
			{
				?>
				<div style="margin-top:10px;" class="page-header text-muted divider"><?php echo $categories[$i]['cat_title'];?></div>
				<?php
				//2. get all posts by category
				$posts = $handler->get_all_posts_by_category($categories[$i]['cat_id']);
				for($j=0; $j<count($posts); $j++)
				{?>
					<div class="">
					<a style="font-style:italic;" class="text-muted divider" href='posts/<?php echo $posts[$j]['bp_slug'];?>'>
						<?php echo $posts[$j]['bp_title'];?><span class="date"><?php echo date("d M Y",strtotime($posts[$j]['bp_date']));?></span>
					</a>
					<?php if($j < (count($posts)-1)){echo'<hr/>';}?>
					</div>
					<?php
				}
			}
		}
    ?>
	</div>
    <!-- /anything until here-->

    <!-- display links and footer -->
    <?php 
    include_once('includes/display_links.php');
    include_once('includes/div_footer.php');
    ?>

    </div><!-- /col-9 -->
  </div><!-- /padding -->
</div>
<!-- /main -->


<?php
include_once('includes/footer.php');
?>