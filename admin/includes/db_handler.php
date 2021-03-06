<?php
//This contains all the functions for the CMS
class DB_HANDLER
{
	private $conn;

	//Constructor
	function __construct()
	{
		include_once('db_connect.php');
		$db = new DB_CONNECT();
		$this->conn = $db->connect();
	}

	//----Utility Functions----//
	//Bind results from the array
	function bind_result_array($stmt)
	{
		$meta = $stmt->result_metadata();
		$result = array();

		while($field = $meta->fetch_field())
		{
			$result[$field->name] = NULL;
			$params[] = &$result[$field->name];
		}

		call_user_func_array(array($stmt, 'bind_result'), $params);
		return $result;
	}

	//Get copy of array references
	function getCopy($row)
	{
		return array_map(create_function('$a', 'return $a;'), $row);
	}

	//Random password generator
	function rand_pass_gen($length)
	{
		$chars = "abcdefghijklmnopqrstuvwzxyz\$_?-0123456789";
		$charArr = str_split($chars);
		$result = "";

		for($i=0; $i<$length; $i++)
		{
			//returns the index of the random char
			$rand_char = array_rand($charArr);
			//concatenate the char into new string
			$result .= "" . $charArr[$rand_char];
		}
		return $result;
	}

	//Prints error message and redirects to a webpage
	function print_msg($message, $redirect)
	{
		echo "<script type='text/javascript'>
				alert('".$message."');
				window.location.replace('".$redirect."');
			</script>";
	}

	//Create slug for URLs
	//Rewrite in .htaccess to display SEO URLs instead
	function gen_slug($url)
	{
		//prepare string with basic normalization
		$url = strtolower($url);
		$url = strip_tags($url);
		$url = stripslashes($url);
		$url = html_entity_decode($url);

		//Remove any quotes
		$url = str_replace('\"','',$url);

		//Replace non-alpha chars with '-'
		$match = '/[^a-z0-9]+/';
		$replace = '-';
		$url = preg_replace($match, $replace, $url);
		$url = trim($url, '-');
		return $url;
	}

	//Generate panel -- too lazy to make them manually lol :) !
	function gen_panel($panel_name, $panel_icon, $panel_link, $panel_count, $panel_color)
	{
	echo '<div class="col-lg-4 col-md-6">';
		echo '<div class="panel '.$panel_color.'">';
			echo '<div class="panel-heading">';
				echo '<div class="row">';
					echo '<div class="col-xs-3">';
						echo '<span class="huge-icon glyphicon '.$panel_icon.'"></span>';
					echo '</div>';
					echo '<div class="col-xs-9 text-right">';
					echo '<div><h1>'.$panel_count.'</h1></div>';
					echo '<div>'.$panel_name.'</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '<a href="'.$panel_link.'">';
				echo '<div class="panel-footer">';
					echo '<span class="pull-left">View '.$panel_name.'</span>';
					echo '<span class="pull-right glyphicon glyphicon-circle-arrow-right"></span>';
					echo '<div class="clearfix"></div>';
				echo '</div>';
			echo '</a>';
		echo '</div>';
	echo '</div>';
	}

	//Return icon
	function ret_icon($icon_name)
	{
		switch($icon_name)
		{
			case "users":
				return "glyphicon-sunglasses";
				break;
			case "blog_posts":
				return "glyphicon-list-alt";
				break;
			case "categories":
				return "glyphicon-list";
				break;
			case "subscribers":
				return "glyphicon-user";
				break;
			case "messages":
				return "glyphicon-envelope";
				break;
			case "images":
				return "glyphicon-picture";
				break;
			case "links":
				return "glyphicon-link";
				break;
			case "comments":
				return "glyphicon-comment";
				break;
			case "page_count":
				return "glyphicon-globe";
				break;
		}
	}

	//Return color
	function ret_color($panel_name)
	{
		switch($panel_name)
		{
			case "users":
				return "panel-red";
				break;
			case "blog_posts":
				return "panel-primary";
				break;
			case "categories":
				return "panel-green";
				break;
			case "subscribers":
				return "panel-yellow";
				break;
			case "messages":
				return "panel-primary";
				break;
			case "images":
				return "panel-yellow";
				break;
			case "links":
				return "panel-green";
				break;
			case "comments":
				return "panel-red";
				break;
			case "page_count":
				return "panel-primary";
				break;
		}
	}

