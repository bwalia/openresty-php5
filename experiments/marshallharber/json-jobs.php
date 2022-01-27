<?php

require_once("include/lib.inc.php");
$data='';
$cat='';
if(isset($_GET['cat']) && $_GET['cat']!=''){
	$cat= $_GET['cat'];
}
		if(isset($_GET['srch'])){
			$srch= addslashes($_GET['srch']);
			$loc=addslashes($_GET['loc']);
			
			$query = "SELECT * FROM documents WHERE Type='job' and Status=1 AND SiteID=".SITE_ID." AND (Code LIKE '%$srch%' || Document LIKE '%$srch%' || Body LIKE '%$srch%' || BodyContent LIKE '%$srch%') AND (FFAlpha80_1 LIKE '%$loc%' or Body like '%$loc%' OR post_code like '%$loc%') Order by ID desc";		
		}

		elseif($_GET['cat']==''){
			$query = "SELECT * FROM documents WHERE Type='job' and Status=1 AND SiteID=".SITE_ID." Order by ID desc";
		}
		else{
			$query = "SELECT d.* FROM documents d join documentcategories dc on d.ID=dc.DocumentID join categories c on dc.CategoryID=c.ID where c.Code='".$_GET['cat']."' and c.SiteID='".SITE_ID."' and dc.SiteID='".SITE_ID."' and d.SiteID='".SITE_ID."' and d.type='job' and d.Status=1 Order by d.ID desc";
		}
		

		$limit=6;
		require_once("include/pagination.php");

		$query .= " Limit $startLim,$endLim ";
		$db->query('SET NAMES utf8');
		$dbResultsData = $db->get_results( $query );

        for( $j=0; $j <= count($dbResultsData)-1; $j++ ):
	    
		$data.="<a class=\"job-listing-bx\" href=\"javascript:void(0)\" onclick=\"savepage('".$dbResultsData[$j]->Code."')\" >";
       
        $data.="<h3>".$dbResultsData[$j]->Document."</h3>";
        $data.="<div class=\"job-atribute\">".$dbResultsData[$j]->FFAlpha80_4.", ".$dbResultsData[$j]->FFAlpha80_2;
		if($dbResultsData[$j]->Reference!='') { $data.="<br/>Reference: ".$dbResultsData[$j]->Reference; } 
		 $data.="</div>";
        /*if(strlen($dbResultsData[$j]->MetaTagDescription)>100){
        	$data.="<p>".substr($dbResultsData[$j]->MetaTagDescription,0,100)."&hellip;</p>";
		} else{
			$data.="<p>".$dbResultsData[$j]->MetaTagDescription."</p>";
		}*/
		$data.="<p>".limit_words($dbResultsData[$j]->MetaTagDescription, 15)." <span style='text-align:right;;color:#fff; font-size:small; border-bottom: 1px dashed #ecf2fc; white-space: nowrap;' class=''>See full job description</span></p>";
		//$data.="<p style='text-align:right;font-size:small;' class='less-margn'>See full job description</p>";
		$data.="</a>";
   		endfor;
		if(count($dbResultsData)==0)
			$data.="<div ><h1 style='border:none;'>No result found!</h1></div>";


	
echo $data;

echo $pagination;
?>