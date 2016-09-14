<?php
//Mail class

class MAIL
{
	//variables
	private $to_user;
	private $message;
	private $subject;

	//constructor
	function __construct(){}

	public function set_to_user($to_user)
	{
		$this->to_user = $to_user;
	}

	public function set_message($message)
	{
		$this->message = $message;
	}

	public function set_subject($subject)
	{
		$this->subject = $subject;
	}

	//TODO: NEED TO COMPLETE ALL THESE FUNCTIONS
	//TODO: CREATE MAIL TEMPLATE CLASS
	//Types of mail
	public function send_thank_you_mail()
	{

	}

	public function send_thank_you_feedback_mail()
	{

	}

	public function send_reset_pass_mail($username, $password)
	{

	}

	public function send_reply_mail($username, $message)
	{

	}
}
?>