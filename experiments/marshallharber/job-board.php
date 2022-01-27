<?php require_once("include/lib.inc.php"); ?>
<?php 
//title
$tokenWindowStr = __token_getValue($db, 'jobboard-windowtitle'); 
if(isset($tokenWindowStr) && $tokenWindowStr!="" ){ 
	$pWindowTitleTxt= $tokenWindowStr; 
}

//meta description
$tokenMetaDescStr = __token_getValue($db, 'jobboard-metadescription'); 
if(isset($tokenMetaDescStr) && $tokenMetaDescStr!="" ){ 
	$pMetaDescriptionTxt= $tokenMetaDescStr; 
}

//meta keywords
$tokenMetaKeywordsStr = __token_getValue($db, 'jobboard-metakeywords'); 
if(isset($tokenMetaKeywordsStr) && $tokenMetaKeywordsStr!="" ){ 
	$pMetaKeywordsTxt= $tokenMetaKeywordsStr; 
}

$catcode='';
$catname='';
if(isset($_GET['category']) && $_GET['category']!=''){
	$catcode= $_GET['category'];
	$catname= $db->get_var("select Name from categories where SiteID='".SITE_ID."' and Code='".$catcode."'");
}

?>
<?php include_once("include/main-header.php"); ?>
   <link rel="canonical" href="<?php echo SITE_PATH;?>/job-board.php" />
  </head>
  <body>
  
   <?php include_once("include/top-header.php"); ?>
    <div class="container page-content">
   	    <div class="row">
                   	<!--	<h1 class="mrgn-lft-rit15">Job Board</h1> -->
                    <div class="col-sm-8 col-md-9 col-md-push-3 col-sm-push-4 ">
                  	
                  	 
                    
                    <div class="row">
                      <div class="col-md-8">
                      <h2>List of <?php if($catname!=''){ echo $catname; } else{ echo 'All'; } ?> Jobs</h2>
					  
					  <div id="ImageLoadingDiv1" style=" text-align:center; display: block; margin-top: 85px; margin-bottom: 20px;">
	Loading...<br />
    <img id="imgAjaxLoading" src="images/loading-3.gif"  style="border-width: 0px;" alt="">
 </div>
					  
					  <div id="content_area">  
                    	
					</div>                     
                      </div>
                       <div class="col-md-4">
                      	<!-- <h2>Apply to Register</h2>-->
           	              <div class="thumbnail contact-us-blk  " style="margin-top:0px;" >                     
                            <!-- <form class="cont-form">
                              <div class="text-right req-label" style="margin-top:-2px;"><small><em><sup class="required">*</sup>required fileds</em></small></div>
                                   <input type="text" class="form-control rit-frm-sm-field"  placeholder="Name "><abr class="small-req" >*</abr>
                                   <input type="email" class="form-control rit-frm-sm-field"  placeholder="Email Address"><abr class="small-req" >*</abr>
                                   <input type="text" class="form-control rit-frm-sm-field"  placeholder="Home Telephone ">
                                   <input type="text" class="form-control rit-frm-sm-field"  placeholder="Daytime Telephone">
                                   <input type="text" class="form-control rit-frm-sm-field"  placeholder="Mobile">
                                  <div class="rit-frm-sm-field"> <input type="file" class="filestyle" data-buttonBefore="true" placeholder="Mobile"></div><abr class="small-req" >*</abr>
                                   <textarea class="form-control rit-frm-sm-field" rows="3" placeholder="Message " ></textarea><abr class="small-req" >*</abr>
                                   <input type="submit" class="btn btn-default btn-mrgn" value="Send Application">
     			             </form>-->
                              <form class="cont-form" enctype="multipart/form-data" id="frm-apply" method="post" action="thankyou-candidate.php">
							  <input type="hidden" name="form_type" id="form_type" value="apply" />
							  <input type="hidden" name="answer" id="answer" value=""/>
							  <input type="hidden" name="types" id="types" value="Looking for work" />
          <h2>Submit Application</h2>
           <div class="text-right" style="color:#000;" ><small><em><sup class="required">*</sup>All fields are required.</em></small></div>
          		 <input type="text" class="form-control"  placeholder="Name" name="name" id="name">
         		 <input type="text" class="form-control"  placeholder="Phone Number" name="ph_no" id="ph_no">
         		 <input type="email" class="form-control"  placeholder="Email" name="email" id="email">
                 <input type="file" class="filestyle"  data-buttonBefore="true" name="file" id="file" >
          <textarea class="form-control" rows="3" placeholder="Message" name="message" id="message" ></textarea>
          <input type="submit" class="btn btn-default" value="Submit Application Now" id="btn_submit"> 
        </form>
               	        </div>
						
						
						<h5 >Jobs attached to your application:</h5>
						<div id="ImageLoadingDiv2" style=" text-align:center; display: block;">
	Loading...<br />
    <img id="imgAjaxLoading1" src="images/loading-3.gif"  style="border-width: 0px;" alt="">
 </div>
                       <div id="jobs_area">
			
</div>	



                        
			  
			  
                      </div>
                   </div>
                   </div>
                    <div class="col-sm-4 col-md-3 col-sm-pull-8 col-md-pull-9">
               	 <?php include_once("include/side-categories.php"); ?>
                </div>
         </div>
         </div>
<?php include_once("include/footer.php"); ?>
<script src="js/cookies.js" type="text/javascript"></script>
<script type="text/javascript">
var last_page=1;
var last_page1=1;
$(document).ready(function(){
		if(getCookie('back_to')=='yes'){
			document.cookie="back_to=no";
			$.movePage(getCookie('last_page'), $('#content_area'));
			$.movePage(getCookie('last_page1'), $('#jobs_area'));
		}
		else{
			$.movePage(1, $('#content_area'));
			$.movePage(1, $('#jobs_area'));
		}
		
	});

	$.movePage = function movePage(pageNum, ref){
	
	
		ref.html("");
		
		
		var url='';
		if(ref.attr('id')=='content_area'){
			$('#ImageLoadingDiv1').show();
			url= "json-jobs.php?pageNum="+pageNum+"&cat=<?php echo $catcode; ?>";
			last_page=pageNum;
		}
		else{
			$('#ImageLoadingDiv2').show();
			url= "json-sel-jobs.php?pageNum="+pageNum+"&mode=sidebar";
			last_page1=pageNum;
		}

		$.ajax({
		  type : "GET",
		  url: url,
		  cache: false,
		  success: function(html){
			//alert(html);return false;
			if(html.indexOf("No result found") > -1){
				window.location.href='/content_not_found.php';
			}
			if(html!='no'){ //alert(html);
				if(ref.attr('id')=='content_area'){
					$('#ImageLoadingDiv1').hide();
				}
				else{ //alert(html);
					$('#ImageLoadingDiv2').hide();
				}
				//$('#ImageLoadingDiv').hide();
				ref.html(html);
			}
		  }
		});
	}

function savepage(code){
	document.cookie="referrer=job-board.php";
	document.cookie="last_srch="+getParameterByName('category');
	document.cookie="last_page="+last_page;
	document.cookie="last_page1="+last_page1;
	
	__urlHandler(code);
	//window.location.href='content.php?code='+code;
}
</script>
  </body>
</html>