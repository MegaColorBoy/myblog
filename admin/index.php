<?php
//Index Dashboard
session_start();
include_once('includes/header.php');
include_once('includes/db_handler.php');

$handler = new DB_HANDLER();

if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Welcome to MyBlog CMS Dashboard</h1>

	<?php
		//All of these panels are generated automatically !
		//Automation saves time indeed ;)
		$arr = array("Posts", "Categories", "Subscribers", "Comments", "Messages", "Links", "Images", "Users", "Page Hits");

		$panel_arr = $handler->ret_all_table_names($arr);
		$panel_arr_count = $handler->count_all_tables($panel_arr);

		for($i=0; $i<count($arr); $i++)
		{
			$panel_name = $arr[$i];
			$panel_icon = $handler->ret_icon($panel_arr[$i]);
			$panel_link = $handler->ret_link($panel_arr[$i]);
			$panel_count = $panel_arr_count[$i];
			$panel_color = $handler->ret_color($panel_arr[$i]);
			$handler->gen_panel($panel_name, $panel_icon, $panel_link, $panel_count, $panel_color);
		}
	?>

</div> 

<?php
include_once('includes/footer.php');
?>