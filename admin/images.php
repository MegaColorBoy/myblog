<?php
//Images
session_start();
include_once('includes/db_connect.php');
include_once('includes/db_handler.php');
include_once('includes/header.php');

//check if the user is logged in
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false)
{
	header('Location: login.php');
}

//variables
$db = new DB_CONNECT();
$conn = $db->connect();
$handler = new DB_HANDLER();

$num_images = "SELECT COUNT(img_id) FROM images";
$sql = mysqli_query($conn, $num_images);
$result = mysqli_fetch_assoc($sql);
$count = $result['COUNT(img_id)'];

//Fetch all images
$images = $handler->get_all_images();

//Validation check for downloading image from URL
if(isset($_POST['img_submit']))
{
	extract($_POST);

	$img_name = mysqli_real_escape_string($conn, $img_name);
	$img_url = mysqli_real_escape_string($conn, $img_url);
	$img_type = mysqli_real_escape_string($conn, $img_type);

	if(!isset($error))
	{
		$result = $handler->download_image_from_url($img_name, $img_type, $img_url);

		if(!$result)
		{
			echo "Error: " . mysqli_error();
		}
		else
		{
			$handler->print_msg("Image has been downloaded.", "images.php");
		}
	}

	if(isset($error))
	{
		foreach($error as $error)
		{
			echo '<p>'.$error.'</p>';
		}
	}
}

?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Manage images</h1>

    <!-- search bar -->
    <input type="text" id="search_bar" onkeyup="searchTable()" placeholder="Search for image..."/>
    <div class="table-responsive">
    	<table class="table table-striped" id="collapse_table">
    		<thead>
    			<tr>
	    			<th>Image ID</th>
	    			<th>Image name</th>
	    			<th>Image type</th>
	    			<th>Image path</th>
	    			<th>Created at</th>
	    			<th>Action</th>
    			</tr>
    			<tbody>
    				<!--insert php code-->
    				<?php
    					if(!$images || !$result)
    					{
    						echo '<h2 class="sub-header">There are no images on this section';
    						//echo "Error: " . mysqli_error();
    					}

    					$counter = 0;
    					while($counter < $count)
    					{
    						echo '<tr>';
    						echo '<td>'.$images[$counter]['img_id'].'</td>';
    						echo '<td>'.$images[$counter]['img_name'].'</td>';
    						echo '<td>'.$images[$counter]['img_type'].'</td>';
    						echo '<td><img class="img-thumbnail" height="200" width="200" src="'.$images[$counter]['img_path'].'"></td>';
    						echo '<td>'.$images[$counter]['uploaded_at'].'</td>';
    						?>
    						<td>
    							<a class="btn btn-danger btn-block" href="delete-image.php?id=<?php echo $images[$counter]['img_id'];?>"
    								onclick="return confirm('Are you sure you want to delete this image ?');">Delete</a>
    						</td>
    						<?php
    						echo '</tr>';
    						$counter++;
    					}
    				?>
    			</tbody>
    		</thead>
    	</table>
    	<a href="add-image.php" class="btn btn-primary btn-md">Add image</a>
    	<a href="#dwnld_img_modal" role="button" data-toggle="modal" class="btn btn-primary btn-md">Download image via URL</a>
    </div>
</div>

<!-- Modal for downloading image from URL -->
<div class="modal fade" id="dwnld_img_modal" tabindex="-1" role="dialog" aria-labelledby="dwnld_img_modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Download image from URL</h4>	
			</div>
			<div class="modal-body">
				<form id="submit_img" class="form-horizontal" name="submit_img" method="post" action="">
					<div class="form-group">
						<label class="control-label col-md-4" for="imgname">Enter image name:</label>
						<div class="col-md-6">
							<input required placeholder="Image name" type="text" class="form-control" id="img_name" name="img_name" 
							value='<?php if(isset($error)){echo $_POST['img_name'];}?>'/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="imgurl">Enter image URL:</label>
						<div class="col-md-6">
							<input required placeholder="Image URL" type="text" class="form-control" id="img_url" name="img_url"
							value='<?php if(isset($error)){echo $_POST['img_url'];} ?>'/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="imgtype">Select image type:</label>
						<div class="col-md-6">
							<select class="form-control" name="img_type">
								<option>.jpg</option>
								<option>.png</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<button type="submit" value="Submit" name="img_submit" class="btn btn-primary btn-block">Download</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div> 

<?php
include_once('includes/footer.php');
?>