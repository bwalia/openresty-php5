 <?php	 
	$query = "SELECT Code, Document FROM documents WHERE Type='blog' and Status=1 AND SiteID=".SITE_ID." Order by ID desc Limit 6 ";
	$db->query('SET NAMES utf8');
	$dbjobs = $db->get_results( $query );
	if(count($dbjobs)>0){
?>
<div class="widget-blk">
	<h2>Recent Posts</h2>
	<ul class="recent-post">
		<?php	foreach($dbjobs as $dbjob){	  ?>
        	<li><a href="javascript:void(0)" onclick="__urlHandler('<?php echo $dbjob->Code;?>','blog')"><?php echo $dbjob->Document;?></a></li>
        <?php }	?>
    </ul>
</div>
<?php } ?>