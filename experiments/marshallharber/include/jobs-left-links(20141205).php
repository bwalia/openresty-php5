<style type="text/css">

a.jb_search_menu_links:link  {
font-weight:bold;
font-size: 11pt;
text-decoration: underline;
}
a.jb_search_menu_links:visited {
font-weight:bold;
font-size: 11pt;
text-decoration: none;
}
a.jb_search_menu_links:hover {
font-weight:bold;
font-size: 11pt;
text-decoration: none;
}
a.jb_search_menu_links:active {
font-weight:bold;
font-size: 11pt;
text-decoration: none;
}

</style>

<div id="iconColumn">
					<a href="index.php"><img src="http://www.marshallharber.com/images/icons/butlers2.jpg" alt="butlers" border="0" /></a>
					<a href="http://twitter.com/marshallharber" title="Follow us on the twitter!"><img src="images/twitter.gif"></a>
					
					<!-- JOB SHOUT - navigation --><p><div id="navigation">
<?php
if($link_cat_groups=$db->get_results("select * from categorygroups where SiteID=".SITE_ID." and type='job' and ID in (select CategoryGroupID from categories where Active=1 and ID in (select CategoryID from documentcategories where DocumentID in (select ID from documents where SiteID=".SITE_ID." and type='job' and PublishCode=1))) and Active=1")){
	foreach($link_cat_groups as $link_cat_group) {
?>
<a class="jb_search_menu_links" href="job_search.php?cat_grp=<?php echo $link_cat_group->Code; ?>" onmouseover="window.status = 'Job search'" title="Job search">Jobs by <?php echo $link_cat_group->Name; ?></a><br/><br/>
<?php }
}
?>


<a class="jb_search_menu_links" href="register-now.php" onmouseover="window.status = 'Apply Now'" title="Apply Now">Register now</a><br/><br/>
<a class="jb_search_menu_links" href="sitemap.php" onmouseover="window.status = 'Job Index'" title="Job Index">Job Index</a>
</div></p><!-- JOB SHOUT - navigation -->
				</div>