<?php 
require_once("include/lib.inc.php");
include_once ("include/main-site-header.php"); ?>
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
					<div id="jobboard_job_index" class="jobboard_job_index_content"><p class="category">Job Index</p>
                    <div class="sitemap">

<?php
if($sql_job_index=$db->get_results("select * from documents where SiteID=".SITE_ID." and Type='job' and Status=1 ORDER BY Published_Timestamp DESC")){
	foreach($sql_job_index as $job_link){
?>
<a class="jobindex_jobs" href="<?php echo $job_link->Code; ?>.html" id="link1" title="<?php echo $job_link->Document; ?>">&raquo;&nbsp;&nbsp;<?php echo $job_link->Document; ?></a>
<?php 
	}
}
?>

</div>
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