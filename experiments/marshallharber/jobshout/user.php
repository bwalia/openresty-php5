<?php
require_once("include/lib.inc.php");



if(isset($_GET['uuid']) && $_GET['uuid']!='' && $_GET['uuid']!=$login_user_uuid){
	$query_chk="select count(*) as num from wi_users where uuid='".$_GET['uuid']."'";
	if(isset($_SESSION['site_id']) && $_SESSION['site_id']!='') {
		$query_chk.=" and SiteID in ('".$_SESSION['site_id']."') ";
	}
	$chk_num=$db->get_var($query_chk);
	if($chk_num==0){
		header("Location: user.php");
	}
}

	
				if(isset($_POST['submit']))
				{	
						$code = addslashes($_POST["code"]);
						$email = $_POST["email"];
						$site_id=$_POST["site_id"];
						
						$sites_guid=$db->get_var("select GUID from sites where id= '$site_id'");
						
						if(isset($_GET['uuid'])){
						$sql= $db->get_var("SELECT count(*) FROM wi_users WHERE code='$code' and uuid !='".$_GET['uuid']."'");
						}
						else {
						$sql= $db->get_var("SELECT count(*) FROM wi_users WHERE code='$code'");
						}
						
						
						if($sql != 0)
					{
						$msg_email = "This user name is already exist";
						}
						
						else {
						if(isset($_GET['uuid'])){
						
						$sql= $db->get_var("SELECT count(*) FROM wi_users WHERE email='$email' and uuid !='".$_GET['uuid']."'");
					}
					else {
						$sql= $db->get_var("SELECT count(*) FROM wi_users WHERE email='$email'");
						}
						if($sql != 0)
					{
						$msg_user = "This email address is already exist";
						} 
				 
						else
					{
					
		
					
		
				
					
					//$time= date("Y-m-d H:i:s");
					//$unix_timestamp= strtotime($time);
					
					
					$noti = '';
					if(isset ($_POST['notification']))
					{
						foreach($_POST['notification'] as $var)
						{
							if($noti=='')
							$noti.= $var;
							else
							$noti.= ','. $var;
							}
						}
						
					
					$code = addslashes($_POST["code"]);
					$firstname = addslashes($_POST["firstname"]);
					$lastname = addslashes($_POST["lastname"]);
					$gender = $_POST["gender"];
					$email = $_POST["email"];
					$access_rights= $_POST["access_rights"];
					//$modified = $_POST["modified"];
					$languages = $_POST["languages"];
					
					$signature = addslashes($_POST["signature"]);
					//$fullname = $_POST["fullname"];
					if(isset( $_POST["password"])) {
					$password = $_POST["password"];
					
					$encrypted_mypassword=md5($password);
					}
					$time = time();
					
					$insert=true; 
					$update=true; 
					$insert_site=true; 
					$update_pic=true;
					
					 if(isset($_GET['uuid'])){
					//echo "UPDATE wi_users SET code = '$code', firstname = '$firstname', lastname = '$lastname', gender = '$gender', email = '$email', modified = '$time', languages = '$languages', notifications_code = '$noti', signature = '$signature', password = '$encrypted_mypassword' where  uuid = '".$_GET['uuid']."'";
					$GUID= $_GET['uuid'];
					$update = $db->query("UPDATE wi_users SET SiteID='".$site_id."', code = '$code', firstname = '$firstname', lastname = '$lastname', gender = '$gender', email = '$email', modified = '$time', access_rights_code=$access_rights, languages = '$languages', notifications_code = '$noti', signature = '$signature',Site_GUID='".$sites_guid."' where  uuid = '".$_GET['uuid']."'");						
					// $db->debug();
					 
					 				
					 if($_FILES['fileinput']['size'] > 0)
								{
									$fileName = $_FILES['fileinput']['name'];
									$tmpName  = $_FILES['fileinput']['tmp_name'];
									$fileSize = $_FILES['fileinput']['size'];
									$fileType = $_FILES['fileinput']['type'];
		
									$fp = fopen($tmpName, 'r');
									$content = fread($fp, filesize($tmpName));
									$content = addslashes($content);
									fclose($fp);
									if(!get_magic_quotes_gpc())
									{
										$fileName = addslashes($fileName);
									}
									
									//echo "update wi_users set photo_avatar='$content' where uuid='$GUID'";
									$update_pic = $db->query("update wi_users set photo_avatar='$content', photo_type='$fileType' where uuid='".$_GET['uuid']."'");
									//$db->debug();
									
								}
					
		
		 
	}
		
		
			
				else {
				
				//echo "INSERT INTO wi_users (uuid, SiteID, code, password, firstname, lastname, gender, email, server, created, modified, languages, notifications_code, signature, fullname,photo_avatar,photo_type,access_rights_code,status)  VALUES ('$GUID','".SITE_ID."','$code','$encrypted_mypassword','$firstname','$lastname','$gender','$email','".SERVER_NUMBER."','$time','$time','$languages','$noti','$signature','','','','1','1')";
				//echo "INSERT INTO wi_users (uuid, SiteID, code, password, firstname, lastname, gender, email, server, created, modified, languages, notifications_code, signature, fullname,photo_avatar,photo_type,access_rights_code,status,Site_GUID)  VALUES ('$GUID','".$site_id."','$code','$encrypted_mypassword','$firstname','$lastname','$gender','$email','".SERVER_NUMBER."','$time','$time','$languages','$noti','$signature','','','','1','1','".$sites_guid."'";	
			$GUID=UniqueGuid('wi_users', 'uuid');				
			$insert = $db->query("INSERT INTO wi_users (uuid, SiteID, code, password, firstname, lastname, gender, email, server, created, modified, languages, notifications_code, signature, fullname,photo_avatar,photo_type,access_rights_code,status,Site_GUID)  VALUES ('$GUID','".$site_id."','$code','$encrypted_mypassword','$firstname','$lastname','$gender','$email','".SERVER_NUMBER."','$time','$time','$languages','$noti','$signature','','','','$access_rights','1','".$sites_guid."')");
			//$db->debug();
			
			if($_FILES['fileinput']['size'] > 0)
								{
									$fileName = $_FILES['fileinput']['name'];
									$tmpName  = $_FILES['fileinput']['tmp_name'];
									$fileSize = $_FILES['fileinput']['size'];
									$fileType = $_FILES['fileinput']['type'];
		
									$fp = fopen($tmpName, 'r');
									$content = fread($fp, filesize($tmpName));
									$content = addslashes($content);
									fclose($fp);
									if(!get_magic_quotes_gpc())
									{
										$fileName = addslashes($fileName);
									}
									//echo 'hi';
									//echo "update wi_users set photo_avatar='$content' where uuid='$GUID'";
									$update_pic = $db->query("update wi_users set photo_avatar='$content', photo_type='$fileType' where uuid='$GUID'");
									//$db->debug();
									//echo 'hello';
								}	
								
							}
			
			if($insert || $update)				
			$curr_site_guid=$db->get_var("select GUID from sites where id= '$site_id'");
			$chk=$db->query("select * from wi_user_sites where uuid_user='$GUID' and uuid_site='$curr_site_guid'");
			if(!$chk){
				$uuid=UniqueGuid('wi_user_sites', 'uuid');				
				$insert_site = $db->query("insert into wi_user_sites(uuid, uuid_user, uuid_site, created, modified, server) values('$uuid', '$GUID', '$curr_site_guid', '$time', '$time', 4)");
			}
			
							
							
			}
			}
			
			
			if(!isset($_GET['uuid']) && isset($insert) && $insert_site && $update_pic) {
		$_SESSION['ins_message'] = "Inserted successfully ";
	 	header("Location:users.php");
	 }
	 elseif(isset($_GET['uuid']) && isset($update) && $insert_site && $update_pic) {
	 	 $_SESSION['up_message'] = "Updated successfully";
	 }
			
			}
			
			if(isset($_POST['submit_pass']))
			{	
			
					$password = $_POST["password"];
					
					$encrypted_mypassword=md5($password);
					
				//echo "update wi_users set password = '$encrypted_mypassword' where  uuid = '".$_GET['uuid']."'";
				if($db->query("update wi_users set password = '$encrypted_mypassword' where  uuid = '".$_GET['uuid']."'")) {		
				$sec_pass = "Password changed successfully";
				
				}
				//$db->debug();
				
				}
			
			
