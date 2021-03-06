<?php

require_once("include/lib.inc.php");


$data='';
$selected_category='';
if(isset($_GET['cat']) && $_GET['cat']!=''){
	$selected_category= $_GET['cat'];
}
if(isset($_GET['month']) && isset($_GET['year']) && $_GET['month']!='' && $_GET['year']!=''){
	$month = $_GET['month'];
	$year = $_GET['year'];
}else{
	$month = '';
	$year = '';
}

		if($selected_category==''){
			$query = "SELECT * FROM documents WHERE Type='blog' and Status=1 AND SiteID='".SITE_ID."'";
		}
		else{
			$query = "SELECT d.* FROM documents d join documentcategories dc on d.ID=dc.DocumentID join categories c on dc.CategoryID=c.ID where c.Code='".$selected_category."' and c.SiteID='".SITE_ID."' and dc.SiteID='".SITE_ID."' and d.SiteID='".SITE_ID."' and d.type='blog' and d.Status=1 ";
		}
		
		if(isset($month) && isset($year) && $month!='' && $year!=''){
            $StartDate = mktime(0,0,0,$month,1,$year);
            $EndDate = mktime(0,0,0,$month,31,$year);
            
            $query.=" AND (Published_timestamp >= $StartDate AND Published_timestamp <= $EndDate)";
        }
        
//    	$query.=" GROUP BY Published_timestamp Order by Published_timestamp Desc";
$query.=" Order by Published_timestamp Desc";
		$limit=6;
		$hide_pagi= true;
		require_once("include/pagination.php");
		$query .= " Limit $startLim,$endLim ";
		$db->query('SET NAMES utf8');
		$dbResultsData = $db->get_results( $query );
//$db->debug();

        for( $j=0; $j <= count($dbResultsData)-1; $j++ ):
        $postedByStr='';
        $publishedDate ='';
        $categoriesStr ='';
        if($dbResultsData[$j]->PostedTimestamp!=""){
        	$Published_timestamp=$dbResultsData[$j]->PostedTimestamp;
        	$publishedDate = date('M d, Y',$Published_timestamp);
        }
	    if($dbResultsData[$j]->UserID!=""){
	    	if($chk_usr= $db->get_row("select firstname,lastname from wi_users where ID='".$dbResultsData[$j]->UserID."'")){
	    		$postedByStr= $chk_usr->firstname.' '.$chk_usr->lastname;
			}
	    }
	   
	  	$catquery = "SELECT c.Name, c.Code FROM documentcategories dc join categories c on dc.CategoryID=c.ID where dc.DocumentID='".$dbResultsData[$j]->ID."' and c.SiteID='".SITE_ID."' and dc.SiteID='".SITE_ID."' and c.Type='blog' Order by dc.ID desc";
		$db->query('SET NAMES utf8');
		$docCategories = $db->get_results( $catquery );
		if($docCategories>0){
			foreach($docCategories as $cat){
				if($categoriesStr==""){
					$categoriesStr .='<a href="blog.php?category='.$cat->Code.'" rel="category tag">'.$cat->Name.'</a>';
				}else{
					$categoriesStr .=', <a href="blog.php?category='.$cat->Code.'" rel="category tag">'.$cat->Name.'</a>';
				}
			}
		}
		
	    $totalComment = $db->get_var("Select count(*) as num from blog_comments where blog_uuid='".$dbResultsData[$j]->GUID."' AND blog_id='".$dbResultsData[$j]->ID."'  AND Status=1");
	    if( $totalComment>0){
	    	if($totalComment==0 || $totalComment==1){
	    		$totalCommentStr= $totalComment." Comment";
	    	}else{
	    		$totalCommentStr= $totalComment." Comments";
	    	}
	   	}else{
	    	$totalCommentStr= "0 Comment";
	    }
	    
	   	if($blogpic = $db->get_row("Select Picture from pictures where SiteID='".SITE_ID."' AND DocumentID='".$dbResultsData[$j]->ID."' AND Status=1 AND Code='thumb-image' ")){
	   		if($blogpic->Picture != ''){
	    		if(isset($blogpic->Type) && $blogpic->Type!=""){
					$mime = $blogpic->Type;
					$blogImg = "data:".$mime.";base64," . base64_encode($blogpic->Picture);	
				}else{
					$blogImg = "data:;base64," . base64_encode($blogpic->Picture);	
				}
			}else{
				$blogImg = "images/blog.jpg";
			}
	   	}else{
	   		$blogImg = "images/blog.jpg";
	   	}    
	    
		$data.="<div class='post'><h1><a href='javascript:void(0)' onclick='__urlHandler(\"".$dbResultsData[$j]->Code."\", \"blog\")'>".$dbResultsData[$j]->Document."</a></h1>";
       	$data.='<div class="mrgn-btm15"><small>';
       	if($publishedDate!=""){
      		$data.='<b>Posted:</b> '.$publishedDate.'| ';
      	}
       	if($postedByStr!=""){
       		$data.='<b>Author:</b> '.$postedByStr.'| ';
       	}
       	if($categoriesStr!=""){
       		$data.='<b>Filed under:</b> '.$categoriesStr.'| ';
       	}
       	$data.='<a href="javascript:void(0)" onclick="__urlHandler(\''.$dbResultsData[$j]->Code.'\',\'blog\', true)" >'.$totalCommentStr.'</a></small></div>';
        $data.='<div class="clearfix">';   
		$data.='<div class="pthumbleft pthumb">';
       	$data.='<img src="'.$blogImg.'" class="img-responsive">';
        $data.='</div>';
        $bodyStr=$dbResultsData[$j]->Body;
   		if(strlen($bodyStr)>160){
			$bodyStr=substr($bodyStr,0,160).'&hellip;';
		}
		$data.=$bodyStr.'<br/>';
 		$data.='<a href="javascript:void(0)" onclick="__urlHandler(\''.$dbResultsData[$j]->Code.'\',\'blog\')" class="more-link">Read the rest of this post ??</a>';
  		$data.='</div>';
		$data.='</div>';
   		endfor;
		if(count($dbResultsData)==0)
			$data.="<div ><h1 style='border:none;'>No result found!</h1></div>";
			
		//echo $pagination;


	
echo $data;

echo $pagination;
?>