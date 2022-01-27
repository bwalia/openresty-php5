<?php 
require_once("include/lib.inc.php");
include_once ("include/main-site-header.php"); 
require_once("include/paging.php"); 

if(isset($_GET['category']) && $_GET['category']!=''){
	$cat_code=addslashes($_GET['category']);
	if($cat_id=$db->get_var("select ID from categories where Code='".$cat_code."' and SiteID=".SITE_ID." and type='job' and Active=1")){
		$query="select d.* from documentcategories dc join documents d on dc.DocumentID=d.ID where dc.CategoryID=".$cat_id." and dc.SiteID=".SITE_ID." and d.SiteID=".SITE_ID." and d.type='job' and d.Status=1 ORDER BY d.Published_Timestamp DESC";
		$QueryString='category='.$cat_code;
		$total_records=count($db->get_results($query));	 
	}else{
		$total_records=0;
	}
}elseif(isset($_GET['location']) && $_GET['location']!=''){
	$location=addslashes($_GET['location']);
	$query="select * from documents where SiteID=".SITE_ID." and type='job' and Status=1 and (FFAlpha80_1 LIKE '%$location%' or Body like '%$location%') ORDER BY Published_Timestamp DESC";
	$QueryString='location='.$location;
	$total_records=count($db->get_results($query));	 
}elseif(isset($_GET['type']) && $_GET['type']!=''){
	$type=addslashes($_GET['type']);
	$query="select * from documents where SiteID=".SITE_ID." and type='job' and Status=1 and FFAlpha80_3 LIKE '".$type."' ORDER BY Published_Timestamp DESC";
	$QueryString='type='.$type;
	$total_records=count($db->get_results($query));	 
}else{
	$query="select * from documents where SiteID=".SITE_ID." and type='job' and Status=1 ORDER BY Published_Timestamp DESC";
	$QueryString='';
	$total_records=count($db->get_results($query));	 
}
?>
<!--<script src="js/cookies.js" type="text/javascript"></script>-->

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

<div id="jobboard_jobs_list">

<?php
	$limit = 10;
	 
	if($total_records>0){
		if(isset($_REQUEST['page']))
			$pageNum = $_REQUEST['page'];	
		else
		$pageNum = '';
		if($pageNum){$start = ($pageNum - 1) * $limit;} 	//first item to display on this page
		else{$start = 0;}		//if no page var is given, set start to 0
	  
		$startLim = $start;
		$endLim = $limit;
	  
		$query.= " LIMIT $startLim,$endLim ";
				
		if($doc_cats = $db->get_results( $query )){
			 doPages($limit, 'jobresults.php', $QueryString, $total_records, $startLim, $limit);
			$count=0;
			foreach($doc_cats as $doc_cat) {
				$count++;
	?><a href="<?php echo $doc_cat->Code; ?>.html" title="<?php echo $doc_cat->Document; ?>">
	<div  class="boxdesign"  <?php if($count==1){ ?>style="margin-top:54px;"<?php } ?>>
	<h1><span class="jobboard_heading_link"><?php echo $doc_cat->Document; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;</h1>
	<?php if($doc_cat->FFAlpha80_4!='') { ?><b>Employer: <?php echo $doc_cat->FFAlpha80_4; ?></b><br /><?php } ?>
	<?php if($doc_cat->FFAlpha80_2!='') { ?><b>Salary: <?php echo $doc_cat->FFAlpha80_2; ?></b><br /><?php } ?>
	<?php if($doc_cat->Reference!='') { ?><b>Ref: <?php echo $doc_cat->Reference; ?></b><br /><?php } ?>

	<p class="more"><?php if(strlen(strip_tags($doc_cat->Body))>200) { echo substr(strip_tags($doc_cat->Body),0,200).'&hellip;'; } else { echo substr(strip_tags($doc_cat->Body),0,200); } ?></p>
	</div>
	</a>
	<?php 
			} 
			doPages($limit, 'jobresults.php', $QueryString, $total_records, $startLim, $limit);
		}
	}else{
		echo "<br><h1>No jobs found!</h1>";
	}

?>
<script type="text/javascript">
window.onload = function ()
{
<?php
$count=0;
foreach($doc_cats as $doc_cat) {
$count++;
?>
_updateMyJobsList('addRemove<?php echo $count; ?>', <?php echo $doc_cat->ID; ?>, 'user_selection_documents_jobapplist',false,true);
<?php
}
?>
}
</script>



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