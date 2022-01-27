<?php require_once("include/config.inc.php"); ?>
<?php require_once("include/constants.php"); ?>
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
				   <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="" />
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
<div class="container">

  <footer>

    <div class="ftr-flt-lft-col"> <!--img src="images/rec-member.jpg" alt="member" > </div-->

    <div class="ftr-flt-rit-col"> <a href="javascript:void(0)" onclick="__urlHandler('links')">Exclusive Links</a><a href="javascript:void(0)" onclick="__urlHandler('terms')">Terms &amp; Conditions</a><a href="javascript:void(0)" onclick="__urlHandler('company')">Company Profile</a><a href="javascript:void(0)" onclick="__urlHandler('candidates')">Candidate Info</a><a href="glossary.php">Glossary</a><a href="sitemap.php">Site Map</a><a href="blog.php" class="brdr-rit-none">Blog</a>

      <p  class="clearfix copyright">Copyright &copy; 2003-<?php echo date('Y'); ?>. All Rights Reserved. Powered by <a target="_blank" href="http://www.tenthmatrix.co.uk/" title="Tenthmatrix" class="powered-by-link"><img src="images/Powered-by-tenthmatrix.png" style="vertical-align:text-bottom;" alt="Tenthmatrix"></a> </p>

    </div>

  </footer>

</div>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 

<!-- Include all compiled plugins (below), or include individual files as needed --> 

<script src="js/jquery.bootstrap.newsbox.js"></script> 

<script src="js/bootstrap.min.js"></script> 

<script src="js/file-uploader.js"></script> 

  <script src="js/placeholder-patch.js"></script>

  <script src="js/jquery.validate.js"></script>

  <script src="js/additional-methods.js"></script>

  <script src="js/bootbox.min.js"></script>

<script type="text/javascript">


var cp_html='<form><script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>"><$script><div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div></form>';
cp_html = cp_html.replace("<$", "</"); 


function __urlHandler(codeStr, page, specialTag){

	page = typeof page !== 'undefined' ? page : false;

	specialTag = typeof specialTag !== 'undefined' ? specialTag : false;

	//console.log(page);

	var seofriendlyURlFlag= '<?php echo SEOFRIENDLYURLSBOOL;?>';

	if(seofriendlyURlFlag==true || seofriendlyURlFlag=="true"){

		var urlStr=codeStr+'.html';

		if(specialTag==true || specialTag=="true"){

			urlStr+='?'+ Math.random()+'#addBlogComment';

		}else if(page=="blog"){

			urlStr+='?'+ Math.random();

		}

		window.location.href=urlStr;

	}else{

		var urlStr='content.php?code='+codeStr;

		if(specialTag==true || specialTag=="true"){

			urlStr+='&'+ Math.random()+'#addBlogComment';

		}else if(page=="blog"){

			urlStr+='&'+ Math.random();

		}

		window.location.href=urlStr;

	}

}



function getCookie(cname) {

    var name = cname + "=";

    var ca = document.cookie.split(';');

    for(var i=0; i<ca.length; i++) {

        var c = ca[i];

        while (c.charAt(0)==' ') c = c.substring(1);

        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);

    }

    return "";

} 



function getParameterByName(name) {

    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");

    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),

        results = regex.exec(location.search);

    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));

}

 

