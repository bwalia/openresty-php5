<?php
header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
//include('my_404.php'); // provide your own HTML for the error page

require_once("include/lib.inc.php"); ?>
<?php include_once("include/main-header.php"); ?>

<link rel="canonical" href="<?php echo SITE_PATH;?>/content_not_found.php" />
</head>
<body>
<?php include_once("include/top-header.php"); ?>
<div class="container">
  <div class="row" >
 
    <div class="col-sm-12 col-md-12">
     <div class="errorpage" > 
     
     <div class="col-md-5"><img src="images/404.png" class="img-responsive"  style="padding:10px; margin-top:10px;"alt=""/></div>
     <div class="col-md-7"><p >Marshall Harber is the U. K.'s most dynamic domestic staff   placement agency and our head office is based in Kensington, London. Our consultants are experienced in dealing with any request and can provide information that will assist you in finding either the most suitable person for the position you are offering, or for the position you are seeking..</p>
     
     <h3>Visit some of our working pages</h3>
 
 <?php
				 $query_cat= $db->get_results("select distinct(c.ID), c.Name, c.Code from categories c left join documentcategories dc on c.ID=dc.CategoryID left join documents d on dc.DocumentID=d.ID where c.SiteID='".SITE_ID."' and dc.SiteID='".SITE_ID."' and d.SiteID='".SITE_ID."' and d.type='job' and d.Status=1 order by c.Name asc");
				 if(count($query_cat)>0){
				 ?>
     
   <div class="col-md-6">  <ul>
   <?php
   for($i=0; $i<count($query_cat)/2; $i++){
   	$query_docs= $db->get_var("select count(distinct(d.ID)) as num_jobs from documents d join documentcategories dc on d.ID=dc.DocumentID where dc.CategoryID='".$query_cat[$i]->ID."' and dc.SiteID='".SITE_ID."' and d.SiteID='".SITE_ID."' and d.type='job' and d.Status=1");
   ?>
     <li><a href="job-board.php?category=<?php echo $query_cat[$i]->Code; ?>"> &#8250; &nbsp;<?php echo $query_cat[$i]->Name; ?> (<?php echo $query_docs; ?>)</a></li>

<?php } ?>
</ul>
</div>

    <div class="col-md-6">  <ul>
   <?php
   for($i=count($query_cat)/2; $i<count($query_cat); $i++){
   	$query_docs= $db->get_var("select count(distinct(d.ID)) as num_jobs from documents d join documentcategories dc on d.ID=dc.DocumentID where dc.CategoryID='".$query_cat[$i]->ID."' and dc.SiteID='".SITE_ID."' and d.SiteID='".SITE_ID."' and d.type='job' and d.Status=1");
   ?>
     <li><a href="job-board.php?category=<?php echo $query_cat[$i]->Code; ?>"> &#8250; &nbsp;<?php echo $query_cat[$i]->Name; ?> (<?php echo $query_docs; ?>)</a></li>

<?php } ?>
</ul>
</div>

<?php } ?>
     
     
     </div>
     
      </div>
   </div>
</div>
</div>
<?php include_once("include/footer.php"); ?>
</body>
</html>
<?php die(); ?>