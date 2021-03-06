<?php require_once("include/cache_start.php"); ?>
<?php require_once("include/lib.inc.php"); ?>
<?php 
//title
$tokenWindowStr = __token_getValue($db, 'contact-page-windowtitle'); 
if(isset($tokenWindowStr) && $tokenWindowStr!="" ){ 
	$pWindowTitleTxt= $tokenWindowStr; 
}

//meta description
$tokenMetaDescStr = __token_getValue($db, 'contact-page-metadescription'); 
if(isset($tokenMetaDescStr) && $tokenMetaDescStr!="" ){ 
	$pMetaDescriptionTxt= $tokenMetaDescStr; 
}

//meta keywords
$tokenMetaKeywordsStr = __token_getValue($db, 'contact-page-metakeywords'); 
if(isset($tokenMetaKeywordsStr) && $tokenMetaKeywordsStr!="" ){ 
	$pMetaKeywordsTxt= $tokenMetaKeywordsStr; 
}

include_once("include/main-header.php"); ?>

  <link rel="canonical" href="<?php echo SITE_PATH;?>/contact.php" />
  </head>
  <body>
  
<?php include_once("include/top-header.php"); ?>
    <div class="container page-content">
    
    <h1>Contact</h1> 
    <div style="margin-bottom:25px;">
   	<!--<iframe src="https://www.google.com/maps/d/u/0/embed?mid=zKIBMcOP5Bkw.k1OvKT5HpigI" style="border:0; min-height:300px; width:100%"></iframe>-->
	<!--<iframe src="https://www.google.com/maps/d/u/0/embed?mid=zHc2ekPj_Y6k.kh1oXdXSwnnM&z=16" style="border:0; min-height:300px; width:100%"></iframe> // changed to new address
-->
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2482.323597907845!2d-0.0858356835640276!3d51.525624317190456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48760ff151314dbf%3A0xe38f46193621c1c1!2sMarshall%20Harber!5e0!3m2!1sen!2sbe!4v1628769620658!5m2!1sen!2sbe" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

<!--iframe src="https://www.google.com/maps/d/u/0/embed?mid=1cMFQu2FtsX_9xRj1QSe-gDbwOUE&z=16" style="border:0; min-height:300px; width:100%"></iframe-->
    </div>
   	    <div class="row" id="content-part">
        	<div class=" col-sm-4 col-md-4">
             <h2 class="hding-brdr-none">Head Office</h2>
<p><?php $tokenAddr = __token_getValue($db, 'contact-page-address'); 
if($tokenAddr!="" ){ 
		echo $tokenAddr; 
	}else{	?>
Marshall Harber Associates Ltd<br/>
239 High Street Kensington,<br/>
Kensington,<br/>
London.<br/>
W8 6SN<br/>
<?php
 } 
?>

<?php $tokenPhone = __token_getValue($db, 'telephone'); 
if($tokenPhone=="" ){ 
		$tokenPhone="+44 (0)20 7938 2200"; 
	} ?>
	
<?php $tokenFax = __token_getValue($db, 'fax'); 
if($tokenFax=="" ){ 
		$tokenFax="+44 (0)20 7113 2005"; 
	} ?>
	
<?php $tokenEmail = __token_getValue($db, 'admin-email'); 
if($tokenEmail=="" ){ 
		$tokenEmail="info@marshallharber.com"; 
	} ?>
	
	
Tel:  <a href="tel://<?php echo str_replace(' ','',$tokenPhone); ?>" class="hightlight-link"><?php echo $tokenPhone; ?></a><br/>
Fax:  <a href="tel://<?php echo str_replace(' ','',$tokenFax); ?>" class="hightlight-link"><?php echo $tokenFax; ?></a><br/>
eMail: <a href="mailto:<?php echo $tokenEmail; ?>" class="hightlight-link"><?php echo $tokenEmail; ?></a>
</p>
<p class="other-loc">
<span style="opacity:0.7"><!--Marshall Harber now has consultants based inBath Office:--></span><br/>
<?php $tokenConsul = __token_getValue($db, 'contact-page-consultant'); 
if($tokenConsul!="" ){ 
		//echo $tokenConsul; 
	}else{	?>
Bath, Somerset<br/>
Henley-on-Thames, Oxfordshire<br/>
Grantham, Licolnshire
<?php
 } 
?>

