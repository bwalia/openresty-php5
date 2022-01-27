<div class="container">

  <footer>

    <div class="ftr-flt-lft-col"> <!-- removed as per client email img src="images/rec-member.jpg" alt="member" --> </div>

   <div class="ftr-flt-rit-col"> <a href="javascript:void(0)" onClick="__urlHandler('links')">Exclusive Links</a><a href="javascript:void(0)" onClick="__urlHandler('terms')">Terms &amp; Conditions</a><a href="javascript:void(0)" onClick="__urlHandler('company')">Company Profile</a><a href="javascript:void(0)" onClick="__urlHandler('candidates')">Candidate Info</a><a href="glossary.php">Glossary</a><a href="sitemap.php">Site Map</a><a href="blog.php">Blog</a><a href="/privacy-policy.html" class="brdr-rit-none">Privacy Policy</a>


      <p  class="clearfix copyright">Copyright &copy; 2003-<?php echo date('Y'); ?>. All Rights Reserved. Powered by 
<!--<a target="_blank" href="http://www.tenthmatrix.co.uk/" title="Tenthmatrix" class="powered-by-link"><img src="images/Powered-by-tenthmatrix.png" style="vertical-align:text-bottom;" alt="Tenthmatrix"></a>-->
      <a href="https://www.jobshout.com/" class="poweredby" target="_blank" title="Jobshout" style="padding:4px;background-color:#fff;border-radius: 3px;"><img src="images/jobshout-powered-logo.gif" style="vertical-align:text-bottom;height: 15px;" alt="Jobshout"/></a> | 
<?php if(isset($headerFootertokenAddr) && $headerFootertokenAddr!="" ){ 

		echo $headerFootertokenAddr; 

	}else{	?>

239 High Street Kensington, London. W8 6SN

<?php } ?></p>

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
  <script src="js/jquery.loading.js"></script>

<?php
$tokenFooterScriptStr = __token_getValue($db, 'seo-footer-script'); 
if(isset($tokenFooterScriptStr) && $tokenFooterScriptStr!="" ){ 
	echo $tokenFooterScriptStr; 
}
?>
<script type="text/javascript">


var cp_html=''; 


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

function set_qus(){
	$.ajax({
	  type : "GET",
	  url: "include/set-qus.php",
	  cache: false,
	  success: function(html){
		//alert(html);return false;
		if(html){
			cp_html='<form id="frm-qus"><label>What\'s '+html+' = </label><input id="txt_answer" name="txt_answer" type="text" class="form-control" /></form>';
		}
	  }
	});

}

 

$(document).ready(function(){


set_qus();
	


var sub_without_cv=false;


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
		  		continue_submit(form);

				}

		else if($('#types').val()=='Looking for work'){
			if(!sub_without_cv){
			bootbox.confirm('You have not attached a CV and you should only proceed this way if you are already successfully registered with the agency and are simply applying for jobs or if you are currently unable to attach one at this time and plan to do so later', function(result) {

			  //Example.show("Confirm result: "+result);

			  if(result){ sub_without_cv=true; continue_submit(form); }

			}); 
			}
			else{ continue_submit(form); }

		}

		else{ continue_submit(form); }
		  
			
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

			continue_submit(form);
		}

		else{
			if(!sub_without_cv){
			bootbox.confirm('You have not attached a CV and you should only proceed this way if you are already successfully registered with the agency and are simply applying for jobs or if you are currently unable to attach one at this time and plan to do so later', function(result) {

			  //Example.show("Confirm result: "+result);

			  if(result){ 
			  //form.submit(); 
			  sub_without_cv=true;
			  
			  continue_submit(form);
			  
			  }

			}); 
			}
			else{
			 continue_submit(form);
			}

		}

		  
			
		  }

	});

	
	$(document).on('submit', '#frm-qus', function(event){
		event.preventDefault();
		$('.btn-primary').trigger('click');
	});
	
	
	$(document).on('keyup, blur, change', '#txt_answer', function(event){
		$('#answer').val($(this).val());
	});


});


function continue_submit(form){
	if($('#answer').val()==''){
		bootbox.confirm({
			title: 'Prove you\'re not a Robot',
			message:cp_html, 
			size:'small', 
			callback: function(result) {		
				if(result){		
					$('#frm-qus').validate({
						rules: { txt_answer: { required: true, number: true } },
						messages: { txt_answer: { required: "Please enter Answer", number: "Please enter only numeric values" } },
					});			
					if($('#frm-qus').valid()){
						$('body').loading({
							overlay: $("#custom-overlay")
						  });
						$.ajax({
						  type : "POST",
						  data: { answer: $('#answer').val() },
						  dataType: 'json',
						  url: "include/check-qus.php",
						  cache: false,
						  success: function(html){
							//alert(html);return false;
							
							if(html.success){
								
								form.submit();
							}
							else{
								$('body').loading('stop');
								$('#frm-qus').prepend('<label class="error" >*'+html.error+'</label>');
								//alert(html.error);
								$('#answer').val('');
								
							}
						  }
						});
						return false;
					}
					else{
						return false;
					}
				}
				else{
					set_qus();
				}
			},
		});	
	}
	else{
		form.submit();
	}
}


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
		sub_without_cv=false;
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
	if(back_to==""){
		back_to="job-board.php";
	}
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