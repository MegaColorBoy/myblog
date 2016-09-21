<?php
//Connection class
class DB_CONNECT
{
	private $conn;

	function __construct(){}

	//connect function
	function connect()
	{
		include_once('config.php');
		$this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if(mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL DB: " . mysqli_connect_error();
		}

		return $this->conn;
	}
}
?>