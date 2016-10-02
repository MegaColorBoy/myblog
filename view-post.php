<?php
//View post
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

//Get post by id
//$get_post_id = $_GET['id'];
//$post = $handler->get_post_by_id($get_post_id);

$get_post_slug = $_GET['url'];
$post = $handler->get_post_by_slug($get_post_slug);

?>

<!-- main  remove from here-->
<div class="column col-sm-9" id="main">
  <div class="padding">
    <div class="full col-sm-9">

    <!-- Page heading -->
    <div style="margin-top:-60px;" class="col-sm-12" id="featured">   
      <div class="page-header text-muted">
        <h3><?php echo $post[0]['bp_title'];?></h3><!--post title-->
        <h6><span class="fa fa-clock-o"></span> <?php echo date("d M Y",strtotime($post[0]['bp_date']));?> |by Abdush Shakoor</h6><!--post date-->
      </div> 
    </div>
       
    <!-- the post content goes here -->
    <div class="col-sm-12">
    	<div class="row">
    		<?php echo $post[0]['bp_cont'];?>
    	</div>
    </div>
    <!-- /post content until here-->

    <!--Display related posts-->
    <div class="col-sm-12">
      <div class="page-header text-muted divider">Related Posts</div>
      <div class="">
        <?php
        $rel_posts = $handler->get_all_related_posts($post[0]['cat_title']);
        $res = count($rel_posts);
        $counter = 0;
        while($counter < $res)
        {
          if($rel_posts[$counter]['bp_title'] != $post[0]['bp_title'])
          {
        ?>
          <a style="font-style:italic;" class="text-muted divider" href='posts/<?php echo $rel_posts[$counter]['bp_slug'];?>'>
          <?php echo $rel_posts[$counter]['bp_title'];?><span class="date"><?php echo date("d M Y",strtotime($rel_posts[$counter]['bp_date']));?></span>
          </a>
          <?php if($counter < ($res-1)){echo'<hr/>';}?>
        <?php
          }
            $counter++;
        } 
        ?>
      </div>
    </div>
    <!-- /end of displaying related posts-->

    <div class="col-sm-12">
      <div class="page-header text-muted divider">Comments</div>
    </div>

    <hr>
                          
    <!-- display links and footer -->
    <?php 
    include_once('includes/display_links.php');
    include_once('includes/div_footer.php');
    ?>
    </div><!-- /col-9 -->
  </div><!-- /padding -->
</div>

<?php
include_once('includes/footer.php');
?>