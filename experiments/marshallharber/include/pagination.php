<?php
	// How many adjacent pages should be shown on each side?

	$adjacents = 3;
	
	if(empty($where) == true)$where = ' where 1=1';
	
	if(empty($query)==true)$query = "SELECT * as num FROM $table_name $where";

	$total_pages=count($db->get_results($query));
	
	
	
	/* Setup vars for query. */
	if(empty($limit)==true) $limit = 10;									//how many items to show per page

	if(isset($_REQUEST['pageNum']))
		$pageNum = $_REQUEST['pageNum'];
	else
		$pageNum = '';
//echo $_REQUEST['pageNum'];exit;
	if($pageNum) 
		$start = ($pageNum - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0

	$startLim = $start;
	$endLim = $limit;
	//Logic ends here


	/* Setup page vars for display. */
	if ($pageNum == 0) $pageNum = 1;					//if no page var is given, default to 1.
	$prev = $pageNum - 1;							//previous page is page - 1
	$next = $pageNum + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	
	$lpm1 = $lastpage - 1;						//last page minus 1
	$showing_upto= $limit+$startLim;
	if($showing_upto>$total_pages){ $showing_upto = $total_pages; }
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pager\">";
		//previous button
		if ($pageNum > 1) 
			$pagination.= "<span><a href=\"javascript:void(0);\" onclick=\"$.movePage('$prev', $(this).parents('.pager').parent())\">&lt;</a></span>";
		else
			$pagination.= "<span ><a href=\"javascript:void(0);\" >&lt;</a></span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				/*if ($counter == $pageNum)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"javascript:void(0);\" onclick=\"$.movePage('$counter')\">$counter</a>";*/					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($pageNum < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					/*if ($counter == $pageNum)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"javascript:void(0);\" onclick=\"$.movePage('$counter')\">$counter</a>";*/					
				}
				//$pagination.= "Page ".$pageNum." of ".$lastpage."";
				//$pagination.= "<a href=\"javascript:void(0);\" onclick=\"$.movePage('$lpm1')\">$lpm1</a>";
				//$pagination.= "<a href=\"javascript:void(0);\" onclick=\"$.movePage('$lastpage')\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $pageNum && $pageNum > ($adjacents * 2))
			{
				//$pagination.= "<a href=\"javascript:void(0);\" onclick=\"$.movePage('1')\">1</a>";
				//$pagination.= "<a href=\"javascript:void(0);\" onclick=\"$.movePage('2')\">2</a>";
				//$pagination.= "Page ".$pageNum." of ".$lastpage."";
				for ($counter = $pageNum - $adjacents; $counter <= $pageNum + $adjacents; $counter++)
				{
					/*if ($counter == $pageNum)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"javascript:void(0);\"  onclick=\"$.movePage('$counter')\">$counter</a>";*/					
				}
				//$pagination.= "Page ".$pageNum." of ".$lastpage."";
				//$pagination.= "<a href=\"javascript:void(0);\" onclick=\"$.movePage('$lpm1')\">$lpm1</a>";
				//$pagination.= "<a href=\"javascript:void(0);\" onclick=\"$.movePage('$lastpage')\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				//$pagination.= "<a href=\"javascript:void(0);\" onclick=\"$.movePage('1')\">1</a>";
				//$pagination.= "<a href=\"javascript:void(0);\" onclick=\"$.movePage('2')\">2</a>";
				//$pagination.= "Page ".$pageNum." of ".$lastpage."";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					/*if ($counter == $pageNum)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"javascript:void(0);\" onclick=\"$.movePage('$counter')\">$counter</a>";*/					
				}
			}
		}
		$pagination.= " Page ".$pageNum." of ".$lastpage." ";
		//next button
		if ($pageNum < $counter - 1) 
			$pagination.= "<span><a href=\"javascript:void(0);\" onclick=\"$.movePage('$next', $(this).parents('.pager').parent())\">&gt;</a></span>";
		else
			$pagination.= "<span ><a href=\"javascript:void(0);\" >&gt;</a></span>";
		$pagination.= "</div>";		
	}
if(!isset($hide_pagi))
echo $pagination;
?>