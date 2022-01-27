<?php 
require_once("include/lib.inc.php");
session_start();
require_once('include/class.phpmailer.php');

if (!empty($_POST)){
	if (isset($_SESSION['correct']) && $_SESSION['correct'] ) {
		$types = $_POST["types"];
		$name = $_POST["name"];
		$email = $_POST["email"];
		$ph_no = $_POST["ph_no"];
		$mob_no= $ph_no;
		if(isset($_POST["mob_no"]) && $_POST["mob_no"]!=''){
			$mob_no =  $_POST["mob_no"];
		}		
		$day_no= $ph_no;
		if(isset($_POST["day_no"]) && $_POST["day_no"]!=''){
			$day_no =  $_POST["day_no"];
		}		
		$occ_mail= 'No';
		if(isset($_POST["occ_mail"]) && $_POST["occ_mail"]!=''){
			$occ_mail =  "Yes";
		}		
		$message = $_POST["message"];
		$time = time();		
		$TimeRegister = date('H:i:s');
		$DateRegister = date('Y-m-d');
		$company='';
		if(isset($_POST["company"])){
			$notes_arr['Company'] =  addslashes($_POST["company"]);
			$company= $_POST["company"];
		}
		$notes_arr['Message'] =  addslashes($message);		
		if($_POST["form_type"]=='enquiry'){	
			$query_enq="INSERT INTO `web_enquiries` (
			`SiteID`, `Created`,`Modified`,`Code`,`Title`,`Firstname`,`Middlename`,`Lastname`,
			`Telephone`,`Fax`,`Email`,`CustomerID`,`zDeleted`,`zStatus`,`zPassword`,
			`zCookie`,`DateRegistered`,`TimeRegistered`,`Name`,`Telephone_daytime`,
			`Mobile`,`JobTitle`,`GUID`,`Site_GUID`,`Customer_GUID`,`WYSIWYG_Editor_type`,
			`Notice_period`,`Notes`,`External_ID`,`StatusAlerts`,`Sync_Modified`,`Email_Preferences`,
			`Rank`, `enquiry_type`
			)
			VALUES (
			'".SITE_ID."', '$time', '$time', '$email', '', '', '', '',
			'$ph_no', '', '$email', '0', '0', 'ACTIVE', '', 
			'', '$DateRegister', '$TimeRegister', '$name', 
			'$mob_no', '', '', UUID(), '".SITE_GUID."', '', '0', 	
			'', '".json_encode($notes_arr)."', '', '0', '0', '0', '', '$types'
			)";
			$insert=$db->query($query_enq);
		}
		$job_str='';
		$admin_job_str='';
		$admin_job_title=array();
		$consultantEmails=array();
		$job_count=0;
		if($types == 'Looking for work'){		
			$db->query( "INSERT INTO jobapplications (GUID, SiteID, Name, Email, TelephoneHome, TelephoneDay, TelephoneMobile, Comments,HomePostcode,SalaryExpectations, created, modified,SourceSite,Free_Text_Search,CV_File_Content,Rank,SourceType) 
			VALUES (UUID(), '".SITE_ID."', '$name', '$email', '$ph_no', '$day_no', '$mob_no', '$message','','' ,'$time', '$time', '', '', '', '', '')");
			$app_id= $db->insert_id;	
			$app_guid = $db->get_var("select GUID from jobapplications where ID='".$app_id."'");			
			if(!empty($_FILES) && $_FILES['file']['size'] > 0)
			{
				$fileName = str_replace(' ','',$_FILES['file']['name']);
				$tmpName  = $_FILES['file']['tmp_name'];
				$fileSize = $_FILES['file']['size'];
				$fileType = $_FILES['file']['type'];				
				$fp = fopen($tmpName, 'r');
				$content = fread($fp, filesize($tmpName));
				$content = addslashes($content);
				fclose($fp);
				if(!get_magic_quotes_gpc())
				{
					$fileName = addslashes($fileName);
				}
				$db->query("update jobapplications set zCV='$content', CVFileType='$fileType', CVFileName='$fileName' where ID='$app_id'");
			}
			if($_POST["form_type"]=='apply' && isset($_COOKIE['user_selection_documents_jobapplist']) && $_COOKIE['user_selection_documents_jobapplist']!=''){
				$jobs_in_cookies= explode("$",$_COOKIE['user_selection_documents_jobapplist']); 
				$jobs_in_cookies= implode(",", $jobs_in_cookies);
				$Query = "SELECT * FROM `documents` WHERE Id in (".$jobs_in_cookies.") AND ( SiteID=".SITE_ID." ) and PublishCode=1 AND Type='job' ORDER BY Published_Timestamp DESC";
				$db->query('SET NAMES utf8');
				if($dbResultsData = $db->get_results($Query)) {
					$admin_job_str='<p>Jobs applied for:</p>';				
					foreach($dbResultsData as $res_data){
						$job_str.='<p>Job ref: ';
						if($res_data->Reference!=''){
							$job_str.=$res_data->Reference.', ';
						}
						$job_str.='<a href="'.SITE_PATH.'/'.$res_data->Code.'.html" target="_blank">'.SITE_PATH.'/'.$res_data->Code.'.html</a></p>';					
						$job_title=$res_data->Document;						
						if($res_data->Reference!=''){
							$admin_job_str.=$res_data->Reference.' &ndash;';
						}
						if($res_data->OwnerUserID>0){
							if($userInfo = $db->get_row("Select * from wi_users where ID='$res_data->OwnerUserID'")){
								$consultantEmails[] = $userInfo->email;
							}
						}elseif($res_data->UserID>0){
							if($userInfo = $db->get_row("Select * from wi_users where ID='$res_data->UserID'")) {
								$consultantEmails[] =$userInfo->email;
							}
						}
						$admin_job_str.=' '.$job_title.' &ndash; <a href="'.SITE_PATH.'/'.$res_data->Code.'.html" target="_blank">'.SITE_PATH.'/'.$res_data->Code.'.html</a><br/>';
						$admin_job_title[]=$job_title;
						$job_guid=$res_data->GUID;				
						$db->query("insert into jobsapplicants(SiteID, Created, Modified, GUID, Job_GUID, JobApplication_GUID) values('".SITE_ID."', '$time', '$time', UUID(), '$job_guid', '$app_guid')");				
						$job_count++;
					}
				}
			}			
			if(isset($_COOKIE['user_selection_documents_jobapplist']) && $_COOKIE['user_selection_documents_jobapplist']!='') {			
				$jobs_in_cookies= explode("$",$_COOKIE['user_selection_documents_jobapplist']); 
				setcookie('user_selection_documents_jobapplist', $_COOKIE['user_selection_documents_jobapplist'], time() - 3600);
				$jobs_in_cookies= implode(",", $jobs_in_cookies);
				$Query = "SELECT * FROM `documents` WHERE ID in (".$jobs_in_cookies.") AND ( SiteID=".SITE_ID." ) AND Type<>'job' ORDER BY Published_Timestamp DESC";
				$db->query('SET NAMES utf8');
				$jobs_in_cookies=array();
				if($dbResultsData = $db->get_results($Query)) {
					foreach($dbResultsData as $res_data){
						$jobs_in_cookies[]=$res_data->ID;						
					}
				}
				setcookie('user_selection_documents_jobapplist', implode("$", $jobs_in_cookies), time()+60*60*24*366);
			}				
			$candidate_sub='Job Application Confirmation - Marshall Harber';
			$candidate_msg='<p>Hi '.$name.'</p>
			<p>This is an automated response to thank you for applying for ';
			if($job_count>0){ 
				$candidate_msg.=' the following job(s).</p>'.$job_str;
			}
			else{
				$candidate_msg.=' job.</p>'; 
			}
			$tokenEmailContentStr = __token_getValue($db, 'candidate-email-content'); 
			if(isset($tokenEmailContentStr) && $tokenEmailContentStr!="" ){ 
				$candidate_msg.= $tokenEmailContentStr; 
			}else{
			$candidate_msg.='<p>This is an automated response to thank you for applying for work finding services on our website.</p>
			<p>Your application(s) will now be considered. Please note that the agency has stringent registration requirements for new applicants and full details of these can be found by clicking <a href="'.SITE_PATH.'/candidates.html">here</a></p>
			<p>If your application is successful, we will contact you for further information or to discuss your application in greater detail. If you don\'t hear from us within the next two weeks then unfortunately, on this occasion, your application has been unsuccessful. We do not store personal data or CVs for unregistered applicants and these details will be automatically and securely deleted in accordance with current data protection laws.</p>
			<p>Please take a moment to read our Privacy Notice for applicants and candidates of the agency. You can click <a href="'.SITE_PATH.'/job-board.php" target="_blank">'.SITE_PATH.'/privacy-policy.html</a> to view this.</p>
			<p>Please continue to check the available jobs we have using the following link as we review and update the website frequently.</p>
			<p><a href="'.SITE_PATH.'/job-board.php" target="_blank">'.SITE_PATH.'/job-board.php</a></p>
			<p>In addition, we welcome applications from any of your friends / acquaintances with similar skills. Please keep us up to date with your employment / job seeking status.</p>
			<p>Thanks again from the Marshall Harber Recruitment Team.</p>';
			}
			$admin_sub='Web Application for Job';
			$admin_msg='<p>We have just received the following application from the <a href="'.SITE_PATH.'" target="_blank">'.SITE_PATH.'</a> job board:</p>
			<p>Name: '.$name.'<br/>Email Address: <a href="mailto:'.$email.'" target="_blank">'.$email.'</a>';
			if($ph_no!=''){ $admin_msg.= ' <br/>Home Telephone: '.$ph_no; }
			if($day_no!=''){ $admin_msg.= ' <br/>Daytime Telephone: '.$day_no; }
			if($mob_no!=''){ $admin_msg.= '<br/>Mobile: '.$mob_no; }
			$admin_msg.='<br/>Message: '.$message;
			$admin_msg.='</p>';			
			if(!empty($_FILES) && $_FILES['file']['size'] > 0){
				$admin_msg.='<p>Please find attached my CV for you to consider me for the ';
			}
			else{
				$admin_msg.='<p>Please consider me for the ';
			}
			if(count($admin_job_title)>0) {
				$admin_msg.=' vacant position(s) of '.implode(', ',$admin_job_title).' as advertised on your website.';
			}
			else{
				$admin_msg.=' jobs suitable to my profile.';
			}
			$admin_msg.=' Please do not hesitate to contact me if you require further information.</p>';
			$admin_msg.='<p>Send occasional emails: '.$occ_mail;
			$admin_msg.='</p>';
			$admin_msg.=$admin_job_str;	
		}
		else{
			$db->query("insert into  jobbriefs (GUID, SiteID, Created, Modified, Name, Tel_daytime, Mobile, Email, Notes,  Server_Number, Site_GUID ) values (UUID(),'".SITE_ID."', '$time', '$time', '$name', '$ph_no', '$mob_no', '$email', '$message', '".SERVER_NUMBER."', '".SITE_GUID."' )");			
			$admin_sub='Enquiry from Marshall Harber';
			$admin_msg='<p>We have just received the following enquiry from the <a href="'.SITE_PATH.'" target="_blank">'.SITE_PATH.'</a> job board:</p>
			<p>Name: '.$name.' <br/>Email Address: <a href="mailto:'.$email.'" target="_blank">'.$email.'</a><br/>Person is: '.$types.' <br/>';
			if($company!=''){ $admin_msg.= 'Company: '.$company.'<br/>'; }
			if($ph_no!=''){ $admin_msg.= 'Telephone: '.$ph_no.'<br/>'; }
			if($mob_no!=''){ $admin_msg.= 'Mobile: '.$mob_no.'<br/>'; }
			$admin_msg.='Message: '.$message.' </p>';		
		}
		require_once("include/mailer-details.php");			
		//mail to admin
		$debugModeBool = false;		
		try {		
			if(!empty($_FILES) && $_FILES['file']['size'] > 0){
				$mail->AddAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);
			}	
			
			$mail->Subject = $admin_sub;
			$mail->AddReplyTo($email,$name);
			$mail->AddAddress(ADMIN_MAIL,SITE_NAME);
						
			if(isset($consultantEmails) && count($consultantEmails)>0) {
				$consultantEmails=array_unique($consultantEmails);
				if(SERVER=='DEV'){
					$admin_msg.= '<p>This email will also go to following addresses: '.implode(', ', $consultantEmails).'</p>';
				}
				if(SERVER=='LIVE'){	
					foreach($consultantEmails as $consultantEmail){					
						$mail->AddAddress($consultantEmail);
					}
				}
			}
			
			$mail->AddCC(CC_MAIL_1);
			//$mail->AddCC(CC_MAIL_2);
			$mail->SetFrom(ADMIN_FROM_MAIL,SITE_NAME);		
			$mail_body=$admin_msg;	
			$mail->MsgHTML($mail_body);		
			$mail->Send();
			$mail->ClearAddresses();
		}
		catch (phpmailerException $e) {
			$error= $e->errorMessage(); 
		}
		catch (Exception $e) {
			$error= $e->getMessage(); 
		}		
		if($types == 'Looking for work'){		
			try {
				$mail->clearAttachments();
				$mail->Subject = $candidate_sub;
				$mail->AddReplyTo(ADMIN_MAIL,SITE_NAME);
				$mail->AddAddress($email,$name);
				$mail->AddCC(CC_MAIL_1);
				//$mail->AddCC(CC_MAIL_2);
				$mail->SetFrom(ADMIN_FROM_MAIL,SITE_NAME);				
				$mail_body=$candidate_msg;
				$mail->MsgHTML($mail_body);				
				$mail->Send();
				$mail->ClearAddresses();
			}
			catch (phpmailerException $e) {
				$error= $e->errorMessage(); 
			}
			catch (Exception $e){
				$error= $e->getMessage(); 			
			}
			$success= "Hi ".$name.", Your application has been submitted successfully and an email has been sent to you. We will get in touch with you soon. Till then you can search and apply for more suitable jobs on our website";
		}
		else{
			$success= "Hi ".$name.", Your enquiry has been submitted successfully. We will get in touch with you soon. Till then you can continue browsing our website";
		}
	}
	else{
		$error= "Incorrect answer. Please try again!!!";
	}
}
else{
	$error= "Error processing request!!!";
}
?>
