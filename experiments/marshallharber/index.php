<?php
require_once("include/cache_start.php");
require_once("include/lib.inc.php");

$tokenWindowStr = __token_getValue($db, 'google-site-verification'); 
if(isset($tokenWindowStr) && $tokenWindowStr!="" ){ 
	$pGoogleSiteVerificationTxt= $tokenWindowStr; 
}

//title
$tokenWindowStr = __token_getValue($db, 'home-page-windowtitle'); 
if(isset($tokenWindowStr) && $tokenWindowStr!="" ){ 
	$pWindowTitleTxt= $tokenWindowStr; 
}

//meta description
$tokenMetaDescStr = __token_getValue($db, 'home-page-metadescription'); 
if(isset($tokenMetaDescStr) && $tokenMetaDescStr!="" ){ 
	$pMetaDescriptionTxt= $tokenMetaDescStr; 
}

$tokenMetaKeywordsStr = __token_getValue($db, 'home-page-metakeywords'); 
if(isset($tokenMetaKeywordsStr) && $tokenMetaKeywordsStr!="" ){ 
	$pMetaKeywordsTxt= $tokenMetaKeywordsStr; 
}

include_once("include/main-header.php"); ?>

<link rel="canonical" href="<?php echo SITE_PATH;?>/index.php" />

 <style>

	@media (max-width:767px) {	

	 .sm-img-bg{

		text-align:center;

		max-width:600px;	

		margin: 0 auto;

		}

	 }

	</style>

</head>

<body>

<?php include_once("include/top-header.php"); ?>

<div class="container">

  <div class="row"   style="margin-top:24px;">

    <div class="col-sm-12 col-md-9 ">

      <div class="row" >

        <div class="col-sm-4 "> 

            <div class="sm-img-bg">

              <img src="images/candidates.jpg" class="img-responsive" alt="Candidates">

              <div  class="services-hding "><a href="javascript:void(0)" onClick="__urlHandler('candidates')">Candidates</a></div>

            </div>

        </div>

        <div class="col-sm-4 ">

        <div class="sm-img-bg"> 

        	<img src="images/services.jpg"  class="img-responsive" alt="Services">

            <div  class="services-hding "><a href="javascript:void(0)" onClick="__urlHandler('our-services')">Our Services</a></div>

          </div>  

         

        </div>

        <div class="col-sm-4 "> 

         <div class="sm-img-bg">

         	<img src="images/clients.jpg"  class="img-responsive" alt="Clients">

        	  <div  class="services-hding "><a href="javascript:void(0)" onClick="__urlHandler('clients')">Clients</a></div>

          </div>    

        </div>

      </div>

      <div style="text-align:center;">

        <h1 class="indx-pg-hding">Household Staff Recruitment </h1>

      </div>

      

<div class="seo-links"  >				

				<?php $tokenMainContent = __token_getValue($db, 'index-page-cats'); 

if($tokenMainContent!="" ){ 

		echo $tokenMainContent; 

	}else{	?>

<a href="housekeeper.html">HOUSEKEEPERS</a>

<a href="butler.html">BUTLERS</a> 

<a href="valet.html">VALETS</a> 

<a href="chauffeur.html">CHAUFFEURS</a> 

<a href="domestic-couple.html">DOMESTIC COUPLES</a> 

<a href="gardener.html">GARDENERS</a> 

<a href="estate-manager.html">ESTATE MANAGERS</a> 

<a href="chef-cook.html">HANDYMEN</a> 

<a href="lady-s-maid.html">LADIES MAIDS</a> 

<a href="house-manager.html">HOUSE  MANAGERS</a> 

<a href="personal-assistant.html">PERSONAL ASSISTANTS</a> 

<a href="daily-cleaner.html">DAILY  CLEANERS</a> 

<a href="chef-cook.html">CHEFS & COOKS</a>

<?php

 } 

?>

</div>	  

	  

	  

<p class="intro-para"><?php $tokenMainContent = __token_getValue($db, 'home-page-main-content'); 

if($tokenMainContent!="" ){ 

		echo $tokenMainContent; 

}else{	?>

Our consultants have a true understanding of how difficult it can be to find the right member of staff for a household. Having worked in private service themselves, they have a unique advantage in being able to assist both candidates and clients find the perfect match.

<?php

 } 

?></p>

    </div>

    <div class="col-sm-12 col-md-3">

      <?php include_once("include/contactus-small.php"); ?>

      <!--<div class="thumbnail" style="padding:10px; border:0px; background:#3e5780; margin-top:15px; margin-bottom:15px;">

                 

                 </div>-->

      <?php include_once("include/latest-vacancies.php"); ?>

    </div>

  </div>

</div>

<?php include_once("include/footer.php"); ?>



<script type="text/javascript">

function savepage(code){

	document.cookie="referrer=job-board.php";

	document.cookie="last_srch=";

	document.cookie="last_page=1";

	document.cookie="last_page1=1";

	__urlHandler(code);

	//window.location.href='content.php?code='+code;

}

</script>

</body>

</html>

<?php

require_once("include/cache_end.php");

?>