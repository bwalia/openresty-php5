<?php $curr_file=basename($_SERVER['PHP_SELF']);
if($curr_file=="content.php" && isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']!=""){
	$curr_file .= '?'.$_SERVER['QUERY_STRING'];
}
$headerFootertokenAddr = __token_getValue($db, 'header-addr');
$tokenPhone = __token_getValue($db, 'telephone'); 
$tokenEmail = __token_getValue($db, 'admin-email');
?>



<header>

  <div class="hdr-inr-bdr">

    <div class="container" style="position:relative;">

      <div class="row">

        <div class="col-sm-3 col-md-3 logo"> <a href="index.php"><img src="images/logo.png" alt="Marshall Harber"></a> </div>

        <div class="col-sm-9 col-md-9  hdr-address-blk">

          <p class="hidden-xs">
          <?php  if($headerFootertokenAddr!="" ){ 
				echo $headerFootertokenAddr; 
			}else{	?>
			239 High Street Kensington, London. W8 6SN
			<?php } ?><br/>

            <?php 	if($tokenPhone!="" ){ 
				echo $tokenPhone; 
			}else{	?>
				+44 (0) 20 7938 2200
			<?php } ?><br/>
			<?php  if($tokenEmail=="" ){ 
				$tokenEmail="info@marshallharber.com"; 
			} ?>
			<a href="mailto:<?php echo $tokenEmail; ?>"><?php echo $tokenEmail; ?></a></p>
			<p class="visible-xs">
          	<?php  if($headerFootertokenAddr!="" ){ 
				echo $headerFootertokenAddr; 
			}else{	?>
			239 High Street Kensington, London. W8 6SN
			<?php } ?>

            <?php 	if($tokenPhone!="" ){ 
				echo $tokenPhone; 
			}else{	?>
				+44 (0) 20 7938 2200
			<?php } ?><br/>
			<?php  if($tokenEmail=="" ){ 
				$tokenEmail="info@marshallharber.com"; 
			} ?>
			<a href="mailto:<?php echo $tokenEmail; ?>"><?php echo $tokenEmail; ?></a></p>
        </div>

      </div>

      <div class="row">

        <div class="navbar navbar-default" role="navigation">

          <div class="navbar-header">

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>

          </div>

          <div class="navbar-collapse collapse" >

            <ul class="nav navbar-nav"  style="margin-bottom:0px; padding-bottom:0px;">

              <li <?php if($curr_file=="index.php") { ?> class="active" <?php }?>><a href="index.php">Home</a></li>

              <li <?php if($curr_file=="content.php?code=our-services" || $curr_file=="content.php?code=our-services.html" || $curr_file=="our-services.html" ) { ?> class="active" <?php }?>><a href="javascript:void(0)" onclick="__urlHandler('our-services')">Our Services</a></li>

              <li <?php if($curr_file=="job-board.php") { ?> class="active" <?php }?>><a href="job-board.php">Job Board </a></li>

              <li <?php if($curr_file=="content.php?code=clients"  || $curr_file=="content.php?code=clients.html"  || $curr_file=="clients.html") { ?> class="active" <?php }?>><a href="javascript:void(0)" onclick="__urlHandler('clients')">Client Info </a></li>

              <li <?php if($curr_file=="content.php?code=candidates"  || $curr_file=="content.php?code=candidates.html"  || $curr_file=="candidates.html") { ?> class="active" <?php }?>><a href="javascript:void(0)" onclick="__urlHandler('candidates')">Candidate Info</a></li>

              <li <?php if($curr_file=="content.php?code=company"  || $curr_file=="content.php?code=company.html"  || $curr_file=="company.html") { ?> class="active" <?php }?>><a href="javascript:void(0)" onclick="__urlHandler('company')">Company Profile</a></li>

              <li <?php if($curr_file=="contact.php") { ?> class="active" <?php }?>><a href="contact.php">Contact Us</a></li>

            </ul>

          </div>

        </div>

      </div>

      <ul class=" navbar-nav social-blk">

     	 <!--<li class="dropdown">

						<a class="dropdown-toggle" href="#" data-toggle="dropdown" title="Search Jobs"><img src="images/search.png"></strong></a>

						<div class="dropdown-menu search-form search-form-width" >

                        <h2>Search for Job</h2>

							<form method="get" action="search-results.php" id="frm-srch" accept-charset="UTF-8">

								<input type="text" placeholder="Search term" id="srch" name="srch" value="<?php if(isset($_GET['srch'])){ echo $_GET['srch']; } ?>"><input type="text" placeholder="Location" id="loc" name="loc" value="<?php if(isset($_GET['loc'])){ echo $_GET['loc']; } ?>">

								<input  type="submit" id="sign-in" value="Search">

							</form>

						</div>

					</li>-->

         

        <li><a target="_blank" href="https://www.facebook.com/pages/Marshall-Harber-Exclusive-Household-Staffing/73230103320" title="Facebook"><img alt="Facebook" src="images/facebook.png"></a></li>

        <li><a target="_blank" href="https://twitter.com/intent/follow?source=followbutton&amp;variant=1.0&amp;screen_name=marshallharber" title="Twitter"><img alt="Twitter" src="images/twitter.png" ></a></li>

        <!--li><a target="_blank" href="https://plus.google.com/+MarshallHarberExclusiveHouseholdStaffingLondon" title="Google Plus"><img alt="GooglePlus" src="images/google-plus.png"></a></li-->

        <li><a target="_blank" href="https://www.linkedin.com/company/private-household" title="Linkedin"><img alt="LinkedIn" src="images/linkdin.png"></a></li>

      </ul>

    </div>

  </div>

</header>
