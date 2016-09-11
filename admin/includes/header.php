<?php
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
{
  $username = $_SESSION['username'];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MyBlog CMS</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
    <!-- Custom styles for this template -->
   

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">MyBlog CMS</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <?php
              if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
              {
                $username = $_SESSION['username'];
                echo '<li><a href="me.php">'.$username.'</a></li>';
                echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';
            ?>
          </ul>
        </div>

      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <?php
              echo '<li class="active"><a href="index.php"><span class="glyphicon glyphicon-exclamation-sign"></span> Overview</a></li>';
              echo '<li><a href="posts.php"><span class="glyphicon glyphicon-list-alt"></span> Posts</a></li>';
              echo '<li><a href="categories.php"><span class="glyphicon glyphicon-list"></span> Categories</a></li>';
            ?>
          </ul>
          <ul class="nav nav-sidebar">
            <?php
              echo '<li><a href="subscribers.php"><span class="glyphicon glyphicon-user"></span> Subscribers</a></li>';
              echo '<li><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> Comments</a></li>';
              echo '<li><a href="feedback.php"><span class="glyphicon glyphicon-envelope"></span> Feedback/Messages</a></li>';
            ?>
          </ul>
          <ul class="nav nav-sidebar">
            <?php
              echo '<li><a href="links.php"><span class="glyphicon glyphicon-link"></span> Links</a></li>';
              echo '<li><a href="images.php"><span class="glyphicon glyphicon-picture"></span> Images</a></li>';
              echo '<li><a href="users.php"><span class="glyphicon glyphicon-sunglasses"></span> Users (Admin)</a></li>';
            ?>
          </ul>
          <ul class="nav nav-sidebar">
            <?php
              echo '<li><a href="../index.php"><span class="glyphicon glyphicon-globe"></span> View website</a></li>';
              }
            ?>
          </ul>
        </div>

        <!--
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>
        </div> 
        -->

      <!--</div>-->
    <!--</div>-->