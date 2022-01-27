<?php 
require_once("include/lib.inc.php");

function __ipAddress(){
	//Just get the headers if we can or else use the SERVER global
	if ( function_exists( 'apache_request_headers' ) ) {
	$headers = apache_request_headers();
	} else {
	$headers = $_SERVER;
	}

	$pPT_ipAddrStr	= $_SERVER["REMOTE_ADDR"];
	$clientIPStr='';

	if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
		$clientIPStr = $headers['X-Forwarded-For'];
	}elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )) {
		$clientIPStr = $headers['HTTP_X_FORWARDED_FOR'];
	}elseif(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$arr_ip=explode(',', $_SERVER["HTTP_X_FORWARDED_FOR"]);
		$clientIPStr = $arr_ip[0];
	}else if(isset($_SERVER["HTTP_X_REAL_IP"])){
		$clientIPStr = $_SERVER["HTTP_X_REAL_IP"];
	}else if(isset($_SERVER['HTTP_CLIENT_IP'])){
		$clientIPStr = $_SERVER['HTTP_CLIENT_IP'];
	}else if(isset($_SERVER["HTTP_X_FORWARDED"])){
		$clientIPStr = $_SERVER["HTTP_X_FORWARDED"];
	}else if(isset($_SERVER["HTTP_FORWARDED_FOR"])){
		$clientIPStr = $_SERVER["HTTP_FORWARDED_FOR"];
	}else if(isset($_SERVER["HTTP_FORWARDED"])){
		$clientIPStr = $_SERVER["HTTP_FORWARDED"];
	}
	if( $clientIPStr != "") { $pPT_ipAddrStr=$clientIPStr; }

	
	$mail_ip_str='';
	if($pPT_ipAddrStr!=''){
		$mail_ip_str.=$pPT_ipAddrStr;
	}
	return $mail_ip_str;
}

require_once('include/class.phpmailer.php');

$res= array();
if (!empty($_POST)){
		$name=$_POST['name'];
		$email=$_POST['email'];
		$blogID=$_POST['blogID'];
		$blogUUID=$_POST['blogUUID'];
		$blogTitle=$_POST['blogTitle'];
		$comment=addslashes($_POST['comment']);
		$remoteIPStr = __ipAddress();
		$time=time();
		
		$site_uuid=$db->get_var("select GUID from sites where id='".SITE_ID."'");
		
		$db->query("insert into blog_comments(uuid, blog_id, blog_uuid, Name, email, comments, comment_by, ip_address, OrderNum, Created, Modified, site_uuid, Server_Number, Status) 
		values(UUID(), $blogID, '$blogUUID', '$name', '$email', '$comment', '','$remoteIPStr', 0, '$time', '$time', '$site_uuid', '".SERVER_NUMBER."', 0)");
		
		$comment_id= $db->insert_id;
		//$succ_msg= "Thanks your comment has been posted OK and will be visible soon!";	
		
		require_once("include/mailer-details.php");
		
		$debugModeBool = false;
		try {
			$mail->AddReplyTo($email,$name);
			$mail->AddAddress(ADMIN_MAIL,'Marshall Harber');
			$mail->AddCC(CC_MAIL);
			$mail->SetFrom($email,$name);			
			
			$mail->Subject = $name." has posted a comment";
			
			$message='<div style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:13;color:#333">'.$name.' has posted a comment for the <b>'.$blogTitle.'</b> blog:</div>';
			$message.="<br/><table border='0' cellpadding='5' cellspacing='0'>
			<tr><td style=\"font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:12px;color:#666\">Email</td><td style=\"font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:14px;color:#333\">".$email."</td></tr>";
			if($comment!=''){
				$message.="<tr><td style=\"font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:12px;color:#666\">Comment</td><td style=\"font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:14px;color:#333\">".$comment."</td></tr>";
			}
			$message.="<tr><td style=\"font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:12px;color:#666\">IP Address</td><td style=\"font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:14px;color:#333\">".$remoteIPStr."</td></tr>";
				
			$message.="<tr><td style=\"font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:14px;color:#666\"><a href=http://cdn.jobshout.com/blog.php?GUID=".$blogUUID."&cmnt#".$comment_id.">Click here to approve comment for this blog</a></td></tr>";
			$message.='</table>';
			
			$mail->MsgHTML($message);
			$mail->Send();
			$mail->ClearAddresses();
			$res['success']= "Hi ".$name.", Thanks your comment has been posted OK and will be visible soon!";
				
		}catch (phpmailerException $e) {
			$res['error']= "Error processing request!!!";
		}
		catch (Exception $e) {
			$res['error']= "Error processing request!!!";
		}

}
 echo json_encode($res); 
?>
