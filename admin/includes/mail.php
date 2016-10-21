<?php
//A simple PHP Mail class
class MAIL
{
	//variables
	private $to_user;
	private $message;
	private $subject;

	function __construct(){}

	//Setters
	//Set user
	public function set_to_user($to_user)
	{
		$this->to_user = $to_user;
	}

	//Set message
	public function set_message($message)
	{
		$this->message = $message;
	}

	//Set subject
	public function set_subject($subject)
	{
		$this->subject = $subject;
	}

	//Get headers
	public function get_headers()
	{
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html; charset=UTF-8" . "\r\n";
		$headers .= "From: MegaColorBoy <no-reply@megacolorboy.esy.es>". "\r\n";
		return $headers;
	}

	//Send mail based on type such as "Thank you"
	public function send_mail_v1($type)
	{
		include_once('includes/mail_templates.php');
		$template = new MAIL_TEMPLATES();

		$headers = $this->get_headers();

		switch($type)
		{
			case "thank_you_mail":
				$body = $template->getThankYouTemplate();
				break;

			case "thank_you_feedback":
				$body = $template->getThankYouFeedbackTemplate();
				break;
		}

		mail($this->to_user, $this->subject, $body, $headers);
	}

	//To send feedback to users or reset password mail
	public function send_mail_v2($type, $username, $message)
	{
		include_once('includes/mail_templates.php');
		$template = new MAIL_TEMPLATES();

		$headers = $this->get_headers();

		switch($type)
		{
			case "reply_message":
				$body = $template->getReplyMailTemplate($username, $message);
				break;
			case "reset_password":
				$body = $template->getResetPasswordTemplate($username, $message);
				break;
		}

		mail($this->to_user, $this->subject, $body, $headers);
	}

}
?>