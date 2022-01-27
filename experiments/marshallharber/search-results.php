<?php require_once("include/lib.inc.php"); ?>
<?php
$srch='';
$loc='';
if(isset($_GET['srch']) && $_GET['srch']!=''){
	$srch= $_GET['srch'];
}
if(isset($_GET['loc']) && $_GET['loc']!=''){
	$loc= $_GET['loc'];
}


?>
<?php include_once("include/main-header.php"); ?>
   
  </head>
  <body>
  
   <?php include_once("include/top-header.php"); ?>
    <div class="container page-content">
   	    <div class="row">
                   	<!--	<h1 class="mrgn-lft-rit15">Job Board</h1> -->
                    <div class="col-sm-8 col-md-9 col-md-push-3 col-sm-push-4 ">
                  	
                  	 
                    
                    <div class="row">
                      <div class="col-md-8">
                      <h2>Search results<?php if($srch!=''){ echo ' for '.$srch; } ?><?php if($loc!=''){ echo ' in '.$loc; } ?></h2>
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
                              <form class="cont-form" enctype="multipart/form-data" id="frm-apply">
          <h2>Apply to Register</h2>
           <div class="text-right" style="color:#000;" ><small><em><sup class="required">*</sup>All fields are required.</em></small></div>
          		 <input type="text" class="form-control"  placeholder="Name" name="name" id="name">
         		 <input type="text" class="form-control"  placeholder="Phone Number" name="ph_no" id="ph_no">
         		 <input type="email" class="form-control"  placeholder="Email" name="email" id="email">
                 <input type="file" class="filestyle"  data-buttonBefore="true" name="file" id="file" >
          <textarea class="form-control" rows="3" placeholder="Message" name="message" id="message" ></textarea>
          <input type="submit" class="btn btn-default" value="Submit" id="btn_submit"> 
        </form>
               	        </div>
						
						
						<h5 >Jobs attached to your application:</h5>
						
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
$(document).ready(function(){
		$.movePage(1, $('#content_area'));
		$.movePage(1, $('#jobs_area'));
	});

	$.movePage = function movePage(pageNum, ref){
	
	
		ref.html("");
		//$('#ImageLoadingDiv').show();
		var url='';
		if(ref.attr('id')=='content_area'){
			url= "include/json-jobs.php?pageNum="+pageNum+"&srch=<?php echo $srch; ?>"+"&loc=<?php echo $loc; ?>";
		}
		else{
			url= "include/json-sel-jobs.php?pageNum="+pageNum+"&mode=sidebar";
		}

		$.ajax({
		  type : "GET",
		  url: url,
		  cache: false,
		  success: function(html){
			//alert(html);return false;
			if(html!='no'){
				//$('#ImageLoadingDiv').hide();
				ref.html(html);
			}
		  }
		});
	}

</script>
  </body>
</html>