if(isset($_GET['uuid'])){

	 $user3 = $db->get_row("SELECT uuid, SiteID, code, firstname, lastname, gender, email, modified, access_rights_code, languages, notifications_code, signature, fullname, password, photo_avatar, photo_type FROM wi_users where uuid = '".$_REQUEST['uuid']."'");
	 
	 $mime = $user3->photo_type;
	 $user_pic= $user3->photo_avatar;
if($mime!='' && $user_pic!='') {
$b64Src = "data:".$mime.";base64," . base64_encode($user_pic);
}
else{
$b64Src = "img/80x80.png";
}
	 //$db->debug();
	 
	 	$uuid=$user3->uuid;
		$site_id=$user3->SiteID;
		$code=$user3->code;
		$firstname=$user3->firstname;
		$lastname=$user3->lastname;
		$gender=$user3->gender;
		$email=$user3->email;
		$languages=$user3->languages;
		$notifications_code=$user3->notifications_code;
		$signature=$user3->signature;
		$password=$user3->password;
		$photo_avatar=$user3->photo_avatar;
		$photo_type=$user3->photo_type;
		$access_rights=$user3->access_rights_code;
		
		$user_sites=array();
		/*if($user3_sites=$db->get_results("select * from wi_user_sites where uuid_user='".$_GET['uuid']."'")) {
		foreach($user3_sites as $user_site){
		$user_site_id=$db->get_var("select id from sites where guid='".$user_site->uuid_site."'");
		$user_sites[]=$user_site_id;
		}
		}*/
		
	}
		else
		  {
		  
		           $uuid='';
				   $site_id='';
				   $code='';
				   $firstname='';
				   $lastname='';
				   $gender='';
				   $email='';
				   $languages='';
				   $notifications_code='';
				   $signature='';
				   $password='';
				   $photo_avatar='';
				   $photo_type='';
				   $access_rights=0;
				   $user_sites=array();
				  $b64Src = "img/80x80.png";
				  /* $TimeRegistered='';*/
		  }

