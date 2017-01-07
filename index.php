<?php
include_once('includes/header.php');

//Fetch all links
$links = $db_handler->get_all_links();
?>
<h2>Abdush Shakoor / MegaColorBoy</h2>
<p>Computer Science + Mathematics Geek.</p>
<a href="images/my-image.jpg"><img class="img-responsive" width="300" height="300" src="images/my-image.jpg"></a>

<!--<h3>About myself:</h3>-->

<h3><a class="h1_link" href="blog.php">Blog</a></h3> <!-- redirect to a page called megacolorboy.com/blog -->


<h3>Areas of Interest and Research</h3>
<ul style="list-style-type:square;">
  <li>Algorithms/Data Structures/Mathematics &#8594; [<a href="#">View projects</a>]</li>
  <li>Systems and Network Programming</li>
  <li>Graphics Programming</li>
  <li>Databases</li>
  <li>Web/Mobile Development</li>
  <li>Cryptography and Security Programming</li>
  <li>Artificial Intelligence</li>
  <li>Game Development</li>
</ul>

<!-- redirect to a page with solutions called megacolorboy.com/solutions -->
<h3>Competitive Programming Solutions</h3>
<ul style="list-style-type:square;">
  <li>Project Euler</li>
  <li>CoderByte</li>
  <li>CodeEval</li>
  <li>CodeAbbey</li>
  <li>LeetCode</li>
</ul>

<h3>Links</h3>
<?php
  for($i=0;$i<count($links);$i++)
  { ?>
      [<a href="<?php echo $links[$i]['link_url'];?>"><?php echo $links[$i]['link_title'];?></a>]
 <?php }
?>
</ul>

<h3><a class="h1_link" href="#">Resume</a></h3>

<h3>Contact</h3>
<p>E-mail: <a href="mailto:abdushshakoor1992@hotmail.com">abdushshakoor1992@hotmail.com</a> [I will try my best to reply ASAP !]</p>
<?php
include_once('includes/footer.php');
?>