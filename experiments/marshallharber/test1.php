<?php
phpinfo();
exit;
/**
* Simple example script using PHPMailer with exceptions enabled
* @package phpmailer
* @version $Id$
*/
require_once("include/lib.inc.php");
require_once('include/class.phpmailer.php');
require_once("include/mailer-details.php");		
echo "SET From : ".ADMIN_FROM_MAIL."<br>";

$mail->SMTPDebug  = 2;  
$email="balinder.walia@gmail.com";
$name="Balinder WALIA";
		
try {		
			
			$mail->Subject = "Testing";
			$mail->AddReplyTo($email,$name);
			$mail->AddAddress("bwalia@tenthmatrix.co.uk","Admin");
			
			$mail->SetFrom(ADMIN_FROM_MAIL,"Marshall Harber");		
			$mail_body="Hello World!";	
			$mail->MsgHTML($mail_body);		
			
            if($mail->Send()) {
  echo "Message sent!";
} else {
  
echo "Mailer Error: " . $mail->ErrorInfo;
}
		}
		catch (phpmailerException $e) {
			$error= $e->errorMessage(); 
 echo "Mailer Error: " . $mail->ErrorInfo;
		}
		catch (Exception $e) {
			$error= $e->getMessage(); 
 echo "Mailer Error: " . $mail->ErrorInfo;
		}		


?>