	//Return link
	function ret_link($link_name)
	{
		switch($link_name)
		{
			case "users":
				return "users.php";
				break;
			case "blog_posts":
				return "posts.php";
				break;
			case "categories":
				return "categories.php";
				break;
			case "subscribers":
				return "subscribers.php";
				break;
			case "messages":
				return "feedback.php";
				break;
			case "images":
				return "images.php";
				break;
			case "links":
				return "links.php";
				break;
			case "comments":
				return "comments.php";
				break;
			case "page_count":
				return "#";
				break;
		}
	}

	//Count table
	function count_table($table_id, $table_name)
	{
		//Anything except "page hits"
		if($table_id != "pg_cnt_id" && $table_name != "page_count")
		{
			$num_table = "SELECT COUNT($table_id) FROM $table_name";
			$sql = mysqli_query($this->conn, $num_table);
			$result = mysqli_fetch_assoc($sql);
			$count = $result["COUNT(".$table_id.")"];
		}
		else
		{
			$num_hits = "SELECT * FROM $table_name";
			$sql = mysqli_query($this->conn, $num_hits);
			$result = mysqli_fetch_assoc($sql);
			$count = $result["pg_cnt_val"];
		}
		return $count;
	}

	//Return primary key of table
	function ret_pk($table_name)
	{
		switch($table_name)
		{
			case "users":
				return "user_id";
				break;
			case "blog_posts":
				return "bp_id";
				break;
			case "categories":
				return "cat_id";
				break;
			case "subscribers":
				return "sub_id";
				break;
			case "messages":
				return "msg_id";
				break;
			case "images":
				return "img_id";
				break;
			case "links":
				return "link_id";
				break;
			case "comments":
				return "cmt_id";
				break;
			case "page_count":
				return "pg_cnt_id";
				break;
		}
	}

	//Return table name
	function ret_tn($table_name)
	{
		if($table_name == "Posts")
		{
			return "blog_posts";
		}
		else if($table_name == "Page Hits")
		{
			return "page_count";
		}
		else
		{
			return strtolower($table_name);
		}
	}

	//Return an array that contains all table names
	function ret_all_table_names($table_arr)
	{
		$new_arr = array();
		for($i=0; $i<count($table_arr); $i++)
		{
			$new_arr[$i] = $this->ret_tn($table_arr[$i]);
		}
		return $new_arr;
	}

	//Return an array that counts all tables
	function count_all_tables($table_arr)
	{
		$new_arr = array();
		for($i=0; $i<count($table_arr); $i++)
		{
			$table_name = $table_arr[$i];
			$table_id = $this->ret_pk($table_name);
			$new_arr[$i] = $this->count_table($table_id, $table_name);
		}
		return $new_arr;
	}
	//----Utility Functions----//

	//----Admin-User Functions----//
	//Create user
	public function add_user($username, $password, $name, $email)
	{
		include_once('pass_hash.php');

		//Check if the user exists
		if(!$this->is_user_exists($username))
		{
			$pass_hash = PASS_HASH::hash($password);

			$stmt = $this->conn->prepare("INSERT INTO users (username, password, name, email, created_at) VALUES (?,?,?,?,NOW())");
			$stmt->bind_param("ssss", $username, $pass_hash, $name, $email);

			$result = $stmt->execute();

			$stmt->close();

			if($result)
			{
				return USER_CREATED_SUCCESSFULLY;
			}
			else
			{
				return USER_CREATE_FAILED;
			}
		}
		else
		{
			return USER_ALREADY_EXISTED;
		}
	}

