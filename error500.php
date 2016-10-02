<?php
//Error 404 page
include_once('includes/header.php'); 
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
    <div class="error-404">
      <div class="error-code m-b-10 m-t-20">500 <i class="fa fa-warning"></i></div>
        <h2 class="font-bold">Internal Server Error :(</h2>

        <div class="error-desc">
        Sorry man, but the site has been facing some technical problems.<br/>
        Try refreshing the page or click the button below to go back to Homepage.
        <div>
          <br/>
          <a href="/my_blog" class="btn btn-block btn-primary"> <span class="fa fa-home"></span> Back to Homepage</a>
        </div>
    </div>
    <!-- /anything until here-->

    <!-- display links and footer -->
    <?php 
    include_once('includes/div_footer.php');
    ?>
    
    </div><!-- /col-9 -->
  </div><!-- /padding -->
</div>
<!-- /main -->
<?php
include_once('includes/footer.php');
?>