<?php require_once("include/cache_start.php"); 

require_once("include/lib.inc.php"); 

$jobTitleStr="";
$consultantEmailStr="";
$authorName="";
$pPageType="";
$published_timestampInt=0;

$flag = false;

$code = isset($_GET['code']) ? $_GET['code'] : '';
$code = str_replace(".html", "", $code);
$ResultingData = array();

if(isset($code)){
	
	$Query = "SELECT * FROM `documents` WHERE `Code`='$code' AND SiteID=" . SITE_ID . " ORDER BY ID DESC LIMIT 1 ";
	$siteCodeStr = 'marshallharber';
	$db->query('SET NAMES utf8');
	$ResultingData = $db->get_row($Query);
}

if(count($ResultingData)>0){
	$pWindowTitleTxt = $ResultingData->PageTitle;
	$pMetaKeywordsTxt = $ResultingData->MetaTagKeywords;
	$pMetaDescriptionTxt = $ResultingData->MetaTagDescription;
}else{
	header('Location: content_not_found.php');   
	exit;
}

include_once("include/main-header.php"); 
?>
 <?php if(isset($ResultingData->Code) && $ResultingData->Code!=''){
	$canonical_url=strtolower($ResultingData->Code); ?>
	<link rel="canonical" href="<?php echo SITE_PATH.'/'.$canonical_url.'.html';?>" />
 <?php } ?>
 
