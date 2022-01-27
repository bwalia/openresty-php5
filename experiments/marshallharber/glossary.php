<?php require_once("include/lib.inc.php"); ?>
<?php include_once("include/main-header.php"); ?>
   <link rel="canonical" href="<?php echo SITE_PATH;?>/glossary.php" />
  </head>
  <body>
    <?php include_once("include/top-header.php"); ?>
    <div class="container page-content">
   	    <div class="row">
        	
           
           
           <div class="col-sm-12 ">
		   <?php
			$query = "select c.* from categories c join documents d on c.Code=d.Code where c.SiteID='".SITE_ID."' and d.SiteID='".SITE_ID."' and d.Status=1 order by c.Order_By_Num";
		
		$db->query('SET NAMES utf8');
		$dbResultsData = $db->get_results( $query );
		?>
           <h2 style="margin-top:15px;" >Glossary</h2> 
           <div class="row">
           <div class="col-md-12">
        <?php
         if(count($dbResultsData)>0){
		?>
         <ul class="jobs-cat">
        <?php
		for( $j=0; $j <= count($dbResultsData)-1; $j++ ){
		?>
          <li><a href="javascript:void(0)" onclick="__urlHandler('<?php echo $dbResultsData[$j]->Code; ?>')" title="<?php echo $dbResultsData[$j]->Name; ?>"><?php echo $dbResultsData[$j]->Name; ?></a></li>
  <?php } ?>
         </ul>
	<?php } ?>

          </div>
      </div>      
           
            </div>
            
            </div>
       </div>
     <?php include_once("include/footer.php"); ?>

  </body>
</html>