$(document).ready(function(){



	$("#frm-contact-small").validate({

		ignore: ':hidden',

		  errorPlacement: function(error, element) {

			if (element.attr("name") == "file" ) {

			  error.insertAfter('.bootstrap-filestyle');

			} else {

			  error.insertAfter(element);

			}

		  },

		rules: {

			types: "required",

			name: "required",

			ph_no: "required",

			email: {

				required: true,

				email: true

			},

			//file: { extension: "docx|rtf|doc|pdf|odt" },

			message: "required",

			

			

		},

		messages: {

			types: "Please select what you are looking for",

			name: "Please enter your Name",

			ph_no: "Please enter your Phone Number",

			email: {

				required: "Please enter your E-mail",

				email: "Please enter valid E-mail"

			},

			//file: { extension: "Please select valid CV file" },

			message: "Please enter Message",

		},
		  submitHandler: function(form) {
		  
		  	if($('#types').val()=='Looking for work'){
				$("#frm-contact-small").attr('action', 'thankyou-candidate.php');
			}
			else{
				$("#frm-contact-small").attr('action', 'thankyou-employer.php');
			}
		  
		  	 if($('#file').val() !='' ){	
		  		form.submit();

				}

		else if($('#types').val()=='Looking for work'){

			bootbox.confirm('You have not attached a CV and you should only proceed this way if you are already successfully registered with the agency and are simply applying for jobs or if you are currently unable to attach one at this time and plan to do so later', function(result) {

			  //Example.show("Confirm result: "+result);

			  if(result){ form.submit(); }

			}); 


		}

		else{ form.submit(); }
		  
			
		  }

	});

	

	

	

	$("#frm-apply").validate({

		ignore: ':hidden',

		errorPlacement: function(error, element) {

			if (element.attr("name") == "file" ) {

			  error.insertAfter('.bootstrap-filestyle');

			} else {

			  error.insertAfter(element);

			}

		  },

		rules: {

			name: "required",

			ph_no: "required",

			email: {

				required: true,

				email: true

			},

			//file: { extension: "docx|rtf|doc|pdf|odt" },

			message: "required",

			

			

		},

		messages: {

			name: "Please enter your Name",

			ph_no: "Please enter your Phone Number",

			email: {

				required: "Please enter your E-mail",

				email: "Please enter valid E-mail"

			},

			//file: { extension: "Please select valid CV file" },

			message: "Please enter Message",

		},
		
		submitHandler: function(form) {
		  
		  	 if($('#file').val() !='' ){
			 //console.log($('#g-recaptcha-response').val());
			 if($('#g-recaptcha-response').val()==''){
			 bootbox.alert(cp_html, function(result) {
			 alert("submitting...");
			// form.submit();
			  });	
			}
			//

		}

		else{

			bootbox.confirm('You have not attached a CV and you should only proceed this way if you are already successfully registered with the agency and are simply applying for jobs or if you are currently unable to attach one at this time and plan to do so later', function(result) {

			  //Example.show("Confirm result: "+result);

			  if(result){ 
			  //form.submit(); 
			  
			  if($('#g-recaptcha-response').val()==''){
			 bootbox.alert(cp_html, function(result) {
			 alert("submitting...");
			// form.submit();
			  });	
			}
			  
			  }

			}); 

		}

		  
			
		  }

	});

	

	


});





</script>



<script type="text/javascript">

    $(function () {

        $(".latestVacaniesClass").bootstrapNews({

            newsPerPage: 2,

            autoplay: true,

			navigation: true,

			pauseOnHover:true,

            direction: 'up',

            newsTickerInterval: 4000,

            onToDo: function () {

                //console.log(this);

            }

        });

		    });

</script> 

<script type="text/javascript">   

$(document).ready(function() {   

	$('#types').change(function(){   

		if($('#types').val() === 'Looking for work'){   

			$('#1').show(500);    

   		} else {   

  			$('#1').hide(500);      

   		}   

	});   

}); 



function goback(){

	var coki_srch= getCookie('last_srch');

	var coki_page= getCookie('last_page');

	var back_to= getCookie('referrer');

	if(coki_srch!=''){

		back_to+='?category='+coki_srch;

	}

	document.cookie="back_to=yes";

	window.location.href= back_to;

} 





</script>



<?php $tokenGACode = __token_getValue($db, 'ga-code'); 

	if($tokenGACode!="" ){

		echo $tokenGACode;

	}else{	?>

		<script type="text/javascript">

 

   		var _gaq = _gaq || [];

   		_gaq.push(['_setAccount', 'UA-733244-1']);

   		_gaq.push(['_trackPageview']);

 

   		(function() {

     		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

     		ga.src = ('https:' == document.location.protocol ? 'https://ssl'

			: 'http://www') + '.google-analytics.com/ga.js';

     		var s = document.getElementsByTagName('script')[0];

			s.parentNode.insertBefore(ga, s);

  		 })();

 

		</script>

 <?php } ?>



 <!-- Google Code for Remarketing tag -->

<!-- Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. For instructions on adding this tag and more information on the above requirements, read the setup guide: google.com/ads/remarketingsetup -->

<script type="text/javascript">

/* <![CDATA[ */

var google_conversion_id = 1030112518;

var google_conversion_label = "YcIECOC4vAQQhoqZ6wM";

var google_custom_params = window.google_tag_params;

var google_remarketing_only = true;

/* ]]> */

</script>

<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">

</script>

<noscript>

<div style="display:inline;">

<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1030112518/?value=1.00&amp;currency_code=GBP&amp;label=YcIECOC4vAQQhoqZ6wM&amp;guid=ON&amp;script=0"/>

</div>

</noscript>



 
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
		  url: "include/json-sel-jobs.php?pageNum="+pageNum+"&mode=full",
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