</p>
            </div>
            <div class="col-sm-offset-2 col-sm-6 col-md-offset-2 col-md-6 col-lg-offset-4 col-lg-4">
              <p>Please use the contact form below.  Fields marked with a <sup class="required">*</sup> are required to help us answer your query.</p>
          <!--<div class="thumbnail contact-us-blk  col-md-81" style="margin-top:0px;">
        
           <form class="form-horizontal cont-us-pg-form " >
             <div class="form-group">
    			<label for="" class="col-sm-4 col-md-4 control-label">I am (please select) <sup>*</sup></label>
    		    <div class="col-sm-8 col-md-8  ">
            			<select class="form-control" style="border-radius:2px;">
                             
                             <option>Looking for work</option>
                             <option>An Employer</option>
                        </select>
                 </div>
             </div>
           	<div class="form-group">
                 <label for="name" class="col-sm-4 col-md-4  control-label">Name <sup>*</sup></label>
                 <div class="col-sm-8 col-md-8 ">
                 <input type="text" class="form-control" id="name">
   		  		</div>
  			</div>
            <div class="form-group">
                 <label for="company" class="col-sm-4 col-md-4 control-label">Company</label>
                 <div class="col-sm-8 col-md-8 ">
                 <input type="text" class="form-control" id="company">
   		  		</div>
  			</div>
  			<div class="form-group">
   				 <label for="inputEmail3" class="col-sm-4 col-md-4 control-label">Email <sup>*</sup></label>
                <div class="col-sm-8 col-md-8  ">
                  <input type="email" class="form-control" id="inputEmail3" >
                </div>
  			</div>
  		  <div class="form-group">
   			   <label for="telephone" class="col-sm-4 col-md-4 control-label">Telephone <sup>*</sup></label>
                <div class="col-sm-8 col-md-8  ">
                  <input type="text" class="form-control" id="">
                </div>
  			</div>
            <div class="form-group">
   			   <label for="telephone" class="col-sm-4 col-md-4  control-label">Moblie</label>
                <div class="col-sm-8 col-md-8  ">
                  <input type="text" class="form-control" id="">
                </div>
  			</div>
             <div class="form-group">
   			   <label for="telephone" class="col-sm-4 col-md-4 control-label">Message <sup>*</sup></label>
                <div class="col-sm-8 col-md-8  ">
  				 <textarea class="form-control" rows="3" ></textarea>
                 </div>
              </div>   
  			<div class="form-group">
   				 <div class="col-sm-offset-4 col-sm-8 col-md-8   text-right">
      			<button type="submit" class="btn  send-btn">Send Email</button>
    </div>
  </div>
</form>
</div>-->
  <!--<p>Please use the contact form below. Fields marked with a <span class="req-lbl">*</span> are required to help us answer your query.</p>-->
<div class="thumbnail contact-us-blk  col-md-81" style="margin-top:0px;" >
                                        <!-- <form class="form-horizontal cont-form">
                                           <select class="form-control small-field" style="border-radius:2px;" id="types" name="types" >
                                 					<option>I am (please select)</option>
                                 					<option value="Looking for work">Looking for work</option>
                                 					<option value="An Employer">An Employer</option>
                            				  </select> <span  class="small-req">*</span> 
                                              <input type="text" class="form-control small-field"   placeholder="Name"><span class="small-req" >*</span>
                                              <input type="text" class="form-control small-field" id="company" placeholder="Company" >   
                                              <input type="email" class="form-control small-field" id="email" placeholder="Email">  	<span  class="small-req">*</span>	  
                                              <input type="text" class="form-control small-field"  placeholder="Phone Number"><span  class="small-req">*</span>
                                              <input type="text" class="form-control small-field"  placeholder="Mobile Number"> 
                                              <div class="clearfix"></div>
                                             <div id="1"  style="display: none;" class="clearfix">  <div  class="small-field"> <input type="file" class="filestyle"  data-buttonBefore="true" >   </div>  <span  class="small-req">*</span>   </div>                        
                                              <textarea class="form-control small-field" rows="3" placeholder="Message"></textarea><span class="small-req">*</span> 	
                                              <input type="submit" class="btn btn-default clearfix" value="Submit" style="margin-right:3%">
             							</form>-->
                                         <form class="form-horizontal cont-form" id="frm-contact-small" enctype="multipart/form-data" method="post" >
										 <input type="hidden" name="form_type" id="form_type" value="enquiry" />
										 <input type="hidden" name="answer" id="answer" value=""/>
                                              <select class="form-control " style="border-radius:2px; padding-top:2px; padding-bottom:2px;" id="types" name="types" >
                                 					<option value="">I am (please select)*</option>
                                 					<option value="Looking for work">Looking for work</option>
                                 					<option value="An Employer">An Employer</option>
                            				  </select> 
                                              <input type="text" class="form-control" placeholder="Name*" id="name" name="name" >
                                              <input type="text" class="form-control" placeholder="Company" id="company" name="company" >   
                                              <input type="email" class="form-control" placeholder="Email*" id="email" name="email" >    
                                              <input type="text" class="form-control"  placeholder="Phone Number*" id="ph_no" name="ph_no" >
                                              <input type="text" class="form-control"  placeholder="Mobile Number" id="mob_no" name="mob_no" > 
                                              <div class="clearfix"></div>
                                             <div id="1"  style="display: none;" class="clearfix">  <div  class=""> <input type="file" class="filestyle"  data-buttonBefore="true" id="file" name="file" >   </div>     </div>                        
                                              <textarea class="form-control " rows="3" placeholder="Message*" id="message" name="message"></textarea>	
                                              <input type="submit" class="btn btn-default clearfix" value="Submit" id="btn_submit" >
             							</form>
            </div>
        </div>
    </div>
   </div>   
<?php include_once("include/footer.php"); ?>
    </body>
</html>
<?php
require_once("include/cache_end.php");
?>