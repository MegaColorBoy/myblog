<?php
//Mail template class -- edit it later after deciding on a name for the blog !
class MAIL_TEMPLATES
{
    function __construct(){}
    
    public function basicTemplate($title, $header, $message, $url, $url_heading)
    {
        $text =
            '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta name="viewport" content="width=device-width" />
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <title>'.$title.'</title>
                <link href="http://www.megacolorboy.esy.es/css/template.css" media="all" rel="stylesheet" type="text/css" />
            </head>

            <body>

            <table class="body-wrap">
                <tr>
                    <td></td>
                    <td class="container" width="600">
                        <div class="content">
                            <table class="main" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="content-wrap">
                                        <table  cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>
                                                    <img class="img-responsive" src="http://www.megacolorboy.esy.es/img/banners/1.jpg"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="content-block">
                                                    <h3>'.$header.'</h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="content-block">
                                                '.$message.'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="content-block">
                                                    Regards,<br>MegaColorBoy
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="content-block aligncenter">
                                                    <a href="'.$url.'" class="btn-primary">'.$url_heading.'</a>
                                                </td>
                                            </tr>
                                          </table>
                                    </td>
                                </tr>
                            </table>
                            <div class="footer">
                                <table width="100%">
                                    <tr>
                                        <td class="aligncenter content-block">Follow me <a href="https://www.facebook.com/MegaColorBoy">@MegaColorBoy/a> on Facebook.</td>
                                    </tr>
                                </table>
                            </div></div>
                    </td>
                    <td></td>
                </tr>
            </table>

            </body>
            </html>';
        return $text;
    }
    
    //Thank you
    public function getThankYouTemplate()
    {
        $title = "Thank you - MegaColorBoy";
        $header = "Thank you for subscribing!";
        $message = "Hey there, Thank you for subscribing to my blog!<br>
                    Please look forward to new blog posts in the future.";
        $url = "http://megacolorboy.esy.es";
        $url_heading = "Visit my blog";
        
        $template = $this->basicTemplate($title, $header, $message, $url, $url_heading);
        return $template;
    }
    
    //Thank you for feedback
    public function getThankYouFeedbackTemplate()
    {
        $title = "Thank you for your feedback - MegaColorBoy";
        $header = "I got your feedback!";
        $message = "Thank you for your feedback. I will reply to you very shortly!<br>
                    Please look forward to new blog posts in the future.";
        $url = "http://megacolorboy.esy.es";
        $url_heading = "Visit my blog";
        
        $template = $this->basicTemplate($title, $header, $message, $url, $url_heading);
        return $template; 
    }
    
    //Reset Password
    public function getResetPasswordTemplate($username, $password)
    {
        $title = "Password Reset - MegaColorBoy";
        $header = "Your password has been reset!";
        $message = 'Dear '. $username .',<br>
                    Since you have forgotten your password, your password has been reset.<br>
                    This is your new password: ' . $password;
        $url = "http://megacolorboy.esy.es/admin";
        $url_heading = "Login to admin panel";
        
        $template = $this->basicTemplate($title, $header, $message, $url, $url_heading);
        return $template;  
    }
    
    //Reply Mail
    public function getReplyMailTemplate($username, $content)
    {
        $title = "Feedback reply - MegaColorBoy";
        $header = "I replied to your feedback!";
        $message = 'Dear '. $username .',<br>'.$content.'<br>';
        $url = "http://megacolorboy.esy.es";
        $url_heading = "Visit my blog";
        
        $template = $this->basicTemplate($title, $header, $message, $url, $url_heading);
        return $template; 
    }
    
}
?>