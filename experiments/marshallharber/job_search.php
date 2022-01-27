<?php 
require_once("include/lib.inc.php"); 
include_once ("include/main-site-header.php"); 
?>
</head>

	<body>
		<!--start header-->
		<?php include_once ("include/header.php"); ?>
        <!--end header-->
		<div id="moreBorder"></div>
		<div id="content">
				<?php include_once('include/left-links.php'); ?>
				<div id="textColumn">
					<?php include_once('include/jobs-common-links.php'); ?>

<ul class="ullink">
<?php
if(isset($_GET['cat_grp']) && $_GET['cat_grp']!=""){
$cat_grp_code=$_GET['cat_grp'];
}else{
$cat_grp_code="marketsectors";
}
if($cat_group=$db->get_row("select * from categorygroups where SiteID=".SITE_ID." and type='job' and code ='".$cat_grp_code."' and Active=1")){
	if($categories=$db->get_results("select ID, Name, Code from categories where CategoryGroupID=".$cat_group->ID." and type='job' and Active=1 and SiteID=".SITE_ID." order by Name asc")) { 
		foreach($categories as $category) {
			if($doc_cats=$db->get_var(" select count(*) from documentcategories where CategoryID=".$category->ID." and SiteID=".SITE_ID." and DocumentID in (select ID from documents where SiteID=".SITE_ID." and type='job' and Status=1)")){
?>
<li><a href="jobresults.php?category=<?php echo $category->Code; ?>" title="Jobs in category: <?php echo $category->Name; ?>">&raquo;&nbsp; <?php echo $category->Name; ?> (<?php echo $doc_cats; ?>)</a></li>
<?php 
			}
		}
	}
}
?>
<li><a href="jobs-index.php" title="Jobs in all categories">&raquo;&nbsp; View all jobs</a></li>
</ul>


</div>  
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</div>
		<!--start footer-->
<?php include_once ("include/content-footer.php"); ?>
<!--end footer-->
<?php include_once ("include/page-tracker.php"); ?>
	</body>
</html>