<?php require_once("include/cache_start.php"); ?>
<?php require_once("include/lib.inc.php"); ?>
<?php include_once("include/main-header.php"); ?>
  <link rel="canonical" href="<?php echo SITE_PATH;?>/sitemap.php" /> 
  <style>
  .page-content h4{
  font-family: "museo_sans_cyrl100";
font-size: 24px;
font-weight: 400;
margin-top: 0px;
margin-bottom: 15px;
line-height: 33px;
  }
  
 .page-content h4 a{
	 padding-left:5px;
	 text-decoration:none;
	 display:block;
	 color:#fff;
	 line-height: 33px;
	 
 }
 
 .page-content h4 a:hover{
	 background: #9b8d4d!important;
	color: #fff;
	text-decoration: none;
 }
  </style>
  </head>
  <body>
    <?php include_once("include/top-header.php"); ?>
    <div class="container page-content">
   	    <div class="row">
        	<div class="col-sm-12 ">
        	<h4><a href="index.php" title="Home">Home</a></h4> 
        	<h4><a href="blog.php" title="Blog">Blog</a></h4>
			<h4><a href="contact.php" title="Contact Us">Contact Us</a></h4> 
			<h4><a href="glossary.php" title="Glossary">Glossary</a></h4>
			
			<?php
			$query = "SELECT * FROM documents WHERE Type='job' and Status=1 AND SiteID=".SITE_ID." Order by ID desc";
		
		$db->query('SET NAMES utf8');
		$dbResultsData = $db->get_results( $query );
		?>
           <h2>Job Index, showing <?php echo count($dbResultsData); ?> Jobs</h2> 
           <div class="row">
           <div class="col-md-12">
        <?php
		
        if(count($dbResultsData)>0){
		?>
         <ul class="jobs-cat">
        <?php
		for( $j=0; $j <= count($dbResultsData)-1; $j++ ){
		?>
          <li><a href="javascript:void(0)" onClick="savepage('<?php echo $dbResultsData[$j]->Code; ?>')" title="<?php echo $dbResultsData[$j]->Document; ?>"><?php echo $dbResultsData[$j]->Document; ?></a></li>
  <?php } ?>
         </ul>
	<?php } ?>
          </div>
      </div>      
           
            </div>
           
           
           <div class="col-sm-12 ">
		   <?php
			$query = "SELECT * FROM documents WHERE Type='page' and Status=1 AND SiteID=".SITE_ID." Order by ID desc";
		
		$db->query('SET NAMES utf8');
		$dbResultsData = $db->get_results( $query );
		?>
           <h2 style="margin-top:15px;" >Site Index, showing <?php echo count($dbResultsData); ?> Pages</h2> 
           <div class="row">
           <div class="col-md-12">
        <?php
         if(count($dbResultsData)>0){
		?>
         <ul class="jobs-cat">
        <?php
		for( $j=0; $j <= count($dbResultsData)-1; $j++ ){
		?>
          <li><a href="javascript:void(0)" onclick="__urlHandler('<?php echo $dbResultsData[$j]->Code; ?>')" title="<?php echo $dbResultsData[$j]->Document; ?>"><?php echo $dbResultsData[$j]->Document; ?></a></li>
  <?php } ?>
         </ul>
	<?php } ?>

          </div>
      </div>      
           
            </div>
            <!--blogs-->
            <?php
			$blogquery = "SELECT * FROM documents WHERE Type='blog' and Status=1 AND SiteID=".SITE_ID." Order by ID desc";
			$db->query('SET NAMES utf8');
			$dbBlogsData = $db->get_results( $blogquery );
			if(count($dbBlogsData)>0){
			?>
            <div class="col-sm-12 ">
		  		<h2 style="margin-top:15px;" >Blog Index, showing <?php echo count($dbBlogsData); ?> Blog(s)</h2> 
          		<div class="row">
           			<div class="col-md-12">
                		<ul class="jobs-cat">
        				<?php	for( $j=0; $j <= count($dbBlogsData)-1; $j++ ){	?>
          				<li><a href="content.php?code=<?php echo $dbBlogsData[$j]->Code; ?>.html" title="<?php echo $dbBlogsData[$j]->Document; ?>"><?php echo $dbBlogsData[$j]->Document; ?></a></li>
  						<?php } ?>
         				</ul>
					</div>
      			</div>      
           </div>
           <?php } ?>
            </div>
       </div>
     <?php include_once("include/footer.php"); ?>
<script type="text/javascript">
function savepage(code){
	document.cookie="referrer=sitemap.php";
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