</head>
<body>
<?php include_once("include/top-header.php"); ?>
<div class="container page-content">
<?php	if(count($ResultingData)>0){
	$type = $ResultingData->Type; 
		switch($type){
			case 'job' :
			
			$arr_cats=$db->get_col("select Code from categories where ID in (select CategoryID from documentcategories where DocumentID = ".$ResultingData->ID." and SiteID='".SITE_ID."') and SiteID='".SITE_ID."'");
	?>
	<script type="text/javascript">
	window.onload = function (){
		var pReloadPage = false;
		_updateMyJobsList('addback', <?php echo $ResultingData->ID;?>, 'user_selection_documents_jobapplist',pReloadPage,true);
		_updateMyJobsList('addforward', <?php echo $ResultingData->ID;?>, 'user_selection_documents_jobapplist',pReloadPage,true);
		pReloadPage = true;
	}
	</script>
	<div class="row"> 
    	<div class="col-sm-8 col-md-9 col-md-push-3 col-sm-push-4 " id="content-part">
    		<div>
        		<h2><?php echo $ResultingData->Document;?></h2>
       			<!--a href="javascript:_updateMyJobsList('addback', <?php echo $ResultingData->ID;?>, 'user_selection_documents_jobapplist');" id="addback<?php echo $ResultingData->ID;?>" class="btn white-btn addback" title="Shortlist this Job"> Shortlist this Job </a--> 
				<a href="javascript:_updateMyJobsList('addforward', <?php echo $ResultingData->ID;?>, 'user_selection_documents_jobapplist');" id="addforward<?php echo $ResultingData->ID;?>" class="btn white-btn addforward" title="Apply for this job"> Apply for this job </a>
				<a href="javascript:void(0)" onClick="goback()"  class="btn white-btn " title="Back to Jobs"> Back to Jobs </a>
				
				<br>
        		<br>
        		<?php if($ResultingData->FFAlpha80_4!='') { ?>Employer: <?php echo $ResultingData->FFAlpha80_4; ?><br><?php } ?>
       			<?php if($ResultingData->FFAlpha80_1!='') { ?>Location: <?php echo $ResultingData->FFAlpha80_1; ?><br><?php } ?>
				<?php if($ResultingData->FFAlpha80_3!='') { ?>Type: <?php echo $ResultingData->FFAlpha80_3; ?><br><?php } ?>

				<?php if($ResultingData->Reference!='') { ?>Reference:<?php echo $ResultingData->Reference; ?><br><?php } ?>
				<?php if($ResultingData->FFAlpha80_2!='') { ?>Salary: <?php echo $ResultingData->FFAlpha80_2; ?><br><?php } ?>
				<?php echo $ResultingData->Body; ?>
				<?php if( $ResultingData->PublishCode == 0 ) echo "<marquee>This vacancy has now been filled. <a href=\"/job-board.php\">Search active jobs on our job board now.</a></marquee>"; ?>
                <!--a href="javascript:_updateMyJobsList('addback', <?php echo $ResultingData->ID;?>, 'user_selection_documents_jobapplist');" id="addback<?php echo $ResultingData->ID;?>" class="btn white-btn addback" title="Shortlist this Job"> Shortlist this Job </a--> 
				<a href="javascript:_updateMyJobsList('addforward', <?php echo $ResultingData->ID;?>, 'user_selection_documents_jobapplist');" id="addforward<?php echo $ResultingData->ID;?>" class="btn white-btn addforward" title="Apply for this job"> Apply for this job </a>
				<a href="javascript:void(0)" onClick="goback()"  class="btn white-btn " title="Back to Jobs"> Back to Jobs </a>
				
				<br>
      
      </div>
    </div>
    <div class="col-sm-4 col-md-3 col-sm-pull-8 col-md-pull-9">
      <?php include_once("include/side-categories.php"); ?>
    </div>
  </div>
	<?php break;
	case 'blog' :
	?>
	 <div class="row"> 
    <!--	<h1 class="mrgn-lft-rit15">Job Board</h1> -->
    <div class="col-sm-8 col-md-9">     	
				 <div class="post-detail clearfix">                     
           			 <h1><?php echo $ResultingData->Document;?></h1>            
           			<small>
           			<?php 
           			if($ResultingData->PostedTimestamp!=""){
        				$Published_timestamp=$ResultingData->PostedTimestamp;
        				$publishedDate = date('M d, Y',$Published_timestamp);
           			
           			?>
           			<b>Posted:</b> <?php echo $publishedDate;?>| 
           			<?php } 
           			if($ResultingData->UserID!=""){
	    				if($chk_usr= $db->get_row("select firstname,lastname from wi_users where ID='".$ResultingData->UserID."'")){
	    					$postedByStr= $chk_usr->firstname.' '.$chk_usr->lastname;
	    			?>
           			<b>Author:</b> <?php echo $postedByStr;?>| 
           			<?php }
           			} ?>
           			<?php $categoriesStr="";
					$docCategories = $db->get_results("SELECT c.Name FROM documentcategories dc join categories c on dc.CategoryID=c.ID where dc.DocumentID='".$ResultingData->ID."' and c.SiteID='".SITE_ID."' and dc.SiteID='".SITE_ID."' and c.Type='blog' Order by dc.ID desc");
					if($docCategories>0){
						foreach($docCategories as $cat){
							if($categoriesStr==""){
								$categoriesStr .=$cat->Name;
							}else{
								$categoriesStr .=', '.$cat->Name;
							}
						}
					}
					if($categoriesStr!=""){
           			?>
           			<b>Filed under:</b> <a href="javascript:void(0)" rel="category tag"><?php echo $categoriesStr;?></a>| 
           			<?php } ?>
           			<?php  $CommentData = $db->get_results("Select * from blog_comments where blog_uuid='".$ResultingData->GUID."' AND blog_id='".$ResultingData->ID."' AND Status=1 Order by ID DESC");
	    			//$db->debug();
	    			$totalComment=count($CommentData);
	    			if( $totalComment>0){
	    				if($totalComment==0 || $totalComment==1){
	    					$totalCommentStr= $totalComment." Comment";
	    				}else{
	    					$totalCommentStr= $totalComment." Comments";
	    				}
	   				}else{
	    				$totalCommentStr= "0 Comment";
	    			}?>
           			<a href="#addBlogComment"><?php echo $totalCommentStr;?></a></small>
           			<?php 
           			if($blogpic = $db->get_row("Select Picture from pictures where SiteID='".SITE_ID."' AND DocumentID='".$ResultingData->ID."' AND Status=1 AND Code='large-image'")){
	    				if($blogpic->Picture != ''){
	    					if(isset($blogpic->Type) && $blogpic->Type!=""){
							$mime = $blogpic->Type;
							$b64Src = "data:".$mime.";base64," . base64_encode($blogpic->Picture);	
							}else{
							$b64Src = "data:;base64," . base64_encode($blogpic->Picture);	
							}
					 } 
					 else{ $b64Src= "images/blog.jpg"; }
            		} else{ $b64Src= "images/blog.jpg"; }	?>
					
					<div class="big-imgblk" id="content-part">
          					<img src="<?php echo $b64Src; ?>" class="img-responsive" alt="" >
            			</div>
			            <?php echo $ResultingData->Body;?>
  
                   <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                	<form  name="addBlogComment" id="addBlogComment">
                	<h4>Name:</h4>
                    <div class="form-group">
                    <input type="text" class="form-control" id="customerName" value="" name="customerName">
                    <input type="hidden" id="b_title" value="<?php echo $ResultingData->Document;?>">
                     <input type="hidden" id="b_id" value="<?php echo $ResultingData->ID;?>">
                    <input type="hidden" id="b_uuid" value="<?php echo $ResultingData->GUID;?>">
                    </div>
                    <h4>Email Address:</h4>
                    <div class="form-group">
                    <input type="text" class="form-control" id="customerEmail" name="customerEmail" value="">
                    </div>
                    <h4>Leave a Comment:</h4>
                    
                        <div class="form-group">
                            <textarea class="form-control" rows="3" id="customerComment" name="customerComment"></textarea>
                        </div>
                        <button type="submit" class="btn send-btn" id="submitComment">Submit</button>
                    </form>
                </div>

               
                <?php if(count($CommentData)>0){	?>
				<hr>
                <!-- Posted Comments -->
				<?php foreach($CommentData as $blogComment){ ?>
                <!-- Comment -->
                <div class="media">
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $blogComment->Name; ?>
                        <?php if($blogComment->Created!=""){
        					$created_timestamp=$blogComment->Created;
        					$CreatedDate = date('M d, Y h:i A',$created_timestamp);
        					$CreatedTime = date('h:i A',$created_timestamp);
           				?>
                            <small><?php echo $CreatedDate." at ".$CreatedTime; ?></small>
                        <?php } ?>
                        </h4>
                        <?php echo $blogComment->comments;?>
                    </div>
                </div>
				<?php } ?>
                
                <?php } ?> 
                </div>
                 

      <!--<div class="pager"><div class="text-right"> <span><a href="#">&lt; Previous</a></span><span><a href="#">Next &gt; </a></span> </div></div>-->
    </div>
    <div class="col-sm-4 col-md-3">
     <!-- start recent posts-->
        <?php include_once("include/recent-posts.php"); ?>
        <!-- end recent posts-->
        
        <!-- start blog archives-->
        <?php include_once("include/blog-archive.php"); ?>
     	<!-- end blog archives-->
     
      	<!-- start blog categories-->
		<?php include_once("include/blog-categories.php"); ?>
		<!-- start blog categories-->
    </div>
  </div>
	
	<?php  break;
	default:
	if($ResultingData->Code=="our-services"){ ?>
	<div class="row">
   		<div class="col-sm-12">
        	<h1><?php echo $ResultingData->Document;?></h1>
         	<div class="row ">
        		<div class="col-sm-3 col-md-2">
              		<?php
		if($blogpic = $db->get_row("Select Picture from pictures where SiteID='".SITE_ID."' AND DocumentID='".$ResultingData->ID."' AND Status=1")){
	   		if($blogpic->Picture != ''){
	    		if(isset($blogpic->Type) && $blogpic->Type!=""){
					$mime = $blogpic->Type;
					$blogImg = "data:".$mime.";base64," . base64_encode($blogpic->Picture);	
				?>
				<div class="text-center"><div style="display:inline-block; margin-bottom:15px;"> <img src="<?php echo $blogImg;  ?>" alt=""></div></div>
				<?php
				}else{
					$blogImg = "data:;base64," . base64_encode($blogpic->Picture);
					?>
				<div class="text-center"><div style="display:inline-block; margin-bottom:15px;"> <img src="<?php echo $blogImg; ?>" alt=""></div></div> 	
					<?php	
				}
			}
	   	}
		
		?>
           		</div>
        		<div class="col-sm-9 col-md-10">
				
            		<div class="seo-links seo-link-st-ser-pg"  >
					<?php $tokenMainContent = __token_getValue($db, 'service-page-cats'); 
if($tokenMainContent!="" ){ 
		echo $tokenMainContent; 
	}else{	?>
<a href="housekeeper.html">HOUSEKEEPERS</a>
 <a href="butler.html">BUTLERS</a> 
<a href="valet.html">VALETS</a> 
<a href="chauffeur.html">CHAUFFEURS</a> 
<a href="domestic-couple.html">DOMESTIC COUPLES</a> 
<a href="gardener.html">GARDENERS</a> <br/>
<a href="estate-manager.html">ESTATE MANAGERS</a> 
<a href="chef-cook.html">HANDYMEN</a> 
<a href="lady-s-maid.html">LADIES MAIDS</a> 
<a href="house-manager.html">HOUSE  MANAGERS</a> <br/>
<a href="personal-assistant.html">PERSONAL ASSISTANTS</a> 
<a href="daily-cleaner.html">DAILY  CLEANERS</a> 
<a href="chef-cook.html">CHEFS & COOKS</a>
<?php
 } 
?>
            		</div>
				
            	</div>
      		</div>
        </div>
  	</div>
	<div class="row mrgn-btm15">
   		<div class=" col-sm-12" id="content-part">
        	<?php echo $ResultingData->Body;?>
        </div>
 	</div>
 	<?php } elseif($ResultingData->Code=="clients" || $ResultingData->Code=="candidates" || $ResultingData->Code=="candidateApplication" ){ ?>
 		<div class="row mrgn-btm15">
            <h1 class="mrgn-lft-rit15"><?php echo $ResultingData->Document;?></h1> 
            <div class="col-sm-12 col-md-9 " id="content-part">
				<?php
		if($blogpic = $db->get_row("Select Picture from pictures where SiteID='".SITE_ID."' AND DocumentID='".$ResultingData->ID."' AND Status=1")){
	   		if($blogpic->Picture != ''){
	    		if(isset($blogpic->Type) && $blogpic->Type!=""){
					$mime = $blogpic->Type;
					$blogImg = "data:".$mime.";base64," . base64_encode($blogpic->Picture);	
				?>
				<div class=" text-center pull-left" style="margin-right:20px;"> <img src="<?php echo $blogImg; ?>" alt=""></div> 
				<?php
				}else{
					$blogImg = "data:;base64," . base64_encode($blogpic->Picture);
					?>
				<div class=" text-center pull-left" style="margin-right:20px;"> <img src="<?php echo $blogImg; ?>" alt=""></div> 	
					<?php	
				}
			}
	   	}
		
		?>
            		<?php echo $ResultingData->Body;?>
            </div>
            <div class="col-sm-12 col-md-3">
                <?php include_once("include/contactus-small.php"); ?>
                <?php if($ResultingData->Code=="clients"){ 
                	include_once("include/call-us.php");
                }else{
                    include_once("include/latest-vacancies.php");
                }
                ?>
            </div>
        </div>
 	<?php } elseif($ResultingData->Code=="company"){?>
 		<div class="row">
        	<div class="col-sm-12 " id="content-part">
          		<h1><?php echo $ResultingData->Document;?></h1> 
          		<?php echo $ResultingData->Body;?>
            </div>
        </div>
 	<?php } else{	?>
 	<div class="row">
   		<div class="col-sm-12">
        	<h1><?php echo $ResultingData->Document;?></h1>
        </div>
  	</div>
	<div class="row mrgn-btm15">
   		<div class=" col-sm-12" id="content-part">
		<?php
		if($blogpic = $db->get_row("Select Picture from pictures where SiteID='".SITE_ID."' AND DocumentID='".$ResultingData->ID."' AND Status=1")){
	   		if($blogpic->Picture != ''){
	    		if(isset($blogpic->Type) && $blogpic->Type!=""){
					$mime = $blogpic->Type;
					$blogImg = "data:".$mime.";base64," . base64_encode($blogpic->Picture);	
				?>
				<div class=" text-center pull-left" style="margin-right:20px;"> <img src="<?php echo $blogImg; ?>" alt=""></div> 
				<?php
				}else{
					$blogImg = "data:;base64," . base64_encode($blogpic->Picture);
					?>
				<div class=" text-center pull-left" style="margin-right:20px;"> <img src="<?php echo $blogImg; ?>" alt=""></div> 	
					<?php	
				}
			}
	   	}
		
		?>
			
		
        	<?php echo $ResultingData->Body;?>
        </div>
 	</div>
 	<?php } ?>
<?php }
} ?>
</div>
<?php include_once("include/footer.php"); ?>
<script src="js/cookies.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){

	$("#addBlogComment").validate({
		ignore: ':hidden',
		rules: {
			customerName: "required",
			customerEmail: {
				required: true,
				email: true
			},
			customerComment: "required",
		
		},
		messages: {
			customerName: "Please enter your Name",
			customerEmail: {
				required: "Please enter your E-mail",
				email: "Please enter valid E-mail"
			},
			customerComment: "Please enter comment",
		},submitHandler: function (form) {
			$('.alert').remove();
			var customerComment= $('#customerComment').val();
			var customerName= $('#customerName').val();
			var customerEmail= $('#customerEmail').val();
			
			var b_title= $('#b_title').val();
			var b_id= $('#b_id').val();
			var b_uuid= $('#b_uuid').val();
			
			if(customerComment!="" && b_id!="" && customerName!="" && customerEmail!=""){
				var btn_text= $('#submitComment').val();
				$('#submitComment').attr('disabled', true);
				$('#submitComment').val('Submitting...');
		
				$.ajax({
					type: "post",
					dataType: "json",
					url: 'submit-blog-comment.php',
					data: {"comment" : customerComment, "name" : customerName, "email" : customerEmail, "blogTitle" : b_title, "blogID" : b_id, "blogUUID" : b_uuid},
					cache: false,
					success: function(html)	{	
						if(html.success){		
							$('#addBlogComment').before('<div class="alert alert-success" role="alert"><i class="glyphicon glyphicon-ok" aria-hidden="true" ></i> '+html.success+'</div>');
							$('#addBlogComment')[0].reset();
						}else if(html.error){
							$('#addBlogComment').before('<div class="alert alert-danger" role="alert"><i class="glyphicon glyphicon-remove" aria-hidden="true" ></i> '+html.error+'</div>');
						}
						$('#submitComment').attr('disabled', false);
						$('#submitComment').val(btn_text);
					}
				});
			}
		}
	});
});

function savepage(code){
	document.cookie="referrer=job-board.php";
	document.cookie="last_srch=";
	document.cookie="last_page=1";
	document.cookie="last_page1=1";
	__urlHandler(code);
}
</script>
</body>
</html>
<?php
require_once("include/cache_end.php");
?>