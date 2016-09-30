<?php
$num_links = "SELECT COUNT(link_id) FROM links";
$sql2 = mysqli_query($conn, $num_links);
$result2 = mysqli_fetch_assoc($sql2);
$count2 = $result2['COUNT(link_id)'];
//Fetch all links
$links = $handler->get_all_links();
?>

<div style="margin-top:-30px;" class="col-sm-12">
      <div class="page-header text-muted divider">Connect with Me</div>
    </div>
<!-- display links -->
    <div class="row">
      <div class="col-sm-6">
        <?php
          $link_counter = 0;
          while($link_counter < $count2)
          {
            echo '<a href="'.$links[$link_counter]['link_url'].'">'.$links[$link_counter]['link_title'].'</a>';
            
            if($link_counter < ($count2 -1))
            {
              echo '<small class="text-muted"> | </small>';
            }
            $link_counter++;
          }
        ?>
      </div>
    </div>