
<?php
	$query = "SELECT * FROM documents WHERE Type='blog' and Status=1 AND SiteID='".SITE_ID."' Order by Published_timestamp desc";
	$BlogResults= $db->get_results($query);
	$selectedYear='';
	if(isset($_GET['Year']) && $_GET['Year']!=''){
		$selectedYear= $_GET['Year'];
	}
	if($BlogResults>0){ ?>
	
	<div class="widget-blk">
		<h2>Archives</h2>
		<ul class="archive">
		
<?php	$data='';
		$i=0;
		$prev_year='';
		$prev_month='';
		$i=0;
		$data='';
		foreach($BlogResults as $BlogResult){
			
 			$curr_year= date('Y',$BlogResult->Published_timestamp);
 			if($prev_year <> $curr_year){
				if($i!=0){
  					$data.='('.$i.')</a>';
 				}
				if($data <> ''){
					$data.='</li></ul></li>';
				}
				$data.='<li><a href="javascript:void(0)" onClick=\'$("#year-'.$curr_year.'").slideToggle()\'>'.$curr_year.'</a>';
  				if($selectedYear==$curr_year){
  					$data.='<ul id="year-'.$curr_year.'">';
  				}else{
  					$data.='<ul id="year-'.$curr_year.'" style="display:none;">';
  				}
  				$prev_year= $curr_year;
  				$prev_month='';
  				$i=0;
 			}
 			$curr_month= date('m',$BlogResult->Published_timestamp);
 			if($prev_month <> $curr_month){
 				if($i!=0){
  					$data.='('.$i.')</a></li>';
 				}
 				$data.='<li><a href="blog.php?Month='.$curr_month.'&amp;Year='.$curr_year.'">'. date('M',$BlogResult->Published_timestamp);
 				$prev_month= $curr_month;
  				$i=1;
  			}else{
  				$i++;
 			}
		}
		$data.='('.$i.')</a></li></ul></li>';
		echo $data;
?>
	</ul>
</div>
<?php } ?>

	