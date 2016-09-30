<?php
//Index page
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//Variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

$num_posts = "SELECT COUNT(bp_id) FROM blog_posts";
$sql = mysqli_query($conn, $num_posts);
$result = mysqli_fetch_assoc($sql);
$count = $result['COUNT(bp_id)'];

//Fetch all posts
$posts = $handler->get_all_posts(); 
?>
          
<!-- main  remove from here-->
<div class="column col-sm-9" id="main">
  <div class="padding">
    <div class="full col-sm-9">

    <!-- Page heading -->
    <div style="margin-top:-60px;" class="col-sm-12" id="featured">   
      <div class="page-header text-muted">
        <h3>Diary of a Passionate Programmer</h3>
      </div> 
    </div>
    
    <!-- anything from here -->      
    <?php
    $counter = 0;
    while($counter < $count)
    {?>
      <div class="row">    
        <div class="col-sm-10">
          <h3><a href='posts/<?php echo $posts[$counter]['bp_id'];?>'><?php echo $posts[$counter]['bp_title'];?></a></h3>
          <h4><span class="label label-info"><?php echo $posts[$counter]['cat_title']; ?></span></h4><h4>
          <small class="text-muted"><span class="fa fa-clock-o"></span> <?php echo $posts[$counter]['bp_date'];?> • <a href='posts/<?php echo $posts[$counter]['bp_id'];?>' class="text-muted">Read More</a></small>
          </h4>
        </div>
        <?php if(($counter + 1) < $count)
        {?>
          <div class="col-sm-12"><hr/></div>
        <?php
        }
        ?>
      </div>
      <?php
      $counter++;
    }
    ?>
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