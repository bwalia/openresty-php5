<?php 
require_once("include/lib.inc.php");
require_once("include/paging.php"); 
require_once("include/class.phpmailer.php");

function NewGuid() { 
	$s = strtoupper(md5(uniqid(rand(),true))); 
	$guidText = 
		substr($s,0,8) . '-' . 
		substr($s,8,4) . '-' . 
		substr($s,12,4). '-' . 
		substr($s,16,4). '-' . 
		substr($s,20); 
	return $guidText;
}
if(isset($_POST['submit'])){
	if(!$_POST['name']){ $err_msg = "* Please enter your name"; }
	elseif(!$_POST['email']){ $err_msg = "* Please enter your email"; }
	elseif(!$_POST['home_tel'] && !$_POST['daytime_telephone'] && !$_POST['mobile']){ $err_msg = "* Please enter at least one contact number"; }
	elseif($_FILES['uploadedCV']['size'] <= 0){ $err_msg = "* Please upload your CV"; }					
	
	else{
	$GUID = $_POST["GUID"];
	$Name = $_POST["name"];
	$email = $_POST["email"];
	$TelephoneHome = $_POST["home_tel"];
	$TelephoneDay = $_POST["daytime_telephone"];
	$TelephoneMobile = $_POST["mobile"];
	$occ_emails=0;
	if(isset($_POST["occ_emails"])) {
		$occ_emails = $_POST["occ_emails"];
	}

	$time = time();
	

	$Query="INSERT INTO jobapplications (GUID, SiteID, Name, Email, TelephoneHome,TelephoneDay, TelephoneMobile,HomePostcode,SalaryExpectations, created, modified,SourceSite,Free_Text_Search,CV_File_Content,Rank,SourceType) 
	VALUES ('$GUID', '".SITE_ID."', '$Name', '$email', '$TelephoneHome','$TelephoneDay','$TelephoneMobile',0,0, '$time', '$time', '', '', '', '', '')";
	$db->query('SET NAMES utf8');
	$insert=$db->query( $Query );
	//$db->debug();
	if($_FILES['uploadedCV']['size'] > 0)
	{
		$fileName = $_FILES['uploadedCV']['name'];
		$tmpName  = $_FILES['uploadedCV']['tmp_name'];
		$fileSize = $_FILES['uploadedCV']['size'];
		$fileType = $_FILES['uploadedCV']['type'];

		$fp = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);
		if(!get_magic_quotes_gpc())
		{
			$fileName = addslashes($fileName);
		}
		
		$update=$db->query("update jobapplications set zCV='$content', CVFileType='$fileType', CVFileName='$fileName' where GUID='$GUID'");
		
	}
	
	$job_str='';
	$admin_job_str='';
	$admin_job_title=array();
	$consultantEmails=array();
	if(isset($_COOKIE['user_selection_documents_jobapplist']) && $_COOKIE['user_selection_documents_jobapplist']!=''){ 
			$jobs_in_cookies= explode("$",$_COOKIE['user_selection_documents_jobapplist']); 
			$jobs_in_cookies= implode(",", $jobs_in_cookies);
			$Query = "SELECT * FROM `documents` WHERE Id in (".$jobs_in_cookies.") AND ( SiteID=".SITE_ID." ) and PublishCode=1 AND Type='job' ORDER BY Published_Timestamp DESC";
			$db->query('SET NAMES utf8');
			if($dbResultsData = $db->get_results($Query)) {
				$job_count=0;

				$admin_job_str='<p>Jobs applied for:</p>';
				
				foreach($dbResultsData as $res_data){
					$job_str.='<p>Job ref: ';
					if($res_data->Reference!=''){
						$job_str.=$res_data->Reference.', ';
					}
					$job_str.='<a href="'.SITE_PATH.'/'.$res_data->Code.'.html" target="_blank">'.SITE_PATH.'/'.$res_data->Code.'.html</a></p>';
										
					$job_title=$res_data->Document;
					
					if($res_data->Reference!=''){
						$admin_job_str.='<br>'.$res_data->Reference.' &ndash;';
					}
					if($res_data->OwnerUserID>0){
						if($userInfo = $db->get_row("Select * from users where ID='$res_data->OwnerUserID'")){
							  $consultantEmails[] = $userInfo->Code;
						}
					}
					elseif($res_data->UserID>0){
						if($userInfo = $db->get_row("Select * from users where ID='$res_data->UserID'")) {
							  $consultantEmails[] =$userInfo->Code;
						}
					}
					$admin_job_str.=' '.$job_title.' &ndash; <a href="'.SITE_PATH.'/'.$res_data->Code.'.html" target="_blank">'.SITE_PATH.'/'.$res_data->Code.'.html</a></p>';
					$admin_job_title[]=$job_title;
					$job_guid=$res_data->GUID;
					$apply_guid=NewGuid();
					
					$db->query("insert into jobsapplicants(SiteID, Created, Modified, GUID, Job_GUID, JobApplication_GUID) values('".SITE_ID."', '$time', '$time', '$apply_guid', '$job_guid', '$GUID')");
					
					$job_count++;
				}
			}
			}
	if($insert)	{
	
	$succ_msg= "Hi ".$Name.", Your CV has been submitted successfully.";
	
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
				$candidate_msg='<p>Hi '.$Name.'</p>
<p>This is an automated response to thank you for applying for work finding services on our website.</p><p>'.$job_str.'</p>
<p>Your application(s) will now be considered. Please note that the agency has stringent registration requirements for new applicants and full details of these can be found by clicking <a href="'.SITE_PATH.'/candidates.html">here</a></p>
<p>If your application is successful, we will contact you for further information or to discuss your application in greater detail. If you don\'t hear from us within the next two weeks then unfortunately, on this occasion, your application has been unsuccessful. We do not store personal data or CVs for unregistered applicants and these details will be automatically and securely deleted in accordance with current data protection laws.</p>
<p>Please take a moment to read our Privacy Notice for applicants and candidates of the agency. You can click <a href="'.SITE_PATH.'/privacy-policy.html">here</a> to view this.</p>
<p>Please continue to check the available jobs we have using the following link as we review and update the website frequently.</p>
<p><a href="'.SITE_PATH.'/job-board.php" target="_blank">'.SITE_PATH.'/job-board.php</a></p>
<p>In addition, we welcome applications from any of your friends / acquaintances with similar skills. Please keep us up to date with your employment / job seeking status.</p>
<p>Thanks again from the Marshall Harber Recruitment Team.</p>';
				
				$admin_sub='Web Application with CV';
				$admin_msg='<p>We have just received the following application from the <a href="'.SITE_PATH.'" target="_blank">'.SITE_PATH.'</a> job board:</p>
<p>Name: '.$Name.'<br/>Email Address: <a href="mailto:'.$email.'" target="_blank">'.$email.'</a>';
if($TelephoneHome!=''){ $admin_msg.= ' <br/>Home Telephone: '.$TelephoneHome; }
if($TelephoneDay!=''){ $admin_msg.= ' <br/>Daytime Telephone: '.$TelephoneDay; }
if($TelephoneMobile!=''){ $admin_msg.= '<br/>Mobile: '.$TelephoneMobile; }
$admin_msg.='</p>';
$admin_msg.='<p>Please find attached my CV for you to consider me for the ';
if(count($admin_job_title)>0) {
$admin_msg.=' vacant position(s) of '.implode(', ',$admin_job_title).' as advertised on your website.';
}
else{
$admin_msg.=' jobs suitable to my profile.';
}
$admin_msg.=' Please do not hesitate to contact me if you require further information.</p>';
$admin_msg.='<p>I am happy to receive occasional emails on vacanices that may be of interest: ';
if($occ_emails==0){ $admin_msg.='No'; }
else{ $admin_msg.='Yes'; }
$admin_msg.='</p>';
$admin_msg.=$admin_job_str;

			
			$mail = new PHPMailer(true); 		// the true param means it will throw exceptions on errors, which we need to catch
			$mail->Charset = 'utf-8';
			$mail->IsSMTP();                    // Set mailer to use SMTP
			$mail->Host = MAIL_HOST;  // Specify main and backup server
			$mail->SMTPAuth = true;             // Enable SMTP authentication
			$mail->Username = MAIL_USERNAME;    // SMTP username
			$mail->Password = MAIL_PASSWORD;     // SMTP password
			
			//mail to user
			$debugModeBool = false;
			try {
				$mail->Subject = $candidate_sub;
				$mail->AddAddress($email,$Name);
				$mail->SetFrom(ADMIN_FROM_MAIL,'Marshall Harber');
				
				$mail_body=$candidate_msg;
				$mail->MsgHTML($mail_body);
			
				$mail->Send();
				$mail->ClearAddresses();

			}
			catch (phpmailerException $e) {
				$err_msg= $e->errorMessage(); 
			}
			catch (Exception $e) {
				$err_msg= $e->getMessage(); 

			}
			//mail to admin
			try {
				if (isset($_FILES['uploadedCV']) && $_FILES['uploadedCV']['size']> 0) {
					$mail->AddAttachment($_FILES['uploadedCV']['tmp_name'], $_FILES['uploadedCV']['name']);
				}

				$mail->Subject = $admin_sub;
				$mail->AddReplyTo($email,$Name);
				$mail->AddAddress(ADMIN_MAIL,'Marshall Harber');
				if(isset($consultantEmails) && count($consultantEmails)>0) {
					$consultantEmails=array_unique($consultantEmails);
					foreach($consultantEmails as $consultantEmail){
						$mail->AddAddress($consultantEmail);
					}
				}
				$mail->AddCC(CC_MAIL);
				$mail->SetFrom($email,$Name);
				
				$mail_body=$admin_msg;
				$mail->MsgHTML($mail_body);
			
				$mail->Send();
				$mail->ClearAddresses();
			}
			catch (phpmailerException $e) {
				$err_msg= $e->errorMessage(); 
			}
			catch (Exception $e) {
				$err_msg= $e->getMessage(); 

			}
			unset($_POST['name']);
			unset($_POST['email']);
			unset($_POST['uploadedCV']);
			unset($_POST['home_tel']);
			unset($_POST['daytime_telephone']);
			unset($_POST['mobile']);
		}
	}
}		


