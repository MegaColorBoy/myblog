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
		$stmt = $this->conn->prepare("UPDATE users SET username = ?, name = ?, email = ? WHERE user_id = ?");
		$stmt->bind_param("sssi", $username, $name, $email, $user_id);
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
		return $num_affected_rows;
	}

	//----Admin-User Functions----//

	//----Blogpost functions----//
	
	//----Blogpost functions----//

	//----Categories functions----//

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
	
	//----Subscriber functions----//

	//----Images functions----//

	//----Images functions----//

	//----Comments functions----//

	//----Comments functions----//

	//----Messages functions----//

	//----Messages functions----//
}

?>