<a href="job_search.php" title="Job board"><h1>Job board</h1></a><script src="http://15232.hittail.com/mlt.js" type="text/javascript"></script>

	<!-- JOB SHOUT - navigation --><div id="navigation">
<?php
if($link_cat_groups=$db->get_results("select * from categorygroups where SiteID=".SITE_ID." and type='job' and ID in (select CategoryGroupID from categories where Active=1 and ID in (select CategoryID from documentcategories where DocumentID in (select ID from documents where SiteID=".SITE_ID." and type='job' and PublishCode=1))) and Active=1")){
	foreach($link_cat_groups as $link_cat_group) {
?>
<a class="jb_search_menu_links myButton" href="job_search.php?cat_grp=<?php echo $link_cat_group->Code; ?>" onmouseover="window.status = 'Job search'" title="Job search">Jobs by <?php echo $link_cat_group->Name; ?></a>&nbsp;&nbsp;
<?php }
}
?>
<a class="jb_search_menu_links myButton" href="register-now.php" onmouseover="window.status = 'Apply Now'" title="Apply Now">Register now</a>&nbsp;&nbsp;
<a class="jb_search_menu_links myButton" href="jobs-index.php" onmouseover="window.status = 'Job Index'" title="Job Index">Job Index</a>
</div><!-- JOB SHOUT - navigation -->
