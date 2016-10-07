<?php
//Handles all functions for the blog page
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
	//----Utility Functions----//

	//----Blogpost functions----//
	//Get all posts, now display categories as well
	//Display all posts in desc order
	public function get_all_posts()
	{
		$posts = array();
		$stmt = $this->conn->prepare("SELECT blog_posts.*, categories.cat_id, categories.cat_title AS cat_title FROM blog_posts 
		 LEFT JOIN bp_cats ON bp_cats.bp_id = blog_posts.bp_id 
		 LEFT JOIN categories ON bp_cats.cat_id = categories.cat_id ORDER BY bp_date DESC");

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

	//Get post by id
	public function get_post_by_id($bp_id)
	{
		$stmt = $this->conn->prepare("SELECT blog_posts.*, categories.cat_id, categories.cat_title AS cat_title FROM blog_posts 
		 LEFT JOIN bp_cats ON bp_cats.bp_id = blog_posts.bp_id
		 LEFT JOIN categories ON bp_cats.cat_id = categories.cat_id 
		 WHERE blog_posts.bp_id = ?");

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

	//Get post by post slug -- same as the function above but for friendly SEO URLs 
	public function get_post_by_slug($bp_slug)
	{
		$stmt = $this->conn->prepare("SELECT blog_posts.*, categories.cat_id, categories.cat_title AS cat_title FROM blog_posts
			LEFT JOIN bp_cats ON bp_cats.bp_id = blog_posts.bp_id
			LEFT JOIN categories ON bp_cats.cat_id = categories.cat_id
			WHERE blog_posts.bp_slug = ?");
		$stmt->bind_param("s", $bp_slug);
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
				$stmt->close();
				return $post;
			}
		}
		else
		{
			return NULL;
		}
	}

	//Get all posts by category
	public function get_all_posts_by_category($cat_id)
	{
		$stmt = $this->conn->prepare("SELECT blog_posts.*, categories.cat_id, categories.cat_title AS cat_title FROM blog_posts 
		 LEFT JOIN bp_cats ON bp_cats.bp_id = blog_posts.bp_id 
		 LEFT JOIN categories ON bp_cats.cat_id = categories.cat_id WHERE categories.cat_id = ?");

		$stmt->bind_param("i", $cat_id);
		if($stmt->execute())
		{
			$posts = array();
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
		else
		{
			return NULL;
		}
		
	}

	//Get all related posts by category
	public function get_all_related_posts($cat_title)
	{
		$stmt = $this->conn->prepare("SELECT blog_posts.*, categories.cat_id, categories.cat_title AS cat_title FROM blog_posts
		 LEFT JOIN bp_cats ON bp_cats.bp_id = blog_posts.bp_id LEFT JOIN categories ON bp_cats.cat_id = categories.cat_id 
		 WHERE categories.cat_title = ? ORDER BY blog_posts.bp_date DESC LIMIT 5");

		$stmt->bind_param("s", $cat_title);
		if($stmt->execute())
		{
			$posts = array();
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

	//----Blogpost functions----//

	//----Links functions----//
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

	//----Categories functions----//
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

	//----Comments functions----//
	public function get_all_comments_by_bp_id($bp_id)
	{
		$comments = array();
		$stmt = $this->conn->prepare("SELECT * FROM comments WHERE bp_id = ?");
		$stmt->bind_param("i", $bp_id);
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

	//Add comment
	public function add_comment($bp_id, $cmt_username, $cmt_email, $cmt_content)
	{
		//If there's no name, then the name would be "guest"
		if(strlen($cmt_username) <= '1')
		{
			$cmt_username = "Guest";
		}
		$stmt = $this->conn->prepare("INSERT INTO comments (bp_id, cmt_username, cmt_email, cmt_content, posted_at) VALUES (?,?,?,?,NOW())");
		$stmt->bind_param("isss", $bp_id, $cmt_username, $cmt_email, $cmt_content);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}
	//----Comments functions----//
}
?>