 <?php	 
	$query = "SELECT * FROM documents WHERE Type='job' and Status=1 AND SiteID=".SITE_ID." Order by ID desc Limit 10 ";
	$db->query('SET NAMES utf8');
	$dbjobs = $db->get_results( $query );
	if(count($dbjobs)>0){
?>
	<div class="panel panel-default news-ticker-panel">
        <div class="panel-heading">Latest Vacancies</div>
        <div class="panel-body">
          <ul class="demo1 latestVacaniesClass">
          <?php	foreach($dbjobs as $dbjob){	  ?>
            <li class="news-item">
            	<a href="javascript:void(0)" onclick="savepage('<?php echo $dbjob->Code;?>')" title="<?php echo $dbjob->Document;?>">
             		<h3><?php echo $dbjob->Document;?></h3>
             		<?php if($dbjob->FFAlpha80_1!='') { ?><?php echo $dbjob->FFAlpha80_1; ?><br /><?php } ?>
			 		<?php if($dbjob->FFAlpha80_3!='') { ?><?php echo $dbjob->FFAlpha80_3; ?><?php } ?>
					<?php if($dbjob->FFAlpha80_3!='' && $dbjob->Reference!='') { ?>, <?php } ?>
					<?php if($dbjob->Reference!='') { ?>Reference: <?php echo $dbjob->Reference; ?><?php } ?>
					<?php if($dbjob->FFAlpha80_3!='' || $dbjob->Reference!='') { ?><br/><?php } ?>
					<?php if($dbjob->FFAlpha80_2!='') { ?><?php echo $dbjob->FFAlpha80_2; ?><br /><?php } ?>
				</a> 
            </li>
            <?php }	?>
           
          </ul>
        </div>
      </div>
<?php } ?>