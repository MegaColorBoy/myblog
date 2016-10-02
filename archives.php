<?php
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//Variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();
$posts = $handler->get_all_posts();
$posts_count = count($posts);
?>

<!-- main  remove from here-->
<div class="column col-sm-9" id="main">
  <div class="padding">
    <div class="full col-sm-9">

    <!-- Page heading -->
    <div style="margin-top:-60px;" class="col-sm-12" id="featured">   
      <div class="page-header text-muted">
        <h3>Archives</h3>
      </div> 
    </div>
    
    <!-- anything from here -->
    <div class="col-sm-12">   
    	<?php
    		for($i=0; $i<$posts_count; $i++)
    		{?>
    			<a style="font-style:italic;" class="text-muted divider" href='posts/<?php echo $posts[$i]['bp_slug'];?>'>

          		<?php echo $posts[$i]['bp_title'];?><span class="date"><?php echo date("d M Y",strtotime($posts[$i]['bp_date']));?></span>
          		</a>
          		<hr/>
    		<?php
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