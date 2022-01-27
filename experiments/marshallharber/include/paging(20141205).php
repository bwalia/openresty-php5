<?php 
/*--------------------------------------------------------------------------------------
@Desc       :   Simple and Cool Paging with PHP
@author     :   Sandeep dhaliwal
@Comments   :   If you like my work, please drop me a comment on the above post link. 
                Thanks!
---------------------------------------------------------------------------------------*/
    function check_integer($which) {
        if(isset($_REQUEST[$which])){
            if (intval($_REQUEST[$which])>0) {
                //check the paging variable was set or not, 
                //if yes then return its number:
                //for example: ?page=5, then it will return 5 (integer)
                return intval($_REQUEST[$which]);
            } else {
                return false;
            }
        }
        return false;
    }//end of check_integer()

    function get_current_page() {
        if(($var=check_integer('page'))) {
            //return value of 'page', in support to above method
            return $var;
        } else {
            //return 1, if it wasnt set before, page=1
            return 1;
        }
    }//end of method get_current_page()

    function doPages($page_size, $thepage, $query_string, $total=0, $startLim, $limit) {
       
        //per page count
        $index_limit = $page_size;

        //set the query string to blank, then later attach it with $query_string
        $query='';
        
        if(strlen($query_string)>0){
            $query = '?'.$query_string."&amp;";
        }
        
        //get the current page number example: 3, 4 etc: see above method description
        $current = get_current_page();
        
        $total_pages=ceil($total/$page_size);
        $start=max($current-intval($index_limit/2), 1);
        $end=$start+$index_limit-1;
		
		//To print the total count of pages on selected page index below:
		$records = $limit+$startLim;
        if($records > $total)
		   $records = $total;
        else
			$records = $limit+$startLim;
			
		echo "<b>".($startLim+1)."-".($records)."&nbsp;of $total</b>";
		
		//To create the Paging navigation:
		if($total > $page_size)
		{
			echo '<p class="jobboard_page_numbers">';
			
			if($current <> 1) {
				$i = $current-1;
				echo '<a href="'.$thepage.$query.'page='.$i.'" >previous</a>&nbsp;';
				//echo '<span class="prn">&middot;</span>&nbsp;';
			}
	
			if($start > 1) {
				$i = 1;
				echo '<a href="'.$thepage.$query.'page='.$i.'" >'.$i.'</a>';
			}
	
			for ($i = $start; $i <= $end && $i <= $total_pages; $i++){
				if($i==$current) {
					echo $i;
				} else {
					echo '<a href="'.$thepage.$query.'page='.$i.'" >'.$i.'</a>';
				}
				if($end <> $total_pages && $i <> $end && $i <> $total_pages)
				   echo '&middot;';
			}
	
			if($total_pages > $end){
				$i = $total_pages;
				echo '<a href="'.$thepage.$query.'page='.$i.'" >'.$i.'</a>';
			}
	
			if($current < $total_pages) {
				$i = $current+1;
				//echo '<span class="prn">&middot;</span>&nbsp;';
				echo '&nbsp;<a href="'.$thepage.$query.'page='.$i.'" >next</a>';
			} 	
		  echo '</p><br>';
		}
    }//end of method doPages()
?>