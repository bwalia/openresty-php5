 <?php	 
	$query = "SELECT Name, Code FROM categories WHERE Type='blog' and Active=1 AND SiteID=".SITE_ID." Order by Name asc";
	$db->query('SET NAMES utf8');
	$dbCats = $db->get_results( $query );
	if(count($dbCats)>0){
?>
<div class="widget-blk">
    <h2>Categories</h2>
	<ul class="recent-post">
		<?php	foreach($dbCats as $dbCat){	  ?>
        	<li><a href="blog.php?category=<?php echo $dbCat->Code;?>" title="<?php echo $dbCat->Name;?>"><?php echo $dbCat->Name;?></a></li>
        <?php }	?>
    </ul>
</div>
<?php } ?>