require_once('include/main-header.php');
 ?>
    </head>
    <body>
		<div id="maincontainer" class="clearfix">
			<!-- header -->
            <header>
                <?php require_once('include/top-header.php');?>
            </header>
            
            <!-- main content -->
            <div id="contentwrapper">
                <div class="main_content">
                    <nav>
                        <div id="jCrumbs" class="breadCrumb module">
	<ul>
		<li>
			<a href="home.php"><i class="icon-home"></i></a>
		</li>
		<li>
			<a href="index.php">Dashboard</a>
		</li>
		<li>
			<a href="users.php">Users</a>
		</li>
		<li>
			<a href="#">User</a>
		</li>
		
		<?php include_once("include/curr_selection.php"); ?>
	</ul>
</div>
                    </nav>
					
					
					
					<h2 class="heading"><?php if(isset($_GET['uuid'])) { echo "Update ".$code; } else { echo 'Add New User'; } ?></h2>
							<div id="validation" style="padding-left: 200px;color:#FF0000;font-size:18px"><?php if (isset($msg_email)) echo $msg_email; ?></div>
							<div id="validation" style="padding-left: 200px;color:#FF0000;font-size:18px"><?php if (isset($msg_user)) echo $msg_user; ?></div>
							<div id="validation" style="padding-left: 200px;color:#00CC00;font-size:18px">
							<?php if(isset($_SESSION['up_message']) && $_SESSION['up_message']!=''){ echo $_SESSION['up_message']; $_SESSION['up_message']=''; }?>
							</div>
							<div id="validation" style="padding-left: 200px;color:#00CC00;font-size:18px"><?php if (isset($sec_pass)) echo $sec_pass; ?></div>	
 				<br/>
                    <div class="row-fluid">
						<div class="span12">

									<form name="form1" id="form1" class="form-horizontal form_validation_reg" action="" enctype="multipart/form-data" method="post" >
										<fieldset>
										
										<?php
										
											/*if($user_access_level>=11 && !isset($_SESSION['site_id'])) {*/
											if($user_access_level>=11) {
											?>
											<div class="control-group formSep">
												<label class="control-label">Main Site<span class="f_req">*</span></label>
												<div class="controls text_line">
												
												
												<select name="site_id" id="site_id_sel" >
												<option value=""></option>
												<?php
													if($site=$db->get_row("select id, GUID, name,Code from sites where ID='$site_id'")){ ?>
															<option <?php if($site_id==$site->id) { ?> selected="selected" <?php } ?> value="<?php echo $site->id; ?>"><?php echo $site->name.' ('.$site->Code.')'; ?></option>	
														<?php 
													}else{
														$sites=$db->get_results("select id, GUID, name,Code from sites order by zStatus asc, Name ASC limit 0,100 ");
														foreach($sites as $site){ ?>
														<option value="<?php echo $site->id; ?>"><?php echo $site->name.' ('.$site->Code.')'; ?></option>	
														<?php }
													}				
													?>
												</select>
													
													</div>
										</div>
										
										
										<div class="control-group formSep">
											<label class="control-label">Grant Access to Site(s) </label>
										
										<div class="controls span8">	
											<table id="other_sites" class="items table table-condensed table-striped" data-provides="rowlink">
												<thead>
												  <tr class="item">
													  <th width="80%">Site</th>
													   <th colspan="2" align="center">Actions</th>
												  </tr>
											  </thead>
											  <tbody>
											  
											  <?php
											  
											  if(isset($_GET['uuid']) && $_GET['uuid']!='') {
											if($user_sites=$db->get_results("select sites.ID, sites.Name, sites.Code, wi_user_sites.uuid from sites join wi_user_sites on sites.GUID=wi_user_sites.uuid_site where sites.ID!='$site_id' and wi_user_sites.uuid_user='".$_GET['uuid']."'")){
											
												foreach($user_sites as $usr_site){
 
											  ?>
												<tr class="item-row" >
													<td class="item-id">
														<span class="site_id" ><?php echo $usr_site->Name.' ('.$usr_site->Code.')';?></span>
														<div class="ui-widget" style="display:none;" >
														<select name="other_site" class="other_site input-sm form-control" >

																<option value="<?php echo $usr_site->ID; ?>"><?php echo $usr_site->Name.' ('.$usr_site->Code.')'; ?></option>	
															
														</select>
														</div>
														<input type="hidden" value="<?php echo $usr_site->uuid;?>" class="h_other_site" >
													</td>
													<td>
														<a href="javascript:void(0)" class="editlink">Edit</a>
														<a href="javascript:void(0)" class="savelink" style="display:none">Save</a>
													</td>	
													<td>
														<a href="javascript:void(0)" class="removelink" >Remove</a>
														<a href="javascript:void(0)" class="cancellink" style="display:none">Cancel</a>
													</td>	
												</tr>
												<?php }
												}
												}
												?>
												
												  <tr id="hiderow">
													<td colspan="4"><a href='javascript:void(0)'></a><a class="rel_addrow" href="javascript:void(0)" title="Add Site">Add Site</a></td>
												  </tr>
											  </tbody>
											  </table>	</div>
											
										</div>
										
											<?php
											}
										 elseif(isset($_SESSION['site_id']) && $_SESSION['site_id']!='')
										 
	 									{
											$site_arr=explode("','",$_SESSION['site_id']);
											if(count($site_arr)>1) {
											?>
											<div class="control-group formSep">
												<label class="control-label">Main Site <span class="f_req">*</span></label>
												<div class="controls text_line">
												
												
													<select onChange="" name="site_id" id="site_id_sel" >
													<option value=""></option>
													<?php
													if($sites=$db->get_results("select id, GUID, name,Code from sites where ID='$site_id' ")){
														foreach($sites as $site){ ?>
															<option <?php if($site_id==$site->id) { ?> selected="selected" <?php } ?> value="<?php echo $site->id; ?>"><?php echo $site->name.' ('.$site->Code.')'; ?></option>	
														<?php }
													}else {
														$sites=$db->get_results("select id,name from sites where id in ('".$_SESSION['site_id']."') order by zStatus asc, Name ASC limit 0,100");
														foreach($sites as $site)
														{
														?>
														<option value="<?php echo $site->id; ?>"><?php echo $site->name; ?></option>	
														<?php } 
													} ?>
												</select>
													
													</div>
										</div>
										
										<div class="control-group formSep">
												<label class="control-label">Grant Access to Site(s) </label>
												<div class="controls span8">	
												<table id="other_sites" class="items table table-condensed table-striped" data-provides="rowlink">
												<thead>
												  <tr class="item">
													  <th width="80%">Site</th>
													  <th colspan="2" align="center">Actions</th>
													  
												  </tr>
											  </thead>
											  <tbody>
											  
											  <?php
											  
											  if(isset($_GET['uuid']) && $_GET['uuid']!='') {
											if($user_sites=$db->get_results("select sites.ID, sites.Name, sites.Code, wi_user_sites.uuid from sites join wi_user_sites on sites.GUID=wi_user_sites.uuid_site where sites.ID!='$site_id' and wi_user_sites.uuid_user='".$_GET['uuid']."'")){
											
												foreach($user_sites as $usr_site){
 
											  ?>
												<tr class="item-row" >
													<td class="item-id">
														<span class="site_id" ><?php echo $usr_site->Name.' ('.$usr_site->Code.')';?></span>
														<div class="ui-widget" style="display:none;" >
														<select name="other_site" class="other_site input-sm form-control" >

																<option value="<?php echo $usr_site->ID; ?>"><?php echo $usr_site->Name.' ('.$usr_site->Code.')'; ?></option>	
															
														</select>
														</div>
														<input type="hidden" value="<?php echo $usr_site->uuid;?>" class="h_other_site" >
													</td>
													<td>
														<a href="javascript:void(0)" class="editlink">Edit</a>
														<a href="javascript:void(0)" class="savelink" style="display:none">Save</a>
													</td>	
													<td>
														<a href="javascript:void(0)" class="removelink" >Remove</a>
														<a href="javascript:void(0)" class="cancellink" style="display:none">Cancel</a>
													</td>	
												</tr>
												<?php }
												}
												}
												?>
												
												  <tr id="hiderow">
													<td colspan="4"><a href='javascript:void(0)'></a><a class="rel_addrow" href="javascript:void(0)" title="Add Site">Add Site</a></td>
												  </tr>
											  </tbody>
											  </table>	</div>
										</div>
											
											<?php
											} else {
										?>
										<input type="hidden" name="site_id" id="site_id" value="<?php if($site_id!='') { echo $site_id; } else { echo $_SESSION['site_id']; } ?>" >
										<?php
										} }
										?>	
										
											<div class="control-group formSep">
												<label class="control-label">Username<span class="f_req">*</span></label>
												<div class="controls text_line">
													<input type="hidden" value="<?php if($uuid!='') { echo $uuid; } ?>" name="GUID" id="GUID" >
													<input type="text"  name="code" id="code" class="input-xlarge" value="<?php echo $code; ?>">
													<span>&nbsp;</span>
												</div></div>
												
											
					<?php if(!isset($_GET['uuid'])) { ?>
								<div class="control-group formSep">
									<label class="control-label">Password<span class="f_req">*</span></label>
										<div class="controls text_line">
											<input type="password"  name="password" id="password" class="input-xlarge" value="<?php echo $password; ?>">
											<span>&nbsp;</span>
									</div>
										</div>
										
										
										<div class="control-group formSep">
												<label class="control-label">Confirm Password<span class="f_req">*</span></label>
												<div class="controls text_line">
													
													<input type="password"  name="c_password" id="c_password" class="input-xlarge" value="">
													<span>&nbsp;</span>
												</div></div>
												<?php } ?>
										
											<!--<div class="control-group formSep">
												<label class="control-label">Confirm Password</label>
													<div class="controls text_line">
													<input type="password"  name="c_password" id="c_password" class="input-xlarge" value="">
											</div>
												</div>-->
												
														
												
												
												
												
											<div class="control-group formSep">
												<label for="fileinput" class="control-label">User avatar</label>
												<div class="controls">
													<div data-fileupload="image" class="fileupload fileupload-new">
														<input type="hidden" />
														<div style="width: 80px; height: 80px;" class="fileupload-new thumbnail"><img src="<?php echo $b64Src; ?>" alt="" width="80" height="80" id="usr_img" /></div>
														<div style="width: 80px; height: 80px; line-height: 80px;" class="fileupload-preview fileupload-exists thumbnail"></div>
														<span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" id="fileinput" name="fileinput" /></span>
														<a data-dismiss="fileupload" class="btn fileupload-exists" href="#">Remove</a>
													</div>	
												</div>
											</div>
											
											
											
											
												
												
												
												<div class="control-group formSep">
												<label class="control-label">First Name<span class="f_req">*</span></label>
												<div class="controls text_line">
													
													<input type="text"  name="firstname" id="firstname" class="input-xlarge" value="<?php echo $firstname; ?>">
													<span>&nbsp;</span>
												</div></div>
												
												<div class="control-group formSep">
												<label class="control-label">Last Name</label>
												<div class="controls text_line">
													
													<input type="text"  name="lastname" id="lastname" class="input-xlarge" value="<?php echo $lastname; ?>">
													<span>&nbsp;</span>
												</div></div>
												
												
												<div class="control-group formSep">
												<label class="control-label">Gender<span class="f_req">*</span></label>
												<div class="controls">
													<label class="radio inline">
														<input type="radio" value="male" id="s_male" name="gender" <?php if($gender=="male") { ?> checked="checked" <?php }?> />
														Male
													</label>
													<label class="radio inline">
														<input type="radio" value="female" id="s_female" name="gender" <?php if($gender=="female") { ?> checked="checked" <?php }?> />
														Female
													</label>
												</div>
											</div>
												
												
												<div class="control-group formSep">
												<label class="control-label">Email<span class="f_req">*</span></label>
												<div class="controls text_line">
													
													<input type="text"  name="email" id="email" class="input-xlarge" value="<?php echo $email; ?>">
													<span>&nbsp;</span>
												</div></div>
												
												<?php if($user_access_level>=2) {?>
												<div class="control-group formSep">
													<label class="control-label">Access Rights<span class="f_req">*</span></label>
													<div class="controls">
														<label class="radio inline">
															<input type="radio" value="1" id="read_access" name="access_rights" <?php if($access_rights==1) { ?> checked="checked" <?php } ?> />
															Readonly
														</label>
														<label class="radio inline">
															<input type="radio" value="2" id="write_access" name="access_rights" <?php if($access_rights==2) { ?> checked="checked" <?php } ?>  />
															ReadWrite
														</label>
														<?php if($user_access_level>=2 && !isset($_SESSION['site_id'])) {?>
														<label class="radio inline">
															<input type="radio" value="11" id="full_access" name="access_rights" <?php if($access_rights==11) { ?> checked="checked" <?php } ?> />
															SuperUser
														</label>
														<?php } ?>
													</div>
												</div>
												<?php } else{ ?>
													<input type="hidden" value="0" id="read_access" name="access_rights"/>
												<?php } ?>
												
												<div class="control-group formSep">
												<label class="control-label">Language(s)</label>
												<div class="controls">
													<select name="languages" id="languages" class="span5">
														<option <?php if($languages=="English") { ?> selected="selected" <?php }?> value="English">English</option>
														<option <?php if($languages=="French") { ?> selected="selected" <?php }?> value="French"> French</option>
														<option <?php if($languages=="German") { ?> selected="selected" <?php }?> value="German">German</option>
														<option <?php if($languages=="Italian") { ?> selected="selected" <?php }?> value="Italian">Italian</option>
														<option <?php if($languages=="Chinese") { ?> selected="selected" <?php }?> value="Chinese">Chinese</option>
														<option <?php if($languages=="Spanish") { ?> selected="selected" <?php }?> value="Spanish">Spanish</option>
													</select>
												</div>
											</div>
												
												
												
												<div class="control-group formSep">
												<label class="control-label">I want to receive:</label>
												<div class="controls">
													<label class="checkbox inline">
													<?php $noti_code = $notifications_code;
															$noti_code = explode("," , $noti_code); ?>
															
													
													<input type="checkbox" value="1" id="email_newsletter" name="notification[]" <?php if (in_array ("1" , $noti_code)) { ?> checked="checked" <?php }?> />
														
														Newsletters
													</label>
													<label class="checkbox inline">
													<input type="checkbox" value="2" id="email_sysmessages" name="notification[]" <?php if (in_array ("2" , $noti_code)) { ?> checked="checked" <?php }?> />
														
														System messages
													</label>
													<label class="checkbox inline">
													<input type="checkbox" value="3" id="email_othermessages" name="notification[]" <?php if (in_array ("3" , $noti_code)) { ?> checked="checked" <?php }?> />
														
														Other messages
													</label>
												</div>
											</div>
											       
											
											
											
											
												<div class="control-group formSep">
												<label for="u_signature" class="control-label">Signature</label>
												<div class="controls">
													<textarea rows="4" id="signature" name="signature" class="input-xlarge"><?php echo $signature; ?></textarea>
													<span class="help-block">Automatic resize</span>
												</div>
											</div>
											
											
												
												
												
												
												
											
									<div class="control-group">
												<div class="controls">
													<button class="btn btn-gebo" type="submit" name="submit" id="submit">Submit</button>
												
												</div>
											</div>
										</fieldset>
									</form>
									
									
									
									
									
									
									
								<?php if(isset($_GET['uuid'])) { ?>
								<div class="row-fluid">
								<div class="span12">
									<h3 class="heading"> Change Password</h3>
									<form name="form_pass" id="form_pass" class="form-horizontal form_validation_reg" action="" enctype="multipart/form-data" method="post" >
									
								<fieldset>
									<div class="control-group formSep">
									<label class="control-label">New Password<span class="f_req">*</span></label>
										<div class="controls text_line">
											<input type="password"  name="password" id="password" class="input-xlarge" value="">
									</div>
										</div>
										
										
										<div class="control-group formSep">
											<label class="control-label">Confirm Password<span class="f_req">*</span></label>
												<div class="controls text_line">
													
													<input type="password"  name="c_password" id="c_password" class="input-xlarge" value="">
												</div></div>
												
										
									<div class="control-group">
												<div class="controls">
													<button class="btn btn-gebo" type="submit" name="submit_pass" id="submit_pass">Change Password</button>
												
												</div>
											</div>
									
									
									</fieldset></form>
									</div></div>
									
									
									
									<?php } ?>
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
													
												
								</div>
							</div>
						</div>
					</div>
                        
                </div>
            </div>
            
			<!-- sidebar -->
            <aside>
                 <?php require_once('include/sidebar.php');?>
			</aside>
			
			 <?php require_once('include/footer.php');?>
            
           
            
			<script type="text/javascript">
			
			$(document).ready(function(){
				$( ".other_site" ).combobox();

				$("#fileinput").change(function(){
					if (this.files && this.files[0]) {
            			var reader = new FileReader();

            			reader.onload = function (e) {
						$('#usr_img').attr('src', e.target.result);
           				 };

           				 reader.readAsDataURL(this.files[0]);
       				 }
					//$("#usr_img").attr("src",img);
					
					
				});
			
				
				
				//* regular validation
					gebo_validation.reg();
					
					
					 $.validator.addMethod("conf_pass", 
                           function(value, element) {
                              if($("#c_password").val()==$("#password").val()){
							  return true;
							  }
							  else
							  {
							  return false;
							  }
                           }, 
                           "Password do not match"    ); 

						   
					bind();
					$(".rel_addrow").click(function(){
						$("#other_sites a.cancellink").each(function(){
							$(this).trigger('click');
						});							
						$("#hiderow").before('<tr class="item-row"><td class="item-id"><span class="site_id" style="display:none;" ></span><div class="ui-widget" ><select  class="other_site input-sm form-control" ><option value=""></option></select></div><input type="hidden" value="" class="h_other_site" ></td><td ><a href="javascript:void(0)" class="editlink" style="display:none">Edit</a><a href="javascript:void(0)" class="savelink" >Save</a></td><td><a href="javascript:void(0)" class="removelink" style="display:none" >Remove</a><a href="javascript:void(0)" class="cancellink" >Cancel</a></td></tr>');
						var curr_row = $("#hiderow").prev();
						curr_row.find('.other_site').combobox();
						curr_row.find('.custom-combobox-input').autocomplete( "search", '' );
						curr_row.find('.custom-combobox-input').focus();		
						bind();
					});	   
						   
			});
					
			
			//* validation
				gebo_validation = {
					
					reg: function() {
						reg_validator = $('#form1').validate({
							onkeyup: false,
							errorClass: 'error',
							validClass: 'valid',
							highlight: function(element) {
								$(element).closest('div').addClass("f_error");
							},
							unhighlight: function(element) {
								$(element).closest('div').removeClass("f_error");
							},
							errorPlacement: function(error, element) {
								$(element).closest('div').append(error);
							},
							rules: {
								site_id: { required: true },
								code: { required: true },
								firstname: { required: true },
								
								gender: { required: true },
								email: { required: true, email:true },
								password: { required: true },
								c_password: { required: true , conf_pass:true},
								access_rights: { required: true }
							},
							invalidHandler: function(form, validator) {
								$.sticky("There are some errors. Please corect them and submit again.", {autoclose : 5000, position: "top-right", type: "st-error" });
							}
						})
						
						reg_pass = $('#form_pass').validate({
							onkeyup: false,
							errorClass: 'error',
							validClass: 'valid',
							highlight: function(element) {
								$(element).closest('div').addClass("f_error");
							},
							unhighlight: function(element) {
								$(element).closest('div').removeClass("f_error");
							},
							errorPlacement: function(error, element) {
								$(element).closest('div').append(error);
							},
							rules: {
								
								password: { required: true },
								c_password: { required: true , conf_pass:true},
							},
							invalidHandler: function(form, validator) {
								$.sticky("There are some errors. Please corect them and submit again.", {autoclose : 5000, position: "top-right", type: "st-error" });
							}
						})
					}
				};
				
				function bind() {
				  $(".savelink").unbind();
				  $(".editlink").unbind();
				  $(".cancellink").unbind();
				  $(".removelink").unbind();				  
				  $(".savelink").click(save);
				  $(".editlink").click(edit);
				  $(".cancellink").click(cancel);
				  $(".removelink").click(remove);				  
				}
				
				//save
				function save() {
					var row = $(this).parents('.item-row');
					var usr_uuid=$('#GUID').val();
					var id=row.find('.other_site').val();
					var old_id=row.find('.h_other_site').val();

					if(id!='')
					{
						var dataString = 'usr_uuid='+usr_uuid+'&id='+id+'&old_id='+old_id;
						$.ajax({
							type: "POST",
							url: "site_grantaccess.php",
							data: dataString,
							dataType: 'json',
							success: function(response)
							{
								if(response.succ){
									alert("Site access granted successfully");
									row.find('.site_id').html(response.site_name);
									row.find('.h_other_site').val(response.uuid);
									
									row.find('.ui-widget').hide();
									row.find('.site_id').show();
									
									row.find('.savelink').hide();
									row.find('.editlink').show();
									row.find('.cancellink').hide();
									row.find('.removelink').show();
									bind();
								}else{
									alert("This Site is already assigned.");
									if(response.id){
										row.find('.other_site').html('<option value="'+response.id+'">'+response.site_name+'</option>');
										row.find('.other_site').combobox( "destroy" );
										row.find('.other_site').combobox();
									}
								}
							}
						});
					}
					else
					{
					alert('Please Select a Site');
					}
				}
				
				//cancel
				function cancel() {
					var row = $(this).parents('.item-row');
					var id=row.find('.h_other_site').val();
					if(id!=''){						
						row.find('.site_id').show();
						row.find('.ui-widget').hide();
						row.find('.savelink').hide();
						row.find('.editlink').show();
						row.find('.cancellink').hide();
						row.find('.removelink').show();
					}
					else
					{						
						row.remove();
					}
				}
				
				//edit
				function edit() {
					$("#other_sites a.cancellink").each(function(){
						$(this).trigger('click');
					});
					var row = $(this).parents('.item-row');					
					row.find('.site_id').hide();									
					row.find('.ui-widget').show();					
					row.find('.other_site').combobox( "destroy" );
					row.find('.other_site').combobox();
					row.find('.savelink').show();
					row.find('.editlink').hide();
					row.find('.cancellink').show();
					row.find('.removelink').hide();
					
					row.find('.custom-combobox-input').focus();
				}
				
				//remove
				function remove() {
					var row = $(this).parents('.item-row');
					var acc_site_guid=row.find('.h_other_site').val();					
					var dataString = 'delaccsite_guid='+acc_site_guid;
					$.ajax({
						type: "POST",
						url: "site_revokeaccess.php",
						data: dataString,
						success: function(response)
						{
							if(response){
								alert("Site access revoked successfully");
								row.remove();
							}
							else{
								alert("Problem revoking Site access");
							}
						}
					});
				}
			</script>
            
		</div>
	</body>
</html>
