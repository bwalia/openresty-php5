<?php
require_once("include/lib.inc.php");

if(!isset($succ_msg) && isset($_COOKIE['user_selection_documents_jobapplist']) && $_COOKIE['user_selection_documents_jobapplist']!=''){ 
	$jobs_in_cookies= explode("$",$_COOKIE['user_selection_documents_jobapplist']); 
	$jobs_in_cookies= implode(",", $jobs_in_cookies);
	$query="SELECT * FROM `documents` WHERE Id in (".$jobs_in_cookies.") AND ( SiteID=".SITE_ID." ) and Status=1 AND Type='job' ORDER BY Published_Timestamp DESC";
	$limit = 3;
	
	require_once("include/pagination.php");
  
    $query.= " LIMIT $startLim,$endLim ";
	
	
    
	$db->query('SET NAMES utf8');
	
	$doc_cats = $db->get_results( $query );
	
	if($doc_cats){
		 //doPages($limit, 'register-now.php', $QueryString, $total_records, $startLim, $limit);
		$count=0;
		foreach($doc_cats as $doc_cat) {
			$count++;
			
			if($_GET['mode']=='sidebar'){
?>			
	<div class="job-summary clearfix job-sum-board-pg">
                    <div class="apply-job-title"><a href="javascript:void(0)" onclick="savepage('<?php echo $doc_cat->Code; ?>')" title="<?php echo $doc_cat->Document; ?>" class="hightlight-link" ><?php echo $doc_cat->Document; ?></a><br/>
                      <a href="javascript:_updateMyJobsList('addRemove<?php echo $count; ?>', <?php echo $doc_cat->ID; ?>, 'user_selection_documents_jobapplist');" id="addRemove<?php echo $count; ?>" title="Remove this job"  class="remove-job" > <span class="glyphicon glyphicon-remove-circle"></span></a>
                   	       <?php if($doc_cat->FFAlpha80_1!='') { ?>Location: <?php echo $doc_cat->FFAlpha80_1; ?><br><?php } ?>
                   		
                   		<?php if($doc_cat->Reference!='') { ?>Reference: <?php echo $doc_cat->Reference; ?><br><?php } ?>
                   		 <?php if($doc_cat->FFAlpha80_2!='') { ?>Salary: <?php echo $doc_cat->FFAlpha80_2; ?><br><?php } ?>
                         </div>
              </div>
	
<?php			
			
			}
			else{
?>

<div class="job-summary apply-job-box clearfix job-sum-board-pg" >
                    <div class="mrgnBtm15"><a href="javascript:void(0);" onclick="nosavepage('<?php echo $doc_cat->Code; ?>')" title="<?php echo $doc_cat->Document; ?>" class="hightlight-link" ><?php echo $doc_cat->Document; ?></a> 
                   	 <a href="javascript:_updateMyJobsList('addRemove<?php echo $count; ?>', <?php echo $doc_cat->ID; ?>, 'user_selection_documents_jobapplist');" id="addRemove<?php echo $count; ?>" title="Remove this job"  class="remove-job" > <span class="glyphicon glyphicon-remove-circle"></span></a> </div>
                   		<?php if($doc_cat->FFAlpha80_4!='') { ?> Employer: <?php echo $doc_cat->FFAlpha80_4; ?><br><?php } ?>
                   		 <?php if($doc_cat->FFAlpha80_1!='') { ?>Location: <?php echo $doc_cat->FFAlpha80_1; ?><br><?php } ?>
                   		 <?php if($doc_cat->FFAlpha80_3!='') { ?>Type: <?php echo $doc_cat->FFAlpha80_3; ?><br><?php } ?>
                   		<?php if($doc_cat->Reference!='') { ?>Reference: <?php echo $doc_cat->Reference; ?><br><?php } ?>
                   		 <?php if($doc_cat->FFAlpha80_2!='') { ?>Salary: <?php echo $doc_cat->FFAlpha80_2; ?><br><?php } ?>
              </div>
			  
			  


<?php 
		}
		}
		
	}
	if(count($doc_cats)==0){
			echo '<h6>No job selected</h6>';
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
<?php }
else{
	if($_GET['mode']=='sidebar'){
	echo '<div class="job-sum-board-pg"><h6 style="padding: 0px; margin: 0px;">No jobs found in your list!</h6></div>';
	}
	else{
	echo '<div class="mrgnBtm15" >No jobs found in your list!</div>';
	}
}
 ?>