<?php

error_reporting(E_ALL);
//error_reporting(E_STRICT);

date_default_timezone_set('Europe/London');
//require_once('include/class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";


$body             = "Hello World!";
    
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
$mail->Host       = "ssl://smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
#$mail->Username = 'AKIAIA4S7XHG3ISFFF2A';
#$mail->Password = 'AoG7HzuRd1IEsCdZDL4sVHJL5nQGIMJ60iOjQS68Kg7z';

$mail->Username = 'tenthmatrix.mailer@gmail.com';
$mail->Password = 'mpYYd-Gcm-cH4-d5h';

			$mail->Subject = "Testing";
			$mail->AddReplyTo($email,$name);
			$mail->AddAddress("bwalia@tenthmatrix.co.uk","Admin");
			$mail->AddCC("jobshout421@gmail.com");
#$mail->AddCC("info@marshallharber.com");
			
//			$mail->SetFrom("bwalia@tenthmatrix.co.uk","Admin From");		
//$mail->SetFrom("noreply@tenthmatrix.co.uk","Marshall Harber");
$mail->SetFrom("noreply@tenthmatrix.co.uk","Marshall Harber");



$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>