include_once ("include/main-site-header.php"); ?>
<script src="js/cookies.js" type="text/javascript"></script>
<script src="js/jquery-1.9.0.js"></script>
<script src="js/jquery.validate.js"></script>
<script type="text/javascript">
$( document ).ready(function( ) {
	
	$.validator.addMethod("require_from_group", function (value, element, options) {
        var numberRequired = options[0];
        var selector = options[1];
        var fields = $(selector, element.form);
        var filled_fields = fields.filter(function () {
            // it's more clear to compare with empty string
            return $(this).val() != "";
        });
        var empty_fields = fields.not(filled_fields);
        // we will mark only first empty field as invalid
        if (filled_fields.length < numberRequired && empty_fields[0] == element) {
            return false;
        }
        return true;
        // {0} below is the 0th item in the options field
    });

	$("#mylist").validate({
		errorPlacement: function(error, element) {
		if (element.attr("name") == "home_tel" || element.attr("name") == "daytime_telephone" || element.attr("name") == "mobile")
       	 error.insertAfter("#home_tel");
    	else
        error.insertAfter(element);
		},
		groups: {
            names: "home_tel daytime_telephone mobile"
        },
		rules: {
			name: "required",
			home_tel: {
                require_from_group: [1, ".telephone"]
            },
			daytime_telephone: {
                require_from_group: [1, ".telephone"]
            },
			mobile: {
                require_from_group: [1, ".telephone"]
            },
			email: {
				required: true,
				email: true
			},
			
			uploadedCV:  "required",
			

		},
		messages: {
			name: "Enter your Name",
			home_tel: {
                require_from_group: "Enter at least one contact number"
            },
			daytime_telephone: {
                require_from_group: "Enter at least one contact number"
            },
			mobile: {
                require_from_group: "Enter at least one contact number"
            },
			email: {
				required: "Enter your Email address",
				email: "Enter a valid email address"
			},
			
			uploadedCV: "Please attach your CV",
			
			
		}
	});
});
</script>

