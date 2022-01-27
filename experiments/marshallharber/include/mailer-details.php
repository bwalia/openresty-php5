<?php
$mail = new PHPMailer(true); 		// the true param means it will throw exceptions on errors, which we need to catch
$mail->Charset = 'utf-8';
$mail->IsSMTP();                    // Set mailer to use SMTP

$mail->SMTPSecure = "ssl";          // sets the prefix to the servier
$mail->Host = MAIL_HOST;           	// Specify main and backup server
$mail->SMTPAuth = true;             // Enable SMTP authentication
$mail->Username = MAIL_USERNAME;    // SMTP username
$mail->Password = MAIL_PASSWORD;    // SMTP password
$mail->Port       = 465;            // set the SMTP port for the GMAIL server
?>