	//Check if user exists
	public function is_user_exists($username)
	{
		$stmt = $this->conn->prepare("SELECT user_id FROM users WHERE username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->store_result();
		$num_rows = $stmt->num_rows;
		$stmt->close();
		return $num_rows > 0;
	}

	//Check user login credentials
	public function check_user_login($username, $pwd)
	{
		include_once('pass_hash.php');

		$stmt = $this->conn->prepare("SELECT password FROM users WHERE username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($password);
		$stmt->store_result();

		if($stmt->num_rows > 0)
		{
			$stmt->fetch();
			$stmt->close();

			//Check if the passwords are matching
			if(PASS_HASH::checkPassword($password, $pwd))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$stmt->close();
			return false;
		}
	}

	//Get user by username - used for login verification
	public function get_user_by_username($username)
	{
		$stmt = $this->conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
		$stmt->bind_param("s", $username);

		if($stmt->execute())
		{
			$user = array();
			$row = $this->bind_result_array($stmt);

			if(!$stmt->error)
			{
				$counter = 0;
				while($stmt->fetch())
				{
					$user[$counter] = $this->getCopy($row);
					$counter++;
				}
			}
			$stmt->close();
			return $user;
		}
		else
		{
			return NULL;
		}
	}

	//Get user by user id
	public function get_user_by_user_id($user_id)
	{
		$stmt = $this->conn->prepare("SELECT username, name, email, created_at FROM users WHERE user_id = ?");
		$stmt->bind_param("i", $user_id);

		if($stmt->execute())
		{
			$user = array();
			$row = $this->bind_result_array($stmt);

			if(!$stmt->error)
			{
				$counter = 0;
				while($stmt->fetch())
				{
					$user[$counter] = $this->getCopy($row);
					$counter++;
				}
			}
			$stmt->close();
			return $user;
		}
		else
		{
			return NULL;
		}
	}

	//Get email by username -- used mainly for resetting the password
	public function get_email_by_username($username)
	{
		$stmt = $this->conn->prepare("SELECT email FROM users WHERE username = ?");
		$stmt->bind_param("s", $username);

		if($stmt->execute())
		{
			$user = array();
			$row = $this->bind_result_array($stmt);

			if(!$stmt->error)
			{
				$counter = 0;
				while($stmt->fetch())
				{
					$user[$counter] = $this->getCopy($row);
					$counter++;
				}
			}
			$stmt->close();
			return $user;
		}
		else
		{
			return NULL;
		}
	}

	//Get all users - might be a useful function sometime
	public function get_all_users()
	{
		$users = array();
		$stmt = $this->conn->prepare("SELECT * FROM users");
		$stmt->execute();
		$row = $this->bind_result_array($stmt);

		if(!$stmt->error)
		{
			$counter = 0;
			while($stmt->fetch())
			{
				$users[$counter] = $this->getCopy($row);
				$counter++;
			}
		}
		$stmt->close();
		return $users;
	}

	//Edit/Update user details
	public function update_user($user_id, $username, $password, $name, $email)
	{
		include_once("pass_hash.php");
		$stmt = $this->conn->prepare("UPDATE users SET username = ?, password = ?, email = ?, name = ?, created_at = NOW() WHERE user_id = ?");
		$pass_hash = PASS_HASH::hash($password);
		$stmt->bind_param("ssssi", $username, $pass_hash, $email, $name, $user_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;		
	}

	//Edit/Update user details -- without password changes
	public function update_user2($user_id, $username, $name, $email)
	{
		$stmt = $this->conn->prepare("UPDATE users SET username = ?, name = ?, email = ?, created_at = NOW() WHERE user_id = ?");
		$stmt->bind_param("sssi", $username, $name, $email, $user_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Reset password
	public function reset_password($username, $password)
	{
		include_once("pass_hash.php");
		$stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE username = ?");
		$pass_hash = PASS_HASH::hash($password);
		$stmt->bind_param("ss", $pass_hash, $username);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Delete user by user id
	public function delete_user($user_id)
	{
		$stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = ?");
		$stmt->bind_param("i", $user_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}
	//----Admin-User Functions----//

	//----Blogpost functions----//
	//Add post
	public function add_post($bp_title, $bp_slug, $bp_desc, $bp_cont)
	{
		$stmt = $this->conn->prepare("INSERT INTO blog_posts (bp_title, bp_slug, bp_desc, bp_cont, bp_date) VALUES (?,?,?,?,NOW())");
		$stmt->bind_param("ssss", $bp_title, $bp_slug, $bp_desc, $bp_cont);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}

	//Add related post by blog post id and category id
	public function add_related_post($bp_id, $cat_id)
	{
		$stmt = $this->conn->prepare("INSERT INTO bp_cats (bp_id, cat_id) VALUES (?,?)");
		$stmt->bind_param("ii", $bp_id, $cat_id);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}

	//Edit post
	public function update_post($bp_id, $bp_title, $bp_slug, $bp_desc, $bp_cont)
	{
		$stmt = $this->conn->prepare("UPDATE blog_posts SET bp_title = ?, bp_slug = ?, bp_desc = ?, bp_cont = ? WHERE bp_id = ?");
		$stmt->bind_param("ssssi", $bp_title, $bp_slug, $bp_desc, $bp_cont, $bp_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Update related post category
	public function update_related_post($bp_id, $new_cat_id)
	{
		$stmt = $this->conn->prepare("UPDATE bp_cats SET cat_id = ? WHERE bp_id = ?");
		$stmt->bind_param("ii", $new_cat_id, $bp_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Delete post by id
	public function delete_post($bp_id)
	{
		$stmt = $this->conn->prepare("DELETE FROM blog_posts WHERE bp_id = ?");
		$stmt->bind_param("i", $bp_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Delete related post
	public function delete_related_post($bp_id)
	{
		$stmt = $this->conn->prepare("DELETE FROM bp_cats WHERE bp_id = ?");
		$stmt->bind_param("i", $bp_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Get post by id
	public function get_post_by_id($bp_id)
	{
		$stmt = $this->conn->prepare("SELECT bp_title, bp_slug, bp_desc, bp_cont, bp_date FROM blog_posts WHERE bp_id = ?");
		$stmt->bind_param("i", $bp_id);
		if($stmt->execute())
		{
			$post = array();
			$row = $this->bind_result_array($stmt);
			if(!$stmt->error)
			{
				$counter = 0;
				while($stmt->fetch())
				{
					$post[$counter] = $this->getCopy($row);
					$counter++;
				}
			}
			$stmt->close();
			return $post;
		}
		else
		{
			return NULL;
		}
	}

	//Get post id by post slug
	public function get_post_id($bp_slug)
	{
		$stmt = $this->conn->prepare("SELECT bp_id FROM blog_posts WHERE bp_slug = ?");
		$stmt->bind_param("s", $bp_slug);
		if($stmt->execute())
		{
			$post_id = array();
			$row = $this->bind_result_array($stmt);

			if(!$stmt->error)
			{
				$counter = 0;
				while($stmt->fetch())
				{
					$post_id[$counter] = $this->getCopy($row);
					$counter++;
				}
				$stmt->close();
				return $post_id;
			}
		}
		else
		{
			return NULL;
		}
	}

	//Get all posts
	//Note: Must write new query to display category as well
	public function get_all_posts()
	{
		$posts = array();
		$stmt = $this->conn->prepare("SELECT blog_posts.*, categories.cat_id, categories.cat_title AS cat_title FROM blog_posts LEFT JOIN bp_cats ON bp_cats.bp_id = blog_posts.bp_id LEFT JOIN categories ON bp_cats.cat_id = categories.cat_id");
		$stmt->execute();
		$row = $this->bind_result_array($stmt);

		if(!$stmt->error)
		{
			$counter = 0;
			while($stmt->fetch())
			{
				$posts[$counter] = $this->getCopy($row);
				$counter++;
			}
		}
		$stmt->close();
		return $posts;
	}
	//----Blogpost functions----//

	//----Categories functions----//
	//Add category
	public function add_category($cat_title, $cat_slug)
	{
		$stmt = $this->conn->prepare("INSERT INTO categories (cat_title, cat_slug, cat_date) VALUES (?,?,NOW())");
		$stmt->bind_param("ss", $cat_title, $cat_slug);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}

	//Edit category
	public function update_category($cat_id, $cat_title, $cat_slug)
	{
		$stmt = $this->conn->prepare("UPDATE categories SET cat_title = ?, cat_slug = ?, cat_date = NOW() WHERE cat_id = ?");
		$stmt->bind_param("ssi", $cat_title, $cat_slug, $cat_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Delete category
	public function delete_category($cat_id)
	{
		$stmt = $this->conn->prepare("DELETE FROM categories WHERE cat_id = ?");
		$stmt->bind_param("i", $cat_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Get category by category id
	public function get_cat_by_cat_id($cat_id)
	{
		$stmt = $this->conn->prepare("SELECT cat_title, cat_slug FROM categories WHERE cat_id = ?");
		$stmt->bind_param("i", $cat_id);

		if($stmt->execute())
		{
			$category = array();
			$row = $this->bind_result_array($stmt);

			if(!$stmt->error)
			{
				$counter = 0;
				while($stmt->fetch())
				{
					$category[$counter] = $this->getCopy($row);
					$counter++;
				}
			}
			$stmt->close();
			return $category;
		}
		else
		{
			return NULL;
		}
	}

	//get category id by category
	public function get_cat_id($cat_title)
	{
		$stmt = $this->conn->prepare("SELECT cat_id FROM categories WHERE cat_title = ?");
		$stmt->bind_param("s", $cat_title);

		if($stmt->execute())
		{
			$cat_id = array();
			$row = $this->bind_result_array($stmt);

			if(!$stmt->error)
			{
				$counter = 0;
				while($stmt->fetch())
				{
					$cat_id[$counter] = $this->getCopy($row);
					$counter++;
				}
			}
			$stmt->close();
			return $cat_id;
		}
		else
		{
			return NULL;
		}
	}

	//get category id by bp_id
	public function get_cat_id_by_bp_id($bp_id)
	{
		$stmt = $this->conn->prepare("SELECT cat_id FROM bp_cats WHERE bp_id = ?");
		$stmt->bind_param("i", $bp_id);

		if($stmt->execute())
		{
			$cat_id = array();
			$row = $this->bind_result_array($stmt);

			if(!$stmt->error)
			{
				$counter = 0;
				while($stmt->fetch())
				{
					$cat_id[$counter] = $this->getCopy($row);
					$counter++;
				}
			}
			$stmt->close();
			return $cat_id;
		}
		else
		{
			return NULL;
		}
	}

	//Get all categories
	public function get_all_categories()
	{
		$categories = array();
		$stmt = $this->conn->prepare("SELECT * FROM categories");
		$stmt->execute();
		$row = $this->bind_result_array($stmt);

		if(!$stmt->error)
		{
			$counter = 0;
			while($stmt->fetch())
			{
				$categories[$counter] = $this->getCopy($row);
				$counter++;
			}
		}
		$stmt->close();
		return $categories;
	}
	//----Categories functions----//

	//----Links functions----//
	//Add a link
	public function add_link($link_title, $link_url)
	{
		$stmt = $this->conn->prepare("INSERT INTO links (link_title, link_url, created_at) VALUES (?,?,NOW())");
		$stmt->bind_param("ss", $link_title, $link_url);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}

	//Edit a link using link id
	public function update_link($link_id, $link_title, $link_url)
	{
		$stmt = $this->conn->prepare("UPDATE links SET link_title = ?, link_url = ?, created_at = NOW() WHERE link_id = ?");
		$stmt->bind_param("ssi", $link_title, $link_url, $link_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Delete a link using link id
	public function delete_link($link_id)
	{
		$stmt = $this->conn->prepare("DELETE FROM links WHERE link_id = ?");
		$stmt->bind_param("i", $link_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}	

	//Get link by link id
	public function get_link_by_link_id($link_id)
	{
		$stmt = $this->conn->prepare("SELECT link_title, link_url FROM links WHERE link_id = ?");
		$stmt->bind_param("i", $link_id);
		
		if($stmt->execute())
		{
			$link = array();
			$row = $this->bind_result_array($stmt);

			if(!$stmt->error)
			{
				$counter = 0;
				while($stmt->fetch())
				{
					$link[$counter] = $this->getCopy($row);
					$counter++;
				}
			}
			$stmt->close();
			return $link;
		}	
		else
		{
			return NULL;
		}	
	}

	//Get all links
	public function get_all_links()
	{
		$links = array();
		$stmt = $this->conn->prepare("SELECT * FROM links");
		$stmt->execute();
		$row = $this->bind_result_array($stmt);

		if(!$stmt->error)
		{
			$counter = 0;
			while($stmt->fetch())
			{
				$links[$counter] = $this->getCopy($row);
				$counter++;
			}
		}
		$stmt->close();
		return $links;
	}
	//----Links functions----//

	//----Subscriber functions----//
	//Add subscriber - for test only
	public function add_subscriber($sub_name, $sub_email)
	{
		$stmt = $this->conn->prepare("INSERT INTO subscribers (sub_name, sub_email, sub_date_joined) VALUES (?,?,NOW())");
		$stmt->bind_param("ss", $sub_name, $sub_email);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}

	//Check for duplicate subscriber
	public function check_duplicate_subscriber($sub_email)
	{
		$stmt = $this->conn->prepare("SELECT * FROM subscribers WHERE sub_email = ?");
		$stmt->bind_param("s", $sub_email);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Delete subscriber by sub_id
	public function delete_subscriber($sub_id)
	{
		$stmt = $this->conn->prepare("DELETE FROM subscribers WHERE sub_id = ?");
		$stmt->bind_param("i", $sub_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Get subscriber
	public function get_subscriber_by_id($sub_id)
	{
		$stmt = $this->conn->prepare("SELECT sub_name, sub_email, sub_date_joined FROM subscribers WHERE sub_id = ?");
		$stmt->bind_param("i", $sub_id);

		if($stmt->execute())
		{
			$subscriber = array();
			$row = $this->bind_result_array($stmt);
			if(!$stmt->error)
			{
				$counter = 0;
				while($stmt->fetch())
				{
					$subscriber[$counter] = $this->getCopy($row);
					$counter++;
				}
			}
			$stmt->close();
			return $subscriber;
		}	
		else
		{
			return NULL;
		}
	}

	//Get all subscribers
	public function get_all_subscribers()
	{
		$subscribers = array();
		$stmt = $this->conn->prepare("SELECT * FROM subscribers");
		$stmt->execute();
		$row = $this->bind_result_array($stmt);

		if(!$stmt->error)
		{
			$counter = 0;
			while($stmt->fetch())
			{
				$subscribers[$counter] = $this->getCopy($row);
				$counter++;
			}
		}
		$stmt->close();
		return $subscribers;
	}

	//----Subscriber functions----//

	//----Images functions----//
	//Add Image
	/*
		Note: If you're using the XAMPP/LAMPP stack, please change the "images" folder
		permission to Read and Write for "Others"(linux) or "Everyone"(mac osx)
		Otherwise, the image won't be added to the folder
	*/
	public function add_image($img_name, $img_type, $img_path)
	{
		$stmt = $this->conn->prepare("INSERT INTO images (img_name, img_type, img_path, uploaded_at) VALUES (?,?,?,NOW())");
		$stmt->bind_param("sss", $img_name, $img_type, $img_path);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}

	//Edit Image - just name only
	public function edit_image($img_id, $img_name)
	{
		$stmt = $this->conn->prepare("UPDATE images SET img_name = ? WHERE img_id = ?");
		$stmt->bind_param("si", $img_name, $img_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Delete Image
	public function delete_image($img_id)
	{
		//Delete it from the directory before removing from the DB
		$path = $this->get_img_dir($img_id);
		unlink($path['img_path']);

		$stmt = $this->conn->prepare("DELETE FROM images WHERE img_id = ?");
		$stmt->bind_param("i", $img_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Download Image from URL (e.g: from any website)
	//This also add the imagepath into the DB
	public function download_image_from_url($img_name, $img_type, $img_url)
	{
		$img_name = str_replace(" ","",$img_name);
		$raw_image = file_get_contents($img_url);
		$img_path = "../images/".$img_name.$img_type;
		file_put_contents($img_path,$raw_image);

		// this is where you add the img to the db
		$result = $this->add_image($img_name.$img_type, $img_type, $img_path);
		return $result;
	}

	//Get image by img_id
	public function get_image_by_id($img_id)
	{
		$stmt = $this->conn->prepare("SELECT * FROM images WHERE img_id = ?");
		$stmt->bind_param("i", $img_id);
		
		if($stmt->execute())
		{
			$image = array();
			if(!$stmt->error)
			{
				$counter = 0;
				while($stmt->fetch())
				{
					$image[$counter] = $this->getCopy($row);
					$counter++;
				}
			}
			$stmt->close();
			return $image;
		}
		else
		{
			return NULL;
		}
	}

	//Get all images
	public function get_all_images()
	{
		$images = array();
		$stmt = $this->conn->prepare("SELECT * FROM images");
		$stmt->execute();
		$row = $this->bind_result_array($stmt);

		if(!$stmt->error)
		{
			$counter = 0;
			while($stmt->fetch())
			{
				$images[$counter] = $this->getCopy($row);
				$counter++;
			}
		}
		$stmt->close();
		return $images;
	}

	//Get image directory by img_id
	public function get_img_dir($img_id)
	{
		$stmt = $this->conn->prepare("SELECT img_path FROM images WHERE img_id = ?");
		$stmt->bind_param("i", $img_id);

		if($stmt->execute())
		{
			$path = $stmt->get_result()->fetch_assoc();
			$stmt->close();
			return $path;
		}
		else
		{
			return NULL;
		}
	}
	//----Images functions----//

	//----Comments functions----//

	//Add comment
	public function add_comment($bp_id, $cmt_username, $cmt_email, $cmt_content)
	{
		$stmt = $this->conn->prepare("INSERT INTO comments (bp_id, cmt_username, cmt_email, cmt_content, posted_at) VALUES (?,?,?,?,NOW())");
		$stmt->bind_param("isss", $bp_id, $cmt_username, $cmt_email, $cmt_content);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}

	//Get all comments
	public function get_all_comments()
	{
		$comments = array();
		$stmt = $this->conn->prepare("SELECT * FROM comments");
		$stmt->execute();
		$row = $this->bind_result_array($stmt);

		if(!$stmt->error)
		{
			$counter = 0;
			while($stmt->fetch())
			{
				$comments[$counter] = $this->getCopy($row);
				$counter++;
			}
		}
		$stmt->close();
		return $comments;
	}

	//Delete comment
	public function delete_comment($cmt_id)
	{
		$stmt = $this->conn->prepare("DELETE FROM comments WHERE cmt_id = ?");
		$stmt->bind_param("i", $cmt_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}
	//----Comments functions----//

	//----Messages functions----//
	//Get all messages
	public function get_all_messages()
	{
		$messages = array();
		$stmt = $this->conn->prepare("SELECT * FROM messages ORDER BY msg_date DESC");
		$stmt->execute();
		$row = $this->bind_result_array($stmt);

		if(!$stmt->error)
		{
			$counter = 0;
			while($stmt->fetch())
			{
				$messages[$counter] = $this->getCopy($row);
				$counter++;
			}
			$stmt->close();
			return $messages;
		}
		else
		{
			return NULL;
		}
	}

	//Send message/feedback
	public function send_message($sender_name, $sender_email, $message)
	{
		$stmt = $this->conn->prepare("INSERT INTO messages (sender_name, sender_email, sender_msg, msg_date, msg_checked) VALUES (?,?,?,NOW(),0)");
		$stmt->bind_param("sss", $sender_name, $sender_email, $message);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}

	//Check message status i.e. if read or not
	public function check_msg_status($msg_checked)
	{
		switch($msg_checked)
		{
			case 0:
				return "Unread";
				break;
			case 1:
				return "Read";
				break;
		}
	}	
	
	//change message status
	public function change_msg_status($msg_id, $mark_id)
	{
		$stmt = $this->conn->prepare("UPDATE messages SET msg_checked = ? WHERE msg_id = ?");
		$stmt->bind_param("ii", $mark_id, $msg_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}

	//Delete message
	public function delete_message($msg_id)
	{
		$stmt = $this->conn->prepare("DELETE FROM messages WHERE msg_id = ?");
		$stmt->bind_param("i", $msg_id);
		$stmt->execute();
		$num_affected_rows = $stmt->affected_rows;
		$stmt->close();
		return $num_affected_rows > 0;
	}
	//----Messages functions----//
}

?>