<style>
#uploadedCV.error{
	margin-top:5px;
}
.required {
    color: #ff0000;
}
label.error {
    color: #ddcf75;
    font-style: italic;
    margin-left: 5px;
}

</style>


 
 
</head>
	<body>
		<!--start header-->
		<?php include_once ("include/header.php"); ?>
        <!--end header-->
		<div id="moreBorder"></div>
		<div id="content">
				<?php include_once('include/left-links.php'); ?>
				<div id="textColumn">
					<?php include_once('include/jobs-common-links.php'); ?>
				<div id="jobboard_jobs_list" style="padding-top:10px;">
				<?php
if(!isset($succ_msg) && isset($_COOKIE['user_selection_documents_jobapplist']) && $_COOKIE['user_selection_documents_jobapplist']!=''){ 
	$jobs_in_cookies= explode("$",$_COOKIE['user_selection_documents_jobapplist']); 
	$jobs_in_cookies= implode(",", $jobs_in_cookies);
	$query="SELECT * FROM `documents` WHERE Id in (".$jobs_in_cookies.") AND ( SiteID=".SITE_ID." ) and Status=1 AND Type='job' ORDER BY Published_Timestamp DESC";
	$limit = 10;
	$total_records=count($db->get_results($query));	  
  	if(isset($_REQUEST['page']))
		$pageNum = $_REQUEST['page'];	
 	else
	$pageNum = '';
	if($pageNum){$start = ($pageNum - 1) * $limit;} 	//first item to display on this page
	else{$start = 0;}		//if no page var is given, set start to 0
  
  	$startLim = $start;
  	$endLim = $limit;
  
    $query.= " LIMIT $startLim,$endLim ";
	
	$QueryString='';
    
	
	if($doc_cats = $db->get_results( $query )){
		 doPages($limit, 'register-now.php', $QueryString, $total_records, $startLim, $limit);
		$count=0;
		foreach($doc_cats as $doc_cat) {
			$count++;
?><br>

<h1><a class="jobboard_heading_link " href="<?php echo $doc_cat->Code; ?>.html" title="<?php echo $doc_cat->Document; ?>"><?php echo $doc_cat->Document; ?></a>&nbsp;

<a style="font-size:12px;" class="jobboard_add_remove_link submit-btn" href="javascript:_updateMyJobsList('addRemove<?php echo $count; ?>', <?php echo $doc_cat->ID; ?>, 'user_selection_documents_jobapplist');" id="addRemove<?php echo $count; ?>" title="Add this job to your list"></a>

</h1>
<?php if($doc_cat->FFAlpha80_4!='') { ?><b>Employer: <?php echo $doc_cat->FFAlpha80_4; ?></b><br /><?php } ?>
<?php if($doc_cat->FFAlpha80_2!='') { ?><b>Salary: <?php echo $doc_cat->FFAlpha80_2; ?></b><br /><?php } ?>
<?php if($doc_cat->Reference!='') { ?><b>Ref: <?php echo $doc_cat->Reference; ?></b><br /><?php } ?>

<p><?php if(strlen(strip_tags($doc_cat->Body))>200) { echo substr(strip_tags($doc_cat->Body),0,200).'&hellip;'; } else { echo substr(strip_tags($doc_cat->Body),0,200); } ?><a class="jobboard_heading_link" href="<?php echo $doc_cat->Code; ?>.html" title="<?php echo $doc_cat->Document; ?>">more</a></p>
<?php 
		}
	}
?>
<script type="text/javascript">
window.onload = function ()
{
<?php
$count=0;
foreach($doc_cats as $doc_cat) {
$count++;
?>
_updateMyJobsList('addRemove<?php echo $count; ?>', <?php echo $doc_cat->ID; ?>, 'user_selection_documents_jobapplist',false,true);
<?php
}
?>
}
</script>
<?php } else { ?>				
				<h1 style="padding-left:15%">No jobs found in your list!</h1>
<?php } ?>
				<?php
				if(isset($succ_msg) && $succ_msg!=''){				
				?>
				<div style="color:#fff;font-size:18px;padding-left:1%"><?php echo $succ_msg; ?></div>
				<?php } else if(isset($err_msg) && $err_msg!=''){ ?>
					<div style="color:#FF0000;font-size:18px;padding-left:15%"><?php echo $err_msg; ?></div>
				<?php } ?>
				<br />
				<!--<a style="color:red;font-size:16px;padding-left:20%" id="validation" name="validation" ></a>-->
				<div id="jobboard_application_form">
					
						<form name="mylist" id="mylist" method="post" action="" enctype="multipart/form-data">
							<input type="hidden" name="iws_sessionKey" VALUE="F5A3CE27-15E5-493E-83EC-68E8768DC8AB">
							<input type="hidden" value="<?php $GUID = NewGuid(); echo $GUID; ?>" name="GUID" id="GUID" >
							<table cellpadding="0" cellspacing="4" border="0">
							<tr>
								<td><label>Name <span class="required">*</span>:&nbsp;&nbsp;</label></td>
								<td><label><input type="text"  name="name" id="name" class="srchfield" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>"></label></td>
							</tr>
							<tr>
								<td><label>Email&nbsp;Address <span class="required">*</span>:&nbsp;&nbsp;</label></td>
								<td><label><input type="text" name="email" id="email" class="srchfield" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"></label></td>
							</tr>
							<tr>
								<td><label>Home&nbsp;Telephone:&nbsp;&nbsp;</label></td>
								<td><label><input type="text"  name="home_tel" id="home_tel" class="telephone srchfield" value="<?php if(isset($_POST['home_tel'])) echo $_POST['home_tel']; ?>"></label></td>
							</tr>
							<tr>
								<td><label>Daytime&nbsp;Telephone:&nbsp;&nbsp;</label></td>
								<td><label><input type="text" name="daytime_telephone" id="daytime_telephone" class="telephone srchfield" value="<?php if(isset($_POST['daytime_telephone'])) echo $_POST['daytime_telephone']; ?>"></label></td>
							</tr>
							<tr>
								<td><label>Mobile:&nbsp;&nbsp;</label></td>
								<td><label><input type="text" name="mobile" id="mobile" class="telephone srchfield" value="<?php if(isset($_POST['mobile'])) echo $_POST['mobile']; ?>"></label></td>
							</tr>
							<tr>
								<td><label>Attach&nbsp;CV <span class="required">*</span>:&nbsp;&nbsp;</label></td>
								<td><label><input type="file" name="uploadedCV" id="uploadedCV"></label></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><p><input type="checkbox" name="occ_emails" VALUE=1>&nbsp;I am happy to receive occasional emails <br>
on vacanices that may be of interest.</p></td>
							</tr>

							<tr><td colspan=2 align="right"><br />
								<p><input type="reset" class="submit-btn" value="Clear application form" name="Clear application form">&nbsp;&nbsp;<input type="submit" class="submit-btn" value="Send Application" name="submit" ></p>
							</td></tr>
</table>
						</form>
					
				</div>
				
				<p>&nbsp;</p>
			</div> 
		</div>
		<!--start footer-->
<?php include_once ("include/content-footer.php"); ?>
<!--end footer-->
<?php include_once ("include/page-tracker.php"); ?>

	</body>
</html>