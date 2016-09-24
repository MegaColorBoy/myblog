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
$get_post_id = $_GET['id'];
$post = $handler->get_post_by_id($get_post_id);
?>

<!-- main  remove from here-->
<div class="column col-sm-9" id="main">
  <div class="padding">
    <div class="full col-sm-9">

    <!-- Page heading -->
    <div style="margin-top:-60px;" class="col-sm-12" id="featured">   
      <div class="page-header text-muted">
        <h3><?php echo $post[0]['bp_title'];?></h3><!--post title-->
        <h6><span class="fa fa-clock-o"></span> <?php echo $post[0]['bp_date'];?></h6><!--post date-->
      </div> 
    </div>
       
    <!-- the post content goes here -->
    <div class="col-sm-12">
    	<div class="row">
    		<?php echo $post[0]['bp_cont'];?>
    	</div>
    </div>
    <!-- /post content until here-->

    <div class="col-sm-12">
      <div class="page-header text-muted divider">Related Posts</div>
    </div>
    
    <div class="col-sm-12">
      <div class="page-header text-muted divider">Comments</div>
    </div>

    <hr>
                          
    <!-- footer -->
    <div class="row" id="footer">    
      <div class="col-sm-6"></div>
      <div class="col-sm-6">
        <p>
        <!--<a href="#" class="pull-right">Made with <span>&#x2764;</span> by Abdush Shakoor</a><br>-->
        <a href="#" class="pull-right">Copyright &copy; 2016 Abdush Shakoor</a>
        </p>
      </div>
    </div>
    <!-- /footer -->
    <hr>  
    </div><!-- /col-9 -->
  </div><!-- /padding -->
</div>

<?php
include_once('includes/footer.php');
?>