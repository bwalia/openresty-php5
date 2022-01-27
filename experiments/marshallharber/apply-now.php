<?php require_once("include/lib.inc.php"); ?>
<?php
$catcode='';
if(isset($_GET['category']) && $_GET['category']!=''){
	$catcode= $_GET['category'];
}

?>
<?php include_once("include/main-header.php"); ?>
<link rel="canonical" href="<?php echo SITE_PATH;?>/apply-now.php" />
</head>
<body>
<?php include_once("include/top-header.php"); ?>
<div class="container page-content">
  <div class="row"> 
  		
    	    <div class="col-sm-8 col-md-9 col-md-push-3 col-sm-push-4 ">
			<h2 id="title" style="display:none;">Enter your details below and then click Submit Application</h2>
			<h2 id="title">Your Application</h2>
			<a href="javascript:void(0)" onClick="goback()" id="addmore1" class="btn white-btn mrgnBtm15 jobslist">Add more Jobs</a>
			<!--a href="javascript:void(0)" onClick="submitApplication()" id="submitApplication1" class="btn white-btn mrgnBtm15 jobslist">Proceed to Job Application Form</a-->
			<br/>
			<div id="ImageLoadingDiv" style=" text-align:center; display: block; margin-bottom:30px; margin-top:20px;" class="col-md-6 jobslist">
	Loading...<br />
    <img id="imgAjaxLoading" src="images/loading-3.gif"  style="border-width: 0px;">
 </div>

<div id="jobs_area" class="jobslist">
			
</div>
             
                  <a href="javascript:void(0)" onClick="goback()" id="addmore2" style="display:none;" class="btn white-btn mrgnBtm15 jobslist">Add more Jobs</a>
                  <!--a href="javascript:void(0)" onClick="submitApplication()" id="submitApplication2"  class="btn white-btn mrgnBtm15 jobslist">Proceed to Job Application Form</a-->
                  <div class="clearfix"></div>
        <div class="thumbnail contact-us-blk col-md-6" style="margin-top:0px;" >
                     <div class="text-right" style="margin-right:3%; color:#000;" ><small><em><sup class="required">*</sup>required fields</em></small></div>
                     <!--<form class="cont-form">
                               <input type="text" class="form-control "  placeholder="Name"><span class="small-req">*</span>   
                               <input type="email" class="form-control small-field"  placeholder="Email Address"><span class="small-req">*</span>   
                               <input type="text" class="form-control small-field"  placeholder="Home Telephone">
                               <input type="text" class="form-control small-field"  placeholder="Daytime Telephone">
                               <input type="text" class="form-control small-field"  placeholder="Mobile">
                               <div class="small-field"> <input type="file" class="filestyle"  data-buttonBefore="true" placeholder="Mobile"></div>  <span class="small-req">*</span>    
                               <textarea class="form-control small-field" rows="3" placeholder="Message" ></textarea>  <span class="small-req">*</span>                            
                  			   <input type="submit" class="btn btn-default"  value="Send Application" style="margin-right:3%"> <br/>
                               <div class="clearfix"></div>
                              <label style="color:#000; font-weight:normal; font-size:12px;"><input type="checkbox"  value="1"> I am happy to receive occasional emails on vacanices that may be of interest.</label>
     			   </form>-->
                   <form class="cont-form" enctype="multipart/form-data" id="frm-apply" method="post" action="thankyou-candidate.php">
				   <input type="hidden" name="form_type" id="form_type" value="apply" />
				   <input type="hidden" name="answer" id="answer" value=""/>
							  <input type="hidden" name="types" id="types" value="Looking for work" />
                               <input type="text" class="form-control "  placeholder="Name*" name="name" id="name">  
                               <input type="email" class="form-control "  placeholder="Email Address*" name="email" id="email">  
                               <input type="text" class="form-control "  placeholder="Home Telephone*" name="ph_no" id="ph_no" >
                               <input type="text" class="form-control "  placeholder="Daytime Telephone" name="day_no" id="day_no" >
                               <input type="text" class="form-control "  placeholder="Mobile" name="mob_no" id="mob_no">
                               <div class=""> <input type="file" class="filestyle"  data-buttonBefore="true" name="file" id="file" ></div>     
                               <textarea class="form-control " rows="3" placeholder="Message*" name="message" id="message" ></textarea>                             
                  			   <input type="submit" class="btn btn-default"  value="Submit Application" id="btn_submit"> <br/>
                               <div class="clearfix"></div>
                              <label style="color:#000; font-weight:normal; font-size:12px;"><input type="checkbox"  value="1" name="occ_mail" id="occ_mail"> I am happy to receive occasional emails on vacanices that may be of interest.</label>
     			   </form>
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
function submitApplication(){
	$("#name").focus();
	$('.jobslist').remove();
	$('#title').show();
}

$(document).ready(function(){
		$.movePage(1, $('#jobs_area'));
	});

	$.movePage = function movePage(pageNum, ref){
		$('#jobs_area').html("");
		$('#ImageLoadingDiv').show();

		$.ajax({
		  type : "GET",
		  url: "json-sel-jobs.php?pageNum="+pageNum+"&mode=full",
		  cache: false,
		  success: function(html){
			//alert(html);return false;
			if(html!='no'){
				$('#ImageLoadingDiv').hide();
				$('#jobs_area').html(html);
				if($('#jobs_area').find('.job-summary').length){ $('#addmore2').show(); }
				else{
					$('#addmore2').remove();
					$('#submitApplication2').remove();
				}
			}
		  }
		});
	}

function nosavepage(code){
	document.cookie="last_srch=";
	document.cookie="last_page=1";
	document.cookie="last_page1=1";
	__urlHandler(code);
	//window.location.href='content.php?code='+code;
}
</script>
</body>
</html>